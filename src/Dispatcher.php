<?php

namespace Ntfy;

use stdClass;
use Ntfy\Exception\NtfyException;

class Dispatcher
{
	private Server $server;

	/**
	 * @var array<string, string>
	 */
	private array $auth;

	/**
	 * @param Server $server
	 * @param array<string, string> $auth
	 */
	public function __construct(Server $server, array $auth = [])
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

		return (object)$message;
	}
}
