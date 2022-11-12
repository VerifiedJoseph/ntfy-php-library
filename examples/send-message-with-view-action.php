<?php

/**
 * 	Code example for sending a message with a view action button
 */

include '../vendor/autoload.php';

use Ntfy\Client;
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
    $message = new Message();
    $message->topic('mytopic');
    $message->title('Hello World');
    $message->body('Hello World from ntfy.sh');
    $message->priority(Message::PRIORITY_HIGH);
    $message->action($action);

    $client = new Client($server);
    $response = $client->send($message);

    // Display sent message details
    echo 'Id: ' . $response->id . PHP_EOL;
    echo 'Time: ' . $response->time . PHP_EOL;
    echo 'Topic: ' . $response->topic . PHP_EOL;
    echo 'Title: ' . $response->title . PHP_EOL;
    echo 'Message: ' . $response->message . PHP_EOL;
    echo 'Priority: ' . $response->priority . PHP_EOL;

    echo 'Action type: ' . $response->actions[0]->action . PHP_EOL;
    echo 'Action label: ' . $response->actions[0]->label . PHP_EOL;
    echo 'Action url: ' . $response->actions[0]->url . PHP_EOL;
} catch (EndpointException | NtfyException $err) {
    echo $err->getMessage();
}
