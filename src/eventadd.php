<?php
/*
ADDRESS:	HTTP://ALBERTYW.MIT.EDU/6470/EVENTADD.PHP
STATUS:		MAINTENANCE NEEDED: NEEDS CSS, MAYBE TURN THIS INTO AJAX
LAST MODIFIED:	JANUARY 23, 2009
DESCRIPTION:	ALLOWS A PERSON TO ADD A EVENT TO THE DATABASE
USAGE:		PUBLIC
*/
//jQueryUI PHP Calls

//End jQuery UI Calls
//See if this is from a specific band or music
$bandid=$_GET['bandid'];
$musicid=$_GET['musicid'];

$login=false;
if(isset($_SESSION['username']) && $_SESSION['username']!=''){//See if person is logged in
	$login=true;
	$username=$_SESSION['username'];
}
$title='moleevent | Add Event';
$googlemaps=false;
$freebase=false;
session_start();
include("/opt/lampp/htdocs/6470/include/headeropen.php");
echo '<script type="text/javascript" src="http://albertyw.mit.edu/6470/include/bandauto.js"></script>';
echo '<script type="text/javascript" src="http://albertyw.mit.edu/6470/include/musicauto.js"></script>';
echo '<script type="text/javascript" src="http://albertyw.mit.edu/6470/include/jquery.autocomplete.js"></script>';
echo '<link rel="stylesheet" type="text/css" href="http://albertyw.mit.edu/6470/include/jquery.autocomplete.css" />';
include("/opt/lampp/htdocs/6470/include/headertext.php");?>

<center><h1>Add New Event</h1></center><br />

<form enctype="multipart/form-data" action="http://albertyw.mit.edu/6470/process/eventadd.php" method="POST">
Name: <input type="text" size="50" name="eventname" /><br />
Date: <input type="text" size="2" name="month" value="MM"/> -
<input type="text" size="2" name="day" value="DD"/> -
20<input type="text" size="2" name="year" value="YY"/>
<br />
Time: <input type="text" size="2" name="hour" value="HH"/>:
<input type="text" size="2" name="minute" value="MM"/>
<br />
Address 1: <input type="text" size="50" name="address1" /><br />
Address 2: <input type="text" size="50" name="address2" /><br />
Bands: <input type="text" size="50" id="bandname" /><br />
Music: <input type="text" size="50" id="musicname" /><br />
Description:<textarea name="article"></textarea><br />
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
<input type="submit" value="Add Event" />
</form>



<?php include("/opt/lampp/htdocs/6470/include/footer.php");?>






<?php
//FUNCTIONS IN HERE

?>
