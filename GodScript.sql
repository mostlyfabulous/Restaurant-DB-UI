-- updated the size of notes in titles relation// Hazra

--//////////////////////////////////////////////////////////////////////////////
--
-- drop table transfers;
--
-- drop table location;
--



drop table places;

drop table ingredientorders;

drop table delivers;

drop table contains;

drop table ingredientsinstock;

drop table ingredients;

drop table supplier;

drop table homelessshelter;

drop table disposal;

--//////////////////////////////////////////////////////////////////////////////

drop table orderhas;
-- cascade update from orders, menuitem

drop table takeoutorder;
-- cascade update from Order, Restaurant, Customer, and DeliveryDriver

drop table pickuporder;
-- cascade update from Order, Restaurant, and Customer

drop table deliverydriver;
-- has no dependencies

drop table orders;

drop table menuitem;
-- cascade update from Restaurant

drop table chef;
-- cascade update from employee

drop table manager;
-- cascade update from employee

drop table employee;
-- cascade update from restaurant

drop table restaurant;
-- has no dependencies

drop table customer;
-- has no dependencies

commit;

CREATE TABLE Customer (
phoneNumber INTEGER,
address varchar(40),
city varchar(20),
province char(2),
postalCode varchar(6),
PRIMARY KEY (phoneNumber));
grant select on Customer to public;

create table Restaurant(
	branchID CHAR(30),
    address varchar(40) not null,
    city varchar(20) not null,
    province char(2) not null,
    postalCode varchar(6) not null,
	PRIMARY KEY (branchID));
grant select on Restaurant to public;
commit;

create table Employee(
    branchID CHAR(30),
    socialInsuranceNumber CHAR(9),
    PRIMARY KEY (socialInsuranceNumber),
    FOREIGN KEY (branchID) REFERENCES Restaurant
        ON DELETE CASCADE
);
grant select on Employee to public;

create table Manager(
	  managerID CHAR(30),
    socialInsuranceNumber CHAR(9),
    branchID CHAR(30),
    PRIMARY KEY (managerID),
    FOREIGN KEY (socialInsuranceNumber) REFERENCES Employee,
    FOREIGN KEY (branchID) REFERENCES Restaurant
    );
grant select on Manager to public;

create table Chef(
	chefID CHAR(30),
    SocialInsuranceNumber CHAR(9),
    branchID CHAR(30),
    PRIMARY KEY (chefID),
    FOREIGN KEY (socialInsuranceNumber) REFERENCES Employee,
    FOREIGN KEY (branchID) REFERENCES Restaurant
    );
commit;

CREATE TABLE MenuItem(
    menuItemID CHAR(30),
    itemName CHAR(30) NOT NULL,
    chefID CHAR(30),
    branchID CHAR(30),
	PRIMARY KEY (menuItemID, branchID),
    FOREIGN KEY (chefID) REFERENCES Chef,
    FOREIGN KEY (branchID) REFERENCES Restaurant
        on delete cascade);
grant select on MenuItem to public;

CREATE TABLE DeliveryDriver(
    driverID CHAR(30),
    PRIMARY KEY (driverID));
grant select on DeliveryDriver to public;
commit;

CREATE TABLE Orders(
    orderID CHAR(30) NOT NULL,
    PRIMARY KEY(orderID)
);
grant select on Orders to public;
commit;
CREATE TABLE TakeoutOrder(
    orderID CHAR(30),
    deliveryTime CHAR(10),
    address varchar(40) not null,
    city varchar(20) not null,
    province char(2) not null,
    postalCode varchar(6) not null,
    driverID CHAR(30),
    phoneNumber INTEGER,
    branchID CHAR(30),
    PRIMARY KEY (orderID),
    FOREIGN KEY (orderID) REFERENCES Orders
        ON DELETE CASCADE,
    FOREIGN KEY (branchID) REFERENCES Restaurant,
    FOREIGN KEY (phoneNumber) REFERENCES Customer,
    FOREIGN KEY (driverID) REFERENCES DeliveryDriver);

CREATE TABLE PickupOrder(
    orderID CHAR(30),
		PickUpTime CHAR(10),
    phoneNumber INTEGER,
    branchID CHAR(30),
    PRIMARY KEY (orderID),
    FOREIGN KEY (orderID) REFERENCES Orders
        ON DELETE CASCADE,
    FOREIGN KEY (branchID) REFERENCES Restaurant,
    FOREIGN KEY (phoneNumber) REFERENCES Customer);

