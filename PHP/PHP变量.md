## 变量结构
```
struct _zval_struct {
	union {
		long lval;
		double dval;
		struct {
			char *val;
			int len;
		} str;
		HashTable *ht;
		zend_object_value obj;
	} value;					//变量value值
	zend_uint refcount__gc;   //引用计数内存中使用次数，为0删除该变量
	zend_uchar type;		   //变量类型
	zend_uchar is_ref__gc;    //区分是否是引用变量，是引用为1，否则为0
};
```

## 变量类型
```
zval.value.lval => 整型、布尔型、资源
zval.value.dval => 浮点型
zval.value.str  => 字符串
zval.value.*ht  => 数组
zval.value.obj  => 对象
```
## 变量名和变量容器关联

每个变量的变量名和指向zval结构的指针被存储在哈希表内，以此实现了变量名到变量容器的映射
## 变量作用域

全局变量被存储到了全局符号表内，而局部变量也就是指函数或对象内的变量，则被存储到了活动符号表内（每个函数或对象都单独维护了自己的活动符号表。活动符号表的生命周期，从函数或对象被调用时开始，到调用完成时结束）

## 变量销毁
变量销毁，分为以下几种情况：

1.、手动销毁

2.、垃圾回收机制销毁（引用计数清0销毁和根缓冲区满后销毁）

我们这次主要讲一下手动销毁，即unset，每次销毁时都会将符号表内的变量名和对应的zval结构进行销毁，并将对应的内存归还到php所维护的内存池内（按内存大小划分到对应内存列表中）
