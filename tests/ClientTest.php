<?php

use Ntfy\Server;
use Ntfy\Client;
use Ntfy\Action;
use Ntfy\Auth;
use Ntfy\Message;
use Ntfy\Json;

class ClientTest extends TestCase
{
    protected static stdClass $authParams;
    protected static stdClass $messageParams;
    protected static stdClass $actionParams;

    public static function setUpBeforeClass(): void
    {
        self::$authParams = Json::decode(self::loadFixture('auth.json'));
        self::$messageParams = Json::decode(self::loadFixture('message.json'));
        self::$actionParams = Json::decode(self::loadFixture('action.json'));
    }

    /**
     * Test sending a message
     */
    public function testSend(): void
    {
        $server = new Server(self::getNtfyUri());

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
        $message->action($action);

        $client = new Client($server);
        $response = $client->send($message);

        $this->assertTrue(property_exists($response, 'topic'));
        $this->assertTrue(property_exists($response, 'title'));
        $this->assertTrue(property_exists($response, 'message'));
        $this->assertTrue(property_exists($response, 'priority'));
        $this->assertTrue(property_exists($response, 'tags'));

        $this->assertEquals(self::$messageParams->topic, $response->topic);
        $this->assertEquals(self::$messageParams->title, $response->title);
        $this->assertEquals(self::$messageParams->priority, $response->priority);
        $this->assertEquals(self::$messageParams->body, $response->message);
        $this->assertEquals(self::$messageParams->tags, $response->tags);

        $this->assertCount(1, $response->actions);
        $this->assertEquals(self::$actionParams->type, $response->actions[0]->action);
        $this->assertEquals(self::$actionParams->label, $response->actions[0]->label);
        $this->assertEquals(self::$actionParams->url, $response->actions[0]->url);
        $this->assertEquals(self::$actionParams->clear, $response->actions[0]->clear);
    }

    /**
     * Test sending a message with username password auth
     */
    public function testSendWithUserAuth(): void
    {
        $topic = 'privatebobtopic';

        $server = new Server(self::getNtfyUri());

        $message = new Message();
        $message->topic($topic);
        $message->title(self::$messageParams->title);
        $message->body(self::$messageParams->body);

        $auth = new Auth\User(
            self::$authParams->username,
            self::$authParams->password
        );

        $client = new Client($server, $auth);
        $response = $client->send($message);

        $this->assertTrue(property_exists($response, 'topic'));
        $this->assertTrue(property_exists($response, 'title'));
        $this->assertTrue(property_exists($response, 'message'));

        $this->assertEquals($topic, $response->topic);
        $this->assertEquals(self::$messageParams->title, $response->title);
        $this->assertEquals(self::$messageParams->body, $response->message);
    }

    /**
     * Test sending a message with access token auth
     */
    public function testSendWithTokenAuth(): void
    {
        $topic = 'privatebobtopic';

        $server = new Server(self::getNtfyUri());

        $message = new Message();
        $message->topic($topic);
        $message->title(self::$messageParams->title);
        $message->body(self::$messageParams->body);

        $auth = new Auth\User(
            self::$authParams->username,
            self::$authParams->password
        );

        $client = new Client($server, $auth);
        $response = $client->send($message);

        $this->assertTrue(property_exists($response, 'topic'));
        $this->assertTrue(property_exists($response, 'title'));
        $this->assertTrue(property_exists($response, 'message'));

        $this->assertEquals($topic, $response->topic);
        $this->assertEquals(self::$messageParams->title, $response->title);
        $this->assertEquals(self::$messageParams->body, $response->message);
    }
}
