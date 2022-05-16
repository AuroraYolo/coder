# lldb-php

```bash
➜  websocket-server git:(main) ✗ lldb -- php bin/swow-cloud server:start

(lldb) target create "php"
Current executable set to 'php' (x86_64).
(lldb) settings set -- target.run-args  "bin/swow-cloud" "server:start"
(lldb) bt
error: invalid process
(lldb) r
Process 8820 launched: '/Users/heping/.phpbrew/php/php-8.1.5/bin/php' (x86_64)
 ------------------ ------------- -------------- -------------
  APP_NAME           PHP_VERSION   SWOW_VERSION   APP_VERSION
 ------------------ ------------- -------------- -------------
  WEBSOCKET_SERVER   8.1.5         0.1.0          0.1
 ------------------ ------------- -------------- -------------

 ____                             ____ _                 _
/ ___|_      _______      __     / ___| | ___  _   _  __| |
\___ \ \ /\ / / _ \ \ /\ / /____| |   | |/ _ \| | | |/ _` |
 ___) \ V  V / (_) \ V  V /_____| |___| | (_) | |_| | (_| |
|____/ \_/\_/ \___/ \_/\_/       \____|_|\___/ \__,_|\__,_|
WebSocket For Swow-Cloud
===================================

If You Want To Exit, You Can Press Ctrl + C To Exit#.
====================================================
[DEBUG] Websocket-Server Start Successfully#
[DEBUG] [WebSocket] current connections#[0] [2022-05-16 17:13:20]
[DEBUG] [WebSocket] current connections#[0] [2022-05-16 17:13:30]
[DEBUG] [WebSocket] send to #16
^ Swow\Http\WebSocketFrame^ {#262
  opcode: 1
  fin: true
  rsv1: false
  rsv2: false
  rsv3: false
  mask: false
  payload_length: 42
  payload_data: Swow\Http\Buffer^ {#292
    value: "Session:[16] broadcast message You said: 1"
    size: 8192
    length: 42
    offset: 42
  }
}
Process 8820 stopped
* thread #1, queue = 'com.apple.main-thread', stop reason = EXC_BAD_INSTRUCTION (code=EXC_I386_INVOP, subcode=0x0)
    frame #0: 0x0000000100872ffc php`ZEND_FE_FETCH_R_SPEC_VAR_HANDLER + 444
php`ZEND_FE_FETCH_R_SPEC_VAR_HANDLER:
->  0x100872ffc <+444>: ud2
    0x100872ffe <+446>: jmp    0x100873003               ; <+451>
    0x100873003 <+451>: cmpl   $0x0, -0x184(%rbp)
    0x10087300a <+458>: setne  %al
Target 0: (php) stopped.
(lldb) bt
* thread #1, queue = 'com.apple.main-thread', stop reason = EXC_BAD_INSTRUCTION (code=EXC_I386_INVOP, subcode=0x0)
  * frame #0: 0x0000000100872ffc php`ZEND_FE_FETCH_R_SPEC_VAR_HANDLER + 444
    frame #1: 0x00000001007ca2bd php`execute_ex + 93
    frame #2: 0x0000000100743baf php`zend_call_function + 7007
    frame #3: 0x0000000102510dab swow.so`swow_coroutine_function(zdata=0x0000000000000000) at swow_coroutine.c:265:16
    frame #4: 0x000000010256471e swow.so`cat_coroutine_context_function(transfer=(from_context = 0x0000000103bb3510, data = 0x0000000000000000)) at cat_coroutine.c:395:12
    frame #5: 0x000000010258d22f swow.so`trampoline at make_x86_64_sysv_macho_gas.S:69
(lldb) p (int) zend_get_executed_lineno();
(int) $0 = 93
(lldb) p (char *) zend_get_executed_filename();
(char *) $1 = 0x000000010593a5c8 "/Users/heping/swow-cloud/websocket-server/vendor/symfony/var-dumper/Caster/Caster.php"
(lldb)

```

# 步骤
1.lldb -- php bin/swow-cloud server:start

2.r

3.bt

4.p (int) zend_get_executed_lineno(); //获取错误行号

5.p (char *) zend_get_executed_filename(); //获取错误文件
