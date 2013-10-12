<?php
/*
ADDRESS:	HTTP://ALBERTYW.MIT.EDU/6470/PROFILE.PHP
STATUS:		TESTING NEEDED
LAST MODIFIED:	JANUARY 18, 2009 BY ALBERT WANG
DESCRIPTION:	DISPLAYS A USER'S PROFILE AND ALLOWS FOR CHANGES
USAGE:		PUBLIC
*/
//jQueryUI PHP Calls

//End jQuery UI Calls
$login=false;
$userid = $_GET['id'];//Find requested profile's id
$ownprofile=false;
session_start();
if(isset($_SESSION['username']) && $_SESSION['username']!=''){//See if person is logged in
	$login=true;
	$ownprofile=true;
	$username=$_SESSION['username'];
}
//Open mySQL Connection, usually this is in headeropen, but we need it early
$connection = mysql_connect("localhost", "6470", "6470") or die("mySQL Connection Error<br />\n");
$database='6470_main';
mysql_select_db($database) or die('Error, could not access database '.$database."\n");
//Find requested profile's info
if($userid =='' || $userid==null){//No profile selected
	$ownprofile=true;
	$result = mysql_query("SELECT * FROM user WHERE username='$username'") or die(mysql_error());
	$row = mysql_fetch_array($result);
	$userid = $row['id'];
}else{//Profile selected
	$result = mysql_query("SELECT * FROM user WHERE id='$userid'") or die(mysql_error());
	$row = mysql_fetch_array($result);
	if($row['username']==$username){
		$ownprofile=true;
	}else{
		$ownprofile=false;
	}
}
if($row['username']==null || $row['username']==''){//If the person isn't logged in and hasn't selected a profile, then die
	include("/opt/lampp/htdocs/6470/include/headeropen.php");
	include("/opt/lampp/htdocs/6470/include/headertext.php");
	echo '<center><h1>The profile could not be found.';
	include("/opt/lampp/htdocs/6470/include/footer.php");
	die();
}


$title='molemusic | '.$row['realname'].'\'s profile';
$googlemaps=false;
$freebase=false;
include("/opt/lampp/htdocs/6470/include/headeropen.php");
echo '<script type="text/javascript" src="http://albertyw.mit.edu/6470/include/profile.js"></script>';
echo '<script type="text/javascript">
function useridfinder(){
	return '.$userid.';
}
function ownprofilefinder(){
	return ';
	if($ownprofile==true) echo 'true';
	if($ownprofile==false) echo 'false';
	echo ';
}
function ownusernamefinder(){
	return \''.$username.'\';
}
</script>';
include("/opt/lampp/htdocs/6470/include/headertext.php");?>


<h1><?php echo $row['realname'].'\'s Profile'; ?></h1><br />

<?php
if($_SESSION['username']!='' && $_SESSION['username']!=null && $ownprofile==false){
	echo '<div id="userfav"></div>';
}?>

<div id="userprofilepicture"><!-- PROFILE PICTURE !-->
<?php
echo '<img src="'.$row['picture'].'" title="profile picture">';
if($ownprofile==true){//IF THIS IS THE VIEWING PERSON'S PICTURE, THEN ALLOW TO CHANGE PICTURE
	echo '<br />';
	echo '<div id="changeprofilepicture"><a href="javascript:changepicture()">Change your picture</a></div>';
}?>
</div> <!-- id="profilepicture !-->



<div id="usermessages"><!-- USER MESSAGES !-->
<div id="usermessageview"></div>
<?php
//turn viewer's username into id
if($_SESSION['id']!=null && $_SESSION['id']!=''){//Post message
	echo '<div id="usermessagepost">';
	echo '<div id="usermessagereturn"></div>';
	echo '<textarea id="usermessageposttext"></textarea><br />';
	echo 'Maximum Length: 1000 characters<br />';
	echo '<input type="hidden" id="usermessagepostwriterid" value="'.$_SESSION['id'].'">';
	echo '<input type="hidden" id="usermessagepostrecipientid" value="'.$userid.'">';
	echo '<span class="usermessagewriter">'.$_SESSION['realname'].'</span>';
	echo '--';
	echo '<span class="usermessagetime">'.date("F j, Y -g:i A").'</span>';
	echo '<input type="submit" onclick="postMessage()" value="Post Message">';
	echo '</div>';//id="usermessagepost"
}
?>
</div> <!-- id="usermessages" !-->



<div id="userbands"><!-- USER'S FAVORITE BANDS !-->
<h1>Favorite Bands</h1>
<div id="userbandsview"></div>
<?php
if($ownprofile==true){
	echo '<div id="changefavoritebands"><a href="http://albertyw.mit.edu/6470/bands/">Add Favorite Bands</a></div>';
}?>
</div> <!-- id="userbands" !-->



<div id="usermusics"><!-- USER'S FAVORITE MUSIC !-->
<?php
echo '<h1>Favorite Music</h1>';
echo '<div id = "usermusicview"></div>';
if($ownprofile==true){
	echo '<div id="changefavoritemusic"><a href="http://albertyw.mit.edu/6470/music/">Add Favorite Music</a></div>';
}
?>
</div><!-- id="usermusics" !-->

<div id="useruserfav"><!-- USER'S FRIENDS !-->
<?php
echo '<h1>'.$_SESSION['realname'].'\'s Friends</h1>';
echo '<div id="userfriendview"></div>';
?>


<?php include("/opt/lampp/htdocs/6470/include/footer.php");?>






<?php
//FUNCTIONS IN HERE

?>
