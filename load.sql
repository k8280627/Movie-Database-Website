LOAD DATA LOCAL INFILE '~/data/movie.del' INTO TABLE Movie 
FIELDS TERMINATED BY ',' 
OPTIONALLY ENCLOSED BY '"';

load data local infile '~/data/actor1.del' into table Actor 
fields terminated by ',' 
optionally enclosed by '"';
load data local infile '~/data/actor2.del' into table Actor 
fields terminated by ',' 
optionally enclosed by '"';
load data local infile '~/data/actor3.del' into table Actor 
fields terminated by ',' 
optionally enclosed by '"';

load data local infile '~/data/sales.del' into table Sales 
fields terminated by ',';

load data local infile '~/data/director.del' into table Director
fields terminated by ',' 
optionally enclosed by '"';

load data local infile '~/data/moviegenre.del' into table MovieGenre 
fields terminated by ',' 
optionally enclosed by '"';

load data local infile '~/data/moviedirector.del' into table MovieDirector 
fields terminated by ',';

load data local infile '~/data/movieactor1.del' into table MovieActor 
fields terminated by ',' 
optionally enclosed by '"';
load data local infile '~/data/movieactor2.del' into table MovieActor 
fields terminated by ',' 
optionally enclosed by '"';

load data local infile '~/data/movierating.del' into table MovieRating 
fields terminated by ',';

Insert into MaxPersonID values(69000);
Insert into MaxMovieID values(4750);
