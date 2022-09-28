<?php

namespace Ntfy;

use stdClass;
use Ntfy\Exception\NtfyException;

class Dispatch
{
	private Server $server;

	private array $auth;

	public function __construct(Server $server, array $auth = [])
	{
		$this->server = $server;
		$this->auth = $auth;
	}

	public function send(Message $message): stdClass
	{
		$guzzle = new Guzzle(
			$this->server->get(),
			$this->auth
		);

		$response = $guzzle->post('', $message->getData());

		$message = Json::decode($response->getBody());

		return (object)$message;
	}
}
