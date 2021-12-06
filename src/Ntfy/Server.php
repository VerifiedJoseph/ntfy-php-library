<?php

namespace Ntfy;

use Ntfy\NtfyException;

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
		$this->uri = $this->vaildate($uri);
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
	 * Vaildate server URI
	 *
	 * Checks if server URI starts with `https://` or `http://`.
	 *
	 * Checks if server URI ends with a forward slash and adds it if misssing.
	 *
	 * @param string $uri Server URI
	 * @return string $uri Returns vaildated server URI
	 *
	 * @throws NtfyException if Server URL doesn't start with `https://` or `http://`.
	 */
	private function vaildate(string $uri): string
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
