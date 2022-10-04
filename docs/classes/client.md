# Client

Class for sending requests to a Ntfy server.

```PHP
Ntfy\Client(Server $server, ?Auth $auth = null)
```

### Examples

- [Send a message](../../examples/send-message.php)

### Methods

Send a message to the defined server.

```PHP
send(Message $message): stdClass
```
