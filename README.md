# Movie-Database-Website
An interactive website connected to a movie database, displaying info of (inserted) actor/movie/director, written by PHP and MySQL.<br>
This repository contains 10 PHP files and 2 SQL files:<br><br>
1.movie.php <br>
	-for the display of the website, dividing the website to two frames, left frame is shown by IndexFile.php, and right frame is shown by search.php.<br>
2.IndexFile.php<br>
	-showing and linking five input pages, two browsing pages and one search pages.<br>
3.search.php<br>
	-can search actor/movie and also link to actor and movie info.<br>
4.addActorDirector.php<br>
	-can add actor or director info.<br>
5.addMovie.php<br>
	-can add movie info.<br>
6.directorToMovie.php<br>
	-can add relation between existing director and existing movie.<br>
7.actorToMovie.php<br>
	-can add relation between existing actor and existing movie.<br>
8.showActorInfo.php<br>
	-can show actor's info and the movie he or she participated in.<br>
9.showMovieInfo.php<br>
	-can show movie's info and the actors who has participated in.<br>
10.review.php<br>
	-is embedded in movie info page, and can allow us to add review to any existing movie. <br><br>
Also, the error messages are presented, and if there is any box or selection not typed in or selected, error message will be shown and the insertion will not succeed.<br><br>

The sql folder contains 2 files: <br><br>
1.create.sql<br>
  -can create multiple tables with respective constraints.<br>
2.load.sql<br>
  -can load the database into the tables created by create.sql.<br>
