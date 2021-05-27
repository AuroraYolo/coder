```go
package main

import "fmt"

/*
func GetNumber() int {
	return 100
}

const num = GetNumber()
*/
/*
GetNumber() 只有在运行期才能知道返回结果，在编译期并不能确定，所以无法作为常量定义的右值。

此外常量之所以叫常量意思是它的值是恒定不变的，如果你试图在运行时修改常量的值，则会在编译期报错
*/
/*
func main() {
	const Pi float64 = 3.1445454545
	const zero = 0.0 // 无类型浮点常量
	const (  // 通过一个 const 关键字定义多个常量，和 var 类似
		size int64 = 1024
		eof        = -1
	)
	const u, v float32 = 0, 3  // u = 0.0, v = 3.0，常量的多重赋值
	const ab, b, c = 3, 4, "foo" // a = 3, b = 4, c = "foo", 无类型整型和字符串常量
	// 打印上述变量值
	fmt.Printf("Pi: %v\n", Pi)
	fmt.Printf("zero: %v\n", zero)
	fmt.Printf("size: %v\n", size)
	fmt.Printf("eof: %v\n", eof)
	fmt.Printf("u: %v\n", u)
	fmt.Printf("v: %v\n", v)
	fmt.Printf("ab: %v\n", ab)
	fmt.Printf("b: %v\n", b)
	fmt.Printf("c: %v\n", c)
}
 */
/*
func main()  {
	//在每一个 const 关键字出现时被重置为 0,然后在下一个 const 出现之前，每出现一次 iota，其所代表的数字会自动增 1
	const (    // iota 被重置为 0
		c0 = iota   // c0 = 0
		c1 = iota   // c1 = 1
		c2 = iota   // c2 = 2
	)

	const (
		u = iota * 2 // u = 0
		v = iota * 2 // v = 2
		w = iota * 2 // w = 4
	)

	const x = iota // x = 0
	const y = iota // y = 0

	fmt.Printf("c0: %v\n", c0)
	fmt.Printf("c1: %v\n", c1)
	fmt.Printf("c2: %v\n", c2)
	fmt.Printf("u: %v\n", u)
	fmt.Printf("v: %v\n", v)
	fmt.Printf("w: %v\n", w)
	fmt.Printf("x: %v\n", x)
	fmt.Printf("y: %v\n", y)
}

 */
//如果两个 const 的赋值语句的表达式是一样的，那么还可以省略后一个赋值表达式。因此，上面的前两个 const 语句可简写为：
const (
	c0 = iota
	c1
	c2
)

const (
	u = iota * 2
	v
	w
)

func main()  {
	fmt.Printf("c0: %v\n", c0)
	fmt.Printf("c1: %v\n", c1)
	fmt.Printf("c2: %v\n", c2)
	fmt.Printf("u: %v\n", u)
	fmt.Printf("v: %v\n", v)
	fmt.Printf("w: %v\n", w)
}

```