CREATE TABLE OrderHas(
    orderID CHAR(30),
    menuItemID CHAR(30),
    branchID CHAR(30),
    PRIMARY KEY (orderID, menuItemID, branchID),
    FOREIGN KEY (orderID) REFERENCES Orders
        ON DELETE CASCADE,
    FOREIGN KEY (menuItemID, branchID) REFERENCES MenuItem
				ON DELETE CASCADE);
commit ;


--////////////////////////////////////////////////////////////////////////////////

CREATE TABLE Disposal (
phoneNumber INTEGER,
PRIMARY KEY (phoneNumber));
commit;

CREATE TABLE HomelessShelter (
phoneNumber INTEGER,
address varchar(40),
city varchar(20),
province char(2),
postalCode varchar(6),
PRIMARY KEY (phoneNumber));
commit;

CREATE TABLE Supplier(
  supplierID CHAR(30),
  bankAccountNo INTEGER,
  PRIMARY KEY (supplierID));

CREATE TABLE Ingredients (
	ingredientName CHAR(50),
	supplierID CHAR(30),
	PRIMARY KEY (ingredientName),
	FOREIGN KEY (supplierID) REFERENCES Supplier
		ON DELETE CASCADE);

CREATE TABLE IngredientsInStock(
		branchID CHAR(30),
    ingredientName CHAR(50),
    lotNumber INTEGER,
		expiryDate CHAR(10),
		quantityLeft INTEGER,
		managerID CHAR(30),
	PRIMARY KEY (ingredientName, lotNumber, branchID),
	FOREIGN KEY (ingredientName) REFERENCES Ingredients,
	FOREIGN KEY (managerID) REFERENCES Manager
);

CREATE TABLE Contains(
	menuItemID CHAR(30),
	branchID CHAR(30),
	ingredientName CHAR(50),
	quantityInGrams INTEGER,
	PRIMARY KEY (menuItemID, branchID, ingredientName),
	FOREIGN KEY (menuItemID, branchID) REFERENCES MenuItem
		ON DELETE CASCADE,
	FOREIGN KEY (ingredientName) REFERENCES Ingredients
);

CREATE TABLE Delivers(
    branchID CHAR(30),
		ingredientName CHAR(50),
    lotNumber INTEGER,
    supplierID CHAR(30),
		deliveryDate CHAR(10),
    PRIMARY KEY (branchID, ingredientName,lotNumber),
    FOREIGN KEY (ingredientName,lotNumber,branchID) REFERENCES IngredientsInStock,
    FOREIGN KEY (supplierID) REFERENCES Supplier);
commit ;

CREATE TABLE IngredientOrders(
    restockID CHAR(30),
		managerID CHAR(30),
    ingredienName CHAR(50),
    quantity INTEGER,
    PRIMARY KEY (restockID),
    FOREIGN KEY (managerID) REFERENCES Manager
        ON DELETE CASCADE);
commit ;

CREATE TABLE Places(
    restockID CHAR(30),
		supplierID CHAR(30),
    PRIMARY KEY (restockID,supplierID),
    FOREIGN KEY (restockID) REFERENCES IngredientOrders,
    FOREIGN KEY (supplierID) REFERENCES Supplier  );
commit ;

--////////////////////////////////////////////////////////////////////////////////

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


insert into Restaurant
values('B1234', '6133 University Blvd', 'Vancouver', 'BC', 'V6T1Z1');

insert into Restaurant
values('B1235', '750 Hornby St', 'Vancouver', 'BC', 'V6Z2H7');

insert into Restaurant
values('B1236', '30 10 Ave SW', 'Calgary', 'AB', 'T2R0A9');

insert into Restaurant
values('B1237', '675 Belleville St', 'Victoria', 'BC', 'V8W9W2');


insert into Employee
values('B1234', '123456789');

insert into Employee
values('B1235', '123456788');

insert into Employee
values('B1236', '412786555');

insert into Employee
values('B1237', '313312777');

insert into Employee
values('B1234', '313312778');

insert into Employee
values('B1234', '313312779');

insert into Employee
values('B1234', '313312228');

insert into Employee
values('B1234', '313312878');

insert into Employee
values('B1235', '978320817');

insert into Employee
values('B1236', '313312348');

insert into Manager
values('M4621', '123456789', 'B1234');

insert into Manager
values('M0167', '123456788', 'B1235');

insert into Manager
values('M4536', '412786555', 'B1236');

insert into Manager
values('M9817', '313312777', 'B1237');

insert into Chef
values('C3131', '313312778', 'B1234');

insert into Chef
values('C3132', '313312779', 'B1234');

insert into Chef
values('C3133', '313312228', 'B1234');

