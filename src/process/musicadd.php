<?php
/*
ADDRESS:	HTTP://ALBERTYW.MIT.EDU/6470/PROCESS/MUSICADD.PHP
STATUS:		MAINTANANCE NEEDED: NEEDS CSS, MAYBE TURN THIS INTO AJAX
LAST MODIFIED:	JANUARY 23, 2009
DESCRIPTION:	PROCESSES REQUEST TO ADD MUSIC TO DATABASE
USAGE:		PUBLIC/SERVER
*/
//jQueryUI PHP Calls

//End jQuery UI Calls
$login=false;
if(isset($_SESSION['username']) && $_SESSION['username']!=''){//See if person is logged in
	$login=true;
	$username=$_SESSION['username'];
}
$title='molemusic | Add Music';
$googlemaps=false;
$freebase=false;
session_start();

//Get Music Info
$musicname = $_POST['musicname'];
$album = $_POST['album'];
$trackno = $_POST['trackno'];
$bandname = $_POST['bandname'];
$article = $_POST['article'];
$fileextension=pathinfo($_FILES['uploadedfile']['name']);//check file extension
$fileextension=strtolower($fileextension['extension']);
$accept=true;

include("/opt/lampp/htdocs/6470/include/headeropen.php");
echo '<script type="text/javascript" src="http://albertyw.mit.edu/6470/include/bandauto.js"></script>';
echo '<script type="text/javascript" src="http://albertyw.mit.edu/6470/include/jquery.autocomplete.js"></script>';
echo '<link rel="stylesheet" type="text/css" href="http://albertyw.mit.edu/6470/include/jquery.autocomplete.css" />';
include("/opt/lampp/htdocs/6470/include/headertext.php");?>

<center><h1>Add New Music</h1></center><br />

<?php
//Check the text first
if($musicname == ''){
	$accept=false;
	echo 'Your music must have a name<br />';
}
if($musicname!=mysql_real_escape_string(htmlentities($musicname))){
	$accept=false;
	echo 'Your music\'s name is improperly formatted<br />';
}
if($album!=mysql_real_escape_string(htmlentities($album))){
	$accept=false;
	echo 'Your music\'s album name is improperly formatted<br />';
}
if(ereg('[^0-9]', $trackno)){
	$accept=false;
	echo 'The track number must be a number<br />';
}
if($bandname == ''){
	$accept=false;
	echo 'Your music must be associated with a band<br />';
}
if($bandname!=mysql_real_escape_string(htmlentities($bandname))){
	$accept=false;
	echo 'Your college\'s name is improperly formatted<br />';
}
if($article!=mysql_real_escape_string(htmlentities($article))){
	$accept=false;
	echo 'Your description is improperly formatted<br />';
}
//Convert bandname to bandid
$bandresult = mysql_query("SELECT * FROM band WHERE name='$bandname'") or die(mysql_error());
$bandrow = mysql_fetch_array($bandresult);
if($bandrow['id']=='' || $bandrow['id']==null){
	$accept=false;
	echo 'The band could not be found<br />';
}else{
	$bandid = $bandrow['id'];
}
//If accept is still true, then text has been checked

//Check Image, if exists and nothing wrong with the text
if($accept==true && file_exists($_FILES['uploadedfile']['tmp_name'])){
	$target_folder = "/opt/lampp/htdocs/6470/img/music/";
	$internet_folder="http://albertyw.mit.edu/6470/img/music/";
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
		$templocation = "/opt/lampp/htdocs/6470/img/temp/musicadd.".$fileextension;
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
		$image->new_image_name = 'musicaddtemp';
		// Path where the new image should be saved. If it's not set the script will output the image without saving it
		$image->save_folder = $target_folder;
		$process = $image->resize();
	}
}

if($accept==true){//If accept is true, then add music to database
	mysql_query("INSERT INTO music
		(trackno, name, album, bandid, article)
		VALUES('$trackno','$musicname','$album','$bandid','$article')")or die(mysql_error());
	//Find the ID
	$result = mysql_query("SELECT * FROM music WHERE name='$musicname'") or die(mysql_error());
	$row = mysql_fetch_array($result);
	$newid = $row['id'];
	if($pictureexists==true){
		//Change the Picture File's ID
		$newpicturelocation = $target_folder.$newid.'.'.$fileextension;
		rename($target_folder.'musicaddtemp.'.$fileextension,$newpicturelocation);
		//Add the picture in
		$newpicturelocation = $internet_folder.$newid.'.'.$fileextension;
		mysql_query("UPDATE music SET picture='$newpicturelocation' WHERE id='$newid'") or die(mysql_error());
	}
}


//If accept is still true, then all is good
if($accept==true){
	echo 'The music has been added.<br />';
	echo '<a href="http://albertyw.mit.edu/6470/music/'.$newid.'/">Go to the Music</a>';
}else{//Did not work, display the form again
	echo 'Please try again:';
	echo '	<form enctype="multipart/form-data" action="http://albertyw.mit.edu/6470/process/musicadd.php" method="POST">
	Name: <input type="text" size="50" name="musicname" value="'.$musicname.'"/><br />
	Album: <input type="text" size="50" name="album" value="'.$album.'"/><br />
	Track Number: <input type="text" size="2" name="trackno" value="'.$trackno.'"/><br />
	Picture: <input type="file" name="uploadedfile"><br />';
	if($bandid=='' || $bandid==null){
		echo 'Band: <input type="text" size="50" name="bandname" id="bandname" value="'.$bandname.'"/><br />';
	}else{
		$result = mysql_query("SELECT * FROM band WHERE id='$bandid'") or die(mysql_error());
		$row = mysql_fetch_array($result);
		echo 'Band: <input type="text" size="50" name="bandname" id="bandname" value="'.$row['name'].'"/><br />';
	}
	echo '
	Description:<br />
	<textarea name="article">'.$article.'</textarea><br />
	<input type="submit" value="Add Music" />
	</form>';

}
?>


<?php include("/opt/lampp/htdocs/6470/include/footer.php");?>






<?php
//FUNCTIONS IN HERE

?>
