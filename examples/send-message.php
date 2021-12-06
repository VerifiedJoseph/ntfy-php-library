<?php

/**
 * 	Code example for sending a messages
 */

include '../vendor/autoload.php';

use Ntfy\Exception\NtfyException;
use Ntfy\Exception\EndpointException;

try {
	// Set server
	$server = new Ntfy\Server('https://ntfy.sh/');

	// Create Ntfy class instance
	$ntfy = new Ntfy\Ntfy($server);
		
	$sentMessage = $ntfy->send(
		topic: 'myTopic',
		message: 'Hello World'
	);

	// Dump sent message details
	var_dump($sentMessage);

} catch (EndpointException | NtfyException $err) {
	echo $err->getMessage();
}
