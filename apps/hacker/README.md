hack
================




###hack






##表结构
create database labs;
create table news(
    id int not null auto_increment primary key,
    title varchar(70) not null,
    news text not null
);
create table users(
    id int not null auto_increment primary key,
    username varchar(70) not null,
    password varchar(70) not null
);
