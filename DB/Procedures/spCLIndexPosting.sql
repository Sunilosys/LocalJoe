DROP PROCEDURE IF EXISTS lj_sf.spCLIndexPosting;
CREATE PROCEDURE lj_sf.`spCLIndexPosting`(in i_import_id int, in i_external_key varchar(255), in i_user_id int)
thisSP:begin
  --
  declare l_category_id int;
  declare l_parent_category_id int;
  declare l_parent_category_name varchar(255);
  declare l_title varchar(255);
  declare l_description text;
  declare l_posting_date datetime;
  declare l_expiration_date datetime;
  declare l_external_email varchar(255);
  declare l_external_url varchar(512);
  declare l_count int;
  declare l_posting_id int;
  declare l_source_id int;
  declare l_image_url varchar(255);
  declare l_image_name varchar(255);
  declare l_image_id int;
  declare l_address varchar(255);
  declare l_city varchar(255);
  declare l_lat varchar(255);
  declare l_lon varchar(255);
  declare l_phone varchar(255);
  --
  declare no_more_rows boolean;
  declare loop_cntr int default 0;
  declare num_rows int default 0;
  --
  declare l_image_cursor cursor for
	select  attribute_value, attribute_name
  from    import_data_attribute
  where   import_id = i_import_id
  and     attribute_group = 'images';
  --
  declare continue HANDLER for NOT FOUND set no_more_rows = TRUE;
  declare exit HANDLER for sqlexception
  begin
      update import_data set status = concat('Error: ', sqlcode) where import_id = i_import_id;
  end;
  --
  -- create temporary table images_to_delete (image_id int);
  --
  -- Process posting
  select  count(*)
  into    l_count
  from    posting
  where   external_key = i_external_key;
  --
  select  category_id, source_id
  into    l_category_id, l_source_id
  from    import_data
  where   import_id = i_import_id
  and     external_key = i_external_key;
  --
  select  attribute_value
  into    l_title
  from    import_data_attribute
  where   import_id = i_import_id
  and     attribute_name = 'heading';
  --
  if l_title is null then
    leave thisSP;
  end if;
  --
  select  attribute_value
  into    l_description
  from    import_data_attribute
  where   import_id = i_import_id
  and     attribute_name = 'body';
  --
  select  str_to_date(substr(attribute_value, 1, 19), '%Y/%m/%d %H:%i:%s')
  into    l_posting_date
  from    import_data_attribute
  where   import_id = i_import_id
  and     attribute_name = 'timestamp';
  --
  if l_posting_date is null then
    select now() into l_posting_date;
  end if;
  --
  select  str_to_date(substr(attribute_value, 1, 19), '%Y/%m/%d %H:%i:%s')
  into    l_expiration_date
  from    import_data_attribute
  where   import_id = i_import_id
  and     attribute_name = 'expiration';
  --
  select  attribute_value
  into    l_external_email
  from    import_data_attribute
  where   import_id = i_import_id
  and     attribute_name = 'accountName';
  --
  select  attribute_value
  into    l_external_url
  from    import_data_attribute
  where   import_id = i_import_id
  and     attribute_name = 'externalURL';
  --
  if l_count = 0 then
    insert into posting (posting_status_id, title, description, posting_date, expiration_date, user_id,
      category_id, date_created, date_updated, post_anonymously, external_key, external_email, external_url, source_id)
    values (2, l_title, l_description, l_posting_date, l_expiration_date, i_user_id, l_category_id, now(),
      now(), '1', i_external_key, l_external_email, l_external_url, l_source_id);
  else
    update  posting
    set     title = l_title,
            description = l_description,
            posting_date = l_posting_date,
            expiration_date = l_expiration_date,
            category_id = l_category_id,
            external_email = l_external_email,
            external_url = l_external_url,
            source_id = l_source_id,
            date_updated = now()
    where   external_key = i_external_key;
  end if;
  --
  select  posting_id
  into    l_posting_id
  from    posting
  where   external_key = i_external_key
  and     source_id = l_source_id;
  --
  -- Process posting images
  /*
  insert into images_to_delete (image_id)
  select  image_id from posting_image where posting_id = l_posting_id;
  --
  delete from image_copy where image_id in (select image_id from images_to_delete);
  delete from image where image_id in (select image_id from images_to_delete);
  --
  drop table images_to_delete;
  */
  delete from posting_image where posting_id = l_posting_id;
  --
  open l_image_cursor;
  select FOUND_ROWS() into num_rows;
  --
	the_loop: loop
    fetch  l_image_cursor
    into   l_image_url, l_image_name;
    --
    if no_more_rows then
        close l_image_cursor;
        leave the_loop;
    end if;
    --
    insert into image (user_id, image_file, image_url, date_created)
    values (i_user_id, substring_index(l_image_url, '/', -1), l_image_url, now());
    --
    select  LAST_INSERT_ID() into l_image_id;
    --
    insert into image_copy (image_id, image_type_id, image_file, image_size, date_created)
    values (l_image_id, 1, substring_index(l_image_url, '/', -1), 0, now());
    --
    if l_image_name = '0' then
      insert into posting_image values (l_posting_id, l_image_id, '1', now());
    else
      insert into posting_image values (l_posting_id, l_image_id, '0', now());
    end if;
    --
  end loop the_loop;
  --
  -- Process posting address
  select  attribute_value
  into    l_address
  from    import_data_attribute
  where   import_id = i_import_id
  and     attribute_name = 'original_address';
  --
  select  attribute_value
  into    l_city
  from    import_data_attribute
  where   import_id = i_import_id
  and     attribute_name = 'original_city';
  --
  select  attribute_value
  into    l_phone
  from    import_data_attribute
  where   import_id = i_import_id
  and     attribute_name = 'original_phone';
  --  
  select  attribute_value
  into    l_lat
  from    import_data_attribute
  where   import_id = i_import_id
  and     attribute_name = 'latitude';
  --
  if l_lat = '0' then
    select  attribute_value
    into    l_lat
    from    import_data_attribute
    where   import_id = i_import_id
    and     attribute_name = 'latitudeEstimated';
  end if;
  --
  select  attribute_value
  into    l_lon
  from    import_data_attribute
  where   import_id = i_import_id
  and     attribute_name = 'longitude';
  --
  if l_lon = '0' then
    select  attribute_value
    into    l_lon
    from    import_data_attribute
    where   import_id = i_import_id
    and     attribute_name = 'longitudeEstimated';
  end if;
  --
  delete from address where posting_id = l_posting_id;
  insert into address (posting_id, address, city, lat, lon, phone, date_created)
  values (l_posting_id, l_address, l_city, l_lat, l_lon, l_phone, now());
  --
  -- Process posting attributes
  select  pc.parent_category_id, pc.name
  into    l_parent_category_id, l_parent_category_name
  from    category c, parent_category pc
  where   c.parent_category_id = pc.parent_category_id
  and     c.category_id = l_category_id;
  --
  call spCLIndexPostingAttribute(i_import_id, l_posting_id, l_category_id, l_parent_category_name);
  --
END;
