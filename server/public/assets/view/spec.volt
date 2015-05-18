{% extends "view/main.volt" %}
{% block left %}
    <ul class="parent-menu-list">
        <li>
            <a href="#">属性列表</a>
            <ul class="child-menu-list">
                {% for prop in properties %}
                    <li><a href="#">${{prop.name}}</a></li>
                {% endfor %}
            </ul>
        </li>
        <li>
            <a href="#">方法列表</a>
            <ul class="child-menu-list">
                {% for method in methods %}
                    <li><a href="#method-{{ method["name"] }}">{{ method["name"] }}()</a></li>
                {% endfor %}
            </ul>
        </li>
    </ul>
{% endblock %}

{% block right %}
    <h2>Class {{ class }}</h2>
    {% if parentClass %}
        <ul class="child-menu-list">
            <li>
                <a href="?class={{ str_replace('\\', '_', parentClass) }}">{{ parentClass }}</a>
            </li>
        </ul>
    {% endif %}

    <h3 class="title">常量列表</h3>
    <table class="doctable informaltable" style ="margin:10px 10px; width=90%">
        <thead>
            <tr>
                <th>名称</th>
                <th>值</th>
                <th>说明</th>
            </tr>
        </thead>

        <tbody class="tbody">
            {% for const in consts %}
                <tr>
                    <td>{{ const.getName() }}</td>
                    <td>{{ const.getValue() }}</td>
                    <td>{{ const.getDocComment() }}</td>
                </tr>
            {% endfor %}
            <tr><td colspan=3>&nbsp;</td></tr>
        </tbody>

    </table>

    <h3 class="title">属性列表</h3>
    <table class="doctable informaltable" style ="margin:10px 10px; width=90%">
        <thead>
            <tr>
                <th>名称</th>
                <th>类型</th>
                <th>是否必须</th>
                <th>说明</th>
            </tr>
        </thead>

        <tbody class="tbody">
            {% for prop in properties %}
                <tr>
                    <td><span style="color:#693"></span> ${{ prop.name }}</td>
                    {% if prop.getDocBlock() %}
                        <td>{{ ltrim(prop.getDocBlock().getTag("var").getContent(), "\\") }}</td>
                        <td>{{ prop.getDocBlock().hasTag("required") }}</td>
                        <td></td>
                    {% else %}
                        <td></td>
                        <td></td>
                        <td></td>
                    {% endif %}
                </tr>
            {% endfor %}
            <tr><td colspan=4>&nbsp;</td></tr>
        </tbody>
    </table>

    <h3 class="title">方法列表</h3>


    {% for method in methods %}
        <div class="refsect1 description" id="method-{{ method['name'] }}">
            <div class="methodsynopsis dc-description">
                <pre>{{ method['docComment'] }}</pre>
                <span class="modifier">{{ method['prototype']['visibility'] }}</span>
                <span class="type">
                    {% if method['prototype']['return'] == "mixed" %}
                        mixed
                    {% else %}
                    <a href="spec.php?class={{ str_replace("\\", "_", method['prototype']['return']) }}">
                        {{ method['prototype']['return'] }}
                    </a>
                    {% endif %}
                </span>
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
    {% endfor %}

{% endblock %}
