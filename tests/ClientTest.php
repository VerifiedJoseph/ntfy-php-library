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
    protected static stdClass $messages;
    protected static stdClass $actionParams;

    public static function setUpBeforeClass(): void
    {
        self::$authParams = Json::decode(self::loadFixture('auth.json'));
        self::$messages = Json::decode(self::loadFixture('message.json'));
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
        $message->topic(self::$messages->plaintext->topic);
        $message->title(self::$messages->plaintext->title);
        $message->priority(self::$messages->plaintext->priority);
        $message->body(self::$messages->plaintext->body);
        $message->tags(self::$messages->plaintext->tags);
        $message->action($action);

        $client = new Client($server);
        $response = $client->send($message);

        $this->assertObjectHasProperty('topic', $response);
        $this->assertObjectHasProperty('title', $response);
        $this->assertObjectHasProperty('message', $response);
        $this->assertObjectHasProperty('priority', $response);
        $this->assertObjectHasProperty('tags', $response);

        $this->assertEquals(self::$messages->plaintext->topic, $response->topic);
        $this->assertEquals(self::$messages->plaintext->title, $response->title);
        $this->assertEquals(self::$messages->plaintext->priority, $response->priority);
        $this->assertEquals(self::$messages->plaintext->body, $response->message);
        $this->assertEquals(self::$messages->plaintext->tags, $response->tags);

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
        $message->title(self::$messages->plaintext->title);
        $message->body(self::$messages->plaintext->body);

        $auth = new Auth\User(
            self::$authParams->username,
            self::$authParams->password
        );

        $client = new Client($server, $auth);
        $response = $client->send($message);

        $this->assertObjectHasProperty('topic', $response);
        $this->assertObjectHasProperty('title', $response);
        $this->assertObjectHasProperty('message', $response);

        $this->assertEquals($topic, $response->topic);
        $this->assertEquals(self::$messages->plaintext->title, $response->title);
        $this->assertEquals(self::$messages->plaintext->body, $response->message);
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
        $message->title(self::$messages->plaintext->title);
        $message->body(self::$messages->plaintext->body);

        $auth = new Auth\Token(
            self::$authParams->token
        );

        $client = new Client($server, $auth);
        $response = $client->send($message);

        $this->assertObjectHasProperty('topic', $response);
        $this->assertObjectHasProperty('title', $response);
        $this->assertObjectHasProperty('message', $response);

        $this->assertEquals($topic, $response->topic);
        $this->assertEquals(self::$messages->plaintext->title, $response->title);
        $this->assertEquals(self::$messages->plaintext->body, $response->message);
    }
}
