# Mysql 的case when 的语法:
1.简单函数
```
CASE [col_name] WHEN [value1] THEN [result1]…ELSE [default] END
```

2.搜索函数
```
CASE WHEN [expr] THEN [result1]…ELSE [default] END
```
# 简单函数
```
SELECT
	NAME '英雄',
	CASE NAME
		WHEN '德莱文' THEN
			'斧子'
		WHEN '德玛西亚-盖伦' THEN
			'大宝剑'
		WHEN '暗夜猎手-VN' THEN
			'弩'
		ELSE
			'无'
	END '装备'
FROM
	user_info;
```
![avatar](https://imgconvert.csdnimg.cn/aHR0cHM6Ly9pbWctYmxvZy5jc2RuLm5ldC8yMDE4MDMxOTE0MjgyMDM2NT93YXRlcm1hcmsvMi90ZXh0L0x5OWliRzluTG1OelpHNHVibVYwTDNGeFh6TXdNRE00TVRFeC9mb250LzVhNkw1TDJUL2ZvbnRzaXplLzQwMC9maWxsL0kwSkJRa0ZDTUE9PS9kaXNzb2x2ZS83MA?x-oss-process=image/format,png)
# 搜索函数
```
CASE WHEN [expr] THEN [result1]…ELSE [default] END：搜索函数可以写判断，并且搜索函数只会返回第一个符合条件的值，其他case被忽略
```
```
# when 表达式中可以使用 and 连接条件
SELECT
	NAME '英雄',
	age '年龄',
	CASE
		WHEN age < 18 THEN
			'少年'
		WHEN age < 30 THEN
			'青年'
		WHEN age >= 30
		AND age < 50 THEN
			'中年'
		ELSE
			'老年'
	END '状态'
FROM
	user_info;
```
![avatar](https://imgconvert.csdnimg.cn/aHR0cHM6Ly9pbWctYmxvZy5jc2RuLm5ldC8yMDE4MDMxOTE0MjkxMDkzP3dhdGVybWFyay8yL3RleHQvTHk5aWJHOW5MbU56Wkc0dWJtVjBMM0Z4WHpNd01ETTRNVEV4L2ZvbnQvNWE2TDVMMlQvZm9udHNpemUvNDAwL2ZpbGwvSTBKQlFrRkNNQT09L2Rpc3NvbHZlLzcw?x-oss-process=image/format,png)

# 聚合函数 sum 配合 case when 的简单函数实现多表 left join 的行转列

注：曾经有个爱学习的路人问我，“那个sum()只是为了好看一点吗？”，left join会以左表为主，连接右表时，得到所有匹配的数据，再group by时只会保留一行数据，因此case when时要借助sum函数，保留其他列的和。如果你还是不明白的话，那就亲手实践一下，只保留left join看一下结果，再group by，看一下结果。例如下面的案例：学生表/课程表/成绩表 ，三个表left join查询每个学生所有科目的成绩，使每个学生及其各科成绩一行展示。

```
SELECT
	st.stu_id '学号',
	st.stu_name '姓名',
	sum(
		CASE co.course_name
		WHEN '大学语文' THEN
			sc.scores
		ELSE
			0
		END
	) '大学语文',
	sum(
		CASE co.course_name
		WHEN '新视野英语' THEN
			sc.scores
		ELSE
			0
		END
	) '新视野英语',
	sum(
		CASE co.course_name
		WHEN '离散数学' THEN
			sc.scores
		ELSE
			0
		END
	) '离散数学',
	sum(
		CASE co.course_name
		WHEN '概率论与数理统计' THEN
			sc.scores
		ELSE
			0
		END
	) '概率论与数理统计',
	sum(
		CASE co.course_name
		WHEN '线性代数' THEN
			sc.scores
		ELSE
			0
		END
	) '线性代数',
	sum(
		CASE co.course_name
		WHEN '高等数学' THEN
			sc.scores
		ELSE
			0
		END
	) '高等数学'
FROM
	edu_student st
LEFT JOIN edu_score sc ON st.stu_id = sc.stu_id
LEFT JOIN edu_courses co ON co.course_no = sc.course_no
GROUP BY
	st.stu_id
ORDER BY
	NULL;

```
![avatar](https://imgconvert.csdnimg.cn/aHR0cHM6Ly9pbWctYmxvZy5jc2RuLm5ldC8yMDE4MDMxOTE1MDg0MTkwNT93YXRlcm1hcmsvMi90ZXh0L0x5OWliRzluTG1OelpHNHVibVYwTDNGeFh6TXdNRE00TVRFeC9mb250LzVhNkw1TDJUL2ZvbnRzaXplLzQwMC9maWxsL0kwSkJRa0ZDTUE9PS9kaXNzb2x2ZS83MA?x-oss-process=image/format,png)

## 测试数据
```
-- 创建表  学生表
CREATE TABLE `edu_student` (
	`stu_id` VARCHAR (16) NOT NULL COMMENT '学号',
	`stu_name` VARCHAR (20) NOT NULL COMMENT '学生姓名',
	PRIMARY KEY (`stu_id`)
) COMMENT = '学生表' ENGINE = INNODB;

-- 课程表 
CREATE TABLE `edu_courses` (
	`course_no` VARCHAR (20) NOT NULL COMMENT '课程编号',
	`course_name` VARCHAR (100) NOT NULL COMMENT '课程名称',
	PRIMARY KEY (`course_no`)
) COMMENT = '课程表' ENGINE = INNODB;

-- 成绩表
CREATE TABLE `edu_score` (
	`stu_id` VARCHAR (16) NOT NULL COMMENT '学号',
	`course_no` VARCHAR (20) NOT NULL COMMENT '课程编号',
	`scores` FLOAT NULL DEFAULT NULL COMMENT '得分',
	PRIMARY KEY (`stu_id`, `course_no`)
) COMMENT = '成绩表' ENGINE = INNODB;

-- 插入数据

-- 学生表数据

INSERT INTO edu_student (stu_id, stu_name)
VALUES
	('1001', '盲僧'),
	('1002', '赵信'),
	('1003', '皇子'),
	('1004', '寒冰'),
	('1005', '蛮王'),
	('1006', '狐狸');

-- 课程表数据 
INSERT INTO edu_courses (course_no, course_name)
VALUES
	('C001', '大学语文'),
	('C002', '新视野英语'),
	('C003', '离散数学'),
	(
		'C004',
		'概率论与数理统计'
	),
	('C005', '线性代数'),
	('C006', '高等数学');

-- 成绩表数据
INSERT INTO edu_score (stu_id, course_no, scores)
VALUES
	('1001', 'C001', 67),	('1002', 'C001', 68),	('1003', 'C001', 69),	('1004', 'C001', 70),	('1005', 'C001', 71),
	('1006', 'C001', 72),	('1001', 'C002', 87),	('1002', 'C002', 88),	('1003', 'C002', 89),	('1004', 'C002', 90),
	('1005', 'C002', 91),	('1006', 'C002', 92),	('1001', 'C003', 83),	('1002', 'C003', 84),	('1003', 'C003', 85),
	('1004', 'C003', 86),	('1005', 'C003', 87),	('1006', 'C003', 88),	('1001', 'C004', 88),	('1002', 'C004', 89),
	('1003', 'C004', 90),	('1004', 'C004', 91),	('1005', 'C004', 92),	('1006', 'C004', 93),	('1001', 'C005', 77),
	('1002', 'C005', 78),	('1003', 'C005', 79);

```
