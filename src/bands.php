<?php
/*
ADDRESS:	HTTP://ALBERTYW.MIT.EDU/6470/BANDS.PHP
STATUS:		FINISHED
LAST MODIFIED:	JANUARY 26, 2009
DESCRIPTION:	LISTS BANDS
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
$title='molemusic | bands';
$googlemaps=false;
$freebase=false;
include("/opt/lampp/htdocs/6470/include/headeropen.php");
echo '<script type="text/javascript" src="http://albertyw.mit.edu/6470/include/bands.js"></script>';
echo '<script type="text/javascript" src="http://albertyw.mit.edu/6470/include/bandauto.js"></script>';
echo '<script type="text/javascript" src="http://albertyw.mit.edu/6470/include/jquery.autocomplete.js"></script>';
echo '<link href="http://albertyw.mit.edu/6470/include/jquery.autocomplete.css" rel="stylesheet" type="text/css"/>';
include("/opt/lampp/htdocs/6470/include/headertext.php");?>

<center><h1>Bands</h1></center>

<div id="bandtoday">
<h1>Today's Band</h1>
<?php
bandtoday($login, $username);
?>
</div>


<div id = "bandsmostpopular">
<h1>Most Popular Bands</h1>
<?php
bandsmostpopular($login, $username);
?>
</div>

<div id="bandadd"><a href="http://albertyw.mit.edu/6470/bandsadd/">Add Bands</a></div>
<div id="bandlist"><a href="http://albertyw.mit.edu/6470/bandlist/">List All Bands</a></div>


<div id="bandsearch">
<h1>Search</h1>
<div id = "bandsearchshow">
<form action="http://albertyw.mit.edu/6470/search/" method="post">
<input type="text" id="bandname" name="searchString" />
<input type="hidden" name="searchtype" value="band">
<input type="submit" value="Search"/>
</form>
</div>
</div>




<?php include("/opt/lampp/htdocs/6470/include/footer.php");?>






<?php
//FUNCTIONS IN HERE
function bandtoday($login,$username){
	$result = mysql_query("SELECT * FROM dailypicks WHERE picktype='bands'") or die(mysql_error());
	$row = mysql_fetch_array($result);
	$bandid = $row['pickid'];
	$result = mysql_query("SELECT * FROM band WHERE id = '$bandid'") or die(mysql_error());
	$row = mysql_fetch_array($result);
	echo '<div class="bandname"><a href="http://albertyw.mit.edu/6470/bands/'.$bandid.'/">'.$row['name'].'</a></div>';
	echo '<div class="picture"><img src="'.$picture.'" title="band picture"></a></div>';
	$bandcollegeid = $row['collegeid'];
	$resultcollege = mysql_query("SELECT * FROM college WHERE id = '$bandcollegeid'") or die(mysql_error());
	$rowcollege = mysql_fetch_array($resultcollege);
	echo '<div class="bandcollege">'.$rowcollege['college'].'</div>';
	echo '<div class="bandarticle">'.$row['article'].'</div>';
	addFavorites($login, $username, $bandid, 0);
}
function bandsmostpopular($login,$username){
	//Find out what's most popular
	$result = mysql_query("SELECT * FROM band ORDER BY views DESC") or die(mysql_error());
	$number=1;
	echo '<ol>';
	while($number<=5){
		$row = mysql_fetch_array($result);
		echo '<li>';
		echo '<span style="background-image:';
		echo $row['picture'].'"></span>';//Band Picture
		echo '<strong><a href="http://albertyw.mit.edu/6470/bands/'.$row['id'].'/">';
		echo $row['name'];//Band Name
		echo '</a></strong><br />';
		$collegeid=$row['collegeid'];
		$resultcollege = mysql_query("SELECT * FROM college WHERE id='$collegeid'") or die(mysql_error());
		$rowcollege = mysql_fetch_array($resultcollege);
		echo '<em>'.$rowcollege['college'].'</em><br />';//College Name
		echo '<span class="bandsviews">'.$row['views'].' Views</span>';
		addFavorites($login, $username, $row['id'], $number);
		echo '</li>';
		echo "\n";//New Line
		$number++;
	}
	echo '</ol>';
}
function addFavorites($login, $username, $bandid, $divnumber){
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
			echo '<div id="bandmakefavorite'.$divnumber.'"><a href="javascript:bandMakeFavorite(\''.$username.'\','.$bandid.',\'bandmakefavorite'.$divnumber.'\')">Make this band one of your favorites</a></div>';
		}else{
			echo '<div id="bandmakefavorite'.$divnumber.'">You have already favorited this band</div>';
		}
	}
}
?>
