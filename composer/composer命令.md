# show
先说下 show 命令。它允许您查看项目的所有已安装包(包括依赖项)，以及查看相关包的说明。所有这些信息都可以在Composer锁文件(composer.lock)中找到, 但是使用 show 命令相对来说是一种更简单、更方便的一种查看包信息的方法。

要列出所有已安装的包及其版本号和说明，只需使用 show:

```bash
composer show
```
有时候把这些信息用依赖关系树的形式查看会更容易理解， 可以通过 --tree or -t 参数:
```bash
composer show -t
```
如果要筛选返回的包，可以使用通配符传递一个额外的字符串参数 *:
```bash
composer show 'symfony/*'
```
这将返回所有已安装的symfony包。注意这里的引号, 如果您使用的是 bash shell，不需要加这个引号, 但是如果您使用的是 zsh 你不用引号的话就会报 ‘no matches found’ 错误。

如果要查看有关特定包的信息，需要完整包名:
```bash
composer show laravel/framework
```
这将向您显示安装的版本、它的许可证和依赖项以及它在本地安装的位置等信息。

# why
如果您想知道安装特定软件包的原因，可以使用 why 命令来确定哪些依赖项需要它：
```bash
composer why vlucas/phpdotenv
```
why 为什么是depends命令的别名，但就我个人而言，我发现使用 ‘why’ 更容易记住。您可以使用--tree或-t标志在依赖树中查看此信息：
```bash
composer why vlucas/phpdotenv -t
```
# why-not
有时，一个或多个已安装的软件包将阻止安装或更新软件包。 为了检查是哪些安装包，我们可以使用 why-not 命令（别名为 prohibits）。 例如，Laravel 最近发布了一个新的5.8版本的框架; 我们可以使用 why-not 命令检查任何阻止我们更新 laravel/framework 包的包：
```bash
composer why-not laravel/framework 5.8
```
同样，我们可以使用 --tree 或 -t 标记在依赖关系树中查看此信息：
```bash
composer why-not laravel/framework 5.8 -t
```
# outdated
在使用 composer update 命令前，你也许想检测一下已安装的包，哪些有可以升级的。这可以使用 outdated 命令。
```bash
composer outdated
```
此命令是 composer show -lo 的别名之一。

根据语义化的版本，返回着色的代码，来标明每个包的状态：

Green: 当前安装包已是最新版本
Yellow: 有可升级的更新, 但可能有不兼容的修改。
Red: 有可用的小版本升级 (一般是bug修复)
如果希望高亮显示小的升级版本, 可以使用 outdated 命令，以--minor-only 或者 -m 参数 ：

# composer outdated -m
状态
我发现自己经常会使用 install 、update 命令的参数 --prefer-source 来处理源代码安装的依赖项。 然后，如果我修改了任何这些依赖项，我需要一种快速检查哪些包已被修改的方法。 status 命令提供了一种方便的方法。

您可以使用 --verbose 或 -v 参数来查看本地修改的软件包和文件：
```bash
composer status -v
```
我发现使用 verbose 标记是使用此命令最有用的方法。

许可
最后，知道您安装的每个软件包的许可证是非常有用的。 Composer 有一个方便的 licenses 命令，用于查询许可的完整列表：
```bash
composer licenses
```
