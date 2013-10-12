<?php
//Open mySQL Connection
$connection = mysql_connect("localhost", "6470", "6470") or die("mySQL Connection Error<br />\n");
$database='6470_main';
mysql_select_db($database) or die('Error, could not access database '.$database."\n");

//Get Variables
$from = $_POST['from'];
$email = $_POST['email'];
$message = $_POST['message'];
include("/opt/lampp/htdocs/6470/include/phpxssfilter.php");
//Check variables
if($from != mysql_real_escape_string(htmlentities(RemoveXSS($from)))){
	$accept=false;
}
if($email != mysql_real_escape_string(htmlentities(RemoveXSS($email)))){
	$accept=false;
}
if($message != mysql_real_escape_string(htmlentities(RemoveXSS($message)))){
	$accept=false;
}

mysql_query("INSERT INTO contact
	(name, email, message)
	VALUES('$from', '$email', '$message') ")
	or die(mysql_error());

?>
