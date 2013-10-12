$(document).ready(function() {
		showMessage(0);
	}
)

function eventMakeFavorite(username, eventid, divid){
	if(username!='' && username!=null && eventid!='' && eventid!=null){
		$.post(
			"http://albertyw.mit.edu/6470/process/eventmakefavorite.php",
			{
				username:username,
				eventid:eventid
			},
			function(txt){
				if(txt=='accept'){
					$('#'+divid).text("You have RSVPed to this event");
				}
			}
		)
	}
}

function changeInfo(changeWhat){
	//Get the info
	var origName, changeLocation
	if(changeWhat=='changeName'){
		origName = $("#eventsinglename").text();
		changeLocation='#eventsinglename';
	}
	if(changeWhat=='changeArticle'){
		origName = $("#eventsinglearticle").text();
		changeLocation = '#eventsinglearticle';
	}
	var hideID='#'+changeWhat+'Link';
	//Make the form
	var inputForm = '<input type="text" length="100" id="'+changeWhat+'" value="'+origName+'">';
	inputForm += '<input type="submit" value="Change" onclick="javascript:changeAction(\''+changeWhat+'\',\''+changeLocation+'\')';
	//Display the form
	$(changeLocation).html(inputForm);
	//Hide the "change this" link
	$(hideID).hide("slow");
}
function changeAction(changeWhat,changeLocation){
	//Get the new info
	var newName = $("#"+changeWhat).val();
	var eventid = getEventID();
	var hideID='#'+changeWhat+'Link';
	//AJAX it to a php script
	$.post(
		"http://albertyw.mit.edu/6470/process/eventsinglechange.php",
		{
			newName:newName,
			eventID:eventid,
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

function changeAddress(){
	var address1 = $("#eventsingleaddress1").text();
	var address2 = $("#eventsingleaddress2").text();
	var form = '<input type="text" id="eventsingleaddress1" value="'+address1+'"><br />';
	form += '<input type="text" id="eventsingleaddress2" value="'+address2+'"><br />';
	form += '<input type="submit" onclick="javascript:changeAddressAction()" value="Change">';
	$("#eventsingleaddress").html(form);
}
function changeAddressAction(){
	var address1 = $("#eventsingleaddress1").val();
	var address2 = $("#eventsingleaddress2").val();
	var eventid = getEventID();
	$.post(
		"http://albertyw.mit.edu/6470/process/eventsinglechangeaddress.php",
		{
			address1: address1,
			address2: address2,
			eventid: eventid
		},
		function(txt){
			$("#eventsingleaddress").html(txt);
		}
	)
}
function changePicture(){
	//Get the requested profile's id
	eventid = getEventID();
	//Make a form
	var changepictureprompt = '<form enctype="multipart/form-data" action="http://albertyw.mit.edu/6470/process/uploader.php" method="POST">';
	changepictureprompt += '<input type="hidden" name="uploadtype" value="event" />';
	changepictureprompt += '<input type="hidden" name="id" value="'+eventid+'" />';
	changepictureprompt += 'Choose a file to upload: <input name="uploadedfile" type="file" /><br />';
	changepictureprompt += '<input type="submit" value="Upload File" /><br />';
	changepictureprompt += 'Maximum file size is 500 kilobytes.';
	changepictureprompt += '</form>';
	//Show the form
	$("#changePictureLink").html(changepictureprompt);
}


//Event Talk
function showMessage(eventmessagestart){
	eventid = getEventID();
	$.post(
		"http://albertyw.mit.edu/6470/process/eventsinglemessageview.php",
		{
			eventsingleid:eventid,
			eventmessagestart:eventmessagestart
		},
		function(txt){//Return info
			$("#eventmessageview").html(txt);
		}
	)
}
function postMessage(){
	//Get the message info
	var messagetext = $("#eventmessageposttext").val();
	var messagewritername = getUsername();
	var eventid = getEventID();
	//Send it through AJAX
	$.post(
		"http://albertyw.mit.edu/6470/process/eventsinglemessage.php",//Call this page
		{
			messagetext:messagetext,//Variables to post
			messagewritername: messagewritername,
			eventid: eventid
		},
		function(txt){//Return info
			var obj = JSON.parse(txt);//Parse by JSON
			if(obj.accept==false){//Does not accept
				var messagereturn = obj.messagereturn;
				$("#eventmessagereturn").html(messagereturn);
			}
			if(obj.accept==true){//Accept
				$("#eventmessagereturn").text('The message has been posted');
			}
		}
	)
	showMessage(0);
}
