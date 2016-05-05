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
function seoUrl($string) {
	$string = strtolower($string);
    //Make alphanumeric (removes all other characters)
    $string = preg_replace("/[^a-z0-9_\s-]/", "", $string);
    //Clean up multiple dashes or whitespaces
    $string = preg_replace("/[\s-]+/", " ", $string);
    //Convert whitespaces and underscore to dash
    #$string = preg_replace("/[\s_]/", "-", $string);
    $string = ucfirst($string);
    return $string;
}
?>
<font size="5" face="Georgia, Arial" color="maroon">
Search for actors or movies:</font>
<form action = "<?php echo $_SERVER['PHP_SELF']; ?>" method = "POST">
<p><span class="error"></span></p>
Search: <input name = "search" type = "text">
<input type = "submit" value = "Go!">

<?php
$inputErr = "";
$search = "";
#$searchResult = "";
if ($_SERVER["REQUEST_METHOD"] == "POST"){
	if (empty($_POST["search"]) || ctype_space($_POST["search"])){
		$inputErr = "You have to type something!";
	}else{
		$temp = trim($_POST["search"]);
		#echo $temp;
		$search = seoUrl($temp);
		#echo $search;
	}
	if (!empty($search)){
		#search in Actor
		#first+ " " + last
		$flPieces = explode(" ", $search);
		$first = $flPieces[0];
		$second = $flPieces[1];
		$flQuery = "select * from Actor where first like '%$first%' and last like '%$second%'";
		$flQueryResult = mysql_query($flQuery,$db_connection);
		echo "<br>";
		echo "Here are the results of '$search':<br></br>";
		while($row = mysql_fetch_assoc($flQueryResult)){
			echo 'Actor: <a href=showActorInfo.php?aid="'.$row['id'].'">'.$row['first']." ".$row['last'].'</a>'."(".$row['dob'].")<br>";
		}
		$lfQuery = "select * from Actor where first like '%$second%' and last like '%$first%'";
		$lfQueryResult = mysql_query($lfQuery,$db_connection);
		while($row = mysql_fetch_assoc($lfQueryResult)){
			echo 'Actor: <a href=showActorInfo.php?aid="'.$row['id'].'">'.$row['first']." ".$row['last'].'</a>'."(".$row['dob'].")<br>";
		}
		#search in Movie
		$movieQuery = "select * from Movie where title like '%$search%'";
		$movieQueryResult = mysql_query($movieQuery,$db_connection);
		while($row = mysql_fetch_assoc($movieQueryResult)){
			echo 'Movie: <a href=showMovieInfo.php?mid="'.$row['id'].'">'.$row['title'].'</a>'."(".$row['year'].")<br>";
		}
	}

}


/*
echo '<dd><a href="actor.php?
        fname='.$row['fname'].'">'.$row['fname'].'</a></dd>'; 
*/
?>
<?php 
mysql_close($db_connection);
?>
<span class="error"> <?php echo $inputErr;?></span>
<br>
</body>
</html>
