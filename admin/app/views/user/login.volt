<!DOCTYPE html>
<!--[if IE 8]> <html lang="zh_CN" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="zh_CN" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="zh_CN">
<!--<![endif]-->
<!-- BEGIN HEAD -->

<head>
    <meta charset="utf-8" />
    <title>Metronic | User Login 1</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <meta content="" name="description" />
    <meta content="BULLSOFT" name="author" />
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
    <link href="{{ static_url('assets/global/plugins/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ static_url('assets/global/plugins/simple-line-icons/simple-line-icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ static_url('assets/global/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ static_url('assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <link href="{{ static_url('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ static_url('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- END PAGE LEVEL PLUGINS -->
    <!-- BEGIN THEME GLOBAL STYLES -->
    <link href="{{ static_url('assets/global/css/components-md.min.css') }}" rel="stylesheet" id="style_components" type="text/css" />
    <link href="{{ static_url('assets/global/css/plugins-md.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- END THEME GLOBAL STYLES -->
    <!-- BEGIN PAGE LEVEL STYLES -->
    <link href="{{ static_url('assets/pages/css/login.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- END PAGE LEVEL STYLES -->
    <!-- BEGIN THEME LAYOUT STYLES -->
    <!-- END THEME LAYOUT STYLES -->
    <link rel="shortcut icon" href="{{ static_url('favicon.ico') }}" /> </head>
<!-- END HEAD -->

<body class=" login">
<!-- BEGIN LOGO -->
<div class="logo">
    <a href="index.html">
        <img src="{{ static_url('assets/pages/img/logo-big.png') }}" alt="布尔软件-后管管理界面" /> </a>
</div>
<!-- END LOGO -->
<!-- BEGIN LOGIN -->
<div class="content">
    <!-- BEGIN LOGIN FORM -->
    <form class="login-form" action="index.html" method="post">
        <h3 class="form-title font-green">登&nbsp;&nbsp;入</h3>
        <div class="alert alert-danger display-hide">
            <button class="close" data-close="alert"></button>
            <span> 用户名/密码不能为空。 </span>
        </div>
        <div class="form-group">
            <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
            <label class="control-label visible-ie8 visible-ie9">用户名</label>
            <input class="form-control form-control-solid placeholder-no-fix" type="text" autocomplete="off" placeholder="用户名" name="username" /> </div>
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">密码</label>
            <input class="form-control form-control-solid placeholder-no-fix" type="password" autocomplete="off" placeholder="密码" name="password" /> </div>
        <div class="form-actions">
            <button type="submit" class="btn green uppercase">芝麻开门</button>
            <label class="rememberme check mt-checkbox mt-checkbox-outline">
                <input type="checkbox" name="remember" value="1" />记住状态
                <span></span>
            </label>
            <a href="javascript:;" id="forget-password" class="forget-password">忘记密码?</a>
        </div>
        <div class="login-options">
            <h4>使用社交账号</h4>
            <ul class="social-icons">
                <li>
                    <a class="social-icon-color facebook" data-original-title="facebook" href="javascript:;"></a>
                </li>
                <li>
                    <a class="social-icon-color twitter" data-original-title="Twitter" href="javascript:;"></a>
                </li>
                <li>
                    <a class="social-icon-color googleplus" data-original-title="Goole Plus" href="javascript:;"></a>
                </li>
                <li>
                    <a class="social-icon-color linkedin" data-original-title="Linkedin" href="javascript:;"></a>
                </li>
            </ul>
        </div>
        <div class="create-account">
            <p>
                <a href="javascript:;" id="register-btn" class="uppercase">申请新账号</a>
            </p>
        </div>
    </form>
    <!-- END LOGIN FORM -->
    <!-- BEGIN FORGOT PASSWORD FORM -->
    <form class="forget-form" action="index.html" method="post">
        <h3 class="font-green">忘记密码 ?</h3>
        <p> 输入邮箱地址接收重置密码的邮件 </p>
        <div class="form-group">
            <input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Email" name="email" /> </div>
        <div class="form-actions">
            <button type="button" id="back-btn" class="btn green btn-outline">返回</button>
            <button type="submit" class="btn btn-success uppercase pull-right">重置</button>
        </div>
    </form>
    <!-- END FORGOT PASSWORD FORM -->
    <!-- BEGIN REGISTRATION FORM -->
    <form class="register-form" action="index.html" method="post">
        <h3 class="font-green">申请新账号</h3>
        <p class="hint"> 请在下面输入您的个人信息: </p>
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">姓名</label>
            <input class="form-control placeholder-no-fix" type="text" placeholder="您的姓名" name="fullname" /> </div>
        <div class="form-group">
            <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
            <label class="control-label visible-ie8 visible-ie9">邮箱</label>
            <input class="form-control placeholder-no-fix" type="text" placeholder="您的邮箱" name="email" /> </div>
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">地址</label>
            <input class="form-control placeholder-no-fix" type="text" placeholder="居住地址" name="address" /> </div>
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">城市</label>
            <input class="form-control placeholder-no-fix" type="text" placeholder="所在城市" name="city" /> </div>
        <p class="hint"> 请在下面输入您的账号信息: </p>
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">用户名</label>
            <input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="用户名" name="username" /> </div>
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">密码</label>
            <input class="form-control placeholder-no-fix" type="password" autocomplete="off" id="register_password" placeholder="密码" name="password" /> </div>
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">再次输入密码</label>
            <input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="再次输入密码" name="rpassword" /> </div>
        <div class="form-group margin-top-20 margin-bottom-20">
            <label class="mt-checkbox mt-checkbox-outline">
                <input type="checkbox" name="remember" value="1" />
                <input type="checkbox" name="tnc" /> 我同意
                <a href="javascript:;">布尔软件服务协议 </a> &
                <a href="javascript:;">隐私安全协议 </a>
                <span></span>
            </label>
            <div id="register_tnc_error"> </div>
        </div>
        <div class="form-actions">
            <button type="button" id="register-back-btn" class="btn green btn-outline">返回</button>
            <button type="submit" id="register-submit-btn" class="btn btn-success uppercase pull-right">提交申请</button>
        </div>
    </form>
    <!-- END REGISTRATION FORM -->
</div>
<div class="copyright"> 2016 © BULLSOFT.org <a href="mailto:support@bullsoft.org">联系我们</a> </div>
<!--[if lt IE 9]>
<script src="{{ static_url('assets/global/plugins/respond.min.js') }}"></script>
<script src="{{ static_url('assets/global/plugins/excanvas.min.js') }}"></script>
<![endif]-->
<!-- BEGIN CORE PLUGINS -->
<script src="{{ static_url('assets/global/plugins/jquery.min.js') }}" type="text/javascript"></script>
<script src="{{ static_url('assets/global/plugins/bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>
<script src="{{ static_url('assets/global/plugins/js.cookie.min.js') }}" type="text/javascript"></script>
<script src="{{ static_url('assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js') }}" type="text/javascript"></script>
<script src="{{ static_url('assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js') }}" type="text/javascript"></script>
<script src="{{ static_url('assets/global/plugins/jquery.blockui.min.js') }}" type="text/javascript"></script>
<script src="{{ static_url('assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="{{ static_url('assets/global/plugins/jquery-validation/js/jquery.validate.min.js') }}" type="text/javascript"></script>
<script src="{{ static_url('assets/global/plugins/jquery-validation/js/additional-methods.min.js') }}" type="text/javascript"></script>
<script src="{{ static_url('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN THEME GLOBAL SCRIPTS -->
<script src="{{ static_url('assets/global/scripts/app.min.js') }}" type="text/javascript"></script>
<!-- END THEME GLOBAL SCRIPTS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="{{ static_url('assets/pages/scripts/login.min.js') }}" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<!-- BEGIN THEME LAYOUT SCRIPTS -->
<!-- END THEME LAYOUT SCRIPTS -->
</body>

</html>