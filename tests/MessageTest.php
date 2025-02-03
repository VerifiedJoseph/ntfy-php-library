<?php

declare(strict_types=1);

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use Ntfy\Message;
use Ntfy\Action;
use Ntfy\Json;
use Ntfy\Exception\NtfyException;

#[CoversClass(Message::class)]
#[UsesClass(Json::class)]
#[UsesClass(Action\View::class)]
#[UsesClass(Action\AbstractAction::class)]
#[UsesClass(NtfyException::class)]
class MessageTest extends TestCase
{
    protected static stdClass $messageParams;
    protected static stdClass $actionParams;

    public static function setUpBeforeClass(): void
    {
        self::$messageParams = Json::decode(self::loadAsset('message.json'));
        self::$actionParams = Json::decode(self::loadAsset('action.json'));
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
        $message->topic(self::$messageParams->topic);
        $message->title(self::$messageParams->title);
        $message->priority(self::$messageParams->priority);
        $message->body(self::$messageParams->body);
        $message->tags(self::$messageParams->tags);
        $message->schedule(self::$messageParams->schedule);
        $message->clickAction(self::$messageParams->clickAction);
        $message->email(self::$messageParams->email);
        $message->icon(self::$messageParams->icon);
        $message->attachURL(
            self::$messageParams->attachmentUrl,
            self::$messageParams->attachmentName
        );
        $message->action($action);
        $message->disableCaching();
        $message->disableFirebase();

        $data = $message->getData();

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

        $this->assertEquals(self::$messageParams->topic, $data['topic']);
        $this->assertEquals(self::$messageParams->title, $data['title']);
        $this->assertEquals(self::$messageParams->priority, $data['priority']);
        $this->assertEquals(self::$messageParams->body, $data['message']);

        $this->assertIsArray($data['tags']);
        $this->assertEquals(self::$messageParams->tags, $data['tags']);

        $this->assertEquals(self::$messageParams->schedule, $data['delay']);
        $this->assertEquals(self::$messageParams->clickAction, $data['click']);
        $this->assertEquals(self::$messageParams->email, $data['email']);
        $this->assertEquals(self::$messageParams->icon, $data['icon']);
        $this->assertEquals(self::$messageParams->attachmentUrl, $data['attach']);
        $this->assertEquals(self::$messageParams->attachmentName, $data['filename']);
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
        $message->topic(self::$messageParams->topic);
        $message->markdownBody(self::$messageParams->bodyMarkdown);
        $data = $message->getData();

        $this->assertArrayHasKey('topic', $data);
        $this->assertArrayHasKey('message', $data);
        $this->assertArrayHasKey('markdown', $data);

        $this->assertEquals(self::$messageParams->topic, $data['topic']);
        $this->assertEquals(self::$messageParams->bodyMarkdown, $data['message']);
        $this->assertTrue($data['markdown']);
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
