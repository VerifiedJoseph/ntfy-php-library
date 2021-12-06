<?php

namespace Ntfy;

use stdClass;

class Ntfy
{
	/**
	 * Max message priority
	 * 
	 * @see https://ntfy.sh/docs/publish/#message-priority
	 */
	public const PRIORITY_MAX = 5;

	/**
	 * High message priority
	 * 
	 * @see https://ntfy.sh/docs/publish/#message-priority
	 */
	public const PRIORITY_HIGH = 4;

	/**
	 * Default message priority
	 * 
	 * @see https://ntfy.sh/docs/publish/#message-priority
	 */
	public const PRIORITY_DEFAULT = 3;

	/**
	 * Low message priority
	 * 
	 * @see https://ntfy.sh/docs/publish/#message-priority
	 */
	public const PRIORITY_LOW = 2;

	/**
	 * Min message priority
	 * 
	 * @see https://ntfy.sh/docs/publish/#message-priority
	 */
	public const PRIORITY_MIN = 1;

	/** @var Guzzle $guzzle Guzzle class instance */
	protected Guzzle $guzzle;

	/**
	 * Create Guzzle class instance
	 *
	 * @param Server $server Server class instance
	 */
	function __construct(Server $server)
	{
		$this->guzzle = new Guzzle($server->get());
	}

	/**
	 * Send a message
	 *
	 * @param string $topic Topic
	 * @param string $message Message body
	 * @param string $title	Message title
	 * @param int $priority Message priority
	 * @param string $tags Message tags
	 *
	 * @return stdClass
	 *
	 * @see https://ntfy.sh/docs/publish/ Sending messages
	 * @see https://ntfy.sh/docs/publish/#message-priority Message priority levels
	 * @see https://ntfy.sh/docs/publish/#tags-emojis Message tags & emojis
	 */
	public function send(string $topic, string $message, $title = '', int $priority = 0, string $tags = ''): stdClass
	{
		$headers = array();
		$headers['Priority'] = $priority;

		if (empty($title) === false) {
			$headers['Title'] = $title;
		}

		if (empty($tags) === false) {
			$headers['Tags'] = $tags;
		}

		$response = $this->guzzle->post($topic, $message, $headers);
		$message = Json::decode($response->getBody());

		return (object) $message;
	}

	/**
	 * Get sent messages for a topic
	 *
	 * To get sent messages for multiple topics, use a comma-separated list. e.g: `mytopic1,mytopic2`
	 *
	 * @param string $topic Topic
	 * @param string $since Messages since a time
	 *
	 * @return stdClass
	 *
	 * @see https://ntfy.sh/docs/subscribe/api/#subscribing-to-multiple-topics Subscribing to multiple topics
	 * @see https://ntfy.sh/docs/subscribe/api/#fetching-cached-messages Fetching cached messages
	 */
	public function get(string $topic, mixed $since = 'all'): stdClass
	{
		$messages = array();

		$query = array(
			'poll' => 1,
			'since' => $since
		);

		$response = $this->guzzle->get($topic . '/json', $query);
		$contents = trim($response->getBody()->getContents());

		if (empty($contents) === false) {
			$lines = explode(PHP_EOL, $contents);

			foreach($lines as $line) {
				$messages[] = Json::decode($line);
			}
		}

		return (object) [
			'topic' => $topic,
			'since' => $since,
			'results' => $messages
		];
	}
}
