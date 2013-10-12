<?php
/*
ADDRESS:	HTTP://ALBERTYW.MIT.EDU/6470/MUSICSINGLE.PHP
STATUS:		MAINTANANCE NEEDED: NEEDS CSS
LAST MODIFIED:	JANUARY 23, 2009
DESCRIPTION:	SHOWS IN-DEPTH INFORMATION ABOUT A SINGLE MUSIC
USAGE:		PUBLIC
*/
//jQueryUI PHP Calls

//End jQuery UI Calls

//Find out what music to display
$musicid = $_GET['id'];
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
//Find music info
$musicresult = mysql_query("SELECT * FROM music WHERE id = '$musicid'") or die(mysql_error());
$musicrow = mysql_fetch_array($musicresult);
$title='molemusic | '.$musicrow['name'];//Title
musicview($musicid, $username, $musicrow['views']);//Increase the music view number by 1
$googlemaps=false;
$freebase=false;

include("/opt/lampp/htdocs/6470/include/headeropen.php");
echo '<script type="text/javascript" src="http://albertyw.mit.edu/6470/include/musicsingle.js"></script>';
echo '<script type="text/javascript">';
echo 'function getMusicID(){';
echo '	return '.$musicid.';';
echo '}';
echo '</script>';
echo '<script type="text/javascript" src="http://albertyw.mit.edu/6470/include/jquery.autocomplete.js"></script>
<link rel="stylesheet" type="text/css" href="http://albertyw.mit.edu/6470/include/jquery.autocomplete.css" />';
include("/opt/lampp/htdocs/6470/include/headertext.php");


echo '<center><div id="musicsinglename">'.$musicrow['name'].'</div>';//Music Name
echo '<span id="changeNameLink"><a href="javascript:changeInfo(\'changeName\')">Change Name</a></span></center>';
//Find the band
$bandid = $musicrow['bandid'];
$resultband = mysql_query("SELECT * FROM band WHERE id='$bandid'") or die(mysql_error());
$rowband = mysql_fetch_array($resultband);
echo '<div class="musicband">'.$rowband['name'].'</div>';//Band Name
//echo '<span id="changeBandLink"><a href="javascript:changeInfo(\'changeBand\')">Change Band</a></span>';
//Find the college of the band
$collegeid = $rowband['collegeid'];
$musiccollegeresult = mysql_query("SELECT * FROM college WHERE id='$collegeid'") or die(mysql_error());
$musiccollegerow = mysql_fetch_array($musiccollegeresult);
echo '<div id="musicsinglecollege">'.$musiccollegerow['college'].'</div>';//College of the Band
echo '<span id="changeCollegeLink"><a href="javascript:changeInfo(\'changeCollege\')">Change College</a></span><br />';
if($musicrow['picture']!='' && $musicrow['picture']!=null){//Album Picture
	echo '<img src="'.$musicrow['picture'].'" title="music picture"><br />';
}
echo '<span id="changePictureLink"><a href="javascript:changePicture()">Change Picture</a></span>';
echo '<div id="musicsinglearticle">'.$musicrow['article'].'</div>';//Music Description
echo '<span id="changeArticleLink"><a href="javascript:changeInfo(\'changeArticle\')">Change Article</a></span>';
echo '<div id="musicsingleviews">Number of Views: '.$musicrow['views'].'</div>';//Number of Views
addFavorites($login, $username, $musicid);

echo '<div id="musicmessages">';//MUSIC MESSAGES
echo '<div id="musicmessageview"></div>';
//turn viewer's musicname into id
if($_SESSION['id']!=null && $_SESSION['id']!=''){//Post message
	echo '<div id="musicmessagepost">';
	echo '<div id="musicmessagereturn"></div>';
	echo '<textarea id="musicmessageposttext"></textarea><br />';
	echo 'Maximum Length: 1000 characters<br />';
	echo '<input type="hidden" id="musicmessagepostwriterid" value="'.$_SESSION['id'].'">';
	echo '<span class="musicmessagewriter">'.$_SESSION['realname'].'</span>';
	echo '--';
	echo '<span class="musicmessagetime">'.date("F j, Y -g:i A").'</span>';
	echo '<input type="submit" onclick="postMessage()" value="Post Message">';
	echo '</div>';//id="musicmessagepost"
}
echo '</div>';

echo '<a href="http://albertyw.mit.edu/6470/music/">More Music</a>';
?>

<?php include("/opt/lampp/htdocs/6470/include/footer.php");?>






<?php
//FUNCTIONS IN HERE
function musicview($musicid, $username, $musicviews){
	//add 1 to views column in table music
	$musicviews = $musicviews+1;
	$query = "UPDATE music SET views='$musicviews' WHERE id = '$musicid'";
	mysql_query($query) or die(mysql_error());
	if($username!='' && $username!=null){//User is logged in, entry to table usermusicview
		//find user's id
		$result = mysql_query("SELECT * FROM user WHERE username='$username'") or die(mysql_error());
		$row = mysql_fetch_array($result);
		$userid = $row['id'];
		mysql_query("INSERT INTO usermusicview
			(userid, musicid)
			VALUES('$userid','$musicid')") or die(mysql_error());
	}
}


function addFavorites($login, $username, $musicid){
	if($login==true){
		//Check to see if the music is already favorited
		//Convert username to user id
		$result = mysql_query("SELECT * FROM user WHERE username = '$username'") or die(mysql_error());
		$row = mysql_fetch_array($result);
		$userid = $row['id'];
		$result = mysql_query("SELECT * FROM usermusicfav WHERE userid='$userid'") or die(mysql_error());
		while($row = mysql_fetch_array($result)){
			if($row['musicid']==$musicid)
				$repeat=true;
		}
		if($repeat==false){//If it hasn't been favorited, then give the option
			echo '<div id="musicmakefavorite"><a href="javascript:musicMakeFavorite(\''.$username.'\',\''.$musicid.'\',\'musicmakefavorite\')">Make Music Your Favorite</a></div>';
		}else{
			echo '<div id="musicmakefavorite">You have already favorited this music</div>';
		}
	}
}
?>
