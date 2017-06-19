<header class="sl-header" ng-controller="HeaderCtrl" id="sl-header">
    <nav class="navbar navbar-inverse navbar-static-top site-nav" role="navigation">
        <div class="container">
            <!-- Contact info -->
            <ul class="nav navbar-nav site-nav-sns">
                <li class="site-nav-sns-phone"><span class="navbar-text">客服热线：400-921-9218</span></li>
                <li> <a href="#" class="icon-sns qq">
                        <div class="social-content">
                            <p class="social-title">点融网官方QQ群</p>
                            <p>141444867</p>
                        </div> </a> </li>
                <li> <a href="http://weibo.com/dianrongwang" target="_blank" class="icon-sns weibo" rel="nofollow"></a> </li>
                <li> <a href="#" class="icon-sns wechat">
                        <div class="social-content">
                            <p class="social-title">扫描关注微信公众号</p>
                            <p><img src="images/qr-code.jpg" /></p>
                        </div> </a> </li>
            </ul>
            <!-- For non-login users -->
            <ul id="nonLoginBar" class="nav navbar-nav navbar-right navbar-sm site-nav-login">
                <li><a id="login-panel" href="login.html" rel="nofollow">登录</a></li>
                <li><a id="create-account" href="reg.html" class="btn btn-sm" rel="nofollow">注册账户</a></li>
            </ul>
            <!-- For login users -->
            <ul class="nav navbar-nav navbar-right navbar-sm site-nav-user ng-cloak" ng-if="isAuthenticated()">
                <!-- Shopping Cart Widget -->
                <li ng-show="hasRole('LENDER')" class="dropdown shopping-cart-widget" ng-controller="CartSummaryCtrl">
                    <!-- Shopping Cart Widget: Not yet invested -->
                    <ul class="dropdown-menu" ng-show="cart.amountSum==0">
                        <li class="shopping-cart-empty"> <p>你还没有投标，查看<a href="market.html">热投项目</a>，立即开启投资之旅！</p> </li>
                    </ul>
                    <!-- Shopping Cart Widget: Invested -->
                    <ul class="dropdown-menu" ng-show="cart.amountSum!= 0" ng-controller="CartCtrl">
                        <li class="shopping-cart-title"> <span>投标 <strong>{{ cart.itemsCount }}笔</strong> </span> <span class="pull-right"> 总额<span ng-bind-html="cart.amountSum | slMoney"></span> </span> </li>
                        <li class="divider"></li>
                        <li ng-repeat="item in cart.items" class="shopping-cart-item" ng-mouseover="show=true" ng-mouseleave="show=false" ng-init="show=false"> <a href="#"> <span>sdfa</span> <span ng-bind-html="item.amount | slMoney" ng-class="{hidden:show}"></span> <span data-toggle="modal" data-target="#deleteCartItem" class="sl-icon-trash hidden" ng-click="transId(item.loanId)" ng-class="{hidden:!show}"></span> </a> </li>
                        <li class="divider"></li>
                        <li class="shopping-cart-checkout"> <a id="checkout-shopping-cart" href="/market/checkout" class="btn btn-sm btn-primary btn-block btn-embossed">查看购物车</a> </li>
                    </ul> </li>
                <!-- My Account Menu -->
                <li class="dropdown"> <a href="member_info.html" class="dropdown-toggle hoverHeader" ng-show="session.firstLoaded &amp;&amp; session.actor.username" data-toggle="dropdown" data-hover="dropdown">{{session.actor.displayName?session.actor.displayName:session.actor.username}}的账户 <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="member_info.html">我的账户</a></li>
                        <li><a href="#" ng-click="logout()">退出</a></li>
                    </ul> </li>
            </ul>
        </div>
    </nav>
    <div class="site-menu">
        <div class="header-navbar-container sl-nav-wrapper header-nav-container">
            <nav class="navbar navbar-static-top sl-navbar" role="navigation">
                <div class="container">
                    <div class="navbar-header  col-xs-6">
                        <button type="button" class="navbar-toggle"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
                        <a class="navbar-brand" href="index.html"> <span class="sl-logo">点融网 - DianRong</span> </a>
                    </div>
                    <div class=" navbar-collapse navbar-ex1-collapse sl-nav">
                        <ul class="nav navbar-nav main-menu navbar-right">
                            <!--menus-->
                            <li class="main-link-list" ng-class="{active:isActive('/market')}"> <a class="main-link" href="market.html"> <span class="main-link-text">我要投资</span> </a> </li>
                            <li class="main-link-list" ng-class="{active:isActive('/public/borrower')}"> <a class="main-link" href="borrow.html"> <span class="main-link-text">我要借款</span> </a> </li>
                            <li class="main-link-list" ng-class="{active:isActive('/public/help-center')}"> <a class="main-link" href="help.html"> <span class="main-link-text">帮助中心</span> </a> </li>
                            <li class="main-link-list" ng-class="{active:isActive('/public/about')}"> <a class="main-link" href="about.html"> <span class="main-link-text">关于我们</span> </a> </li>
                        </ul>
                    </div>
                    <!-- /.navbar-collapse -->
                </div>
            </nav>
        </div>
        <!--secondaryNav-->
        <!--jumbotron-->
    </div>
</header>