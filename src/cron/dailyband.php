<?php
/*
ADDRESS:	HTTP://ALBERTYW.MIT.EDU/6470/CRON/BANDS.PHP
STATUS:		FINISHED
LAST MODIFIED:	JANUARY 21, 2009
DESCRIPTION:	THIS IS RUN EVERY DAY AND PICKS A NEW BAND
USAGE:		SERVER/HIDDEN
*/

//Open mySQL Connection
$connection = mysql_connect("localhost", "6470", "6470") or die("mySQL Connection Error<br />\n");
$database='6470_main';
mysql_select_db($database) or die('Error, could not access database '.$database."\n");

//Find out how many bands there are
$result = mysql_query("SELECT * FROM band") or die(mysql_error());
$numberofbands = mysql_num_rows($result);
//Select a random number (id) between 1 and the number of bands
$bandpicker = rand(1,$numberofbands);
//Set that random number as today's band
$result = mysql_query("UPDATE dailypicks SET pickid = '$bandpicker' WHERE picktype = 'bands'") or die(mysql_error());

?>
