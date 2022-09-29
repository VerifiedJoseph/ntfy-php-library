<?php

namespace Ntfy;

use stdClass;
use Ntfy\Exception\NtfyException;

class Dispatcher
{
	private Server $server;

	private ?Auth $auth;

	public function __construct(Server $server, ?Auth $auth)
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
		$auth = [];
		if ($this->auth !== null) {
			$auth = $this->auth->getPayload();
		}

		$guzzle = new Guzzle(
			$this->server->get(),
			$auth
		);

		$response = $guzzle->post('', $message->getData());

		$message = Json::decode($response->getBody());

		return (object)$message;
	}
}
