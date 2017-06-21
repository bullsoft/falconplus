<?php
return array(
    'application' => array(
        "name"  => "site",
        "ns"    => "Plus\\Web\\",
        "mode"  => "Web",
        "staticUri" => "/",
        "url" => "http://localhost:8081/",
        "logFilePath" => "/tmp/Plus_site.log",
    ),
    "view" => array(
        "compiledPath"      => "/tmp/compiled/",
        "compiledExtension" => ".compiled",
    ),
    'db' => array(
        "host" => "127.0.0.1",
        "port" => 3306,
        "username" => "root",
        "password" => "",
        "dbname" => "test",
        "charset" => "utf8",
        "timeout" => 3, // 3 秒
    ),
    "sayings" => [
        "UNIX很简单。但需要有一定天赋的人才能理解这种简单。 - Dennis Ritchie",
        "软件在能够复用前必须先能用。 - Ralph Johnson",
        "优秀的判断力来自经验，但经验来自于错误的判断。- Fred Brooks",
        "'理论’是你知道是这样，但它却不好用。‘实践’是它很好用，但你不知道是为什么。程序员将理论和实践结合到一起：既不好用，也不知道是为什么。 - ???",
        "当你想在你的代码中找到一个错误时，这很难；当你认为你的代码是不会有错误时，这就更难了。- Steve McConnell 《代码大全》",
        "如果建筑工人盖房子的方式跟程序员写程序一样，那第一只飞来的啄木鸟就将毁掉人类文明。 - Gerald Weinberg",
        "项目开发的六个阶段：充满热情 -> 醒悟 -> 痛苦 -> 找出罪魁祸首 -> 惩罚无辜 -> 褒奖闲人。 - ???",
        "优秀的代码是它自己最好的文档。当你考虑要添加一个注释时，问问自己, 「如何能改进这段代码，以让它不需要注释？ 」 - Bertrand Russell",
        "无论在排练中演示是如何的顺利(高效)，当面对真正的现场观众时，出现错误的可能性跟在场观看的人数成正比。 - ???",
        "罗马帝国崩溃的一个主要原因是，没有0，他们没有有效的方法表示他们的C程序成功的终止。 - Robert Firth",
        "C程序员永远不会灭亡。他们只是cast成了void。 -  ???",
        "如果debugging是一种消灭bug的过程，那编程就一定是把bug放进去的过程。 - Edsger Dijkstra",
        "你要么要软件质量，要么要指针算法；两者不可兼得。 - Bertrand Meyer",
        "有两种方法能写出没有错误的程序；但只有第三种好用。 - Alan J. Perlis",
        "用代码行数来测评软件开发进度，就相对于用重量来计算飞机建造进度。 - 比尔-盖茨",
        "最初的90%的代码用去了最初90%的开发时间。余下的10%的代码用掉另外90%的开发时间。 - Tom Cargill",
        "程序员和上帝打赌要开发出更大更好——傻瓜都会用的软件。而上帝却总能创造出更大更傻的傻瓜。所以，上帝总能赢。 - Anon",
    ],
);