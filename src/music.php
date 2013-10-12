<?php
/*
ADDRESS:	HTTP://ALBERTYW.MIT.EDU/6470/MUSIC.PHP
STATUS:		MAINTANANCE NEEDED: CSS, SEARCH
LAST MODIFIED:	JANUARY 23, 2009
DESCRIPTION:	LISTS MUSIC
USAGE:		PUBLIC
*/
//Nifty Cube Corners Javascript Calls

//End Nifty Cube Calls
//jQueryUI PHP Calls

//End jQuery UI Calls
$login=false;
if(isset($_SESSION['username']) && $_SESSION['username']!=''){//See if person is logged in
	$login=true;
	$username=$_SESSION['username'];
}
$title='molemusic | music';
$googlemaps=false;
$freebase=false;
session_start();
include("/opt/lampp/htdocs/6470/include/headeropen.php");
echo '<script type="text/javascript" src="http://albertyw.mit.edu/6470/include/music.js"></script>';
echo '<script type="text/javascript" src="http://albertyw.mit.edu/6470/include/musicauto.js"></script>';
echo '<script type="text/javascript" src="http://albertyw.mit.edu/6470/include/jquery.autocomplete.js"></script>';
echo '<link href="http://albertyw.mit.edu/6470/include/jquery.autocomplete.css" rel="stylesheet" type="text/css"/>';
include("/opt/lampp/htdocs/6470/include/headertext.php");?>

<center><h1>Music</h1></center><br />


<div id="musictoday">
<h1>Today's Music</h1>
<?php
musictoday($login, $username);
?>
</div>



<div id = "musicmostpopular">
<h1>Most Popular Music</h1>
<?php
musicmostpopular($login, $username);
?>
</div>

<div id="musicadd"><a href="http://albertyw.mit.edu/6470/musicadd/">Add Music</a></div>
<div id="musiclist"><a href="http://albertyw.mit.edu/6470/musiclist/">List All Music</a></div>

<div id="musicearch">
<h1>Search</h1>
<div id = "musicsearchshow">
<form action="http://albertyw.mit.edu/6470/search/" method="post">
<input type="text" id="musicname" name="searchString" />
<input type="hidden" name="searchtype" value="music">
<input type="submit" value="Search"/>
</form>
</div>
</div>


<?php include("/opt/lampp/htdocs/6470/include/footer.php");?>






<?php
//FUNCTIONS IN HERE

function musictoday($login,$username){
	$result = mysql_query("SELECT * FROM dailypicks WHERE picktype='music'") or die(mysql_error());
	$row = mysql_fetch_array($result);
	$musicid = $row['pickid'];
	$result = mysql_query("SELECT * FROM music WHERE id = '$musicid'") or die(mysql_error());
	$row = mysql_fetch_array($result);
	echo '<div class="musicname"><a href="http://albertyw.mit.edu/6470/music/'.$musicid.'/">'.$row['name'].'</a></div>';
	echo '<div class="musicalbum">'.$row['album'].'</div>';
	$bandid = $row['bandid'];
	$resultband = mysql_query("SELECT * FROM band WHERE id='$bandid'") or die(mysql_error());
	$rowband = mysql_fetch_array($resultband);
	echo '<div class="musicband">'.$rowband['name'].'</div>';
	$musiccollegeid = $rowband['collegeid'];
	$resultcollege = mysql_query("SELECT * FROM college WHERE id = '$musiccollegeid'") or die(mysql_error());
	$rowcollege = mysql_fetch_array($resultcollege);
	echo '<div class="musiccollege">'.$rowcollege['college'].'</div>';
	addFavorites($login, $username, $musicid, 0);
}
function musicmostpopular($login,$username){
	//Find out what's most popular
	$result = mysql_query("SELECT * FROM music ORDER BY views DESC") or die(mysql_error());
	$number=1;
	echo '<ol>';
	while($number<=5){
		$row = mysql_fetch_array($result);
		echo '<li>';
		echo '<span style="background-image: url(\'';
		echo $row['picture'].'\')"></span>';//Music Picture
		echo '<strong><a href="http://albertyw.mit.edu/6470/music/'.$row['id'].'/">';
		echo $row['name'];//Music Name
		echo '</a></strong><br />';
		$bandid = $row['bandid'];
		$resultband = mysql_query("SELECT * FROM band WHERE id='$bandid'") or die(mysql_error());
		$rowband = mysql_fetch_array($resultband);
		echo '<div class="musicband">'.$rowband['name'].'</div>';
		echo '<span class="musicviews">'.$row['views'].' Views</span>';
		addFavorites($login, $username, $row['id'], $number);
		echo '</li>';
		echo "\n";//New Line
		$number++;
	}
	echo '</ol>';
}
function addFavorites($login, $username, $musicid, $divnumber){
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
			echo '<div id="musicmakefavorite'.$divnumber.'"><a href="javascript:musicMakeFavorite(\''.$username.'\','.$musicid.',\'musicmakefavorite'.$divnumber.'\')">Make this music one of your favorites</a></div>';
		}else{
			echo '<div id="musicmakefavorite'.$divnumber.'">You have already favorited this music</div>';
		}
	}
}
?>
