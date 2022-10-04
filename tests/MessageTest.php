<?php

class MessageTest extends TestCase
{
	/** @var string $topic Message topic */
	private string $topic = 'mytopic';

	/** @var string $title Message title */
	private string $title = 'Hello World';

	/** @var string $body Message body */
	private string $body = 'Hello World from PHPUnit';

	/** @var int $priority Message priority */
	private int $priority = 4;

	/** @var array<int, string> $tags Message tags */
	private array $tags = ['hello', 'world'];

	/** @var string $priority Message icon */
	private string $icon = 'https://ntfy.sh/static/img/ntfy.png';

	/** @var string $attachmentUrl File attachment URL */
	private string $attachmentUrl = 'https://example.com/index.html';

	/** @var string $attachmentName File attachment name */
	private string $attachmentName = 'index.html';

	/** @var string $actionType Action type */
	private string $actionType = 'view';

	/** @var string $actionLabel Action label */
	private string $actionLabel = 'Open Website';

	/** @var string $actionUrl Action URL */
	private string $actionUrl = 'https://example.com';

	/** @var bool $actionNoteClear Action clear status */
	private bool $actionNoteClear = true;

	/**
	 * Test sending a message
	 */
	public function testSend(): void
	{
		$messageExample = self::getMessageExample();

		$message = new Ntfy\Message(self::$server);
		$message->topic($messageExample->topic);
		$message->title($messageExample->title);
		$message->priority($messageExample->priority);
		$message->body($messageExample->body);

		$response = $message->send();

		$this->assertObjectHasAttribute('topic', $response);
		$this->assertObjectHasAttribute('title', $response);
		$this->assertObjectHasAttribute('message', $response);
		$this->assertObjectHasAttribute('priority', $response);

		$this->assertEquals($messageExample->topic, $response->topic);
		$this->assertEquals($messageExample->title, $response->title);
		$this->assertEquals($messageExample->priority, $response->priority);
		$this->assertEquals($messageExample->body, $response->message);
	}

	/**
	 * Test creating a message without a topic.
	 *
	 * An exception should be thrown by `Ntfy\Message->getData()`
	 */
	public function testNoTopicException(): void
	{
		$this->expectException(Ntfy\Exception\NtfyException::class);

		$message = new Ntfy\Message(self::$server);
		$message->getData();
	}
}
