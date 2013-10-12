<?php
/*
ADDRESS:	HTTP://ALBERTYW.MIT.EDU/6470/PROCESS/UPLOADER.PHP
STATUS:		MAINTANANCE NEEDED: MAYBE TURN THIS INTO AN AJAX UPLOAD?
LAST MODIFIED:	JANUARY 19, 2009
DESCRIPTION:	TAKES UPLOADED PICTURES, RESIZES THEM, THEN STORES THEM
USAGE:		HIDDEN
*/
//jQueryUI PHP Calls

//End jQuery UI Calls
$login=false;
if(isset($_SESSION['username']) && $_SESSION['username']!=''){//See if person is logged in
	$login=true;
	$username=$_SESSION['username'];
}
$title='molemusic | profile';
$googlemaps=false;
$freebase=false;
session_start();
include("/opt/lampp/htdocs/6470/include/headeropen.php");
//head stuff here
include("/opt/lampp/htdocs/6470/include/headertext.php");
//Make file location
$uploadtype = $_POST['uploadtype'];
$id = $_POST['id'];
$fileextension=pathinfo($_FILES['uploadedfile']['name']);//check file extension
$fileextension=strtolower($fileextension['extension']);
if($uploadtype=='profile'){
	$target_folder = "/opt/lampp/htdocs/6470/img/profile/";
	$internet_folder="http://albertyw.mit.edu/6470/img/profile/";

}
if($uploadtype=='band'){
	$target_folder = "/opt/lampp/htdocs/6470/img/band/";
	$internet_folder="http://albertyw.mit.edu/6470/img/band/";
}
if($uploadtype=='music'){
	$target_folder = "/opt/lampp/htdocs/6470/img/music/";
	$internet_folder="http://albertyw.mit.edu/6470/img/music/";
}
if($uploadtype=='college'){
	$target_folder = "/opt/lampp/htdocs/6470/img/college/";
	$internet_folder="http://albertyw.mit.edu/6470/img/college/";
}
if($uploadtype=='event'){
	$target_folder = "/opt/lampp/htdocs/6470/img/event/";
	$internet_folder="http://albertyw.mit.edu/6470/img/event/";
}
$okay=true;
$target_path = $target_folder . $id .'.'. $fileextension;
$internet_path = $internet_folder . $id .'.'. $fileextension;

//Check to make sure the file is ok
if(filesize($_FILES['uploadedfile']['tmp_name'])>500000){//Check file size
	$okay=false;
	echo 'The file is too large. <br />';
}

if($fileextension==null || $fileextension=='' || ($fileextension!='jpg' && $fileextension!='gif' && $fileextension!='png' && $fileextension!='tif')){
	$okay=false;
	echo 'The file type is not an acceptable format. <br />';
}
if($okay==true){//If file is good
	//then move the file to a temporary location for resizing
	$templocation = "/opt/lampp/htdocs/6470/img/temp/".$id.'.'.$fileextension;
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
	$image->new_image_name = $id;
	// Path where the new image should be saved. If it's not set the script will output the image without saving it
	$image->save_folder = $target_folder;
	$process = $image->resize();
	if($process['result'] && $image->save_folder)
	{
		echo 'The new image ('.$process['new_file_path'].') has been saved.<br />';
	}

	//Output something
	echo "The picture ".  basename( $_FILES['uploadedfile']['name'])." has been uploaded: <br />";
	echo '<img src="'.$internet_path.'"><br />';
}else{
	echo "The picture has not been uploaded.<br />";
	if($uploadtype=='profile')
		echo '<a href="http://albertyw.mit.edu/6470/profile/">Back to Your Profile</a><br>';
	if($uploadtype=='band')
		echo '<a href="http://albertyw.mit.edu/6470/bands/'.$id.'/">Back to the Band</a><br>';
	if($uploadtype=='music')
		echo '<a href="http://albertyw.mit.edu/6470/music/'.$id.'/">Back to the Music</a><br>';
	if($uploadtype=='college')
		echo '<a href="http://albertyw.mit.edu/6470/colleges/'.$id.'/">Back to the College</a><br>';
	if($uploadtype=='event')
		echo '<a href="http://albertyw.mit.edu/6470/event/'.$id.'/">Back to the Event</a><br>';
	include("/opt/lampp/htdocs/6470/include/footer.php");
	die();
}



//Open mySQL Connection
$connection = mysql_connect("localhost", "6470", "6470") or die("mySQL Connection Error<br />\n");
$database='6470_main';
mysql_select_db($database) or die('Error, could not access database '.$database."\n");

if($uploadtype=='profile'){//Update user table
	mysql_query("UPDATE user SET picture = '$internet_path' WHERE id='$id'") or die(mysql_error());
	echo '<a href="http://albertyw.mit.edu/6470/profile/">Back to Your Profile</a><br>';
}
if($uploadtype=='band'){//Update user table
	mysql_query("UPDATE band SET picture = '$internet_path' WHERE id='$id'") or die(mysql_error());
	echo '<a href="http://albertyw.mit.edu/6470/bands/'.$id.'/">Back to the Band</a><br>';
}
if($uploadtype=='music'){//Update user table
	mysql_query("UPDATE music SET picture = '$internet_path' WHERE id='$id'") or die(mysql_error());
	echo '<a href="http://albertyw.mit.edu/6470/music/'.$id.'/">Back to the Music</a><br>';
}
if($uploadtype=='college'){//Update user table
	mysql_query("UPDATE college SET picture = '$internet_path' WHERE id='$id'") or die(mysql_error());
	echo '<a href="http://albertyw.mit.edu/6470/college/'.$id.'/">Back to the College</a><br>';
}
if($uploadtype=='event'){//Update user table
	mysql_query("UPDATE event SET picture = '$internet_path' WHERE id='$id'") or die(mysql_error());
	echo '<a href="http://albertyw.mit.edu/6470/event/'.$id.'/">Back to the Event</a><br>';
}

include("/opt/lampp/htdocs/6470/include/footer.php");
?>
