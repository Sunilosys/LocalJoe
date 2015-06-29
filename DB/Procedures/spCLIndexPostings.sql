DROP PROCEDURE IF EXISTS lj_sf.spCLIndexPostings;
CREATE PROCEDURE lj_sf.`spCLIndexPostings`()
begin
  --
  declare l_import_id int;
  declare l_external_key varchar(255);
  declare l_user_id int;
  --
  declare no_more_rows boolean;
  declare loop_cntr int default 0;
  declare num_rows int default 0;
  --
  declare l_cl_posting_cursor cursor for
  select  import_id, external_key
  from    import_data
  where   status = 'Not Processed'
  limit   1000;   
  --
  declare continue HANDLER for NOT FOUND set no_more_rows = TRUE;
  --
  select  setting_value
  into    l_user_id
  from    parition_setting
  where   setting_name = 'CLUserId';
  --
  open l_cl_posting_cursor;
  select FOUND_ROWS() into num_rows;
  --
  the_loop1: loop
    fetch  l_cl_posting_cursor
    into   l_import_id, l_external_key;
    --
    if no_more_rows then
      close l_cl_posting_cursor;
      leave the_loop1;
    end if;
    --
    call spCLIndexPosting(l_import_id, l_external_key, l_user_id);
    --
    update  import_data
    set     status = 'Processed'
    where   import_id = l_import_id;
    --
  end loop the_loop1;
  --
  -- Adding dummy statement to get rid of warning 1329
  select count(*) into num_rows from import_data;
  --
END;