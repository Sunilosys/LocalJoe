

DROP TABLE IF EXISTS index_run;

CREATE TABLE index_run (
       date_from    datetime NOT NULL,
       date_end     datetime NOT NULL
)
ENGINE = InnoDB DEFAULT CHARSET=utf8;

