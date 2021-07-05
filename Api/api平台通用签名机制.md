## 通用API平台需要对每一个访问请求进行身份验证。

## 用户机制
API平台里的每一个用户有自己的uid。
每一个用户可以有一个或者多个appKey和appSecret。即一组appKey和appSecret标记一个应用。
其中appKey用来管理权限。【唯一】（24位随机字符串）（lumen里可以使用str_random()生成）
appSecret用来签名。（32位随机字符串）（lumen里可以使用str_random()生成）
appKey为每次请求必传的参数

##签名规则
排序请求字符串
对所有的请求参数，按照参数名称的字典顺序进行排序

##参数编码
对所有的请求参数的键值相连接然后进行RFC3986规则进行编码
编码规则为：
对于字符 A-Z、a-z、0-9 以及字符 - 、 _ 、 . 、 ~ 不编码。
对于其他字符编码成 %XY 的格式，其中 XY 是字符对应 ASCII 码的 16 进制表示。比如半角的双引号 ” 对应的编码就是 %22 。
对于扩展的 UTF-8 字符，编码成 %XY%ZA… 的格式。
需要说明的是半角的空格要被编码是 %20 ，而不是加号 + 。
注意：一般支持 URL 编码的库（比如 PHP 中的 urlencode ）都是按照 application/x-www-form-urlencoded 的 MIME 类型的规则进行编码。可以直接使用这类方式进行编码，把编码后的字符串中加号 + 替换成 %20 、星号 * 替换成 %2A 、 %7E 替换回波浪号 ~ ，即可得到上述规则描述的编码字符串。

构造用于计算签名的字符串
```php
StringToSign=
//get或者post
HTTPMethod +
编码后的参数
1
2
3
4
```
##计算HMAC值
按照 RFC2104 的定义，使用步骤 3 得到的字符串 StringToSign 计算签名 HMAC 值。
注意：计算签名时，使用的 Key 就是您的 appSecret，使用的哈希算法是 SHA1。
计算签名
按照 Base64 编码规则，把步骤 3 得到的 HMAC 值编码成字符串，即得到签名值（Signature）。
将签名作为signature参数添加到请求中
签名代码 PHP版本
```php
//1.排序参数
ksort($parameters);
//2.对参数进行URL编码
$paramsStr = '';
foreach ($parameters as $k => $v) {
$paramsStr .= $k . $v;
}
$res = urlencode($paramsStr);
$res = preg_replace('/\+/', '%20', $res);
$res = preg_replace('/\*/', '%2A', $res);
$res = preg_replace('/%7E/', '~', $res);
//3.构造计算签名的字符串
$stringToSign = $request->getMethod() . $res;
//4.计算HMAC值
$hmacStr = hash_hmac('sha1', $stringToSign, $appSecret, true);
//5.返回签名值
$signature = base64_encode($hmacStr);
```


