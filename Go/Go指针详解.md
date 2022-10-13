# 指针的创建

1.先定义对应的变量，再通过变量取得内存地址，创建指针

```go
// 定义普通变量
aint := 1
// 定义指针变量
ptr := &aint //获取内存地址
```

2.先创建指针，分配好内存后，再给指针指向的内存地址写入对应的值

```go

// 创建指针
astr := new(string)  //用new创建并返回指针
// 给指针赋值
*astr = "Go编程时光"
fmt.Println(*astr) //用*符号获取指针变量值
```

3.先声明一个指针变量，再从其他变量取得内存地址赋值给它

```go
aint := 1
	var bint *int // 声明一个指针
	bint = &aint  // 初始化
	fmt.Println(bint)  //0xc000020098
	fmt.Println(*bint)  //1
	fmt.Println(&aint)  //0xc000020098
```

# & 和 *用法

`&` ：从一个普通变量中取得内存地址

`*`：当*在赋值操作符（=）的右边，是从一个指针变量中取得变量值，当*在赋值操作符（=）的左边，是指该指针指向的变量

```go

package main

import "fmt"

func main() {
    aint := 1     // 定义普通变量
    ptr := &aint  // 定义指针变量
    fmt.Println("普通变量存储的是：", aint) //1
    fmt.Println("普通变量存储的是：", *ptr) //1
    fmt.Println("指针变量存储的是：", &aint) //0xc0000100a0
    fmt.Println("指针变量存储的是：", ptr)   //0xc0000100a0
}
```

# 指针类型

```go
package main

import "fmt"

func main() {
	astr := "hello"
	aint := 1
	abool := false
	arune := 'a'
	afloat := 1.2
	astruct := struct {
	}{}
	afunc := func(op int) int {
		return op
	}

	fmt.Printf("astr 指针类型是：%T\n", &astr)
	fmt.Printf("aint 指针类型是：%T\n", &aint)
	fmt.Printf("abool 指针类型是：%T\n", &abool)
	fmt.Printf("arune 指针类型是：%T\n", &arune)
	fmt.Printf("afloat 指针类型是：%T\n", &afloat)
	fmt.Printf("astruct 指针类型是：%T\n", &astruct)
	fmt.Printf("afunc 指针类型是：%T\n", &afunc)
	//astr 指针类型是：*string
     //   aint 指针类型是：*int
    // abool 指针类型是：*bool
   //  arune 指针类型是：*int32
   // afloat 指针类型是：*float64
   // astruct 指针类型是：*struct {}
   // afunc 指针类型是：*func(int) int

}

```

# [原文链接](https://golang.iswbm.com/c01/c01_07.html)