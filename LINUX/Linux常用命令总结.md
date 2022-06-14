## 网络配置查看

````bash
root@VM-0-16-ubuntu:~# ip -s addr show dev eth0
2: eth0: <BROADCAST,MULTICAST,UP,LOWER_UP> mtu 1500 qdisc mq state UP group default qlen 1000
    link/ether 52:54:00:83:26:ad brd ff:ff:ff:ff:ff:ff
    inet xx.xx.xx.xx/22 brd xx scope global eth0
       valid_lft forever preferred_lft forever
    inet6 xx scope link
       valid_lft forever preferred_lft forever
    RX: bytes  packets  errors  dropped overrun mcast
    8792318268 85927180 0       0       0       0
    TX: bytes  packets  errors  dropped carrier collsns
    13518187886 86282794 0       0       0       0

内容解释:    
⽐如都包含了 IP 地址、⼦⽹掩码、MAC
地址、⽹关地址、MTU ⼤⼩、⽹⼝的状态以及⽹路包收发的统计信息，下⾯就来说说这些信息，它们都与
⽹络性能有⼀定的关系。
第⼀，⽹⼝的连接状态标志。其实也就是表示对应的⽹⼝是否连接到交换机或路由器等设备，如果
ifconfig 输出中看到有 RUNNING ，或者 ip 输出中有 LOWER_UP ，则说明物理⽹路是连通的，如
果看不到，则表示⽹⼝没有接⽹线。
第⼆，MTU ⼤⼩。默认值是 1500 字节，其作⽤主要是限制⽹络包的⼤⼩，如果 IP 层有⼀个数据报要
传，⽽且数据帧的⻓度⽐链路层的 MTU 还⼤，那么 IP 层就需要进⾏分⽚，即把数据报分成⼲⽚，这样每
⼀⽚就都⼩于 MTU。事实上，每个⽹络的链路层 MTU 可能会不⼀样，所以你可能需要调⼤或者调⼩ MTU
的数值。
第三，⽹⼝的 IP 地址、⼦⽹掩码、MAC 地址、⽹关地址。这些信息必须要配置正确，⽹络功能才能正常
⼯作。
第四，⽹路包收发的统计信息。通常有⽹络收发的字节数、包数、错误数以及丢包情况的信息，如果 TX
（发送） 和 RX （接收） 部分中 errors、dropped、overruns、carrier 以及 collisions 等指标不为 0 时，
则说明⽹络发送或者接收出问题了，这些出错统计信息的指标意义如下：
errors 表示发⽣错误的数据包数，⽐如校验错误、帧同步错误等；
dropped 表示丢弃的数据包数，即数据包已经收到了 Ring Buffer（这个缓冲区是在内核内存中，更具
体⼀点是在⽹卡驱动程序⾥），但因为系统内存不⾜等原因⽽发⽣的丢包；
overruns 表示超限数据包数，即⽹络接收/发送速度过快，导致 Ring Buffer 中的数据包来不及处理，
⽽导致的丢包，因为过多的数据包೿压在 Ring Buffer，这样 Ring Buffer 很容易就溢出了；
carrier 表示发⽣ carrirer 错误的数据包数，⽐如双⼯模式不匹配、物理电缆出现问题等；
collisions 表示冲突、碰撞数据包数；    
````

