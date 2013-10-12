<?php
/*
ADDRESS:	HTTP://ALBERTYW.MIT.EDU/6470/CONTACT.PHP
STATUS:		MAINTENANCE NEEDED: CSS
LAST MODIFIED:	JANUARY 21, 2009
DESCRIPTION:	HAS CONTACT INFO AND A FORM TO SUBMIT MESSAGES
USAGE:		PUBLIC
*/
//jQueryUI PHP Calls

//End jQuery UI Calls
$login=false;
if(isset($_SESSION['username']) && $_SESSION['username']!=''){//See if person is logged in
	$login=true;
	$username=$_SESSION['username'];
}
$title='molemusic | Contact Us';
$googlemaps=false;
$freebase=false;
session_start();
include("/opt/lampp/htdocs/6470/include/headeropen.php");?>
<script type="text/javascript">
$(document).ready(function() {
		var form = 'From: <input type="text" id="from" /><br />';
		form += 'Email: <input type="text" id="email" /><br />';
		form += '<textarea id="message"></textarea><br />';
		form += '<input type="submit" onclick="submitContact()" value="Submit"><br />';
		$("#contact").html(form);
	}
)
function submitContact(){
	var from = $("#from").val();
	var email = $("#email").val();
	var message = $("#message").val();
	$.post(
		"http://albertyw.mit.edu/6470/process/contact.php",
		{
			from: from,
			email: email,
			message: message
		},
		function(txt){
			$("#id").prepend('Your message has been submitted.<br />Thank you');
		}
	)
}
</script>
<?php include("/opt/lampp/htdocs/6470/include/headertext.php");?>

<center><h1>Contact Us</h1></center><br />
<!--This form is not in HTML to keep spammers away; see above!-->
<div id="contact"></div>


<?php include("/opt/lampp/htdocs/6470/include/footer.php");?>






<?php
//FUNCTIONS IN HERE

?>
