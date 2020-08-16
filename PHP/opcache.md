## 1.概述
```
在理解 OPCache 功能之前，我们有必要先理解PHP-FPM + Nginx 的工作机制，以及PHP脚本解释执行的机制。
```
1.1 PHP-FPM + Nginx 的工作机制

请求从Web浏览器到Nginx，再到PHP处理完成,一共要经历如下五个步骤:

**第一步:启动服务**
+ 启动PHP-FPM。PHP-FPM 支持两种通信模式：TCP socket和Unix socket；

- PHP-FPM 会启动两种类型的进程：Master 进程 和 Worker 进程，前者负责监控端口、分配任务、管理Worker进程；后者就是PHP的cgi程序，负责解释编译执行PHP脚本。

- 启动Nginx。首先会载入 ngx_http_fastcgi_module 模块，初始化FastCGI执行环境，实现FastCGI协议请求代理
这里要注意：fastcgi的worker进程(cgi进程)，是由PHP-FPM来管理，不是Nginx。Nginx只是代理

**第二步：Request => Nginx**
- Nginx 接收请求，并基于location配置，选择一个合适handler
- 这里就是代理PHP的 handler

**第三步：Nginx => PHP-FPM**
- Nginx 把请求翻译成fastcgi请求
- 通过TCP socket/Unix Socket 发送给PHP-FPM 的master进程

**第四步：PHP-FPM Master => Worker**
- PHP-FPM master 进程接收到请求
- 分配Worker进程执行PHP脚本，如果没有空闲的Worker，返回502错误
   Worker(php-cgi)进程执行PHP脚本，如果超时，返回504错误
- 处理结束，返回结果

**第五步：PHP-FPM Worker => Master => Nginx**
- PHP-FPM Worker 进程返回处理结果，并关闭连接，等待下一个请求
- PHP-FPM Master 进程通过Socket 返回处理结果
- Nginx Handler顺序将每一个响应buffer发送给第一个filter → 第二个 → 以此类推 → 最终响应发送给客户端

1.2 PHP脚本解释执行的机制
  1. php初始化执行环节，启动Zend引擎，加载注册的扩展模块
  2. 初始化后读取脚本文件，Zend引擎对脚本文件进行词法分析(lex)，语法分析(bison)，生成语法树
 3. Zend 引擎编译语法树，生成opcode，
 4. Zend 引擎执行opcode，返回执行结果
 
  在PHP cli模式下，每次执行PHP脚本，四个步骤都会依次执行一遍；

  在PHP-FPM模式下，步骤1)在PHP-FPM启动时执行一次，后续的请求中不再执行；步骤2)~4)每个请求都要执行一遍；
  
 2.Opcache原理
  Opcache缓存的机制主要是:将编译好的操作码放入共享内存,提供给其他进程访问.
  
 **2.1 共享内存**
 
 UNIX/Linux 系统提供很多种进程间内存共享的方式：
  - System-V shm API: System V共享内存,
     - sysv shm是持久化的，除非被一个进程明确的删除，否则它始终存在于内存里，直到系统关机；
 - mmap API：
   - mmap映射的内存在不是持久化的，如果进程关闭，映射随即失效，除非事先已经映射到了一个文件上
   - 内存映射机制mmap是POSIX标准的系统调用，有匿名映射和文件映射两种
   - mmap的一大优点是把文件映射到进程的地址空间
   - 避免了数据从用户缓冲区到内核page cache缓冲区的复制过程；
   - 当然还有一个优点就是不需要频繁的read/write系统调用
 
 - POSIX API： System V 的共享内存是过时的, POSIX共享内存提供了使用更简单、设计更合理的API.
 - Unix socket API
 OPCache 使用了前三个共享内存机制，根据配置或者默认mmap 内存共享模式。
 
     依据PHP字节码缓存的场景，OPCache的内存管理设计非常简单，快速读写，不释放内存，过期数据置为Wasted。
 
    当Wasted内存大于设定值时，自动重启OPCache机制，清空并重新生成缓存
 
 **2.2 互斥锁**
  
    任何内存资源的操作，都涉及到锁的机制。
 
    共享内存：一个单位时间内，只允许一个进程执行写操作，允许多个  进程执行读操作；
 
    写操作同时，不阻止读操作，以至于很少有锁死的情况。
 
    这就引发另外一个问题：新代码、大流量场景，进程排队执行缓存    opcode操作；重复写入，导致资源浪费。
 

  
  
  





