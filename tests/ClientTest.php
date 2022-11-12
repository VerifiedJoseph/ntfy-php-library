<?php

use Ntfy\Server;
use Ntfy\Client;
use Ntfy\Action;
use Ntfy\Auth;
use Ntfy\Message;
use Ntfy\Json;

class ClientTest extends TestCase
{
    /**
     * Test sending a message
     */
    public function testSend(): void
    {
        $messageExample = Json::decode(self::loadFixture('message.json'));
        $actionExample = Json::decode(self::loadFixture('action.json'));

        $server = new Server(self::getNtfyUri());

        $action = new Action\View();
        $action->label($actionExample->label);
        $action->url($actionExample->url);
        $action->enableNoteClear();

        $message = new Message();
        $message->topic($messageExample->topic);
        $message->title($messageExample->title);
        $message->priority($messageExample->priority);
        $message->body($messageExample->body);
        $message->tags($messageExample->tags);
        $message->action($action);

        $auth = new Auth('Joseph', 'test');

        $client = new Client($server, $auth);
        $response = $client->send($message);

        $this->assertObjectHasAttribute('topic', $response);
        $this->assertObjectHasAttribute('title', $response);
        $this->assertObjectHasAttribute('message', $response);
        $this->assertObjectHasAttribute('priority', $response);
        $this->assertObjectHasAttribute('tags', $response);

        $this->assertEquals($messageExample->topic, $response->topic);
        $this->assertEquals($messageExample->title, $response->title);
        $this->assertEquals($messageExample->priority, $response->priority);
        $this->assertEquals($messageExample->body, $response->message);
        $this->assertEquals($messageExample->tags, $response->tags);

        $this->assertCount(1, $response->actions);
        $this->assertEquals($actionExample->type, $response->actions[0]->action);
        $this->assertEquals($actionExample->label, $response->actions[0]->label);
        $this->assertEquals($actionExample->url, $response->actions[0]->url);
        $this->assertEquals($actionExample->clear, $response->actions[0]->clear);
    }
}
