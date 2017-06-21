<div class="container">
<h1>博客搜索结果: </h1>
<div class="col-md-12">
    {% if blogs is not empty %}
    {% for blog in blogs %}
    <h2><a href="{{ url('blog/post/') }}{{blog['slug']}}">{{blog["title"]}}</a></h2>
    <p>{{blog["intro"]}}</p>
    <div>
       <span class="badge">Posted {{date("Y-m-d", blog["ctime"])}}</span>
       <div class="pull-right">
          {% for tag in blog["tags"] %}
            <span class="label label-success">{{tag}}</span>
          {% endfor %}
       </div>
     </div>
     {% if loop.last == false %}
     <hr />
    {% endif %}
    {% endfor %}
    {% else %}
       <center><h2>～～空空如也～～</h2></center>
    {% endif %}
    </div>     
    <hr>
</div>