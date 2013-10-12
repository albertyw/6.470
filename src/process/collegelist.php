<?php
/*
ADDRESS:	HTTP://ALBERTYW.MIT.EDU/6470/PROCESS/COLLEGELIST.PHP
STATUS:		FINISHED
LAST MODIFIED:	JANUARY 26, 2009
DESCRIPTION:	AJAX FUNCTION TO RETURN COLLEGE
USAGE:		PUBLIC
*/
$startid = $_POST['startid'];
$numberList = $_POST['numberList'];

//Open mySQL Connection
$connection = mysql_connect("localhost", "6470", "6470") or die("mySQL Connection Error<br />\n");
$database='6470_main';
mysql_select_db($database) or die('Error, could not access database '.$database."\n");

//Find the max number

$endid = $startid+$numberList;
while($startid<$endid && $totalruns<50){
	$result = mysql_query("SELECT * FROM college WHERE id=$startid") or die(mysql_error());
	$row = mysql_fetch_array($result);
	if($row['id']==null){
		$startid++;
		$endid++;
		$totalruns++;
	}else{
		echo $startid.'.  ';//ID of the College
		echo '<a href="http://albertyw.mit.edu/6470/college/'.$startid.'/">'.$row['college'].'</a><br />';  //College of the College
		$result = mysql_query("SELECT * FROM user WHERE collegeid='$startid'") or die(mysql_error());
		echo 'molemusic members: '.mysql_num_rows($result).'<br />';
		$startid++;
		$totalruns++;
	}
}
?>
