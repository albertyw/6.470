<?php
/*
ADDRESS:	HTTP://ALBERTYW.MIT.EDU/6470/RETRIEVELOGIN.PHP
STATUS:		MAINTANANCE NEEDED: NEED STYLESHEETING
LAST MODIFIED:	JANUARY 17, 2008 BY ALBERT WANG
DESCRIPTION:	ALLOWS THE USER TO TYPE IN AN EMAIL TO RETRIEVE THEIR LOGIN
USAGE:		PUBLIC
*/
//jQueryUI PHP Calls

//End jQuery UI Calls
$login=false;
if(isset($_SESSION['username']) && $_SESSION['username']!=''){//See if person is logged in
	$login=true;
	$username=$_SESSION['username'];
}
$title='molemusic | Retrieve Your Login';
$googlemaps=false;
$freebase=false;
session_start();
include("/opt/lampp/htdocs/6470/include/headeropen.php");?>
<script type="text/javascript">
//Called when the retrieve login is pressed
function retrievelogin()  {
	$("#loginmessage").empty();
	//Find username and password values from form
	var email = $(':input').val();
	$.post(
		"http://albertyw.mit.edu/6470/process/retrievelogin.php", //argument #1 - the server file where the request is sent
		{
			email: email, //argument #2 - the data to be sent
		},
		function(txt){ //argument#3 - process the return text
			if(txt=="An email with your login and new password was sent")
				$("#formcontents").html(txt);
			if(txt=="Your email was not found")
				$("#loginmessage").html(txt);
		}
	)
};
</script>
<?php include("/opt/lampp/htdocs/6470/include/headertext.php");?>

<center><h1>Retrieve your Login</h1></center><br />

<div id="formcontents">
<div id="loginmessage"></div>
Your email: <input type="text" length="20" name="email" /><br />
<input type="button" length="20" value="Retrieve" onclick="retrievelogin()" /><br />
<div id="loginretrieve"><a href="http://albertyw.mit.edu/6470/login/">Login</a></div>
</div>


<?php include("/opt/lampp/htdocs/6470/include/footer.php");?>






<?php
//FUNCTIONS IN HERE

?>
