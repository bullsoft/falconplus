<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>雪品大爆炸</title>

    <!-- Bootstrap Core CSS -->
    <link href="{{ url('/tpls/'~tpl~'/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="{{ url('/tpls/'~tpl~'/css/shop-homepage.css') }}" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style type="text/css">

    </style>
</head>

<body>

{% include "layouts/nav.volt" %}

<!-- Page Content -->
<div class="container">

    <div class="row">

        <div class="col-md-3">
            <p class="lead">类别</p>
            <div class="list-group">
                <a href="#" class="list-group-item">金融软件</a>
                <a href="#" class="list-group-item">交流社区</a>
                <a href="#" class="list-group-item">电商网站</a>
            </div>
        </div>

        <div class="col-md-9">

            {{ content() }}

        </div>

    </div>

</div>
<!-- /.container -->

<div class="container">

    <hr>

    <!-- Footer -->
    <footer>
        <div class="row">
            <div class="col-lg-12">
                <p>Copyright &copy; <a href="http://bullsoft.org" target="_blank">BullSoft.org</a> 2016</p>
            </div>
        </div>
    </footer>

</div>
<!-- /.container -->

<!-- jQuery -->
<script src="{{ url('/tpls/'~tpl~'/js/jquery.js') }}"></script>

<!-- Bootstrap Core JavaScript -->
<script src="{{ url('/tpls/'~tpl~'/js/bootstrap.min.js') }}"></script>

</body>

</html>
