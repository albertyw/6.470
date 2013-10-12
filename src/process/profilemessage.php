<?php
//Take message info
$messagetext = $_POST['messagetext'];
$messagewriterid = $_POST['messagewriterid'];
$messagerecipientid = $_POST['messagerecipientid'];
$accept=true;
//Will need RemoveXSS
include("/opt/lampp/htdocs/6470/include/phpxssfilter.php");

echo $messagewriterusername;
//Check the message itself for special characters, length
if($messagetext != htmlentities(mysql_real_escape_string(RemoveXSS($messagetext))) || strlen($messagetext)>1000 || strlen($messagetext)==0){
	$messagereturn = 'Your message is improperly formatted<br />';
	$accept=false;
}

//Connect to Database
$connection = mysql_connect("localhost", "6470", "6470") or die("mySQL Connection Error<br />\n");
$database='6470_main';
mysql_select_db($database) or die('Error, could not access database '.$database."\n");
//Check the writer
$result = mysql_query("SELECT * FROM user WHERE id = '$messagewriterid'") or die(mysql_error());
$row = mysql_fetch_array($result);
if($row['id']=='' || $row['id']==null){
	$accept=false;
	$messagereturn .= 'You are not logged in<br />';
}else{
	$messagewriterrealname = $row['realname'];
}
//Check the recipient
$result = mysql_query("SELECT * FROM user WHERE id = '$messagerecipientid'") or die(mysql_error());
$row = mysql_fetch_array($result);
if($row['username']=='' || $row['id']==null){
	$accept=false;
	$messagereturn .= 'You are writing to the wrong person<br />';
}
echo '{';
if($accept==true){//If the message can be processed:
	mysql_query("INSERT INTO usertalk
		(writerid, recipientid, text)
		VALUES ('$messagewriterid','$messagerecipientid','$messagetext')");
	echo '"accept":true';
}else{
	echo '"accept":false,';
	echo '"messagereturn":"'.$messagereturn.'"';
}
echo '}';
?>
