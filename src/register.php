<?php
/*
ADDRESS:	HTTP://ALBERTYW.MIT.EDU/6470/REGISTER.PHP
STATUS:		MAINTENANCE NEEDED: DEBUGGING/TESTING, ADDITION OF CSS/DESIGN/LAYOUT
LAST MODIFIED:	JANUARY 13, 2009 BY ALBERT WANG
DESCRIPTION:	ALLOWS VISITORS TO REGISTER FOR AN ACCOUNT
USAGE:		PUBLIC
*/
//Nifty Cube Corners Javascript Calls

//End Nifty Cube Calls
//jQueryUI PHP Calls

//End jQuery UI Calls
$title='Register for An Account';
$googlemaps=false;
$freebase=false;
session_start();
include("/opt/lampp/htdocs/6470/include/headeropen.php");
if(isset($_SESSION['username']) && $_SESSION['username']!=''){//If the user is already logged in, redirect to profile page
	echo '<script type="text/javascript">
	<!--
	window.location = "http://albertyw.mit.edu/6470/profile/"
	//-->
	</script>
	';
}?>
<script type="text/javascript" src="http://albertyw.mit.edu/6470/include/jquery.autocomplete.js"></script>
<script type="text/javascript">
//FUNCTIONS FOR THE COLLEGE AUTOCOMPLETE
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
	var oSuggest = $("#CollegeAjax")[0].autocompleter;
	oSuggest.findValue();
	return false;
}

function captcha(){//CAPTCHA
	$.post(
		"http://albertyw.mit.edu/6470/process/registrationcaptcha.php", //Server file
	{//Data to be sent
		//Nothing needed
	},
	function(json){//Data to be received
		obj = JSON.parse(json);
		message = obj.message;
		captchakey = obj.captchakey
		$("#captcha").html(message);
	}
	)
}


$(document).ready(function() {
	captcha();
	//Function that is run when college input is typed into
	$("#CollegeAjax").autocomplete(
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
	//Update the domain when email input is typed into
	$("#email").keypress(function (press) {
		var college = $("#CollegeAjax").val();
		$.post(
			"http://albertyw.mit.edu/6470/process/registrationemail.php", //Server file
			{//Data to be sent
				college: college
			},
			function(domain){//Data to be received
				$("#emaildomain").text("@"+domain);
			}
		)
	})//Update the domain when college input is typed into
	$("#CollegeAjax").keypress(function (press) {
		var college = $("#CollegeAjax").val();
		$.post(
			"http://albertyw.mit.edu/6470/process/registrationemail.php", //Server file
			{//Data to be sent
				college: college
			},
			function(domain){//Data to be received
				$("#emaildomain").text("@"+domain);
			}
		)
	})
});





//FUNCTION WHEN SUBMIT BUTTON IS PRESSED
function submitregistration(){
	//Read Values
	var username = $("#usernamepage").val();
	var password = $("#passwordpage").val();
	password = sha1Hash(password);//SHA1 Hash for security
	var passwordconfirm = $("#password2page").val();
	passwordconfirm = sha1Hash(passwordconfirm);
	var realname = $("#realnamepage").val();
	var college = $("#CollegeAjax").val();
	var email = $("#emailpage").val();
	var captchaanswer = $("#captchaanswer").val();
	//Also will be using var captchakey

	//Checking values
	var message='';
	if(password!=passwordconfirm){//Make sure passwords are correct
		message = "Your two passwords don't match.  Please retype them.<br />";
	}else{//If passwords match, then:
	//Send stuff over to server
	$.post(
		"http://albertyw.mit.edu/6470/process/registrationcheck.php", //Server file that JSON will be sent to
		{//Data to be sent
			username: username,
			password: password,
			realname: realname,
			college: college,
			email: email,
			captchaanswer: captchaanswer,
			captchakey: captchakey
		},
		function(txt){//Data to be received
			data = JSON.parse(txt);//Processing
			if(data.captcha == false)//Bad Captcha
				message = "Your CAPTCHA answer is incorrect.<br />";
			if(data.usernameformat == false)//Bad inputs
				 message = message + "Your username is formatted incorrectly.<br />";
			if(data.passwordformat == false)
				 message = message + "Your password is formatted incorrectly.<br />";
			if(data.realnameformat == false)
				 message = message + "Your real name is formatted incorrectly.<br />";
			if(data.collegeformat == false)
				 message = message + "Your college is formatted incorrectly.<br />";
			if(data.emailformat == false)
				 message = message + "Your email is formatted incorrectly.<br />";
			 if(data.usernamefree == false)//Username already taken
				message = message + "The username is already taken.<br />";
			if(data.emailfree == false)//Email already taken
				message = message + "The email address has already been registered.<br />";
			if(data.collegecorrect == false)//Incorrect College
				 message = message + 'Your college is incorrect.  Please search again or <a href="admin@albertyw.mit.edu">email the administrators</a>.<br />';
			if(data.registered == true){//Registration was submitted, and processed
				message = "Registration Submitted.  An email has been sent to your email address.  Please confirm it to log in.<br /><a href=\"http://albertyw.mit.edu/6470/\">Back</a>";
				$("#form").html(message);//Overwrite the form
			}else{
				$("#messages").html(message);//Add message before form
				captcha();
			}
		}
	)}
}
</script>
<?php include("/opt/lampp/htdocs/6470/include/headertext.php");?>
<center><h1>Register For An Account</h1></center><br />

<div id="form">
<div id="messages">
</div>
Between 5 and 20 Alphanumeric characters please!<br />
Username: <input type="text" length="20" id="usernamepage" /><br />
Password:<input type="password" length="20" id="passwordpage" /><br />
Password (Confirm):<input type="password" length="20" id="password2page" /><br />
Real Name: <input type="text" length="20" id="realnamepage" /><br />
College: <input type="text" id="CollegeAjax" value=""/><br />
College Email Address: <input type="text" length="20" id="emailpage" /><span id="emaildomain"></span><br />
<span id="captcha"></span>
By registering, you agree to the <a href="http://albertyw.mit.edu/6470/tos/">Terms of Service</a><br>
<input type="button" length="20" value="Register" onclick="submitregistration()" /><br />
</div>


<submit>
<br><br>



<?php include("/opt/lampp/htdocs/6470/include/footer.php");?>






<?php
//FUNCTIONS IN HERE

?>
