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
        $this->assertTrue(property_exists($body, 'args'));
        $this->assertTrue(property_exists($body->args, 'test'));
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
        $this->assertTrue(property_exists($body, 'data'));
        $this->assertTrue(property_exists($body, 'headers'));
        $this->assertTrue(property_exists($body->headers, 'X-Httpbin-Test'));

        $this->assertEquals($data, $body->json);
        $this->assertEquals($headerValue, $body->headers->{'X-Httpbin-Test'});
    }

    /**
     * Test making a GET request with basic authentication
     */
    public function testBasicAuth(): void
    {
        $auth = new Auth\User('admin', 'password1245');

        $guzzle = new Guzzle(self::getHttpBinUri(), $auth);
        $response = $guzzle->get('basic-auth/' . $auth->getUsername() . '/' . $auth->getPassword());
        $body = Json::decode($response->getBody());

        $this->assertIsObject($body);
        $this->assertTrue(property_exists($body, 'authenticated'));
        $this->assertTrue(property_exists($body, 'user'));

        $this->assertEquals(true, $body->authenticated);
        $this->assertEquals($auth->getUsername(), $body->user);
    }

    /**
     * Test making a GET request with Bearer token authentication
     */
    public function testBearerToken(): void
    {
        $auth = new Auth\Token('randomString');

        $guzzle = new Guzzle(self::getHttpBinUri(), $auth);
        $response = $guzzle->get('/bearer');
        $body = Json::decode($response->getBody());

        $this->assertIsObject($body);
        $this->assertTrue(property_exists($body, 'authenticated'));
        $this->assertTrue(property_exists($body, 'token'));

        $this->assertEquals(true, $body->authenticated);
        $this->assertEquals($auth->getToken(), $body->token);
    }
}
