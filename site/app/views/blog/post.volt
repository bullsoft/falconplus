<div class="row blog-row">

    <!-- Blog Post Content Column -->
    <div class="col-lg-8">
        <!-- Blog Post -->
        <!-- Post Content -->
        {{content}}

        <hr />

        <!-- Blog Comments -->
        <!-- Posted Comments -->

        <div id="cloud-tie-wrapper" class="cloud-tie-wrapper"></div>
        <script src="https://img1.cache.netease.com/f2e/tie/yun/sdk/loader.js"></script>
        <script>
            var cloudTieConfig = {
                url: document.location.href,
                sourceId: "",
                productKey: "7ac731ee56d74e5b80aaac1952a0d61b",
                target: "cloud-tie-wrapper"
            };
            var yunManualLoad = true;
            Tie.loader("aHR0cHM6Ly9hcGkuZ2VudGllLjE2My5jb20vcGMvbGl2ZXNjcmlwdC5odG1s", true);
        </script>

        <!-- Comment -->

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

        <!-- Side Widget Well -->
        <div class="well">
            <h4>编程珠玑</h4>
            <p>
                ...
            </p>
        </div>

    </div>

</div>
<!-- /.row -->
