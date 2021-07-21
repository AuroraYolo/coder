## 使用strlen和mb_strlen这两个函数时，注意文件编码、数据库编码、浏览器编码，三码合一
```
1.strlen() 和 mb_strlen()共同点：
2.strlen( $str ) 和 mb_strlen( $str [,encoding ] )都是：求字符串长度的函数。
3.strlen不能设置编码类型；mb_strlen可以设置字符串编码类型（根据第二个参数）。
4.strlen() 和 mb_strlen()之间的区别：
5.strlen计算字符时，对utf-8中文字符是长度为3。（默认使用内部编码；如果内码使用的时gbk或gb2312那么，中文字符长度为2）
6.mb_strlen函数在使用时，需要加载php_mbstring.dll模块（就是在php.ini中开启extension=php_mbstring.dll），否则运行时会出现未定义函数。
7.mb_strlen函数，选择utf8为内码时，中文字符当作长度为1来计算。（关于mb_strlen在处理乱码，就是除了内码外的编码（文件编辑器的编码），这里使用gbk就会出现乱码）
```
```php
<?php
$str = "你好a中国world!";
echo strlen( $str ), "<br>";     //> 19
echo mb_strlen( $str , 'utf8');  //> 11
echo mb_strlen( $str, 'gbk' );   //> 13 
echo mb_strlen( $str, 'gb2312' );//> 13
echo mb_strlen( $str ); //> 默认使用内部编码（这里时utf-8） 11
?>
```
```
这里的utf8，得到预期的结果为4+7=11（4个中文+7个英文）
gbk 和 gb2312 得到13，这时什么意思？？？（出现了乱码）
strlen或mb_strlen在处理汉字时，出现解析错误，得到的是字符串所占的字节数。（上面的gbk和gb2312就是这种原因造成的；由于默认内部编码为utf-8，所以出现解析错误。）

这里strlen、mb_strlen默认使用的编码，就是编辑器文件的编码。
如何获取当前文件内码：
php的内置函数 mb_internal_encoding()，该函数会返回一个字符串。
```
```php
<?php
echo mb_internal_encoding();  //> "UTF-8" 没有参数时，返回内部默认编码
# 使用mb_internal_encoding($encoding)设置内部默认编码。
//> 获取文件内部默认编码
echo mb_internal_encoding(), "<br>";
dump( mb_internal_encoding("GB2312"), "<br>");
echo mb_internal_encoding();
$str = "你好中国";
echo "<br>", mb_strlen( $str );
```
运行结果：
```
UTF-8
bool(true)
EUC-CN
7
```
```
这里mb_strlen( $str )得到7，是由于编辑器的编码是utf-8。如果我们改掉编辑器编码为GB2312编码的到的是4。（可以知道，在没有乱码（三码合一），中文字符在被mb_strlen处理时是当做1计算。)
strlen( $str )：计算时，使用的编码以文件的编码为准（如果文件为gbk那么一个汉字为2；utf-8那么一个汉字为3）
mb_internal_encoding( [encoding] )：设置编码，默认返回true（设置成功）/false（设置失败）。
strlen()和mb_strlen()函数的组合应用：
这两个函数联合计算出一个中英文混排的串是多少（一个中文字符的占位是2，英文字符是1）
$str = "你好a中国world!";
echo (strlen( $str ) + mb_strlen( $str, 'utf8' ))/2; //>15
"你好a中国world!" 的strlen($str)是19，mb_strlen($str,'utf8')是11，"你好a中国world!"的占位是15 （4*2+7）
```
```
总结：
strlen、mb_strlen在使用时，最好设置三码合一。
如果所有的编码都是一致的，那么：
strlen获取的是字符串的内部字节。（gbk、gb2312等，一个汉字为2；utf-8，一个汉字为3。英文下的字母或符号都是为1）
mb_strlen获取的是指定编码下的字符数（前提是指定编码需要和文件编码一致）
如果文件编码和设置的编码不一致：
在使用strlen时，默认使用文件编码计算（如：文件编码为utf-8，每个汉字就为3）
mb_strlen在处理汉字会出现乱码的情况。
mb_internal_encoding([encoding])：可以设置/获取，当前文件的编码。
```
作者：余生无解
链接：https://www.jianshu.com/p/a180dd9048a8

