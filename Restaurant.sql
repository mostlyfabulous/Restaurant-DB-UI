-- updated the size of notes in titles relation// Hazra

drop table restaurant;
-- has no dependencies

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
values('B1234', '6133 University Blvd', 'Vancouver', 'BC' 'V6T1Z1');

insert into Restaurant
values('B1235', '750 Hornby St', 'Vancouver', 'BC', 'V6Z2H7');

insert into Restaurant
values('B1236', '30 10 Ave SW', 'Calgary', 'AB', 'T2R0A9');

insert into Restaurant
values('B1237', '675 Belleville St', 'Victoria', 'BC', 'V8W9W2');

commit;
