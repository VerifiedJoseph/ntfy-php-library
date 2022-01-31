<?php

/**
 * 	Code example for sending a messages
 */

include '../vendor/autoload.php';

use Ntfy\Server;
use Ntfy\Message;

use Ntfy\Exception\NtfyException;
use Ntfy\Exception\EndpointException;

try {
	// Set server
	$server = new Server('https://ntfy.sh/');
	
	// Create a new message 
	$message = new Message($server);
	$message->topic('mytopic');
	$message->title('Hello World');
	$message->body('Hello World from ntfy.sh');
	$message->priority(Message::PRIORITY_HIGH);

	// Sent the message
	$details = $message->send();

	// Display sent message details
	echo 'Id: ' . $details->id . PHP_EOL;
	echo 'Time: ' . $details->time . PHP_EOL;
	echo 'Topic: ' . $details->topic . PHP_EOL;
	echo 'Title: ' . $details->title . PHP_EOL;
	echo 'Message: ' . $details->message . PHP_EOL;
	echo 'Priority: ' . $details->priority . PHP_EOL;

} catch (EndpointException | NtfyException $err) {
	echo $err->getMessage();
}
