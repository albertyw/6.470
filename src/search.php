<?php
/*
ADDRESS:	HTTP://ALBERTYW.MIT.EDU/6470/SEARCH.PHP
STATUS:		UNFINISHED/MAINTANANCE NEEDED/FINISHED
LAST MODIFIED:	JANUARY 27, 2009
DESCRIPTION:	SEARCH PAGE: SEARCH/REDIRECT TO BANDS, COLLEGES, MUSIC,EVENTS
USAGE:		PUBLIC
*/
//jQueryUI PHP Calls

//End jQuery UI Calls
$login=false;
if(isset($_SESSION['username']) && $_SESSION['username']!=''){//See if person is logged in
	$login=true;
	$username=$_SESSION['username'];
}
$title='molemusic | search';
$googlemaps=false;
$freebase=false;
session_start();
include("/opt/lampp/htdocs/6470/include/headeropen.php");
//head stuff here
include("/opt/lampp/htdocs/6470/include/headertext.php");


//Get Variables
$searchtype = $_POST['searchtype'];
$searchString = $_POST['searchString'];

if($searchString !=mysql_real_escape_string(htmlentities(RemoveXSS($searchString)))){
	echo "improper formatting";
	include("/opt/lampp/htdocs/6470/include/footer.php");
	die();
}
if($searchtype !=mysql_real_escape_string(htmlentities(RemoveXSS($searchtype)))){
	echo "improper formatting";
	include("/opt/lampp/htdocs/6470/include/footer.php");
	die();
}

//Open mySQL Connection
$connection = mysql_connect("localhost", "6470", "6470") or die("mySQL Connection Error<br />\n");
$database='6470_main';
mysql_select_db($database) or die('Error, could not access database '.$database."\n");

if($searchtype == 'band'){
	//Search for the string in the band database
	$result = mysql_query("SELECT * FROM band WHERE name='$searchString'") or die(mysql_error());
	$row = mysql_fetch_array($result);
	if($row['id']!='' && $row['id']!=null){
		echo '<script type="text/javascript">
		<!--
		window.location="http://albertyw.mit.edu/6470/bands/'.$row['id'].'/";
		-->
		</script>';
	}
}
if($searchtype == 'music'){
	//Search for the string in the band database
	$result = mysql_query("SELECT * FROM music WHERE name='$searchString'") or die(mysql_error());
	$row = mysql_fetch_array($result);
	if($row['id']!='' && $row['id']!=null && $link==null){
		echo '<script type="text/javascript">
		<!--
		window.location="http://albertyw.mit.edu/6470/music/'.$row['id'].'/"
		//-->
		</script>';
	}
}
if($searchtype == 'college'){
	//Search for the string in the band database
	$result = mysql_query("SELECT * FROM college WHERE college='$searchString'") or die(mysql_error());
	$row = mysql_fetch_array($result);
	if($row['id']!='' && $row['id']!=null && $link==null){
		echo '<script type="text/javascript">
		<!--
		window.location="http://albertyw.mit.edu/6470/college/'.$row['id'].'/"
		//-->
		</script>';
	}
}
if($searchtype == 'event'){
	//Search for the string in the band database
	$result = mysql_query("SELECT * FROM event WHERE name='$searchString'") or die(mysql_error());
	$row = mysql_fetch_array($result);
	if($row['id']!='' && $row['id']!=null && $link==null){
		echo '<script type="text/javascript">
		<!--
		window.location="http://albertyw.mit.edu/6470/event/'.$row['id'].'/"
		//-->
		</script>';
	}
}

include("/opt/lampp/htdocs/6470/include/footer.php");
?>
