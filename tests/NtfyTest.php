<?php

use Ntfy\Ntfy;

class NtfyTest extends TestCase
{
	private static Ntfy $ntfy;

	private string $testTopic = 'phpUnitTest';
	private string $testTitle = 'Test message';
	private string $testMessage = 'Hello World. This is a test message.';
	private int $testPriority = 5;

	public static function setUpBeforeClass(): void
	{
		parent::setUpBeforeClass();

		self::$ntfy = new Ntfy(self::$server);
	}

	/**
	 * Test sending a message
	 */
	public function testSend(): void
	{
		$message = self::$ntfy->send(
			topic: $this->testTopic,
			message: $this->testMessage,
			title: $this->testTitle,
			priority: $this->testPriority
		);

		$this->assertIsObject($message);
		$this->assertObjectHasAttribute('id', $message);
		$this->assertObjectHasAttribute('topic', $message);
		$this->assertObjectHasAttribute('message', $message);
		$this->assertObjectHasAttribute('priority', $message);

		$this->assertEquals($this->testTopic, $message->topic);
		$this->assertEquals($this->testMessage, $message->message);
		$this->assertEquals($this->testPriority, $message->priority);

	}

	/**
	 * Test gettings sent messages for a topic
	 *
	 * @depends testSend
	 */
	public function testGet(): void
	{
		$messages = self::$ntfy->get(
			topic: $this->testTopic
		);

		$this->assertIsObject($messages);
		$this->assertObjectHasAttribute('topic', $messages);
		$this->assertObjectHasAttribute('since', $messages);
		$this->assertObjectHasAttribute('results', $messages);
	}
}
