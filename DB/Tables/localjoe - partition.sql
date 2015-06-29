

DROP TABLE IF EXISTS posting_image;

CREATE TABLE posting_image (
       posting_id           int NOT NULL,
       image_id             int NOT NULL,
       is_main_image        varchar(1) NULL,
       date_created         datetime NOT NULL,
       PRIMARY KEY (posting_id, image_id)
)
ENGINE = InnoDB DEFAULT CHARSET=utf8;

CREATE UNIQUE INDEX posting_image_pk ON posting_image
(
       posting_id,
       image_id
);


DROP TABLE IF EXISTS posting_tag;

CREATE TABLE posting_tag (
       posting_id           int NOT NULL,
       tag_id               int NOT NULL,
       date_created         datetime NOT NULL,
       PRIMARY KEY (posting_id, tag_id)
)
ENGINE = InnoDB DEFAULT CHARSET=utf8;

CREATE UNIQUE INDEX posting_tag_pk ON posting_tag
(
       posting_id,
       tag_id
);


DROP TABLE IF EXISTS address;

CREATE TABLE address (
       address_id           int NOT NULL AUTO_INCREMENT,
       posting_id           int NULL,
       address              varchar(255) NULL,
       city                 varchar(100) NULL,
       zip                  varchar(20) NULL,
       lat                  float NULL,
       lon                  float NULL,
       phone                varchar(20) NULL,
       date_created         datetime NOT NULL,
       PRIMARY KEY (address_id)
)
ENGINE = InnoDB DEFAULT CHARSET=utf8;

CREATE UNIQUE INDEX address_pk ON address
(
       address_id
);


CREATE INDEX address_idx2 ON address
(
       posting_id
);


DROP TABLE IF EXISTS image_copy;

CREATE TABLE image_copy (
       image_copy_id        int NOT NULL AUTO_INCREMENT,
       image_id             int NOT NULL,
       image_type_id        int NOT NULL,
       image_file           varchar(255) NOT NULL,
       image_size           int NOT NULL,
       width                int NULL,
       height               int NULL,
       date_created         datetime NOT NULL,
       PRIMARY KEY (image_copy_id)
)
ENGINE = InnoDB DEFAULT CHARSET=utf8;

CREATE UNIQUE INDEX image_copy_pk ON image_copy
(
       image_copy_id
);

CREATE INDEX image_copy_idx1 ON image_copy
(
       image_type_id
);

CREATE INDEX image_copy_idx2 ON image_copy
(
       image_id
);



DROP TABLE IF EXISTS image;

CREATE TABLE image (
       image_id             int NOT NULL AUTO_INCREMENT,
       user_id              int NOT NULL,
       image_file           varchar(255) NOT NULL,
       image_title          varchar(100) NULL,
       width                int NULL,
       height               int NULL,
       image_size           int NULL,
       date_created         datetime NOT NULL,
       PRIMARY KEY (image_id)
)
ENGINE = InnoDB DEFAULT CHARSET=utf8;

CREATE UNIQUE INDEX image_pk ON image
(
       image_id
);

CREATE INDEX image_idx1 ON image
(
       user_id
);



DROP TABLE IF EXISTS folder_posting;

CREATE TABLE folder_posting (
       folder_posting_id    int NOT NULL AUTO_INCREMENT,
       posting_id           int NOT NULL,
       folder_id            int NOT NULL,
       date_created         datetime NOT NULL,
       PRIMARY KEY (folder_posting_id)
)
ENGINE = InnoDB DEFAULT CHARSET=utf8;

CREATE UNIQUE INDEX folder_posting_pk ON folder_posting
(
       folder_posting_id
);

CREATE INDEX folder_posting_idx1 ON folder_posting
(
       folder_id
);

CREATE INDEX folder_posting_idx2 ON folder_posting
(
       posting_id
);


DROP TABLE IF EXISTS posting_view;

CREATE TABLE posting_view (
       posting_view_id      int NOT NULL AUTO_INCREMENT,
       posting_id           int NOT NULL,
       action_id            int NOT NULL,
       user_id              int NULL,
       date_created         datetime NOT NULL,
       PRIMARY KEY (posting_view_id)
)
ENGINE = InnoDB DEFAULT CHARSET=utf8;

CREATE UNIQUE INDEX posting_view_pk ON posting_view
(
       posting_view_id
);

CREATE INDEX posting_view_idx1 ON posting_view
(
       posting_id
);

