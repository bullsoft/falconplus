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
            <a class="navbar-brand" href="{{ url("/") }}">雪品应用</a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li>
                    <a href="{{ url("product/web-recommend") }}">精选</a>
                </li>
                <li>
                    <a href="{{ url("product/web-ranking") }}">排行榜</a>
                </li>
                <li>
                    <a href="{{ url('user/web-purchased') }}">已购项目</a>
                </li>
                <li>
                    <a href="{{ url("user/web-product-updates") }}">更新</a>
                </li>
            </ul>


            {% if !session.has("identity") %}
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><b>登录</b> <span class="caret"></span></a>
                    <ul id="login-dp" class="dropdown-menu">
                        <li>
                            <div class="row">
                                <div class="col-md-12">
                                    Login via
                                    <div class="social-buttons">
                                        <a href="#" class="btn btn-fb"><i class="fa fa-facebook"></i> 微信</a>
                                        <a href="#" class="btn btn-tw"><i class="fa fa-twitter"></i> 新浪微博</a>
                                    </div>
                                    or
                                    <form class="form" role="form" method="post" action="{{ url('user/do-login') }}" accept-charset="UTF-8" id="login-nav">
                                        <div class="form-group">
                                            <label class="sr-only" for="navInputMobile">手机号</label>
                                            <input type="text" name="mobile" class="form-control" id="navInputMobile" placeholder="输入手机号" required>
                                        </div>
                                        <div class="form-group">
                                            <label class="sr-only" for="navInputPassword">密码</label>
                                            <input type="password" name="password" class="form-control" id="navInputPassword" placeholder="输入密码" required>
                                            <div class="help-block text-right"><a href="{{ url('user/web-forgot-password') }}">忘记密码 ?</a></div>
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary btn-block">登 录</button>
                                        </div>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox"> 保持登录
                                            </label>
                                        </div>
                                    </form>
                                </div>
                                <div class="bottom text-center">
                                    还没有账号 ? <a href="{{ url("user/web-login") }}"><b>点击注册</b></a>
                                </div>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
            {% else %}
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">欢迎, {{ user.mobile }} <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ url("user/web-home") }}"><i class="icon-cog"></i>用户中心</a></li>
                        <li><a href="{{ url("user/web-message") }}"><i class="icon-envelope"></i>消息中心</a></li>
                        <li class="divider"></li>
                        <li><a href="{{ url("user/do-logout") }}"><i class="icon-off"></i> 退出</a></li>
                    </ul>
                </li>
            </ul>
            {% endif %}


            <div class="col-lg-3 navbar-right navbar-nav navbar-form">

                <div class="input-group">
                    <input type="text" class="form-control" placeholder="查找应用">
                      <span class="input-group-btn">
                        <button class="btn btn-default" type="button">搜索</button>
                      </span>
                </div><!-- /input-group -->

            </div><!-- /.col-lg-6 -->

        </div>

        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
</nav>