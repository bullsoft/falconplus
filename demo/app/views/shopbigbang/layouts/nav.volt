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

            <div class="col-lg-3 pull-right navbar-nav navbar-form">

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