<?php
/*
ADDRESS:	HTTP://ALBERTYW.MIT.EDU/6470/EVENT.PHP
STATUS:		FINISHED
LAST MODIFIED:	JANUARY 23, 2009
DESCRIPTION:	LISTS EVENTS
USAGE:		PUBLIC
*/
//jQueryUI PHP Calls

//End jQuery UI Calls
$login=false;

session_start();
if(isset($_SESSION['username']) && $_SESSION['username']!=''){//See if person is logged in
	$login=true;
	$username=$_SESSION['username'];
}
$title='molemusic | events';
$googlemaps=false;
$freebase=false;
include("/opt/lampp/htdocs/6470/include/headeropen.php");
echo '<script type="text/javascript" src="http://albertyw.mit.edu/6470/include/event.js"></script>';
echo '<script type="text/javascript" src="http://albertyw.mit.edu/6470/include/eventauto.js"></script>';
echo '<script type="text/javascript" src="http://albertyw.mit.edu/6470/include/jquery.autocomplete.js"></script>';
echo '<link href="http://albertyw.mit.edu/6470/include/jquery.autocomplete.css" rel="stylesheet" type="text/css"/>';
include("/opt/lampp/htdocs/6470/include/headertext.php");?>

<center><h1>Events</h1></center>

<div id="eventtoday">
<h1>Today's Event</h1>
<?php
eventtoday($login, $username);
?>
</div>



<div id = "eventmostpopular">
<h1>Most Popular Events</h1>
<?php
eventmostpopular($login, $username);
?>
</div>

<div id="eventadd"><a href="http://albertyw.mit.edu/6470/eventadd/">Add Event</a></div>
<div id="eventlist"><a href="http://albertyw.mit.edu/6470/eventlist/">List All Events</a></div>

<div id="eventearch">
<h1>Search</h1>
<div id = "eventearchshow"><form action="http://albertyw.mit.edu/6470/search/" method="post">
<input type="text" id="eventname" name="searchString" />
<input type="hidden" name="searchtype" value="event">
<input type="submit" value="Search"/>
</form>
</div>
</div>




<?php include("/opt/lampp/htdocs/6470/include/footer.php");?>






<?php
//FUNCTIONS IN HERE
function eventtoday($login,$username){
	$result = mysql_query("SELECT * FROM dailypicks WHERE picktype='event'") or die(mysql_error());
	$row = mysql_fetch_array($result);
	$eventid = $row['pickid'];
	$result = mysql_query("SELECT * FROM event WHERE id = '$eventid'") or die(mysql_error());
	$row = mysql_fetch_array($result);
	echo '<div class="eventname"><a href="http://albertyw.mit.edu/6470/event/'.$eventid.'/">'.$row['name'].'</a></div>';//Event Name
	echo '<div class="picture"><img src="'.$picture.'" title="event picture"></a></div>';//Event picture
	$resultband = mysql_query("SELECT * FROM eventbands WHERE eventid = '$eventid'") or die(mysql_error());
	$rowband = mysql_fetch_array($resultband);
	$bandid = $rowband['bandid'];
	$resultband = mysql_query("SELECT * FROM band WHERE id='$bandid'");
	$rowband = mysql_fetch_array($resultband);
	echo '<div class="eventband"><a href="http://albertyw.mit.edu/6470/bands/'.$bandid.'/">'.$rowband['name'].'</a></div>';//Bands at event
	$unixtimestamp = strtotime($row['time']);
	echo '<div class="eventtime">'.date("F j, Y - g:i A",$unixtimestamp).'</div>';//Date/Time of Event
	echo '<div class="eventdescription">'.$row['description'].'</div>';//Event Description
	echo '<div class="eventaddress1">'.$row['address1'].'</div>';
	echo '<div class="eventaddress2">'.$row['address2'].' </div>';
	addFavorites($login, $username, $eventid, 0);//Add event to favorites (RSVP for event)
}
function eventmostpopular($login,$username){
	//Find out what's most popular
	$result = mysql_query("SELECT * FROM event ORDER BY views DESC") or die(mysql_error());
	$number=1;
	echo '<ol>';
	while($number<=5){
		$row = mysql_fetch_array($result);
		echo '<li>';
		echo '<span style="background-image: url(';
		echo $row['picture'].')"></span>';//Event Picture
		echo '<strong><a href="http://albertyw.mit.edu/6470/event/'.$row['id'].'/">';
		echo $row['name'];//Event Name
		echo '</a></strong><br />';
		$eventid = $row['id'];
		$resultband = mysql_query("SELECT * FROM eventbands WHERE eventid = '$eventid'") or die(mysql_error());
		$rowband = mysql_fetch_array($resultband);
		$bandid = $rowband['bandid'];
		$resultband = mysql_query("SELECT * FROM band WHERE id='$bandid'");
		$rowband = mysql_fetch_array($resultband);
		echo '<div class="eventband"><a href="http://albertyw.mit.edu/6470/bands/'.$bandid.'/">'.$rowband['name'].'</a></div>';//Bands at event
		$unixtimestamp = strtotime($row['time']);
		echo '<div class="eventtime">'.date("F j, Y - g:i A",$unixtimestamp).'</div>';//Date/Time of Event
		echo '<span class="eventviews">'.$row['views'].' Views</span>';//Event Views
		addFavorites($login, $username, $row['id'], $number);
		echo '</li>';
		echo "\n";//New Line
		$number++;
	}
	echo '</ol>';
}
function addFavorites($login, $username, $eventid, $divnumber){
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
			echo '<div id="eventmakefavorite'.$divnumber.'"><a href="javascript:eventMakeFavorite(\''.$username.'\','.$eventid.',\'eventmakefavorite'.$divnumber.'\')">RSVP this Event</a></div>';
		}else{
			echo '<div id="eventmakefavorite'.$divnumber.'">You have already RSVPed this event</div>';
		}
	}
}
?>
