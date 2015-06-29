delete from source;
INSERT INTO source (source_code,source_name,api_base_url,api_auth_key,api_response_format)
values ('CRAIG','Craigslist','http://api.3taps.com','jm387xa84ycup9t3kpgm854p','json');

delete from api_map;
delete from category_mapping;

insert into api_map (source_id,api_parameters,search_text)
values (1,'category=STIX',null);

insert into category_mapping (category_id,api_id) values (68,1);

insert into api_map (source_id,api_parameters,search_text) 
values (1,'category=SOTH',null);

insert into category_mapping (category_id,api_id) values (75,2);


insert into api_map (source_id,api_parameters,search_text) 
values (1,'category=SFUR',null);

insert into category_mapping (category_id,api_id) values (73,3);


insert into api_map (source_id,api_parameters,search_text) 
values (1,'category=SELE&annotations={original_subcat:ela}',null);

insert into category_mapping (category_id,api_id) values (74,4);


insert into api_map (source_id,api_parameters,search_text) 
values (1,'category=SCOM',null);

insert into category_mapping (category_id,api_id) values (72,5);


insert into api_map (source_id,api_parameters,search_text) 
values (1,'category=SBIK',null);

insert into category_mapping (category_id,api_id) values (8,6);


insert into api_map (source_id,api_parameters,search_text) 
values (1,'category=SAPL',null);

insert into category_mapping (category_id,api_id) values (74,7);


insert into api_map (source_id,api_parameters,search_text)
values (1,'annotations={original_subcat:moa}',null);

insert into category_mapping (category_id,api_id) values (71,8);

insert into api_map (source_id,api_parameters,search_text) 
values (1,'category=VAUT&annotations={original_subcat:cta}','truck');

insert into category_mapping (category_id,api_id) values (7,9);


insert into api_map (source_id,api_parameters,search_text) 
values (1,'category=VAUT&annotations={original_subcat:cta}','not truck');

insert into category_mapping (category_id,api_id) values (6,10);

insert into api_map (source_id,api_parameters,search_text) 
values (1,'category=VAUT&annotations={original_subcat:mca}',null);

insert into category_mapping (category_id,api_id) values (10,11);


insert into api_map (source_id,api_parameters,search_text) 
values (1,'category=COMM&annotations={original_subcat:gms}',null);

insert into category_mapping (category_id,api_id) values (64,12);


insert into api_map (source_id,api_parameters,search_text) 
values (1,'category=COMM&annotations={original_subcat:grp}',null);

insert into category_mapping (category_id,api_id) values (65,13);


insert into api_map (source_id,api_parameters,search_text) 
values (1,'category=COMM&annotations={original_subcat:act}',null);

insert into category_mapping (category_id,api_id) values (70,14);


insert into api_map (source_id,api_parameters,search_text) 
values (1,'category=COMM&annotations={original_subcat:cal}','Farmers Market');

insert into category_mapping (category_id,api_id) values (66,15);


insert into api_map (source_id,api_parameters,search_text) 
values (1,'category=SHNG','Farmers Market');

insert into category_mapping (category_id,api_id) values (66,16);


insert into api_map (source_id,api_parameters,search_text) 
values (1,'category=RVAC',null);

insert into category_mapping (category_id,api_id) values (5,17);


insert into api_map (source_id,api_parameters,search_text) 
values (1,'category=RSHR',null);

insert into category_mapping (category_id,api_id) values (3,18);

insert into api_map (source_id,api_parameters,search_text) 
values (1,'category=RSUB',null);

insert into category_mapping (category_id,api_id) values (4,19);


insert into api_map (source_id,api_parameters,search_text) 
values (1,'category=RHFR','apartment');

insert into category_mapping (category_id,api_id) values (1,20);



insert into api_map (source_id,api_parameters,search_text) 
values (1,'category=RHFR','house or home');

insert into category_mapping (category_id,api_id) values (2,21);


insert into api_map (source_id,api_parameters,search_text) 
values (1,'category=SVCP&annotations={original_subcat:lbs}','move or moving');

insert into category_mapping (category_id,api_id) values (56,22);


insert into api_map (source_id,api_parameters,search_text)
values (1,'category=SVCP&annotations={original_subcat:lbs}','handy');

insert into category_mapping (category_id,api_id) values (55,23);


insert into api_map (source_id,api_parameters,search_text) 
values (1,'category=SVCP&annotations={original_subcat:eve}','cater or catering');

insert into category_mapping (category_id,api_id) values (59,24);


insert into api_map (source_id,api_parameters,search_text)
values (1,'category=SVCP','chef');

insert into category_mapping (category_id,api_id) values (58,25);


insert into api_map (source_id,api_parameters,search_text) 
values (1,'category=SVCH&annotations={original_subcat:kid}',null);

insert into category_mapping (category_id,api_id) values (54,26);


insert into api_map (source_id,api_parameters,search_text) 
values (1,'category=SVCH&annotations={original_subcat:hss}',null);

insert into category_mapping (category_id,api_id) values (57,27);


insert into api_map (source_id,api_parameters,search_text) 
values (1,'category=SVCH&annotations={original_subcat:hss}','chef');

insert into category_mapping (category_id,api_id) values (58,28);


insert into api_map (source_id,api_parameters,search_text) 
values (1,'category=SVCE&annotations={original_subcat:lss}',null);

insert into category_mapping (category_id,api_id) values (60,29);


