## select原理
select函数监视的文件描述符分3类,writefds,readfds,exceptfds,调用select函数会阻塞,直到有描述符就绪
(有数据可读,可写,或者有except),或者超时(timeout指定),select函数返回后，可以便利fdset,来找到就绪的描述符.

## 文件描述符的数量限制

Linux  => 1024

##  缺点
1.单个进程文件描述符fd是有限制的,FD_SETSIZE设置,默认1024
2.对socket进行扫描时时线性扫描,采用轮询的方法,效率较低.
3.需要维护一个用来存放大量fd的数据结构.
