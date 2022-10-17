# 使用go install下载的包存储的路径

$GOPATH/pkg

# go.mod文件

# go.mod 的内容理解

第一行：模块的引用路径

第二行：项目使用的 go 版本

第三行：项目所需的直接依赖包及其版本

``````go

module github.com/BingmingWong/module-test

go 1.14

require (
    example.com/apple v0.1.2
    example.com/banana v1.2.3
    example.com/banana/v2 v2.3.4
    example.com/pear // indirect
    example.com/strawberry // incompatible
)

exclude example.com/banana v1.2.4
replace（
    golang.org/x/crypto v0.0.0-20180820150726-614d502a4dac => github.com/golang/crypto v0.0.0-20180820150726-614d502a4dac
    golang.org/x/net v0.0.0-20180821023952-922f4815f713 => github.com/golang/net v0.0.0-20180826012351-8a410e7b638d
    golang.org/x/text v0.3.0 => github.com/golang/text v0.3.0
)
``````

`exclude： 忽略指定版本的依赖包`

`replace：由于在国内访问golang.org/x的各个包都需要翻墙，你可以在go.mod中使用replace替换成github上对应的库`

# go.sum文件

每一行都是由 模块路径，模块版本，哈希检验值 组成，其中哈希检验值是用来保证当前缓存的模块不会被篡改。hash 是以h1:
开头的字符串，表示生成checksum的算法是第一版的hash算法（sha256）

go.mod 和 go.sum 是 go modules 版本管理的指导性文件，因此 go.mod 和 go.sum 文件都应该提交到你的 Git
仓库中去，避免其他人使用你写项目时，重新生成的go.mod 和 go.sum 与你开发的基准版本的不一致

# go mod命令的使用

1. go mod init:初始化go mod,生成go.mod文件，后可接参数指定module名
2. go mod download :手动触发下载依赖包到本地cache($GOPATH/pkg/mod)目录
3. go mod graph：打印项目的模块依赖结构
4. go mod tidy:添加缺少的包，且删除无用的包
5. go mod verify:校验模块是否被篡改过
6. go mod why:查看为什么需要依赖
7. go mod vendor:导出项目所有依赖到vendor下
8. go mod edit：编辑go.mod文件，接- fmt参数格式化go.mod文件，接-require=golang.org/x/text 添加依赖，接
   -droprequire=golang.org/x/text 删除依赖
9. go list -m -json all：以 json 的方式打印依赖详情
10. 如何添加依赖使用go install,go get下载安装，自动写入go.mod