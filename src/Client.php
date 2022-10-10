<?php

namespace Ntfy;

use stdClass;
use Ntfy\Exception\NtfyException;

class Client
{
    private Server $server;

    private ?Auth $auth;

    /**
     * @param Server $server Server URI
     * @param ?Auth $auth Authentication username and password
     */
    public function __construct(Server $server, ?Auth $auth = null)
    {
        $this->server = $server;
        $this->auth = $auth;
    }

    /**
     * Send the message to the defined server.
     *
     * @param Message $message
     * @return stdClass
     * @throws NtfyException
     */
    public function send(Message $message): stdClass
    {
        $guzzle = new Guzzle(
            $this->server->get(),
            $this->auth
        );

        $response = $guzzle->post('', $message->getData());

        $message = Json::decode($response->getBody());

        return $message;
    }
}
