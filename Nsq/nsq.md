# NsqClient TCP 协议规范

## user_agent (nsqd v0.2.25+) 这个客户端的代理字符串

## max_msg_timeout (nsqd v0.2.28+) 配置服务端发送消息给客户端的超时时间


## long_id (v0.2.28+ 版之后已经抛弃，使用 hostname 替换)这个标示符是描述的长格式。(比如. 主机名全名)

## heartbeat_interval (nsqd v0.2.19+) 心跳的毫秒数.

有效范围: 1000 <= heartbeat_interval <= configured_max (-1 禁用心跳)

--max-heartbeat-interval (nsqd 标志位) 控制最大值

默认值 --client-timeout / 2

##  client_id 这个标示符用来消除客户端的歧义 (比如. 一些指定给消费者)

## hostname 部署了客户端的主机名
