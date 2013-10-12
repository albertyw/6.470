<?php
/*
ADDRESS:	HTTP://ALBERTYW.MIT.EDU/6470/BANDSADD.PHP
STATUS:		MAINTENANCE NEEDED: NEEDS CSS, MAYBE TURN THIS INTO AJAX
LAST MODIFIED:	JANUARY 23, 2009
DESCRIPTION:	ALLOWS A PERSON TO ADD A BAND TO THE DATABASE
USAGE:		PUBLIC
*/
//jQueryUI PHP Calls

//End jQuery UI Calls
$login=false;
if(isset($_SESSION['username']) && $_SESSION['username']!=''){//See if person is logged in
	$login=true;
	$username=$_SESSION['username'];
}
$title='molemusic | Add Bands';
$googlemaps=false;
$freebase=false;
session_start();
include("/opt/lampp/htdocs/6470/include/headeropen.php");
echo '<script type="text/javascript" src="http://albertyw.mit.edu/6470/include/bandsadd.js"></script>';
echo '<script type="text/javascript" src="http://albertyw.mit.edu/6470/include/jquery.autocomplete.js"></script>';
echo '<link rel="stylesheet" type="text/css" href="http://albertyw.mit.edu/6470/include/jquery.autocomplete.css" />';
include("/opt/lampp/htdocs/6470/include/headertext.php");?>

<center><h1>Add New Bands</h1></center><br />

<form enctype="multipart/form-data" action="http://albertyw.mit.edu/6470/process/bandsadd.php" method="POST">
Band Name: <input type="text" size="50" name="bandname" /><br />
Picture: <input type="file" name="uploadedfile"><br />
College: <input type="text" size="50" name="collegename" id="collegename"/><br />
Description:<br />
<textarea name="article"></textarea><br />
<input type="submit" value="Add A Band" />
</form>



<?php include("/opt/lampp/htdocs/6470/include/footer.php");?>






<?php
//FUNCTIONS IN HERE

?>
