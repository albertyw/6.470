<?php
/*
ADDRESS:	HTTP://ALBERTYW.MIT.EDU/6470/PROCESS/EVENTSINGLEBANDPROMPT.PHP
STATUS:		FINISHED
LAST MODIFIED:	JANUARY 28, 2009
DESCRIPTION:	CREATES A PROMPT FOR EVENTSINGLE.PHP TO CHANGE BANDS
USAGE:		HIDDEN
*/

//Connect to mysql database
$connection = mysql_connect("localhost", "6470", "6470") or die("mySQL Connection Error<br />\n");
$database='6470_main';
mysql_select_db($database) or die('Error, could not access database '.$database."\n");

//Get Variables
$eventid = $_POST['eventid'];

//Find the current bands for it
$result = mysql_query("SELECT * FROM eventbands WHERE eventid='$eventid'") or die(mysql_error());
$numberofbands=0;
while($row = mysql_fetch_array($result)){
	$bandid = $row['bandid'];
	$nameresult = mysql_query("SELECT * FROM band WHERE id = '$bandid'") or die(mysql_error());
	$namerow = mysql_fetch_array($nameresult);
	$bandarray[$numberofbands]=$namerow['name'];
	$numberofbands++;
}

//Create Prompts
$banddisplay=0;
while($banddisplay<=$numberofbands){
	echo '<input type="text" id="band'.$banddisplay.'" value="'.$bandarray[$banddisplay].'"><br />';
	$banddisplay++;
}
echo '<input type="hidden" id="numberofbands" value="'.$numberofbands.'">';
echo '<input type="submit" onclick="javascript:changeBandAction()" value="Change">';

?>
