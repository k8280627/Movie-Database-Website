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
$idErr = $firstErr = $lastErr = $dobErr = $dodErr = "";
$update = "";
$identity = $first = $last = $sex = $dod = $dob = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {

	if (empty($_POST["identity"])){
		$idErr = "This is required!";
	}else{
		if ($_POST["identity"] == "Actor"){
			$identity = "Actor";
		}else{
			$identity = "Director";
		}
	}
	if (empty($_POST["first"]) || ctype_space($_POST["first"]) ){
		$firstErr = "First name is required!";
		#echo $firstErr;
	}else{
		$temp = trim($_POST["first"]);
		$first = seoUrl($temp);
		#echo $first;
	}
	if (empty($_POST["last"]) || ctype_space($_POST["last"]) ) {
		$lastErr = "Last name is required!";
	}else{
		$temp = trim($_POST["last"]);
		$last = seoUrl($temp);
	}
	$dob = $_POST["dob"];
	$dod = $_POST["dod"];
	if (!empty($dob)){
		$born = strtotime($dob);
		#echo $born;
		if ($born > time() or $born < -5333212800){
			$dobErr =  "Invalid date of birth";
		}
	}
	if (!empty($dod)){
		$die = strtotime($dob);
		#echo $die;
		if ($die > time() or $die < -5333212800){
			$dodErr = "invalid date of death";
			
		}
	}
	if (!empty($dob) and !empty($dod) ){
		$born = strtotime($dob);
		$die = strtotime($dod);
		if ($born > $die){
			$dodErr =  "Date of death earlier than date of birth, error!";
		}
	}
	#$identity = mysql_real_escape_string($_POST["identity"]);
	if ( !empty($identity) and !empty($first) and !empty($last) and empty($dodErr) and empty($dobErr) ){
		$sex = $_POST["sex"];
		

		$oldMaxID = 0;
		$newMaxID = 0;
		$maxPersonQuery= "SELECT * FROM MaxPersonID";
		$maxResult = mysql_query($maxPersonQuery, $db_connection);
		$maxPersonID = mysql_fetch_assoc($maxResult);
		$maxID = $maxPersonID['id'];
		#echo $maxID;		
		
		if ($_POST["identity"] == "Actor") {
			$check = sprintf("SELECT * FROM Actor WHERE last='%s' and first = '%s' 
			and sex = '%s';", $last, $first, $sex);
		}else{
			$check = sprintf("SELECT * FROM Director WHERE last='%s' and first = '%s' 
			and sex = '%s';", $last, $first, $sex);
		}

		$checkResult = mysql_query($check, $db_connection);
		#echo mysql_num_rows($checkResult); 
		if (mysql_num_rows($checkResult)==0 ){
			$update = sprintf("Added successfully to '%s'",$identity);
			#change maxID and insert!
			
			$oldMaxID = $maxID;
			$newMaxID = $oldMaxID + 1;

			#echo $maxID;
			#insert to maxPersonID and Actor/Director
			$deleteOldMaxIDQuery = "Delete from MaxPersonID where id = $oldMaxID";
			mysql_query($deleteOldMaxIDQuery, $db_connection) or die ('Error');

			$insertNewMaxIDQuery = "Insert into MaxPersonID values($newMaxID)";
			mysql_query($insertNewMaxIDQuery, $db_connection) or die ('Error');
			
			#insert into Actor or Director

			if ($_POST["identity"] == "Actor") {
			$insertADQuery= "Insert into $identity values($newMaxID, '$last', '$first',
			'$sex', '$dob', '$dod')";
			}else{
			$insertADQuery= "Insert into $identity values($newMaxID, '$last', '$first',
			 '$dob', '$dod')";
			}

			#echo $insertADQuery;
			#echo '<br>';
			mysql_query($insertADQuery, $db_connection) or die ('Error');

			#print new inserted ID and Add-on
			$newIDResults= mysql_query($maxPersonQuery, $db_connection) or die('Error');
			$nrow = mysql_fetch_assoc($newIDResults);
			#echo "New id is ".$nrow['id'];
			
			$newAddQuery = "SELECT * FROM $identity WHERE id = $newMaxID";
			$newAddResults= mysql_query($newAddQuery,$db_connection);
			#echo "New added info is: ";
			$result = "";
			$result = mysql_fetch_row( $newAddResults);
			#echo $result[0];
			/*for ($i = 0; $i <= mysql_num_fields($newAddResults); $i++){		
			echo $result[$i]." ";
			}*/
		}elseif (mysql_num_rows($checkResult)!=0 ){
			$update =  sprintf("This '%s' exists already!",$identity);
			#echo $check;
		}
	}
}?>
<?php
function seoUrl($string) {
    //Lower case everything
    $string = strtolower($string);
    //Make alphanumeric (removes all other characters)
    $string = preg_replace("/[^a-z0-9_\s-]/", "", $string);
    //Clean up multiple dashes or whitespaces
    $string = preg_replace("/[\s-]+/", " ", $string);
    //Convert whitespaces and underscore to dash
    $string = preg_replace("/[\s_]/", "-", $string);
    $string = ucfirst($string);
    return $string;
}
?>
<font size="5" face="Georgia, Arial" color="maroon">
Please add a new actor or director to our website:</font>
<br>
<p><span class="error">* required field.</span></p>
<form action = "./addActorDirector.php" method = "POST">
Who do you want to add:
<input name = "identity" value = "Actor"  checked type = "radio"></input>
Actor
<input name = "identity" value = "Director" type = "radio"></input>
Director
<span class="error"> * <?php echo $idErr;?></span>
<br></br>
First Name: <input name = "first" type = "text" >
<span class="error"> * <?php echo $firstErr;?></span>
<br>
Last Name: <input name = "last" type = "text" >
<span class="error"> * <?php echo $lastErr;?></span>
<br>
Sex: 
<input name = "sex" value = "Male" checked = "true" type = "radio"></input>
Male
<input name = "sex" value = "Female" type = "radio"></input>
Female
<br>
Date of Birth(YYYY/MM/DD): <input name = "dob" type = "date">
<span class="error"> <?php echo $dobErr;?></span>
<br>
Date of Death(YYYY/MM/DD): <input name = "dod" type = "date">
<span class="error"> <?php echo $dodErr;?></span>
<br>
<input value = "Submit" type = "submit"><br>

</html>
<?php
echo $update;
mysql_close($db_connection);
?>
</body>
</html>