<?php
/*
ADDRESS:	HTTP://ALBERTYW.MIT.EDU/6470/RETRIEVELOGIN.PHP
STATUS:		FINISHED
LAST MODIFIED:	JANUARY 17, 2008 BY ALBERT WANG
DESCRIPTION:	ALLOWS THE USER TO TYPE IN AN EMAIL TO RETRIEVE THEIR LOGIN
USAGE:		PUBLIC
*/
$email = $_POST['email'];

//Use RemoveXSS
include("/opt/lampp/htdocs/6470/include/phpxssfilter.php");
//Check to make sure the email is not null or malformed
if($email == '' || $email != mysql_real_escape_string(RemoveXSS($email))){
	die("Your email was not found");
}

//Open mySQL Connection
$connection = mysql_connect("localhost", "6470", "6470") or die("mySQL Connection Error<br />\n");
$database='6470_main';
mysql_select_db($database) or die('Error, could not access database '.$database."\n");

//Search for the email
$result = mysql_query("SELECT * FROM user WHERE email = '$email'");
$row = mysql_fetch_array($result);
if($row['email']==$email){//Email found
	echo 'An email with your login and new password was sent';
	$username = $row['username'];
	//Generate a new password
	$newpassword = rand(0,10000);

	//Send email
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$headers .= 'From: no-reply@albertyw.mit.edu';
	//Make the message
	$message = "<html><head><title>molemusic Password Retrieval</title></head><body>
	Your username is: $username <br />
	Your password is: $newpassword <br />
	<br />
	If you did not ask for your password to be reset, please contact abuse@albertyw.mit.edu.<br />
	<br />
	Thank you,<br />
	The molemusic Team</body></html>";
	mail( $email, "molemusic Registration Confirmation", $message, $headers );//Send confirmation email

	//Update the Database
	mysql_query("UPDATE user SET password = '$newpassword' WHERE username='$username'");
}else{//Email not found
	echo 'Your email was not found';
}

?>