## socket 信息如何查看？
```bash
root@VM-0-16-ubuntu:~# netstat -nlp
Active Internet connections (only servers)
Proto Recv-Q Send-Q Local Address           Foreign Address         State       PID/Program name
tcp        0      0 172.19.0.1:53           0.0.0.0:*               LISTEN      741/named

## -n 表示不显示名字,而足以数字方式显示ip和端口
## -l 表示至显示listen状态的socket
## -p 表示显示进程信息

root@VM-0-16-ubuntu:~# ss -ltnp
State     Recv-Q    Send-Q                                    Local Address:Port          Peer Address:Port    Process
LISTEN    0         10                                           172.19.0.1:53                 0.0.0.0:*        users:(("named",pid=741,fd=60),("named",pid=741,fd=59),("named",pid=741,fd=58))

# -l 表示只显示listen状态的socket
# -t 表示只是显示tcp连接
# -n 表示不显示名字,而足以数字方式显示ip和端口
# -p 表示显示进程信息

可以发现，输出的内容都差不多， ⽐如都包含了 socket 的状态（State）、接收队列（Recv-Q）、发送队
列（Send-Q）、本地地址（Local Address）、远端地址（Foreign Address）、进程 PID 和进程名称
（PID/Program name）等。
接收队列（Recv-Q）和发送队列（Send-Q）⽐较特殊，在不同的 socket 状态。它们表示的含义是不同
的。
当 socket 状态处于 Established 时：
Recv-Q 表示 socket 缓冲区中还没有被应⽤程序读取的字节数；
Send-Q 表示 socket 缓冲区中还没有被远端主机确认的字节数；
⽽当 socket 状态处于 Listen 时：
Recv-Q 表示全连接队列的⻓度；
Send-Q 表示全连接队列的最⼤⻓度；
在 TCP 三次握⼿过程中，当服务器收到客户端的 SYN 包后，内核会把该连接存储到半连接队列，然后再
向客户端发送 SYN+ACK 包，接着客户端会返回 ACK，服务端收到第三次握⼿的 ACK 后，内核会把连接
从半连接队列移除，然后创建新的完全的连接，并将其增加到全连接队列 ，等待进程调⽤ accept() 函数
时把连接取出来。
```
## ⽹络吞吐率和 PPS 如何查看？
```bash
## 显示⽹⼝的统计数据； 数字1 表示每隔1秒 输出一组数据
sar -n DEV 1
Linux 5.4.0-77-generic (VM-0-16-ubuntu) 	06/14/22 	_x86_64_	(2 CPU)

22:38:57        IFACE   rxpck/s   txpck/s    rxkB/s    txkB/s   rxcmp/s   txcmp/s  rxmcst/s   %ifutil
22:38:58    veth21d28fa      0.00      0.00      0.00      0.00      0.00      0.00      0.00      0.00
22:38:58           lo      0.00      0.00      0.00      0.00      0.00      0.00      0.00      0.00
22:38:58    veth4195d13      0.00      0.00      0.00      0.00      0.00      0.00      0.00      0.00

sar -n EDEV，显示关于⽹络错误的统计数据；
sar -n TCP，显示 TCP 的统计数据


rxpck/s 和 txpck/s 分别是接收和发送的 PPS，单位为包 / 秒。
rxkB/s 和 txkB/s 分别是接收和发送的吞吐率，单位是 KB/ 秒。
rxcmp/s 和 txcmp/s 分别是接收和发送的压缩数据包数，单位是包 / 秒。


```
```bash
对于带宽，我们可以使⽤ ethtool 命令来查询，它的单位通常是 Gb/s 或者 Mb/s ，不过注意这⾥⼩写
字⺟ b ，表示⽐特⽽不是字节。我们通常提到的千兆⽹卡、万兆⽹卡等，单位也都是⽐特（bit）。如下
你可以看到， eth0 ⽹卡就是⼀个千兆⽹卡

ethtool eth0 | grep Speed
 Speed: 1000Mb/s
```

## 连通性和延时如何查看？

```bash
要测试本机与远程主机的连通性和延时，通常是使⽤ ping 命令，它是基于 ICMP 协议的，⼯作在⽹络
层。
⽐如，如果要测试本机到 192.168.12.20 IP 地址的连通性和延时：
## -c 5表示发送5次 icmp包
ping www.baidu.com -c 5
PING www.a.shifen.com (110.242.68.3) 56(84) bytes of data.
64 bytes from 110.242.68.3 (110.242.68.3): icmp_seq=1 ttl=51 time=33.3 ms
64 bytes from 110.242.68.3 (110.242.68.3): icmp_seq=2 ttl=51 time=33.3 ms
64 bytes from 110.242.68.3 (110.242.68.3): icmp_seq=3 ttl=51 time=33.3 ms
64 bytes from 110.242.68.3 (110.242.68.3): icmp_seq=4 ttl=51 time=33.3 ms
64 bytes from 110.242.68.3 (110.242.68.3): icmp_seq=5 ttl=51 time=33.3 ms

--- www.a.shifen.com ping statistics ---
5 packets transmitted, 5 received, 0% packet loss, time 4006ms
rtt min/avg/max/mdev = 33.297/33.304/33.319/0.007 ms

显示的内容主要包含 icmp_seq （ICMP 序列号）、 TTL （⽣存时间，或者跳数）以及 time （往返延
时），⽽且最后会汇总本次测试的情况，如果⽹络没有丢包， packet loss 的百分⽐就是 0。
不过，需要注意的是， ping 不通服务器并不代表 HTTP 请求也不通，因为有的服务器的防⽕墙是会禁⽤
ICMP 协议的。
```
