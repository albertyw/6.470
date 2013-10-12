<?php
$eventid = $_POST['eventsingleid'];
$eventmessagestart = $_POST['eventmessagestart'];
//Open mySQL Connection
$connection = mysql_connect("localhost", "6470", "6470") or die("mySQL Connection Error<br />\n");
$database='6470_main';
mysql_select_db($database) or die('Error, could not access database '.$database."\n");
//Get message info
if($eventmessagestart==0){//List last 5 messages
	$eventtalk = mysql_query("SELECT * FROM eventtalk WHERE eventid='$eventid' ORDER BY time DESC") or die(mysql_error());
}else{
	$eventtalk = mysql_query("SELECT * FROM eventtalk WHERE (eventid='$eventid' && id<='$eventmessagestart') ORDER BY time DESC") or die(mysql_error());
}
$count=1;
echo '<h1>Talk About The Event</h1>';
$message = mysql_fetch_array($eventtalk);
//Check for newer messages
$eventmessageend = $message['id'];
$newermessageresult = mysql_query("SELECT * FROM eventtalk WHERE (eventid='$eventid' && id>'$eventmessageend') ORDER BY time ASC") or die(mysql_error());
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
		echo '<div class="eventmessage">';
		echo '<span class="eventmessagetext">'.$message['text'].'</span>';//Text of the message
		echo '<div class="messageinfo">';
		$writerid = $message['userid'];
		$writerfinder = mysql_query("SELECT * FROM  user WHERE id='$writerid'");
		$writerfinderrow = mysql_fetch_array($writerfinder);
		echo '<span class="eventmessagewriter">'.$writerfinderrow['realname'].'</span>';//Name of the writer
		echo '--';
		$unixtimestamp = strtotime($message['time']);
		echo '<span class="eventmessagetime">'.date("F j, Y - g:i A",$unixtimestamp).'</span>';//Time of the message
		echo '</div>'; //class="eventmessageinfo"
		echo "</div>\n"; //class="eventmessage"
	}
	$count++;
	$message = mysql_fetch_array($eventtalk);
}
if ($message['id']!=''){//Put a "Next" button to show more messages
	echo '<input type="submit" onclick="showMessage('.$message['id'].')" value="View Older Messages">';
}
?>
