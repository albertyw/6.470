
$(document).ready(function() {
		showMessage(0);
	}
)

function musicMakeFavorite(username, musicid, divid){
	if(username!='' && username!=null && musicid!='' && musicid!=null){
		$.post(
			"http://albertyw.mit.edu/6470/process/musicmakefavorite.php",
			{
				username:username,
				musicid:musicid
			},
			function(txt){
				if(txt=='accept'){
					$('#'+divid).text("This music has been added to your favorites list");
				}
			}
		)
	}
}

function changeInfo(changeWhat){
	//Get the info
	var origName, changeLocation
	if(changeWhat=='changeName'){
		origName = $("#musicsinglename").text();
		changeLocation='#musicsinglename';
	}
	if(changeWhat=='changeCollege'){
		origName = $("#musicsinglecollege").text();
		changeLocation='#musicsinglecollege';
	}
	if(changeWhat=='changeArticle'){
		origName = $("#musicsinglearticle").text();
		changeLocation = '#musicsinglearticle';
	}
	var hideID='#'+changeWhat+'Link';
	//Make the form
	var inputForm = '<input type="text" length="100" id="'+changeWhat+'" value="'+origName+'">';
	inputForm += '<input type="submit" value="Change" onclick="javascript:changeAction(\''+changeWhat+'\',\''+changeLocation+'\')';
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
	var musicid = getMusicID();
	var hideID='#'+changeWhat+'Link';
	//AJAX it to a php script
	$.post(
		"http://albertyw.mit.edu/6470/process/musicsinglechange.php",
		{
			newName:newName,
			musicID:musicid,
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
	musicid = getMusicID();
	//Make a form
	var changepictureprompt = '<form enctype="multipart/form-data" action="http://albertyw.mit.edu/6470/process/uploader.php" method="POST">';
	changepictureprompt += '<input type="hidden" name="uploadtype" value="music" />';
	changepictureprompt += '<input type="hidden" name="id" value="'+musicid+'" />';
	changepictureprompt += 'Choose a file to upload: <input name="uploadedfile" type="file" /><br />';
	changepictureprompt += '<input type="submit" value="Upload File" /><br />';
	changepictureprompt += 'Maximum file size is 500 kilobytes.';
	changepictureprompt += '</form>';
	//Show the form
	$("#changePictureLink").html(changepictureprompt);
}


//FUNCTIONS FOR COLLEGE AJAX AUTOCOMPLETE

function autocompleteHead() {
	//Function that is run when college input is typed into
	$("#changeCollege").autocomplete(
		"http://albertyw.mit.edu/6470/process/autocomplete_college.php",
		{
			delay:10,
			minChars:2,
			matchSubset:0,
			matchContains:0,
			cacheLength:1,
			onItemSelect:selectItem,
			onFindValue:findValue,
			formatItem:formatItem,
			autoFill:true,
			maxItemsToShow:5
		}
	)
}
function findValue(li) {
	if( li == null ) return alert("No match!");
	// if coming from an AJAX call, let\'s use the CityId as the value
	if( !!li.extra ) var sValue = li.extra[0];
	// otherwise, let\'s just display the value in the text box
	else var sValue = li.selectValue;
	//alert("The value you selected was: " + sValue);
}
function selectItem(li) {
	findValue(li);
}
function formatItem(row) {
	return row[0];
}
function lookupAjax(){
	var oSuggest = $("#changeCollege")[0].autocompleter;
	oSuggest.findValue();
	return false;
}



//Music Talk
function showMessage(musicmessagestart){
	musicid = getMusicID();
	$.post(
		"http://albertyw.mit.edu/6470/process/musicsinglemessageview.php",
		{
			musicsingleid:musicid,
			musicmessagestart:musicmessagestart
		},
		function(txt){//Return info
			$("#musicmessageview").html(txt);
		}
	)
}
function postMessage(){
	//Get the message info
	var messagetext = $("#musicmessageposttext").val();
	var messagewriterid = $("#musicmessagepostwriterid").val();
	var musicid = getMusicID();
	//Send it through AJAX
	$.post(
		"http://albertyw.mit.edu/6470/process/musicsinglemessage.php",//Call this page
		{
			messagetext:messagetext,//Variables to post
			messagewriterid: messagewriterid,
			musicid: musicid
		},
		function(txt){//Return info
			var obj = JSON.parse(txt);//Parse by JSON
			if(obj.accept==false){//Does not accept
				var messagereturn = obj.messagereturn;
				$("#musicmessagereturn").html(messagereturn);
			}
			if(obj.accept==true){//Accept
				$("#musicmessagereturn").text('The message has been posted');
			}
		}
	)
	showMessage(0);
}
