<?php
/*
ADDRESS:	HTTP://ALBERTYW.MIT.EDU/6470/CRON/COLLEGE_CULL.PHP
STATUS:
LAST MODIFIED:	JANUARY 16, 2009 by ALBERT WANG
DESCRIPTION:	DELETES COLLEGES WITHOUT A URL, WITHOUT A DESCRIPTION, OR WITH SPECIAL CHARACTERS
USAGE:		PUBLIC
*/
include("/opt/lampp/htdocs/6470/include/phpxssfilter.php");

echo '<h1>College_cull</h1>';
//Open mySQL Connection
$connection = mysql_connect("localhost", "6470", "6470") or die("mySQL Connection Error<br />\n");
$database='6470_main';
mysql_select_db($database) or die('Error, could not access database '.$database."\n");

//Find out where to start
$result = mysql_query("SELECT * FROM apiconfig WHERE updater='college_cull'");
$row = mysql_fetch_array($result);
$id = $row['configcursor'];

//Find the college row where id is there
$result = mysql_query("SELECT * FROM college WHERE id='$id'");
$row = mysql_fetch_array($result);

echo $row['college'].'<br>';

//See if there's a URL
if($row['emaildomain']==''){
	$delete=true;
	echo 'Bad Email Domain.<br>';
}

//See if the URL is just ".edu"
if($row['emaildomain']=='.edu'){
	$delete=true;
	echo 'Email domain is just ".edu"<br>';
}

//See if there's an actual description
if(substr($row['description'],0,3)=='404' || $row['description']==null){
	$delete = true;
	echo 'Bad Description.<br>';
}

//See if there's special characters in the name
if(ereg('[^a-zA-Z0-9\' ]', $row['college']) || $row['college'] !=mysql_real_escape_string(htmlentities(RemoveXSS($row['college'])))){
	$delete = true;
	echo 'Bad name.<br>';
}

if($delete == true){//Then delete the row
	$result = mysql_query("DELETE FROM college WHERE id = '$id'");
	echo 'COLLEGE DELETED.';
}
//Update Cursor
$id++;
$result = mysql_query("UPDATE apiconfig SET configcursor='$id' WHERE updater='college_cull'");


//Refresh the page
echo '
<script>
<!--

/*
Auto Refresh Page with Time script
By JavaScript Kit (javascriptkit.com)
Over 200+ free scripts here!
*/

//enter refresh time in "minutes:seconds" Minutes should range from 0 to inifinity. Seconds should range from 0 to 59
var limit="0:1"

if (document.images){
var parselimit=limit.split(":")
parselimit=parselimit[0]*60+parselimit[1]*1
}
function beginrefresh(){
if (!document.images)
return
if (parselimit==1)
window.location.reload()
else{
parselimit-=1
curmin=Math.floor(parselimit/60)
cursec=parselimit%60
if (curmin!=0)
curtime=curmin+" minutes and "+cursec+" seconds left until page refresh!"
else
curtime=cursec+" seconds left until page refresh!"
window.status=curtime
setTimeout("beginrefresh()",1000)
}
}

window.onload=beginrefresh
//-->
</script>';

?>
