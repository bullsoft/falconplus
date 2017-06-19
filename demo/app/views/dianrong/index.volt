<!DOCTYPE html>
<html dir="ltr" lang="zh-CN" xml:lang="zh-CN">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="description" content="{{ headDesc }}" />
    <meta name="keywords" content="{{ headKeywords }}" />
    <link rel="shortcut icon" href="{{ url("/tpls/"~tpl~"/images/favicon.ico") }}" />
    <title>{{ title }}</title>
    <link href="{{ url("/tpls/"~tpl~"/css/bootstrap.min.css") }}" rel="stylesheet" />
    <link href="{{ url("/tpls/"~tpl~"/css/components.css?ver=") }}{{ version }}" rel="stylesheet" />
    <link href="{{ url("/tpls/"~tpl~"/css/main.css?ver=") }}{{ version }}" rel="stylesheet" />
    <link href="{{ url("/tpls/"~tpl~"/css/new-home.css?ver=") }}{{ version }}" rel="stylesheet" />
    <style type="text/css">
        @media (min-width: 992px) {
            @font-face {
                font-family: 'proxima-nova';
                src: url('{{ url("/tpls/"~tpl~"/fonts/proximanova-regular-webfont.eot") }}');
                src: url('{{ url("/tpls/"~tpl~"/fonts/proximanova-regular-webfont.eot?#iefix") }}') format('embedded-opentype'),
                url('{{ url("/tpls/"~tpl~"/fonts/proximanova-regular-webfont.woff") }}') format('woff'),
                url('{{ url("/tpls/"~tpl~"/fonts/proximanova-regular-webfont.ttf") }}') format('truetype');
                font-weight: normal;
                font-style: normal;
            }

            @font-face {
                font-family: 'proxima-nova';
                src: url('{{ url("/tpls/"~tpl~"/fonts/proximanova-regular-webfont.eot") }}');
                src: url('{{ url("/tpls/"~tpl~"/fonts/proximanova-regular-webfont.eot?#iefix") }}') format('embedded-opentype'),
                url('{{ url("/tpls/"~tpl~"/fonts/proximanova-regular-webfont.woff") }}') format('woff'),
                url('{{ url("/tpls/"~tpl~"/fonts/proximanova-regular-webfont.ttf") }}') format('truetype');
                font-weight: bold;
                font-style: normal;
            }
        }
    </style>
    <!-- Add support for bootstrap in IE8 -->
    <!--[if lt IE 9]>
    <link href="{{ url("/tpls/"~tpl~"/css/ie8.css?ver=") }}{{ version }}" rel="stylesheet">
    <![endif]-->
    <!--[if IE 9]>
    <link href="{{ url("/tpls/"~tpl~"/css/ie9.css?ver=") }}{{ version }} rel="stylesheet">
    <![endif]-->
</head>

<body>
<!--[if lt IE 8]>
<div class="alert alert-warning text-center" style="margin-bottom:0;">
    <p>你的浏览器不支持点融网的一些新特性，请升级你的浏览器至<a href="http://se.360.cn/">360浏览器</a>或<a href="http://browsehappy.com/">Chrome</a>。
    </p>
    <p>正在为你跳转到旧版网站...<a href="index.html">立即跳转</a></p>
    <p>2015年了，IE8老了...</p>
</div>
<![endif]-->
<div class="wrapper login">
    <!--header-->
    {% include "layouts/head.volt" %}
    <!--content-->
    {{ content() }}
    {% include "layouts/foot.volt" %}
</div>
    <script src="{{ url("/tpls/"~tpl~"/js/jquery.js") }}" type="text/javascript"></script>
    <script src="{{ url("/tpls/"~tpl~"/js/common.js") }}" type="text/javascript"></script>
</body>
</html>