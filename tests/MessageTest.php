<?php

class MessageTest extends TestCase
{
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
