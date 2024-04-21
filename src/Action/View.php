<?php

namespace Ntfy\Action;

/**
 * Class for creating a view button action
 *
 * @see https://ntfy.sh/docs/publish/#open-websiteapp
 */
class View extends AbstractAction
{
    /** {@inheritDoc} */
    protected string $type = 'view';

    /** @var string $url URL */
    protected string $url = '';

    /**
     * Set action URL
     *
     * @param string $url URL
     */
    public function url(string $url): void
    {
        $this->url = $url;
    }

    /**
     * {@inheritDoc}
     */
    protected function generate(): array
    {
        $action = parent::generate();
        $action['url'] = $this->url;

        return $action;
    }
}
