-- updated the size of notes in titles relation// Hazra

drop table Ingredients;
-- cascade update from supplier

drop table IngredientsInStock;
-- cascade update from supplier

drop table IngredientsToOrder;
-- cascade update from supplier

commit;

create table Ingredients
	(ingredientName CHAR(50),
	supplierID CHAR(30),
	primary key(ingredientName),
	foreign key (supplierID) references Supplier
		ON DELETE CASCADE);

create table IngredientsInStock
	(branchID CHAR(30),
    ingredientName CHAR(50),
    lotNumber INTEGER,
    expiryDate DATE,
		quantityLeft INTEGER,
		deliveryTime TIMESTAMP;
	primary key (ingredientName, lotNumber, branchID)
	foreign key (ingredientName) references Ingredients);
grant select on IngredientsInStock to public;

create table IngredientsToOrder
	(branchID CHAR(30),
	ingredientName CHAR(50),
	quantityToOrder INTEGER,
	primary key (ingredientName, branchID)
	foreign key (ingredientName) references Ingredients);

grant select on IngredientsToOrder to public;

commit;

insert into IngredientsToOrder
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
values('Chicken Thigh', 'S314');



insert into IngredientsInStock
values('B1234', 'Russet Potato', 60, '2018-12-13', 10, '2018-11-15 10:35:01', 'M4621');

insert into IngredientsInStock
values('B1234', 'Salt', 11, '2020-01-25', 10, '2018-08-10 11:12:13', 'M4621');

insert into IngredientsInStock
values('B1235', 'Basamati Rice', 9, '2019-11-03', 5, '2018-06-16 16:01:32', 'M0167');

insert into IngredientsInStock
values('B1235', 'Chickpeas', 9, '2019-09-21', 10, '2018-08-23 13:09:54', 'M0167');

insert into IngredientsInStock
values('B1234', 'Apple', 99, '2018-12-10', 50, '2018-11-22 09:44:25', 'M4621');

insert into IngredientsInStock
values('B1234', 'Egg', 273, '2018-12-02', 50, '2018-11-10 15:53:05', 'M4621');


insert into IngredientsToOrder
values('B1235', 'Salt', 12);

insert into IngredientsToOrder
values('B1235', 'Basamati Rice', 50);

insert into IngredientsToOrder
values('Ketchup', '12','100', 'S311');

insert into IngredientsToOrder
values('Peanut Butter', '15','30', 'S310');

insert into IngredientsToOrder
values('Chickpeas', '10','200', 'S310');

insert into IngredientsToOrder
values('Bread Flour', '20','500', 'S310');

insert into IngredientsToOrder
values('Butter', '80','100', 'S312');

insert into IngredientsToOrder
values('Apple', '100','40', 'S313');

insert into IngredientsToOrder
values('Whole Milk', '92','50', 'S312');

insert into IngredientsToOrder
values('Chicken Thigh', '100','100', 'S314');

insert into IngredientsToOrder
values('Russet Potato', '40','60', 'S313');

insert into IngredientsToOrder
values('Egg', '274','100', 'S313');

insert into IngredientsToOrder
values('Russet Potato', '61','60', 'S313');

insert into IngredientsToOrder
values('Cake Flour', '13','60', 'S310');

insert into IngredientsToOrder
values('Olive Oil', '15','80', 'S310');

commit;
