$(document).ready(function() {
		showMessage(0);
	}
)

function changeInfo(changeWhat){
	//Get the info
	var origName, changeLocation
	if(changeWhat=='changeDescription'){
		origName = $("#collegesingledescription").text();
		changeLocation = '#collegesingledescription';
		var inputForm = '<textarea id="'+changeWhat+'">'+origName+'</textarea>';
		inputForm += '<input type="submit" value="Change" onclick="javascript:changeAction(\''+changeWhat+'\',\''+changeLocation+'\')';
	}
	var hideID='#'+changeWhat+'Link';
	//Display the form
	$(changeLocation).html(inputForm);
	//Hide the "change this" link
	$(hideID).hide("slow");
	if(changeWhat=='changeCollege'){
		autocompleteHead();
	}
}
function changeAction(changeWhat,changeLocation){
	//Get the new info
	var newName = $("#"+changeWhat).val();
	var collegeid = getCollegeID();
	var hideID='#'+changeWhat+'Link';
	//AJAX it to a php script
	$.post(
		"http://albertyw.mit.edu/6470/process/collegesinglechange.php",
		{
			newName:newName,
			collegeID:collegeid,
			changeWhat:changeWhat
		},
		function(txt){//Show the change
			if(txt=='accept'){
				$(changeLocation).text(newName);
				$(hideID).show("slow");
			}
			if(txt=='improperformat'){
				$(changeLocation).append('Your text is improperly formatted');
			}
			if(txt=='wrongcollege'){
				$(changeLocation).append('The college could not be found');
			}
			if(txt=='toolong'){
				$(changeLocation).append('</h1><br />Your input is too long<h1>');
			}
		}
	)
}

function changePicture(){
	//Get the requested profile's id
	collegeid = getCollegeID();
	//Make a form
	var changepictureprompt = '<form enctype="multipart/form-data" action="http://albertyw.mit.edu/6470/process/uploader.php" method="POST">';
	changepictureprompt += '<input type="hidden" name="uploadtype" value="college" />';
	changepictureprompt += '<input type="hidden" name="id" value="'+collegeid+'" />';
	changepictureprompt += 'Choose a file to upload: <input name="uploadedfile" type="file" /><br />';
	changepictureprompt += '<input type="submit" value="Upload File" /><br />';
	changepictureprompt += 'Maximum file size is 500 kilobytes.';
	changepictureprompt += '</form>';
	//Show the form
	$("#changePictureLink").html(changepictureprompt);
}


//College Talk
function showMessage(collegemessagestart){
	collegeid = getCollegeID();
	$.post(
		"http://albertyw.mit.edu/6470/process/collegesinglemessageview.php",
		{
			collegesingleid:collegeid,
			collegemessagestart:collegemessagestart
		},
		function(txt){//Return info
			$("#collegemessageview").html(txt);
		}
	)
}
function postMessage(){
	//Get the message info
	var messagetext = $("#collegemessageposttext").val();
	var messagewriterid = $("#collegemessagepostwriterid").val();
	var collegeid = getCollegeID();
	//Send it through AJAX
	$.post(
		"http://albertyw.mit.edu/6470/process/collegesinglemessage.php",//Call this page
		{
			messagetext:messagetext,//Variables to post
			messagewriterid: messagewriterid,
			collegeid: collegeid
		},
		function(txt){//Return info
			var obj = JSON.parse(txt);//Parse by JSON
			if(obj.accept==false){//Does not accept
				var messagereturn = obj.messagereturn;
				$("#collegemessagereturn").html(messagereturn);
			}
			if(obj.accept==true){//Accept
				$("#collegemessagereturn").text('The message has been posted');
			}
		}
	)
	showMessage(0);
}
