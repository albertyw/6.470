<?php
/*
ADDRESS:	HTTP://ALBERTYW.MIT.EDU/6470/...
STATUS:		UNFINISHED/MAINTANANCE NEEDED/FINISHED
LAST MODIFIED:	JANUARY 17, 2009
DESCRIPTION:	TEMPLATE.  USE THIS WHEN CREATING OTHER PAGES.
USAGE:		PUBLIC/HIDDEN/OFFLINE
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
$title='TEMPLATE';
$googlemaps=false;
$freebase=false;
session_start();
include("/opt/lampp/htdocs/6470/include/headeropen.php");
//head stuff here
include("/opt/lampp/htdocs/6470/include/headertext.php");?>

<center><h1><!--Title Here !--></h1></center><br />

<!--Content Here !-->


<?php include("/opt/lampp/htdocs/6470/include/footer.php");?>






<?php
//FUNCTIONS IN HERE

?>
