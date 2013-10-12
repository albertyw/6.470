<?php
/*
ADDRESS:	HTTP://ALBERTYW.MIT.EDU/6470/PROCESS/REGISTRATIONCHECK.PHP
STATUS:		MAINTENANCE NEEDED: DEBUG/TEST/CHANGE TEXT FOR EMAIL SCRIPT AT LINES 129-140
LAST MODIFIED:	JANUARY 13, 2009 BY ALBERT WANG
DESCRIPTION:	ALLOWS VISITORS TO REGISTER FOR AN ACCOUNT
USAGE:		PUBLIC
*/
//Need to remove XSS Attacks
include("/opt/lampp/htdocs/6470/include/phpxssfilter.php");

//Get variables
$username = $_POST['username'];
$password = $_POST['password'];
$realname = $_POST['realname'];
$college = $_POST['college'];
$email = $_POST['email'];
$captchaanswer = $_POST['captchaanswer'];
$captchakey = $_POST['captchakey'];

//Connect to Database
$connection = mysql_connect("localhost", "6470", "6470") or die("mySQL Connection Error<br />\n");
$database='6470_main';
mysql_select_db($database) or die('Error, could not access database '.$database."\n");


//Start return variable
$return = '{';
//True to input into mysql, false, to reject
$registration=true;

$result = mysql_query("SELECT * FROM captcha WHERE captchakey = '$captchakey'") or die(mysql_error());
$row = mysql_fetch_array($result);
if($row['answer']!=$captchaanswer){
	die("{\"captcha\":false}");
}

//Make sure there aren't HTML, mysql injection, and XSS attacks                 Check to make sure proper characters         make sure correct length
if($username != htmlentities(mysql_real_escape_string(RemoveXSS($username))) || ereg('[^A-Za-z0-9]', $username) || strlen($username)>20 || strlen($username)<5){
	$return .= '"usernameformat":false,';
	$registration=false;
}else{
	$return .= '"usernameformat":true,';
}
if($password != htmlentities(mysql_real_escape_string(RemoveXSS($password))) || ereg('[^A-Za-z0-9]', $password) || strlen($password)!=40 || $password == "da39a3ee5e6b4b0d3255bfef95601890afd80709"){
	$return .= '"passwordformat":false,';
	$registration=false;
}else{
	$return .= '"passwordformat":true,';
}
if(ereg('[^a-zA-Z ]', $realname)){
	$return .= '"realnameformat":false,';
	$registration=false;
}else{
	$return .= '"realnameformat":true,';
}
if($college != htmlentities(mysql_real_escape_string(RemoveXSS($college)))){
	$return .= '"collegeformat":false,';
	$registration=false;
}else{
	$return .= '"collegeformat":true,';
}
if($email != htmlentities(mysql_real_escape_string(RemoveXSS($email))) || ereg('\b[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b', $email) || strlen($email)>20 || strlen($email)<5){
	$return .= '"emailformat":false,';
	$registration=false;
}else{
	$return .= '"emailformat":true,';
}


//See if Username is already taken in regular user table
$result = mysql_query("SELECT * FROM user WHERE username='$username'") or die(mysql_error());
$row=mysql_fetch_array($result);
if($row['username']==$username){
	$return .= '"usernamefree": false,';
	$registration=false;
}else{//See if username is in usertemporary table
	$result = mysql_query("SELECT * FROM usertemporary WHERE username='$username'") or die(mysql_error());
	$row=mysql_fetch_array($result);
	if($row['username']==$username && $username!=''){
		$return .= '"usernamefree": false,';
		$registration=false;
	}else{
		$return.= '"usernamefree": true,';
	}
}

//See if email is already taken in user table
$result = mysql_query("SELECT * FROM user WHERE email='$email'") or die(mysql_error());
$row=mysql_fetch_array($result);
if($row['email']==$email){
	$return .= '"emailfree": false,';
	$registration=false;
}else{//See if email is already taken in usertemporary table
	$result = mysql_query("SELECT * FROM usertemporary WHERE email='$email'") or die(mysql_error());
	$row=mysql_fetch_array($result);
	if($row['email']==$email){
		$return .= '"emailfree": false,';
		$registration=false;
	}else{
		$return.= '"emailfree": true,';
	}
}

//See if college is correct
$college = strtolower($college);
$result = mysql_query("SELECT * FROM college WHERE LCASE(college)='$college'") or die(mysql_error());
$row=mysql_fetch_array($result);
if(strtolower($row['college'])!=$college || $college=='' || $college==null){
	$return .= '"collegecorrect": false,';
	$registration=false;
}else{
	$return.= '"collegecorrect": true,';
}

//If $registration is still true, then send into database
if($registration==true){
	$return .='"registered":true,';
	//Find the college code
	$result = mysql_query("SELECT * FROM college WHERE LCASE(college)='$college'") or die(mysql_error());
	$row=mysql_fetch_array($result);
	$collegeid = $row['id'];

	//Generate a confirmation code by random numbers
	$confirmationcode = rand(1000000000,9999999999);

	//Change email to add @domain.edu if needed
	$result = mysql_query("SELECT * FROM college WHERE LCASE(college)='$college'") or die(mysql_error());
	$row=mysql_fetch_array($result);
	$pos = strpos($email, $row['emaildomain']);
	$pos2 = strpos($email, "@");
	if($pos === false && $pos2 === false){
		$email = $email."@".$row['emaildomain'];
	}

	//Send to temporary database table
	mysql_query("INSERT INTO usertemporary
		(username, password, realname, collegeid, email, confirmationcode)
		VALUES('$username', '$password', '$realname', '$collegeid', '$email', '$confirmationcode') ")
		or die(mysql_error());

	//Send email

	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$headers .= 'From: no-reply@albertyw.mit.edu';
	//Make the message
	$message = "<html><head><title>Welcome to molemusic!</title></head><body>
	Welcome to molemusic!  We need you to confirm your email address with us.  <br />
	Please go to the link below:<br />
	<a href=\"http://albertyw.mit.edu/6470/process/registrationconfirm.php?code=".$confirmationcode."\">
	http://albertyw.mit.edu/6470/process/registrationconfirm.php?code=".$confirmationcode."</a><br />
	<br />
	Thank you,<br />
	The molemusic Team</body></html>";
	mail( $email, "molemusic Registration Confirmation", $message, $headers );//Send confirmation email
}else{//Something was wrong with the form, send back
	$return .='"registered":false,';
}
$return .='}';//End the JSON string object
echo $return;//Output the JSON string
?>
