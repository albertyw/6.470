<?php
$userid = $_POST['profileid'];
$ownprofile = $_POST['ownprofile'];
$userbandstart = $_POST['userbandstart'];

//Open mySQL Connection
$connection = mysql_connect("localhost", "6470", "6470") or die("mySQL Connection Error<br />\n");
$database='6470_main';
mysql_select_db($database) or die('Error, could not access database '.$database."\n");

if($userbandstart==0){//Choose what to display
	$userbands = mysql_query("SELECT * FROM userbandfav WHERE userid = '$userid' ORDER BY id DESC") or die(mysql_error());
}else{
	$userbands = mysql_query("SELECT * FROM userbandfav WHERE (userid='$userid' && id<='$userbandstart') ORDER BY id DESC") or die(mysql_error());
}//Do an initial fetch_array to find the first id
$rowuserbands = mysql_fetch_array($userbands);
$userbandend = $rowuserbands['id'];
$newerbandresult = mysql_query("SELECT * FROM userbandfav WHERE (userid='$userid' && id>'$userbandend') ORDER BY id ASC") or die(mysql_error());
$count=1;
while($count<=5){
	$newbandrow = mysql_fetch_array($newerbandresult);
	$count++;
}
if($newbandrow['id']!=''){
	echo '<input type="submit" onclick="showBands('.$newbandrow['id'].')" value="View Newer Band Favorites">';
}
$count=1;
$exit=false;
while($count<=5 && $exit==false){
	$rowcurrentbandid = $rowuserbands['bandid'];
	$userband = mysql_query("SELECT * FROM band WHERE id = '$rowcurrentbandid'");
	$rowuserband = mysql_fetch_array($userband);
	if($rowuserband['name']=='' || $rowuserband['name']==null){
		$exit=true;
	}else{
		echo '<div class="userband">';
		echo '<div class="userbandname"><a href="http://albertyw.mit.edu/6470/bands/'.$rowcurrentbandid.'/">'.$rowuserband['name'].'</a></div>';
		echo '<div class="userbandpicture"><img src="'.$rowuserband['picture'].' title="band picture"></div>';
		$userbandcollegeid = $rowuserband['collegeid'];
		$collegeresult = mysql_query("SELECT * FROM college WHERE id = '$userbandcollegeid'");
		$rowcollege = mysql_fetch_array($collegeresult);
		echo '<div class="college">'.$rowcollege['college'].'</div>';
		if($ownprofile=='true'){
			echo '<a href="javascript:deleteFavoriteBand('.$rowuserbands['id'].')">Delete Band</a>';
		}
		echo '</div>'; //class="userband"
	}
	$count++;
	$rowuserbands = mysql_fetch_array($userbands);
}
if ($rowuserbands['id']!=''){//Put a "Next" button to show more bands
	echo '<input type="submit" onclick="showBands('.$rowuserbands['id'].')" value="View Older Bands">';
}
?>
