{% extends "nav_base.volt" %}

{% block right %}
<div class="row carousel-holder">

    <div class="col-md-12">
        <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                <li data-target="#carousel-example-generic" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner">
                <div class="item active">
                    <img class="slide-image" src="{{ url('/tpls/'~tpl~'/images/p2p.png') }}" alt="网贷系统">
                </div>
                <div class="item">
                    <img class="slide-image" src="{{ url('/tpls/'~tpl~'/images/cf.png') }}" alt="众筹系统">
                </div>
                <div class="item">
                    <img class="slide-image" src="{{ url('/tpls/'~tpl~'/images/py.png') }}" alt="汉字转拼音服务">
                </div>
            </div>
            <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left"></span>
            </a>
            <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right"></span>
            </a>
        </div>
    </div>

</div>

<div class="row">

    <div class="col-sm-4 col-lg-4 col-md-4">
        <div class="thumbnail">
            <img src="{{ url('/tpls/'~tpl~'/thumb/p2p.png') }}" alt="">
            <div class="caption">
                <h4 class="pull-right">RMB 60W</h4>
                <h4><a href="{{ url("product/web-item/1") }}">P2P系统</a>
                </h4>
                <p>P2P是peer-to-peer的缩写，peer在英语里有（地位、能力等）同等者、同事和伙伴等意义。P2P直接将人们联系起来，让人们通过互联网直接交互。使得网络上的沟通变得容易、更直接共享和交互，真正地消除中间商，为企业与个人提供更大的方便。</p>
            </div>
            <div class="ratings">
                <p class="pull-right">15 reviews</p>
                <p>
                    <span class="glyphicon glyphicon-star"></span>
                    <span class="glyphicon glyphicon-star"></span>
                    <span class="glyphicon glyphicon-star"></span>
                    <span class="glyphicon glyphicon-star"></span>
                    <span class="glyphicon glyphicon-star"></span>
                </p>
            </div>
        </div>
    </div>

    <div class="col-sm-4 col-lg-4 col-md-4">
        <div class="thumbnail">
            <img src="{{ url('/tpls/'~tpl~'/thumb/cf.png') }}" alt="">
            <div class="caption">
                <h4 class="pull-right">RMB 40W</h4>
                <h4><a href="#">实物众筹</a>
                </h4>
                <p>众筹是一种新兴的融资模式,其中众筹模式主要分为实物众筹和股权众筹。在实物众筹模式下,潜在投资者会对感兴趣的实物项目...</p>
            </div>
            <div class="ratings">
                <p class="pull-right">12 reviews</p>
                <p>
                    <span class="glyphicon glyphicon-star"></span>
                    <span class="glyphicon glyphicon-star"></span>
                    <span class="glyphicon glyphicon-star"></span>
                    <span class="glyphicon glyphicon-star"></span>
                    <span class="glyphicon glyphicon-star-empty"></span>
                </p>
            </div>
        </div>
    </div>

    <div class="col-sm-4 col-lg-4 col-md-4">
        <div class="thumbnail">
            <img src="{{ url('/tpls/'~tpl~'/thumb/py.png') }}" alt="">
            <div class="caption">
                <h4 class="pull-right">RMB 1W</h4>
                <h4><a href="#">汉字转拼音服务</a>
                </h4>
                <p>汉字转拼音,解决多音字/生僻字.当你需要对输入提示进行优化或索引优化的时间非常有效果</p>
            </div>
            <div class="ratings">
                <p class="pull-right">31 reviews</p>
                <p>
                    <span class="glyphicon glyphicon-star"></span>
                    <span class="glyphicon glyphicon-star"></span>
                    <span class="glyphicon glyphicon-star"></span>
                    <span class="glyphicon glyphicon-star"></span>
                    <span class="glyphicon glyphicon-star-empty"></span>
                </p>
            </div>
        </div>
    </div>

    <div class="col-sm-4 col-lg-4 col-md-4">
        <div class="thumbnail">
            <img src="http://placehold.it/320x150" alt="">
            <div class="caption">
                <h4 class="pull-right">$84.99</h4>
                <h4><a href="#">Fourth Product</a>
                </h4>
                <p>This is a short description. Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
            </div>
            <div class="ratings">
                <p class="pull-right">6 reviews</p>
                <p>
                    <span class="glyphicon glyphicon-star"></span>
                    <span class="glyphicon glyphicon-star"></span>
                    <span class="glyphicon glyphicon-star"></span>
                    <span class="glyphicon glyphicon-star-empty"></span>
                    <span class="glyphicon glyphicon-star-empty"></span>
                </p>
            </div>
        </div>
    </div>

    <div class="col-sm-4 col-lg-4 col-md-4">
        <div class="thumbnail">
            <img src="http://placehold.it/320x150" alt="">
            <div class="caption">
                <h4 class="pull-right">$94.99</h4>
                <h4><a href="#">Fifth Product</a>
                </h4>
                <p>This is a short description. Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
            </div>
            <div class="ratings">
                <p class="pull-right">18 reviews</p>
                <p>
                    <span class="glyphicon glyphicon-star"></span>
                    <span class="glyphicon glyphicon-star"></span>
                    <span class="glyphicon glyphicon-star"></span>
                    <span class="glyphicon glyphicon-star"></span>
                    <span class="glyphicon glyphicon-star-empty"></span>
                </p>
            </div>
        </div>
    </div>

</div>

{% endblock %}