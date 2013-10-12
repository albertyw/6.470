<?php
/*
ADDRESS:	HTTP://ALBERTYW.MIT.EDU/6470/COLLEGELIST.PHP
STATUS:		FINISHED
LAST MODIFIED:	JANUARY 26, 2009
DESCRIPTION:	LISTS ALL COLLEGE
USAGE:		PUBLIC
*/
//Nifty Cube Corners Javascript Calls

//End Nifty Cube Calls
//jQueryUI PHP Calls

//End jQuery UI Calls
$login=false;
if(isset($_SESSION['usercollege']) && $_SESSION['usercollege']!=''){//See if person is logged in
	$login=true;
	$usercollege=$_SESSION['usercollege'];
}
$title='molecollege | List College';
$googlemaps=false;
$freebase=false;
session_start();
include("/opt/lampp/htdocs/6470/include/headeropen.php");
echo '<script type="text/javascript" src="http://albertyw.mit.edu/6470/include/collegelist.js"></script>';
include("/opt/lampp/htdocs/6470/include/headertext.php");?>

<center><h1>List All Colleges</h1></center><br />

<div id="viewcollege"></div>


<?php include("/opt/lampp/htdocs/6470/include/footer.php");?>






<?php
//FUNCTIONS IN HERE

?>
