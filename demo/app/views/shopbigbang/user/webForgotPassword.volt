<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <div class="panel panel-login">
            <div class="panel-heading">
                <div class="row">
                    <a href="#" class="active" id="login-form-link">忘记密码</a>

                </div>
                <hr>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-12">
                        <form id="login-form" action="{{ url('user/do-post-reset-password-mail') }}" method="post" role="form" style="display: block;">
                            <div class="form-group">
                                <input type="text" name="mobile" id="reset-mobile" tabindex="1" class="form-control" placeholder="手机号" value="">
                            </div>
                            <div class="form-group">
                                <input type="text" name="email" id="reset-email" tabindex="2" class="form-control" placeholder="邮箱地址">
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-6 col-sm-offset-3">
                                        <input type="submit" name="login-submit" id="login-submit" tabindex="4" class="form-control btn btn-login" value="重置密码">
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
