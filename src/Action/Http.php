<?php

declare(strict_types=1);

namespace Ntfy\Action;

/**
 * Class for creating a http button action
 *
 * @see https://ntfy.sh/docs/publish/#open-websiteapp
 */
class Http extends AbstractAction
{
    /** {@inheritDoc} */
    protected string $type = 'http';

    /** @var string $url HTTP request URL */
    protected string $url = '';

    /** @var string $method HTTP request method */
    protected string $method = 'POST';

    /** @var array<string, string> $headers HTTP request headers */
    protected array $headers = [];

    /** @var string $body HTTP request body */
    protected string $body = '';

    /**
     * Set HTTP request URL
     *
     * @param string $url URL
     */
    public function url(string $url): void
    {
        $this->url = $url;
    }

    /**
     * Set HTTP request method
     *
     * @param string $method HTTP request method
     */
    public function method(string $method): void
    {
        $this->method = $method;
    }

    /**
     * Set an HTTP request header
     *
     * @param string $name Header name
     * @param string $value Header value
     */
    public function header(string $name, string $value): void
    {
        $this->headers[$name] = $value;
    }

    /**
     * Set HTTP request body
     *
     * @param string $body Request body
     */
    public function body(string $body): void
    {
        $this->body = $body;
    }

    /**
     * {@inheritDoc}
     */
    protected function generate(): array
    {
        $action = parent::generate();
        $action['url'] = $this->url;
        $action['method'] = $this->method;

        if ($this->headers !== []) {
            $action['headers'] = $this->headers;
        }

        if ($this->body !== '') {
            $action['body'] = $this->body;
        }

        return $action;
    }
}
