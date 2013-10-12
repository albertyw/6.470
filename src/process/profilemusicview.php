<?php
//Get Variables
$userid = $_POST['userid'];
$ownprofile = $_POST['ownprofile'];
$usermusicstart = $_POST['usermusicstart'];

//Open mySQL Connection
$connection = mysql_connect("localhost", "6470", "6470") or die("mySQL Connection Error<br />\n");
$database='6470_main';
mysql_select_db($database) or die('Error, could not access database '.$database."\n");

if($usermusicstart==0){
	$usermusic = mysql_query("SELECT * FROM usermusicfav WHERE userid = '$userid' ORDER BY id DESC") or die(mysql_error());
}else{
	$usermusic = mysql_query("SELECT * FROM usermusicfav WHERE (userid='$userid' && id<='$usermusicstart') ORDER BY id DESC") or die(mysql_error());
}
$usermusicrow = mysql_fetch_array($usermusic);
//Check for newer messages
$usermusicend = $usermusicrow['id'];
$newermusicresult = mysql_query("SELECT * FROM usermusicfav WHERE (userid='$userid' && id>'$usermusicend') ORDER BY id ASC") or die(mysql_error());
$count=1;
while($count<=5){
	$newmusicrow = mysql_fetch_array($newermusicresult);
	$count++;
}
if($newmusicrow['id']!=''){
	echo '<input type="submit" onclick="showMusic('.$newmusicrow['id'].')" value="View Older Music Favorites">';
}

$count=1;
$exit=false;
while($count<=5 && $exit==false){
	if($usermusicrow['musicid']=='' || $usermusicrow['musicid']==null){
		$exit=true;
	}else{
		echo '<div class="usermusic">';
		$usermusicid = $usermusicrow['musicid'];
		$usermusicsingle = mysql_query("SELECT * FROM music WHERE id = '$usermusicid'");
		$usermusicsinglerow = mysql_fetch_array($usermusicsingle);
		echo '<div class = "usermusicname"><a href="http://albertyw.mit.edu/6470/music/'.$usermusicid.'/">';
		echo $usermusicsinglerow['name'];
		echo '</a></div>';
		echo '<div class="usermusicalbum">Album: ';
		echo $usermusicsinglerow['album'].' - Track Number: ';
		echo $usermusicsinglerow['trackno'];
		echo '</div>';
		echo '<div class="usermusicgenre">';
		$usermusicgenre = $usermusicsinglerow['genre'];
		$usermusicgenreresult = mysql_query("SELECT * FROM genre WHERE id = '$usermusicgenre'");
		$usermusicgenrerow = mysql_fetch_array($usermusicgenreresult);
		echo $usermusicgenrerow['name'];
		echo '</div>';
		if($ownprofile=='true'){
			echo '<a href="javascript:deleteFavoriteMusic('.$usermusicrow['id'].')">Delete Music</a>';
		}
		echo '</div>';//class="usermusic"
	}
	$count++;
	$usermusicrow = mysql_fetch_array($usermusic);
}
if ($usermusicrow['id']!=''){//Put a "Next" button to show more music
	echo '<input type="submit" onclick="showMusic('.$usermusicrow['id'].')" value="View Older Music Favorites">';
}
?>
