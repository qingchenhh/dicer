create database pass;

create table data(
    id INT NOT NULL AUTO_INCREMENT,
    user VARCHAR(256) NOT NULL,
    pass VARCHAR(256) NOT NULL,
    PRIMARY KEY ( id )
);

create table mz(
     uid VARCHAR(256) NOT NULL,
     user VARCHAR(256) NOT NULL,
     pass VARCHAR(256) NOT NULL,
     date_time VARCHAR(256) NOT NULL
);

create user 'qingchen'@'localhost' identified by "T##$sT0201";
grant select,insert,delete,update on pass.* to 'qingchen'@'localhost';