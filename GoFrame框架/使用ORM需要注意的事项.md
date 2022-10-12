# 1.需要在main.go文件手动引入mysql包

```go
package main

import (
	"github.com/gogf/gf/v2/os/gctx"

	_ "github.com/gogf/gf/contrib/drivers/mysql/v2" //就是这个

	"goframe-websocket/internal/cmd"
	_ "goframe-websocket/internal/logic"
	_ "goframe-websocket/internal/packed"
)

func main() {
	cmd.Main.Run(gctx.New())
}

//link https://github.com/gogf/gf/tree/master/contrib/drivers
```

#  查询单挑记录时传入Scan是一个指针变量,而不是赋值的指针
```go
func (s *sUser) GetUserByMobileAndPassword(ctx context.Context, mobile string, password string) (*entity.User, error) {
	var user *entity.User //声明一个指针变量
	get, _ := g.Cfg().Get(ctx, "jwt.key")
	key := get.Val().(string)
	password, _ = utils.Encrypt([]byte(password), []byte(key))
	err := dao.User.Ctx(ctx).Where(g.Map{
		dao.User.Columns().Mobile:   mobile,
		dao.User.Columns().Password: password,
	}).Scan(&user)
	return user, err
}

```