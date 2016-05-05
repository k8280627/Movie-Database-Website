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
$newMovie = "";
$titleErr = $yearErr= "";
$title = $year = $rating = $company = "";
if ($_SERVER["REQUEST_METHOD"] == "POST"){
	$company = $_POST["company"];
	$rating = $_POST["scroller"];

	if (empty($_POST["title"]) || ctype_space($_POST["title"])){
		$titleErr = "Title is required";
	}else{
		$title = trim($_POST["title"]); 
		#echo $title;
	}
	if (!empty($_POST["year"])){
		if ($_POST["year"] > date("Y") or $_POST["year"] < 1800){
		$yearErr =  "Invalid year, please insert a valid year";
		}else{
			$year = $_POST["year"];
		}
	}else{
		$year = $_POST["year"];
	}
	#check if movie exists
	#need to insert into Movie and MovieGenre;
	if (!empty($title)){
		$checkQuery = "select * from Movie where title = '$title' ";
		#echo $checkQuery;
		#echo "<br>";
		$checkResult = mysql_query($checkQuery,$db_connection);
		#echo mysql_num_rows($checkResult);
		#echo "<br>";
		if( 1){
			#mysql_num_rows($checkResult) == 0 ){
			#echo "result";
			#echo sql_num_rows($checkResult);
			#echo "New movie";
			#echo "<br>";
			$newMovie = "Thank you for adding a new movie information!";
			$maxIDQuery = "select * from MaxMovieID;";
			$maxIDResult = mysql_query($maxIDQuery,$db_connection);
			$maxMovieID = mysql_fetch_assoc($maxIDResult);
			$maxID = $maxMovieID['id'];
			
			$oldMaxID = $maxID;
			$newMaxID = $oldMaxID + 1;

			$deleteOldMaxIDQuery = "Delete from MaxMovieID where id = $oldMaxID";
			mysql_query($deleteOldMaxIDQuery, $db_connection) or die ('Error');
			$insertNewMaxIDQuery = "Insert into MaxMovieID values($newMaxID)";
			mysql_query($insertNewMaxIDQuery, $db_connection) or die ('Error');
			
			$insertMovieQuery = "Insert into Movie values($newMaxID,'$title','$year',
			'$rating','$company') "; 
			#echo $insertMovieQuery;
			#echo '<br>';

			$insertMovieResult = mysql_query($insertMovieQuery, $db_connection) or die ('Error');
			$newMovieQuery = "Select * from Movie where id = $newMaxID";
			$newMovieResult= mysql_query($newMovieQuery,$db_connection);
			$result = mysql_fetch_row( $newMovieResult);
			#echo $result[0];
			/*for ($i = 0; $i <= mysql_num_fields($newMovieResult); $i++){		
			echo $result[$i]." ";
			}*/
			#echo "<br>";
			###########################insert into MovieGenre;
			if (!empty($_POST['genre'])) {
				foreach($_POST['genre'] as $genre) {
		            #echo $genre; 
		            $insertMGQuery = "Insert into MovieGenre values($newMaxID, '$genre')" ;
		            #echo $insertMGQuery;
					$insertMGResult = mysql_query($insertMGQuery, $db_connection);
		    	}
			}
		}
		else{
			$newMovie =  "This movie already exists in our database, but thanks anyway:)!";

		}	
		

		
	}
}
?>
<font size="5" face="Georgia, Arial" color="maroon">
Please add a new movie to our website:
</font>
<p><span class="error">* required field.</span></p>
<form action = "<?php echo $_SERVER['PHP_SELF']; ?>" method = "POST">
Title: <input name = "title" type = "text" >
<span class="error">* <?php echo $titleErr;?></span>
<br>
Year(YYYY): <input name = "year" type = "date" maxlength="4">
<span class="error"> <?php echo $yearErr;?></span>
<br>
MPAA Rating: <SELECT NAME="scroller">
<OPTION>G
<OPTION>NC-17
<OPTION>PG
<OPTION>PG-13
<OPTION>R
<OPTION>Surrendere
</SELECT><br>
Company: <input name = "company" type = "text"><br>
Best suited genre: 
<input name = "genre[]" type = "checkbox" value = "Action">Action
<input name = "genre[]" type = "checkbox" value = "Adult">Adult
<input name = "genre[]" type = "checkbox" value = "Adventure">Adventure
<input name = "genre[]" type = "checkbox" value = "Animation">Animation
<input name = "genre[]" type = "checkbox" value = "Comedy">Comedy
<input name = "genre[]" type = "checkbox" value = "Crime">Crime
<input name = "genre[]" type = "checkbox" value = "Documentary">Documentary
<input name = "genre[]" type = "checkbox" value = "Drama">Drama
<input name = "genre[]" type = "checkbox" value = "Family">Family
<input name = "genre[]" type = "checkbox" value = "Fantasy">Fantasy
<input name = "genre[]" type = "checkbox" value = "Horror">Horror
<input name = "genre[]" type = "checkbox" value = "Musical">Musical
<input name = "genre[]" type = "checkbox" value = "Mystery">Mystery
<input name = "genre[]" type = "checkbox" value = "Romance">Romance
<input name = "genre[]" type = "checkbox" value = "Sci-Fi">Sci-Fi
<input name = "genre[]" type = "checkbox" value = "Short">Short
<input name = "genre[]" type = "checkbox" value = "Thriller">Thriller
<input name = "genre[]" type = "checkbox" value = "War">War
<input name = "genre[]" type = "checkbox" value = "Western">Western
<br>
<input value = "Submit" type = "submit"> 
<br></br>

<?php echo $newMovie;
?> 
<?php 
mysql_close($db_connection);
?>
</form>
</body>
</html>
