<?php
/*
ADDRESS:	HTTP://ALBERTYW.MIT.EDU/6470/PROCESS/BANDLIST.PHP
STATUS:		FINISHED
LAST MODIFIED:	JANUARY 26, 2009
DESCRIPTION:	AJAX FUNCTION TO RETURN BANDS
USAGE:		PUBLIC
*/
$startid = $_POST['startid'];
$numberList = $_POST['numberList'];

//Open mySQL Connection
$connection = mysql_connect("localhost", "6470", "6470") or die("mySQL Connection Error<br />\n");
$database='6470_main';
mysql_select_db($database) or die('Error, could not access database '.$database."\n");

$endid = $startid+$numberList;
while($startid<$endid){
	$result = mysql_query("SELECT * FROM band WHERE id=$startid") or die(mysql_error());
	$row = mysql_fetch_array($result);
	if($row['id']!=null && $row['id']!='')
	{
		echo $startid.'.  ';//ID of the Band
		echo '<a href="http://albertyw.mit.edu/6470/bands/'.$startid.'/">'.$row['name'].'</a>';  //Name of the Band
		echo $row['views'].'<br />';  //Views
	}
	$startid++;
}
?>
