## 一般的SQL更新语句:
UPDATE mytable SET myfield = 'value' WHERE other_field = 'other_value';
## 如果更新同一字段为同一个值
UPDATE mytable set myfield ='value' WHERE other_field IN('other_values');
## 批量更新方案
CASE WHEN 
UPDATE mytable SET 
              myfield = CASE id 
              WHEN 1 THEN 'value'
              WHEN 2 THEN 'value'
              WHEN 3 THEN 'value'
        END,
              myfield1 = CASE id
              WHEN 1 THEN 'value1'
              WHEN 2 THEN 'value2'
              WHEN 3 THEN 'value3'
        END
WHERE id IN (1,2,3)
SQL的意思是更新myfield字段当id为1的时候值为value......,更新myfield1字段当id为1的时候
值为'value1'....
              
                