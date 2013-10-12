<?php
/*
ADDRESS:	HTTP://ALBERTYW.MIT.EDU/6470/PROFILE.PHP
STATUS:		MAINTENANCE NEEDED: BASIC CODING FINISHED.  NEED FORMATTING, SUBMIT SHOULD RESPOND TO ENTER BUTTON
LAST MODIFIED:	JANUARY 15, 2009 by ALBERT WANG
DESCRIPTION:	HOME PAGE FOR WEBSITE
USAGE:		PUBLIC
*/

//jQueryUI PHP Calls

//End jQuery UI Calls

//Send stuff to headeropen
$googlemaps=false;//Whether to include the google maps api
$getusername = $_GET['username'];
//Confirm login/password
session_start();
if(!isset($_SESSION['username']) || !$getusername==''){//If the person isn't already logged in
  $username=$_GET['username'];
  $password=$_GET['password'];
  //Open mySQL Connection, usually this is in headeropen, but we need it early
  $connection = mysql_connect("localhost", "6470", "6470") or die("mySQL Connection Error<br />\n");
  $database='6470_main';
  mysql_select_db($database) or die('Error, could not access database '.$database."\n");
  $result = mysql_query("SELECT * FROM user WHERE username='$username'") or die(mysql_error());
  $row = mysql_fetch_array($result);
  if($row['password']==$password){//Log in is correct
    $_SESSION['id']=$row['id'];
    echo $_SESSION['id'].'<br>';
    $_SESSION['username']=$username;
    $_SESSION['realname']=$row['realname'];
    $_SESSION['usercollegeid']=$row['collegeid'];
    $title = 'molemusic | '.$realname.'\'s home';
  }else{//Login is not correct
    $logincorrect=false;
    $title = 'molemusic | profile';
  }
}
//Copy session variables to this page's variables
  $userid=$_SESSION['id'];
  $username=$_SESSION['username'];
  $realname=$_SESSION['realname'];
  $usercollegeid=$_SESSION['usercollegeid'];
  $title = 'molemusic | '.$realname.'\'s home';
include("/opt/lampp/htdocs/6470/include/headeropen.php");?>
<?php include("/opt/lampp/htdocs/6470/include/headertext.php");?>



<a href="http://albertyw.mit.edu/6470/profile/">Profile</a>
  <div class="wide block">
  <h1>Recently Viewed Bands</h1>
  <ol class="50xx">
      <?php //Find bands and colleges associated with this user
      $result = mysql_query("SELECT * FROM userbandview WHERE userid='$userid'");
      $total=1;
      while($total<=5 && $exit==false){
        $row=mysql_fetch_array($result);
	if($row['id']=='' || $row['id']==null)
		$exit=true;
	//Make sure that the band has not already been displayed
	$finder=1;
	$displaythis=true;
	while($finder<=count($viewband)){
		if($viewband[$finder]==$row['bandid'])
			$displaythis=false;
		$finder++;
	}

	if($displaythis==true){
	echo '<li>';
        $bandid=$row['bandid'];//Remeber the band and college id
	$viewband[$total]=$bandid;
        $collegeid=$row['collegeid'];

        $result2 = mysql_query("SELECT * FROM band WHERE id='$bandid'");//Find the band's real name/picture
        $row2 = mysql_fetch_array($result2);
        echo '<span style="background-image:';
        echo $row2['picture'].'">
        </span>';

        echo '<strong><a href="http://albertyw.mit.edu/6470/bands/'.$bandid.'/">';//Start the link to the band
        echo $row2['name'];//Display the name
        echo '</a></strong>';//End the link

        $result3 = mysql_query("SELECT * FROM college WHERE id='$collegeid'");//Find the college's real name
        $row3 = mysql_fetch_array($result3);
        echo '<em>'.$row3['college'].'</em>';//College name
        echo '</li>';
	$total++;
	}
      }

      ?>
  </ol>
  </div><!-- class="wide block" END RECENTLY VIEWED BANDS!-->




  <div class="wide block"><!-- START COLLEGE BANDS !-->
  <?php //Find the name of the user's college
  $query = "SELECT college.college FROM user, college WHERE ((user.collegeid = college.id) AND (user.username='$username'))";
  $result = mysql_query($query) or die(mysql_error());
  $row=mysql_fetch_array($result);
  echo '<h1>'.$row['college'].' Bands</h1>';
  ?>
  <ol class="50xx">
    <?php //Find band names associated with this college
      $result = mysql_query("SELECT * FROM band WHERE collegeid='$usercollegeid'");
      $number_bands = mysql_num_rows($result);
      $picks = 1;
      $bandsgiven = min(5,$number_bands); //Number of bands to show
      unset($bandid);
      while($picks <=$bandsgiven){ //Pick which bands are shown
        $bandid[$picks]=rand(1,$number_bands);
        $finder=1;//Make sure that $bandid is not already picked
        while($finder<$picks){
          if($bandid[$finder]==$bandid[$picks])//If its already picked, redo
            $picks--;
          $finder++;
        }
        $picks++;
      }
      //Start searching and displaying bands
      $picks=1;
      while($row = mysql_fetch_array($result)){//From previous mysql query
        $finder=1;
        while($finder<=$bandsgiven){
          if($picks==$bandid[$finder]){
            $currentbandid = $row['id'];

            echo '<span style="background-image:';
            echo $row['picture'].'"></span>';

            echo '<strong><a href="http://albertyw.mit.edu/6470/bands/'.$currentbandid.'/">';//Start the link to the band
            echo $row['name'];//Display the name
            echo '</a></strong>';//End the link
	    echo "\n";//New Line
          }
          $finder++;
        }
        $picks++;
      }
    ?>
  </ol>
