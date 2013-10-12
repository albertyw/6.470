<?php
/*
ADDRESS:	HTTP://ALBERTYW.MIT.EDU/6470/PROCESS/LOGOUT.PHP
STATUS:		UNFINISHED
LAST MODIFIED:	JANUARY 16, 2008 BY ALBERT WANG
DESCRIPTION:	LOGOUTS A USER
USAGE:		HIDDEN
*/
//Nifty Cube Corners Javascript Calls

//End Nifty Cube Calls
//jQueryUI PHP Calls

//End jQuery UI Calls
session_start();
if(isset($_SESSION['username'])){
	session_unset();
	session_destroy();//END session for security
}
$title='Logout processing';
$headtext='';
$googlemaps=false;
$freebase=false;
include("/opt/lampp/htdocs/6470/include/headeropen.php");
include("/opt/lampp/htdocs/6470/include/headertext.php");?>

<center><h1>Logout Processing</h1></center><br />

You have been logged out.


<?php include("/opt/lampp/htdocs/6470/include/footer.php");?>






<?php
//FUNCTIONS IN HERE

?>
