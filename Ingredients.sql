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
values('1235', 'Russet Potato', '60', '2018-12-13', '10', '313', '313' );

insert into IngredientsInStock
values('1234', 'Salt', '11', '2020-01-25', '10', '310', '310');

insert into IngredientsInStock
values('1234', 'Basamati Rice', '49', '2019-11-03', '5', '310', '310');

insert into IngredientsInStock
values('1234', 'Chickpeas', '9', '2019-09-21', '10', '310', '310');

insert into IngredientsInStock
values('1234', 'Apple', '99', '2018-12-10', '50', '313', '313');

insert into IngredientsInStock
values('1234', 'Egg', '273', '2018-12-02', '50', '313', '313');


insert into IngredientsToOrder
values('1234', 'Salt', '12', '150', '310');
 
insert into IngredientsToOrder
values('1234', 'Basamati Rice', '50','100', '310');

insert into IngredientsToOrder
values('1234', 'Ketchup', '12','100', '311');

insert into IngredientsToOrder
values('1234', 'Peanut Butter', '15','30', '310');

insert into IngredientsToOrder
values('1234', 'Chickpeas', '10','200', '310');

insert into IngredientsToOrder
values('1234', 'Bread Flour', '20','500', '310');

insert into IngredientsToOrder
values('1234', 'Butter', '80','100', '312');

insert into IngredientsToOrder
values('1234', 'Apple', '100','40', '313');

insert into IngredientsToOrder
values('1234', 'Whole Milk', '92','50', '312');

insert into IngredientsToOrder
values('1234', 'Chicken Thigh', '100','100', '314');

insert into IngredientsToOrder
values('1234', 'Russet Potato', '40','60', '313');

insert into IngredientsToOrder
values('1234', 'Egg', '274','100', '313');

insert into IngredientsToOrder
values('1235', 'Russet Potato', '61','60', '313');

insert into IngredientsToOrder
values('1235', 'Cake Flour', '13','60', '310');

insert into IngredientsToOrder
values('1235', 'Olive Oil', '15','80', '310');

commit;
