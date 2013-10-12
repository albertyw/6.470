<?php
/*
ADDRESS:	HTTP://ALBERTYW.MIT.EDU/6470/EVENTSINGLE.PHP
STATUS:		MAINTANANCE NEEDED: NEEDS CSS
LAST MODIFIED:	JANUARY 23, 2009
DESCRIPTION:	SHOWS IN-DEPTH INFORMATION ABOUT A SINGLE EVENT
USAGE:		PUBLIC
*/
//jQueryUI PHP Calls

//End jQuery UI Calls

//Find out what event to display
$eventid = $_GET['id'];
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
//Find event info
$eventresult = mysql_query("SELECT * FROM event WHERE id = '$eventid'") or die(mysql_error());
$eventrow = mysql_fetch_array($eventresult);
$title='moleevent | '.$eventrow['name'];//Title
eventview($eventid, $username, $eventrow['views']);//Increase the event view number by 1
$googlemaps=false;
$freebase=false;

include("/opt/lampp/htdocs/6470/include/headeropen.php");
echo '<script type="text/javascript" src="http://albertyw.mit.edu/6470/include/eventsingle.js"></script>';
echo '<script type="text/javascript">';
echo 'function getEventID(){';
echo '	return '.$eventid.';';
echo '}';
echo 'function getUsername(){';
echo '  return \''.$username.'\';';
echo '}';
echo '</script>';
echo '<script type="text/javascript" src="http://albertyw.mit.edu/6470/include/jquery.autocomplete.js"></script>
<link rel="stylesheet" type="text/css" href="http://albertyw.mit.edu/6470/include/jquery.autocomplete.css" />';
include("/opt/lampp/htdocs/6470/include/headertext.php");


echo '<center><div id="eventsinglename">'.$eventrow['name'].'</div>';//Event Name
echo '<span id="changeNameLink"><a href="javascript:changeInfo(\'changeName\')">Change Name</a></span></center>';
//Find the band
$resultband1 = mysql_query("SELECT * FROM eventbands WHERE eventid='$eventid'") or die(mysql_error());
echo '<div id="eventsingleband">';
while($rowband1 = mysql_fetch_array($resultband1)){
	$bandid = $rowband1['bandid'];
	$resultband = mysql_query("SELECT * FROM band WHERE id='$bandid'") or die(mysql_error());
	$rowband = mysql_fetch_array($resultband);
	echo '<a href="http://albertyw.mit.edu/6470/bands/'.$bandid.'/">'.$rowband['name'].'</a>';//Band Name
	echo '<br />';
}
echo '</div>';
//echo '<span id="changeBandLink"><a href="javascript:changeBand()">Change Band</a></span><br><br>';

if($eventrow['picture']!='' && $eventrow['picture']!=null){//Event Picture
	echo '<img src="'.$eventrow['picture'].'" title="event picture"><br />';
}
echo '<span id="changePictureLink"><a href="javascript:changePicture()">Change Picture</a></span><br>';

$unixtimestamp = strtotime($eventrow['time']);
echo '<div id="eventsingletime">'.date("F j, Y - g:i A",$unixtimestamp).'</div>';//Time

echo '<div id="eventsingleaddress"><span id="eventsingleaddress1">'.$eventrow['address1'].'</span>';
echo '<span id="eventsingleaddress2">'.$eventrow['address2'].'</span></div>';
echo '<span id="changeAddressLink"><a href="javascript:changeAddress()">Change Address</a></span>';//Address

echo '<div id="eventsinglearticle">'.$eventrow['description'].'</div>';//Event Description
echo '<span id="changeArticleLink"><a href="javascript:changeInfo(\'changeArticle\')">Change Article</a></span>';
echo '<div id="eventsingleviews">Number of Views: '.$eventrow['views'].'</div>';//Number of Views
addFavorites($login, $username, $eventid);

echo '<div id="eventmessages">';//EVENT MESSAGES
echo '<div id="eventmessageview"></div>';
//turn viewer's eventname into id
if($_SESSION['id']!=null && $_SESSION['id']!=''){//Post message
	echo '<div id="eventmessagepost">';
	echo '<div id="eventmessagereturn"></div>';
	echo '<textarea id="eventmessageposttext"></textarea><br />';
	echo 'Maximum Length: 1000 characters<br />';
	echo '<input type="hidden" id="eventmessagepostwriterid" value="'.$_SESSION['id'].'">';
	echo '<span class="eventmessagewriter">'.$_SESSION['realname'].'</span>';
	echo '--';
	echo '<span class="eventmessagetime">'.date("F j, Y -g:i A").'</span>';
	echo '<input type="submit" onclick="postMessage()" value="Post Message">';
	echo '</div>';//id="eventmessagepost"
}
echo '</div>';

echo '<a href="http://albertyw.mit.edu/6470/event/">More Events</a>';
?>

<?php include("/opt/lampp/htdocs/6470/include/footer.php");?>






<?php
//FUNCTIONS IN HERE
function eventview($eventid, $username, $eventviews){
	//add 1 to views column in table event
	$eventviews = $eventviews+1;
	$query = "UPDATE event SET views='$eventviews' WHERE id = '$eventid'";
	mysql_query($query) or die(mysql_error());
	if($username!='' && $username!=null){//User is logged in, entry to table usereventview
		//find user's id
		$result = mysql_query("SELECT * FROM user WHERE username='$username'") or die(mysql_error());
		$row = mysql_fetch_array($result);
		$userid = $row['id'];
		mysql_query("INSERT INTO usereventview
			(userid, eventid)
			VALUES('$userid','$eventid')") or die(mysql_error());
	}
}


function addFavorites($login, $username, $eventid){
	if($login==true){
		//Check to see if the event is already favorited
		//Convert username to user id
		$result = mysql_query("SELECT * FROM user WHERE username = '$username'") or die(mysql_error());
		$row = mysql_fetch_array($result);
		$userid = $row['id'];
		$result = mysql_query("SELECT * FROM usereventfav WHERE userid='$userid'") or die(mysql_error());
		while($row = mysql_fetch_array($result)){
			if($row['eventid']==$eventid)
				$repeat=true;
		}
		if($repeat==false){//If it hasn't been favorited, then give the option
			echo '<div id="eventmakefavorite"><a href="javascript:eventMakeFavorite(\''.$username.'\',\''.$eventid.'\',\'eventmakefavorite\')">RSVP to this event</a></div>';
		}else{
			echo '<div id="eventmakefavorite">You have already RSVPed this event</div>';
		}
	}
}
?>
