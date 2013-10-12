<?php
/*
ADDRESS:	HTTP://ALBERTYW.MIT.EDU/6470/CRON/MUSIC.PHP
STATUS:		FINISHED
LAST MODIFIED:	JANUARY 23, 2009
DESCRIPTION:	THIS IS RUN EVERY DAY AND PICKS A NEW BAND
USAGE:		SERVER/HIDDEN
*/

//Open mySQL Connection
$connection = mysql_connect("localhost", "6470", "6470") or die("mySQL Connection Error<br />\n");
$database='6470_main';
mysql_select_db($database) or die('Error, could not access database '.$database."\n");

//Find out how many bands there are
$result = mysql_query("SELECT * FROM music") or die(mysql_error());
$numberofmusic = mysql_num_rows($result);
//Select a random number (id) between 1 and the number of bands
$musicpicker = rand(1,$numberofmusic);
//Set that random number as today's band
$result = mysql_query("UPDATE dailypicks SET pickid = '$musicpicker' WHERE picktype = 'music'") or die(mysql_error());

?>
