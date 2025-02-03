<?php

declare(strict_types=1);

namespace Ntfy;

use Ntfy\Action\Broadcast;
use Ntfy\Action\Http;
use Ntfy\Action\View;
use Ntfy\Exception\NtfyException;

/**
 * Class for sending a message
 */
class Message
{
    /**
     * Max message priority
     * @see https://ntfy.sh/docs/publish/#message-priority
     */
    public const PRIORITY_MAX = 5;

    /**
     * High message priority
     * @see https://ntfy.sh/docs/publish/#message-priority
     */
    public const PRIORITY_HIGH = 4;

    /**
     * Default message priority
     * @see https://ntfy.sh/docs/publish/#message-priority
     */
    public const PRIORITY_DEFAULT = 3;

    /**
     * Low message priority
     * @see https://ntfy.sh/docs/publish/#message-priority
     */
    public const PRIORITY_LOW = 2;

    /**
     * Min message priority
     * @see https://ntfy.sh/docs/publish/#message-priority
     */
    public const PRIORITY_MIN = 1;

    /** @var array<string, mixed> $data Message settings */
    private array $data = [
        'topic' => ''
    ];

    /**
     * Set message topic (required)
     *
     * @param string $topic Message topic
     *
     * @see https://ntfy.sh/docs/publish/#publishing
     */
    public function topic(string $topic): void
    {
        $this->data['topic'] = $topic;
    }

    /**
     * Set message title
     *
     * @param string $title Message title
     */
    public function title(string $title): void
    {
        $this->data['title'] = $title;
    }

    /**
     * Set message priority
     *
     * Priorities:
     * - `5` - Max
     * - `4` - High
     * - `3` - Default
     * - `2` - Low
     * - `1` - Min
     *
     * @param int $priority Message priority
     *
     * @see https://ntfy.sh/docs/publish/#message-priority
     */
    public function priority(int $priority): void
    {
        $this->data['priority'] = $priority;
    }

    /**
     * Set plaintext message body
     *
     * Use `markdownBody()` to set a markdown formatted message body
     *
     * @param string $body Message body
     */
    public function body(string $body): void
    {
        $this->data['message'] = $body;
        $this->data['markdown'] = false;
    }

    /**
     * Set markdown formatted message body
     *
     * Use `body()` to set a plaintext message body
     *
     * @param string $body Message body
     *
     * @see https://docs.ntfy.sh/publish/#markdown-formatting
     */
    public function markdownBody(string $body): void
    {
        $this->data['message'] = $body;
        $this->data['markdown'] = true;
    }

    /**
     * Set message tags
     *
     * @param array<int, string|int> $tags Array of message tags
     *
     * @see https://ntfy.sh/docs/publish/#tags-emojis
     */
    public function tags(array $tags): void
    {
        $this->data['tags'] = $tags;
    }

    /**
     * Set scheduled delivery for the message
     *
     * @param string $delay Duration of the delay (e.g 1min, 1hour, 1day)
     *
     * @see https://ntfy.sh/docs/publish/#scheduled-delivery
     */
    public function schedule(string $delay): void
    {
        $this->data['delay'] = $delay;
    }

    /**
     * Set URL to open when message notification is clicked
     *
     * @param string $url URL
     *
     * @see https://ntfy.sh/docs/publish/#click-action
     */
    public function clickAction(string $url): void
    {
        $this->data['click'] = $url;
    }

    /**
     * Set email address for sending a email notification
     *
     * @param string $email Email address
     *
     * @see https://ntfy.sh/docs/publish/#e-mail-notifications
     */
    public function email(string $email): void
    {
        $this->data['email'] = $email;
    }

    /**
     * Set URL for message notification icon
     *
     * @param string $url icon URL
     *
     * @see https://ntfy.sh/docs/publish/#icons
     */
    public function icon(string $url): void
    {
        $this->data['icon'] = $url;
    }

    /**
     * Set a file attachment using a URL
     *
     * @param string $url File URL
     * @param string $name Filename (optional, ntfy will fetch filename its self if not given)
     *
     * @see https://ntfy.sh/docs/publish/#attachments
     * @see https://ntfy.sh/docs/publish/#attach-local-file
     */
    public function attachURL(string $url, string $name = ''): void
    {
        $this->data['attach'] = $url;
        $this->data['filename'] = $name;
    }

    /**
     * Set an action button
     *
     * @param Broadcast|Http|View $action Action class instance
     *
     * @see https://ntfy.sh/docs/publish/#action-buttons
     */
    public function action(Broadcast|Http|View $action): void
    {
        $this->data['actions'][] = $action->get();
    }

    /**
     * Disable caching for this message
     *
     * @see https://ntfy.sh/docs/publish/#message-caching
     */
    public function disableCaching(): void
    {
        $this->data['cache'] = 'no';
    }

    /**
     * Disable firebase for this message
     *
     * @see https://ntfy.sh/docs/publish/#disable-firebase
     */
    public function disableFirebase(): void
    {
        $this->data['firebase'] = 'no';
    }

    /**
     * Get the data to be sent as JSON to the server.
     *
     * @return array<string, mixed>
     * @throws NtfyException if the message topic is not given
     */
    public function getData(): array
    {
        if ($this->data['topic'] === '') {
            throw new NtfyException('Message topic must be given');
        }

        return $this->data;
    }
}
