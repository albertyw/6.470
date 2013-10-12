<?php
/*
ADDRESS:	HTTP://ALBERTYW.MIT.EDU/6470/CRON/MUSICTABLE.PHP
STATUS:		UNFINISHED
LAST MODIFIED:	JANUARY 27, 2009 BY ALBERT WANG
DESCRIPTION:	THIS PAGE IS GETS DATABASE INFORMATION FROM FREEBASE AND PUSHES IT INTO THE LOCAL DATABASE
USAGE:		HIDDEN
*/

//Open mySQL Connection
$connection = mysql_connect("localhost", "6470", "6470") or die("mySQL Connection Error<br />\n");
$database='6470_main';
mysql_select_db($database) or die('Error, could not access database '.$database."\n");
include("/opt/lampp/htdocs/6470/include/phpxssfilter.php");

echo '<h1>Musictable.php</h1>';



//FIND OLD QUERY
$result = mysql_query("SELECT * FROM apiconfig
	WHERE updater='freebase_musictable'") or die(mysql_error());
$row = mysql_fetch_array( $result );
$cursor='"'.$row['configcursor'].'"';
if($cursor=='""') $cursor='true';

$mqlquery_name='
{
	"cursor":'.$cursor.',
	"query":[
	{
		"type":"/music/artist",
		"name":null,
		"track":[{
			"id":null,
			"name":null,
			"album":[]
		}],
		"limit":1
	}
	]
}';

$contents=sendquery($mqlquery_name, $name);
//CHANGE STRING INTO OBJECT WITH JSON
$obj=json_decode($contents);

//VERIFY STATUS
$status=$obj->{'status'};
$code=$obj->{'code'};
if($status=='200 OK' && $code=='/api/status/ok'){
	//STRING EXTRACTION
	//Need to keep cursor
	$cursor=$obj->{'cursor'};
	//Dig into object
	$result=$obj->{'result'};
	$obj2=$result[0];
	$artistname=$obj2->{'name'};//Artist Name
	$artistname = mysql_real_escape_string(htmlspecialchars($artistname));
	$track=$obj2->{'track'};
	$sizeofarray = sizeof($track);
	$read=0;
	while($read<$sizeofarray){
		$obj3=$track[$read];
		$album=$obj3->{'album'};
		$albumarray[$read]=$album[0];//Album Array
		$trackarray[$read]=$obj3->{'name'};//Track Name
		//PROCESS STRINGS
		//RemoveXSS has already been processed above
		$trackarray[$read]=mysql_real_escape_string(htmlspecialchars($trackarray[$read]));
		$albumarray[$read]=mysql_real_escape_string(htmlspecialchars($albumarray[$read]));
		$read++;
	}
}else{
	die("error");
}





	//ECHO EXTRACTED STRINGS
	echo '<b>Extracted Strings</b><br><br>';
	echo 'Cursor: '.$cursor.'<br>';
	echo 'Artist Name: '.$artistname.'<br>';
	print_r($trackarray).'<br>';
	print_r($albumarray);

	//SEE IF ITS A REPEAT
	/*$checkrepeat = $trackarray[0];
	$result = mysql_query("SELECT * FROM music WHERE name='$checkrepeat'") or die(mysql_error());
	$row = mysql_fetch_array($result);
	if($row['id']!=null && $row['id']!=''){
		die("Music has repeated");
	}*/


	//INSERT TEXT INTO DATABASE
	$read=0;
	$result = mysql_query("SELECT * FROM band where name='$artistname'") or die(mysql_error());
	$row = mysql_fetch_array($result);
	$bandid = $row['id'];
	while($read<$sizeofarray && $bandid!=''){
		$currenttrack = $trackarray[$read];
		$currentalbum = $albumarray[$read];
		$trackno = rand(1,20);
		$views = rand(1,20);
		//Check Repeat
		$result = mysql_query("SELECT * FROM music WHERE name='$currenttrack'") or die(mysql_error());
		$row = mysql_fetch_array($result);
		if($row['id']==null || $row['id']==''){
			$result = mysql_query("INSERT INTO music
				(trackno, name, album, bandid, views)
				VALUES('$trackno', '$currenttrack', '$currentalbum', '$bandid', '$views') ")
				or die(mysql_error());
		}
		$read++;
	}

	//UPDATE CURSOR
	$result = mysql_query("UPDATE apiconfig SET configcursor='$cursor' WHERE updater='freebase_musictable'")
		or die(mysql_error());
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








//FUNCTIONS
function sendquery($mqlquery){
	//FORMAT QUERY INTO URL
	echo '<b>Query Text</b><br><br>';
	echo '<pre>'.$mqlquery.'</pre><br><br>';

	//$mqlquery = str_replace(array("\n", "\r", "\n", "\t", "\o", "\xOB"), '', $mqlquery);//Need to clear whitespace
	//$name=str_replace(' ', '+', $name);
	//$mqlquery=encodeURIComponent($mqlquery);
	//$mqlquery = str_replace('REPLACETHIS', $name, $mqlquery);
	$mqlsend='http://api.freebase.com/api/service/mqlread?query='.urlencode($mqlquery);
	//SEND AND READ URL
	$fh = fopen($mqlsend, 'r');
	$contents = stream_get_contents($fh);
	fclose($fh);
	echo '<b>Return Text</b><br><br>';
	echo '<pre>'.$contents.'</pre><br><br>';
	return $contents;
}



?>
