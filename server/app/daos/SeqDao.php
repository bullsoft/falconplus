<?php
namespace Demo\Server\Daos;

class SeqDao
{
    private static $seq = null;

    private static function setUp()
    {
        if(is_null(self::$seq)) {
            self::$seq = new \BullSoft\Seq(getDI()->getConfig()->dbCommon->toArray(), getDI()->getConfig()->redis->toArray());
        }
    }

    public static function create($app, $bucket, $start = 0)
    {
        self::setUp();
        return self::$seq->create($app, $bucket, $start);
    }

    public static function generate($app, $bucket, $step = 0)
    {
        self::setUp();
        return (int) self::$seq->generate($app, $bucket, $step);

    }
}