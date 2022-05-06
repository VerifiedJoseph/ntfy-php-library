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

	/** @var array<string, string|bool> $action Message action */
	private array $action =  [
		"type" => "view",
		"label" => "Open Website",
		"url" => "https://example.com",
		"clear" => true
	];

	/**
	 * Test sending a message
	 */
	public function testSend(): void
	{
		$action = new Ntfy\Action\View();
		$action->label($this->action['label']);
		$action->url($this->action['url']);
		$action->enableNoteClear();

		$message = new Ntfy\Message(self::$server);
		$message->topic($this->topic);
		$message->title($this->title);
		$message->body($this->body);
		$message->tags($this->tags);
		$message->priority($this->priority);
		$message->action($action);

		$details = $message->send();

		$this->assertIsObject($details);
		$this->assertObjectHasAttribute('topic', $details);
		$this->assertObjectHasAttribute('title', $details);
		$this->assertObjectHasAttribute('message', $details);
		$this->assertObjectHasAttribute('priority', $details);
		$this->assertObjectHasAttribute('actions', $details);

		$this->assertEquals($this->topic, $details->topic);
		$this->assertEquals($this->title, $details->title);
		$this->assertEquals($this->body, $details->message);
		$this->assertEquals($this->tags, $details->tags);
		$this->assertEquals($this->priority, $details->priority);

		$this->assertCount(1, $details->actions);
		$this->assertEquals($this->action['type'], $details->actions[0]->action);
		$this->assertEquals($this->action['label'], $details->actions[0]->label);
		$this->assertEquals($this->action['url'], $details->actions[0]->url);
		$this->assertEquals($this->action['clear'], $details->actions[0]->clear);
	}
}
