# mysql启动服务器程序

## mysqld
mysqld是一个可执行文件就可以启动一个服务器进程。
## mysqld_safe
mysqld_safe 是一个启动脚本,它会间接的调用mysqld,而且还会启动一个监控进程，这个监控进程在服务器进程挂了的时候，可以帮助重启它。也会将服务器程序的出错信息和其他诊断信息重定向到某个文件中,会产生错误日志,这样可以方便我们找出错误原因.
## mysql.server
mysql.server 也是一个启动脚本,软连接../support-files/mysql.server 执行文件的时候，间接调用mysql_safe,在调用mysql.server时在后边指定start参数就可以启动服务器程序了。

`mysql.server start`

`mysql.server stop`

## mysqld_multi
运行多个`mysql`服务器进程

# 启动mysql客户端程序
## 连接命令
mysql -h主机名 -u用户名 -p密码
```
-h	表示服务器进程所在计算机的域名或者IP地址，如果服务器进程就运行在本机的话，可以省略这个参数，或者填localhost或者127.0.0.1。也可以写作 --host=主机名的形式。
-u	表示用户名。也可以写作 --user=用户名的形式。
-p	表示密码。也可以写作 --password=密码的形式
```
注意事项：

1.最好不要在一行命令中输入密码。

2.如果你非要在一行命令中显式的把密码输出来，那-p和密码值之间不能有空白字符

3.mysql的各个参数的摆放顺序没有硬性规定，也就是说你也可以这么写：`mysql -p  -u root -h localhost`

4.如果你的服务器和客户端安装在同一台机器上，-h参数可以省略，就像这样：`mysql -u root -p  `

# 客户端与服务器连接的过程



