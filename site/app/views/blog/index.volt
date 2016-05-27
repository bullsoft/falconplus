<div class="row blog-row">

    <!-- Blog Entries Column -->
    <div class="col-md-8">

        <h1 class="page-header">
            博客+
            <small>最新动态</small>
        </h1>
        {% if count(blogs) == 0 %}
        <p>呀！不好意思，啥都没有。</p>
        {% endif %}
        <!-- First Blog Post -->
        {% for blog in blogs %}
        <h2>
            <a href="{{ url('blog/post/') }}{{blog['slug']}}">{{blog["title"]}}</a>
        </h2>
        <p class="lead">
            by <a href="index.php">Phalcon+ Team</a>
        </p>
        <p><span class="glyphicon glyphicon-time"></span> Posted on {{date("Y-m-d H:i:s", blog["ctime"])}}</p>
        <hr>
        <!--
             <img class="img-responsive" src="http://placehold.it/900x300" alt="">
             <hr>
        -->
        <p>{{blog["intro"]}}</p>

        <a class="btn btn-primary" href="{{url('blog/post/')}}{{blog['slug']}}">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

        <hr>
        {% endfor %}

        <!-- Pager -->
        <ul class="pager">
            {% if isLast == false %}
            <li class="previous">
                <a href="{{url('blog/index.html?pageNo=')}}{{pageNo+1}}">&larr; Older</a>
            </li>
            {% endif %}
            {% if pageNo > 1 %}
            <li class="next">
                <a href="{{url('blog/index.html?pageNo=')}}{{pageNo-1}}">Newer &rarr;</
            </li>
            {% endif %}
        </ul>

    </div>

    <!-- Blog Sidebar Widgets Column -->
    <div class="col-md-4">

        <!-- Blog Search Well -->
        <div class="well">
            <h4>Blog Search</h4>
            <div class="input-group">
                <input type="text" class="form-control">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="button">
                                <span class="glyphicon glyphicon-search"></span>
                            </button>
                        </span>
            </div>
            <!-- /.input-group -->
        </div>

        <!-- Blog Categories Well -->
        <div class="well">
            <h4>Blog Categories</h4>
            <div class="row">
                <div class="col-lg-6">
                    <ul class="list-unstyled">
                        <li><a href="#">Category Name</a>
                        </li>
                        <li><a href="#">Category Name</a>
                        </li>
                        <li><a href="#">Category Name</a>
                        </li>
                        <li><a href="#">Category Name</a>
                        </li>
                    </ul>
                </div>
                <!-- /.col-lg-6 -->
                <div class="col-lg-6">
                    <ul class="list-unstyled">
                        <li><a href="#">Category Name</a>
                        </li>
                        <li><a href="#">Category Name</a>
                        </li>
                        <li><a href="#">Category Name</a>
                        </li>
                        <li><a href="#">Category Name</a>
                        </li>
                    </ul>
                </div>
                <!-- /.col-lg-6 -->
            </div>
            <!-- /.row -->
        </div>

        <!-- Side Widget Well -->
        <div class="well">
            <h4>Side Widget Well</h4>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Inventore, perspiciatis adipisci accusamus laudantium odit aliquam repellat tempore quos aspernatur vero.</p>
        </div>

    </div>

</div>
<!-- /.row -->
