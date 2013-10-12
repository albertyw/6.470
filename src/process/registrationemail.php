<?php
/*
ADDRESS:	HTTP://ALBERTYW.MIT.EDU/6470/PROCESS/REGISTRATIONEMAIL.PHP
STATUS:		FINISHED
LAST MODIFIED:	JANUARY 13, 2009
DESCRIPTION:	QUERIES FROM REGISTER.PHP TO FIND COLLEGE DOMAIN
USAGE:		PUBLIC
*/
//Take college name from register.php
$college = $_POST['college'];

//Connect to mysql Database
$connection = mysql_connect("localhost", "6470", "6470") or die("mySQL Connection Error<br />\n");
$database='6470_main';
mysql_select_db($database) or die('Error, could not access database '.$database."\n");

//Find College
$result = mysql_query("SELECT * FROM college WHERE college='$college'") or die(mysql_error());
$row=mysql_fetch_array($result);
//Echo the website domain of the college
echo $row['emaildomain'];
?>
