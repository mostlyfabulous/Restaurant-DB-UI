-- updated the size of notes in titles relation// Hazra

drop table manager;
-- cascade update from restaurant

drop table chef;
-- cascade update from restaurant

commit;

create table Employee(
    branchID CHAR(30);
    socialInsuranceNumber CHAR(9) UNIQUE,
    PRIMARY KEY (socialInsuranceNumber, branchID),
    FOREIGN KEY (branchID) REFERENCES Restaurant,
        ON DELETE NO ACTION
        ON UPDATE CASCADE
)

create table Manager(
	managerID CHAR(30),
    socialInsuranceNumber INTEGER UNIQUE,
    PRIMARY KEY (managerID),
    FOREIGN KEY (socialInsuranceNumber) REFERENCES Employee
    );

grant select on Manager to public;

create table Chef(
	chefID CHAR(30),
    SocialInsuranceNumber INTEGER UNIQUE,
    PRIMARY KEY (chefID),
    FOREIGN KEY (socialInsuranceNumber) REFERENCES Employee
    );
grant select on Chef to public;
commit;

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
values('B1234', '313312778');

insert into Employee
values('B1234', '313312228');

insert into Employee
values('B1234', '313312878');

insert into Employee
values('B1235', '978320817');

insert into Employee
values('B1233', '313312348');

insert into Manager
values('M4621', '123456789');

insert into Manager
values('M0167', '123456788');

insert into Manager
values('M4536', '412786555');

insert into Manager
values('M9817', '313312777');

insert into Chef
values('C3131', '313312778');

insert into Chef
values('C3132', '313312778');

insert into Chef
values('C3133', '313312228');

insert into Chef
values('C4372', '313312878');

insert into Chef
values('C5525', '978320817');

insert into Chef
values('C5450', '313312348');
/* 
insert into Manager
values('M4621', 'B1234', '123456789');

insert into Manager
values('M0167', 'B1235', '123456788');

insert into Manager
values('M4536', 'B1236', '412786555');

insert into Manager
values('M9817', 'B1237', '313312777');

insert into Chef
values('C3131', 'B1234', '313312778');

insert into Chef
values('C3132', 'B1234', '313312778');

insert into Chef
values('C3133', 'B1234', '313312228');

insert into Chef
values('C4372', 'B1234', '313312878');

insert into Chef
values('C5525', 'B1235', '978320817');

insert into Chef
values('C5450', 'B1233', '313312348'); */

commit;
