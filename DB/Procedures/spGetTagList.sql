DELIMITER @@
DROP PROCEDURE IF EXISTS spGetTagList;
CREATE PROCEDURE spGetTagList(in i_posting_id int, out l_tag_list varchar(1024))
begin
  --
  declare l_value varchar(1024);
  declare l_count int;
  --
  declare no_more_rows boolean;
  declare loop_cntr int default 0;
  declare num_rows int default 0;
  --
  declare l_tag_cursor cursor for
	select  t.tag_name
  from    posting_tag pt,
          tag t
  where   pt.posting_id = i_posting_id
  and     pt.tag_id = t.tag_id;
  --
  declare continue HANDLER for NOT FOUND set no_more_rows = TRUE;
  --
  set  l_tag_list = '';
  set  l_count = 0;
  --
	open l_tag_cursor;
  select FOUND_ROWS() into num_rows;
  --
	the_loop: loop
    fetch  l_tag_cursor
    into   l_value;
    --
    if no_more_rows then
        close l_tag_cursor;
        leave the_loop;
    end if;
    --
    set l_count = l_count + 1;
    --
    if l_count = 1 then
      select concat (l_tag_list, l_value) into l_tag_list;
    else
      select concat (l_tag_list, ',', l_value) into l_tag_list;
    end if;
    --
  end loop the_loop;
  --
END @@
DELIMITER ;

