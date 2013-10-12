<?php
//Get Variables
$favuserid = $_POST['userid'];
$ownprofile = $_POST['ownprofile'];
$ownusername = $_POST['ownusername'];

//Connect to mysql database
$connection = mysql_connect("localhost", "6470", "6470") or die("mySQL Connection Error<br />\n");
$database='6470_main';
mysql_select_db($database) or die('Error, could not access database '.$database."\n");

//Convert username to id
$result = mysql_query("SELECT * FROM user WHERE username = '$ownusername'") or die(mysql_error());
$row = mysql_fetch_array($result);
$ownuserid = $row['id'];

//Check useruserfav
$result = mysql_query("SELECT * FROM useruserfav WHERE (user1id = '$ownuserid' && user2id = '$favuserid')") or die(mysql_error());
$row = mysql_fetch_array($result);
if($row['id']=='' || $row['id']==null){//Search the other way around
	$result = mysql_query("SELECT * FROM useruserfav WHERE (user2id = '$ownuserid' && user1id = '$favuserid')") or die(mysql_error());
	$row = mysql_fetch_array($result);
	if($row['id']=='' || $row['id']==null){//Not friended yet, become a friend
		mysql_query("INSERT INTO useruserfav
			(user1id, user2id)
			VALUES('$ownuserid','$favuserid')") or die(mysql_error());
		echo 'You are now friends with this person.  ';
	}else{//Already friended, delete friend
		$id = $row['id'];
		mysql_query("DELETE FROM useruserfav WHERE id='$id'") or die(mysql_error());
		echo 'You are no longer friends with this person.';
	}
}else{//Already friended, delete friend
	$id = $row['id'];
	mysql_query("DELETE FROM useruserfav WHERE id='$id'") or die(mysql_error());
	echo 'You are no longer friends with this person.';
}
?>
