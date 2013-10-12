<?php
//Get Variables
$favuserid = $_POST['userid'];
$ownprofile = $_POST['ownprofile'];

//Connect to mysql database
$connection = mysql_connect("localhost", "6470", "6470") or die("mySQL Connection Error<br />\n");
$database='6470_main';
mysql_select_db($database) or die('Error, could not access database '.$database."\n");


//Check useruserfav
$result = mysql_query("SELECT * FROM useruserfav WHERE (user1id = '$favuserid' || user2id = '$favuserid')") or die(mysql_error());
$numberdisplay=1;
while($numberdisplay<=5){
	$row = mysql_fetch_array($result);
	if($row['id']!='' && $row['id']!=null){
		if($row['user1id']==$favuserid){
			$user2id = $row['user2id'];
			$resultrealname = mysql_query("SELECT * FROM user WHERE id='$user2id'") or die(mysql_error());
			$rowrealname = mysql_fetch_array($resultrealname);
			echo '<a href="http://albertyw.mit.edu/6470/profile/'.$user2id.'/">'.$rowrealname['realname'].'</a><br>';
		}
		if($row['user2id']==$favuserid){
			$user1id = $row['user1id'];
			$resultrealname = mysql_query("SELECT * FROM user WHERE id='$user1id'") or die(mysql_error());
			$rowrealname = mysql_fetch_array($resultrealname);
			echo '<a href="http://albertyw.mit.edu/6470/profile/'.$user1id.'/">'.$rowrealname['realname'].'</a><br>';
		}
	}
	$numberdisplay++;
}
?>
