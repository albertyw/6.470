<?php
$userid = $_POST['profileid'];
$usermessagestart = $_POST['usermessagestart'];
//Open mySQL Connection
$connection = mysql_connect("localhost", "6470", "6470") or die("mySQL Connection Error<br />\n");
$database='6470_main';
mysql_select_db($database) or die('Error, could not access database '.$database."\n");
//Get message info
if($usermessagestart==0){//List last 5 messages
	$usertalk = mysql_query("SELECT * FROM usertalk WHERE recipientid='$userid' ORDER BY time DESC") or die(mysql_error());
}else{
	$usertalk = mysql_query("SELECT * FROM usertalk WHERE (recipientid='$userid' && id<='$usermessagestart') ORDER BY time DESC") or die(mysql_error());
}
$count=1;
echo '<h1>Messages</h1>';
$message = mysql_fetch_array($usertalk);
//Check for newer messages
$usermessageend = $message['id'];
$newermessageresult = mysql_query("SELECT * FROM usertalk WHERE (recipientid='$userid' && id>'$usermessageend') ORDER BY time ASC") or die(mysql_error());
while($count<=5){
	$newmessagerow = mysql_fetch_array($newermessageresult);
	$count++;
}
if($newmessagerow['id']!=''){
	echo '<input type="submit" onclick="showMessage('.$newmessagerow['id'].')" value="View Newer Messages">';
}
$count=1;
while($count<=5 && $exit==false){

	if($message['id']=='' || $message['id']==0){
		$exit=true;
	}else{
		echo '<div class="usermessage">';
		echo '<span class="usermessagetext">'.$message['text'].'</span>';//Text of the message
		echo '<div class="messageinfo">';
		$writerid = $message['writerid'];
		$writerfinder = mysql_query("SELECT * FROM  user WHERE id='$writerid'");
		$writerfinderrow = mysql_fetch_array($writerfinder);
		echo '<span class="usermessagewriter">'.$writerfinderrow['realname'].'</span>';//Name of the writer
		echo '--';
		$unixtimestamp = strtotime($message['time']);
		echo '<span class="usermessagetime">'.date("F j, Y - g:i A",$unixtimestamp).'</span>';//Time of the message
		echo '</div>'; //class="usermessageinfo"
		echo "</div>\n"; //class="usermessage"
	}
	$count++;
	$message = mysql_fetch_array($usertalk);
}
if ($message['id']!=''){//Put a "Next" button to show more messages
	echo '<input type="submit" onclick="showMessage('.$message['id'].')" value="View Older Messages">';
}
?>
