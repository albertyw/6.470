<?php

// Include the API
require '../../lastfmapi/lastfmapi.php';

// Get the session auth data
$file = fopen('../auth.txt', 'r');
// Put the auth data into an array
$authVars = array(
	'apiKey' => trim(fgets($file)),
	'secret' => trim(fgets($file)),
	'username' => trim(fgets($file)),
	'sessionKey' => trim(fgets($file)),
	'subscriber' => trim(fgets($file))
);
// Pass the array to the auth class to eturn a valid auth
$auth = new lastfmApiAuth('setsession', $authVars);

// Call for the album package class with auth data
$apiClass = new lastfmApi();
$eventClass = $apiClass->getPackage($auth, 'event');

// Setup the variables
$methodVars = array(
	'eventId' => '666379',
	'status' => 2
);

if ( $eventClass->attend($methodVars) ) {
	echo '<b>Status changed to: '.$methodVars['status'].'</b>';
}
else {
	die('<b>Error '.$eventClass->error['code'].' - </b><i>'.$eventClass->error['desc'].'</i>');
}

?>