CREATE DATABASE dental;
USE dental;
create table line(
	no int
);

insert into line values ('0');

ALTER TABLE line
ADD ischange int;

create table patient(
	no int,
	reg int,
	start time,
	stop time);

ALTER TABLE line
ADD patient_count int,
ADD patient_avg int;

DELIMITER $$

CREATE  PROCEDURE avg_time (IN `dif` INT)  
begin
		SET @count := (select patient_count from line);
		update line set patient_avg = (patient_avg * @count + dif)/(@count+1);
		update line set patient_count = patient_count + 1;
end$$

DELIMITER ;

update line set patient_count = 10,patient_avg = 5;


create table doctor (
	user_name varchar(50),
	pwd varchar(50),
	last_update DATETIME,
	patient_num int,
	online int
);

insert into doctor values('shehan','123','null','0','0');

ALTER TABLE patient
drop start,
drop stop;

update line set no = 0;

insert into patient values ('2','521'),('3','565'),('4','654'),('5','546'),('6','688'),('7','568'),('8','986'),('9','231'),('10','216');

insert into doctor values ('shan','123','null','null','0');

insert into patient values ('11','001'),('12','021'),('13','065'),('14','054'),('15','046'),('16','088'),('17','168'),('18','086'),('19','232'),('20','226');

ALTER TABLE line
ADD last_patient_time DATETIME;