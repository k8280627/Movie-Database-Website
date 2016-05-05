create table Movie(
	id int NOT NULL,
	title varchar(100) NOT NULL,
	year int, 
	rating varchar(10),
	company varchar(50),
	PRIMARY KEY(id)) ENGINE = INNODB;
/* id and title of a movie should not be null, and id is set as the primary key 
of the table*/
create table Actor(
	id int NOT NULL,
 	last varchar(20),
 	first varchar(20), 
 	sex varchar(6), 
 	dob DATE, 
 	dod DATE,
	PRIMARY KEY(id)) ENGINE = INNODB;
/*id should not be null, and it is set as the primary key of the table*/
create table Sales(
	mid int NOT NULL,
	ticketsSold int, 
	totalIncome int,
	FOREIGN KEY(mid) references Movie(id),
	CHECK (ticketsSold >= 0 AND totalIncome > ticketsSold)) ENGINE = INNODB;
/*mid should not be null, and it is set as foreign key refering from Movie(id).
Also, ticketsSold and totalIncome should be larger than 0 and totalIncome is 
larger than ticketsSold*/
create table Director(
	id int NOT NULL, 
	last varchar(20), 
	first varchar(20), 
	dob DATE, 
	dod DATE,
	PRIMARY KEY(id)) ENGINE = INNODB;
/*id should not be null and it is also the primary key of the table*/
create table MovieGenre(
	mid int, 
	genre varchar(20),
	FOREIGN KEY(mid) references Movie(id)) ENGINE = INNODB;
/**mid should not be null and it is a foreign key referring to Movie(id)*/
create table MovieDirector(
	mid int NOT NULL, 
	did int NOT NULL, 
	FOREIGN KEY(mid) references Movie(id),
	FOREIGN KEY(did) references Director(id)) ENGINE = INNODB;
/*mid and did should not be null and mid refers to Movie(id). did refers to Director(id) */
create table MovieActor(
	mid int NOT NULL, 
	aid int NOT NULL, 
	role varchar(50),
	FOREIGN KEY(mid) references Movie(id),
	FOREIGN KEY(aid) references Actor(id)) ENGINE = INNODB;
/*mid and aid should not be null and they both refer to Movie(id) and Actor(id)
respectively*/
create table MovieRating(
	mid int NOT NULL,
	imdb int, 
	rot int,
	CHECK ((imdb >= 0 AND imdb <= 100) AND (rot >= 0 AND rot <=100)),
	FOREIGN KEY(mid) references Movie(id)) ENGINE = INNODB;
/*mid should not be null and both imdb and rot should be within 0 and 100.
mid refers to Movie(id)*/
create table Review(
	name varchar(20), 
	time timestamp, 
	mid int NOT NULL, 
	rating int NOT NULL, 
	comment varchar(500),
	FOREIGN KEY(mid) references Movie(id),
	CHECK (rating >= 0)) ENGINE = INNODB;
/*mid and rating should not be null. mid refers to Movie(id). rating should be 
larger than 0*/
create table MaxPersonID(id int) ENGINE = INNODB;

create table MaxMovieID(id int) ENGINE = INNODB;
