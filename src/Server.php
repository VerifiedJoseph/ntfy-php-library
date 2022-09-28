<?php

namespace Ntfy;

use Ntfy\Exception\NtfyException;

/**
 * Class for setting and vaildating a server URI
 */
final class Server
{
	/** @var string $uri Server URI */
	private string $uri = '';

	/**
	 *
	 * @param string $uri Server URI
	 */
	function __construct(string $uri)
	{
		$this->uri = $this->validate($uri);
	}

	/**
	 * Get server
	 *
	 * @return string Returns server URI
	 */
	public function get(): string
	{
		return $this->uri;
	}

	/**
	 * Validate server URI
	 *
	 * Checks if server URI starts with `https://` or `http://`.
	 *
	 * Checks if server URI ends with a forward slash and adds it if missing.
	 *
	 * @param string $uri Server URI
	 * @return string $uri Returns validated server URI
	 *
	 * @throws NtfyException if Server URL doesn't start with `https://` or `http://`.
	 */
	private function validate(string $uri): string
	{
		if(preg_match('/^https?:\/\//', $uri) === 0) {
			throw new NtfyException('Server URI must start with https:// or http://');
		}

		if(substr($uri, -1) !== '/') {
			$uri .= '/';
		}

		return $uri;
	}
}
