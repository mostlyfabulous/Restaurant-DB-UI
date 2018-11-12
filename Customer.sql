-- updated the size of notes in titles relation// Hazra

drop table customer;
-- has no dependencies

commit;

CREATE TABLE Customer (
phoneNumber INTEGER,
address varchar(40),
city varchar(20),
province char(2),
postalCode varchar(6),
PRIMARY KEY (phoneNumber)

grant select on Customer to public;

commit;

insert into Customer
values('7783209817', '2350 Health Sciences Mall', 'Vancouver', 'BC',
    'V6T1Z3');

insert into Customer
values('7783334444', '2366 Main Mall', 'Vancouver', 'BC', 'V6T1Z4');

insert into Customer
values('7781112222', '800 Robson St', 'Vancouver', 'BC', 'V6Z3B7');

insert into Customer
values('7781113333', null, null, null, null);

insert into Customer
values('7781114444', null, null, null, null);

insert into Customer
values('7781115555', null, null, null, null);
commit;