insert into Chef
values('C4372', '313312878', 'B1234');

insert into Chef
values('C5525', '978320817', 'B1235');

insert into Chef
values('C5450', '313312348', 'B1236');


insert into MenuItem
values('MI001', 'Cobb Salad', 'C3131', 'B1234');

insert into MenuItem
values('MI002', 'Yam Fries',  'C3131', 'B1234');

insert into MenuItem
values('MI003', 'Tomato Soup', 'C3132', 'B1234');

insert into MenuItem
values('MI004', 'Grilled Cheese', 'C3132', 'B1234');

insert into MenuItem
values('MI004', 'Grilled Cheese', 'C5525', 'B1235');

insert into MenuItem
values('MI004', 'Grilled Cheese', 'C5450', 'B1236');

insert into MenuItem
values('MI005', 'Mac and Cheese', 'C5450', 'B1236');

insert into MenuItem
values('MI005', 'Mac and Cheese', 'C3132', 'B1237');

insert into MenuItem
values('MI006', 'Garlic Bread', 'C3133', 'B1234');

insert into MenuItem
values('MI006', 'Garlic Bread', 'C5525', 'B1235');

insert into DeliveryDriver
values('D0001');

insert into DeliveryDriver
values('D0002');

insert into DeliveryDriver
values('D0003');

insert into DeliveryDriver
values('D0004');

insert into DeliveryDriver
values('D0005');


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
values('O000001', null, '2350 Health Sciences Mall', 'Vancouver', 'BC',
    'V6T1Z3', 'D0001', '7783209817', 'B1234');

insert into TakeoutOrder
values('O000002', '2018-12-02', '2350 Health Sciences Mall', 'Vancouver', 'BC',
    'V6T1Z3', 'D0002', '7783209817', 'B1234');

insert into TakeoutOrder
values('O000003', null, '6133 University Blvd', 'Vancouver', 'BC',
    'V6T1Z1', 'D0002', '7783334444', 'B1234');

insert into TakeoutOrder
values('O000004', '2018-12-02', '689 Thurlow St', 'Vancouver', 'BC',
    'V6E4M3', 'D0003', '7781112222', 'B1235');

insert into TakeoutOrder
values('O000005', '2018-12-02', '701 W Georgia St', 'Vancouver', 'BC',
    'V7Y1G5', 'D0003', '7781112222', 'B1235');

insert into PickupOrder
values('O000006', '2018-12-01', '7781113333', 'B1234');

insert into PickupOrder
values('O000007', '2018-12-01', '7781114444', 'B1234');

insert into PickupOrder
values('O000008', '2018-12-01', '7781115555', 'B1235');

insert into OrderHas
values('O000001', 'MI001', 'B1234');

insert into OrderHas
values('O000001', 'MI002', 'B1234');

insert into OrderHas
values('O000001', 'MI003', 'B1234');

insert into OrderHas
values('O000001', 'MI005', 'B1236');

insert into OrderHas
values('O000002', 'MI002', 'B1234');

insert into OrderHas
values('O000003', 'MI004', 'B1234');

insert into OrderHas
values('O000003', 'MI005', 'B1236');

insert into OrderHas
values('O000004', 'MI001', 'B1234');

insert into OrderHas
values('O000004', 'MI003', 'B1234');

insert into OrderHas
values('O000005', 'MI002', 'B1234');

insert into OrderHas
values('O000005', 'MI003', 'B1234');

insert into OrderHas
values('O000005', 'MI004', 'B1235');

insert into OrderHas
values('O000005', 'MI005', 'B1236');

insert into OrderHas
values('O000006', 'MI005', 'B1237');

insert into OrderHas
values('O000007', 'MI001', 'B1234');

insert into OrderHas
values('O000007', 'MI004', 'B1234');

insert into OrderHas
values('O000008', 'MI003', 'B1234');

--//////////////////////////////////DISPOSAL/////////////////////////////////////////////

insert into Disposal
values('7785598006');

insert into Disposal
values('7785558007');

insert into Disposal
values('7783397777');

insert into Disposal
values('7789870055');

insert into Disposal
values('7786258776');

----//////////////////////////////////HOMELESSSHELTER/////////////////////////////////////////////

insert into HomelessShelter
values('7786208716','2345 West 45th Ave', 'Vancouver', 'BC', 'V6T8X3');

insert into HomelessShelter
values('7786255481','5432 West 4rd Ave', 'Vancouver', 'BC', 'V6T1L9');

insert into HomelessShelter
values('7787840909','222 West Broadway', 'Vancouver', 'BC', 'V6T5T9');

