<div class="dashboard">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <ul class="dashboard-tabs">
                <li class="active">
                    <a href="#profile" class="btn" aria-controls="profile" role="tab" data-toggle="tab">
                        <span class="glyphicon glyphicon-user"></span>
                        <h4>个人信息</h4>
                    </a>
                </li>
                <li>
                    <a href="#statistics" class="btn" aria-controls="statistics" role="tab" data-toggle="tab">
                        <span class="glyphicon glyphicon-time"></span>
                        <h4>统计</h4>
                    </a>
                </li>
                <li>
                    <a href="#donate" class="btn" aria-controls="donate" role="tab" data-toggle="tab">
                        <span class="glyphicon glyphicon-usd"></span>
                        <h4>订单</h4>
                    </a>
                </li>
                <li>
                    <a href="#settings" class="btn" aria-controls="settings" role="tab" data-toggle="tab">
                        <span class="glyphicon glyphicon-cog"></span>
                        <h4>设置</h4>
                    </a>
                </li>
                <li>
                    <a href="#help" class="btn" aria-controls="help" role="tab" data-toggle="tab">
                        <span class="glyphicon glyphicon-question-sign"></span>
                        <h4>工单</h4>
                    </a>
                </li>
            </ul>
        </div>

        <div class="tab-content col-md-12">

            <div role="tabpanel" class="tab-pane active" id="profile">

                <div class="container">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="profile">
                                <img src="http://icons.iconarchive.com/icons/custom-icon-design/flatastic-10/128/Bear-icon.png" alt="..." class="img-circle">
                                <p>顾伟刚</p>
                                <p>18612648090</p>
                            </div>
                            <ul class="list-group">
                                <li class="list-group-item active">我的详情</li>
                                <li class="list-group-item">订单列表</li>
                                <li class="list-group-item">编辑地址</li>
                                <li class="list-group-item">修改密码</li>
                                <li class="list-group-item">...</li>
                                <li class="list-group-item">...</li>
                            </ul>
                        </div>

                        <div class="col-md-9">
                            <div class="profile-pane">
                                <div>
                                    <div class="header">我的详情
                                    </div>
                                    <div class="content">
                                        111
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>


            </div>


            <div role="tabpanel" class="tab-pane" id="statistics">
                Statistics
            </div>

            <div role="tabpanel" class="tab-pane" id="donate">

                <div>
                    <div class="header">
                        <h4>Account Information</h4>
                    </div>
                    <div class="content">
                        <div class="row">
                         ...

                        </div>
                    </div>
                </div>


            </div>


            <div role="tabpanel" class="tab-pane" id="settings">



            </div>


            <div role="tabpanel" class="tab-pane help-pane" id="help">
                <!-- Begin Help -->
                <div class="jumbotron jumbotron-sm">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-12 col-lg-12">
                                <h1 class="h1">联系我们 <small>7*24</small></h1>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="well well-sm">
                                <form>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="name">公司名称</label>
                                                <input type="text" class="form-control" id="name" placeholder="Enter name" required="required" />
                                            </div>
                                            <div class="form-group">
                                                <label for="email">邮箱地址</label>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <span class="glyphicon glyphicon-envelope"></span>
                                                    </span>
                                                    <input type="email" class="form-control" id="email" placeholder="Enter email" required="required" />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="subject">主题</label>
                                                <select id="subject" name="subject" class="form-control" required="required">
                                                    <option value="na" selected="">Choose One:</option>
                                                    <option value="service">General Customer Service</option>
                                                    <option value="suggestions">Suggestions</option>
                                                    <option value="product">Product Support</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="name">消息</label>
                                                <textarea name="message" id="message" class="form-control" rows="9" cols="25" required="required" placeholder="Message"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <button type="submit" class="btn btn-primary pull-right" id="btnContactUs">发送消息</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <form>
                                <legend><span class="glyphicon glyphicon-globe"></span> 办公地点</legend>
                                <address>
                                    <strong>北京</strong><br>
                                    北京市朝阳区<br>
                                    霄云路28号网信大厦A座<br>
                                    <abbr title="Phone">P:</abbr>
                                    (010) 59926655
                                </address>
                                <address>
                                    <strong>布尔软件科技有限公司</strong><br>
                                    <a href="mailto:#">support@bullsoft.org</a>
                                </address>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- End Help -->
            </div>
        </div>
    </div>
</div>