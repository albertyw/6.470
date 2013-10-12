<?php
/*
ADDRESS:	HTTP://ALBERTYW.MIT.EDU/6470/PROCESS/REGISTRATIONCAPTCHA.PHP
STATUS:
LAST MODIFIED:	JANUARY 15, 2009 BY ALBERT WANG
DESCRIPTION:	GENERATES A CAPTCHA AND KEY FOR /REGISTER.PHP
USAGE:		HIDDEN
*/

$registrationtop = $_POST['registrationtop'];

//Make two Random numbers for the person to captcha
$firstint = rand(0,100);
$secondint = rand(0,100);
//Find the answer that the person needs
$answer = $firstint+$secondint;
//Generate a keycode for javascript
$captchakey=rand(0,1000);

//Open mySQL Connection
$connection = mysql_connect("localhost", "6470", "6470") or die("mySQL Connection Error<br />\n");
$database='6470_main';
mysql_select_db($database) or die('Error, could not access database '.$database."\n");

//Insert into table
$result = mysql_query("INSERT INTO captcha (answer, captchakey) VALUES('$answer', '$captchakey') ") or die(mysql_error());

if($registrationtop==true){
	$extra='register';
}
//Make the message
$message = "What is ".$firstint." + ".$secondint."? <input type=\\\"text\\\" length=\\\"3\\\" id=\\\"captchaanswer$extra\\\"><br />";
//Send the message
$json = '{"message":"'.$message.'","captchakey":"'.$captchakey.'"}';
echo $json;
?>
