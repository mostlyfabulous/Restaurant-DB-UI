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

CREATE TABLE MenuItem(
    menuItemID CHAR(30),
    itemName CHAR(30) NOT NULL,
	PRIMARY KEY (menuItemID)
	);
grant select on MenuItem to public;

commit;

insert into MenuItem;
values('001', 'Cobb Salad');

insert into MenuItem
values('002', 'Yam Fries');

insert into MenuItem
values('003', 'Tomato Soup');

insert into MenuItem
values('004', '');

commit;
