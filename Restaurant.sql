-- updated the size of notes in titles relation// Hazra

drop table salesdetails;
-- cascade delete from sales and titles

drop table sales;
-- has no dependencies

drop table titleditors;
-- cascade delete from editors and titles

drop table titleauthors;
-- cascade delete from authors and titles

drop table titles;
-- cascade delete from publishers

drop table publishers;
-- has no dependencies

drop table authors;
-- has no dependencies

drop table editors;
-- cascade delete for some of its own rows

commit;

create table Restaurant(
	branchID CHAR(30),
    address varchar(40) not null,
    city varchar(20) not null,
    province char(2) not null,
    postalCode varchar(6) not null,
	PRIMARY KEY (branchID));
	 
grant select on Restaurant to public;

commit;

insert into Restaurant
values('1234', '6133 University Blvd', 'Vancouver', 'BC' 'V6T1Z1');

insert into Restaurant
values('1235', '750 Hornby St', 'Vancouver', 'BC', 'V6Z2H7');

insert into Restaurant
values('1236', '30 10 Ave SW', 'Calgary', 'AB', 'T2R0A9');

insert into Restaurant
values('1237', '675 Belleville St', 'Victoria', 'BC', 'V8W9W2');

commit;
