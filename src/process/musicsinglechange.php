<?php
//Get Variables
$newvalue = $_POST['newName'];
$musicid =$_POST['musicID'];
$changewhat = $_POST['changeWhat'];

//Open mySQL Connection
$connection = mysql_connect("localhost", "6470", "6470") or die("mySQL Connection Error<br />\n");
$database='6470_main';
mysql_select_db($database) or die('Error, could not access database '.$database."\n");

include("/opt/lampp/htdocs/6470/include/phpxssfilter.php");

if($newvalue!=mysql_real_escape_string(htmlentities(RemoveXSS($newvalue)))){
	die("improperformat");
}

//Find what column in database to change, check values
if($changewhat=='changeName'){
	$column = 'name';
	if(strlen($newvalue)>100)//Check length
		die("toolong");
}
if($changeWhat=='changeCollege'){
	$column = 'collegeid';
	//check to make sure college exists
	$collegeresult = mysql_query("SELECT * FROM college WHERE college='$newvalue'") or die(mysql_error());
	$collegerow = mysql_fetch_array($collegeresult);
	if($collegerow['id']=='' || $collegerow['id']==null){
		die("wrongcollege");
	}else{
		//find college id
		$newvalue = $collegerow['id'];
	}
}
if($changeWhat=='changeArticle'){
	$column = 'article';
}

//Checking is finished, update the database
mysql_query("UPDATE music SET $column = '$newvalue' WHERE id = '$musicid'") or die(mysql_error());
echo 'accept';
?>
