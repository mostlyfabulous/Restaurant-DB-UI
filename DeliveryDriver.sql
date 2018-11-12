-- updated the size of notes in titles relation// Hazra

drop table deliverydriver
-- has no dependencies

commit;

CREATE TABLE DeliveryDriver(
    driverID CHAR(30),
    PRIMARY KEY (driverId));
	 
grant select on DeliveryDriver to public;

commit;

insert into DeliveryDriver
values(D0001);

insert into DeliveryDriver
values(D0002);

insert into DeliveryDriver
values(D0003);

insert into DeliveryDriver
values(D0004);

insert into DeliveryDriver
values(D0005);

commit;
