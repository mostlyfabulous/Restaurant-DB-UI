
drop table places;

drop table ingredientorders;

drop table delivers;

drop table contains;

drop table transfers;

drop table ingredientsinstock;

drop table ingredients;

drop table supplier;

drop table homelessshelter;

drop table disposal;

drop table location;

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
