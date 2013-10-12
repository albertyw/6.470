<?php
/*
ADDRESS:	HTTP://ALBERTYW.MIT.EDU/6470/EVENTSINGLECHANGEADDRESS.PHP
STATUS:		FINISHED
LAST MODIFIED:	JANUARY 28, 2009
DESCRIPTION:	SHOWS IN-DEPTH INFORMATION ABOUT A SINGLE EVENT
USAGE:		PUBLIC
*/
//Connect to mysql database
$connection = mysql_connect("localhost", "6470", "6470") or die("mySQL Connection Error<br />\n");
$database='6470_main';
mysql_select_db($database) or die('Error, could not access database '.$database."\n");

//Get Variables
$address1 = $_POST['address1'];
$address2 = $_POST['address2'];
$eventid = $_POST['eventid'];

//Store variables
mysql_query("UPDATE event SET address1='$address1'WHERE id='$eventid'") or die(mysql_error());
mysql_query("UPDATE event SET address2='$address2' WHERE id='$eventid'") or die(mysql_error());

echo '<span id="eventsingleaddress1">'.$address1.'</span><br />';
echo '<span id="eventsingleaddress2">'.$address2.'</span>';

?>
