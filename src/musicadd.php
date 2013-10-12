<?php
/*
ADDRESS:	HTTP://ALBERTYW.MIT.EDU/6470/MUSICADD.PHP
STATUS:		MAINTENANCE NEEDED: NEEDS CSS, MAYBE TURN THIS INTO AJAX
LAST MODIFIED:	JANUARY 23, 2009
DESCRIPTION:	ALLOWS A PERSON TO ADD A MUSIC TO THE DATABASE
USAGE:		PUBLIC
*/
//jQueryUI PHP Calls

//End jQuery UI Calls
//See if this is for a specific band
$bandid=$_GET['bandid'];

$login=false;
if(isset($_SESSION['username']) && $_SESSION['username']!=''){//See if person is logged in
	$login=true;
	$username=$_SESSION['username'];
}
$title='molemusic | Add Music';
$googlemaps=false;
$freebase=false;
session_start();
include("/opt/lampp/htdocs/6470/include/headeropen.php");
echo '<script type="text/javascript" src="http://albertyw.mit.edu/6470/include/bandauto.js"></script>';
echo '<script type="text/javascript" src="http://albertyw.mit.edu/6470/include/jquery.autocomplete.js"></script>';
echo '<link rel="stylesheet" type="text/css" href="http://albertyw.mit.edu/6470/include/jquery.autocomplete.css" />';
include("/opt/lampp/htdocs/6470/include/headertext.php");?>

<center><h1>Add New Music</h1></center><br />

<form enctype="multipart/form-data" action="http://albertyw.mit.edu/6470/process/musicadd.php" method="POST">
Name: <input type="text" size="50" name="musicname" /><br />
Album: <input type="text" size="50" name="album" /><br />
Track Number: <input type="text" size="2" name="trackno" /><br />
Picture: <input type="file" name="uploadedfile"><br />
<?php
if($bandid=='' || $bandid==null){
	echo 'Band: <input type="text" size="50" name="bandname" id="bandname"/><br />';
}else{
	$result = mysql_query("SELECT * FROM band WHERE id='$bandid'") or die(mysql_error());
	$row = mysql_fetch_array($result);
	echo 'Band: <input type="text" size="50" name="bandname" id="bandname" value="'.$row['name'].'"/><br />';
}
?>
Description:<br />
<textarea name="article"></textarea><br />
<input type="submit" value="Add Music" />
</form>



<?php include("/opt/lampp/htdocs/6470/include/footer.php");?>






<?php
//FUNCTIONS IN HERE

?>