CREATE INDEX posting_view_idx2 ON posting_view
(
       user_id
);

CREATE INDEX posting_view_idx3 ON posting_view
(
       action_id
);


DROP TABLE IF EXISTS action;

CREATE TABLE action (
       action_id            int NOT NULL AUTO_INCREMENT,
       action               varchar(30) NULL,
       date_created         datetime NOT NULL,
       PRIMARY KEY (action_id)
)
ENGINE = InnoDB DEFAULT CHARSET=utf8;


CREATE UNIQUE INDEX action_pk ON action
(
       action_id
);


DROP TABLE IF EXISTS posting_attribute;

CREATE TABLE posting_attribute (
       posting_attribute_id int NOT NULL AUTO_INCREMENT,
       posting_id           int NOT NULL,
       category_attribute_id int NOT NULL,
       value                varchar(1024) NOT NULL,
       dimension            varchar(30) NULL,
       is_other             varchar(1) NOT NULL,
       date_created         datetime NOT NULL,
       PRIMARY KEY (posting_attribute_id)
)
ENGINE = InnoDB DEFAULT CHARSET=utf8;

CREATE UNIQUE INDEX posting_attribute_pk ON posting_attribute
(
       posting_attribute_id
);

CREATE INDEX posting_attribute_idx1 ON posting_attribute
(
       category_attribute_id
);

CREATE INDEX posting_attribute_idx2 ON posting_attribute
(
       posting_id
);


DROP TABLE IF EXISTS rating;

CREATE TABLE rating (
       rating_id            int NOT NULL AUTO_INCREMENT,
       rating_scale_id      int NOT NULL,
       posting_id           int NOT NULL,
       user_id              int NOT NULL,
       posting_user_id      int NOT NULL,
       rating               varchar(255) NOT NULL,
       date_created         datetime NOT NULL,
       PRIMARY KEY (rating_id)
)
ENGINE = InnoDB DEFAULT CHARSET=utf8;

CREATE UNIQUE INDEX rating_pk ON rating
(
       rating_id
);

CREATE INDEX rating_idx1 ON rating
(
       rating_scale_id
);

CREATE INDEX rating_idx2 ON rating
(
       posting_id
);

CREATE INDEX rating_idx3 ON rating
(
       user_id
);

CREATE INDEX rating_idx4 ON rating
(
       posting_user_id
);

DROP TABLE IF EXISTS posting;

CREATE TABLE posting (
       posting_id           int NOT NULL AUTO_INCREMENT,
       posting_status_id    int NOT NULL,
       title                varchar(255) NOT NULL,
       description          text NULL,
       posting_date         datetime NOT NULL,
       expiration_date      datetime NOT NULL,
       user_id              int NOT NULL,
       city_id              int NOT NULL,
       category_id          int NOT NULL,
       long_html            mediumtext NULL,
       short_html           mediumtext NULL,
       post_anonymously     varchar(1),
       date_created         datetime NOT NULL,
       date_updated         datetime NOT NULL,
       PRIMARY KEY (posting_id)
)
ENGINE = InnoDB DEFAULT CHARSET=utf8;

CREATE UNIQUE INDEX posting_pk ON posting
(
       posting_id
);

CREATE INDEX posting_idx1 ON posting
(
       city_id
);

CREATE INDEX posting_idx2 ON posting
(
       posting_status_id
);

CREATE INDEX posting_idx3 ON posting
(
       category_id
);

CREATE INDEX posting_idx4 ON posting
(
       user_id
);


DROP TABLE IF EXISTS friend;

CREATE TABLE friend (
       friend_id            int NOT NULL AUTO_INCREMENT,
       friend_user_id       int NOT NULL,
       user_id              int NOT NULL,
       date_created         datetime NOT NULL,
       PRIMARY KEY (friend_id)
)
ENGINE = InnoDB DEFAULT CHARSET=utf8;

CREATE UNIQUE INDEX friend_pk ON friend
(
       friend_id
);

CREATE INDEX friend_idx1 ON friend
(
       user_id
);


DROP TABLE IF EXISTS folder;

CREATE TABLE folder (
       folder_id            int NOT NULL AUTO_INCREMENT,
       user_id              int NOT NULL,
       folder_name          varchar(100) NOT NULL,
       date_created         datetime NOT NULL,
       PRIMARY KEY (folder_id)
)
ENGINE = InnoDB DEFAULT CHARSET=utf8;

