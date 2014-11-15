Flock
=====

Flock of tweeting birds. Coming soon.

Twitter Authentication Setup
----------------------------
There are two ways the Twitter app credentials can be load into the application.
The first (original) way is specifying a configuration file:

```
$ cat > config/config.ini
consumer_key = {CONSUMER_KEY}
consumer_secret = {CONSUMER_SECRET}

; ProgramovaniCZ account secrets
ot_programovaniCZ = {OAUTH_TOKEN}
ots_programovaniCZ = {OAUTH_SECRET}

^D
```

The other possibility is to specify directly the environment variables:

```
$ export OAUTH_TOKEN={OAUTH_TOKEN}
$ export OAUTH_SECRET={OAUTH_SECRET}
$ export CONSUMER_KEY={CONSUMER_KEY}
$ export CONSUMER_SECRET={CONSUMER_SECRET}
```

After that, you need to choose the appropriate ConfigProvider in the `src/bin/{process}.php` file.