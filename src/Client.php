<?php

declare(strict_types=1);

namespace Ntfy;

use stdClass;
use Ntfy\Auth\User;
use Ntfy\Auth\Token;
use Ntfy\Exception\NtfyException;

class Client
{
    /** @var Guzzle $guzzle Guzzle class instance */
    private Guzzle $guzzle;

    /**
     * @param Server $server Server URI
     * @param Auth\User|Auth\Token $auth Authentication class instance
     */
    public function __construct(Server $server, User|Token|null $auth = null)
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
        $message = Json::decode($response->getBody()->getContents());

        return $message;
    }
}
