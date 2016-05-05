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
$actorErr = $movieErr = "";
$actor = $movie = $role = "";
$role = $_POST["Role"];
$actorID = $movieID = 0;
$update = "";
if ($_SERVER["REQUEST_METHOD"] == "POST"){
	if ($_POST["actor"] == "Choose an actor"){
		$actorErr = "Actor is required";
	}else{
		$actor = ($_POST["actor"]);
	}
	if ($_POST["movie"] == "Choose a movie"){
		$movieErr = "Movie is required";
	}else{
		$movie = ($_POST["movie"]);
	}
	if (empty($movieErr) and empty($actorErr)){
		#$actor = $_POST["Actor"]; #format: first last (dob)
		#$movie = $_POST["Movie"]; #format: title (year)
		#echo "actorarray is".$actorArray;
		#echo $actor;
		#echo "<br>";
		$actorPieces = explode(" ",$actor); 
		$first = $actorPieces[0];
		$last = $actorPieces[1]; 
		$findAIDQuery = "select id from Actor where first = '$first'and
		 last = '$last' ";
		 #echo $findAIDQuery;
		 #echo "<br>";
		$findAIDResult = mysql_query($findAIDQuery,$db_connection) or die('Error');
		$AIDResult = mysql_fetch_assoc($findAIDResult);
		#echo "num of row is".mysql_num_rows($findAIDResult);
		#echo "<br>";
		#echo "Aid is ".$AIDResult['id']; 		 
		#echo "<br>";
		$AID = $AIDResult['id'];

		#echo $movie;
		$moviePieces = explode(" (",$movie);
		$title = $moviePieces[0];
		$temp = explode(")",$moviePieces[1]);
		$year = $temp[0];
		#echo $title;
		#echo $year;
		#echo "<br>";
		$findMIDQuery = "select id from Movie where title = '$title' and year = $year";
		$findMIDResult = mysql_query($findMIDQuery,$db_connection) or die('Error');
		$MIDResult = mysql_fetch_assoc($findMIDResult);
		#echo "num of row is".mysql_num_rows($findMIDResult);
		#echo "Mid is ".$MIDResult['id'];
		#echo "<br>";
		$MID = $MIDResult['id'];
		$checkAMQuery = "select * from MovieActor where mid = $MID and aid = $AID and role = '$role'";
		$checkAMResult = mysql_query($checkAMQuery,$db_connection) or die('Error');
		if( mysql_num_rows($checkAMResult) == 0){

			$insertAMQuery = "Insert into MovieActor values($MID, $AID, '$role')";
			$insertAMResult = mysql_query($insertAMQuery,$db_connection) or die('Error');
			$update =  "Updated! Thanks! :D";

		}else{
			$update = "We already have this update! Thanks anyway :)";
		}
	}
}

?>
<font size="5" face="Georgia, Arial" color="maroon">
Please add an actor below to the movie(s) we have:
</font>
<br>
<p><span class="error">* required field.</span></p>
<form action = "<?php echo $_SERVER['PHP_SELF']; ?>" method = "POST">
Actor: <SELECT NAME="actor">
<?php
	echo "<OPTION> Choose an actor </OPTION>";
	$ActorQuery = "select * from Actor order by first";
	$ActorResults = mysql_query($ActorQuery,$db_connection);
	#echo "<br>";
	#echo "num ".mysql_num_rows($ActorResults);
	#$actorArray = array();
	#array_push($actorArray, array("apple","Banana"), array("app","Ban"));
	#echo ($actorArray[0][1]);
	#echo "<br>";
	#echo $actorArray[1][0];
	
	while ($row = mysql_fetch_array($ActorResults)){		
		$nameDob = $row["first"]." ".$row["last"]." (".$row["dob"].")";
		#$id = $row["id"];
		#array_push($actorArray, array($row["id"], $nameDob));
		echo "<OPTION>".$nameDob."</OPTION>";
		
	}?>
</SELECT>
<span class="error"> * <?php echo $actorErr;?></span>
<br>
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
<span class="error"> * <?php echo $movieErr;?></span>
<br>
Role: <input name = "Role" type = "text">
<br>
<input value = "Submit" type = "submit"> 
<br></br>
<?php
	echo $update;
?>

</form>
</body>
</html>
