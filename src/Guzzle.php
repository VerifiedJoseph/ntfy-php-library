<?php

namespace Ntfy;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Psr\Http\Message\ResponseInterface;

use Ntfy\Exception\NtfyException;
use Ntfy\Exception\EndpointException;

// Guzzle exceptions
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;

/**
 * Class for making HTTP requests using GuzzleHttp.
 */
final class Guzzle
{
    private Client $client;

    /** @var array<int, string> $requestMethods Array of supported HTTP request methods */
    private array $requestMethods = ['GET', 'POST'];

    /** @var int $timeout Request timeout in seconds */
    private int $timeout = 10;

    /**
     *
     * @param string $uri Server URI
     * @param ?Auth $auth Authentication username and password
     */
    public function __construct(string $uri, ?Auth $auth)
    {
        $config = $this->getConfig($uri, $auth);
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
    private function request(string $method, string $endpoint, array $options = []): ResponseInterface
    {
        try {
            if (in_array($method, $this->requestMethods) === false) {
                throw new NtfyException('Request method must be GET or POST');
            }

            $response = $this->client->request($method, $endpoint, $options);
        } catch (ConnectException $err) {
            throw new NtfyException($err->getMessage());
        } catch (RequestException $err) {
            if ($err->hasResponse() === false) {
                throw new EndpointException($err->getMessage(), 0);
            }

            $response = $err->getResponse();
            $contentType = $response->getHeaderLine('Content-Type');

            if ($contentType === 'application/json') {
                $json = Json::decode($response->getBody());
                $message = $json->error . ' (code: ' . $json->code . ')';

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
     * @param ?Auth $auth Authentication username and password
     * @return array<string, mixed> Returns client config array
     */
    private function getConfig(string $uri, ?Auth $auth): array
    {
        $config = [
            'base_uri' => $uri,
            'Accept' => 'application/json',
            'timeout' => $this->timeout,
            'allow_redirects' => false,
        ];

        $config = array_merge(
            $config,
            $this->getAuthConfig($auth)
        );

        return $config;
    }

    /**
     * Get authentication config
     *
     * @param ?Auth $auth Authentication class instance
     * @return array<string, array<int|string, string>>
     */
    private function getAuthConfig(?Auth $auth): array
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
