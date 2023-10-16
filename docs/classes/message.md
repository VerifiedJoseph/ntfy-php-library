# Message

Class for creating a message

```PHP
Ntfy\Message()
```

### Examples

- [Send a message](../../examples/send-message.php)
- [Send a message with a markdown body](../../examples/send-message-with-markdown-body.php)
- [Send a message with a view action button](../../examples/send-message-with-view-action.php)
- [Send a message to a server protected with user authentication](../../examples/send-message-with-user-auth.php)
- [Send a message to a server protected with token authentication](../../examples/send-message-with-token-auth.php)

### Constants

Maximum message priority

```PHP
Message::PRIORITY_MAX
```

High message priority

```PHP
Message::PRIORITY_HIGH
```

Default message priority

```PHP
Message::PRIORITY_DEFAULT
```

Low message priority

```PHP
Message::PRIORITY_LOW
```

Minimum message priority

```PHP
Message::PRIORITY_MIN
```

### Methods

Set message topic

```PHP
topic(string $topic): void
```

Set message title

```PHP
title(string $title): void
```

Set message priority

```PHP
priority(int $priority): void
```

Set plaintext message body

```PHP
body(string $body): void
```

Set markdown message body

```PHP
markdownBody(string $body): void
```

Set message tags

```PHP
tags(array $tags): void
```

Set scheduled delivery for the message

```PHP
schedule(string $delay): void
```

Set URL to open when message notification is clicked

```PHP
clickAction(string $url): void
```

Set email address for sending a email notification

```PHP
email(string $email): void
```

Set URL for message notification icon

```PHP
icon(string $url): void
```

Set a file attachment using a URL

```PHP
attachURL(string $url, string $name = ''): void
```

Set an action button

```PHP
action(Action $action): void
```

Disable caching for this message

```PHP
disableCaching(): void
```

Disable firebase for this message

```PHP
disableFirebase(): void
```

Get the data to be sent as JSON to the server.

```PHP
getData(): array
```
