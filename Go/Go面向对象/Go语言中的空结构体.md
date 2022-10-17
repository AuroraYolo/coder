#  没有对象属性的结构体就是一个空结构体

# 空结构体不占用空间

# 基于空结构不占用内存空间这个特性,可以用channel控制并发时,只是需要一个信号，但并不需要传递值。
```go
func main() {
    ch := make(chan struct{}, 1)
    go func() {
        <-ch
        // do something
    }()
    ch <- struct{}{}
    // ...
}

```