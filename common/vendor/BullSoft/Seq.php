<?php
namespace BullSoft;

class Seq
{
    const CACHE_PREFIX = 'id-sequcence:';
    const STEP = 500;

    private $dbConf = array();
    private $cacheConf = array();

    private $cacheClient = null;
    private $dbClient = null;

    /**
     * Config Sample
     <code>
     $dbConf = array(
        'host' => '127.0.0.1',
        'port' => '3306',
        'username' => 'root',
        'password' => '',
        'dbname' => 'test',
        'charset' => 'utf8',
     );
     $cacheConf = array(
        'host' => '127.0.0.1',
        'port' => 6379,
        'db'   => 1,
        'timeout' => 1,
     );
     </code>
     *
     */
    public function __construct(array $dbConf, array $cacheConf)
    {
        $this->dbConf = $dbConf;
        $this->cacheConf = $cacheConf;
    }

    private function initCacheClient()
    {
        if($this->cacheClient !== null) {
            return ;
        }
        $this->cacheClient = new \Redis();
        try {
            $this->cacheClient->connect($this->cacheConf['host'], $this->cacheConf['port'], $this->cacheConf['timeout']);
            $this->cacheClient->select($this->cacheConf['db']);
        } catch(\Exception $e) {
            // @TODO ...
            echo "redis: Connection failed: " . $e->getMessage();
        }
    }

    private function initDbClient()
    {
        if($this->dbClient !== null) {
            return ;
        }
        $dsn = "mysql:dbname=".$this->dbConf["dbname"].";host=".$this->dbConf['host'].";port=".$this->dbConf['port'];
        try {
            $this->dbClient = new \PDO(
                $dsn,
                $this->dbConf['username'],
                $this->dbConf['password'],
                array(
                    \PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES '{$this->dbConf['charset']}'",
                )
            );
        } catch (PDOException $e) {
            // @TODO ...
            echo 'mysql: Connection failed: ' . $e->getMessage();
        }
    }

    /**
     * 初始化序列
     */
    public function create($app, $bucket, $start = 0)
    {
        $this->initDbClient();
        $sql = "SET @maxId = (SELECT MAX(`id`) FROM `generation`); " .
             "INSERT INTO `generation` (`id`, `app`, `bucket`, `seq`) VALUES " .
             "(@maxId+1, '{$app}', '{$bucket}', '{$start}');";
        $rows = $this->dbClient->exec($sql);
        if($rows <= 0) {
            throw new \Exception("初始化ID序列失败");
        }
        return true;
    }

    /**
     * 序列发生器
     */
    public function generate($app, $bucket, $step = 0)
    {
        $this->initCacheClient();
        $cacheKey = self::CACHE_PREFIX . $app . ":" . $bucket;
        if($step <= 500) {
            $step = self::STEP;
        }

        if($pk = $this->cacheClient->lPop($cacheKey)) {
            return $pk;
        } else {
            $this->initDbClient();
            $sql = "UPDATE `generation` SET `seq` = LAST_INSERT_ID(`seq` + {$step}) WHERE `app`='{$app}' AND `bucket`='{$bucket}'";
            $rows = $this->dbClient->exec($sql);
            if($rows <= 0) {
                throw new \Exception("网络繁忙");
            }
            $sequence = $this->dbClient->lastInsertId();
            $this->push($cacheKey, $sequence, $step);
            $pk = $this->generate($app, $bucket, $step);
            return $pk;
        }
    }

    /**
     * Redis事务，向Redis中插入序列
     */
    private function push($cacheKey, $sequence, $step)
    {
        $this->initCacheClient();
        $this->cacheClient->watch($cacheKey);
        $this->cacheClient->multi();
        for ($i = $step; $i > 0; $i--) {
            $this->cacheClient->rPush($cacheKey, $sequence - $i + 1);
        }
        $this->cacheClient->exec();
    }
    
    public function getList($app = "")
    {
        $this->initDbClient();
        $sql = "SELECT * FROM `generation`";
        if($app != "") {
            $sql .= " WHERE `app` = '{$app}'";
        }
        $rows = $this->dbClient->query($sql);
        return $rows->fetchAll(\PDO::FETCH_ASSOC);
    }
}