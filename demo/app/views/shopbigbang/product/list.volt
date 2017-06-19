{% extends 'nav_base.volt' %}

{% block right %}
<ul class="nav nav-tabs">
    {% for item in tops %}
    <li{% if this.request.getQuery("type", "string", "p2p") == item['slug'] %} class="active"{% endif %}><a href="{{ url('product/list?type=') }}{{item['slug']}}&id={{item['id']}}">{{item['name']}}</a></li>
    {% endfor %}
</ul>

<div class="well" style="margin-top: 10px">
    {% for option in fields %}
    {% if option['inputType'] == "OPTION" %}
    <div class="row">
        <div class="col-md-9">
            <form class="form-inline">
                <div class="form-group">
                    <span class="">{{option['displayName']}}</span>:
                    {% set vals = explode(",", option['defaultValue']) %}
                    {% set desc = explode(",", option['fieldDesc']) %}
                    {% for val in vals %}
                    <label class="checkbox-inline">
                        <input type="checkbox" value="{{val}}">{{desc[loop.index-1]}}
                    </label>
                    {% endfor %}
                </div>
            </form>
        </div>
    </div>
    {% endif %}
    {% endfor %}
</div>


<div class="row product-list">
		<div class="list-group">
        {% for sku in skus %}
        <div href="#" class="list-group-item">
            <div class="media col-md-3">
                <figure class="pull-left">
                    <img class="media-object img-rounded img-responsive"  src="http://placehold.it/350x250" alt="placehold.it/350x250" >
                </figure>
            </div>
            <div class="col-md-6">
                <h4 class="list-group-item-heading">{{sku['name']}}</h4>
                <div style="margin-top: 20px"></div>
                {% set exts = explode("@@", sku['extends']) %}
                {% for ext in exts %}
                {% if loop.index % 2 != 0 %}
                <div class="row">
                    {% set attrs1 = explode("||", exts[loop.index-1]) %}
                    <div class="col-md-6">{{attrs1[3]}}: {{__invoke__("Volt::showField", fields, attrs1)}} </div>
                    {% if exts[loop.index] is not empty %}
                    {% set attrs2 = explode("||", exts[loop.index]) %}
                    <div class="col-md-6">{{attrs2[3]}}：{{__invoke__("Volt::showField", fields, attrs2)}} </div>
                    {% endif %}
                </div>
                {% endif %}
                {% endfor %}
                <div class="row">
                    <div class="col-md-3">投资进度</div>
                    <div class="col-md-9">
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" aria-valuenow="70"
                             aria-valuemin="0" aria-valuemax="100" style="width:70%">
                            70%
                        </div>
                    </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 text-center">
                <h2> 14240人 <small> 参与 </small></h2>
                <form action="" method="POST" class="invest-form" id="investForm-{{sku['id']}}">
                    <div class="form-group">
                        <input type="hidden" value="{{sku['id']}}" class="investSkuId">
                        <div class="input-group">
                            <div class="input-group-addon">￥</div>
                            <input type="text" class="form-control quantity" id="investAmount-{{sku['id']}}" placeholder="投资金额" value="100">
                            <div class="input-group-addon">.00</div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-default btn-lg btn-block invest-btn"> 投资 </button>
                </form>
            </div>
        </div>
        {% endfor %}
    </div>
</div>
{% endblock %}

