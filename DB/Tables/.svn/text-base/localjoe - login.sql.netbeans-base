DROP TABLE IF EXISTS city;

CREATE TABLE city (
       city_id              int NOT NULL AUTO_INCREMENT,
       region_id            int NULL,
       state_id             int NULL,
       city                 varchar(100) NOT NULL,
       date_created         datetime NOT NULL,
       PRIMARY KEY (city_id)
)
ENGINE = InnoDB DEFAULT CHARSET=utf8;

CREATE UNIQUE INDEX city_pk ON city
(
       city_id
);

CREATE INDEX city_idx1 ON city
(
       state_id
);

CREATE INDEX city_idx2 ON city
(
       region_id
);



DROP TABLE IF EXISTS region;

CREATE TABLE region (
       region_id            int NOT NULL AUTO_INCREMENT,
       metro_id             int NOT NULL,
       state_id             int NULL,
       region               varchar(100) NOT NULL,
       date_created         datetime NOT NULL,
       PRIMARY KEY (region_id)
)
ENGINE = InnoDB DEFAULT CHARSET=utf8;

CREATE UNIQUE INDEX region_pk ON region
(
       region_id
);

CREATE INDEX region_idx1 ON region
(
       metro_id
);


DROP TABLE IF EXISTS metro;

CREATE TABLE metro (
       metro_id             int NOT NULL AUTO_INCREMENT,
       metro_name           varchar(100) NOT NULL,
       date_created         datetime NOT NULL,
       PRIMARY KEY (metro_id)
)
ENGINE = InnoDB DEFAULT CHARSET=utf8;


CREATE UNIQUE INDEX metro_pk ON metro
(
       metro_id
);



DROP TABLE IF EXISTS state;

CREATE TABLE state (
       state_id             int NOT NULL AUTO_INCREMENT,
       country_id           int NOT NULL,
       state                varchar(100) NOT NULL,
       date_created         datetime NOT NULL,
       PRIMARY KEY (state_id)
)
ENGINE = InnoDB DEFAULT CHARSET=utf8;

CREATE UNIQUE INDEX state_pk ON state
(
       state_id
);

CREATE INDEX state_idx1 ON state
(
       country_id
);


DROP TABLE IF EXISTS country;

CREATE TABLE country (
       country_id           int NOT NULL AUTO_INCREMENT,
       country              varchar(100) NOT NULL,
       date_created         datetime NOT NULL,
       PRIMARY KEY (country_id)
)
ENGINE = InnoDB DEFAULT CHARSET=utf8;


CREATE UNIQUE INDEX country_pk ON country
(
       country_id
);


DROP TABLE IF EXISTS address;

CREATE TABLE address (
       address_id           int NOT NULL AUTO_INCREMENT,
       user_id              int NULL,
       address1             varchar(255) NULL,
       address2             varchar(255) NULL,
       city                 varchar(100) NULL,
       state                varchar(100) NULL,
       country              varchar(100) NULL,
       zip                  varchar(20) NULL,
       intersection         varchar(255) NULL,
       lat                  float NULL,
       lon                  float NULL,
       date_created         datetime NOT NULL,
       PRIMARY KEY (address_id)
)
ENGINE = InnoDB DEFAULT CHARSET=utf8;

CREATE UNIQUE INDEX address_pk ON address
(
       address_id
);

CREATE INDEX address_idx1 ON address
(
       user_id
);


DROP TABLE IF EXISTS user_info;

CREATE TABLE user_info (
       user_id              int NOT NULL AUTO_INCREMENT,
       authentication_method_id int NOT NULL,
       first_name           varchar(100) NOT NULL,
       last_name            varchar(100) NOT NULL,
       email                varchar(255) NULL,
       password             varchar(30) NULL,
       phone                varchar(20) NULL,
       date_created         datetime NOT NULL,
       date_updated         datetime NOT NULL,
       PRIMARY KEY (user_id)
)
ENGINE = InnoDB DEFAULT CHARSET=utf8;

CREATE UNIQUE INDEX user_info_pk ON user_info
(
       user_id
);


CREATE INDEX user_info_idx2 ON user_info
(
       authentication_method_id
);


DROP TABLE IF EXISTS authentication_method;

CREATE TABLE authentication_method (
       authentication_method_id int NOT NULL AUTO_INCREMENT,
       authentication_method varchar(100) NOT NULL,
       date_created         datetime NOT NULL,
       PRIMARY KEY (authentication_method_id)
)
ENGINE = InnoDB DEFAULT CHARSET=utf8;


CREATE UNIQUE INDEX authentication_method_pk ON authentication_method
(
       authentication_method_id
);


ALTER TABLE address
       ADD FOREIGN KEY (user_id)
                             REFERENCES user_info (user_id);


ALTER TABLE user_info
       ADD FOREIGN KEY (authentication_method_id)
                             REFERENCES authentication_method (authentication_method_id);


ALTER TABLE state
       ADD FOREIGN KEY (country_id)
                             REFERENCES country (country_id);


ALTER TABLE region
       ADD FOREIGN KEY (metro_id)
                             REFERENCES metro (metro_id);


ALTER TABLE city
       ADD FOREIGN KEY (state_id)
                             REFERENCES state (state_id);


ALTER TABLE region
       ADD FOREIGN KEY (state_id)
                             REFERENCES state (state_id);