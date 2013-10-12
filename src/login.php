<?php
/*
ADDRESS:	HTTP://ALBERTYW.MIT.EDU/6470/LOGIN.PHP
STATUS:		MAINTENANCE NEEDED: BASIC CODING FINISHED.  NEED FORMATTING, SUBMIT SHOULD RESPOND TO ENTER BUTTON
LAST MODIFIED:	JANUARY 11, 2009 by ALBERT WANG
DESCRIPTION:	ALLOWS USER TO LOG INTO ACCOUNT, POSSIBLY WILL BE INCLUDED AS PULL-DOWN TAB
USAGE:		PUBLIC
*/
//Nifty Cube Corners Javascript Calls

//End Nifty Cube Calls
//jQueryUI PHP Calls

//End jQuery UI Calls

session_start();
//If index.php is being loaded in http:, redirect to https: because of passwords
$title='molemusic | login';
$googlemaps=false;
$freebase=false;
include("/opt/lampp/htdocs/6470/include/headeropen.php");
if(isset($_SESSION['username']) && $_SESSION['username']!=''){//If the user is already logged in, redirect to profile page
	echo '<script type="text/javascript">
	<!--
	window.location = "http://albertyw.mit.edu/6470/profile/"
	//-->
	</script>
	';
}?>
<?php include("/opt/lampp/htdocs/6470/include/headertext.php");?>



<div id="loginmessage"></div>
Login: <input type="text" length="20" id="username" /><br />
Password: <input type="password" length="20" id="password" /><br />
<input type="button" length="20" value="Log In" onclick="submitlogin()" /><br />
<div id="loginretrieve"><a href="http://albertyw.mit.edu/6470/retrievelogin/">Forgot your login?</a></div>

<br />
<br />
<h2><a href="register.php">Register</a></h2>

<?php include("/opt/lampp/htdocs/6470/include/footer.php");?>






<?php
//FUNCTIONS IN HERE

?>
