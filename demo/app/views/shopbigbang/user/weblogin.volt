<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <div class="panel panel-login">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-6">
                        <a href="#" class="active" id="login-form-link">登录</a>
                    </div>
                    <div class="col-xs-6">
                        <a href="#" id="register-form-link">注册</a>
                    </div>
                </div>
                <hr>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-12">
                        <form id="login-form" action="{{ url('user/do-login') }}" method="post" role="form" style="display: block;">

                            <div class="form-group">
                                <input type="text" name="mobile" id="login-mobile" tabindex="1" class="form-control" placeholder="手机号" value="">
                            </div>
                            <div class="form-group">
                                <input type="password" name="password" id="login-password" tabindex="2" class="form-control" placeholder="密码">
                            </div>
                            <div class="form-group text-center">
                                <input type="checkbox" tabindex="3" class="" name="remember" id="login-remember">
                                <label for="login-remember"> 记住我</label>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-6 col-sm-offset-3">
                                        <input type="submit" name="login-submit" id="login-submit" tabindex="4" class="form-control btn btn-login" value="登录">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="text-center">
                                            <a href="{{ url('user/web-forgot-password') }}" tabindex="5" class="forgot-password">忘记密码?</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <form id="register-form" action="{{ url('user/do-create') }}" method="post" role="form" style="display: none;">
                            <div class="form-group">
                                <input type="text" name="mobile" id="reg-mobile" tabindex="1" class="form-control" placeholder="手机号" value="">
                            </div>
                            <div class="form-group">
                                <input type="email" name="email" id="reg-email" tabindex="1" class="form-control" placeholder="邮件地址" value="">
                            </div>
                            <div class="form-group">
                                <input type="password" name="password" id="reg-password" tabindex="2" class="form-control" placeholder="密码">
                            </div>
                            <div class="form-group">
                                <input type="password" name="confirm-password" id="reg-confirm-password" tabindex="2" class="form-control" placeholder="确认密码">
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-6 col-sm-offset-3">
                                        <input type="submit" name="register-submit" id="register-submit" tabindex="4" class="form-control btn btn-register" value="点击注册">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
