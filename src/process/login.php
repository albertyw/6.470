<?php
/*
ADDRESS:	HTTP://ALBERTYW.MIT.EDU/6470/PROCESS/LOGIN.PHP
STATUS:		UNFINISHED
LAST MODIFIED:	JANUARY 11, 2008 BY ALBERT WANG
DESCRIPTION:	TAKES JSON LOGIN INFO AND CHECKS TO SEE IF ITS CORRECT
USAGE:		HIDDEN
*/


header("Cache-Control: no-cache");
//header("Content-Type: text/x-json");

//Recieve JSON Variables
$username=$_POST['username'];
$password=$_POST['password'];

//Connect to Database
$connection = mysql_connect("localhost", "6470", "6470") or die("mySQL Connection Error<br />\n");
$database='6470_main';
mysql_select_db($database) or die('Error, could not access database '.$database."\n");

//Do the login processing here
$result = mysql_query("SELECT * FROM user
 WHERE username='$username'") or die(mysql_error());
$row=mysql_fetch_array($result);
if($row['password']==$password && $row['username']!=null && $row['username']!=''){
	echo '{"login":true}';
}else{
	echo '{"login":false}';
}

//If correct, redirect to profile.php

//If incorrect, redirect to index.php

?>









<?php
//FUNCTIONS IN HERE

?>
