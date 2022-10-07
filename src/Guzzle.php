<?php

namespace Ntfy;

use GuzzleHttp\Psr7;
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
	private array $requestMethods = array('GET', 'POST');

	/** @var int $timeout Request timeout in seconds */
	private int $timeout = 10;

	/**
	 *
	 * @param string $uri Server URI
	 * @param array<string, string> $auth Authentication username and password
	 */

	function __construct(string $uri, $auth = array())
	{
		$config = $this->getConfig($uri, $auth);
		$this->client = new Client($config);
	}

	/**
	 * Make GET request
	 *
	 * @param string $endpoint API endpoint
	 * @param array<string, mixed> $query HTTP Query data
	 * @return ResponseInterface
	 */
	public function get(string $endpoint, array $query = array()): ResponseInterface
	{
		$options = array(
			RequestOptions::QUERY => $query
		);

		return $this->request('GET', $endpoint, $options);
	}

	/**
	 * Make POST request
	 *
	 * @param string $endpoint API endpoint
	 * @param array<string, mixed> $data
	 * @param array<string, mixed> $headers
	 * @return ResponseInterface
	 */
	public function post(string $endpoint, array $data = [], array $headers = array()): ResponseInterface
	{
		$options = array(
			RequestOptions::HEADERS => $headers,
			RequestOptions::JSON => $data
		);

		return $this->request('POST', $endpoint, $options);
	}

	/**
	 * Make HTTP request
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
	private function request(string $method, string $endpoint, array $options = array()): ResponseInterface
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
				$json = (object) Json::decode($response->getBody());
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
	 * @param array<string, string> $auth Authentication username and password
	 * @return array<string, mixed> Returns client config array
	 */
	private function getConfig(string $uri, array $auth): array
	{
		$config = array(
			'base_uri' => $uri,
			'Accept' => 'application/json',
			'timeout' => $this->timeout,
			'allow_redirects' => false,
		);

		$config = array_merge(
			$config,
			$this->getAuthConfig($auth)
		);

		return $config;
	}

	/**
	 * Get authentication config
	 *
	 * @param array<string, string> $auth Authentication username and password
	 * @return array<string, array<int|string, string>>
	 */
	private function getAuthConfig(array $auth): array
	{
		$config = array();

		if ($auth !== []) {
			$config[RequestOptions::AUTH] = array(
				$auth['username'],
				$auth['password']
			);
		}

		return $config;
	}
}
