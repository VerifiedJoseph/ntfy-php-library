<?php

use Ntfy\Message;
use Ntfy\Action;
use Ntfy\Json;

class MessageTest extends TestCase
{
	protected static stdClass $messageExample;
	protected static stdClass $actionExample;

	public static function setUpBeforeClass(): void
	{
		self::$messageExample = Json::decode(self::loadFixture('message.json'));
		self::$actionExample = Json::decode(self::loadFixture('action.json'));
	}

	/**
	 * test setting and getting a message
	 */
	public function testGetData(): void
	{
		$action = new Action\View();
		$action->label(self::$actionExample->label);
		$action->url(self::$actionExample->url);
		$action->enableNoteClear();

		$message = new Message();
		$message->topic(self::$messageExample->topic);
		$message->title(self::$messageExample->title);
		$message->priority(self::$messageExample->priority);
		$message->body(self::$messageExample->body);
		$message->tags(self::$messageExample->tags);
		$message->schedule(self::$messageExample->schedule);
		$message->clickAction(self::$messageExample->clickAction);
		$message->email(self::$messageExample->email);
		$message->icon(self::$messageExample->icon);
		$message->attachURL(
			self::$messageExample->attachmentUrl,
			self::$messageExample->attachmentName
		);
		$message->action($action);
		$message->disableCaching();
		$message->disableFirebase();

		$data = $message->getData();

		$this->assertIsArray($data);
		$this->assertArrayHasKey('topic', $data);
		$this->assertArrayHasKey('title', $data);
		$this->assertArrayHasKey('priority', $data);
		$this->assertArrayHasKey('message', $data);
		$this->assertArrayHasKey('tags', $data);
		$this->assertArrayHasKey('delay', $data);
		$this->assertArrayHasKey('click', $data);
		$this->assertArrayHasKey('email', $data);
		$this->assertArrayHasKey('icon', $data);
		$this->assertArrayHasKey('attach', $data);
		$this->assertArrayHasKey('filename', $data);
		$this->assertArrayHasKey('actions', $data);
		$this->assertArrayHasKey('cache', $data);
		$this->assertArrayHasKey('firebase', $data);

		$this->assertEquals(self::$messageExample->topic, $data['topic']);
		$this->assertEquals(self::$messageExample->title, $data['title']);
		$this->assertEquals(self::$messageExample->priority, $data['priority']);
		$this->assertEquals(self::$messageExample->body, $data['message']);

		$this->assertIsArray($data['tags']);
		$this->assertEquals(self::$messageExample->tags, $data['tags']);

		$this->assertEquals(self::$messageExample->schedule, $data['delay']);
		$this->assertEquals(self::$messageExample->clickAction, $data['click']);
		$this->assertEquals(self::$messageExample->email, $data['email']);
		$this->assertEquals(self::$messageExample->icon, $data['icon']);
		$this->assertEquals(self::$messageExample->attachmentUrl, $data['attach']);
		$this->assertEquals(self::$messageExample->attachmentName, $data['filename']);
		$this->assertEquals('no', $data['cache']);
		$this->assertEquals('no', $data['firebase']);

		$this->assertIsArray($data['actions']);
		$this->assertCount(1, $data['actions']);
		$this->assertEquals(self::$actionExample->type, $data['actions'][0]['action']);
		$this->assertEquals(self::$actionExample->label, $data['actions'][0]['label']);
		$this->assertEquals(self::$actionExample->url, $data['actions'][0]['url']);
		$this->assertEquals(self::$actionExample->clear, $data['actions'][0]['clear']);
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