insert into HomelessShelter
values('7786298004','204 Metrotown', 'Vancouver', 'BC', 'V6T9M3');

insert into HomelessShelter
values('7785388993','555 West Balsam', 'Vancouver', 'BC', 'V6T8N5');

----//////////////////////////////////SUPPLIER/////////////////////////////////////////////

insert into Supplier
values('S001', 100000000);

insert into Supplier
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

insert into Supplier
values('S315', 444555777);
commit;


----//////////////////////////////////INGREDIENTS/////////////////////////////////////////////
insert into Ingredients
values('Peanut Butter', 'S310');

insert into Ingredients
values('Salt', 'S310');

insert into Ingredients
values('Basamati Rice', 'S310');

insert into Ingredients
values('Chickpeas', 'S310');

insert into Ingredients
values('Bread Flour', 'S310');

insert into Ingredients
values('Cake Flour', 'S310');

insert into Ingredients
values('Olive Oil', 'S310');

insert into Ingredients
values('Ketchup', 'S311');

insert into Ingredients
values('Butter', 'S312');

insert into Ingredients
values('Whole Milk', 'S312');

insert into Ingredients
values('Russet Potato', 'S313');

insert into Ingredients
values('Apple', 'S313');

insert into Ingredients
values('Egg', 'S313');

insert into Ingredients
values('Garlic', 'S313');

insert into Ingredients
values('Chicken Thigh', 'S314');

insert into Ingredients
values('Bread', 'S315');


----//////////////////////////////////INGREDIENTSINSTOCK/////////////////////////////////////////////

insert into IngredientsInStock
values('B1234', 'Russet Potato', 60, '2018-12-13', 10, 'M4621');

insert into IngredientsInStock
values('B1234', 'Salt', 11, '2020-01-25', 10, 'M4621');

insert into IngredientsInStock
values('B1235', 'Basamati Rice', 8, '2019-11-03', 5, 'M0167');

insert into IngredientsInStock
values('B1235', 'Chickpeas', 9, '2019-09-21', 10, 'M0167');

insert into IngredientsInStock
values('B1234', 'Apple', 99, '2018-12-10', 50, 'M4621');

insert into IngredientsInStock
values('B1234', 'Egg', 273, '2018-12-02', 50, 'M4621');

insert into IngredientsInStock
values('B1234', 'Butter', 79, '2019-04-15', 50, 'M4621');

insert into IngredientsInStock
values('B1234', 'Garlic', 80, '2019-01-11', 50, 'M4621');

----//////////////////////////////////CONTAINS/////////////////////////////////////////////
insert into Contains
values('MI006', 'B1234', 'Garlic', 10);

insert into Contains
values('MI006', 'B1235', 'Salt', 2);

insert into Contains
values('MI006', 'B1235', 'Butter', 20);

insert into Contains
values('MI006', 'B1235', 'Bread', 100);

--/////////////////////////////////////DELIVERS//////////////////////////////////////////



insert into Delivers
values('B1234','Salt', 11, 'S311', '2018-12-25');

insert into Delivers
values('B1235','Basamati Rice', 8, 'S311', '2019-01-01');

insert into Delivers
values('B1235','Chickpeas', 9, 'S312','2019-02-21');

insert into Delivers
values('B1234','Egg', 273, 'S001','2018-12-22');

insert into Delivers
values('B1234','Butter',79, 'S002','2019-03-21');


--////////////////////////////////////INGREDIENTORDERS///////////////////////////////////////////



insert into IngredientOrders
values('R1234','M4621', 'Oliver Oil', 3);

insert into IngredientOrders
values('R1235','M0167', 'Ketchup', 10);

insert into IngredientOrders
values('R1236','M0167', 'Egg', 50);

insert into IngredientOrders
values('R5432','M4621', 'Butter', 20);

insert into IngredientOrders
values('R1237','M4621', 'Garlic', 60);

insert into IngredientOrders
values('R1238','M0167', 'Bread', 10);

insert into IngredientOrders
values('R1239','M0167', 'Chickpeas', 1);

insert into IngredientOrders
values('R1229','M4621', 'Basamati Rice', 13);


--////////////////////////////////////PLACES///////////////////////////////////////////


insert into Places
values('R1234','S001');

insert into Places
values('R1235','S001');

insert into Places
values('R1236','S001');

insert into Places
values('R5432','S312');

insert into Places
values('R1237','S002');

insert into Places
values('R1238','S003');

insert into Places
values('R1239','S312');

insert into Places
values('R1229','S312');



--///////////////////////////////////////////////////////////////////////////////
