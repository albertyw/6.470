<?php
$bandid = $_POST['bandid'];
$ownprofile = $_POST['ownprofile'];

if($ownprofile=='false'){//Make sure the delete is allowed
	echo '{"accept":false}';
	die();
}
//Open mySQL Connection
$connection = mysql_connect("localhost", "6470", "6470") or die("mySQL Connection Error<br />\n");
$database='6470_main';
mysql_select_db($database) or die('Error, could not access database '.$database."\n");

//Delete Query
mysql_query("DELETE FROM userbandfav WHERE id = '$bandid'") or die(mysql_query());

echo '{"accept":true}';

?>
