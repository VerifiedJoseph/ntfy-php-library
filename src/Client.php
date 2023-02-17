<?php

namespace Ntfy;

use stdClass;
use Ntfy\Exception\NtfyException;

class Client
{
    /** @var Guzzle $guzzle Guzzle class instance */
    private Guzzle $guzzle;

    /**
     * @param Server $server Server URI
     * @param ?Auth $auth Authentication class instance
     */
    public function __construct(Server $server, ?Auth $auth = null)
    {
        $this->guzzle = new Guzzle(
            $server->get(),
            $auth
        );
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
        $response = $this->guzzle->post('', $message->getData());
        $message = Json::decode($response->getBody());

        return $message;
    }
}
