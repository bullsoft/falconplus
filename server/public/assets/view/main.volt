{% include "view/head.volt" %}
<div class="clearfix">
    <aside class="layout-menu">
        {% block left %}
        {% endblock%}
    </aside>

    <section id="layout-content" style="min-height: 400px;">
        {% block right %}
        {% endblock %}
    </section>

    <div style="clear:both"></div>
</div>
{% block js_footer %}
{% endblock %}
{% include "view/tail.volt" %}
