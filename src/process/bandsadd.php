<?php
/*
ADDRESS:	HTTP://ALBERTYW.MIT.EDU/6470/PROCESS/BANDSADD.PHP
STATUS:		MAINTANANCE NEEDED: NEEDS CSS, MAYBE TURN THIS INTO AJAX
LAST MODIFIED:	JANUARY 23, 2009
DESCRIPTION:	PROCESSES REQUEST TO ADD BAND TO DATABASE
USAGE:		PUBLIC/SERVER
*/
//jQueryUI PHP Calls

//End jQuery UI Calls
$login=false;
if(isset($_SESSION['username']) && $_SESSION['username']!=''){//See if person is logged in
	$login=true;
	$username=$_SESSION['username'];
}
$title='molemusic | Add Bands';
$googlemaps=false;
$freebase=false;
session_start();

//Get Band Info
$bandname = $_POST['bandname'];
$collegename = $_POST['collegename'];
$article = $_POST['article'];
$fileextension=pathinfo($_FILES['uploadedfile']['name']);//check file extension
$fileextension=strtolower($fileextension['extension']);
$accept=true;

include("/opt/lampp/htdocs/6470/include/headeropen.php");
include("/opt/lampp/htdocs/6470/include/headertext.php");?>

<center><h1>Add New Bands</h1></center><br />

<?php
//Check the text first
if($bandname == ''){
	$accept=false;
	echo 'Your band must have a name<br />';
}
if($bandname!=mysql_real_escape_string(htmlentities($bandname))){
	$accept=false;
	echo 'Your band\'s name is improperly formatted<br />';
}
if($collegename == ''){
	$accept=false;
	echo 'Your band must be associated with a college<br />';
}
if($collegename!=mysql_real_escape_string(htmlentities($collegename))){
	$accept=false;
	echo 'Your college\'s name is improperly formatted<br />';
}
if($article!=mysql_real_escape_string(htmlentities($article))){
	$accept=false;
	echo 'Your description is improperly formatted<br />';
}
//Convert collegename to collegeid
$collegeresult = mysql_query("SELECT * FROM college WHERE college='$collegename'") or die(mysql_error());
$collegerow = mysql_fetch_array($collegeresult);
if($collegerow['id']=='' || $collegerow['id']==null){
	$accept=false;
	echo 'The college could not be found<br />';
}else{
	$collegeid = $collegerow['id'];
}
//If accept is still true, then text has been checked

//Check Image, if exists and nothing wrong with the text
if($accept==true && file_exists($_FILES['uploadedfile']['tmp_name'])){
	$target_folder = "/opt/lampp/htdocs/6470/img/band/";
	$internet_folder="http://albertyw.mit.edu/6470/img/band/";
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
		$templocation = "/opt/lampp/htdocs/6470/img/temp/bandadd.".$fileextension;
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
		$image->new_image_name = 'bandaddtemp';
		// Path where the new image should be saved. If it's not set the script will output the image without saving it
		$image->save_folder = $target_folder;
		$process = $image->resize();
	}
}

if($accept==true){//If accept is true, then add band to database
	mysql_query("INSERT INTO band
		(name, collegeid, article)
		VALUES('$bandname','$collegeid','$article')")or die(mysql_error());
	if($pictureexists==true){
		//Find the ID
		$result = mysql_query("SELECT * FROM band WHERE name='$bandname'") or die(mysql_error());
		$row = mysql_fetch_array($result);
		$newid = $row['id'];
		//Change the Picture File's ID
		$newpicturelocation = $target_folder.$newid.'.'.$fileextension;
		rename($target_folder.'bandaddtemp.'.$fileextension,$newpicturelocation);
		//Add the picture in
		$newpicturelocation = $internet_folder.$newid.'.'.$fileextension;
		mysql_query("UPDATE band SET picture='$newpicturelocation' WHERE id='$newid'") or die(mysql_error());
	}
}


//If accept is still true, then all is good
if($accept==true){
	echo 'The band has been created.<br />';
	echo '<a href="http://albertyw.mit.edu/6470/bands/'.$newid.'/">Go to the Band</a>';
}else{//Did not work, display the form again
	echo 'Please try again:';
echo '	<form enctype="multipart/form-data" action="http://albertyw.mit.edu/6470/process/bandsadd.php" method="POST">
	Band Name: <input type="text" size="50" name="bandname" value='.$bandname.'/><br />
	Picture: <input type="file" name="uploadedfile"><br />
	College: <input type="text" size="50" name="collegename" id="collegename" value='.$collegename.'/><br />
	Description:<br />
	<textarea name="article">'.$article.'</textarea><br />
	<input type="submit" value="Add A Band" />
	</form>';
}
?>


<?php include("/opt/lampp/htdocs/6470/include/footer.php");?>






<?php
//FUNCTIONS IN HERE

?>
