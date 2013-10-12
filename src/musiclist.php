<?php
/*
ADDRESS:	HTTP://ALBERTYW.MIT.EDU/6470/MUSICLIST.PHP
STATUS:		FINISHED
LAST MODIFIED:	JANUARY 26, 2009
DESCRIPTION:	LISTS ALL MUSIC
USAGE:		PUBLIC
*/
//Nifty Cube Corners Javascript Calls

//End Nifty Cube Calls
//jQueryUI PHP Calls

//End jQuery UI Calls
$login=false;
if(isset($_SESSION['username']) && $_SESSION['username']!=''){//See if person is logged in
	$login=true;
	$username=$_SESSION['username'];
}
$title='molemusic | List Music';
$googlemaps=false;
$freebase=false;
session_start();
include("/opt/lampp/htdocs/6470/include/headeropen.php");
echo '<script type="text/javascript" src="http://albertyw.mit.edu/6470/include/musiclist.js"></script>';
include("/opt/lampp/htdocs/6470/include/headertext.php");?>

<center><h1>List All Music</h1></center><br />

<div id="viewmusic"></div>


<?php include("/opt/lampp/htdocs/6470/include/footer.php");?>






<?php
//FUNCTIONS IN HERE

?>
