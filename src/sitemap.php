<?php
/*
ADDRESS:	HTTP://ALBERTYW.MIT.EDU/6470/ABOUTUS.PHP
STATUS:		MAINTANANCE NEEDED: MAYBE DIFFERENT TEXT
LAST MODIFIED:	JANUARY 19, 2009
DESCRIPTION:	PAGE WITH INFORMATION ABOUT US
USAGE:		PUBLIC
*/
//jQueryUI PHP Calls

//End jQuery UI Calls
$title='molemusic | Site Map';
$googlemaps=false;
session_start();
include("/opt/lampp/htdocs/6470/include/headeropen.php");
//head stuff here
include("/opt/lampp/htdocs/6470/include/headertext.php");?>

<center><h1>Site Map</h1></center><br />

<ul>
<li><a href="http://albertyw.mit.edu/6470/">Home</a></li>
<li><ul>
<li>User/Profile Info</li>
<li><a href="http://albertyw.mit.edu/6470/login/">Login</a></li>
<li><a href="http://albertyw.mit.edu/6470/user/">Your User Page</a></li>
<li><a href="http://albertyw.mit.edu/6470/profile/">Your Profile</a></li>
<li><a href="http://albertyw.mit.edu/6470/logout/">Log Out</a></li>
</ul></li>

<li><ul>
<li>Music Info</li>
<li><a href="http://albertyw.mit.edu/6470/bands/">Bands</a></li>
<li><a href="http://albertyw.mit.edu/6470/music/">Music</a></li>
<li><a href="http://albertyw.mit.edu/6470/colleges/">Colleges</a></li>
<li><a href="http://albertyw.mit.edu/6470/events/">Events</a></li>
</ul></li>

<li><ul>
<li>Other</li>
<li><a href="http://albertyw.mit.edu/6470/aboutus/">About Us</a></li>
<li><a href="http://albertyw.mit.edu/6470/sitemap/">Sitemap</a></li>
<li><a href="http://albertyw.mit.edu/6470/tos/">Terms of Service</a></li>
<li><a href="http://albertyw.mit.edu/6470/contact/">Contact Us</a></li>
</ul></li>

</ul>


<?php include("/opt/lampp/htdocs/6470/include/footer.php");?>






<?php
//FUNCTIONS IN HERE

?>
