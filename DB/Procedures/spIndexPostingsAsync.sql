DELIMITER @@
drop procedure if exists spIndexPostingsAsync;
create procedure spIndexPostingsAsync()
begin
  --
  declare l_start_date datetime;
  declare l_end_date datetime;
  --
  select  date_end
  into    l_start_date
  from    index_run;
  --
  if l_start_date is null then
    select '2010-01-01' into l_start_date;
  end if;
  select now() into l_end_date;
  --
  delete from index_run;
  insert into index_run values (l_start_date, l_end_date);
  --
  call spIndexPostings(l_start_date, l_end_date);
END @@
DELIMITER ;