[安装链接](!https://github.com/shivammathur/homebrew-php)

## 当与phpbrew切换版本遇见冲突,
比如homebrew-php是8.1版本,phpbrew是8.0版本，当执行了phpbrew off 重新执行phpbrew switch php-8.0.6会报错,执行brew unlink php@8.1 如果切换为8.1版本执行brew link --overwrite --force php@8.1
