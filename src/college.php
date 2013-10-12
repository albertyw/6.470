<?php
/*
ADDRESS:	HTTP://ALBERTYW.MIT.EDU/6470/COLLEGE.PHP
STATUS:		MAINTANANCE NEEDED: CSS, SEARCH
LAST MODIFIED:	JANUARY 23, 2009
DESCRIPTION:	LISTS COLLEGE
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
$title='molemusic | college';
$googlemaps=false;
$freebase=false;
session_start();
include("/opt/lampp/htdocs/6470/include/headeropen.php");
echo '<script type="text/javascript" src="http://albertyw.mit.edu/6470/include/college.js"></script>';
echo '<script type="text/javascript" src="http://albertyw.mit.edu/6470/include/collegeauto.js"></script>';
echo '<script type="text/javascript" src="http://albertyw.mit.edu/6470/include/jquery.autocomplete.js"></script>';
echo '<link href="http://albertyw.mit.edu/6470/include/jquery.autocomplete.css" rel="stylesheet" type="text/css"/>';
include("/opt/lampp/htdocs/6470/include/headertext.php");?>

<center><h1>College</h1></center><br />

<?php
if($login==true){
	echo '<div id="collegeuser">';
	echo '<h1>Your College</h1>';
	collegeuser($username);
	echo '</div>';
}
?>

<div id = "collegeother">
<h1>Other Colleges</h1>
<?php
collegeother();
?>
</div>

<div id="collegelist"><a href="http://albertyw.mit.edu/6470/collegelist/">List All Colleges</a></div>

<div id="collegeearch">
<h1>Search</h1>
<div id = "collegesearchshow">
<form action="http://albertyw.mit.edu/6470/search/" method="post">
<input type="text" id="collegename" name="searchString" />
<input type="hidden" name="searchtype" value="college">
<input type="submit" value="Search"/>
</form>
</div>
</div>


<?php include("/opt/lampp/htdocs/6470/include/footer.php");?>






<?php
//FUNCTIONS IN HERE

function collegeuser($username){
	//Find the user's collegeid
	$result = mysql_query("SELECT * FROM user WHERE username='$username'") or die(mysql_error());
	$row = mysql_fetch_array($result);
	$collegeid = $row['collegeid'];
	//Find the college information
	$result = mysql_query("SELECT * FROM college WHERE id='$collegeid'") or die(mysql_error());
	$row = mysql_fetch_array($result);
	echo '<span style="background-image:';
	echo $row['picture'].'"></span>'; //College Picture
	echo '<strong><a href="http://albertyw.mit.edu/6470/college/'.$row['id'].'/">';
	echo $row['college'];//College Name
	echo '</a></strong><br />';
	echo '<div class="collegestate">'.$row['state'].'</div>';
}
function collegeother(){
	//Find out what's most popular
	$result = mysql_query("SELECT * FROM college") or die(mysql_error());
	$numberofcolleges=mysql_num_rows($result);
	$number=1;
	echo '<ol>';
	while($number<=5){
		$collegeid = rand(1,$numberofcolleges);
		$result = mysql_query("SELECT * FROM college WHERE id='$collegeid'") or die(mysql_error());
		$row = mysql_fetch_array($result);
		if($row['college']!=null && $row['college']!=''){
			echo '<li>';
			echo '<span style="background-image:';
			echo $row['picture'].'"></span>'; //College Picture
			echo '<strong><a href="http://albertyw.mit.edu/6470/college/'.$row['id'].'/">';
			echo $row['college'];//College Name
			echo '</a></strong><br />';
			echo '<div class="collegestate">'.$row['state'].'</div>';
			echo '</li>';
			echo "\n";//New Line
			$number++;
		}
	}
	echo '</ol>';
}
?>
