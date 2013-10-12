$(document).ready(function(){

        $("#register").click(function () {//TO BE RUN WHEN THE REGISTER BUTTON IS CLICKED
	  var registerform='<div id="registermessagestop">';
	  registerform +='</div>';
	  registerform +='<p>';
	    registerform +='<label>Username</label>';
	    registerform +='<input type="text" length="20" id="usernameregister" />';
	    registerform +='<a href="javascript:hide1()" class="right">X</a>';
	  registerform +='</p>';
	  registerform +='<p>';
	    registerform +='<label>Password</label>';
	    registerform +='<input type="password" length="20" id="passwordregister" />';
	  registerform +='</p>';
	  registerform +='<p>';
	    registerform +='<label>Confirm Password</label>';
	    registerform +='<input type="password" length="20" id="password2register" />';
	  registerform +='</p>';
	  registerform +='<p>';
	    registerform +='<label>College:</label>';
	    registerform +='<input type="text" id="CollegeAjaxregister" value=""/>';
	  registerform +='</p>';
	  registerform +='<p>';
	    registerform +='<label>College Email Address:</label>';
	    registerform +='<input type="text" length="20" id="emailregister" />';
	    registerform +='<span id="emaildomain"></span>';
	  registerform +='</p>';
	  registerform +='<p>';
	    registerform +='<span id="captcharegister"></span>';
	  registerform +='</p>';
	  registerform +='<p>By registering, you agree to ';
	  registerform +='the <a href="http://albertyw.mit.edu/6470/tos/">Terms of ';
	  registerform +='Service</a>';
	  registerform +='</p>';
	  registerform +='<p>';
	    registerform +='<input type="button" length="20" value="Register"';
	    registerform +='onclick="submitregistrationtop()" />';
	  registerform +='</p>';
	  registerform +='<a href="javascript:hide2()" class="right">hide this window</a>';
	  $("#registerform").html(registerform);//Add the form into the page
	  captcharegister();//Run the captcha function
	  $("#CollegeAjaxregister").autocompleteregistration(//Bind autocomplete to the form
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
	$("#emailregister").keypress(function (press) {
		var college = $("#CollegeAjaxregister").val();
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
	$("#CollegeAjaxregister").keypress(function (press) {
		var college = $("#CollegeAjaxregister").val();
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
          $("#registration").show("slide", {direction: "up"}, 1000);
        });//END REGISTER CLICK FUNCTION
	$("#usernameLogin").click(function() {//Clear username login when clicked on
			$("#usernameLogin").val("");
		}
	)
	$("#usernameLogin").keypress(function (key) {
			if(key.which==13){//13 is equal to "enter"
				submitlogin();
			}
		}
	)
	$("#passwordLogin").click(function() {//clear password login when clicked on
			$("#passwordLogin").val("");
		}
	)
	$("#passwordLogin").keypress(function (key) {//
			if(key.which==13){//13 is equal to "enter"
				submitlogin();
			}
		}
	)

});//END DOCUMENT.READY

function hide2(){//When the hide link is clicked
	$("#registerform").html('');
	$("#registration").hide("slide", {direction: "up"}, 1000);
}
function hide1(){//When the hide button is clicked
	$("#registerform").html('');
	$("#registration").hide("slide", {direction: "up"}, 1000);
}

function captcharegister(){//CAPTCHA for registration
	$.post(
		"http://albertyw.mit.edu/6470/process/registrationcaptcha.php", //Server file
	{//Data to be sent
		registrationtop:true
	},
	function(json){//Data to be received
		obj = JSON.parse(json);
		message = obj.message;
		captchakey = obj.captchakey
		$("#captcharegister").html(message);
	}
	)
}

function submitregistrationtop(){//TO BE RUN WHEN USER REGISTERS
	//Read Values
	var username = $("#usernameregister").val();
	var password = $("#passwordregister").val();
	password = sha1Hash(password);//SHA1 Hash for security
	var passwordconfirm = $("#password2register").val();
	passwordconfirm = sha1Hash(passwordconfirm);
	var realname = $("#realnameregister").val();
	var college = $("#CollegeAjaxregister").val();
	var email = $("#emailregister").val();
	var captchaanswer = $("#captchaanswerregister").val();
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
				message = "Registration Submitted.  An email has been sent to your email address.  Please confirm it to log in.<br /><a href=\"javascript:hide()\">Back</a>";
				$("#registerform").html(message);//Overwrite the form
			}else{
				$("#registermessagestop").html(message);//Add message before form
				captcharegister();
			}
		}
	)}
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
function lookupAjaxCollege(){
	var oSuggest = $("#CollegeAjaxregister")[0].autocompleter;
	oSuggest.findValue();
	return false;
}
