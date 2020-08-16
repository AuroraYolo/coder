## MySQL SQL语句执行流程
![avatar](MySQL的逻辑架构图.png)

与MySQL查询流程一样,更新流程还涉及两个重要的日志模块,redo log(重做日志)和binlog(归档日志).


## redo log
如果每一次的的更新操作都需要写进磁盘,然后磁盘也要找到对应的那条记录,然后再更新,整个IO成本、查找成本很高.MySQL里使用的是
WAL技术,WAL的全称是Write-Ahead Logging.它的关键点是先写日志,再写磁盘.具体来说,当有一条记录需要更新的时候,InnoDB引擎就会先把记录写到redo log里面,
并更新内存.这个时候更新就算完成了.同时,InnoDB引擎会在适当的时候,将这个操作记录更新到磁盘里面,而这个更新往往是在系统比较空闲的时候做.

InnoDB的redo log是固定大小的,比如可以配置为一组4个文件,每个文件的大小是1GB,那么总共可以记录4GB的操作.从头开始写,写到末尾就又回到开头循环写.如图所示:
![avatar](redolog写日志方法图.png)
write pos是当前记录的位置,一边写一边往后移,写到第3号文件末尾后就回到0号文件开头.checkpoint是当前要擦除的位置,也是往后移并且循环的,擦除记录
前要把记录更新到数据文件.
有了redo log,InnoDB就可以保证即使数据库发送异常重启,之前提交的记录都不会丢失,这个能力成为crash-safe.

## bin log
redo log是InnoDB引擎特有的日志,而Server层也有自己的日志,称为binlog(归档日志).为什么有两份日志?因为最开始MySQL里并没有InnoDB引擎.
MySQL自带的引擎是MyISAM,但是MyISAM没有crash-safe的能力,binlog日志只能用于归档.而InnoDB是另一个公司以插件形式引入MySQL的,既然只依靠binlog
是没有crash-safe能力的,所以InnoDB使用redo log来实现crash-safe的能力.

## redo log和bin log的不同点
1.redo log是InnoDB引擎特有的;bin log是MySQL的Server层实现的,所有引擎可以使用.
2.redo log是物理日志,记录的是"在某个数据页上做了什么修改";binlog是逻辑日志,记录的是这个语句的原始逻辑.比如"给ID=2这一行的c字段加1".
3.redo log是循环写的,空间固定会用完;binlog是可以追加写入的."追加写"是指binlog文件写到一定大小后会切换到下一个.并不会覆盖一起的日志.

## InnoDB引擎执行更新语句时的内部流程
1.执行器先找到引擎取ID=2这一行.ID是主键,引擎直接用树搜索找到这一行.如果ID=2这一行所在的数据页本来就在内存中,就直接返回给执行器;否则,需要先从磁盘读入内存后再返回.
2.执行器拿到引擎给的行数据,把这个值加上1,比如原来是N,现在是N+1,得到新的一行数据,再调用引擎接口写入这行新数据.
3.引擎将这行数据更新到内存中,同时将这个更新操作记录到redo log里面,此时redo log处于prepare(预提交)状态.然后告知执行器执行完成了,随时可以提交事务.
4.执行器生成这个操作的binlog,并把binlog写入磁盘.
5.执行器调用引擎的提交事务交接口,引擎把刚刚写入的redo log改成提交(commit)状态,更新完成.将 redo log 的写入拆成了两个步骤：prepare和commit,这就是"两阶段提交"

## 两阶段提交
为了让两份日志之间的逻辑一致.




