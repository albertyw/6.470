<?php
include("/opt/lampp/htdocs/6470/include/phpxssfilter.php");

//Get Variables
$searchString = $_POST['searchString'];
$typeband = $_POST['typeband'];
$typemusic = $_POST['typemusic'];
$typecollege = $_POST['typecollege'];
$typeevent = $_POST['typeevent'];

if($searchString !=mysql_real_escape_string(htmlentities(RemoveXSS($searchString)))){
	die("improper formatting");
}

//Open mySQL Connection
$connection = mysql_connect("localhost", "6470", "6470") or die("mySQL Connection Error<br />\n");
$database='6470_main';
mysql_select_db($database) or die('Error, could not access database '.$database."\n");

if($typeband ==true){
	//Search for the string in the band database
	$result = mysql_query("SELECT * FROM band WHERE name='$searchString'") or die(mysql_error());
	$row = mysql_fetch_array($result);
	if($row['id']!='' && $row['id']!=null){
		echo '<script type="text/javascript">
		<!--
		window.location="http://albertyw.mit.edu/6470/bands/'.$row['id'].'/";
		-->
		</script>';
		$link=true;
	}
}
if($typemusic == true){
	//Search for the string in the band database
	$result = mysql_query("SELECT * FROM music WHERE name='$searchString'") or die(mysql_error());
	$row = mysql_fetch_array($result);
	if($row['id']!='' && $row['id']!=null && $link==null){
		echo '<script type="text/javascript">
		<!--
		window.location="http://albertyw.mit.edu/6470/music/'.$row['id'].'/"
		//-->
		</script>';
		$link=true;
	}
}
if($typecollege == true){
	//Search for the string in the band database
	$result = mysql_query("SELECT * FROM college WHERE college='$searchString'") or die(mysql_error());
	$row = mysql_fetch_array($result);
	if($row['id']!='' && $row['id']!=null && $link==null){
		echo '<script type="text/javascript">
		<!--
		window.location="http://albertyw.mit.edu/6470/college/'.$row['id'].'/"
		//-->
		</script>';
		$link=true;
	}
}
if($typeevent == true){
	//Search for the string in the band database
	$result = mysql_query("SELECT * FROM event WHERE name='$searchString'") or die(mysql_error());
	$row = mysql_fetch_array($result);
	if($row['id']!='' && $row['id']!=null && $link==null){
		echo '<script type="text/javascript">
		<!--
		window.location="http://albertyw.mit.edu/6470/event/'.$row['id'].'/"
		//-->
		</script>';
		$link=true;
	}
}
if($link==false){//No exact matches found, redirect to search page
	echo '<script type="text/javascript">
	<!--
	window.location = "http://albertyw.mit.edu/6470/search.php?searchstring='.$string.'"
	//-->
	</script>';
}

?>
