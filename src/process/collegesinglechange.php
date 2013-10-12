<?php
//Get Variables
$newvalue = $_POST['newName'];
$collegeid =$_POST['collegeID'];
$changewhat = $_POST['changeWhat'];

//Open mySQL Connection
$connection = mysql_connect("localhost", "6470", "6470") or die("mySQL Connection Error<br />\n");
$database='6470_main';
mysql_select_db($database) or die('Error, could not access database '.$database."\n");


//Find what column in database to change, check values
if($changeWhat=='changeDescription'){
	$column = 'description';
}
if($column==null || $column==''){
	die();
}
//Checking is finished, update the database
mysql_query("UPDATE college SET $column = '$newvalue' WHERE id = '$collegeid'") or die(mysql_error());
echo 'accept';
?>
