[传送路径](https://segmentfault.com/a/1190000040450097?_ea=154846193)
```
基本知识
git clone && git init
本地初始化一个Git仓库

与从远程拉取到本地一个Git仓库，本质上没有区别，在远程拉取仓库也需要先在远程建立仓库，其命令依旧是git init

git目录
切换分支
.git/HEAD 用于记录当前所在分支，使用 git checkout branchName 是直接修改该文件

ref: refs/heads/master
某个分支的当前提交
.git/refs/heads

e6caa5bbcd4d362d3a5bac6b5a3417c15991484c
类似的查看某个标签的当前提交 .git/refs/tags

e6caa5bbcd4d362d3a5bac6b5a3417c15991484c
暂存区
git add filename 该动作内容保存在 .git/index 文件中

日志
.git/logs 保存所有日志 ，使用 git log 会查询该文件

常用命令
git add
git commit
git merge
git checkout
git diff
git status
git log
学习平台
https://learngitbranching.js....

应用场景
git blame 找出“真凶”
git blame filename
git checkout 回滚文件
git checkout filename
git add 如何取消
git reset HEAD filename
git commit 如何取消
git reset --soft HEAD~1
// 重新修改commit信息
git commit --amend
git merge 如何取消
git merge --abort
不要盲目使用git add .
git status
// 在将文件添加到缓存区之前，请一定、一定、一定先git diff 下
git diff
// 检查所有修改都是想add的，如果所有修改都是的话，可以使用 git add . 除此之外还请慎重呀！
git add . || git add filename1 filename2
git rebase 变基 ==“换爹”？
git rebase branch
git cherry-pick 不动声色的“偷代码”
git cherry-pick hashcommit|branchname
加塞任务如何处理
git stash
git stash apply|pop
git list
最后，根据上述描述的工作中经常遇到的场景给出一张流程图。

```
