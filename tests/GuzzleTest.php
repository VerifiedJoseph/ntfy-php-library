<?php

use Ntfy\Auth;
use Ntfy\Guzzle;
use Ntfy\Json;

class GuzzleTest extends TestCase
{
    private static Guzzle $guzzle;

    public static function setUpBeforeClass(): void
    {
        self::$guzzle = new Guzzle(self::getHttpBinUri(), null);
    }

    /**
     * Test making a GET request
     */
    public function testGet(): void
    {
        $query = [
            'test' => 'HelloWorld'
        ];

        $response = self::$guzzle->get('get', $query);
        $body = Json::decode($response->getBody());

        $this->assertIsObject($body);
        $this->assertObjectHasAttribute('args', $body);
        $this->assertObjectHasAttribute('test', $body->args);
        $this->assertEquals('HelloWorld', $body->args->test);
    }

    /**
     * Test making a POST request
     */
    public function testPost(): void
    {
        $data = ['hello', 'World'];
        $headerValue = 'hello world';

        $headers = [
            'X-Httpbin-Test' => $headerValue
        ];

        $response = self::$guzzle->post('post', $data, $headers);
        $body = Json::decode($response->getBody());

        $this->assertIsObject($body);
        $this->assertObjectHasAttribute('data', $body);
        $this->assertObjectHasAttribute('headers', $body);
        $this->assertObjectHasAttribute('X-Httpbin-Test', $body->headers);

        $this->assertEquals($data, $body->json);
        $this->assertEquals($headerValue, $body->headers->{'X-Httpbin-Test'});
    }

    /**
     * Test making a GET request with Basic Auth
     */
    public function testBasicAuth(): void
    {
        $auth = new Auth('admin', 'password1245');
        $guzzle = new Guzzle(self::getHttpBinUri(), $auth);

        $response = $guzzle->get('basic-auth/' . $auth->getUsername() . '/' . $auth->getPassword());
        $body = Json::decode($response->getBody());

        $this->assertIsObject($body);
        $this->assertObjectHasAttribute('authenticated', $body);
        $this->assertObjectHasAttribute('user', $body);

        $this->assertEquals(true, $body->authenticated);
        $this->assertEquals($auth->getUsername(), $body->user);
    }
}
