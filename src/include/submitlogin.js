//Called when the submit/login button is pressed
function submitlogin()  {
	$("#loginmessage").empty();
	//Find username and password values from form
	var username = $("#usernameLogin").val();
	var password = $("#passwordLogin").val();
	if(username=='User Name' && password=='password'){//For the login page itself

		username = $("#username").val();
		password = $("#password").val();
	}
	password = sha1Hash(password);//SHA1 Hash the password for security
	$.post(
		"http://albertyw.mit.edu/6470/process/login.php", //argument #1 - the server file where the request is sent
		{
			username: username, //argument #2 - the data to be sent
			password: password
		},
		function(txt){ //argument#3 - process the return text
			var datasets = JSON.parse(txt); //JSON string to object
			if(datasets.login==true){//The login is correct, redirect to profile.php
				window.location = "http://albertyw.mit.edu/6470/user/"+username+"/"+password+"/";
				//window.location = "http://albertyw.mit.edu/6470/user.php?username="+username+"&password="+password;
			}else{//The Login is incorrect, show message
				$("#loginmessage").css("border","3px solid red");
				$("#loginmessage").text("Login Not Correct");
			}
		}
	)
};
