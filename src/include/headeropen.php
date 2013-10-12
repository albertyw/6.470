<?php
/*
ADDRESS:	HTTP://ALBERTYW.MIT.EDU/6470/INCLUDE/HEADEROPEN.PHP
STATUS:		UNFINISHED
LAST MODIFIED:	JANUARY 25, 2008 by dsngiem
DESCRIPTION:	THE NOT TOTALLY VISIBLE HEADER STUFF (E.G. <HEAD></HEAD>)
USAGE:		HIDDEN
*/
?>

<?php
//Open mySQL Connection
$connection = mysql_connect("localhost", "6470", "6470") or die("mySQL Connection Error<br />\n");
$database='6470_main';
mysql_select_db($database) or die('Error, could not access database '.$database."\n");

//PHP busywork (should be just calls in functions below)

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>
<?php echo $title."\n" /*Outputs title set by parent page*/?>
</title>

<!--Meta Tags!-->
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<meta name="keywords" content="" />
<meta name="description" content="" />
<!--Includes!-->
<?php
include("/opt/lampp/htdocs/6470/include/phpxssfilter.php"); //php cross site scripting shield
include ("/opt/lampp/htdocs/6470/process/lastfmapi/lastfmapi.php"); //last.fm api
$authVars['apiKey']='1dfda490d71fa486956d92acf7a217b0';//last.fm api login
$auth = new lastfmApiAuth('setsession', $authVars);//last.fm api login
?>
<script src="http://albertyw.mit.edu/6470/include/jquery.js" type="text/javascript"></script> <?php /* Loads jQuery */ echo "\n"; ?>
<script src="http://albertyw.mit.edu/6470/include/jquery-ui-personalized-1.5.3.min.js" type="text/javascript"> </script><?php /* Loads jQuery UI */ echo "\n"; ?>
<script src="http://albertyw.mit.edu/6470/include/json2.js" type="text/javascript"></script><?php /* Include JSON for Javascript*/ echo "\n"; ?>
<script src="http://albertyw.mit.edu/6470/include/hash.js" type="text/javascript"></script><?php /* SHA1 Hash for Javascript */ echo "\n"; ?>
<script src="http://albertyw.mit.edu/6470/include/submitlogin.js" type="text/javascript"></script><?php /* Log In script for Javascript */ echo "\n"; ?>
<link href="http://albertyw.mit.edu/6470/include/master.css" rel="stylesheet" type="text/css"/> <?php /* Loads Global CSS */ echo "\n"; ?>
<!--Nifty Corners Cube -->

<!--jQuery UI -->
    <script src="http://code.jquery.com/jquery-latest.js" type="text/javascript"></script>
    <script src="http://albertyw.mit.edu/6470/include/ui/effects.core.js" type="text/javascript"></script>
    <script src="http://albertyw.mit.edu/6470/include/ui/effects.slide.js" type="text/javascript"></script>
    <script src="http://albertyw.mit.edu/6470/include/headertext.js" type="text/javascript"></script>

<!--Javascript-->
<script type="text/javascript" src="http://albertyw.mit.edu/6470/include/jquery.autocompleteregistration.js"></script>
<link href="http://albertyw.mit.edu/6470/include/jquery.autocomplete.css" rel="stylesheet" type="text/css"/>


<!--Other Head Stuff -->





<?php
//FUNCTIONS



?>
