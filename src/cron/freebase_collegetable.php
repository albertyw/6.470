<?php
/*
ADDRESS:	HTTP://ALBERTYW.MIT.EDU/6470/CRON/COLLEGETABLE.PHP
STATUS:		UNFINISHED
LAST MODIFIED:	JANUARY 10, 2009 BY ALBERT WANG
DESCRIPTION:	THIS PAGE IS GETS DATABASE INFORMATION FROM FREEBASE AND PUSHES IT INTO THE LOCAL DATABASE
USAGE:		HIDDEN
*/

//Open mySQL Connection
$connection = mysql_connect("localhost", "6470", "6470") or die("mySQL Connection Error<br />\n");
$database='6470_main';
mysql_select_db($database) or die('Error, could not access database '.$database."\n");
include("/opt/lampp/htdocs/6470/include/phpxssfilter.php");

echo '<h1>Collegetable.php</h1>';



//FIND OLD QUERY
$result = mysql_query("SELECT * FROM apiconfig
	WHERE updater='freebase_collegetable'") or die(mysql_error());
$row = mysql_fetch_array( $result );
$cursor='"'.$row['configcursor'].'"';
if($cursor=='""') $cursor='true';

$mqlquery_name='
{
	"cursor":'.$cursor.',
	"query":[
	{
		"type":"/education/university",
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
	$guid=$obj2->{'guid'};//GUID, needed to find college's other info

	//PROCESS STRINGS
	//RemoveXSS has already been processed above
	if(is_array($name)) $name=$name[0];
	$name=mysql_real_escape_string(htmlspecialchars($name));

}else{
	die("name error");
}



//Now Find Other Information
$mqlquery_address='
{
	"query":[
	{
		"type":"/education/university",
		"guid":"'.$guid.'",
		"/education/educational_institution/address":[
		{
			"street_address":[],
			"street_address_2":[],
			"citytown":[],
			"state_province_region":[],
			"postal_code":[]
		}
		],
		"limit":1
	}
	]
}';

$contents=sendquery($mqlquery_address);
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
	$address=$obj2->{'/education/educational_institution/address'};
	$address2=$address[0];
	$state=$address2->{'state_province_region'};//state
	$city=$address2->{'citytown'};//city
	$zip=RemoveXSS($address2->{'postal_code'});//zip
	$streetaddress1=$address2->{'street_address'};//street address
	$streetaddress2=$address2->{'street_address_2'};

	//PROCESS STRINGS
	//RemoveXSS has already been processed above
	if(is_array($streetaddress1)) $streetaddress1=$streetaddress1[0];
	if(is_array($streetaddress2)) $streetaddress2=$streetaddress2[0];
	$streetaddress=$streetaddress1.' '.$streetaddress2;
	if(is_array($city)) $city=$city[0];
	if(is_array($state)) $state=$state[0];
	if(is_array($zip)) $zip=$zip[0];

	$streetaddress=mysql_real_escape_string(htmlspecialchars($streetaddress));
	$city=mysql_real_escape_string(htmlspecialchars($city));
	$state=mysql_real_escape_string(htmlspecialchars($state));
	$zip=mysql_real_escape_string(htmlspecialchars($zip));
}else{
	die("address error");
}




$mqlquery_image='
{
	"query":[
	{
		"type":"/education/university",
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



$mqlquery_location='
{
	"query":[
	{
		"type":"/education/university",
		"guid":"'.$guid.'",
		"/location/location/geolocation":[
		{
			"latitude":[],
			"longitude":[]
		}
		],
		"limit":1
	}
	]
}';

$contents=sendquery($mqlquery_location);
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
	$geolocation=$obj2->{'/location/location/geolocation'};
	$geolocation2=$geolocation[0];
	$longitude=RemoveXSS($geolocation2->{'longitude'});//Longitude
	$latitude=RemoveXSS($geolocation2->{'latitude'});//Latitude

	//PROCESS STRINGS
	//RemoveXSS has already been processed above
	if(is_array($longitude)) $longitude=$longitude[0];
	if(is_array($latitude)) $latitude=$latitude[0];
	$longitude=mysql_real_escape_string(htmlspecialchars($longitude));
	$latitude=mysql_real_escape_string(htmlspecialchars($latitude));
}else{
	die("geolocation error");
}

$mqlquery_article='{
	"query":[
	{
		"type":"/education/university",
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


	//ECHO EXTRACTED STRINGS
	echo '<b>Extracted Strings</b><br><br>';
	echo 'Cursor: '.$cursor.'<br>';
	echo 'Name: '.$name.'<br>';
	echo 'Longitude: '.$longitude.'<br>';
	echo 'Latitude: '.$latitude.'<br>';
	echo 'Street Address: '.$streetaddress.'<br>';
	echo 'City: '.$city.'<br>';
	echo 'State: '.$state.'<br>';
	echo 'Zip: '.$zip.'<br>';
	echo 'Image URL: <a href="'.$imageurl.'">'.$imageurl.'</a><br>';
	echo 'Article Text: '.$articletext.'<br>';

	//SEE IF ITS A REPEAT
	if($longitude!=0 && $longitude!=null && $latitude!=0 && $latitude!=null){
		$result = mysql_query("SELECT * FROM college  WHERE ((latitude='$latitude') AND (longitude='$longitude'))")
			or die(mysql_error());
		$row = mysql_fetch_array( $result );
		if(!empty($row)){
			if($row['college']==$name && $row['picture']==$imageurl && $row['address']==$streetaddress){
				die("QUERIES HAVE REPEATED!");
			}
		}
	}


	//INSERT TEXT INTO DATABASE
	$result = mysql_query("INSERT INTO college
		(college, address, city, state, zip, country, longitude, latitude, description, picture)
		VALUES('$name', '$streetaddress', '$city', '$state', '$zip', '$country', '$longitude', '$latitude', '$articletext', '$imageurl' ) ")
		or die(mysql_error());

	//UPDATE CURSOR
	$result = mysql_query("UPDATE apiconfig SET configcursor='$cursor' WHERE updater='freebase_collegetable'")
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
