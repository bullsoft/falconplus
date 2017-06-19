{% extends "view/main.volt" %}
{% block left %}
    <ul class="parent-menu-list">
        <li>
            <a href="#">服务列表</a>
            <ul class="child-menu-list">
                {% for file in serviceFileList %}
                    {% set classname = pathinfo(file, constant("PATHINFO_FILENAME")) %}
                    <li{% if targetService is defined and targetService == classname %} class="current"{% endif %}><a href="?service={{ classname }}">{{ classname }}</a></li>
                {% endfor %}

            </ul>
        </li>
    </ul>
{% endblock %}

{% block right %}
    {% if targetService is defined %}
        <h2>Service <a href="spec.php?class={{ str_replace("\\", "_", serviceWithNamespace) }}" title="查看详情">{{ serviceWithNamespace }}</a></h2>
        <h3 class="title">描述</h3>
        <div class="refsect1 description" id="list-{$method->name}">
            <div class="methodsynopsis dc-description">
                <pre>{{ class.getDocComment() }}</pre>
            </div>
        </div>
        <h3 class="title">接口定义</h3>
        {% for method in methods %}
            <div class="refsect1 description" id="method-{{ method['name'] }}">
                <div class="methodsynopsis dc-description">
                    <button class="playground-button" id="play-{{ method['name'] }}" method="{{method['name']}}">示例</button>
                    <pre>{{ method['docComment'] }}</pre>
                    <span class="modifier">{{ method['prototype']['visibility'] }}</span>
                    <span class="type"><a href="spec.php?class={{ str_replace("\\", "_", method['prototype']['return']) }}">{{ method['prototype']['return'] }}</a></span>
                    <span class="methodname"><strong>{{ method['name'] }}</strong></span>
                    ( <span class="methodparam">
                        {% for paramName, param in method["prototype"]["arguments"] %}
                            <a href="spec.php?class={{ str_replace("\\", "_", param["type"]) }}">{{ param["type"] }}</a> {% if param["by_ref"] %}&{% endif %}${{ paramName }}
                            {% if param["required"] %}
                            {% else %}
                                = {{ var_export(param["default"], true) }}
                            {% endif %}
                            {% if loop.last == false %}
                                ,
                            {% endif %}
                        {% endfor %}
                      </span>
                    )
                </div>
            </div>
            <div class="example" id="example-{{ method['name'] }}" style="display:none;">
                <div class="phpcode">
                    <code>
                        {{ highlight_string(method['sampleCode'], true) }}
                    </code>
                </div>
                <div style="text-align:right">
                    <button>可惜,不能运行</button>
                </div>
            </div>
        {% endfor %}
    {% else %}
        <h2>{{ welcome }}</h2>
        <pre>
            <code>
   ____  _           _                   ____  _
 |  _ \| |__   __ _| | ___ ___  _ __   |  _ \| |_   _ ___
 | |_) | '_ \ / _` | |/ __/ _ \| '_ \  | |_) | | | | / __|
 |  __/| | | | (_| | | (_| (_) | | | | |  __/| | |_| \__ \
 |_|   |_| |_|\__,_|_|\___\___/|_| |_| |_|   |_|\__,_|___/
            </code>
        </pre>
    {% endif %}
{% endblock %}

{% block js_footer %}
    <style type="text/css">
     .playground-button {
         letter-spacing: 1px;
         font-weight: bold;
         width: 75px;
         height: 24px;
         font-size: 15px;
         line-height: 21px;
         background-color: rgba(0, 0, 0, 0.15);
         border-width: 0;
         opacity: 0.5;
     }
    </style>

    <script type="text/javascript">
     vex.defaultOptions.className='vex-theme-os';
     $(document).ready(function(){
         $(".playground-button").click(function(){
             var example = "#example-" + $(this).attr("method");
             vex.open({
                 content: $(example).html(),
                 afterOpen: function($vexContent) {
                     return $vexContent.append($el);
                 },
                 afterClose: function() {
                     return console.log('vexClose');
                 },
                 appendLocation: 'section'
             });
         })
     })
    </script>
{% endblock %}
