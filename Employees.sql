-- updated the size of notes in titles relation// Hazra

drop table manager;
-- cascade update from restaurant

drop table chef;
-- cascade update from restaurant

commit;

create table Manager(
	managerID CHAR(30), 
    branchID CHAR(30), 
    socialInsuranceNumber INTEGER UNIQUE,
    PRIMARY KEY (managerID),
    FOREIGN KEY (branchID) REFERENCES Restaurant,
        ON DELETE NO ACTION
        ON UPDATE CASCADE);

grant select on Manager to public;

create table Chef(
	chefID CHAR(30), 
    branchID CHAR(30), 
    SocialInsuranceNumber INTEGER UNIQUE,
    PRIMARY KEY (managerID),
    FOREIGN KEY (branchID) REFERENCES Restaurant,
        ON DELETE NO ACTION
        ON UPDATE CASCADE);

grant select on Chef to public;
commit;

insert into Manager
values('4621', '1234', '123456789');

insert into Manager
values('0167', '1235', '123456788');

insert into Manager
values('4536', '1236', '412786555');

insert into Manager
values('9817', '1237', '313312777');

insert into Chef
values('3131', '1234', '313312778');

insert into Chef
values('3132', '1234', '313312778');

insert into Chef
values('3133', '1234', '313312228');

insert into Chef
values('4372', '1234', '313312878');

insert into Chef
values('5525', '1235', '978320817');

insert into Chef
values('5450', '1233', '313312348');

commit;
