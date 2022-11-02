# channel 使用

往通道中发送数据 channel <- 200

从通道读取数据并赋值 ret := <- channel

# 缓冲通道与无缓冲通道

缓冲通道:允许通道里存储一个或多个数据，设置了缓冲区后，发送端和接收端处于异步接收
的状态
channel :=make(chann int,10)

无缓冲通道:在通道里无法存储数据,这意味着，接收端必须先于发送端准备好，以确保你发送完数据后，有人立马接收数据，否则发送端就会造成阻塞，原因很简单，
信道中无法存储数据。也就是说发送端和接收端是同步运行的。

channel := make(chan int)
channel := make(chan int,0)

## 双向通道和单向通道

双向通道：可以发送数据，可以接收数据
单向通道: 通道只能接收或者发送数据

双向通道:

```go
import (
    "fmt"
    "time"
)

func main() {
    pipline := make(chan int)

    go func() {
        fmt.Println("准备发送数据: 100")
        pipline <- 100
    }()

    go func() {
        num := <-pipline
        fmt.Printf("接收到的数据是: %d", num)
    }()
    // 主函数sleep，使得上面两个goroutine有机会执行
    time.Sleep(time.Second)
}
```

单向通道:可以分为只读通道和只写通道
定义只读通道:

```go
var channel = make(chan int)
type Receiver = <-chan int // 关键代码：定义别名类型
var receiver Receiver = channel
```

定义只写通道:

```go
var channel = make(chan int)
type Sender = chan<- int  // 关键代码：定义别名类型
var sender Sender = channel
```

`<-chan`表示这个通道，只能从里发出数据，对于程序来说就是只读
`chan<-`表示这个通道，只能从那个外面接收数据，对于程序来说就是只写

通道本身就是为了传输数据而存在的，如果只有接收者或者只有发送者，
那通道就变成了只入不出或者只出不入了吗，没什么用。所以只读通道和只写通道，唇亡齿寒，缺一不可。

# 遍历通道
遍历通道，使用for加range关键字，在range时，要确保通道是否处于关闭状态。否则循环会
阻塞.

# 用通道来做锁
当通道里的数据量已经达到设定的容量时，此时再往里发送数据会阻塞整个程序。利用这个特性，可以
用它来当程序的锁

# 通道传递是深拷贝吗?
Go的数据结构可以分为两种:
值类型:String,Array,Int,Struct,Float,Bool
引用类型:Slice,Map
所以是否是深拷贝，取决于你传入的值是值类型还是引用类型。

# 注意事项
关闭一个未初始化的 channel 会产生 panic

重复关闭同一个 channel 会产生 panic

向一个已关闭的 channel 发送消息会产生 panic

从已关闭的 channel 读取消息不会产生 panic，且能读出 channel 中还未被读取的消息，若消息均已被读取，则会读取到该类型的零值。

从已关闭的 channel 读取消息永远不会阻塞，并且会返回一个为 false 的值，用以判断该 channel 是否已关闭（x,ok := <- ch）

关闭 channel 会产生一个广播机制，所有向 channel 读取消息的 goroutine 都会收到消息

channel 在 Golang 中是一等公民，它是线程安全的，面对并发问题，应首先想到 channel

