-- updated the size of notes in titles relation// Hazra

drop table MenuItem
-- cascade 

commit;

CREATE TABLE Supplier(
    supplierID CHAR(30), 
    bankAccountNo INTEGER, unique
    PRIMARY KEY (supplierID));
grant select on Supplier to public;

commit;

insert into Supplier;
values('S001', 100000000);

insert into Supplier;
values('S002', 543342111);

insert into Supplier
values('S003', 444333222);

insert into Supplier
values('S310', 333222111);

insert into Supplier
values('S311', 111222333);

insert into Supplier
values('S312', 222333444);

insert into Supplier
values('S313', 333444555);

insert into Supplier
values('S314', 444555666);
commit;
