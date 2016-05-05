<!DOCTYPE html>
<html style="font-family: serif">
<head>
<style>
.error {color: #FF0000;}
</style>
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
$insert = "";
$movieErr = $ratingErr = "";
$name = $time = $movie = $rating = $comment = "";
if ($_SERVER["REQUEST_METHOD"] == "GET"){
	$mid = $_GET['mid'];
	$mid = filter_var($mid, FILTER_SANITIZE_NUMBER_INT);
	#echo $mid;

	$name = $_GET["userName"];
	$time = time();
	#echo $time;
	$comment = $_GET["comment"]; 
	if ($_GET["movie"] == "Choose a movie"){
		$movieErr = "Movie is required";
	}else{
		$movie = $_GET["movie"];
	}

	if (empty($_GET["rating"])){
		$ratingErr = "Rating is required";
	}else{
		$rating = $_GET["rating"];
	}

	if (!empty($movie) and !empty($rating)){
		$moviePieces = explode(" (",$movie);
		$title = $moviePieces[0];
		$temp = explode(")",$moviePieces[1]);
		$year = $temp[0];
		$findMIDQuery = "select id from Movie where title = '$title' and year = $year";
		$findMIDResult = mysql_query($findMIDQuery,$db_connection) or die('Error');
		$MIDResult = mysql_fetch_assoc($findMIDResult);
		$MID = $MIDResult['id'];

		$insertReviewQuery = "Insert into Review values('$name', FROM_UNIXTIME($time), $MID, '$rating','$comment')";
		#echo $insertReviewQuery;
		$insertReviewResult = mysql_query($insertReviewQuery,$db_connection) or die('Error');
		$insert =  "Inserted! Thanks :)";
		#echo $insert;
		#echo  "<br>";
	}

}
?>

<font size="5" face="Georgia, Arial" color="maroon">
Please give us more movie reviews!</font>
<form action = "./review.php" method = "GET">
<p><span class="error">* required field.</span></p>
Your name/nickname: <input name = "userName" type = "text">
<br>
<?php #echo "mid is ".$mid;
?>
Movie: <SELECT NAME= "movie">
<?php
	echo "<OPTION> Choose a movie </OPTION>";
	$MovieQuery = "select * from Movie order by title";
	#echo $MovieQuery;
	$MovieResults = mysql_query($MovieQuery,$db_connection);
	#$movieArray = array();
	#echo "<br>";
	#echo "num ".mysql_num_rows($MovieResults);
	while ($row = mysql_fetch_array($MovieResults)){
		$titleYear= $row["title"]. " (".$row["year"].")";
		#array_push($movieArray, array($row["id"],$titleYear));
		echo "<OPTION>".$titleYear."</OPTION>";
	}?>

</SELECT>
<span class="error">* <?php echo $movieErr;?></span>
<br>
Your rating(1-5): <input name = "rating" type = "number" min = 1 max = 5>
<span class="error">* <?php echo $ratingErr;?></span>
<br>
Your comment: <input name ="comment" type = "text">
<br>
<input value = "Submit!!" type = "submit"> 
<br>
<?php
echo $insert;
?>
</body>
</html>
