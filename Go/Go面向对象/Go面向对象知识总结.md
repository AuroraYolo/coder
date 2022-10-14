# Go支持继承，不支持重写方法

````go
package extension_test

import (
	"fmt"
	"testing"
)

type Pet struct {
}

func (p *Pet) Speak() {
	fmt.Printf("....")
}

func (p *Pet) SpeakTo(host string) {
	p.Speak() //这里只能调用的是Pet本类的Speak()方法，不像php支持overload可以用子类重写该方法
	fmt.Println(" ", host)
}

type Dog struct {
	Pet  //可以使用dog.SpeakTo()调用的是Pet里的方法
}

func (d *Dog) Speak() {
	fmt.Printf("Wang!")
}

func TestDog(t *testing.T) {
	dog := new(Dog)
	dog.SpeakTo("Chao")
}
````

# Go通过接口实现多态

先定义一个商品（Good）的接口，意思是一个类型或者结构体，只要实现了settleAccount() 和 orderInfo() 两个方法，那这个类型/结构体就是一个商品。

```go
package main

import (
    "fmt"
    "strconv"
)

// 定义一个商品接口
type Good interface {
    settleAccount() int //定义计算订单金额接口
    orderInfo() string  //定义获取商品订单信息
}
//商品为手机
type Phone struct {
    name string
    quantity int
    price int
}
//实现计算订单金额
func (phone Phone) settleAccount() int {
    return phone.quantity * phone.price
}
//实现获取订单信息
func (phone Phone) orderInfo() string{
    return "您要购买" + strconv.Itoa(phone.quantity)+ "个" +
        phone.name + "计：" + strconv.Itoa(phone.settleAccount()) + "元"
}
//商品为一个赠品
type FreeGift struct {
    name string
    quantity int
    price int
}
//订单金额为0
func (gift FreeGift) settleAccount() int {
    return 0
}
//获取订单信息
func (gift FreeGift) orderInfo() string{
    return "您要购买" + strconv.Itoa(gift.quantity)+ "个" +
        gift.name + "计：" + strconv.Itoa(gift.settleAccount()) + "元"
}

func calculateAllPrice(goods []Good) int {
    var allPrice int
    for _,good := range goods{
        fmt.Println(good.orderInfo())
        allPrice += good.settleAccount()
    }
    return allPrice
}
func main()  {
    iPhone := Phone{
        name:     "iPhone",
        quantity: 1,
        price:    8000,
    }
    earphones := FreeGift{
        name:     "耳机",
        quantity: 1,
        price:    200,
    }

    goods := []Good{iPhone, earphones}
    allPrice := calculateAllPrice(goods)
    fmt.Printf("该订单总共需要支付 %d 元", allPrice)
}
//输出
//您要购买1个iPhone计：8000元
//您要购买1个耳机计：0元
//该订单总共需要支付 8000 元
```

# 面向对象:结构体里的Tag用法(用于定义元数据)

## JSON标签

JSON字符串是我们常用的数据传输格式，由一组k-v键值对组成，很多时候，我们需要将接收到的JSON串与我们规定好的数据结构体绑定，方便直接调用，JSON标签能很便捷的完成这一工作,这些标签能被encoding/json包中的编码与解码工具解析。

| Tag                               |                                          作用 |
|:----------------------------------|--------------------------------------------:|
| "json_name"                       | 将结构体的属性与json_name的对应（可以省略，与属性同名，且会在名字后面加 s） |
| "-"                               |                             说明结构体的该属性不参与序列化 | 
| "json_name,omitempy"              |                        如果为类型零值或空值，序列化时忽略该字段 | 
| "json_name,string[number｜boolen]" |              指定属性的类型，支持string、number、boolen | 

```go

type Student struct { 
    ID int `json:"-"` // 该字段不进行序列化 
    Class int `json:"class"` // 该字段与class对应
    Name string `json:"name,omitempy"` // 如果为类型零值或空值，序列化时忽略该字段 
    Age int `json:"age,string"` // 指定类型，支持string、number、boolen 
}


package main

import (
	"encoding/json"
	"fmt"
)

type Person struct {
	Name    string `json:"name"`
	Age     int    `json:"age"`
	Address string `json:"address,omitempty"`
}

func main() {
	p1 := Person{
		Name: "Jack",
		Age:  22,
	}

	data1, err := json.Marshal(p1)
	if err != nil {
		panic(err)
	}

	// p1 没有 Addr，就不会打印了
	fmt.Printf("%s\n", data1)

	// ================

	p2 := Person{
		Name:    "Jack",
		Age:     22,
		Address: "China,Japan",
	}

	data2, err := json.Marshal(p2)
	if err != nil {
		panic(err)
	}

	// p2 则会打印所有
	fmt.Printf("%s\n", data2)
}

```
