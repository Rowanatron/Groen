
<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

$url='http://makeitwork.local.mybit.nl/vms/klanty/testing';
$username = 'makeitwork';
$password = 'itWorkMake2018';

//  Initiate curl
$ch = curl_init();

// Set the url
curl_setopt($ch, CURLOPT_URL,$url);

// Will return the response, if false it print the response
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

// volgende regels voor eventueel inloggen
curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $password);

// include header in output: false;
curl_setopt($ch, CURLOPT_HEADER, 0);

// Execute
$result=curl_exec($ch);

if($result === FALSE) {
    echo "cURL Error: " . curl_error($ch);
}

// Closing
curl_close($ch);

print_r(json_decode($result, true));

?>