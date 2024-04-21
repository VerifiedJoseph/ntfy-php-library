<?php

namespace Ntfy;

use Ntfy\Auth\User;
use Ntfy\Auth\Token;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use GuzzleHttp\HandlerStack;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;
use Ntfy\Exception\NtfyException;
use Ntfy\Exception\EndpointException;

/**
 * Class for making HTTP requests using GuzzleHttp.
 */
class Guzzle
{
    private Client $client;

    /** @var array<int, string> $requestMethods Array of supported HTTP request methods */
    private array $requestMethods = ['GET', 'POST'];

    /** @var int $timeout Request timeout in seconds */
    private int $timeout = 10;

    /**
     *
     * @param string $uri Server URI
     * @param User|Token $auth Authentication class instance
     * @param ?HandlerStack $handlerStack Guzzle handler stack
     */
    public function __construct(string $uri, User|Token $auth = null, ?HandlerStack $handlerStack = null)
    {
        $config = $this->getConfig($uri, $auth, $handlerStack);
        $this->client = new Client($config);
    }

    /**
     * Make a GET request
     *
     * @param string $endpoint API endpoint
     * @param array<string, mixed> $query HTTP Query data
     * @return ResponseInterface
     */
    public function get(string $endpoint, array $query = []): ResponseInterface
    {
        $options = [
            RequestOptions::QUERY => $query
        ];

        return $this->request('GET', $endpoint, $options);
    }

    /**
     * Make a POST request
     *
     * @param string $endpoint API endpoint
     * @param array<mixed, mixed> $data
     * @param array<string, mixed> $headers
     * @return ResponseInterface
     */
    public function post(string $endpoint, array $data = [], array $headers = []): ResponseInterface
    {
        $options = [
            RequestOptions::HEADERS => $headers,
            RequestOptions::JSON => $data
        ];

        return $this->request('POST', $endpoint, $options);
    }

    /**
     * Make an HTTP request
     *
     * @param string $method HTTP request method
     * @param string $endpoint API endpoint
     * @param array<string, mixed> $options HTTP request options
     * @return ResponseInterface
     *
     * @throws NtfyException if HTTP request method is not supported
     * @throws NtfyException if a connection cannot be established
     * @throws EndpointException if the server returned an error
     */
    protected function request(string $method, string $endpoint, array $options = []): ResponseInterface
    {
        try {
            if (in_array($method, $this->requestMethods) === false) {
                throw new NtfyException('Request method must be GET or POST');
            }

            $response = $this->client->request($method, $endpoint, $options);
        } catch (ConnectException $err) {
            throw new NtfyException($err->getMessage());
        } catch (RequestException $err) {
            $response = $err->getResponse();
            $contentType = $response->getHeaderLine('Content-Type');

            if ($contentType === 'application/json') {
                $json = Json::decode($response->getBody());
                $message = sprintf(
                    '%s (error code: %s, http status: %s)',
                    $json->error,
                    $json->code,
                    $json->http
                );

                throw new EndpointException($message, $json->http);
            }

            throw new EndpointException(
                $err->getMessage(),
                $response->getStatusCode()
            );
        }

        return $response;
    }

    /**
     * Get GuzzleHttp client config
     *
     * @param string $uri Server URI
     * @param User|Token $auth Authentication class instance
    *  @param ?HandlerStack $handlerStack Guzzle handler stack
     * @return array<string, mixed> Returns client config array
     */
    private function getConfig(string $uri, User|Token $auth = null, ?HandlerStack $handlerStack = null): array
    {
        $config = [
            'base_uri' => $uri,
            'Accept' => 'application/json',
            'timeout' => $this->timeout,
            'allow_redirects' => false,
        ];

        if ($handlerStack !== null) {
            $config['handler'] = $handlerStack;
        }

        $config = array_merge(
            $config,
            $this->getAuthConfig($auth)
        );

        return $config;
    }

    /**
     * Get authentication config
     *
     * @param User|Token $auth Authentication class instance
     * @return array<string, array<int|string, string>>
     */
    private function getAuthConfig(User|Token|null $auth): array
    {
        $config = [];

        if ($auth !== null) {
            switch ($auth->getMethod()) {
                case 'user':
                    $config[RequestOptions::AUTH] = [
                        $auth->getUsername(),
                        $auth->getPassword(),
                    ];

                    break;
                case 'token':
                    $config[RequestOptions::HEADERS] = [
                        'Authorization' => 'Bearer ' . $auth->getToken()
                    ];

                    break;
            }
        }

        return $config;
    }
}
