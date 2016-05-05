# Movie-Database-Website
An interactive website connected to a movie database, displaying info of (inserted) actor/movie/director, written by PHP and MySQL

This repository contains 10 PHP files and 2 SQL files:<br>
movie.php <br>
	-for the display of the website, dividing the website to two frames, left frame is shown by IndexFile.php, and right frame is shown by search.php.<br>
IndexFile.php<br>
	-showing and linking five input pages, two browsing pages and one search pages.<br>
search.php<br>
	-can search actor/movie and also link to actor and movie info.<br>
addActorDirector.php<br>
	-can add actor or director info.<br>
addMovie.php<br>
	-can add movie info.<br>
directorToMovie.php<br>
	-can add relation between existing director and existing movie.<br>
actorToMovie.php<br>
	-can add relation between existing actor and existing movie.<br>
showActorInfo.php<br>
	-can show actor's info and the movie he or she participated in.<br>
showMovieInfo.php<br>
	-can show movie's info and the actors who has participated in.<br>
review.php<br>
	-is embedded in movie info page, and can allow us to add review to any existing movie. <br>
Also, the error messages are presented, and if there is any box or selection not typed in or selected, error message will be shown and the insertion will not succeed.<br>

The sql folder contains 2 files: <br>
create.sql<br>
  -can create multiple tables with respective constraints.<br>
load.sql<br>
  -can load the database into the tables created by create.sql.<br>
