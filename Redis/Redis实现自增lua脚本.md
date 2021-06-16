```lua
 local current = redis.call('incr',KEYS[1]);
                local t = redis.call('ttl',KEYS[1]);
                if t == -1 then
                redis.call('expire',KEYS[1],ARGV[1])
                end;
                return current;
```
通过 INCR 和 EXPIRE 两个操作的保证原子性
