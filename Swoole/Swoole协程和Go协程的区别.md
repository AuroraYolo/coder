Swoole是单线程的,GO是多线程的。
Swoole必须开启协程上下文,Go是天生支持协程的。
Swoole如果要多核处理协程,需要依赖Process开启多进程.
Go的协程模型是GMP模型. M:系统线程 P:Go实现的协程处理器 G：协程