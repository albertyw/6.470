<?php
/*
ADDRESS:	HTTP://ALBERTYW.MIT.EDU/6470/CRON/ARTISTTABLE.PHP
STATUS:		UNFINISHED
LAST MODIFIED:	JANUARY 11, 2009 BY ALBERT WANG
DESCRIPTION:	THIS PAGE IS GETS DATABASE INFORMATION FROM FREEBASE AND PUSHES IT INTO THE LOCAL DATABASE
USAGE:		HIDDEN
*/

//Open mySQL Connection
$connection = mysql_connect("localhost", "6470", "6470") or die("mySQL Connection Error<br />\n");
$database='6470_main';
mysql_select_db($database) or die('Error, could not access database '.$database."\n");
include("/opt/lampp/htdocs/6470/include/phpxssfilter.php");

echo '<h1>Aristtable.php</h1>';



//FIND OLD QUERY
$result = mysql_query("SELECT * FROM apiconfig
	WHERE updater='freebase_artisttable'") or die(mysql_error());
$row = mysql_fetch_array( $result );
$cursor='"'.$row['configcursor'].'"';
if($cursor=='""') $cursor='true';
//***************************************NAME************************
$mqlquery_name='
{
	"cursor":'.$cursor.',
	"query":[
	{
		"type":"/music/artist",
		"name":null,
		"guid":null,
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
	$name=$obj2->{'name'}; //Name of college
	$guid=$obj2->{'guid'};//GUID, needed to find artist's other info

	//PROCESS STRINGS
	//RemoveXSS has already been processed above
	if(is_array($name)) $name=$name[0];
	$name=mysql_real_escape_string(htmlspecialchars($name));

}else{
	die("name error");
}



//****************************IMAGE******************************
$mqlquery_image='
{
	"query":[
	{
		"type":"/music/artist",
		"guid":"'.$guid.'",
		"/common/topic/image":[
		{
			"id":null
		}
		],
		"limit":1
	}
	]
}';

$contents=sendquery($mqlquery_image);
//CHANGE STRING INTO OBJECT WITH JSON
$obj=json_decode($contents);

//VERIFY STATUS
$status=$obj->{'status'};
$code=$obj->{'code'};
if($status=='200 OK' && $code=='/api/status/ok'){
	//STRING EXTRACTION
	//Dig into object
	$result=$obj->{'result'};
	$obj2=$result[0];
	$image=$obj2->{'/common/topic/image'};
	$image2=$image[0];
	$imageurl='http://www.freebase.com/api/trans/raw'.RemoveXSS($image2->{'id'});//Image

	//PROCESS STRINGS
	//RemoveXSS has already been processed above
	$imageurl=mysql_real_escape_string(htmlspecialchars($imageurl));
}else{
	die("image error");
}



//**********************ARTICLE***************************
$mqlquery_article='{
	"query":[
	{
		"type":"/music/artist",
		"guid":"'.$guid.'",
		"/common/topic/article":[
		{
			"id":null
			}
		],
		"limit":1
	}
	]
}';

$contents=sendquery($mqlquery_article);
//CHANGE STRING INTO OBJECT WITH JSON
$obj=json_decode($contents);
//VERIFY STATUS
$status=$obj->{'status'};
$code=$obj->{'code'};
if($status=='200 OK' && $code=='/api/status/ok'){
	//STRING EXTRACTION
	//Dig into object
	$result=$obj->{'result'};
	$obj2=$result[0];
	$article=$obj2->{'/common/topic/article'};
	$article2=$article[0];
	$articleurl='http://www.freebase.com/api/trans/raw'.RemoveXSS($article2->{'id'});//Article
	$curl = curl_init($articleurl);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	$articletext = curl_exec($curl);//Return text
	curl_close ($curl);

	//PROCESS STRINGS
	//RemoveXSS has already been processed above
	$articletext=mysql_real_escape_string(htmlspecialchars($articletext));
}else{
	die("article error");
}



//***********************************GROUP MEMBERSHIP*******************************
$exit=false;
$grouparray = array();
while($exit==false){
	if($cursorgroupmembership==null){
		$cursorgroupmembership="true";
	}else{
		$cursorgroupmembership='"'.$cursorgroupmembership.'"';
	}
	$mqlquery_groupmembership='
	{
		"cursor":'.$cursorgroupmembership.',
		"query":[
		{
			"type":"/music/group_membership",
			"member":"'.stripslashes($name).'",
			"group":[],
			"limit":1
		}
		]
	}';

	$contents=sendquery($mqlquery_groupmembership);
	//CHANGE STRING INTO OBJECT WITH JSON
	$obj=json_decode($contents);

	//VERIFY STATUS
	$status=$obj->{'status'};
	$code=$obj->{'code'};
	if($status=='200 OK' && $code=='/api/status/ok'){
		//STRING EXTRACTION
		//Dig into object
		$cursorgroupmembership=$obj->{'cursor'};
		$result=$obj->{'result'};
		$obj2=$result[0];
		$group=$obj2->{'group'};

		//PROCESS STRINGS
		//RemoveXSS has already been processed above
		if(is_array($group)) $group=$group[0];
		$group=mysql_real_escape_string(htmlspecialchars($group));
					echo 'GROUPARRAY<br>';
			print_r($grouparray);
			echo '<br>GROUP<br>';
			echo $group;
			echo '<br><br>';
		$search=0;
		while($search<count($grouparray)){
			if($grouparray[$search]==$group || ($group=='' && $group==null)){

				$exit=true;
			}
			$search++;
		}
		if($exit!=true){
			$grouparray[]=$group;
		}
	}else{
		die("group membership error");
	}
}




	//ECHO EXTRACTED STRINGS
	echo '<b>Extracted Strings</b><br><br>';
	echo 'Cursor: '.$cursor.'<br>';
	echo 'Name: '.$name.'<br>';
	echo 'Freebase GUID: '.$guid.'<br>';
	echo 'Group(s): ';
	print_r($grouparray);
	echo '<br>';
	echo 'Image URL: <a href="'.$imageurl.'">'.$imageurl.'</a><br>';
	echo 'Article Text: '.$articletext.'<br>';

	//SEE IF ITS A REPEAT
	if($imageurl!=null && $imageurl!=0){
		$result = mysql_query("SELECT * FROM artist  WHERE picture='$imageurl')")
			or die(mysql_error());
		$row = mysql_fetch_array( $result );
		if(!empty($row)){
			if($row['name']==$name)
				die('CURSOR HAS REPEATED!');

		}
	}

	//Formatting for tables
	/*if(!empty($grouparray)){
		$bandswitch=2;
	}*/

	//INSERT TEXT INTO DATABASE
	$result = mysql_query("INSERT INTO artist
		(name, picture, band, article, freebaseid)
		VALUES('$name', '$imageurl', '$bandswitch', '$articletext', '$guid') ")
		or die(mysql_error());
	/*$result = mysql_query("INSERT INTO artistalias
		(artistid, alias, band)
		VALUES('$artistid', '$alias', '$bandswitch) ")
		or die(mysql_error());*/
	//UPDATE CURSOR
	$result = mysql_query("UPDATE apiconfig SET configcursor='$cursor' WHERE updater='freebase_artisttable'")
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
