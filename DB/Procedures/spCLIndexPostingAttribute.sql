DROP PROCEDURE IF EXISTS spCLIndexPostingAttribute;
CREATE PROCEDURE spCLIndexPostingAttribute (in i_import_id int, in i_posting_id int,
  in i_category_id int, in i_parent_category_name varchar(255))
begin
  --
  declare l_parent_attribute varchar(255);
  declare l_cl_attribute1 varchar(255);
  declare l_cl_attribute2 varchar(255);
  declare l_cl_attribute1_value varchar(255);
  declare l_cl_attribute2_value varchar(255);
  declare l_category_attribute_id int;
  declare l_parent_category_attribute_id int;
  declare l_count int;
  --
  declare no_more_rows boolean;
  declare loop_cntr int default 0;
  declare num_rows int default 0;
  --
  declare l_attribute_cursor cursor for
	select  parent_attribute, cl_attribute1, cl_attribute2
  from    cl_attribute_mapping
  where   parent_category = i_parent_category_name;
  --
  declare continue HANDLER for NOT FOUND set no_more_rows = TRUE;
  --
  delete from posting_attribute where posting_id = i_posting_id;
  --
  open l_attribute_cursor;
  select FOUND_ROWS() into num_rows;
  --
	the_loop: loop
    fetch  l_attribute_cursor
    into   l_parent_attribute, l_cl_attribute1, l_cl_attribute2;
    --
    if no_more_rows then
        close l_attribute_cursor;
        leave the_loop;
    end if;
    --
    set l_category_attribute_id = null;
    set l_cl_attribute1_value = null;
    set l_cl_attribute2_value = null;
    --
    select  ca.category_attribute_id, ca.parent_category_attribute_id
    into    l_category_attribute_id, l_parent_category_attribute_id
    from    category_attribute ca,
            parent_category_attribute pca
    where   ca.parent_category_attribute_id = pca.parent_category_attribute_id
    and     pca.name = l_parent_attribute
    and     ca.category_id = i_category_id;
    --
    select  count(*)
    into    l_count
    from    import_data_attribute
    where   import_id = i_import_id
    and     attribute_name = l_cl_attribute1;
    --
    if l_count > 0 then
      select  attribute_value
      into    l_cl_attribute1_value
      from    import_data_attribute
      where   import_id = i_import_id
      and     attribute_name = l_cl_attribute1;
      --
      if l_cl_attribute1_value is null or l_cl_attribute1_value = '0' then
        set l_cl_attribute1_value = null;
      end if;
    end if;
    --
    if l_cl_attribute2 is not null then
      select  count(*)
      into    l_count
      from    import_data_attribute
      where   import_id = i_import_id
      and     attribute_name = l_cl_attribute2;
      --
      if l_count > 0 then
        select  attribute_value
        into    l_cl_attribute2_value
        from    import_data_attribute
        where   import_id = i_import_id
        and     attribute_name = l_cl_attribute2;
        --
        if l_cl_attribute2_value is null or l_cl_attribute2_value = '0' then
          set l_cl_attribute2_value = null;
        end if;
      end if;
    end if;
    --
    if l_category_attribute_id is not null then
      if l_cl_attribute1_value is not null or l_cl_attribute2_value is not null then
        if i_parent_category_name = 'Rentals' and l_parent_attribute in ('Rent') then
          insert into posting_attribute (posting_id, category_attribute_id, value, dimension, is_other, date_created)
          values (i_posting_id, l_category_attribute_id, l_cl_attribute1_value, 'Per Month', '0', now());
        elseif i_parent_category_name = 'Rentals' and l_parent_attribute != 'Features' then
          if l_cl_attribute1_value is not null then
            insert into posting_attribute (posting_id, category_attribute_id, value, is_other, date_created)
            values (i_posting_id, l_category_attribute_id, l_cl_attribute1_value, '0', now());
          else
            insert into posting_attribute (posting_id, category_attribute_id, value, is_other, date_created)
            values (i_posting_id, l_category_attribute_id, l_cl_attribute2_value, '0', now());
          end if;
        elseif i_parent_category_name = 'Rentals' and l_parent_attribute = 'Features' then
          if l_cl_attribute1_value = 'on' or l_cl_attribute2_value = 'on' then
            insert into posting_attribute (posting_id, category_attribute_id, value, is_other, date_created)
            values (i_posting_id, l_category_attribute_id, 'Pets', '0', now());
          end if;
        elseif i_parent_category_name = 'Autos' and l_parent_attribute in ('Price') then
          insert into posting_attribute (posting_id, category_attribute_id, value, is_other, date_created)
          values (i_posting_id, l_category_attribute_id, l_cl_attribute1_value, '0', now());
        elseif i_parent_category_name = 'Autos' and l_parent_attribute in ('Make', 'Model') then
          --
          -- select  initcap (l_cl_attribute1_value) into l_cl_attribute1_value;
          --
          select  count(*)
          into    l_count
          from    category_attribute_valid_value
          where   parent_category_attribute_id = l_parent_category_attribute_id
          and     value = l_cl_attribute1_value;
          --
          if l_count = 0 then
            insert into category_attribute_valid_value (parent_category_attribute_id, value, display_sequence,
              is_active, is_other, date_created)
            values (l_parent_category_attribute_id, l_cl_attribute1_value, 100, '1', '0', now());
          end if;
          --
          insert into posting_attribute (posting_id, category_attribute_id, value, is_other, date_created)
          values (i_posting_id, l_category_attribute_id, l_cl_attribute1_value, '0', now());
        else -- All other parent categories have the price attribute only
          insert into posting_attribute (posting_id, category_attribute_id, value, is_other, date_created)
          values (i_posting_id, l_category_attribute_id, l_cl_attribute1_value, '0', now());
        end if;
      end if;
    end if;
  end loop the_loop;
  --
END;