CREATE UNIQUE INDEX folder_pk ON folder
(
       folder_id
);

CREATE INDEX folder_idx1 ON folder
(
       user_id
);


DROP TABLE IF EXISTS saved_search;

CREATE TABLE saved_search (
       search_id            int NOT NULL AUTO_INCREMENT,
       search_name varchar(255) NOT NULL,
       user_id              int NOT NULL,
       search_terms         varchar(2048) NULL,
       date_created         datetime NOT NULL,
       PRIMARY KEY (search_id)
)
ENGINE = InnoDB DEFAULT CHARSET=utf8;

CREATE UNIQUE INDEX saved_search_pk ON saved_search
(
       search_id
);

CREATE INDEX saved_search_idx1 ON saved_search
(
       user_id
);


DROP TABLE IF EXISTS user_info;

CREATE TABLE user_info (
       user_id              int NOT NULL,
       first_name           varchar(100) NOT NULL,
       last_name            varchar(100) NOT NULL,
       email                varchar(255) NULL,
       date_created         datetime NOT NULL,
       date_updated         datetime NOT NULL,
       authentication_method_id int NOT NULL,
       active_flag          varchar(1) NULL,
       PRIMARY KEY (user_id)
)
ENGINE = InnoDB DEFAULT CHARSET=utf8;

CREATE UNIQUE INDEX user_info_pk ON user_info
(
       user_id
);


DROP TABLE IF EXISTS authentication_method;

