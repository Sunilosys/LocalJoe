DELIMITER @@
DROP PROCEDURE IF EXISTS spGenerateSearchData;
CREATE PROCEDURE spGenerateSearchData(in i_posting_id int)
begin
  declare l_value varchar(1024);
  declare l_dimension varchar(30);
  declare l_solr_column_name varchar(30);
  declare l_parent_category_name varchar(255);
  declare l_display_format varchar(100);
  declare l_column_list text;
  declare l_value_list text;
  declare l_sql_stmt text;
  declare l_title varchar(255);
  declare l_description text;
  declare l_city_id int;
  declare l_city_name varchar(255);
  declare l_user_id int;
  declare l_parent_category_id int;
  declare l_category_attribute_id int;
  declare l_category_id int;
  declare l_category_name varchar(255);
  declare l_delete_stmt varchar(1024);
  declare l_posting_date datetime;
  declare l_expiration_date datetime;
  declare l_date_created datetime;
  declare l_date_updated datetime;
  declare l_checkbox_list varchar(1024);
  declare l_tag_list varchar(1024);
  declare l_parent_category_attribute_name varchar(255);
  declare l_is_search_facet varchar(1);
  declare l_solr_format varchar(10);
  declare l_solr_range_format varchar(10);
  declare l_image_title varchar(100);
  declare l_image_file varchar(255);
  declare l_default_date_format varchar(255);
  declare l_count int;
  declare l_posting_status_id int;
  declare l_facet_type varchar(30);
  
  declare no_more_rows boolean;
  declare loop_cntr int default 0;
  declare num_rows int default 0;

 
  declare l_attribute_cursor cursor for
	select  distinct pca.solr_column_name, f.display_format, pa.category_attribute_id, replace(replace(lower(rtrim(pca.name)), ' ', '_'), '-', '_'), pca.is_search_facet,
            pca.facet_type, f.solr_format, f.solr_range_format
  from    posting_attribute pa,
          category_attribute ca,
          parent_category_attribute pca,
          format f
  where   pa.category_attribute_id = ca.category_attribute_id
  and     ca.parent_category_attribute_id = pca.parent_category_attribute_id
  and     pca.format_id = f.format_id
  and     pa.posting_id = i_posting_id
  and     pca.is_search_facet = '1';
  
  declare continue HANDLER for NOT FOUND set no_more_rows = TRUE;
  
  

  
  select  distinct pc.name, pc.parent_category_id, c.category_id, c.name, p.title, p.description, p.posting_status_id, p.user_id,
          p.posting_date, p.expiration_date, p.date_created, p.date_updated
  into    l_parent_category_name, l_parent_category_id, l_category_id, l_category_name, l_title, 
          l_description, l_posting_status_id, l_user_id, l_posting_date, l_expiration_date, l_date_created, l_date_updated
  from    posting p,
          category c,
          parent_category pc
  where   p.category_id = c.category_id
  and     c.parent_category_id = pc.parent_category_id
  and     p.posting_id = i_posting_id;

  select concat ('posting_id_i,title_t,description_t,posting_status_id_i,category_id_i,parent_category_id_i,category_name_t,parent_category_name_t,user_id_i') into l_column_list;
  select concat (i_posting_id, ',''',replace(l_title,'''',''''''),
                             ''',''',replace(l_description,'''',''''''),
                             ''',',l_posting_status_id,
                             ',',l_category_id,
                             ',',l_parent_category_id,
                             ',''',l_category_name,
                             ''',''',l_parent_category_name,
                             ''',',l_user_id) into l_value_list;
  

 
  select  count(*)
  into    l_count
  from    address
  where   posting_id = i_posting_id;
 
  if l_count > 0 then
    select  city
    into    l_city_name
    from    address
    where   posting_id = i_posting_id;
    
    if l_city_name is not null then
      select concat (l_column_list,',city_name_t') into l_column_list;
      select concat (l_value_list,',''',l_city_name,'''') into l_value_list;
    end if;
  end if;
  
  select  setting_value
  into    l_default_date_format
  from    parition_setting
  where   setting_name = 'defaultDateFormat';
  
  select concat (l_column_list,',posting_date_dt,expiration_date_dt,date_created_dt,date_updated_dt') into l_column_list;
  select concat (l_value_list,',''',l_posting_date,''',''',l_expiration_date,''',''',l_date_created,
    ''',''',l_date_updated,'''') into l_value_list;
  
	open l_attribute_cursor;
  select FOUND_ROWS() into num_rows;
  
	the_loop: loop
    fetch  l_attribute_cursor
    into   l_solr_column_name, l_display_format, l_category_attribute_id, l_parent_category_attribute_name, l_is_search_facet, l_facet_type, l_solr_format, l_solr_range_format;
    
    if no_more_rows then
        close l_attribute_cursor;
        leave the_loop;
    end if;
    
    if l_display_format = 'Checkbox' then
      select concat (l_column_list,',',l_solr_column_name) into l_column_list;
      call spGetCheckboxList (i_posting_id, l_category_attribute_id, l_checkbox_list);
      select concat (l_value_list,',''',l_checkbox_list,'''') into l_value_list;
    elseif l_display_format not in ('Integer+Dimension', 'Numeric+Dimension') then
      select  value
      into    l_value
      from    posting_attribute
      where   posting_id = i_posting_id
      and     category_attribute_id = l_category_attribute_id;
      
      select concat (l_column_list,',',l_solr_column_name) into l_column_list;
      if l_solr_format = '_dt' or l_solr_format = '_tdt' then
        select str_to_date(l_value,l_default_date_format) into l_value;
      end if;
      select concat (l_value_list,',''',l_value,'''') into l_value_list;
    elseif l_display_format in ('Integer+Dimension', 'Numeric+Dimension') then
      select  value, dimension
      into    l_value, l_dimension
      from    posting_attribute
      where   posting_id = i_posting_id
      and     category_attribute_id = l_category_attribute_id;
      
      if l_facet_type != 'range' then
        select  concat(l_parent_category_attribute_name, '_', 
                  replace(replace(replace(replace(replace(replace(lower(l_dimension), ' ', '_'), '(', ''), ')', ''), '-', '_'), '%', 'percent'), '$', 'dollar'), l_solr_format)
        into    l_solr_column_name;
      else
        select  concat(l_parent_category_attribute_name, '_', 
                  replace(replace(replace(replace(replace(replace(lower(l_dimension), ' ', '_'), '(', ''), ')', ''), '-', '_'), '%', 'percent'), '$', 'dollar'), l_solr_range_format)
        into    l_solr_column_name;
      end if;
      select concat (l_column_list,',',l_solr_column_name) into l_column_list;
      select concat (l_value_list,',''',l_value,'''') into l_value_list;
    end if;
    
  end loop the_loop;
  
  select  i.image_title, i.image_file
  into    l_image_title, l_image_file
  from    image i,
          posting_image p
  where   p.posting_id = i_posting_id
  and     i.image_id = p.image_id
  and     p.is_main_image = '1'
  order by rand() limit 0,1;
  
  if l_image_title is not null then
    select concat (l_column_list,',posting_image_title_t,posting_image_file_t') into l_column_list;
    select concat (l_value_list,',''',l_image_title,''',''',l_image_file,'''') into l_value_list;
  end if;
  
  select concat (l_column_list,',tag_tc') into l_column_list;
  call spGetTagList (i_posting_id, l_tag_list);
  select concat (l_value_list,',''',l_tag_list,'''') into l_value_list;
  
  
  select concat ('delete from all_', lower(l_parent_category_name), ' where posting_id_i = ',i_posting_id,';') into l_delete_stmt;
  set    @ds = l_delete_stmt;
  prepare delStmt from @ds; 
  execute delStmt;
  deallocate prepare delStmt;
  
 select concat ('insert into all_', lower(l_parent_category_name), 
    ' (',l_column_list,') values (', l_value_list, ');') into l_sql_stmt;
   
  set @cs = l_sql_stmt;
  prepare createStmt FROM @cs; 
  execute createStmt;
  deallocate prepare createStmt;
 
END;
 @@
DELIMITER ;


