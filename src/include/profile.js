//Want to run showMessage when the document is loaded
$(document).ready(function() {
		showMessage(0);
		showBands(0);
		showMusic(0);
		showFriend();
		showFriendList();
	}
)

//PROFILE PICTURE
function changepicture(){
	//Get the requested profile's id
	userid = useridfinder();
	//Make a form
	var changepictureprompt = '<form enctype="multipart/form-data" action="http://albertyw.mit.edu/6470/process/uploader.php" method="POST">';
	changepictureprompt += '<input type="hidden" name="uploadtype" value="profile" />';
	changepictureprompt += '<input type="hidden" name="id" value="'+userid+'" />';
	changepictureprompt += 'Choose a file to upload: <input name="uploadedfile" type="file" /><br />';
	changepictureprompt += '<input type="submit" value="Upload File" /><br />';
	changepictureprompt += 'Maximum file size is 500 kilobytes.';
	changepictureprompt += '</form>';
	//Show the form
	$("#changeprofilepicture").html(changepictureprompt);
}



//PROFILE MESSAGES
function showMessage(usermessagestart){
	userid = useridfinder();
	$.post(
		"http://albertyw.mit.edu/6470/process/profilemessageview.php",
		{
			profileid:userid,
			usermessagestart:usermessagestart
		},
		function(txt){//Return info
			$("#usermessageview").html(txt);
		}
	)
}
function postMessage(){
	//Get the message info
	var messagetext = $("#usermessageposttext").val();
	var messagewriterid = $("#usermessagepostwriterid").val();
	var messagerecipientid = $("#usermessagepostrecipientid").val();
	//Send it through AJAX
	$.post(
		"http://albertyw.mit.edu/6470/process/profilemessage.php",//Call this page
		{
			messagetext:messagetext,//Variables to post
			messagewriterid: messagewriterid,
			messagerecipientid: messagerecipientid
		},
		function(txt){//Return info
			var obj = JSON.parse(txt);//Parse by JSON
			if(obj.accept==false){//Does not accept
				var messagereturn = obj.messagereturn;
				$("#usermessagereturn").html(messagereturn);
			}
			if(obj.accept==true){//Accept
				$("#usermessagereturn").text('The message has been posted');
			}
		}
	)
	showMessage(0);
}

//FAVORITE BAND LIST
function showBands(userbandstart){
	userid = useridfinder();
	ownprofile = ownprofilefinder();
	$.post(
		"http://albertyw.mit.edu/6470/process/profilebandsview.php",
		{
			profileid:userid,
			ownprofile:ownprofile,
			userbandstart:userbandstart

		},
		function(txt){//Return info
			$("#userbandsview").html(txt);
		}
	)
}
function deleteFavoriteBand(bandid){
	var ownprofile = ownprofilefinder();
	if(ownprofile==false){
		$("#userbandsview").append("You cannot make this change");
	}else{
		$.post(
			"http://albertyw.mit.edu/6470/process/profilebanddelete.php",
			{
				bandid:bandid,
				ownprofile:ownprofile
			},
			function(txt){

			}
		)
		showBands();
	}
}

//FAVORITE MUSIC LIST
function showMusic(usermusicstart){
	userid = useridfinder();
	ownprofile = ownprofilefinder();
	$.post(
		"http://albertyw.mit.edu/6470/process/profilemusicview.php",
		{
			userid:userid,
			ownprofile:ownprofile,
			usermusicstart:usermusicstart
		},
		function(txt){//Return info
			$("#usermusicview").html(txt);
		}
	)
}
function deleteFavoriteMusic(musicid){
	var ownprofile = ownprofilefinder();
	if(ownprofile==false){
		$("#usermusicview").append("You cannot make this change");
	}else{
		$.post(
			"http://albertyw.mit.edu/6470/process/profilemusicdelete.php",
			{
				musicid:musicid,
				ownprofile:ownprofile
			},
			function(txt){

			}
		)
		showMusic();
	}
}

//USER FRIENDS
function showFriend(){
	userid = useridfinder();
	ownusername = ownusernamefinder();
	ownprofile = ownprofilefinder();
	if(ownprofile!=true){
		$.post(
			"http://albertyw.mit.edu/6470/process/profilefav.php",
			{
				userid:userid,
				ownprofile:ownprofile,
				ownusername:ownusername
			},
			function(txt){//Return info
				$("#userfav").html(txt);
			}
		)
	}
}
function changefav(){
	userid = useridfinder();
	ownusername = ownusernamefinder();
	ownprofile = ownprofilefinder();
	if(ownprofile!=true){
		$.post(
			"http://albertyw.mit.edu/6470/process/profilefavchange.php",
			{
				userid:userid,
				ownprofile:ownprofile,
				ownusername:ownusername
			},
			function(txt){//Return info
				$("#userfav").html(txt);
			}
		)
	}
}
function showFriendList(){
	userid = useridfinder();
	ownprofile = ownprofilefinder();
	$.post(
		"http://albertyw.mit.edu/6470/process/profilefavlist.php",
		{
			userid:userid,
			ownprofile:ownprofile
		},
		function(txt){//Return info
			$("#userfriendview").html(txt);
		}
	)
}
