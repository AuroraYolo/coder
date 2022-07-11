````
缓存目录
jetbrains 系列产品的缓存目录分为两类：
配置文件目录
保存诸如快捷键、颜色主题、30天试用授权证书、自定义 jbr 运行时参数等等的 ide 用户配置信息，所以不能随意删除。删除后会重置程序初始安装状态。
临时文件目录
可以随意删除，其中包含缓存、本地文件修改修改、用于工程加速的 index 文件，这些文件的用途在于优化 ide 的速度，删除后ide 会根据需要重建的。
日志文件目录
保存 ide 运行的java日志、产品升级日志以及保存用于故障诊断信息的文件，体积比较小，就几 M而已。
配置文件目录¶
jetbrains 以 产品名年份.版本号 的格式来命名配置文件目录。如 pycharm 2021.1 的配置文件目录名称为 PyCharm2021.1。如果是 pycharm 2021.2版本，则对应的配置文件目录名称为 PyCharm2021.2。在不同的操作系统平台下，分别存放在以下用户目录下：

windows：%userprofile%/AppData/Roaming/JetBrains
macos: ~/Library/ApplicationSupport/JetBrains
linux: ~/.config/JetBrains
产生升级后，如 2021.1 升级到 2021.2，会生成新的对应目录，在升级成功后可以删除旧版本目录。

临时文件目录
与配置文件目录类似，具有相同的目录命名规则与固定的存储位置。

windows: %userprofile%/AppData/Local/JetBrains
macos: ~/Library/Caches/JetBrains
linux: ~/.cache/JetBrains/
同样，删除掉旧版本的目录即可。

日志文件目录
经过比较，日志文件的路径规则与配置文件目录、临时文件目录稍有不同：

windows: 在临时文件目录下的 log，如 %userprofile%/AppData/Local/JetBrains/WebStrom2021.1/log
macos: ~/Library/Caches/JetBrains，因体积不大，不需要关注，只是在卸载时，记得手工删除。
````