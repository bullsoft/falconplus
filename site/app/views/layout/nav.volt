<!-- Navigation -->
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/index.html">Phalcon+</a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
                <li>
                    <a href="https://gitter.im/bullsoft/phalconplus?utm_source=badge&amp;utm_medium=badge&amp;utm_campaign=pr-badge"><img src="https://camo.githubusercontent.com/a9dd0115afeec813737b6e0a085ee2d5d4716d01/68747470733a2f2f6261646765732e6769747465722e696d2f62756c6c736f66742f7068616c636f6e706c75732e737667" alt="Gitter" data-canonical-src="https://badges.gitter.im/bullsoft/phalconplus.svg" style="max-width:100%;"></a>
                </li>
                <li{% if dispatcher.getControllerName() == "quick_start" %} class="active"{% endif %}>
                    <a href="/quick_start.html">快速开始</a>
                </li>
                <li{% if dispatcher.getControllerName() ==  "manual" %} class="active"{% endif %}>
                    <a href="/manual.html">手册</a>
                </li>
                <li>
                    <a href="/api/">API文档</a>
                </li>
                <li>
                    <a href="http://forum.bullsoft.org" target="_blank">社区</a>
                </li>
                <li>
                    <a href="http://bullsoft.org/donate" target="_blank">捐助我们</a>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">博客 <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="{{ url('blog/index.html') }}">首页</a>
                        </li>
                        <li>
                            <a href="{{ url('blog/category.html') }}">分类</a>
                        </li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">赞助商<b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="http://bullsoft.org" target="_blank">布尔软件</a>
                        </li>
                        <li>
                            <a href="http://www.firstp2p.com" target="_blank">网信理财</a>
                        </li>
                        <li>
                            <a href="http://shopbigbang.com" target="_blank">雪品应用</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
</nav>
