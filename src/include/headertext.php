<?php
/*
ADDRESS:	HTTP://ALBERTYW.MIT.EDU/6470/INCLUDE/HEADERTEXT.PHP
STATUS:		UNFINISHED
LAST MODIFIED:	January 25, 2008 by dsngiem
DESCRIPTION:	THE VISIBLE PART OF HEADER (E.G. NAVIGATION)
USAGE:		HIDDEN
*/

$login=false;
if(isset($_SESSION['username']) && $_SESSION['username']!=''){//See if person is logged in
	$login=true;
}
?>
  </head>

  <body>
    <div id="shadow">
    <div id="header">
      <div id="registration">
	<div id="registerform">
	</div><!-- id="registerform"!-->
      </div><!-- id="registration!-->
      <div class="nest">
      </div>
      <div class="logo"> <!-- for positioning -->
          <a href="http://albertyw.mit.edu/6470/">
	  <img src="http://albertyw.mit.edu/6470/img/idHeader.logo.png" />
	</a>
	<span class="tag">the underground college music scene</span>
      </div>
<?php
	if($login==true){
	  echo '
      <div class="upper"> <!-- for the top row of links -->
	<ul>
	  <li class="settings">
            <a href="/6470/user/">' . $_SESSION['username'] . '</a>
	  </li>
	  <li id="logout">
	    <a href="/6470/logout/">logout</a>
	  </li>
	</ul>
      </div>';
	}else{
	  echo '
      <div class="upper"> <!-- for the top row of links -->
	<ul>
	  <li class="login">
	    <div id="loginmessage"> <!-- needed for javascript -->
	    </div>
            <form>
	    <input type="text" length="20" value="User Name" id="usernameLogin" />
	    <input type="password" length="20" id="passwordLogin" value="password"/>
	    </form>
	    <!-- I prefer to not have a button so that users can just --
	       -- press enter to login. -- commented code follows --
	    <input type="button" length="20" value="Log In" onclick="submitlogin()" />
		<div id="loginretrieve">
		  <a href="http://albertyw.mit.edu/6470/retrievelogin/">
		    Forgot your login?
		  </a>
		</div>
		   -->
	  </li>
	  <li id="register">
	    register
	  </li>
	</ul>
      </div>';}?>
      <div class="lower"> <!-- for the bottom row of links -->
	<ul>
	  <li>
	    <a href="/6470/bands/" class="artists">bands</a>
	  </li>
	  <li>
	    <a href="/6470/music/" class="music">music</a>
	  </li>
	  <li>
	    <a href="/6470/college/" class="colleges">colleges</a>
	  </li>
	  <li>
	    <a href="/6470/event/" class="events">events</a>
	  </li>
	</ul>
      </div>
    </div>
 <!--
    <div id="core">
	<h1>an image and a name and other junk will lovingly go here.</h1>
    </div>
-->
    <div id="split"> <!-- This is here for the transition between the --
		       -- core and the content -->
    </div>

    <div id="content">