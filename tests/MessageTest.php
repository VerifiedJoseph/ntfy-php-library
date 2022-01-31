<?php

class MessageTest extends TestCase
{
	private string $topic = 'mytopic';
	private string $title = 'Hello World';
	private string $body = 'Hello World from PHPUnit';
	private array $tags = ['hello', 'world'];
	private int $priority = 4;

	/**
	 * Test sending a message
	 */
	public function testSend(): void
	{
		$message = new Ntfy\Message(self::$server);
		$message->topic($this->topic);
		$message->title($this->title);
		$message->body($this->body);
		$message->tags($this->tags);
		$message->priority($this->priority);

		$details = $message->send();

		$this->assertIsObject($details);
		$this->assertObjectHasAttribute('topic', $details);
		$this->assertObjectHasAttribute('title', $details);
		$this->assertObjectHasAttribute('message', $details);
		$this->assertObjectHasAttribute('priority', $details);

		$this->assertEquals($this->topic, $details->topic);
		$this->assertEquals($this->title, $details->title);
		$this->assertEquals($this->body, $details->message);
		$this->assertEquals($this->tags, $details->tags);
		$this->assertEquals($this->priority, $details->priority);
	}

	/**
	 * Test sending a message with a file attachment
	 */
	public function testSendWithFile(): void
	{
		$message = new Ntfy\Message(self::$server);
		$message->topic($this->topic);
		$message->title($this->title);
		$message->attach(
			$this->getImagePath(),
			$this->getImageName()
		);

		$details = $message->send();

		$this->assertIsObject($details);
		$this->assertObjectHasAttribute('topic', $details);
		$this->assertObjectHasAttribute('title', $details);
		$this->assertObjectHasAttribute('attachment', $details);

		$this->assertEquals($this->topic, $details->topic);
		$this->assertEquals($this->title, $details->title);
		$this->assertEquals($this->getImageName(), $details->attachment->name);

	}
}
