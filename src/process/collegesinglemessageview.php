<?php
$collegeid = $_POST['collegesingleid'];
$collegemessagestart = $_POST['collegemessagestart'];
//Open mySQL Connection
$connection = mysql_connect("localhost", "6470", "6470") or die("mySQL Connection Error<br />\n");
$database='6470_main';
mysql_select_db($database) or die('Error, could not access database '.$database."\n");
//Get message info
if($collegemessagestart==0){//List last 5 messages
	$collegetalk = mysql_query("SELECT * FROM collegetalk WHERE collegeid='$collegeid' ORDER BY time DESC") or die(mysql_error());
}else{
	$collegetalk = mysql_query("SELECT * FROM collegetalk WHERE (collegeid='$collegeid' && id<='$collegemessagestart') ORDER BY time DESC") or die(mysql_error());
}
$count=1;
echo '<h1>Talk About The College</h1>';
$message = mysql_fetch_array($collegetalk);
//Check for newer messages
$collegemessageend = $message['id'];
$newermessageresult = mysql_query("SELECT * FROM collegetalk WHERE (collegeid='$collegeid' && id>'$collegemessageend') ORDER BY time ASC") or die(mysql_error());
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
		echo '<div class="collegemessage">';
		echo '<span class="collegemessagetext">'.$message['text'].'</span>';//Text of the message
		echo '<div class="messageinfo">';
		$userid = $message['userid'];
		$writerfinder = mysql_query("SELECT * FROM  user WHERE id='$userid'");
		$writerfinderrow = mysql_fetch_array($writerfinder);
		echo '<span class="collegemessagewriter">'.$writerfinderrow['realname'].'</span>';//Name of the writer
		echo '--';
		$unixtimestamp = strtotime($message['time']);
		echo '<span class="collegemessagetime">'.date("F j, Y - g:i A",$unixtimestamp).'</span>';//Time of the message
		echo '</div>'; //class="collegemessageinfo"
		echo "</div>\n"; //class="collegemessage"
	}
	$count++;
	$message = mysql_fetch_array($collegetalk);
}
if ($message['id']!=''){//Put a "Next" button to show more messages
	echo '<input type="submit" onclick="showMessage('.$message['id'].')" value="View Older Messages">';
}
?>
