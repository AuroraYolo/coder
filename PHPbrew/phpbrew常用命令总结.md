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
    --enable-gd-native-ttf \
    darwin64-x86_64-cc
````
# 使用指定的php版本


```bash
phpbrew use 8.0.6
```

# 问题
```
1.checking for openssl >= 1.0.1... no
configure: error: Package requirements (openssl >= 1.0.1) were not met:

No package 'openssl' found
```
解决办法:
```
  echo 'export PATH="/usr/local/opt/openssl@1.1/bin:$PATH"' >> ~/.zshrc

  export LDFLAGS="-L/usr/local/opt/openssl@1.1/lib"
  export CPPFLAGS="-I/usr/local/opt/openssl@1.1/include"

  export PKG_CONFIG_PATH="/usr/local/opt/openssl@1.1/lib/pkgconfig"
```


