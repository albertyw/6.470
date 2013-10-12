<?
/*
ADDRESS:	HTTP://ALBERTYW.MIT.EDU/6470/CRON/GOOGLE_COLLEGETABLE.PHP
STATUS:		FINISHED: MAYBE TURN THIS INTO A CRON JOB
LAST MODIFIED:	JANUARY 14, 2009 BY ALBERT WANG
DESCRIPTION:	THIS PAGE AUTOMATICALLY QUERIES THE COLLEGE TABLE AND GOOGLE AND FINDS THE COLLEGE'S WEBSITE DOMAIN
USAGE:		SERVER
*/

//Connect to Database
$connection = mysql_connect("localhost", "6470", "6470") or die("mySQL Connection Error<br />\n");
$database='6470_main';
mysql_select_db($database) or die('Error, could not access database '.$database."\n");

//Find starting id
$result = mysql_query("SELECT * FROM apiconfig WHERE updater = 'google_collegetable'" ) or die(mysql_error());
$row=mysql_fetch_array($result);
$newid = $row['configcursor']+1;

//See Find college name
$result = mysql_query("SELECT * FROM college WHERE id = '$newid'" ) or die(mysql_error());
$row=mysql_fetch_array($result);
$collegename = $row['college'];

//Make the URL
$url = "http://www.google.com/search?hl=en&q=".str_replace(" ", "+", $collegename);

//Download the HTML at that URL
$fh = fopen($url, 'r');
$contents = stream_get_contents($fh);
fclose($fh);

//In Google, the reference URL is encased within <cite>, </cite>, find them
$offsetstart=1;
$offsetend=1;
while($found==false && $skip==false){
	$startpos = strpos($contents,"<cite>", $offsetstart);
	$restoftext=substr($contents,$startpos,strlen($contents)-$startpos);
	if(strpos($restoftext,"<cite>")===false){//No addresses with edu and - found
		$skip=true;
		$string='';
	}
	$endpos = strpos($contents, "</cite>", $offsetend);
	$length=$endpos-$startpos;
	echo $startpos.'<br>'.$endpos.'<br>';
	$substring = substr($contents,$startpos+6, $length);//+6 so that <cite> itself isn't included
	echo "<b>Raw substring</b><br>\n";
	echo "<pre>".htmlentities($substring)."</pre><br><br>\n";
	if(!(strpos($substring, "edu")===false) && !(strpos($substring, "-")===false) && $substring!=''){//There are many cites within each search, we want a special one with edu in it
		$found=true;
	}else{
		$offsetstart = $startpos+6;
		echo 'Offsetstart: '.$offsetstart.'<br>';
		$offsetend = $endpos+6;
		echo 'Offsetend: '.$offsetend.'<br><br>';
		if($startpos==0 || $endpos==0){
			$skip=true;
		}
	}
}
if($skip==false){
	//Right now substring is raw (it looks like "heller.brandeis.edu/ - 9k -")
	//We need to get rid of the extra stuff

	//Kill any <b> and </b>
	$substring = str_replace("<b>","",$substring);
	$substring = str_replace("</b>","",$substring);
	echo '<b>Kill b and /b</b><br>';
	echo $substring.'<br>';

	//Find the ".edu"
	$cutoff = strpos($substring,".edu");
	$substring = substr($substring,0,$cutoff);
	echo '<b>Kill .edu</b><br>';
	echo $substring.'<br>';

	//Find the last period
	$substring = substr(strrchr($substring,"."), 1);
	echo '<b>Kill subdomain</b><br>';
	echo $substring.'<br>';

	$string = $substring.".edu";

}

echo "<b>Final String</b><br>\n";
echo "<pre>".htmlentities($string)."</pre><br><br>\n";


//INSERT TEXT INTO DATABASE
$result = mysql_query("UPDATE college SET emaildomain ='$string' WHERE id='$newid'")
	or die(mysql_error());

//UPDATE CURSOR
$result = mysql_query("UPDATE apiconfig SET configcursor='$newid' WHERE updater='google_collegetable'")
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
?>
