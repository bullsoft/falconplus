<?php
use Demo\Server\Models\Kv as KvModel;
use Demo\Server\Models\DealRecord as DRModel;
use PhalconPlus\Db\UnitOfWork as UnitOfWork;

class TestTask extends \Phalcon\CLI\Task
{
    public function mainAction(array $params = []) {
        var_dump($params);
        return 1;
    }

    public function test1Action()
    {
        KvModel::$shardKey = 1;
        $a = KvModel::findFirst("userId=2 AND key='a0'");
        $profiles = $this->di->get("profiler")->getProfiles();
        foreach ($profiles as $profile) {
            echo "SQL Statement: ", $profile->getSQLStatement(), "\n";
            echo "Start Time: ", $profile->getInitialTime(), "\n";
            echo "Final Time: ", $profile->getFinalTime(), "\n";
            echo "Total Elapsed Time: ", $profile->getTotalElapsedSeconds(), "\n";
            echo "==========================" . "\n";
        }
        //var_dump($a->toArray());
    }

    public function testAction()
    {
        $work = new UnitOfWork("dbDemo");
        $dr = DRModel::findFirst(8);
        $dr->ctime = "2015-10-24 17:25:00";
        $work->save("drtime", $dr);
        
        $kv = new KvModel();
        $kv->key = "foo2";
        $kv->val = "bar2";
        $work->save("testKV", $kv);
        
        $work->exec();
        
        $profiles = $this->di->get("profiler")->getProfiles();
        foreach ($profiles as $profile) {
            echo "SQL Statement: ", $profile->getSQLStatement(), "\n";
            echo "Start Time: ", $profile->getInitialTime(), "\n";
            echo "Final Time: ", $profile->getFinalTime(), "\n";
            echo "Total Elapsed Time: ", $profile->getTotalElapsedSeconds(), "\n";
            echo "==========================" . "\n";
        }
    }
}
