<?php
/*
ADDRESS:	HTTP://ALBERTYW.MIT.EDU/6470/CRON/DAILYEVENT.PHP
STATUS:		FINISHED
LAST MODIFIED:	JANUARY 28, 2009
DESCRIPTION:	THIS IS RUN EVERY DAY AND PICKS A NEW EVENT
USAGE:		SERVER/HIDDEN
*/

//Open mySQL Connection
$connection = mysql_connect("localhost", "6470", "6470") or die("mySQL Connection Error<br />\n");
$database='6470_main';
mysql_select_db($database) or die('Error, could not access database '.$database."\n");

//Find out how many bands there are
$result = mysql_query("SELECT * FROM event") or die(mysql_error());
while($exit==false){
	$row = mysql_fetch_array($result);
	$unixtimestamp = strtotime($row['time']);
	echo $unixtimestamp.' ';
	echo time().'<br />';;
	if($unixtimestamp>=time() && $unixtimestamp<=time()+86400){
		$exit=true;
		$eventpicker = $row['id'];
	}
	if($row['id']==''){
		$exit=true;
	}
}

//Set that random number as today's band
$result = mysql_query("UPDATE dailypicks SET pickid = '$eventpicker' WHERE picktype = 'event'") or die(mysql_error());

?>
