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
            <a class="navbar-brand" href="{{ url('/index.html') }}">Phalcon+</a>
            <img src="http://phalcon.b0.upaiyun.com/photo/logo.gif" height="50px" />
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
                <li{% if dispatcher.getControllerName() == "quick-start" %} class="active"{% endif %}>
                    <a href="/quick-start.html">快速开始</a>
                </li>
                <li>
                    <a href="#manual"{% if dispatcher.getControllerName() == "manual" %} class="active"{% endif %}>手册</a>
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
                            <a href="{{ url('/blog/index.html') }}">首页</a>
                        </li>
                        <li>
                            <a href="{{ url('/blog/category.html') }}">分类</a>
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