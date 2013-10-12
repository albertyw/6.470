$(document).ready(function() {
		showMessage(0);
	}
)


function bandMakeFavorite(username, bandid, divid){
	if(username!='' && username!=null && bandid!='' && bandid!=null){
		$.post(
			"http://albertyw.mit.edu/6470/process/bandmakefavorite.php",
			{
				username:username,
				bandid:bandid
			},
			function(txt){
				if(txt=='accept'){
					$('#'+divid).text("This band has been added to your favorites list");
				}
			}
		)
	}
}

function changeInfo(changeWhat){
	//Get the info
	var origName, changeLocation
	if(changeWhat=='changeName'){
		origName = $("#bandsinglename").text();
		changeLocation='#bandsinglename';
	}
	if(changeWhat=='changeCollege'){
		origName = $("#bandsinglecollege").text();
		changeLocation='#bandsinglecollege';
	}
	if(changeWhat=='changeArticle'){
		origName = $("#bandsinglearticle").text();
		changeLocation = '#bandsinglearticle';
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
	var bandid = getBandID();
	var hideID='#'+changeWhat+'Link';
	//AJAX it to a php script
	$.post(
		"http://albertyw.mit.edu/6470/process/bandsinglechange.php",
		{
			newName:newName,
			bandID:bandid,
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
	bandid = getBandID();
	//Make a form
	var changepictureprompt = '<form enctype="multipart/form-data" action="http://albertyw.mit.edu/6470/process/uploader.php" method="POST">';
	changepictureprompt += '<input type="hidden" name="uploadtype" value="band" />';
	changepictureprompt += '<input type="hidden" name="id" value="'+bandid+'" />';
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

//Band Talk
function showMessage(bandmessagestart){
	bandid = getBandID();
	$.post(
		"http://albertyw.mit.edu/6470/process/bandsinglemessageview.php",
		{
			bandsingleid:bandid,
			bandmessagestart:bandmessagestart
		},
		function(txt){//Return info
			$("#bandmessageview").html(txt);
		}
	)
}
function postMessage(){
	//Get the message info
	var messagetext = $("#bandmessageposttext").val();
	var messagewriterid = $("#bandmessagepostwriterid").val();
	var bandid = getBandID();
	//Send it through AJAX
	$.post(
		"http://albertyw.mit.edu/6470/process/bandsinglemessage.php",//Call this page
		{
			messagetext:messagetext,//Variables to post
			messagewriterid: messagewriterid,
			bandid: bandid
		},
		function(txt){//Return info
			var obj = JSON.parse(txt);//Parse by JSON
			if(obj.accept==false){//Does not accept
				var messagereturn = obj.messagereturn;
				$("#bandmessagereturn").html(messagereturn);
			}
			if(obj.accept==true){//Accept
				$("#bandmessagereturn").text('The message has been posted');
			}
		}
	)
	showMessage(0);
}
