redlock-php - Redis distributed locks in PHP

Based on [Redlock-rb](https://github.com/antirez/redlock-rb) by [Salvatore Sanfilippo](https://github.com/antirez), descendant of [ronnylt/redlock-php](https://github.com/ronnylt/redlock-php) which was abandoned in early 2015.

This library implements the Redis-based distributed lock manager algorithm [described in this Redis article](http://redis.io/topics/distlock).

To create a lock manager:

Locks can be provided using an array of server tuples made up of the server name (required), connection port (optional), and connection timeout (optional), or by using already-connected Redis objects,

```php
$server = new \Redis;
$server->connect('127.0.0.1');

$servers = [
    ['127.0.0.1', 6379, 0.01],
    ['127.0.0.1'],
    $server,
];

$redLock = new RedLock($servers);

```

To acquire a lock:

```php

$lock = $redLock->lock('my_resource_name', 1000);

```

Where the resource name is an unique identifier of what you are trying to lock and 1000 is the number of milliseconds for the validity time.

The returned value is `false` if the lock was not acquired (you may try again), otherwise an array representing the lock is returned, having three keys:

```php
Array
(
    [validity] => 9897.3020019531
    [resource] => my_resource_name
    [token] => 53771bfa1e775
)
```

* validity, an integer representing the number of milliseconds the lock will be valid.
* resource, the name of the locked resource as specified by the user.
* token, a random token value which is used to safe reclaim the lock.

To release a lock:

```php
    $redLock->unlock($lock)
```

It is possible to setup the number of retries (by default 3) and the retry
delay (by default 200 milliseconds) used to acquire the lock.

The retry delay is actually chosen at random between `$retryDelay / 2` milliseconds and
the specified `$retryDelay` value.

**Disclaimer**: As stated in the original antirez's version, this code implements an algorithm which is currently a proposal, it was not formally analyzed. Make sure to understand how it works before using it in your production environments.
