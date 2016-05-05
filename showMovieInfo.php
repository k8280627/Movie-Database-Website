<!DOCTYPE html>
<html style="font-family: serif">
<head>
</head>
<body bgcolor="f3fffe">
<?php
$servername = $_SERVER['SERVER_NAME'];
$username = "cs143";
$password = "";

// Create connection
$db_connection = mysql_connect($servername, $username, $password);

// Check connection
if ($db_connection->connect_error) {
    die("Connection failed: " . $db_connection->connect_error);
}
#echo "Connected successfully to database!";

/////Finish Connecting to MySQL/////
#still need to change to CS143 datbase!!!!!!
mysql_select_db("TEST",$db_connection);

?>
<?php
$mid = $_GET['mid'];
$mid = filter_var($mid, FILTER_SANITIZE_NUMBER_INT);
#echo $mid;
$movieQuery = "select * from Movie where id = $mid";
$movieResult = mysql_query($movieQuery,$db_connection);
$movie = mysql_fetch_array($movieResult);



if(empty($movie['company']) ){
	$movie['company'] = "x";
}
if(empty($movie['year']) ){
	$movie['year'] = "x";
}

$genreQuery = "select  * from MovieGenre where mid = $mid";
$genreResult = mysql_query($genreQuery,$db_connection);
$genre = mysql_fetch_array($genreResult);

?>
<font size="5" face="Georgia, Arial" color="maroon">
Here's the movie's info: </font><br><br>
<?php
echo "Title: <b>".$movie['title']."</b><br>";
echo "Company: ".$movie['company']."<br>";
echo "MPAA rating: ".$movie['rating']."<br>";

$MDQuery = "select * from MovieDirector where mid = $mid";
$MDResult = mysql_query($MDQuery,$db_connection);
echo "Director: ";
$i = 0;
if(mysql_num_rows($MDResult) == 0 ){
	$directorName = "x";
	echo $directorName;
}
while($MD = mysql_fetch_array($MDResult)){
	$directorQuery = "select * from Director where id = $did";
	$directorResult = mysql_query($directorQuery,$db_connection);
	$director = mysql_fetch_array($directorResult);
	$directorName = $director['first']." ".$director['last'];
	if ($i >= 1){
		echo ", ";
	}
	echo $directorName;
	$i = $i + 1;
}


echo "<br>";
$genreQuery = "select * from MovieGenre where mid = $mid";
$genreResult = mysql_query($genreQuery,$db_connection);
echo "Genre: ";
$j = 0;
if(mysql_num_rows($genreResult) == 0 ){
	$genreName = "x";
	echo $genreName;
}
while($genre = mysql_fetch_array($genreResult)){
	$genreName = $genre['genre'];
	if($j >=1){
		echo ", ";
	}
	echo $genreName;
	$j = $j + 1;
}
echo "<br><br>";
?>
<font size="5" face="Georgia, Arial" color="maroon">
Actors in this movie:</font><br><br>
<?php
$MRQuery = "select * from MovieActor where mid = $mid";
$MRResult = mysql_query($MRQuery,$db_connection);
#$MR = mysql_fetch_array($MRResult);
while($MR = mysql_fetch_array($MRResult)){
	if(empty($MR['role']) ){
		$MR['role'] = "unknown role";
	}
	$aid = $MR['aid'];	
	$actorQuery = "select * from Actor where id = $aid";
	$actorResult = mysql_query($actorQuery,$db_connection);
	$actor = mysql_fetch_array($actorResult);
	echo '<a href=showActorInfo.php?aid="'.$aid.'">'.$actor['first']." ".$actor['last'].'</a>'.' acted as '.$MR['role'].'<br>';
}
if (empty($aid)){
	echo "We don't have the info, or maybe you can update for us:)?<br>";
}
?>
<br>
<font size="5" face="Georgia, Arial" color="maroon">Reviews of this movie</font><br><br>
<?php
$reviewQuery = "select * from Review where mid = $mid";
$reviewResult = mysql_query($reviewQuery);
$avgQuery = "select avg(rating), count(rating) from Review where mid = $mid";
$avgResult = mysql_query($avgQuery);
$avgRating = mysql_fetch_array($avgResult);
$mid = filter_var($mid, FILTER_SANITIZE_NUMBER_INT);
if ($avgRating['avg(rating)'] ==NULL){
	$avgRating = 0;
	$avgRatingCount = 0;
}else{
	$avgRating = $avgRating['avg(rating)'];
	$avgRatingCount =$avgRating['count(rating)'];
}

echo "Average review score: ".$avgRating."/5 by ".$avgRatingCount." reviewers.";
echo '<a href=review.php?mid="'.$mid.'"> Why not write your own review?</a><br>';
echo "Here are the reviews:<br>";
while ($review = mysql_fetch_array($reviewResult)){
	echo "At ".$review['time']." reviewer ".$review['name']." rated ".$review['rating'].
	". Here's the comment:<br>".$review['comment']."<br><br>";

}
echo "______________________________________________________<br>";
?>
<font size="5" face="Georgia, Arial" color="maroon">
Search for other actors or movies?</font>
<br><br>
<form action = "./search.php" method = "POST">
Search:<input name = "search" type = "text">
<input type = "submit" value = "Go!">
<br></br>
<?php 
mysql_close($db_connection);
?>
</body>
</html>