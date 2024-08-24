// Send an SMS using Twilio's REST API and PHP
<?php
// Required if your environment does not handle autoloading
require __DIR__ . '/vendor/autoload.php';

// Your Account SID and Auth Token from console.twilio.com
$sid = "ACbed2bb98db1a39fc89e1f2efa04fddf0";
$token = "46127148ca0fedf60ca3c0a95fe23bec";
$client = new Twilio\Rest\Client($sid, $token);

// Use the Client to make requests to the Twilio REST API
$client->messages->create(
    // The number you'd like to send the message to
    '+919336882409',
    [
        // A Twilio phone number you purchased at https://console.twilio.com
        'from' => '+919336882409',
        // The body of the text message you'd like to send
        'body' => "Hey Jenny! Good luck on the bar exam!"
    ]
);