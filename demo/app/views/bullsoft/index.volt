<!doctype html>
<html lang="zh_CN">
    <head>
        <meta charset="utf-8">
        <title>布尔软件开放平台</title>
        <meta name="viewport" content="width=device-width, initial-scale=0.9">
        <link href="{{static_url("css/bootstrap.css")}}" rel="stylesheet" type="text/css" media="all" />
        <link href="{{static_url("css/themify-icons.css")}}" rel="stylesheet" type="text/css" media="all" />
        <link href="{{static_url("css/flexslider.css")}}" rel="stylesheet" type="text/css" media="all" />
        <link href="{{static_url("css/lightbox.min.css")}}" rel="stylesheet" type="text/css" media="all" />
        <link href="{{static_url("css/ytplayer.css")}}" rel="stylesheet" type="text/css" media="all" />
        <link href="{{static_url("css/theme.css")}}" rel="stylesheet" type="text/css" media="all" />
        <link href="{{static_url("css/custom.css")}}" rel="stylesheet" type="text/css" media="all" />
        <link href="{{static_url("css/font.css")}}" rel="stylesheet" type="text/css" media="all" />
        <!-- Custom CSS -->
        {{__invoke__('Volt::yourCss', whichController, whichAction)}}
    </head>
    <body>
        {% include "layouts/nav.volt" %}
        <div class="main-container">
            {{content()}}
            {% include "layouts/footer.volt" %}
        </div>

        <script src="{{static_url("js/jquery.min.js")}}"></script>
        <script src="{{static_url("js/bootstrap.min.js")}}"></script>
        <script src="{{static_url("js/flickr.js")}}"></script>
        <script src="{{static_url("js/flexslider.min.js")}}"></script>
        <script src="{{static_url("js/lightbox.min.js")}}"></script>
        <script src="{{static_url("js/masonry.min.js")}}"></script>
        <script src="{{static_url("js/twitterfetcher.min.js")}}"></script>
        <script src="{{static_url("js/spectragram.min.js")}}"></script>
        <script src="{{static_url("js/ytplayer.min.js")}}"></script>
        <script src="{{static_url("js/countdown.min.js")}}"></script>
        <script src="{{static_url("js/smooth-scroll.min.js")}}"></script>
        <script src="{{static_url("js/parallax.js")}}"></script>
        <script src="{{static_url("js/scripts.js")}}"></script>
        {{__invoke__('Volt::yourJs', whichController, whichAction)}}

    </body>

</html>
