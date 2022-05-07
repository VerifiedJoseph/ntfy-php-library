<?php

/**
 * 	Code example for sending a message with a view action button
 */

include '../vendor/autoload.php';

use Ntfy\Server;
use Ntfy\Message;

use Ntfy\Exception\NtfyException;
use Ntfy\Exception\EndpointException;

try {
	// Set server
	$server = new Server('https://ntfy.sh/');
	
	// Create a new view action
	$action = new Ntfy\Action\View();
	$action->label('Open website');
	$action->url('https://example.com/');

	// Create a new message 
	$message = new Message($server);
	$message->topic('mytopic');
	$message->title('Hello World');
	$message->body('Hello World from ntfy.sh');
	$message->priority(Message::PRIORITY_HIGH);
	$message->action($action);

	// Sent the message
	$details = $message->send();

	// Display sent message details
	echo 'Id: ' . $details->id . PHP_EOL;
	echo 'Time: ' . $details->time . PHP_EOL;
	echo 'Topic: ' . $details->topic . PHP_EOL;
	echo 'Title: ' . $details->title . PHP_EOL;
	echo 'Message: ' . $details->message . PHP_EOL;
	echo 'Priority: ' . $details->priority . PHP_EOL;

	echo 'Action type: ' . $details->actions[0]->action . PHP_EOL;
	echo 'Action label: ' . $details->actions[0]->label . PHP_EOL;
	echo 'Action url: ' . $details->actions[0]->url . PHP_EOL;

} catch (EndpointException | NtfyException $err) {
	echo $err->getMessage();
}
