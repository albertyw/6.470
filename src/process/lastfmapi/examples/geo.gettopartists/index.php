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
$geoClass = $apiClass->getPackage($auth, 'geo');

// Setup the variables
$methodVars = array(
	'country' => 'Brazil'
);

if ( $artists = $geoClass->getTopArtists($methodVars) ) {
	echo '<b>Data Returned</b>';
	echo '<pre>';
	print_r($artists);
	echo '</pre>';
}
else {
	die('<b>Error '.$geoClass->error['code'].' - </b><i>'.$geoClass->error['desc'].'</i>');
}

?>