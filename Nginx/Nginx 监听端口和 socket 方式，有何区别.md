Nginx和PHP-FPM的进程间通信有两种方式,一种是TCP Socket,一种是UNIX Domain Socket.
其中TCP Socket是IP加端口,Nginx的默认的通信方式,可以跨服务器.非常适合做负载均衡,而UNIX Domain Socket是发生
在系统内核里不经过网络.只能用于Nginx跟PHP-FPM都在同一服务器场景.