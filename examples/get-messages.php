<?php

/**
 * 	Code example for gettings sent messages
 */

include '../vendor/autoload.php';

use Ntfy\Exception\NtfyException;
use Ntfy\Exception\EndpointException;

try {
	// Set server
	$server = new Ntfy\Server('https://ntfy.sh/');

	// Create Ntfy class instance
	$ntfy = new Ntfy\Ntfy($server);

	$messages = $ntfy->get(
		topic: 'myTopic',
	);

	// Dump sent messages
	var_dump($messages);

} catch (EndpointException | NtfyException $err) {
	echo $err->getMessage();
}
