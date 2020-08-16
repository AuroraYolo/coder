1. 通过代码词法分析(re2c)和语义分析(Bison) 将php代码编辑为抽象语法树(AST)
2. 将抽象语法树 编译为 opcode数组 (zend_op_array)

- opcode其实就是zend定义的一个C的的结构性(struct) opcode中定义 变量的类型 存储和对应语句 执行方式 结果等
- pass_two 编译阶段很关键的一个操作就是确定了各个 变量、中间值、临时值、返回值、字面量 的 内存编号 
