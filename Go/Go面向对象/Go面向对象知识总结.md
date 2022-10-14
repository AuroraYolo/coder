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

# 面向对象:结构体里的Tag用法
