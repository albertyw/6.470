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
if($row['id']=='' || $row['id']==null){//Not friended yet
	echo 'You are not friends with this person.  <a href="javascript:changefav()">Become A Friend</a>';
}else{//Already friended
	echo 'You are friends with this person.  <a href="javascript:changefav()">Leave Him</a>';
}
?>
