## Master进程
swoole应用的root进程,fork出Reactor线程和Manager进程
Reactor是包含在master进程中的多线程程序,处理TCP连接和数据收发(异步非阻塞方式)

## Manager进程
Manager进程负责fork并维护多个worker子进程,负责回收并创建新的worker子进程
当服务器关闭时,Manager将发送信号给所有worker子进程.通知其服务关闭

## worker进程
以多进程的方式运行,负责接受由Reactor线程投递的请求数据包
执行PHP回调函数,生成数据响应发送给Reactor

## Task Worker进程
同worker进程一样,主要处理任务分发