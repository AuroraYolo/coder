## 问题
```
在 mac 下执行 brew update 时，报如下错误：

Error:
homebrew-core is a shallow clone.
homebrew-cask is a shallow clone.
To `brew update`, first run:
git -C /usr/local/Homebrew/Library/Taps/homebrew/homebrew-core fetch --unshallow
git -C /usr/local/Homebrew/Library/Taps/homebrew/homebrew-cask fetch --unshallow
These commands may take a few minutes to run due to the large size of the repositories.
This restriction has been made on GitHub's request because updating shallow
clones is an extremely expensive operation due to the tree layout and traffic of
Homebrew/homebrew-core and Homebrew/homebrew-cask. We don't do this for you
automatically to avoid repeatedly performing an expensive unshallow operation in
CI systems (which should instead be fixed to not use shallow clones). Sorry for
the inconvenience!
```
## 解决
````
解决时本来很简单，只需按上述提示执行相应命令即可：

git -C /usr/local/Homebrew/Library/Taps/homebrew/homebrew-core fetch --unshallow
git -C /usr/local/Homebrew/Library/Taps/homebrew/homebrew-cask fetch --unshallow
但是默认关联 git 仓库是国外的，速度慢，还经常被墙，导致 early EOF 之类的错误：

git -C /usr/local/Homebrew/Library/Taps/homebrew/homebrew-core fetch --unshallow
remote: Enumerating objects: 365476, done.
remote: Counting objects: 100% (365455/365455), done.
remote: Compressing objects: 100% (147319/147319), done.
fatal: The remote end hung up unexpectedly12 MiB | 9.00 KiB/s     
fatal: early EOF
fatal: index-pack failed
````
## 换源
国外常用仓库慢的经典解决办法，自然是临时将该仓库临时源设置为国内的镜像。一般使用中科大的：

## 更新 homebrew-cask
cd "$(brew --repo)"/Library/Taps/homebrew/homebrew-cask

# 更换源
git remote set-url origin https://mirrors.ustc.edu.cn/homebrew-cask.git

# 更新，由于已经 cd 到相应文件夹了，因此不需要通过 -C 指定路径了
git fetch --unshallow

## 更新 homebrew-core
cd "$(brew --repo)"/Library/Taps/homebrew/homebrew-core

# 更换源
git remote set-url origin https://mirrors.ustc.edu.cn/homebrew-core.git
# 更新
git fetch --unshallow
如果有问题，可以通过如下命令查看远端 repo 是不是设置错了。

git remote -v
如果错了，可以重新设置远端，然后强制更新：

git fetch --all
git reset --hard origin/master
git pull
最后 brew update 即可。
