<div class="row">

    <h3>邮寄地址</h3>

    <div class="well col-xs-8 col-sm-8 col-md-8 col-lg-8 col-xs-offset-2 col-sm-offset-2 col-md-offset-2 col-lg-offset-2">
        <div class="row user-row">
            <div class="col-xs-3 col-sm-2 col-md-1 col-lg-1">
                <input type="radio" value="1" name="shipmentMethod" checked />
            </div>
            <div class="col-xs-8 col-sm-9 col-md-10 col-lg-10">
                <strong>公司-百度大厦</strong><br>
                <span class="text-muted">顾伟刚: 18612648090</span>
            </div>
            <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1 dropdown-user" data-for=".cyruxx">
                <i class="glyphicon glyphicon-chevron-down text-muted"></i>
            </div>
        </div>

        <div class="row user-infos cyruxx">
            <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-xs-offset-0 col-sm-offset-0 col-md-offset-1 col-lg-offset-1">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">地址详请</h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-3 col-lg-3 hidden-xs hidden-sm">
                                <img class="img-circle"
                                     src="http://icons.iconarchive.com/icons/icons8/ios7/96/Network-Ip-Address-icon.png"
                                     alt="User Pic">
                            </div>
                            <div class="col-xs-2 col-sm-2 hidden-md hidden-lg">
                                <img class="img-circle"
                                     src="http://icons.iconarchive.com/icons/icons8/ios7/48/Network-Ip-Address-icon.png"
                                     alt="User Pic">
                            </div>
                            <div class="col-xs-10 col-sm-10 hidden-md hidden-lg">
                                <strong>顾伟刚</strong><br>
                                <dl>
                                    <dt>User level:</dt>
                                    <dd>Administrator</dd>
                                    <dt>Registered since:</dt>
                                    <dd>11/12/2013</dd>
                                    <dt>Topics</dt>
                                    <dd>15</dd>
                                    <dt>Warnings</dt>
                                    <dd>0</dd>
                                </dl>
                            </div>
                            <div class=" col-md-9 col-lg-9 hidden-xs hidden-sm">
                                <strong>顾伟刚</strong><br>
                                <table class="table table-user-information">
                                    <tbody>
                                    <tr>
                                        <td>手机号:</td>
                                        <td>18612648090</td>
                                    </tr>
                                    <tr>
                                        <td>地址:</td>
                                        <td>北京 北京市朝阳区霄云路28号网信大厦A座</td>
                                    </tr>
                                    <tr>
                                        <td>送货时间:</td>
                                        <td>工作日</td>
                                    </tr>
                                    <tr>
                                        <td>备注</td>
                                        <td>暂无</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <button class="btn btn-sm btn-primary" type="button"
                                data-toggle="tooltip"
                                data-original-title="Send message to user"><i class="glyphicon glyphicon-envelope"></i></button>
                        <span class="pull-right">
                            <button class="btn btn-sm btn-warning" type="button"
                                    data-toggle="tooltip"
                                    data-original-title="Edit this user"><i class="glyphicon glyphicon-edit"></i></button>
                            <button class="btn btn-sm btn-danger" type="button"
                                    data-toggle="tooltip"
                                    data-original-title="Remove this user"><i class="glyphicon glyphicon-remove"></i></button>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="row">
    <h3>
        购物车
    </h3>

    <div class="col-sm-12 col-md-10 col-md-offset-1">
        {% if cart.getItems() is empty %}
        <h4>对不起, 空空如也.</h4>
        {% else %}
        <table class="table table-hover">
            <thead>
            <tr>
                <th>产品</th>
                <th>数量</th>
                <th class="text-center">单价</th>
                <th class="text-center">合计</th>
                <th> </th>
            </tr>
            </thead>
            <tbody>

            {% for key,item in cart.getItems() %}
            <tr>
                <td class="col-sm-8 col-md-6">
                    <div class="media">
                        <!--
                        <a class="thumbnail pull-left" href="#">
                            <img class="media-object" src="http://icons.iconarchive.com/icons/custom-icon-design/flatastic-2/72/product-icon.png" style="width: 72px; height: 72px;">
                        </a>
                        -->
                        <div class="media-body">
                            <h4 class="media-heading"><a href="#">{{ item.getName() }}</a></h4>
                            <h5 class="media-heading"> by <a href="#">卖家{{ item.getProvider() }}</a></h5>
                            <span>库存: </span><span class="text-success"><strong>{{ item.getVars()["amount"] }}</strong></span>
                        </div>
                    </div>
                </td>
                <td class="col-sm-1 col-md-1" style="text-align: center">
                    <input type="email" class="form-control" id="exampleInputEmail1" value="{{ item.getQty() }}">
                </td>
                <td class="col-sm-1 col-md-1 text-center"><strong>￥{{ item.getPrice() }}</strong></td>
                <td class="col-sm-1 col-md-1 text-center"><strong>￥{{ item.getPrice() * item.getQty() }}</strong></td>
                <td class="col-sm-1 col-md-1">
                    <button type="button" class="btn btn-danger">
                        <span class="glyphicon glyphicon-remove"></span> 删除
                    </button>
                </td>
            </tr>
            {% endfor %}
            <tr>
                <td>  </td>
                <td>  </td>
                <td>  </td>
                <td><h5>商品总价</h5></td>
                <td class="text-right"><h5><strong>￥{{ cart.getTotals()["items"] }}</strong></h5></td>
            </tr>
            <tr>
                <td>  </td>
                <td>  </td>
                <td>  </td>
                <td><h5>物流</h5></td>
                <td class="text-right"><h5><strong>￥{{ cart.getTotals()["shipments"] }}</strong></h5></td>
            </tr>
            <tr>
                <td>  </td>
                <td>  </td>
                <td>  </td>
                <td><h3>总计</h3></td>
                <td class="text-right"><h3><strong>￥{{ cart.getTotals()["grand_total"] }}</strong></h3></td>
            </tr>
            <tr>
                <td>  </td>
                <td>  </td>
                <td>  </td>
                <td>
                    <button type="button" class="btn btn-default">
                        <span class="glyphicon glyphicon-shopping-cart"></span> 继续购买
                    </button>
                </td>
                <td>
                    <button type="button" class="btn btn-success">
                        支付 <span class="glyphicon glyphicon-play"></span>
                    </button>
                </td>
            </tr>
            </tbody>
        </table>
        {% endif %}
    </div>
</div>