</div><!-- class="half block" END COLLEGE BANDS !-->



<div class="half block"><!-- START MOST VIEWED AT COLLEGE!-->
  <?php //Find the name of the user's college
  $result = mysql_query("SELECT * FROM college WHERE id='$usercollegeid'") or die(mysql_error());
  $row=mysql_fetch_array($result);
  echo '<h1>Popular Bands at '.$row['college'].'</h1>';
  ?>
  <ol class="50xx">
  <?php
  $query = "SELECT * FROM band WHERE collegeid='$usercollegeid' ORDER BY views DESC";
  $result = mysql_query($query) or die(mysql_error());
  $returnnum = min(5,mysql_num_rows($result));
  $count = 1;
  while($count<=$returnnum){
    $row = mysql_fetch_array($result);
    echo '<li>';
    echo '<span style="background-image:'.$row['picture'].';">';
    echo '</span>';
    echo '<strong><a href="http://albertyw.mit.edu/6470/bands/'.$row['id'].'/">'.$row['name'].'</a></strong>';
    //$collegeid = $row['collegeid'];
    //$result2 = mysql_query ("SELECT * FROM college WHERE id = '$collegeid'") or die(mysql_error());
    //$row2 = mysql_fetch_array($result2);
    //echo '<em>'.$row2['name'].'</em>';
    echo '</li>';
    $count++;
  }

  ?>
  </ol>
</div><!-- END MOST VIEWED AT COLLEGE !-->



<div class="half block"><!-- START FRIENDS AT COLLEGE !-->
  <?php //Find the name of the user's college
  $result = mysql_query("SELECT * FROM college WHERE id='$usercollegeid'") or die(mysql_error());
  $row=mysql_fetch_array($result);
  echo '<h1>People At '.$row['college'].'</h1>';
  ?>
  <ul class="50xx">
  <?php //Find user names associated with this college
      $result = mysql_query("SELECT * FROM user WHERE collegeid='$usercollegeid'");
      $number_users = mysql_num_rows($result);
      $picks = 1;
      $usersgiven = min(5,$number_users); //Number of bands to show
      while($picks <=$usersgiven){ //Pick which bands are shown
        $usersid[$picks]=rand(1,$number_users);
        $finder=1;//Make sure that $bandid is not already picked
        while($finder<$picks){
          if($usersid[$finder]==$usersid[$picks])//If its already picked, redo
            $picks--;
          $finder++;
        }
        $picks++;
      }
      ////Start searching and displaying bands
      $picks=1;
      while($row = mysql_fetch_array($result)){//From previous mysql query
        $finder=1;
        while($finder<=$usersgiven){
          if($picks==$usersid[$finder]){
            $currentusersid = $row['userid'];

	    echo '<li>';
            echo '<span style="background-image:';
            echo $row['picture'].'">
            </span>';

            echo '<strong><a href="http://albertyw.mit.edu/6470/profile/'.$row['id'].'/">';//Start the link to the band
            echo $row['realname'];//Display the name
            echo '</a></strong>';//End the link
	    echo '</li>';
          }
          $finder++;
        }
        $picks++;
      }
    ?>
  </ul>
      </div>

<?php include("/opt/lampp/htdocs/6470/include/footer.php");?>
