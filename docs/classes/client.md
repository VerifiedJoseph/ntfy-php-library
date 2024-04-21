# Client

Class for sending requests to a Ntfy server.

```PHP
Ntfy\Client(Server $server, User|Token $auth = null)
```

### Examples

- [Send a message](../../examples/send-message.php)
- [Send a message to a server protected with user authentication](../../examples/send-message-with-user-auth.php)
- [Send a message to a server protected with token authentication](../../examples/send-message-with-token-auth.php)

### Methods

Send a message to the defined server.

```PHP
send(Message $message): stdClass
```
