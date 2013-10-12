<?php
/*
ADDRESS:	HTTP://ALBERTYW.MIT.EDU/6470/PROCESS/REGISTRATIONCONFIRM.PHP
STATUS:		MAINTENANCE NEEDED: ADDITION OF CSS/DESIGN/LAYOUT
LAST MODIFIED:	JANUARY 13, 2009  BY ALBERT WANG
DESCRIPTION:	USERS ARE DIRECTED TO THIS PAGE TO CONFIRM THEIR REGISTRATION
USAGE:		PUBLIC
*/
//Nifty Cube Corners Javascript Calls

//End Nifty Cube Calls
//jQueryUI PHP Calls

//End jQuery UI Calls
$confirm=$_GET['code'];

$title='Registration Confirmation';
$googlemaps=false;
$freebase=false;
include("/opt/lampp/htdocs/6470/include/headeropen.php");?>
<?php include("/opt/lampp/htdocs/6470/include/headertext.php");

//FIND user in usertemporary table
$result = mysql_query("SELECT * FROM usertemporary
	WHERE confirmationcode='$confirm'") or die(mysql_error());
$row = mysql_fetch_array($result);
$username = $row['username'];
if($username != ''){//Make sure the user is found
	//Read variables
	$password = $row['password'];
	$realname = $row['realname'];
	$registerdate = date('Y-m-d');
	$collegeid = $row['collegeid'];
	$email = $row['email'];

	//MOVE user to user table
	mysql_query("INSERT INTO user
		(username, password, realname, registerdate, collegeid, email)
		VALUES('$username', '$password', '$realname', '$registerdate', '$collegeid', '$email' ) ")
		or die(mysql_error());

	//DELETE user in usertemporary table
	mysql_query("DELETE FROM usertemporary WHERE confirmationcode='$confirm'")
	or die(mysql_error());

	//Make a message and allow the user to log in
	$message = "Thank you for your registration.  You can log in now:
	<div id=\"loginmessage\"></div>
	Login: <input type=\"text\" length=\"20\" name=\"username\" /><br />
	Password: <input type=\"password\" length=\"20\" name=\"password\" /><br />
	<input type=\"button\" length=\"20\" value=\"Log In\" onclick=\"submitlogin()\" /><br />";
}else{//If the username isn't found, then the code isn't correct
	$message = "Your confirmation code is incorrect.  Make sure the link from your email is correct.";
}
?>

<center><h1>Registration Confirmation</h1></center><br />

<?php echo $message ?>



<?php include("/opt/lampp/htdocs/6470/include/footer.php");?>






<?php
//FUNCTIONS IN HERE

?>
