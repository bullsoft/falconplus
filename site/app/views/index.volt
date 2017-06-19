{% include "layout/head.volt" %}

{% include "layout/nav.volt" %}

{% if dispatcher.getControllerName() == "index" %}
    {% include "layout/ad.volt" %}
{% endif %}

<!-- Page Content -->
<div class="container">

    {{ content() }}

    <hr>

    <!-- Footer -->
    <footer>
        <div class="row">
            <div class="col-lg-12">
                <p>Copyright &copy; Phalcon+ 2015 - {{date("Y", time())}}. A member of <a href="http://bullsoft.org" target="_blank">BullSoft.org</a>.</p>
            </div>
        </div>
    </footer>

</div>
<!-- /.container -->

{% include "layout/js_foot.volt" %}
{% include "layout/foot.volt" %}