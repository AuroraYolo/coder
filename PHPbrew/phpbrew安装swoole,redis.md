## 文档地址
https://github.com/phpbrew/phpbrew/wiki/Extension-Installer

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

## swow
composer 下载swow包
```bash
composer require swow/swow:dev-develop
```
composer vendor bin执行编译命令
```bash
./vendor/bin/swow-builder
```
运行swow 并查看swow版本信息
```bash
php -n -d extension=/Users/heping/Serendipity-Job//vendor/swow/swow/ext/modules/swow.so --ri swow
```
这样安装的好处是可以通过composer 控制swow的版本

##  iconv
```bash
 brew install libiconv
phpbrew ext install iconv -- --with-iconv=/usr/local/Cellar/libiconv/1.16
```

## gd
```bash
phpbrew ext install gd -- --with-gd=shared \
    --with-png-dir=/usr/local/opt/lib \
    --with-jpeg-dir=/usr/local/opt/jpeg \
    --with-freetype-dir=/usr/local/opt/freetype  \
    --enable-gd-native-ttf
```
