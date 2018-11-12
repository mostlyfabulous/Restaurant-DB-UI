-- updated the size of notes in titles relation// Hazra

drop table IngredientsInStock;
-- cascade update from supplier

drop table IngredientsToOrder;
-- cascade update from supplier

commit;

create table IngredientsInStock
	(branchID CHAR(30), not null
    ingredientName CHAR(50), not null
    lotNumber INTEGER, not null
    expiryDate CHAR(50),
	quantityLeft CHAR(30),
	select suppliedFromsupplierID from SUPPLIER,
	select deliversSupplierID from SUPPLIER,
	primary key (ingredientName, lotNumber, branchID)
	foreign key (suppliedFromsupplierID, deliversSupplierID) references Supplier,
		ON DELETE NO ACTION
		ON UPDATE CASCADE);
	 
grant select on IngredientsInStock to public;

create table IngredientsToOrder
	(branchID CHAR(30), not null
	ingredientName CHAR(50), not null
    lotNumber INTEGER, not null
	quantityToOrder CHAR(30),
	select suppliedFromsupplierID FROM SUPPLIER,
	primary key (ingredientName, lotNumber, branchID)
	foreign key (suppliedFromsupplierID) REFERENCES Supplier,
		ON DELETE NO ACTION
		ON UPDATE CASCADE );

grant select on IngredientsToOrder to public;

commit;

insert into IngredientsInStock
values('IS1235', 'Russet Potato', '60', '2018-12-13', '10', 'S313', 'S313' );

insert into IngredientsInStock
values('IS1234', 'Salt', '11', '2020-01-25', '10', 'S310', 'S310');

insert into IngredientsInStock
values('IS1234', 'Basamati Rice', '49', '2019-11-03', '5', 'S310', 'S310');

insert into IngredientsInStock
values('IS1234', 'Chickpeas', '9', '2019-09-21', '10', 'S310', 'S310');

insert into IngredientsInStock
values('IS1234', 'Apple', '99', '2018-12-10', '50', 'S313', 'S313');

insert into IngredientsInStock
values('IS1234', 'Egg', '273', '2018-12-02', '50', 'S313', 'S313');


insert into IngredientsToOrder
values('IO1234', 'Salt', '12', '150', 'S310');
 
insert into IngredientsToOrder
values('IO1234', 'Basamati Rice', '50','100', 'S310');

insert into IngredientsToOrder
values('IO1234', 'Ketchup', '12','100', 'S311');

insert into IngredientsToOrder
values('IO1234', 'Peanut Butter', '15','30', 'S310');

insert into IngredientsToOrder
values('IO1234', 'Chickpeas', '10','200', 'S310');

insert into IngredientsToOrder
values('IO1234', 'Bread Flour', '20','500', 'S310');

insert into IngredientsToOrder
values('IO1234', 'Butter', '80','100', 'S312');

insert into IngredientsToOrder
values('IO1234', 'Apple', '100','40', 'S313');

insert into IngredientsToOrder
values('IO1234', 'Whole Milk', '92','50', 'S312');

insert into IngredientsToOrder
values('IO1234', 'Chicken Thigh', '100','100', 'S314');

insert into IngredientsToOrder
values('IO1234', 'Russet Potato', '40','60', 'S313');

insert into IngredientsToOrder
values('IO1234', 'Egg', '274','100', 'S313');

insert into IngredientsToOrder
values('IO1235', 'Russet Potato', '61','60', 'S313');

insert into IngredientsToOrder
values('IO1235', 'Cake Flour', '13','60', 'S310');

insert into IngredientsToOrder
values('IO1235', 'Olive Oil', '15','80', 'S310');

commit;
