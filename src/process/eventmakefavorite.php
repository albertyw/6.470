<?php
/*
ADDRESS:	HTTP://ALBERTYW.MIT.EDU/6470/EVENTMAKEFAVORITE.PHP
STATUS:		FINISHED
LAST MODIFIED:	JANUARY 28, 2009
DESCRIPTION:	ADDS EVENT TO USER'S FAVORITE LIST
USAGE:		SERVER/HIDDEN
*/

//Get Variables
$username = $_POST['username'];
$eventid = $_POST['eventid'];
$accept=true;

//Open mySQL Connection
$connection = mysql_connect("localhost", "6470", "6470") or die("mySQL Connection Error<br />\n");
$database='6470_main';
mysql_select_db($database) or die('Error, could not access database '.$database."\n");

//check variables
if($eventid == '' || ereg('[^0-9]', $eventid) || $username == ''){
	$accept=false;
}
//Check eventid to see if its real
$result = mysql_query("SELECT * FROM event WHERE id = '$eventid'") or die(mysql_error());
$row = mysql_fetch_array($result);
if($row['name']=='' || $row['name']==null){
	$accept=false;
}

//Convert username into user id
$result = mysql_query("SELECT * FROM user WHERE username='$username'") or die(mysql_error());
$row = mysql_fetch_array($result);
if($row['id']=='' || $row['id']==null){
	$accept=false;
}else{
	$userid = $row['id'];
}
if($accept==true){//Add the favorite listing
	//First make sure that the event is not already favorited
	$result = mysql_query("SELECT * FROM usereventfav WHERE userid='$userid'") or die(mysql_error());
	while($row = mysql_fetch_array($result)){
		if($row['eventid']==$eventid)
			$repeat=true;
	}
	if($repeat==false){
		mysql_query("INSERT INTO usereventfav
			(userid, eventid)
			VALUES('$userid', '$eventid')") or die(mysql_error());
	}
	echo 'accept';//Still accept even if its a repeat
}else{
	echo 'cannot accept';
}
?>
