
create database Piscine;
use Piscine;
ALTER DATABASE Piscine CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
create table Nageur(
	nom varchar(30),
	prenom varchar(30),
	sexe char(1),
	birth_date date,
	pays varchar(10),
	nom_club varchar(30),
	constraint Pk_Nageur primary key (nom,prenom,birth_date),
	groupe varchar(4) default null
);

create table Performance(
	temps time,
	lieu varchar(30),
	type_course varchar(30),
	taille_bassin integer(2),
	relay integer(1),
	age integer(2),
	pdate date,
	nom varchar(30),
	prenom varchar(30),
	birth_date date,
	saison int(4),
	foreign key fk_Nageur(nom,prenom,birth_date) references Nageur(nom,prenom,birth_date),
	constraint Pk_Performance primary key (nom,prenom,temps,pdate)
);

create table Club(
	idclub integer(12),
	nom_club varchar(30),
	constraint Pk_Club primary key (idclub)
);
