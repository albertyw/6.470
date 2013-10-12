<?php
/*
ADDRESS:	HTTP://ALBERTYW.MIT.EDU/6470/COLLEGESINGLE.PHP
STATUS:		MAINTANANCE NEEDED: NEEDS CSS
LAST MODIFIED:	JANUARY 23, 2009
DESCRIPTION:	SHOWS IN-DEPTH INFORMATION ABOUT A SINGLE COLLEGE
USAGE:		PUBLIC
*/
//jQueryUI PHP Calls

//End jQuery UI Calls

//Find out what college to display
$collegeid = $_GET['id'];
session_start();
$login=false;
if(isset($_SESSION['username']) && $_SESSION['username']!=''){//See if person is logged in
	$login=true;
	$username=$_SESSION['username'];
}
//Open mySQL Connection
$connection = mysql_connect("localhost", "6470", "6470") or die("mySQL Connection Error<br />\n");
$database='6470_main';
mysql_select_db($database) or die('Error, could not access database '.$database."\n");
//Find college info
$collegeresult = mysql_query("SELECT * FROM college WHERE id = '$collegeid'") or die(mysql_error());
$collegerow = mysql_fetch_array($collegeresult);
$title='molecollege | '.$collegerow['college'];//Title
$googlemaps=false;
$freebase=false;

include("/opt/lampp/htdocs/6470/include/headeropen.php");
echo '<script type="text/javascript" src="http://albertyw.mit.edu/6470/include/collegesingle.js"></script>';
echo '<script type="text/javascript">';
echo 'function getCollegeID(){';
echo '	return '.$collegeid.';';
echo '}';
echo '</script>';
echo '<script type="text/javascript" src="http://albertyw.mit.edu/6470/include/jquery.autocomplete.js"></script>
<link rel="stylesheet" type="text/css" href="http://albertyw.mit.edu/6470/include/jquery.autocomplete.css" />';
include("/opt/lampp/htdocs/6470/include/headertext.php");


echo '<center><h1>'.$collegerow['college'].'</h1></center>';//College Name
if($collegerow['picture']!='' && $collegerow['picture']!=null){//Album Picture
	echo '<img src="'.$collegerow['picture'].'" title="college picture"><br />';
}
echo '<span id="changePictureLink"><a href="javascript:changePicture()">Change Picture</a></span>';
echo '<div id="collegesingledescription">'.$collegerow['description'].'</div>';//College Description
echo '<span id="changeDescriptionLink"><a href="javascript:changeInfo(\'changeDescription\')">Change Description</a></span>';
echo '<div id="collegepeople">';
collegepeople($collegeid);
echo '</div>';//Users at the college
echo '<div id="collegebands">';
collegebands($collegeid);//Bands at the college
echo '</div>';

echo '<div id="collegemessages">';//COLLEGE MESSAGES
echo '<div id="collegemessageview"></div>';
//turn viewer's collegename into id
if($_SESSION['id']!=null && $_SESSION['id']!=''){//Post message
	echo '<div id="collegemessagepost">';
	echo '<div id="collegemessagereturn"></div>';
	echo '<textarea id="collegemessageposttext"></textarea><br />';
	echo 'Maximum Length: 1000 characters<br />';
	echo '<input type="hidden" id="collegemessagepostwriterid" value="'.$_SESSION['id'].'">';
	echo '<span class="collegemessagewriter">'.$_SESSION['realname'].'</span>';
	echo '--';
	echo '<span class="collegemessagetime">'.date("F j, Y -g:i A").'</span>';
	echo '<input type="submit" onclick="postMessage()" value="Post Message">';
	echo '</div>';//id="collegemessagepost"
}
echo '</div>';

echo '<a href="http://albertyw.mit.edu/6470/college/">Other Colleges</a>';
?>

<?php include("/opt/lampp/htdocs/6470/include/footer.php");?>






<?php
//FUNCTIONS IN HERE
function collegepeople($collegeid){
	$result = mysql_query("SELECT * FROM user WHERE collegeid='$collegeid'") or die(mysql_error());
	$peopleatcollege = mysql_num_rows($result);
	if($peopleatcollege!=1){
		echo 'There are '.$peopleatcollege.' molemusic members at this college';
	}else{
		echo 'There is 1 molemusic member at this college';
	}
	$number=1;
	echo '<ol>';
	while($number<=5 && $exit==false){
		$row = mysql_fetch_array($result);
		if($row['id']!='' && $row['id']!=null){
			echo '<li>';
			echo '<a href="http://albertyw.mit.edu/6470/profile/'.$row['id'].'/">'.$row['realname'].'</a>';
			echo '</li>';
			$number++;
		}else{
			$exit=true;
		}
	}
	echo '</ol>';
}
function collegebands($collegeid){
	$result = mysql_query("SELECT * FROM band WHERE collegeid='$collegeid'") or die(mysql_error());
	$bandsatcollege = mysql_num_rows($result);
	if($bandsatcollege!=1){
		echo 'There are '.$peopleatcollege.' bands at this college';
	}else{
		echo 'There is 1 band at this college';
	}
	$number=1;
	echo '<ol>';
	while($number<=5 && $exit==false){
		$row = mysql_fetch_array($result);
		if($row['id']!='' && $row['id']!=null){
			echo '<li>';
			echo '<a href="http://albertyw.mit.edu/6470/bands/'.$row['id'].'/">'.$row['name'].'</a>';
			echo '</li>';
			$number++;
		}else{
			$exit=true;
		}
	}
	echo '</ol>';
}
?>
