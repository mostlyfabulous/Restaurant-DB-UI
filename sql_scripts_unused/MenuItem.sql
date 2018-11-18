-- updated the size of notes in titles relation// Hazra

drop table MenuItem
-- cascade update from Restaurant

commit;

CREATE TABLE MenuItem(
    menuItemID CHAR(30),
    itemName CHAR(30) NOT NULL,
    chefID CHAR(30),
    branchID CHAR(30),
	PRIMARY KEY (menuItemID, branchID),
    FOREIGN KEY (chefID) REFERENCES Chef,
        on delete ;
        on update cascade;
    FOREIGN KEY (branchID) REFERENCES Restaurant,
        on delete cascade,
        on update cascade;
	);
grant select on MenuItem to public;

commit;

insert into MenuItem;
values('MI001', 'Cobb Salad', '3131', 'B1234');

insert into MenuItem
values('MI002', 'Yam Fries',  '3131', 'B1234');

insert into MenuItem
values('MI003', 'Tomato Soup', '3132', 'B1234');

insert into MenuItem
values('MI004', 'Grilled Cheese', '3132', 'B1234');

insert into MenuItem
values('MI004', 'Grilled Cheese', '3132', 'B1235');

insert into MenuItem
values('MI004', 'Grilled Cheese', '3132', 'B1236');

insert into MenuItem
values('MI005', 'Mac and Cheese', '3132', 'B1236');

insert into MenuItem
values('MI005', 'Mac and Cheese', '3132', 'B1237');
insert

commit;
