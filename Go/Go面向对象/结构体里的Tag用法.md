```go

type Person struct {
    Name string `json:"name"`
    Age  int    `json:"age"`
    Addr string `json:"addr,omitempty"`
}
```

由于 Person 结构体里的 Addr 字段有 omitempty 属性，因此 encoding/json 在将对象转化 json 字符串时，只要发现对象里的 Addr 为
false， 0， 空指针，空接口，空数组，空切片，空映射，空字符串中的一种，就会被忽略。