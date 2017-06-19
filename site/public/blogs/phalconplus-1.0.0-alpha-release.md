# 1.0.0-Alpha 发布

标签（空格分隔）： php phalcon+ phalconplus

> 随着`Phalcon`框架进入`3.0`时代，说明其越来越健壮，社区维护`LTS`的决心也得到了印证。同时也说明`Zephir`越来越完备，越来越成熟。特别是，`Phalcon 3.1.2`已经全面支持`PHP 7.1`这个消息也给广大`Phalconer`打了一针强心剂，吃了一颗定心丸。

---

随着`Phalcon`框架进入`3.0`时代，说明其越来越健壮，社区维护`LTS`的决心也得到了印证。同时也说明`Zephir`越来越完备，越来越成熟。特别是，`Phalcon 3.1.2`已经全面支持`PHP 7.1`这个消息也给广大`Phalconer`打了一针强心剂，吃了一颗定心丸。

趁着此次`3.1.2`的发布，我也发布一下`Phalcon+ 1.0.0-Alpha`，此次扩展部分变化如下：

 - 支持`UnitOfWork`部分特性
 - `Model::update()`的时候支持添加额外的条件
 - 升级`Zephir`到最新版本

讲真，变化不是很大。不过此次发布变化最大的在PHP部分。更新如下：

 - 全面集成`composer`
 - `fp-common`升级成标准的`Phalcon+Cli`模块
 - 命令行工具全面升级改造
 - 集成`deployer`部署工具

从现在开始，安装好`Phalcon+`扩展之后，你只需要以下几步便能轻松开始`Phalcon`的奇妙之旅:

 1. 创建Phalcon+项目: `composer create-project bullsoft/fp-project fp-app`
 2. 进入项目: `cd fp-app`
 3. 查看命令行帮助文档: `./common/bin/fp-devtool`
![Phalcon+命令行工具帮助文档][1]
 4. 创建模块：`./common/bin/fp-devtool module create`
 5. 查看模块列表：`./common/bin/fp-devtool module list`
 ![Phalcon+模块列表][2]
 6. 运行模块：`./common/bin/fp-devtool server start api`
 7. 查看模块运行情况：`./common/bin/fp-devtool server list`
 ![Phalcon+服务列表][3]
 8. 浏览器查看效果：![此处输入图片的描述][4]
 9. 完美！！！


  [1]: http://bullsoft-static.oss-cn-beijing.aliyuncs.com/plus/image/fp-devtool-help.png
  [2]: http://bullsoft-static.oss-cn-beijing.aliyuncs.com/plus/image/fp-devtool-module_list.png
  [3]: http://bullsoft-static.oss-cn-beijing.aliyuncs.com/plus/image/fp-devtool-server-list.png
  [4]: http://bullsoft-static.oss-cn-beijing.aliyuncs.com/plus/image/localhost_8000.png
