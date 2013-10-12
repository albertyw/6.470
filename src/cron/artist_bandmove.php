<?php
/*
ADDRESS:	HTTP://ALBERTYW.MIT.EDU/6470/CRON/ARTIST_BANDMOVE.PHP
STATUS:		FINISHED
LAST MODIFIED:	JANUARY 27, 2009
DESCRIPTION:	MOVES STUFF FROM ARTIST_BACKUP TABLE TO BAND TABLE
USAGE:		HIDDEN/SERVER
*/

//Open mySQL Connection
$connection = mysql_connect("localhost", "6470", "6470") or die("mySQL Connection Error<br />\n");
$database='6470_main';
mysql_select_db($database) or die('Error, could not access database '.$database."\n");

//Find the cursor
$result = mysql_query("SELECT * FROM apiconfig WHERE updater='artist_bandmove'") or die(mysql_error());
$row = mysql_fetch_array($result);
$artistid = $row['configcursor'];

//Find the artist row
$result = mysql_query("SELECT * FROM artist_backup WHERE id='$artistid'") or die(mysql_error());
$row = mysql_fetch_array($result);
//Strip useful variables
$name = mysql_real_escape_string($row['name']);
if($name=='') die();
$picture = mysql_real_escape_string($row['picture']);
$article = mysql_real_escape_string($row['article']);

//Make up a college to attach the band to
while($found==false){
	$collegeid=rand(1,6724);
	$result = mysql_query("SELECT * FROM college WHERE id='$collegeid'") or die(mysql_error());
	$row = mysql_fetch_array($result);
	if($row['college']!=null && $row['college']!=''){
		$found=true;
	}
}

//Make up a number of views
$views = rand(0,10);

//Move it into the band table
mysql_query("INSERT INTO band
	(name, picture, collegeid, article, views)
	VALUES('$name','$picture','$collegeid','$article','$views')") or die(mysql_error());
//Set the cursor
$artistid++;
mysql_query("UPDATE apiconfig SET configcursor ='$artistid' WHERE updater='artist_bandmove'") or die(mysql_error());

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
