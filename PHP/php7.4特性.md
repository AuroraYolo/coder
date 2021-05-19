# 数组解包
使用展开运算符... 解包数组
```php
function sum($a,$b,$c){
return $a+$b+$c;
}
$arr1  = [1];
## version >=7.4
sum(1,2,...$arr1);

## version < 7.4
sum(1,2,$arr1[0]);
```
