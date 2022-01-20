<?php

namespace Ntfy\Message;

use Ntfy\Server;
use Ntfy\Guzzle;

/**
 * Base class for working with messages
 */
abstract class Message
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
}
