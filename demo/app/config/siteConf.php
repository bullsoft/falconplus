<?php
/**
 * Created by PhpStorm.
 * User: guweigang
 * Date: 16/1/13
 * Time: 16:20
 */

$host = getDI()->get('request')->getHttpHost();

if(strpos($host, "shopbigbang.com") !== false) {
    $tpl = "shopbigbang";
} elseif(strpos($host, "bullsoft.org") !== false) {
    $tpl = "bullsoft";
} else {
    $tpl = "shopbigbang";
}

$siteConf = [
    "dianrong" => [
        // Default
        "headDesc"     => "点融网为广大个人和微小企业提供便利的投融资服务。借款产品灵活、大额、费用低、手续快；投资方式人性友好、回报高、百分百本金保护！Dianrong.com provides online efficient investment and financing services for individuals and SMEs. Better rates, lower cost, faster way to borrowers and more flexible investment, higher returns, 100% principal protection to investors.",
        "headKeywords" => "P2P网贷,P2P网络贷款平台,P2P网络投资平台,P2P投资理财平台,网络贷款平台,团团赚,点融,点融网,点融官网",
        "template"     => $tpl,
        // IndexController
        "index:index"  => "点融网首页",
        // UserController
        "user:webLogin" => "用户登录",
    ],

    "shopbigbang" => [
        "headDesc" => "",
        "headKeywords" => "",
        "template" => $tpl,
    ],

    "bullsoft" => [
        "headDesc" => "布尔软件开放平台",
        "headKeywords" => "",
        "template" => $tpl,
    ]
];

return $siteConf[$tpl];