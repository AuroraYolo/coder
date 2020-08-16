以new PhpDocumentor\Reflection\Element(),PHP会通过SPl_autoload_register 调用 loadClass -> findFile -> findFileWithExtension。步骤如下：

 - 将 \ 转为文件分隔符/，加上后缀php，变成 $logicalPathPsr4, 即 phpDocumentor/Reflection//Element.php;
 - 利用命名空间第一个字母p作为前缀索引搜索 prefixLengthsPsr4 数组，查到下面这个数组：
```
        p' => 
            array (
                'phpDocumentor\\Reflection\\' => 25,
                'phpDocumentor\\Fake\\' => 19,
          )
```
 - 遍历这个数组，得到两个顶层命名空间 phpDocumentor\Reflection\ 和 phpDocumentor\Fake\
 - 在这个数组中查找 phpDocumentor\Reflection\Element，找出 phpDocumentor\Reflection\ 这个顶层命名空间并且长度为25。
 - 在prefixDirsPsr4 映射数组中得到phpDocumentor\Reflection\ 的目录映射为：
```
    'phpDocumentor\\Reflection\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpdocumentor/reflection-common/src',
            1 => __DIR__ . '/..' . '/phpdocumentor/type-resolver/src',
            2 => __DIR__ . '/..' . '/phpdocumentor/reflection-docblock/src',
        ),
```     
- 遍历这个映射数组，得到三个目录映射；
- 查看 “目录+文件分隔符//+substr(&dollar;logicalPathPsr4, &dollar;length)”文件是否存在，存在即返回。这里就是
'__DIR__/../phpdocumentor/reflection-common/src + substr(phpDocumentor/Reflection/Element.php,25)'
- 如果失败，则利用 fallbackDirsPsr4 数组里面的目录继续判断是否存在文件


## 主要原理是通过spl_autoload_register注册类，然后使用的时候，根据一定的规则去获取该类.
