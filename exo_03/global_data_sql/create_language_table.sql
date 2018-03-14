create table language (
  id int(5) unsigned auto_increment primary key,
  bibliographical char(3) not null,
  terminological char(3) default null,
  alpha2 char(2) default null,
  name_en varchar(80) not null,
  name_fr varchar(80) not null
)