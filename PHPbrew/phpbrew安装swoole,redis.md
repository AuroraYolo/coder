## swoole
```bash
phpbrew ext install swoole --  --enable-openssl --with-openssl-dir=/usr/local/opt/openssl@1.1/  ##根据自己主机目录位置填写
 --enable-http2 --enable-sockets --enable-swoole-json --enable-swoole-curl

```

## Redis
```bash
phpbrew ext install redis
```

## amqp
```bash
phpbrew ext install amqp beta  -- --with-librabbitmq-dir=/usr/local/Cellar/rabbitmq-c/0.10.0  ## librabbitmq地址
```