CREATE TABLE  authentication_method (
  authentication_method_id int NOT NULL,
  authentication_method varchar(100) NOT NULL,
  date_created datetime NOT NULL,
  date_updated datetime NOT NULL,
  PRIMARY KEY (authentication_method_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE UNIQUE INDEX authentication_method_pk ON authentication_method
(
       authentication_method_id
);



DROP TABLE IF EXISTS city;

CREATE TABLE city (
       city_id              int NOT NULL AUTO_INCREMENT,
       city                 varchar(100) NOT NULL,
       date_created         datetime NOT NULL,
       PRIMARY KEY (city_id)
)
ENGINE = InnoDB DEFAULT CHARSET=utf8;

CREATE UNIQUE INDEX city_pk ON city
(
       city_id
);


DROP TABLE IF EXISTS tag;

CREATE TABLE tag (
       tag_id               int NOT NULL AUTO_INCREMENT,
       tag_name             varchar(100) NULL,
       date_created         datetime NOT NULL,
       PRIMARY KEY (tag_id)
)
ENGINE = InnoDB DEFAULT CHARSET=utf8;


CREATE UNIQUE INDEX tag_pk ON tag
(
       tag_id
);


DROP TABLE IF EXISTS rating_scale;

CREATE TABLE rating_scale (
       rating_scale_id      int NOT NULL AUTO_INCREMENT,
       rating               int NOT NULL,
       image_file           varchar(255) NULL,
       date_created         datetime NOT NULL,
       PRIMARY KEY (rating_scale_id)
)
ENGINE = InnoDB DEFAULT CHARSET=utf8;


CREATE UNIQUE INDEX rating_scale_pk ON rating_scale
(
       rating_scale_id
);


DROP TABLE IF EXISTS category_attribute_valid_value;

CREATE TABLE category_attribute_valid_value (
       category_attribute_valid_value_id int NOT NULL AUTO_INCREMENT,
       category_attribute_id int NULL,
       parent_category_attribute_id int NULL,
       value                varchar(1024) NOT NULL,
       filter_attribute_id  int NULL,
       filter_value         varchar(1024) NULL,
       display_sequence     int NOT NULL,
       is_active            varchar(1) NOT NULL,
       is_other             varchar(1) NOT NULL,
       date_created         datetime NOT NULL,
       PRIMARY KEY (category_attribute_valid_value_id)
)
ENGINE = InnoDB DEFAULT CHARSET=utf8;

CREATE UNIQUE INDEX category_attribute_valid_value_pk ON category_attribute_valid_value
(
       category_attribute_valid_value_id
);

CREATE INDEX category_attribute_valid_value_idx1 ON category_attribute_valid_value
(
       category_attribute_id
);

CREATE INDEX category_attribute_valid_value_idx2 ON category_attribute_valid_value
(
       parent_category_attribute_id
);

DROP TABLE IF EXISTS category_attribute;

CREATE TABLE category_attribute (
       category_attribute_id int NOT NULL AUTO_INCREMENT,
       category_id          int NOT NULL,
       parent_category_attribute_id int NULL,
       display_sequence     int NOT NULL,
       date_created         datetime NOT NULL,
       PRIMARY KEY (category_attribute_id)
)
ENGINE = InnoDB DEFAULT CHARSET=utf8;

CREATE UNIQUE INDEX category_attribute_pk ON category_attribute
(
       category_attribute_id
);

CREATE INDEX category_attribute_idx1 ON category_attribute
(
       category_id
);


CREATE INDEX category_attribute_idx2 ON category_attribute
(
       parent_category_attribute_id
);


DROP TABLE IF EXISTS category;

CREATE TABLE category (
       category_id          int NOT NULL AUTO_INCREMENT,
       parent_category_id   int NOT NULL,
       name                 varchar(255) NOT NULL,
       description          varchar(255) NULL,
       date_created         datetime NOT NULL,
       is_active            varchar(1) NULL,
       PRIMARY KEY (category_id)
)
ENGINE = InnoDB DEFAULT CHARSET=utf8;

CREATE UNIQUE INDEX category_pk ON category
(
       category_id
);

CREATE INDEX category_idx1 ON category
(
       parent_category_id
);


DROP TABLE IF EXISTS parent_category_attribute;

CREATE TABLE parent_category_attribute (
       parent_category_attribute_id int NOT NULL AUTO_INCREMENT,
       parent_category_id   int NOT NULL,
       format_id            int NOT NULL,
       name                 varchar(255) NOT NULL,
       facet_name           varchar(255) NULL,
       facet_type           varchar(30) NULL,
       is_search_facet      varchar(1) NOT NULL,
       is_active            varchar(1) NOT NULL,
       sorttype             varchar(30) NULL,
       rule                 varchar(30) NULL,
       is_required          varchar(1) NOT NULL,
       solr_column_name     varchar(30) NULL,
       is_currency          varchar(1) NULL,
       help_text            varchar(1024) NULL,
       range_increment      int NULL,
       date_created         datetime NOT NULL,
       PRIMARY KEY (parent_category_attribute_id)
)
ENGINE = InnoDB DEFAULT CHARSET=utf8;

CREATE UNIQUE INDEX parent_category_attribute_pk ON parent_category_attribute
(
       parent_category_attribute_id
);

CREATE INDEX parent_category_attribute_idx1 ON parent_category_attribute
(
       parent_category_id
);

CREATE INDEX parent_category_attribute_idx2 ON parent_category_attribute
(
       format_id
);

DROP TABLE IF EXISTS parent_category;

CREATE TABLE parent_category (
       parent_category_id   int NOT NULL AUTO_INCREMENT,
       name                 varchar(255) NOT NULL,
       supports_rating      varchar(1) NOT NULL,
       is_active            varchar(1) NOT NULL,
       date_created         datetime NOT NULL,
       PRIMARY KEY (parent_category_id)
)
ENGINE = InnoDB DEFAULT CHARSET=utf8;


CREATE UNIQUE INDEX parent_category_pk ON parent_category
(
       parent_category_id
);


DROP TABLE IF EXISTS posting_status;

CREATE TABLE posting_status (
       posting_status_id    int NOT NULL AUTO_INCREMENT,
       posting_status       varchar(100) NOT NULL,
       date_created         datetime NOT NULL,
       PRIMARY KEY (posting_status_id)
)
ENGINE = InnoDB DEFAULT CHARSET=utf8;


CREATE UNIQUE INDEX posting_status_pk ON posting_status
(
       posting_status_id
);


DROP TABLE IF EXISTS format;

CREATE TABLE format (
       format_id            int NOT NULL AUTO_INCREMENT,
       display_format       varchar(100) NOT NULL,
       solr_format          varchar(10) NULL,
       solr_range_format    varchar(10) NULL,
       date_created         datetime NOT NULL,
       PRIMARY KEY (format_id)
)
ENGINE = InnoDB DEFAULT CHARSET=utf8;


CREATE UNIQUE INDEX format_pk ON format
(
       format_id
);


DROP TABLE IF EXISTS image_type;

CREATE TABLE image_type (
       image_type_id        int NOT NULL AUTO_INCREMENT,
       image_type           varchar(100) NOT NULL,
       width                int NOT NULL,
       height               int NOT NULL,
       date_created         datetime NOT NULL,
       PRIMARY KEY (image_type_id)
)
ENGINE = InnoDB DEFAULT CHARSET=utf8;


CREATE UNIQUE INDEX image_type_pk ON image_type
(
       image_type_id
);


ALTER TABLE posting_image
       ADD FOREIGN KEY (image_id)
                             REFERENCES image (image_id);


ALTER TABLE posting_image
       ADD FOREIGN KEY (posting_id)
                             REFERENCES posting (posting_id);
                             

ALTER TABLE posting_tag
       ADD FOREIGN KEY (tag_id)
                             REFERENCES tag (tag_id);


ALTER TABLE posting_tag
       ADD FOREIGN KEY (posting_id)
                             REFERENCES posting (posting_id);


ALTER TABLE address
       ADD FOREIGN KEY (posting_id)
                             REFERENCES posting (posting_id);


ALTER TABLE image_copy
       ADD FOREIGN KEY (image_id)
                             REFERENCES image (image_id);


ALTER TABLE image_copy
       ADD FOREIGN KEY (image_type_id)
                             REFERENCES image_type (image_type_id);


ALTER TABLE image
       ADD FOREIGN KEY (user_id)
                             REFERENCES user_info (user_id);


ALTER TABLE folder_posting
       ADD FOREIGN KEY (posting_id)
                             REFERENCES posting (posting_id);


ALTER TABLE folder_posting
       ADD FOREIGN KEY (folder_id)
                             REFERENCES folder (folder_id);


ALTER TABLE posting_view
       ADD FOREIGN KEY (user_id)
                             REFERENCES user_info (user_id);


ALTER TABLE posting_view
       ADD FOREIGN KEY (posting_id)
                             REFERENCES posting (posting_id);


ALTER TABLE posting_view
       ADD FOREIGN KEY (action_id)
                             REFERENCES action (action_id);


ALTER TABLE posting_attribute
       ADD FOREIGN KEY (posting_id)
                             REFERENCES posting (posting_id);


ALTER TABLE posting_attribute
       ADD FOREIGN KEY (category_attribute_id)
                             REFERENCES category_attribute (category_attribute_id);


ALTER TABLE rating
       ADD FOREIGN KEY (rating_scale_id)
                             REFERENCES rating_scale (rating_scale_id);


ALTER TABLE rating
       ADD FOREIGN KEY (user_id)
                             REFERENCES user_info (user_id);


ALTER TABLE rating
       ADD FOREIGN KEY (posting_id)
                             REFERENCES posting (posting_id);


ALTER TABLE posting
       ADD FOREIGN KEY (category_id)
                             REFERENCES category (category_id);


ALTER TABLE posting
       ADD FOREIGN KEY (posting_status_id)
                             REFERENCES posting_status (posting_status_id);


ALTER TABLE posting
       ADD FOREIGN KEY (city_id)
                             REFERENCES city (city_id);


ALTER TABLE posting
       ADD FOREIGN KEY (user_id)
                             REFERENCES user_info (user_id);


ALTER TABLE friend
       ADD FOREIGN KEY (user_id)
                             REFERENCES user_info (user_id);


ALTER TABLE folder
       ADD FOREIGN KEY (user_id)
                             REFERENCES user_info (user_id);


ALTER TABLE saved_search
       ADD FOREIGN KEY (user_id)
                             REFERENCES user_info (user_id);



ALTER TABLE parent_category_attribute
       ADD FOREIGN KEY (parent_category_id)
                             REFERENCES parent_category (parent_category_id);


ALTER TABLE parent_category_attribute
       ADD FOREIGN KEY (format_id)
                             REFERENCES format (format_id);


ALTER TABLE category_attribute_valid_value
       ADD FOREIGN KEY (category_attribute_id)
                             REFERENCES category_attribute (category_attribute_id);


ALTER TABLE category_attribute_valid_value
       ADD FOREIGN KEY (parent_category_attribute_id)
                             REFERENCES parent_category_attribute (parent_category_attribute_id);


ALTER TABLE category_attribute
       ADD FOREIGN KEY (category_id)
                             REFERENCES category (category_id);


ALTER TABLE category_attribute
       ADD FOREIGN KEY (parent_category_attribute_id)
                             REFERENCES parent_category_attribute (parent_category_attribute_id);


ALTER TABLE category
       ADD FOREIGN KEY (parent_category_id)
                             REFERENCES parent_category (parent_category_id);

ALTER TABLE user_info
       ADD FOREIGN KEY (authentication_method_id)
                             REFERENCES authentication_method (authentication_method_id);