<?php
/*
ADDRESS:	HTTP://ALBERTYW.MIT.EDU/6470/BANDSINGLE.PHP
STATUS:		MAINTANANCE NEEDED: NEEDS CSS
LAST MODIFIED:	JANUARY 21, 2009
DESCRIPTION:	SHOWS IN-DEPTH INFORMATION ABOUT A SINGLE BAND
USAGE:		PUBLIC
*/
//jQueryUI PHP Calls

//End jQuery UI Calls

//Find out what band to display
$bandid = $_GET['id'];
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
//Find band info
$bandresult = mysql_query("SELECT * FROM band WHERE id = '$bandid'") or die(mysql_error());
$bandrow = mysql_fetch_array($bandresult);
$title='molemusic | '.$bandrow['name'];//Title
bandview($bandid, $username, $bandrow['views']);//Increase the band view number by 1
$googlemaps=false;
$freebase=false;

include("/opt/lampp/htdocs/6470/include/headeropen.php");
echo '<script type="text/javascript" src="http://albertyw.mit.edu/6470/include/bandsingle.js"></script>';
echo '<script type="text/javascript">';
echo 'function getBandID(){';
echo '	return '.$bandid.';';
echo '}';
echo '</script>';
echo '<script type="text/javascript" src="http://albertyw.mit.edu/6470/include/jquery.autocomplete.js"></script>
<link rel="stylesheet" type="text/css" href="http://albertyw.mit.edu/6470/include/jquery.autocomplete.css" />';
include("/opt/lampp/htdocs/6470/include/headertext.php");


echo '<center><div id="bandsinglename">'.$bandrow['name'].'</div>';
echo '<span id="changeNameLink"><a href="javascript:changeInfo(\'changeName\')">Change Name</a></span>
</center>';

//Find the college
$collegeid = $bandrow['collegeid'];
$bandcollegeresult = mysql_query("SELECT * FROM college WHERE id='$collegeid'") or die(mysql_error());
$bandcollegerow = mysql_fetch_array($bandcollegeresult);
$bandcollege = $bandcollegerow['college'];
echo '<div id="bandsinglecollege">'.$bandcollege.'</div>';
echo '<span id="changeCollegeLink"><a href="javascript:changeInfo(\'changeCollege\')">Change College</a></span><br />';
if($bandrow['picture']!='' && $bandrow['picture']!=null){
	echo '<img src="'.$bandrow['picture'].'" title="band picture"><br />';
}
echo '<span id="changePictureLink"><a href="javascript:changePicture()">Change Picture</a></span>';
echo '<div id="bandsinglearticle">'.$bandrow['article'].'</div>';
echo '<span id="changeArticleLink"><a href="javascript:changeInfo(\'changeArticle\')">Change Article</a></span>';
echo '<div id="bandsingleviews">Number of Views: '.$bandrow['views'].'</div>';
addFavorites($login, $username, $bandid);
echo '<div id="bandsinglemusic">';
echo '<ol>';
$bandmusicresult = mysql_query("SELECT * FROM music WHERE bandid='$bandid'") or die(mysql_error());
while($bandmusicrow = mysql_fetch_array($bandmusicresult)){
	echo '<li>';
	echo '<span id="bandsinglemusicname"><a href="http://albertyw.mit.edu/6470/music/'.$bandmusicrow['id'].'/">'.$bandmusicrow['name'].'</a> </span>';
	echo '<span id="bandsinglemusicalbum">'.$bandmusicrow['album'].' </span>';
	echo '<span id="bandsinglemusictrackno">'.$bandmusicrow['trackno'].'</span>';
	echo '</li>';
}
echo '</ol>';
echo '<a href="http://albertyw.mit.edu/6470/musicadd/'.$bandid.'/">Add Music To This Band</a>';
echo '</div>';

echo '<div id="bandmessages">';//BAND MESSAGES
echo '<div id="bandmessageview"></div>';
//turn viewer's bandname into id
if($_SESSION['id']!=null && $_SESSION['id']!=''){//Post message
	echo '<div id="bandmessagepost">';
	echo '<div id="bandmessagereturn"></div>';
	echo '<textarea id="bandmessageposttext"></textarea><br />';
	echo 'Maximum Length: 1000 characters<br />';
	echo '<input type="hidden" id="bandmessagepostwriterid" value="'.$_SESSION['id'].'">';
	echo '<span class="bandmessagewriter">'.$_SESSION['realname'].'</span>';
	echo '--';
	echo '<span class="bandmessagetime">'.date("F j, Y -g:i A").'</span>';
	echo '<input type="submit" onclick="postMessage()" value="Post Message">';
	echo '</div>';//id="bandmessagepost"
}
?>
</div> <!-- id="usermessages" !-->
<a href="http://albertyw.mit.edu/6470/bands/">More Bands</a>


<?php include("/opt/lampp/htdocs/6470/include/footer.php");?>






<?php
//FUNCTIONS IN HERE
function bandview($bandid, $username, $bandviews){
	//add 1 to views column in table band
	$bandviews = $bandviews+1;
	$query = "UPDATE band SET views='$bandviews' WHERE id = '$bandid'";
	mysql_query($query) or die(mysql_error());
	if($username!='' && $username!=null){//User is logged in, entry to table userbandview
		//find user's id
		$result = mysql_query("SELECT * FROM user WHERE username='$username'") or die(mysql_error());
		$row = mysql_fetch_array($result);
		$userid = $row['id'];
		mysql_query("INSERT INTO userbandview
			(userid, bandid)
			VALUES('$userid','$bandid')") or die(mysql_error());
	}
}


function addFavorites($login, $username, $bandid){
	if($login==true){
		//Check to see if the band is already favorited
		//Convert username to user id
		$result = mysql_query("SELECT * FROM user WHERE username = '$username'") or die(mysql_error());
		$row = mysql_fetch_array($result);
		$userid = $row['id'];
		$result = mysql_query("SELECT * FROM userbandfav WHERE userid='$userid'") or die(mysql_error());
		while($row = mysql_fetch_array($result)){
			if($row['bandid']==$bandid)
				$repeat=true;
		}
		if($repeat==false){//If it hasn't been favorited, then give the option
			echo '<div id="bandmakefavorite"><a href="javascript:bandMakeFavorite(\''.$username.'\',\''.$bandid.'\',\'bandmakefavorite\')">Make Band Your Favorite</a></div>';
		}else{
			echo '<div id="bandmakefavorite">You have already favorited this band</div>';
		}
	}
}
?>
