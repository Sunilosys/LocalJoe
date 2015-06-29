DELIMITER @@
DROP PROCEDURE IF EXISTS spRegenerateSearchTable;
CREATE PROCEDURE spRegenerateSearchTable(in i_parent_category_id int)
begin
  declare l_sql_stmt text;
  declare l_delete_stmt varchar(255);
  declare l_parent_category_name varchar(255);
  declare l_parent_category_attribute_id int;
  declare l_name varchar(255);
  declare l_is_search_facet varchar(1);
  declare l_display_format varchar(100);
  declare l_solr_format varchar(10);
  declare l_solr_range_format varchar(10);
  declare l_facet_type varchar(30);
  declare l_dimension_name varchar(30);
  --
  declare no_more_rows boolean;
  declare loop_cntr int default 0;
  declare num_rows int default 0;
  --
  declare l_attribute_cursor cursor for
	select  pca.parent_category_attribute_id, replace(replace(replace(replace(lower(rtrim(pca.name)), ' ', '_'), '-', '_'), '(', ''), ')', ''), pca.is_search_facet, pca.facet_type, f.display_format, f.solr_format, f.solr_range_format
  from    parent_category_attribute pca,
          format f
  where   pca.format_id = f.format_id
  and     pca.parent_category_id = i_parent_category_id
  order by pca.parent_category_attribute_id;
  --
  declare l_dimension_cursor cursor for
  select  replace(replace(replace(replace(replace(replace(lower(value), ' ', '_'), '(', ''), ')', ''), '-', '_'), '%', 'percent'), '$', 'dollar')
  from    category_attribute_valid_value
  where   parent_category_attribute_id = l_parent_category_attribute_id
  order by display_sequence, value;
  --
  declare continue HANDLER for NOT FOUND set no_more_rows = TRUE;
  --
  -- Get the parent category name
  select  name
  into    l_parent_category_name
  from    parent_category
  where   parent_category_id = i_parent_category_id;
  --
  select concat ('create table all_', lower(l_parent_category_name), ' (') into l_sql_stmt;
  select concat (l_sql_stmt, 'posting_id_i int null, ') into l_sql_stmt;
  select concat (l_sql_stmt, 'posting_status_id_i int null, ') into l_sql_stmt;
  select concat (l_sql_stmt, 'title_t varchar(255) null, ') into l_sql_stmt;
  select concat (l_sql_stmt, 'description_t text null, ') into l_sql_stmt;
  select concat (l_sql_stmt, 'category_id_i int null, ') into l_sql_stmt;
  select concat (l_sql_stmt, 'parent_category_id_i int null, ') into l_sql_stmt;
  select concat (l_sql_stmt, 'category_name_t varchar(255) null, ') into l_sql_stmt;
  select concat (l_sql_stmt, 'parent_category_name_t varchar(255) null, ') into l_sql_stmt;
  select concat (l_sql_stmt, 'city_name_t varchar(100) null, ') into l_sql_stmt;
  select concat (l_sql_stmt, 'posting_date_dt datetime null, ') into l_sql_stmt;
  select concat (l_sql_stmt, 'expiration_date_dt datetime null, ') into l_sql_stmt;
  select concat (l_sql_stmt, 'date_created_dt datetime null, ') into l_sql_stmt;
  select concat (l_sql_stmt, 'date_updated_dt datetime null, ') into l_sql_stmt;
  select concat (l_sql_stmt, 'user_id_i int null, ') into l_sql_stmt;
  --
	open l_attribute_cursor;
  select FOUND_ROWS() into num_rows;
  --
	the_loop: loop
    fetch  l_attribute_cursor
    into   l_parent_category_attribute_id, l_name, l_is_search_facet, l_facet_type, l_display_format, l_solr_format, l_solr_range_format;
    --
    if no_more_rows then
        close l_attribute_cursor;
        leave the_loop;
    end if;
    --
    if l_is_search_facet = '1' then
      if l_display_format not in ('Integer+Dimension', 'Numeric+Dimension') then
        if l_facet_type != 'range' then
          update parent_category_attribute set solr_column_name = concat(l_name, l_solr_format)
          where parent_category_attribute_id = l_parent_category_attribute_id;
          --
          if l_solr_format = '_dt' then
            select concat (l_sql_stmt, l_name, l_solr_format,' datetime null, ') into l_sql_stmt;
          elseif l_solr_format = '_i' then
            select concat (l_sql_stmt, l_name, l_solr_format,' int null, ') into l_sql_stmt;
          elseif l_solr_format = '_f' then
            select concat (l_sql_stmt, l_name, l_solr_format,' float null, ') into l_sql_stmt;
          else
            select concat (l_sql_stmt, l_name, l_solr_format,' varchar(1024) null, ') into l_sql_stmt;
          end if;
        else
          update parent_category_attribute set solr_column_name = concat(l_name, l_solr_range_format)
          where parent_category_attribute_id = l_parent_category_attribute_id;
          --
          if l_solr_format = '_dt' then
            select concat (l_sql_stmt, l_name, l_solr_range_format,' datetime null, ') into l_sql_stmt;
          elseif l_solr_format = '_i' then
            select concat (l_sql_stmt, l_name, l_solr_range_format,' int null, ') into l_sql_stmt;
          elseif l_solr_format = '_f' then
            select concat (l_sql_stmt, l_name, l_solr_range_format,' float null, ') into l_sql_stmt;
          else
            select concat (l_sql_stmt, l_name, l_solr_range_format,' varchar(1024) null, ') into l_sql_stmt;
          end if;
        end if;
      elseif l_display_format in ('Integer+Dimension', 'Numeric+Dimension') then
        -- select concat (l_sql_stmt, l_name, '_dimension_t varchar(30) null, ') into l_sql_stmt;
        open l_dimension_cursor;
        loop2: loop
          fetch l_dimension_cursor into l_dimension_name;
          if no_more_rows then
            set no_more_rows := false;
            close l_dimension_cursor;
            leave loop2;
          end if;
          --
          if l_facet_type != 'range' then
            if l_solr_format = '_i' then
              select concat (l_sql_stmt, l_name, '_', l_dimension_name, l_solr_format, ' int null, ') into l_sql_stmt;
            elseif l_solr_format = '_f' then
              select concat (l_sql_stmt, l_name, '_', l_dimension_name, l_solr_format, ' float null, ') into l_sql_stmt;
            end if;
          else
            if l_solr_format = '_i' then
              select concat (l_sql_stmt, l_name, '_', l_dimension_name, l_solr_range_format, ' int null, ') into l_sql_stmt;
            elseif l_solr_format = '_f' then
              select concat (l_sql_stmt, l_name, '_', l_dimension_name, l_solr_range_format, ' float null, ') into l_sql_stmt;
            end if;
          end if;
          --
        end loop loop2;
      end if;
    end if;
    --
  end loop the_loop;
  --
  select concat (l_sql_stmt, 'posting_image_title_t varchar(100) null, ') into l_sql_stmt;
  select concat (l_sql_stmt, 'posting_image_file_t varchar(255) null, ') into l_sql_stmt;
  select concat (l_sql_stmt, 'tag_tc varchar(1024) null') into l_sql_stmt;
  select concat (l_sql_stmt, ');') into l_sql_stmt;
  --
  -- Drop table if it already exists
  select concat ('drop table if exists all_', lower(l_parent_category_name), ';') into l_delete_stmt;
  set    @ds = l_delete_stmt;
  prepare delStmt from @ds; 
  execute delStmt;
  deallocate prepare delStmt;
  --
  set @cs = l_sql_stmt;
  prepare createStmt FROM @cs; 
  EXECUTE createStmt;
  deallocate prepare createStmt;
END @@
DELIMITER ;



