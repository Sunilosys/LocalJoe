DELIMITER @@
DROP PROCEDURE IF EXISTS spGetCheckboxList;
CREATE PROCEDURE spGetCheckboxList(in i_posting_id int, in i_category_attribute_id int, out l_checkbox_list varchar(1024))
begin
  --
  declare l_value varchar(1024);
  declare l_count int;
  --
  declare no_more_rows boolean;
  declare loop_cntr int default 0;
  declare num_rows int default 0;
  --
  declare l_cb_cursor cursor for
	select  value
  from    posting_attribute
  where   posting_id = i_posting_id
  and     category_attribute_id = i_category_attribute_id;
  --
  declare continue HANDLER for NOT FOUND set no_more_rows = TRUE;
  --
  set  l_checkbox_list = '';
  set  l_count = 0;
  --
	open l_cb_cursor;
  select FOUND_ROWS() into num_rows;
  --
	the_loop: loop
    fetch  l_cb_cursor
    into   l_value;
    --
    if no_more_rows then
        close l_cb_cursor;
        leave the_loop;
    end if;
    --
    set l_count = l_count + 1;
    --
    if l_count = 1 then
      select concat (l_checkbox_list, l_value) into l_checkbox_list;
    else
      select concat (l_checkbox_list, ',', l_value) into l_checkbox_list;
    end if;
    --
  end loop the_loop;
  --
END @@
DELIMITER ;

