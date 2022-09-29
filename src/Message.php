<?php

namespace Ntfy;

use Ntfy\Exception\NtfyException;

use stdClass;

/**
 * Class for sending a message
 */
class Message
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

	/** @var Server $server Server */
	private Server $server;

	/** @var string $topic Message topic */
	private string $topic = '';

	/** @var string $title Message title */
	private string $title = '';

	/** @var string|int $priority Message priority */
	private string|int $priority = 3;

	/** @var string $body Message body */
	private string $body = '';

	/** @var array<int,string|int> $tags Message tags */
	private array $tags = [];

	/** @var string $delay Timestamp or duration of the delay */
	private string $delay = '';

	/** @var string $click Click action URL */
	private string $click = '';

	/** @var string $email Email address for e-mail notifications */
	private string $email = '';

	/** @var string $attachFilename Name of file attachment */
	private string $attachFilename = '';

	/** @var string $attachUrl Remote URL of file attachment */
	private string $attachUrl = '';

	/** @var ?Auth $auth Basic access authentication username and password */
	private ?Auth $auth = null;

	/** @var array<int, array<string, mixed>> $actions Action button configs */
	private array $actions = [];

	/** @var bool $cache Cache status for message */
	private bool $cache = true;

	/** @var bool $firebase Firebase status for message */
	private bool $firebase = true;

	/**
	 * Create Guzzle class instance
	 *
	 * @param Server $server Server class instance
	 */
	public function __construct(Server $server)
	{
		$this->server = $server;
	}

	/**
	 * Set message topic
	 *
	 * @param string $topic Message topic
	 *
	 * @see https://ntfy.sh/docs/publish/#publishing
	 */
	public function topic(string $topic): void
	{
		$this->topic = $topic;
	}

	/**
	 * Set message title (optional)
	 *
	 * @param string $title Message title
	 */
	public function title(string $title): void
	{
		$this->title = $title;
	}

	/**
	 * Set message priority
	 *
	 * Priorities:
	 * - `5` - Max
	 * - `4` - High
	 * - `3` - Default
	 * - `2` - Low
	 * - `1` - Min
	 *
	 * @param int $priority Message priority
	 *
	 * @see https://ntfy.sh/docs/publish/#message-priority
	 */
	public function priority(int $priority): void
	{
		$this->priority = $priority;
	}

	/**
	 * Set message body
	 *
	 * @param string $body Message body
	 */
	public function body(string $body): void
	{
		$this->body = $body;
	}

	/**
	 * Set message tags
	 *
	 * @param array<int, string|int> $tags Array of message tags
	 *
	 * @see https://ntfy.sh/docs/publish/#tags-emojis
	 */
	public function tags(array $tags): void
	{
		$this->tags = $tags;
	}

	/**
	 * Set scheduled delivery for the message
	 *
	 * @param string $delay Duration of the delay (e.g 1min, 1hour, 1day)
	 *
	 * @see https://ntfy.sh/docs/publish/#scheduled-delivery
	 */
	public function schedule(string $delay): void
	{
		$this->delay = $delay;
	}

	/**
	 * Set URL to open when message notification is clicked
	 *
	 * @param string $url URL
	 *
	 * @see https://ntfy.sh/docs/publish/#click-action
	 */
	public function clickAction(string $url): void
	{
		$this->click = $url;
	}

	/**
	 * Set email address for sending a email notification
	 *
	 * @param string $email Email address
	 *
	 * @see https://ntfy.sh/docs/publish/#e-mail-notifications
	 */
	public function email(string $email): void
	{
		$this->email = $email;
	}

	/**
	 * Set a file attachment using a URL
	 *
	 * @param string $url File URL
	 * @param string $name Filename (optional, ntfy will fetch filename its self if not given)
	 *
	 * @see https://ntfy.sh/docs/publish/#attachments
	 * @see https://ntfy.sh/docs/publish/#attach-local-file
	 */
	public function attachURL(string $url, string $name = ''): void
	{
		$this->attachUrl = $url;
		$this->attachFilename = $name;
	}

	/**
	 * Set username and password for basic access authentication
	 *
	 * @param string $username Username
	 * @param string $password Password
	 *
	 * @see https://ntfy.sh/docs/publish/#authentication
	 * @see https://ntfy.sh/docs/config/#access-control
	 */
	public function auth(string $username, string $password): void
	{
		$this->auth = new Auth($username, $password);
	}

	/**
	 * Set an action button
	 *
	 * @param Action $action Action class instance
	 *
	 * @see https://ntfy.sh/docs/publish/#action-buttons
	 */
	public function action(Action $action): void
	{
		$this->actions[] = $action->get();
	}

	/**
	 * Disable caching for this message
	 *
	 * @see https://ntfy.sh/docs/publish/#message-caching
	 */
	public function disableCaching(): void
	{
		$this->cache = false;
	}

	/**
	 * Disable firebase for this message
	 *
	 * @see https://ntfy.sh/docs/publish/#disable-firebase
	 */
	public function disableFirebase(): void
	{
		$this->firebase = false;
	}

	/**
	 * Get the data to be sent as JSON to the server.
	 *
	 * @return array<string, mixed>
	 * @throws NtfyException
	 */
	public function getData(): array
	{
		if ($this->topic === '') {
			throw new NtfyException('Message topic must be given');
		}

		$data = [];
		$data['topic'] = $this->topic;

		if ($this->title !== '') {
			$data['title'] = $this->title;
		}

		if ($this->body !== '') {
			$data['message'] = $this->body;
		}

		if ($this->tags !== []) {
			$data['tags'] = $this->tags;
		}

		if ($this->priority !== '') {
			$data['priority'] = $this->priority;
		}

		if ($this->actions !== []) {
			$data['actions'] = $this->actions;
		}

		if ($this->click !== '') {
			$data['click'] = $this->click;
		}

		if ($this->attachUrl !== '') {
			$data['attach'] = $this->attachUrl;
		}

		if ($this->attachFilename !== '') {
			$data['filename'] = $this->attachFilename;
		}

		if ($this->delay !== '') {
			$data['delay'] = $this->delay;
		}

		if ($this->email !== '') {
			$data['email'] = $this->email;
		}

		if ($this->cache === false) {
			$data['cache'] = 'no';
		}

		if ($this->firebase === false) {
			$data['firebase'] = 'no';
		}

		return $data;
	}

	/**
	 * Send the message
	 *
	 * @throws NtfyException if a message topic is not given
	 *
	 * @return stdClass
	 */
	public function send(): stdClass
	{
		return (new Dispatcher($this->server, $this->auth))->send($this);
	}
}
