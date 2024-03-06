<?php

use Ntfy\Auth;
use Ntfy\Guzzle;
use Ntfy\Json;
use Ntfy\Exception\NtfyException;
use Ntfy\Exception\EndpointException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use Psr\Http\Message\ResponseInterface;

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
        $this->assertObjectHasProperty('args', $body);
        $this->assertObjectHasProperty('test', $body->args);
        $this->assertEquals('HelloWorld', $body->args->test[0]);
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
        $this->assertObjectHasProperty('data', $body);
        $this->assertObjectHasProperty('headers', $body);
        $this->assertObjectHasProperty('X-Httpbin-Test', $body->headers);

        $this->assertEquals($data, $body->json);
        $this->assertEquals($headerValue, $body->headers->{'X-Httpbin-Test'}[0]);
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
        $this->assertObjectHasProperty('authorized', $body);
        $this->assertObjectHasProperty('user', $body);

        $this->assertEquals(true, $body->authorized);
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
        $this->assertObjectHasProperty('authenticated', $body);
        $this->assertObjectHasProperty('token', $body);

        $this->assertEquals(true, $body->authenticated);
        $this->assertEquals($auth->getToken(), $body->token);
    }

    /**
     * Test making a request that throws a RequestException
     */
    public function testRequestException(): void
    {
        $this->expectException(EndpointException::class);

        $guzzle = new Guzzle(self::getHttpBinUri(), null);
        $guzzle->get('/status/404');
    }

    /**
     * Test making a request that throws a ConnectException
     */
    public function testConnectException(): void
    {
        $this->expectException(NtfyException::class);

        $guzzle = new Guzzle('http://something.invalid', null);
        $guzzle->get('/');
    }

    /**
     * Test making a request that throws a RequestException with a JSON response
     */
    public function testRequestExceptionJsonResponse(): void
    {
        $this->expectException(EndpointException::class);

        $body = (string) json_encode(['error' => 'forbidden', 'code' => 40301, 'http' => 403]);

        $mock = new MockHandler([
            new GuzzleHttp\Psr7\Response(403, ['Content-Type' => 'application/json'], $body),
        ]);

        $handlerStack = HandlerStack::create($mock);
        $guzzle = new Guzzle('http://example.com', null, $handlerStack);
        $guzzle->get('/');
    }

    /**
     * Test making a request with an unsupported request method
     */
    public function testUnsupportedRequestMethod(): void
    {
        $this->expectException(NtfyException::class);
        $this->expectExceptionMessage('Request method must be GET or POST');

        $guzzle = new class (self::getHttpBinUri(), null) extends Guzzle {
            public function put(string $endpoint): ResponseInterface
            {
                return $this->request('PUT', $endpoint);
            }
        };

        $guzzle->put('/put');
    }
}
