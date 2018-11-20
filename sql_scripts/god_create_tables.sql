CREATE TABLE Customer (
phoneNumber INTEGER,
address varchar(40),
city varchar(20),
province char(2),
postalCode varchar(6),
PRIMARY KEY (phoneNumber),
CHECK (phoneNumber >= 0));
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
    FOREIGN KEY (driverID) REFERENCES DeliveryDriver,
		CHECK (phoneNumber >= 0));

CREATE TABLE PickupOrder(
    orderID CHAR(30),
		PickUpTime CHAR(10),
    phoneNumber INTEGER,
    branchID CHAR(30),
    PRIMARY KEY (orderID),
    FOREIGN KEY (orderID) REFERENCES Orders
        ON DELETE CASCADE,
    FOREIGN KEY (branchID) REFERENCES Restaurant,
    FOREIGN KEY (phoneNumber) REFERENCES Customer,
		CHECK (phoneNumber >= 0));

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

CREATE TABLE Location (
	phoneNumber INTEGER,
	PRIMARY KEY (phoneNumber),
	CHECK (phoneNumber >= 0));
	commit;

CREATE TABLE Disposal (
	phoneNumber INTEGER,
	PRIMARY KEY (phoneNumber),
	FOREIGN KEY (phoneNumber) REFERENCES Location,
	CHECK (phoneNumber >= 0));
	commit;

CREATE TABLE HomelessShelter (
	phoneNumber INTEGER,
	address varchar(40),
	city varchar(20),
	province char(2),
	postalCode varchar(6),
	PRIMARY KEY (phoneNumber),
	FOREIGN KEY (phoneNumber) REFERENCES Location,
	CHECK (phoneNumber >= 0));
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
	FOREIGN KEY (ingredientName) REFERENCES Ingredients
		ON DELETE CASCADE,
	FOREIGN KEY (managerID) REFERENCES Manager,
	CHECK (quantityLeft >= 0));

CREATE TABLE Transfers (
	phoneNumber INTEGER,
	branchID CHAR(30),
	ingredientName CHAR(50),
	lotNumber INTEGER,
	managerID CHAR(30),
	PRIMARY KEY (managerID,phoneNumber, branchID,ingredientName,lotNumber),
	FOREIGN KEY (phoneNumber) REFERENCES Location,
	FOREIGN KEY (ingredientName,lotNumber,branchID) REFERENCES IngredientsInStock
		ON DELETE CASCADE,
	FOREIGN KEY (managerID) REFERENCES Manager,
	CHECK (phoneNumber >= 0));
	commit;

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
    ingredientName CHAR(50),
    quantity INTEGER,
    PRIMARY KEY (restockID),
    FOREIGN KEY (managerID) REFERENCES Manager);
commit ;

CREATE TABLE Places(
    restockID CHAR(30),
		supplierID CHAR(30),
    PRIMARY KEY (restockID,supplierID),
    FOREIGN KEY (restockID) REFERENCES IngredientOrders,
    FOREIGN KEY (supplierID) REFERENCES Supplier  );
commit ;
