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
$aid = $_GET['aid'];
$actorQuery = "select * from Actor where id = $aid";
$actorResult = mysql_query($actorQuery,$db_connection);
$actor = mysql_fetch_array($actorResult);

if(empty($actor['sex']) ){
	$actor['sex'] = "x";
}
if(empty($actor['dob']) ){
	$actor['dob'] = "x";
}
if(empty($actor['dod']) ){
	$actor['dod'] = "x";
}
?>
<font size="5" face="Georgia, Arial" color="maroon">
Here's the actor's info:</font>
<br><br>
<?php
echo "Name: <b>".$actor['first']." ".$actor['last']."</b><br>";
echo "Sex: ".$actor['sex']."<br>";
echo "Date of birth: ".$actor['dob']."<br>";
echo "Date of death: ". $actor['dod']."<br><br><br>";?>
<font size="5" face="Georgia, Arial" color="maroon">
The actor acted in: </font>
<br></br>
<?php
$MRQuery = "select * from MovieActor where aid = $aid";
$MRResult = mysql_query($MRQuery,$db_connection);
while($MR = mysql_fetch_array($MRResult)){
	if(empty($MR['role']) ){
		$MR['role'] = "unknown role";
	}
	$mid = $MR['mid'];
	$movieQuery = "select * from Movie where id = $mid";
	$movieResult = mysql_query($movieQuery,$db_connection);
	$movie = mysql_fetch_array($movieResult);
	echo 'Acted <b> '.$MR['role'].' </b> in <a href=showMovieInfo.php?mid="'.$mid.'">'.$movie['title'].'</a>('.$movie['year'].')<br>';
}
echo "______________________________________________________<br>";
?>
<font size="5" face="Georgia, Arial" color="maroon">
Search for other actors or movies?</font>
<br>
<form action = "./search.php" method = "POST">
Search:<input name = "search" type = "text">
<input type = "submit" value = "Go!">

<?php 
mysql_close($db_connection);
?>
</body>
</html>