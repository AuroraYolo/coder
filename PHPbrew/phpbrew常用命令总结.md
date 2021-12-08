# 关闭phpbrew
```bash
phpbrew off
```

# 切换php版本

```bash
phpbrew swtich 8.0.6
```
```bash
phpbrew -d install 7.4.23 \
    +default \
    +fpm \
    +iconv \
    +curl \
    +ctype \
    +filter \
    +json \
    +mbstring \
    +openssl \
    +pdo \
    +sqlite \
    +mysql \
    +phar \
    +sockets \
    +zlib \
    -- \
    --with-zlib-dir=/usr/local/opt/zlib \
    --with-gd=shared \
    --with-png-dir=/usr/local/opt/lib \
    --with-jpeg-dir=/usr/local/opt/jpeg \
    --with-freetype-dir=/usr/local/opt/freetype \
    --enable-gd-native-ttf
````
# 使用指定的php版本


```bash
phpbrew use 8.0.6
```
