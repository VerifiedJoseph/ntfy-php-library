<?php

use Ntfy\Message;
use Ntfy\Action;
use Ntfy\Json;
use Ntfy\Exception\NtfyException;

class MessageTest extends TestCase
{
    protected static stdClass $messages;
    protected static stdClass $actionParams;

    public static function setUpBeforeClass(): void
    {
        self::$messages = Json::decode(self::loadFixture('message.json'));
        self::$actionParams = Json::decode(self::loadFixture('action.json'));
    }

    /**
     * Test setting and getting a message
     */
    public function testGetData(): void
    {
        $action = new Action\View();
        $action->label(self::$actionParams->label);
        $action->url(self::$actionParams->url);
        $action->enableNoteClear();

        $message = new Message();
        $message->topic(self::$messages->plaintext->topic);
        $message->title(self::$messages->plaintext->title);
        $message->priority(self::$messages->plaintext->priority);
        $message->body(self::$messages->plaintext->body);
        $message->tags(self::$messages->plaintext->tags);
        $message->schedule(self::$messages->plaintext->schedule);
        $message->clickAction(self::$messages->plaintext->clickAction);
        $message->email(self::$messages->plaintext->email);
        $message->icon(self::$messages->plaintext->icon);
        $message->attachURL(
            self::$messages->plaintext->attachmentUrl,
            self::$messages->plaintext->attachmentName
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

        $this->assertEquals(self::$messages->plaintext->topic, $data['topic']);
        $this->assertEquals(self::$messages->plaintext->title, $data['title']);
        $this->assertEquals(self::$messages->plaintext->priority, $data['priority']);
        $this->assertEquals(self::$messages->plaintext->body, $data['message']);

        $this->assertIsArray($data['tags']);
        $this->assertEquals(self::$messages->plaintext->tags, $data['tags']);

        $this->assertEquals(self::$messages->plaintext->schedule, $data['delay']);
        $this->assertEquals(self::$messages->plaintext->clickAction, $data['click']);
        $this->assertEquals(self::$messages->plaintext->email, $data['email']);
        $this->assertEquals(self::$messages->plaintext->icon, $data['icon']);
        $this->assertEquals(self::$messages->plaintext->attachmentUrl, $data['attach']);
        $this->assertEquals(self::$messages->plaintext->attachmentName, $data['filename']);
        $this->assertEquals('no', $data['cache']);
        $this->assertEquals('no', $data['firebase']);

        $this->assertIsArray($data['actions']);
        $this->assertCount(1, $data['actions']);
        $this->assertEquals(self::$actionParams->type, $data['actions'][0]['action']);
        $this->assertEquals(self::$actionParams->label, $data['actions'][0]['label']);
        $this->assertEquals(self::$actionParams->url, $data['actions'][0]['url']);
        $this->assertEquals(self::$actionParams->clear, $data['actions'][0]['clear']);
    }

    /**
     * Test setting and getting a message with a markdown body message
     */
    public function testGetDataWithMarkdownMessage(): void
    {
        $message = new Message();
        $message->topic(self::$messages->markdown->topic);
        $message->markdownBody(self::$messages->markdown->body);
        $data = $message->getData();

        $this->assertIsArray($data);
        $this->assertArrayHasKey('topic', $data);
        $this->assertArrayHasKey('message', $data);
        $this->assertArrayHasKey('markdown', $data);

        $this->assertEquals(self::$messages->markdown->topic, $data['topic']);
        $this->assertEquals(self::$messages->markdown->body, $data['message']);
        $this->assertTrue(self::$messages->markdown->markdown);
    }

    /**
     * Test creating a message without a topic.
     *
     * An exception should be thrown by `Ntfy\Message->getData()`
     */
    public function testNoTopicException(): void
    {
        $this->expectException(NtfyException::class);

        $message = new Message();
        $message->getData();
    }
}
