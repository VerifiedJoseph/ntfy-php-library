<?php

namespace Ntfy;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Psr\Http\Message\ResponseInterface;

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
	private array $requestMethods = array('GET', 'POST', 'PUT');

	/** @var int $timeout Request timeout in seconds */
	private int $timeout = 10;

	/**
	 *
	 * @param string $uri Server URI
	 */
	function __construct(string $uri)
	{
		$config = $this->getConfig($uri);
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
	 * Make POST request a JOSN payload
	 *
	 * @param string $endpoint API endpoint
	 * @param string $data
	 * @param array $headers
	 * @return ResponseInterface
	 */
	public function post(string $endpoint, string $data = '', array $headers = array()): ResponseInterface
	{
		$options = array(
			RequestOptions::HEADERS => $headers,
			RequestOptions::BODY => $data
		);

		return $this->request('POST', $endpoint, $options);
	}

	/**
	 * Make PUT request
	 *
	 * @param string $endpoint API endpoint
	 * @param array<string, string> $data
	 * @return ResponseInterface
	 */
	public function put(string $endpoint, array $data): ResponseInterface
	{
		$options = array(
			RequestOptions::JSON => $data
		);

		return $this->request('PUT', $endpoint, $options);
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
	 * @throws NtfyException if API returned an error
	 */
	private function request(string $method, string $endpoint, array $options = array()): ResponseInterface
	{
		try {
			if (in_array($method, $this->requestMethods) === false) {
				throw new NtfyException('Request method must be GET, POST or PUT');
			}

			$response = $this->client->request($method, $endpoint, $options);

		} catch (ConnectException $err) {
			throw new NtfyException($err->getMessage());

		} catch (RequestException $err) {
			if ($err->hasResponse() === false) {
				throw new NtfyException($err->getMessage(), 0);
			}

			$response = $err->getResponse();

			throw new NtfyException(
				$response->getBody()->getContents(),
				$response->getStatusCode()
			);
		}

		return $response;
	}

	/**
	 * Get GuzzleHttp client config
	 *
	 * @param string $uri Server URI
	 * @return array<string, mixed> Returns client config array
	 */
	private function getConfig(string $uri): array
	{
		$config = array(
			'base_uri' => $uri,
			'Accept' => 'application/json',
			'timeout' => $this->timeout,
			'allow_redirects' => false,
		);

		return $config;
	}
}
