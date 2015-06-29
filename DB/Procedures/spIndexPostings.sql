DELIMITER @@
drop procedure if exists spIndexPostings;
create procedure spIndexPostings()
begin
  --
  declare l_posting_id int;
  --
  declare no_more_rows boolean;
  declare loop_cntr int default 0;
  declare num_rows int default 0;
  --
  declare l_posting_cursor cursor for
  select  posting_id
  from    posting
  where   is_indexed = '0' 
  limit 2500;
  --
  declare continue HANDLER for NOT FOUND set no_more_rows = TRUE;
  --
  open l_posting_cursor;
  select FOUND_ROWS() into num_rows;
  --
  the_loop1: loop
    fetch  l_posting_cursor
    into   l_posting_id;
    --
    if no_more_rows then
      close l_posting_cursor;
      leave the_loop1;
    end if;
    --
    call spGenerateSearchData(l_posting_id);
    update posting set is_indexed = 1 where posting_id = l_posting_id; 
    --
  end loop the_loop1;
  --
END @@
DELIMITER ;