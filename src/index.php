<?php
/*
ADDRESS:	HTTP://ALBERTYW.MIT.EDU/6470/INDEX.PHP
STATUS:		MAINTENANCE NEEDED: BASIC CODING FINISHED.  NEED FORMATTING, SUBMIT SHOULD RESPOND TO ENTER BUTTON
LAST MODIFIED:	JANUARY 11, 2009 by ALBERT WANG
DESCRIPTION:	HOME PAGE FOR WEBSITE
USAGE:		PUBLIC
*/
//Nifty Cube Corners Javascript Calls

//End Nifty Cube Calls
//jQueryUI PHP Calls

//End jQuery UI Calls

session_start();
//If index.php is being loaded in http:, redirect to https: because of passwords
$title='molemusic';
$googlemaps=false;
$freebase=false;
include("/opt/lampp/htdocs/6470/include/headeropen.php");?>
<?php include("/opt/lampp/htdocs/6470/include/headertext.php");?>

<h1>Welcome</h1>
<p>molemusic connects your college and your music together.</p>
<p>Start by making your own <a href="http://albertyw.mit.edu/6470/register/">profile</a> and begin exploring your favorite bands!</p>
<!--
<a href="http://albertyw.mit.edu/6470/bands/">Bands</a>
<a href="http://albertyw.mit.edu/6470/music/">Music</a>
<a href="http://albertyw.mit.edu/6470/college/">Colleges</a>
<a href="http://albertyw.mit.edu/6470/event/">Events</a><br />
<a href="http://albertyw.mit.edu/6470/aboutus/">About Us</a> -->


<?php include("/opt/lampp/htdocs/6470/include/footer.php");?>






<?php
//FUNCTIONS IN HERE

?>
