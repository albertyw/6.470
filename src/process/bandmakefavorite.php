<?php
/*
ADDRESS:	HTTP://ALBERTYW.MIT.EDU/6470/BANDMAKEFAVORITE.PHP
STATUS:		FINISHED
LAST MODIFIED:	JANUARY 23, 2009
DESCRIPTION:	ADDS BANDS TO USER'S FAVORITE LIST
USAGE:		SERVER/HIDDEN
*/

//Get Variables
$username = $_POST['username'];
$bandid = $_POST['bandid'];
$accept=true;

//Open mySQL Connection
$connection = mysql_connect("localhost", "6470", "6470") or die("mySQL Connection Error<br />\n");
$database='6470_main';
mysql_select_db($database) or die('Error, could not access database '.$database."\n");

//check variables
if($bandid == '' || ereg('[^0-9]', $bandid) || $username == ''){
	$accept=false;
}
//Check bandid to see if its real
$result = mysql_query("SELECT * FROM band WHERE id = '$bandid'") or die(mysql_error());
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
	//First make sure that the band is not already favorited
	$result = mysql_query("SELECT * FROM userbandfav WHERE userid='$userid'") or die(mysql_error());
	while($row = mysql_fetch_array($result)){
		if($row['bandid']==$bandid)
			$repeat=true;
	}
	if($repeat==false){
		mysql_query("INSERT INTO userbandfav
			(userid, bandid)
			VALUES('$userid', '$bandid')") or die(mysql_error());
	}
	echo 'accept';//Still accept even if its a repeat
}else{
	echo 'cannot accept';
}
?>
