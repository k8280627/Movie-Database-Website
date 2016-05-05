<!DOCTYPE html>
<html style="font-family: serif">
<head>
<!--<link rel="stylesheet" type="text/css" href="style.css">-->
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
$dirErr = $movErr = "";
$director = $movie = "";
if ($_SERVER["REQUEST_METHOD"] == "POST"){
	if ($_POST["director"] == "Choose a director"){
		$dirErr = "Director is required";
	}else{
		$director = $_POST["director"];
	}
	if ($_POST["movie"] == "Choose a movie"){
		$movErr = "Movie is required";
	}else{
		$movie = $_POST["movie"];
	}
	if ($director != "Choose a director" and $director !="" and $movie != "Choose a movie" and $movie != "" ){
		#echo "Insert!";
		#echo "<br>";
		$directorPieces = explode(" ",$director); 
		$first = $directorPieces[0];
		$last = $directorPieces[1];

		$findDIDQuery = "select id from Director where first = '$first'and
		 last = '$last' ";
		 
		$findDIDResult = mysql_query($findDIDQuery,$db_connection) or die('Error');
		$DIDResult = mysql_fetch_assoc($findDIDResult);

		$DID = $DIDResult['id'];
		$moviePieces = explode(" (",$movie);
		$title = $moviePieces[0];
		$temp = explode(")",$moviePieces[1]);
		$year = $temp[0];

		$findMIDQuery = "select id from Movie where title = '$title' and year = $year";
		$findMIDResult = mysql_query($findMIDQuery,$db_connection) or die('Error');
		$MIDResult = mysql_fetch_assoc($findMIDResult);

		$MID = $MIDResult['id'];
		$checkMDQuery = "select * from MovieDirector where mid = $MID and did = $DID";
		$checkMDResult = mysql_query($checkMDQuery,$db_connection) or die('Error');
		if( mysql_num_rows($checkMDResult) == 0){

			$insertMDQuery = "Insert into MovieDirector values($MID, $DID)";
			$insertMDResult = mysql_query($insertMDQuery,$db_connection) or die('Error');
			$update =  "Updated! Thanks! :D";

		}else{
			$update = "We already have this update! Thanks anyway :)";
		}
	}
}
?>

<font size="5" face="Georgia, Arial" color="maroon">
Please add an director below to the movie(s) we have:</font>
<br>
<p><span class="error">* required field.</span></p>
<form action = "<?php echo $_SERVER['PHP_SELF']; ?>" method = "POST">

Director: <SELECT NAME="director">
<?php
	echo "<OPTION>Choose a director</OPTION>";
	$directorQuery = "select * from Director order by first";
	$directorResults = mysql_query($directorQuery,$db_connection);
	
	while ($row = mysql_fetch_array($directorResults)){		
		$nameDob = $row["first"]." ".$row["last"]." (".$row["dob"].")";
		#$id = $row["id"];
		#array_push(directorArray, array($row["id"], $nameDob));
		echo "<OPTION>".$nameDob."</OPTION>";
		
	}?>
</SELECT>
<span class="error"> * <?php echo $dirErr;?></span>
<br>
Movie: <SELECT NAME= "movie">
<?php
	echo "<OPTION>Choose a movie</OPTION>";
	$MovieQuery = "select * from Movie order by title";
	#echo $MovieQuery;
	$MovieResults = mysql_query($MovieQuery,$db_connection);

	while ($row = mysql_fetch_array($MovieResults)){
		$titleYear= $row["title"]. " (".$row["year"].")";
		#array_push($movieArray, array($row["id"],$titleYear));
		echo "<OPTION>".$titleYear."</OPTION>";
	}?>
</SELECT>
<span class="error"> * <?php echo $movErr;?></span>
<br></br>
<input value = "Submit" type = "submit"> 
<br></br>
<?php
	echo $update;
	?>

</body>
</html>
