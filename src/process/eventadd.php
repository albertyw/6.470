<?php
/*
ADDRESS:	HTTP://ALBERTYW.MIT.EDU/6470/PROCESS/EVENTADD.PHP
STATUS:		MAINTANANCE NEEDED: NEEDS CSS, MAYBE TURN THIS INTO AJAX
LAST MODIFIED:	JANUARY 23, 2009
DESCRIPTION:	PROCESSES REQUEST TO ADD EVENT TO DATABASE
USAGE:		PUBLIC/SERVER
*/
//jQueryUI PHP Calls

//End jQuery UI Calls
$login=false;
if(isset($_SESSION['username']) && $_SESSION['username']!=''){//See if person is logged in
	$login=true;
	$username=$_SESSION['username'];
}
$title='moleevent | Add Event';
$googlemaps=false;
$freebase=false;
session_start();

//Get Event Info
$eventname = $_POST['eventname'];
$month = $_POST['month'];
$day = $_POST['day'];
$year = $_POST['year'];
$hour = $_POST['hour'];
$minute = $_POST['minute'];
$address1 = $_POST['address1'];
$address2 = $_POST['address2'];
$bandname = $_POST['bandname'];
$musicname = $_POST['musicname'];
$article = $_POST['article'];
$fileextension=pathinfo($_FILES['uploadedfile']['name']);//check file extension
$fileextension=strtolower($fileextension['extension']);
$accept=true;

include("/opt/lampp/htdocs/6470/include/headeropen.php");
echo '<script type="text/javascript" src="http://albertyw.mit.edu/6470/include/bandauto.js"></script>';
echo '<script type="text/javascript" src="http://albertyw.mit.edu/6470/include/musicauto.js"></script>';
echo '<script type="text/javascript" src="http://albertyw.mit.edu/6470/include/jquery.autocomplete.js"></script>';
echo '<link rel="stylesheet" type="text/css" href="http://albertyw.mit.edu/6470/include/jquery.autocomplete.css" />';
include("/opt/lampp/htdocs/6470/include/headertext.php");?>

<center><h1>Add New Event</h1></center><br />

<?php
//Check the text first
if($eventname == ''){
	$accept=false;
	echo 'Your event must have a name<br />';
}
if($eventname!=mysql_real_escape_string(htmlentities($eventname))){
	$accept=false;
	echo 'Your event\'s name is improperly formatted<br />';
}
if(ereg('[^0-9]', $month) || $month <1 || $month >12){
	$accept=false;
	echo 'The month is incorrectly formatted<br />';
}
if(ereg('[^0-9]', $day) || $day <1 || $day >31){
	$accept=false;
	echo 'The day is incorrectly formatted<br />';
}
if(ereg('[^0-9]', $year) || $year <1 || $year >99){
	$accept=false;
	echo 'The month is incorrectly formatted<br />';
}
if(ereg('[^0-9]', $hour) || $hour <1 || $hour >12){
	$accept=false;
	echo 'The hour is incorrectly formatted<br />';
}
if(ereg('[^0-9]', $minute) || $minute <1 || $minute >60){
	$accept=false;
	echo 'The minute is incorrectly formatted<br />';
}
if($address1 == ''){
	$accept=false;
	echo 'There must be an address for the event<br />';
}
if($address1!=mysql_real_escape_string(htmlentities($address1))){
	$accept=false;
	echo 'The address is improperly formatted<br />';
}
if($address2!=mysql_real_escape_string(htmlentities($address2))){
	$accept=false;
	echo 'Your address 2 is improperly formatted<br />';
}
if($article!=mysql_real_escape_string(htmlentities($article))){
	$accept=false;
	echo 'Your description is improperly formatted<br />';
}
//Convert bandname to bandid
$bandresult = mysql_query("SELECT * FROM band WHERE name='$bandname'") or die(mysql_error());
$bandrow = mysql_fetch_array($bandresult);
$bandid = $bandrow['id'];
//Convert musicname to bandid
$musicresult = mysql_query("SELECT * FROM music WHERE name='$musicname'") or die(mysql_error());
$musicrow = mysql_fetch_array($musicresult);
$musicid = $musicrow['id'];
//If accept is still true, then text has been checked

