<?php
//Get the letters from register.php
$letters = $_GET['q'];
//Connect to mysql database
$connection = mysql_connect("localhost", "6470", "6470") or die("mySQL Connection Error<br />\n");
$database='6470_main';
mysql_select_db($database) or die('Error, could not access database '.$database."\n");


//Find college names starting with $letters
$result = mysql_query("SELECT * FROM college WHERE college LIKE '$letters%' ORDER BY college") or die(mysql_error());

while ($row = mysql_fetch_array($result)) {
	echo $row['college']."\n";
}

?>
