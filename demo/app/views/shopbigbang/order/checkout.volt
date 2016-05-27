<!-- Credit card form -->
<div class="container">
    <h3>订单支付</h3>
    <div class="row">
        <div class="col-xs-12 col-md-2>
                    </div>
                    <div class="col-xs-12 col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">订单详情</h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-xs-12">
                            <p>订单号: {{order['dealNo']}} </p>
                            <p>购物车(编号：{{order['cartNo']}}) 清单：</p>
                            <ul>
                                {% for sku in skus %}
                                <li>{{sku["name"]}} - 卖家：{{sku["relatedSeller"]["nickname"]}}</li>
                                {% endfor %}
                            </ul>
                            总计：{{order["amount"]}} 元
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="col-xs-12 col-md-12">
            <div class="panel with-nav-tabs panel-primary">
                <div class="panel-heading">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab1primary" data-toggle="tab">支付宝</a></li>
                        <li><a href="#tab2primary" data-toggle="tab">微信支付</a></li>
                        <li><a href="#tab3primary" data-toggle="tab">银联支付</a></li>
                    </ul>
                </div>
                <div class="panel-body">
                    <div class="tab-content">
                        <div class="tab-pane fade in active" id="tab1primary">
                            <a href="{{url('order/payment/alipay?orderNo=')}}{{order['dealNo']}}"><button class="btn bg-gray" type="button">支付宝支付<i class="fa fa-long-arrow-right"></i></button></a>
                        </div>
                        <div class="tab-pane fade" id="tab2primary">Primary 2</div>
                        <div class="tab-pane fade" id="tab3primary">Primary 3</div>
                        <div class="tab-pane fade" id="tab4primary">Primary 4</div>
                        <div class="tab-pane fade" id="tab5primary">Primary 5</div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

