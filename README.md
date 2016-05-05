# Movie-Database-Website
An interactive website connected to a movie database, displaying info of (inserted) actor/movie/director, written by PHP and MySQL

This repository contains 10 PHP files and 2 SQL files:<br>
movie.php 
	-for the display of the website, dividing the website to two frames, left frame is shown by IndexFile.php, and right frame is shown by search.php.
IndexFile.php
	-showing and linking five input pages, two browsing pages and one search pages.
search.php
	-can search actor/movie and also link to actor and movie info.
addActorDirector.php
	-can add actor or director info.
addMovie.php
	-can add movie info.
directorToMovie.php
	-can add relation between existing director and existing movie.
actorToMovie.php
	-can add relation between existing actor and existing movie.
showActorInfo.php
	-can show actor's info and the movie he or she participated in.
showMovieInfo.php
	-can show movie's info and the actors who has participated in.
review.php
	-is embedded in movie info page, and can allow us to add review to any existing movie. 
Also, the error messages are presented, and if there is any box or selection not typed in or selected, error message will be shown and the insertion will not succeed.

The sql folder contains 2 files: 
create.sql
  -can create multiple tables with respective constraints.
load.sql
  -can load the database into the tables created by create.sql.
