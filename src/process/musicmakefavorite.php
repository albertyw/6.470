<?php
/*
ADDRESS:	HTTP://ALBERTYW.MIT.EDU/6470/MUSICMAKEFAVORITE.PHP
STATUS:		FINISHED
LAST MODIFIED:	JANUARY 23, 2009
DESCRIPTION:	ADDS MUSIC TO USER'S FAVORITE LIST
USAGE:		SERVER/HIDDEN
*/

//Get Variables
$username = $_POST['username'];
$musicid = $_POST['musicid'];
$accept=true;

//Open mySQL Connection
$connection = mysql_connect("localhost", "6470", "6470") or die("mySQL Connection Error<br />\n");
$database='6470_main';
mysql_select_db($database) or die('Error, could not access database '.$database."\n");

//check variables
if($musicid == '' || ereg('[^0-9]', $musicid) || $username == ''){
	$accept=false;
}
//Check musicid to see if its real
$result = mysql_query("SELECT * FROM music WHERE id = '$musicid'") or die(mysql_error());
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
	//First make sure that the music is not already favorited
	$result = mysql_query("SELECT * FROM usermusicfav WHERE userid='$userid'") or die(mysql_error());
	while($row = mysql_fetch_array($result)){
		if($row['musicid']==$musicid)
			$repeat=true;
	}
	if($repeat==false){
		mysql_query("INSERT INTO usermusicfav
			(userid, musicid)
			VALUES('$userid', '$musicid')") or die(mysql_error());
	}
	echo 'accept';//Still accept even if its a repeat
}else{
	echo 'cannot accept';
}
?>
