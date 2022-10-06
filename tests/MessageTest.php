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
        $action = new Ntfy\Action\View();
        $action->label($this->actionLabel);
        $action->url($this->actionUrl);
        $action->enableNoteClear();

        $message = new Ntfy\Message(self::$server);
        $message->topic($this->topic);
        $message->title($this->title);
        $message->body($this->body);
        $message->tags($this->tags);
        $message->icon($this->icon);
        $message->priority($this->priority);
        $message->action($action);
        $message->attachURL(
            $this->attachmentUrl,
            $this->attachmentName
        );

        $details = $message->send();

        $this->assertIsObject($details);
        $this->assertObjectHasAttribute('topic', $details);
        $this->assertObjectHasAttribute('title', $details);
        $this->assertObjectHasAttribute('message', $details);
        $this->assertObjectHasAttribute('icon', $details);
        $this->assertObjectHasAttribute('priority', $details);
        $this->assertObjectHasAttribute('actions', $details);

        $this->assertEquals($this->topic, $details->topic);
        $this->assertEquals($this->title, $details->title);
        $this->assertEquals($this->body, $details->message);
        $this->assertEquals($this->tags, $details->tags);
        $this->assertEquals($this->icon, $details->icon);
        $this->assertEquals($this->priority, $details->priority);

        $this->assertCount(1, $details->actions);
        $this->assertEquals($this->actionType, $details->actions[0]->action);
        $this->assertEquals($this->actionLabel, $details->actions[0]->label);
        $this->assertEquals($this->actionUrl, $details->actions[0]->url);
        $this->assertEquals($this->actionNoteClear, $details->actions[0]->clear);
    }

    /**
     * Test sending a message without a topic.
     *
     * An exception should be thrown by `Ntfy\Message->send()`
     */
    public function testNoTopicException(): void
    {
        $this->expectException(Ntfy\Exception\NtfyException::class);

        $message = new Ntfy\Message(self::$server);
        $message->send();
    }
}