//Check Image, if exists and nothing wrong with the text
if($accept==true && file_exists($_FILES['uploadedfile']['tmp_name'])){
	$target_folder = "/opt/lampp/htdocs/6470/img/event/";
	$internet_folder="http://albertyw.mit.edu/6470/img/event/";
	$target_path = $target_folder . $id .'.'. $fileextension;
	$internet_path = $internet_folder . $id .'.'. $fileextension;
	if(filesize($_FILES['uploadedfile']['tmp_name'])>500000){//Check file size
		$accept=false;
		echo 'The picture is too large. <br />';
	}
	if($fileextension==null || $fileextension=='' || ($fileextension!='jpg' && $fileextension!='gif' && $fileextension!='png' && $fileextension!='tif')){
		$accept=false;
		echo 'The picture\'s file type is not an acceptable format. <br />';
	}
	if($accept==true){//If file is good
		$pictureexists=true; //Needed later when adding picture to database
		//then move the file to a temporary location for resizing
		$templocation = "/opt/lampp/htdocs/6470/img/temp/eventadd.".$fileextension;
		move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $templocation);
		//Delete Old Image
		if(file_exists($target_path)) unlink($target_path);
		//RESIZE IMAGE

		include "/opt/lampp/htdocs/6470/process/imageresize.php";
		$image = new Resize_Image;
		$image->new_width = 300;
		$image->new_height = 300;
		$image->image_to_resize = $templocation; // Full Path to the file
		$image->ratio = true; // Keep Aspect Ratio?
		// Name of the new image (optional) - If it's not set a new will be added automatically
		$image->new_image_name = 'eventaddtemp';
		// Path where the new image should be saved. If it's not set the script will output the image without saving it
		$image->save_folder = $target_folder;
		$process = $image->resize();
	}
}

if($accept==true){//If accept is true, then add event to database
	//Create the time:
	$time = '20'.$year.'-'.$month.'-'.$day.' '.$hour.':'.$minute.'00';
	mysql_query("INSERT INTO event
		(time, name, description, address1, address2)
		VALUES('$time','$eventname','$article','$address1','$address2')")or die(mysql_error());
	//Find the ID
	$result = mysql_query("SELECT * FROM event WHERE name='$eventname'") or die(mysql_error());
	$row = mysql_fetch_array($result);
	$newid = $row['id'];
	if($pictureexists==true){
		//Change the Picture File's ID
		$newpicturelocation = $target_folder.$newid.'.'.$fileextension;
		rename($target_folder.'eventaddtemp.'.$fileextension,$newpicturelocation);
		//Add the picture in
		$newpicturelocation = $internet_folder.$newid.'.'.$fileextension;
		mysql_query("UPDATE event SET picture='$newpicturelocation' WHERE id='$newid'") or die(mysql_error());
	}
	if($bandid!='' && $bandid!=null){
		mysql_query("INSERT INTO eventbands
		(eventid, bandid)
		VALUES('$newid','$bandid')") or die(mysql_error());
	}
	if($musicid!='' && $musicid!=null){
		mysql_query("INSERT INTO eventmusic
		(eventid, musicid)
		VALUES('$newid','$musicid')") or die(mysql_error());
	}
}


//If accept is still true, then all is good
if($accept==true){
	echo 'The event has been added.<br />';
	echo '<a href="http://albertyw.mit.edu/6470/event/'.$newid.'/">Go to the Event</a>';
}else{//Did not work, display the form again
	echo 'Please try again:';
	echo '<form enctype="multipart/form-data" action="http://albertyw.mit.edu/6470/process/eventadd.php" method="POST">
Name: <input type="text" size="50" name="eventname" value="'.$eventname.'"/><br />
Date: <input type="text" size="2" name="month" value="'.$month.'"/> -
<input type="text" size="2" name="day" value="'.$day.'"/> -
20<input type="text" size="2" name="year" value="'.$year.'"/>
<br />
Time: <input type="text" size="2" name="hour" value="'.$hour.'"/>:
<input type="text" size="2" name="minute" value="'.$minute.'"/>
<br />
Address 1: <input type="text" size="50" name="address1" value="'.$eventname.'"/><br />
Address 2: <input type="text" size="50" name="address2" value="'.$eventname.'"/><br />';
if($bandid=='' || $bandid==null){
	echo 'Band: <input type="text" size="50" name="bandname" id="bandname"/><br />';
}else{
	$result = mysql_query("SELECT * FROM band WHERE id='$bandid'") or die(mysql_error());
	$row = mysql_fetch_array($result);
	echo 'Band: <input type="text" size="50" name="bandname" id="bandname" value="'.$row['name'].'"/><br />';
}
if($musicid=='' || $musicid==null){
	echo 'Music: <input type="text" size="50" name="musicname" id="musicname"/><br />';
}else{
	$result = mysql_query("SELECT * FROM music WHERE id='$musicid'") or die(mysql_error());
	$row = mysql_fetch_array($result);
	echo 'Music: <input type="text" size="50" name="musicname" id="musicname" value="'.$row['name'].'"/><br />';
}
echo 'Description:<textarea name="article">'.$article.'</textarea><br />
Picture: <input type="file" name="uploadedfile"><br />
<input type="submit" value="Add Event" />
</form>';

}
?>


<?php include("/opt/lampp/htdocs/6470/include/footer.php");?>






<?php
//FUNCTIONS IN HERE

?>
