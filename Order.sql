-- updated the size of notes in titles relation// Hazra

drop table orders;
-- no dependencies

drop table pickuporder;
-- cascade update from Order, Restaurant, and Customer

drop table takeoutorder;
-- cascade update from Order, Restaurant, Customer, and DeliveryDriver

drop table orderhas;
-- cascade update from orders, menuitem
commit;

CREATE TABLE Orders(
    orderID CHAR(30) NOT NULL,
    PRIMARY KEY(orderID)
);

CREATE TABLE TakeoutOrder(
    orderID CHAR(30),
    deliveryTime DATETIME,
    address varchar(40) not null,
    city varchar(20) not null,
    province char(2) not null,
    postalCode varchar(6) not null,
    driverID CHAR(30),
    phoneNumber INTEGER,
    branchID CHAR(30),
    PRIMARY KEY (orderID),
    FOREIGN KEY (orderID) REFERENCES Orders
        ON DELETE CASCADE
        ON UPDATE CASCADE ,
    FOREIGN KEY (branchID) REFERENCES Restaurant
        ON DELETE NO ACTION
        ON UPDATE CASCADE,
    FOREIGN KEY (phoneNumber) REFERENCES Customer
        ON DELETE NO ACTION
        ON UPDATE CASCADE,
    FOREIGN KEY (driverID) REFERENCES DeliveryDriver
        ON DELETE NO ACTION
        ON UPDATE CASCADE);
grant select on TakeoutOrder to public;

CREATE TABLE PickupOrder(
    PickUpTime DATETIME NOT NULL,
    orderID CHAR(30),
    phoneNumber INTEGER,
    branchID CHAR(30),
    PRIMARY KEY (orderID),
    FOREIGN KEY (orderID) REFERENCES Orders
        ON DELETE CASCADE
        ON UPDATE CASCADE ,
    FOREIGN KEY (branchID) REFERENCES Restaurant
        ON DELETE NO ACTION
        ON UPDATE CASCADE,
    FOREIGN KEY (phoneNumber) REFERENCES Customer
        ON DELETE NO ACTION
        ON UPDATE CASCADE);
grant select on PickupOrder to public;

CREATE TABLE OrderHas(
    orderID CHAR(30),
    menuItemID CHAR(30),
    PRIMARY KEY (orderID, menuItemID),
    FOREIGN KEY (orderID) REFERENCES Orders
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    FOREIGN KEY (menuItemID) REFERENCES MenuItem
    ON DELETE CASCADE
    ON UPDATE CASCADE);
grant select on OrderHas to public;
commit;

insert into Orders
values('O000001');

insert into Orders
values('O000002');

insert into Orders
values('O000003');

insert into Orders
values('O000004');

insert into Orders
values('O000005');

insert into Orders
values('O000006');

insert into Orders
values('O000007');

insert into Orders
values('O000008');

insert into TakeoutOrder
values('O000001', '2018-12-01 15:45:21', '2350 Health Sciences Mall', 'Vancouver', 'BC',
    'V6T1Z3', 'D0001', '7783209817', 'B1234');

insert into TakeoutOrder
values('O000002', '2018-12-02 09:47:15', '2350 Health Sciences Mall', 'Vancouver', 'BC',
    'V6T1Z3', 'D0002', '7783209817', 'B1234');

insert into TakeoutOrder
values('O000003', '2018-12-02 11:06:10', '6133 University Blvd', 'Vancouver', 'BC',
    'V6T1Z1', 'D0002', '7783334444', 'B1234');

insert into TakeoutOrder
values('O000004', '2018-12-02 11:47:05', '689 Thurlow St', 'Vancouver', 'BC', 
    'V6E 4M3', 'D0003', '7781112222', 'B1235');

insert into TakeoutOrder
values('O000005', '2018-12-02 10:02:27', '701 W Georgia St', 'Vancouver', 'BC',
    'V7Y1G5', 'D0003', '7781112222', 'B1235');

insert into PickupOrder
values('O000006', '2018-12-01 12:10:10', '7781113333', 'B1234');

insert into PickupOrder
values('O000007', '2018-12-01 12:31:10', '7781114444', 'B1234');

insert into PickupOrder
values('O000008', '2018-12-01 13:10:10', '7781115555', 'B1235');

insert into OrderHas
values('O000001', 'MI001');

insert into OrderHas
values('O000001', 'MI002');

insert into OrderHas
values('O000001', 'MI003');

insert into OrderHas
values('O000002', 'MI002');

insert into OrderHas
values('O000003', 'MI004');

insert into OrderHas
values('O000003', 'MI005');

insert into OrderHas
values('O000004', 'MI001');

insert into OrderHas
values('O000004', 'MI003');

insert into OrderHas
values('O000005', 'MI002');

insert into OrderHas
values('O000005', 'MI003');

insert into OrderHas
values('O000005', 'MI004');

insert into OrderHas
values('O000005', 'MI005');

insert into OrderHas
values('O000006', 'MI005');

insert into OrderHas
values('O000007', 'MI001');

insert into OrderHas
values('O000007', 'MI004');

insert into OrderHas
values('O000008', 'MI003');

insert into OrderHas
values('O000001', 'MI005');
