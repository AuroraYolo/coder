# # 给struct结构体定义行为(方法时),推荐使用指针传递对象避免内存拷贝

```golang
package main

type Employee struct {
  Id string
  Name string
  Age int
}
//第⼀种定义⽅式在实例对应⽅法被调⽤时，实例的成员会进⾏值复制
func (e Emplyoee) String {
return fmt.Sprintf("ID:%s-Name:%s-Age:%d", e.Id, e.Name, e.Age)
}
//通常情况下为了避免内存拷⻉我们使⽤第⼆种定义⽅式
func (e *Emplyoee) string {
 return fmt.Sprintf("ID:%s/Name:%s/Age:%d", e.Id, e.Name, e.Age)
}


```

# `*c` 是获取指针变量值，如果后面跟上`=`是给指针变量赋值。`&c` 是获取内存地址