<?php

declare(ticks=1);

if (PHP_SAPI != 'cli') die('Hey, CLI only!');

define('TEST_ITERATIONS', 100);

require "Benchmark/Timer.php";

$t = new Benchmark_Timer();
$t->start();

$aTests = array(
    25,
    50,
    75,
    100
);

$t->setMarker('Script init');

foreach ($aTests as $concurrency) {

    $oTest = bucketDB::factory(array(
        'type' => 'mysql',
        'host' => 'localhost',
        'user' => 'root',
        'password' => 'password',
        'dbname' => 'test_bucket',
        'engine' => 'MyISAM'
    ));
    test_update($oTest, $concurrency, $t, 'MyISAM');


    $oTest = bucketDB::factory(array(
        'type' => 'mysql',
        'host' => 'localhost',
        'user' => 'root',
        'password' => 'password',
        'dbname' => 'test_bucket',
        'engine' => 'InnoDB'
    ));
    test_update($oTest, $concurrency, $t, 'InnoDB');


    $oTest = bucketDB::factory(array(
        'type' => 'mysql',
        'host' => 'localhost',
        'user' => 'root',
        'password' => 'password',
        'dbname' => 'test_bucket',
        'engine' => 'MEMORY'
    ));
    test_update($oTest, $concurrency, $t, 'MEMORY');


    $oTest = bucketDB::factory(array(
        'type' => 'pgsql',
        'port' => 5432,
        'host' => 'localhost',
        'user' => 'pgsql',
        'password' => 'password',
        'dbname' => 'test_bucket'
    ));
    test_update($oTest, $concurrency, $t, 'PgSQL ');

    $oTest = bucketDB::factory(array(
        'type' => 'shm'
    ));
    test_update($oTest, $concurrency, $t, 'SHM   ');

    $oTest = bucketDB::factory(array(
        'type' => 'shmSemaphore'
    ));
    test_update($oTest, $concurrency, $t, 'SHMSEM');
}


$t->stop();

$t->display();

exit;

function test_update($oTest, $concurrency, $t, $text)
{
    $oTest->updateCreate();
    $oTest->disconnect();

    for ($c = 0; $c < $concurrency; $c++) {
        mt_srand(1000 + $c);
        $pid = pcntl_fork();
        if ($pid == 0) {
            $oTest->connect();
            for ($i = 0; $i < TEST_ITERATIONS; $i++) {
                $oTest->updateTest('2008-05-16 16:00:00', mt_rand(1,2), mt_rand(1,2)) ? 1 : 0;
            }
            exit;
        }
    }

    $status = 0;
    while (pcntl_wait($status) > 0);

    $result = $oTest->updateResult();
    $fail = $concurrency * TEST_ITERATIONS - $result == 0 ? 'OK' : "ERR: {$result}";

    $oTest->updateDrop();

    $t->setMarker("{$text} - C{$concurrency} - {$fail}");
}


abstract class bucketDB
{
    protected   $aConf;
    protected   $db;
    protected   $tableName;
    protected   $hasTransactions;

    function __construct($aConf)
    {
        $this->aConf = $aConf;
        $this->tableName = 'test_'.mt_rand(1000,1999);
    }

    function __destruct()
    {
        $this->disconnect();
    }

    static function factory($aConf)
    {
        $className = 'bucketDB_'.$aConf['type'];
        return new $className($aConf);
    }

    abstract function connect();

    abstract function disconnect();

    abstract function query($sql);

    abstract function fetch($result);

    abstract function error();

    abstract function affectedRows($result);

    abstract function updateCreate();

    function updateDrop()
    {
        $this->query("DROP TABLE {$this->tableName}");
    }

    function updateTest($date_time, $creative_id, $zone_id)
    {
        $updateSql = "UPDATE {$this->tableName} SET counter = counter + 1 WHERE date_time = '$date_time' AND creative_id = $creative_id AND zone_id = $zone_id";
        $result = $this->query($updateSql);
        if (!$this->affectedRows($result)) {
            if ($this->hasTransactions) {
                $this->query("BEGIN");
            }
            $result = $this->query("INSERT INTO {$this->tableName} VALUES ('$date_time', $creative_id, $zone_id, 1)");
            if (!$result) {
                if ($this->hasTransactions) {
                    $this->query("ROLLBACK");
                }
                $result = $this->query($updateSql);
            } else {
                if ($this->hasTransactions) {
                    $this->query("COMMIT");
                }
            }
        }

        return (bool)$result;
    }

    function updateResult()
    {
        $result = $this->query("SELECT SUM(counter) AS cnt FROM {$this->tableName}");
        $row = $this->fetch($result);
        return (int)$row['cnt'];
    }
}

class bucketDb_MySQL extends bucketDB
{
    function __construct($aConf)
    {
        $aConf['engine'] = empty($aConf['engine']) ? 'MyISAM' : $aConf['engine'];
        parent::__construct($aConf);

        $this->hasTransactions  = strtolower($this->aConf['engine']) == 'innodb';
    }

    function connect()
    {
        $host = $this->aConf['host'].':'.(empty($this->aConf['port']) ? 3306 : $this->aConf['port']);
        $this->db = mysql_connect($host, $this->aConf['user'], $this->aConf['password'], true);
        return @mysql_select_db($this->aConf['dbname'], $this->db);
    }

    function disconnect()
    {
        if (!empty($this->db)) {
            mysql_close($this->db);
            $this->db = null;
        }
    }

    function query($sql)
    {
        if (!empty($this->db) || $this->connect()) {
            return @mysql_query($sql, $this->db);
        }
        return false;
    }

    function error()
    {
        return mysql_error($this->db);
    }

    function fetch($result)
    {
        return mysql_fetch_assoc($result);
    }

    function affectedRows($result)
    {
        return mysql_affected_rows($this->db);
    }

    function updateCreate()
    {
        $sql = "
            CREATE TABLE {$this->tableName} (
                date_time datetime NOT NULL,
                creative_id int NOT NULL,
                zone_id int NOT NULL,
                counter int NOT NULL DEFAULT 1,
                PRIMARY KEY (date_time, creative_id, zone_id)
            ) ENGINE={$this->aConf['engine']}
        ";
        $this->query($sql) or die($this->error());
    }
}

class bucketDb_PgSQL extends bucketDB
{
    function  __construct($aConf)
    {
        parent::__construct($aConf);
        $this->hasTransactions = true;
    }

    function connect()
    {
        $host = !empty($this->aConf['host']) ? "host={$this->aConf['host']} " : '';
        $port = empty($this->aConf['port']) ? 5432 : $this->aConf['port'];
        return $this->db = pg_connect("{$host}port={$port} user={$this->aConf['user']} password={$this->aConf['password']} dbname={$this->aConf['dbname']}", PGSQL_CONNECT_FORCE_NEW);
    }

    function disconnect()
    {
        if (!empty($this->db)) {
            pg_close($this->db);
            $this->db = null;
        }
    }

    function query($sql)
    {
        if (!empty($this->db) || $this->connect()) {
            return @pg_query($this->db, $sql);
        }
        return false;
    }

    function error()
    {
        return pg_errormessage($this->db);
    }

    function fetch($result)
    {
        return pg_fetch_assoc($result);
    }

    function affectedRows($result)
    {
        return @pg_affected_rows($result);
    }

    function updateCreate()
    {
        $sql = "
            CREATE TABLE {$this->tableName} (
                date_time timestamp(0) NOT NULL,
                creative_id int NOT NULL,
                zone_id int NOT NULL,
                counter int NOT NULL DEFAULT 1,
                PRIMARY KEY (date_time, creative_id, zone_id)
            )
        ";
        $this->query($sql) or die($this->error());
    }
}

class bucketDb_SHM extends bucketDB
{
    public $bucketClass = 'shmBucket';

    function connect()
    {
        $this->oShm = new $this->bucketClass();
    }

    function disconnect()
    {
    }

    function query($sql)
    {
    }

    function fetch($result)
    {
    }

    function affectedRows($result)
    {
    }

    function error()
    {
    }

    function updateCreate()
    {
        $this->updateDrop();
    }

    function updateTest($date_time, $creative_id, $zone_id)
    {
        $oShm = new $this->bucketClass();
        $oShm->log($date_time, $creative_id, $zone_id);
    }

    function updateResult()
    {
        $oShm = new $this->bucketClass();
        if ($aBucket = $oShm->get()) {
            $count = 0;
            foreach ($aBucket as $v) {
                $count += $v;
            }
            return $count;
        }
        return 0;
    }

    function updateDrop()
    {
        $oShm = new $this->bucketClass();
        $oShm->drop();
    }
}

class bucketDb_SHMSemaphore extends bucketDb_SHM
{
    public $bucketClass = 'shmSemaphorBucket';
}


class shmBucket
{
    public $key;
    public $id;
    public $shmSize;
    public $aBucket;
    private $fpLock;

    function __construct()
    {
        $this->key     = 120176;
        $this->aBucket = array();
    }

    public function acquireLock()
    {
        $this->fpLock = fopen('buckets.lock', 'w');
        return flock($this->fpLock, LOCK_EX);
    }

    public function releaseLock()
    {
        return flock($this->fpLock, LOCK_UN);
    }

    public function log($dateTime, $creativeId, $zoneId)
    {
        if (!$this->acquireLock()) {
            return false;
        }

        if (!$this->open()) {
            if (!$this->create()) {
                $this->open();
            }
        }

        $ret = false;
        if (!empty($this->id)) {
            $this->read();

            // Log
            $key = "{$dateTime}|{$creativeId}|$zoneId}";
            if (isset($this->aBucket[$key])) {
                $this->aBucket[$key]++;
            } else {
                $this->aBucket[$key] = 1;
            }

            $this->write();
            $this->close();

            $ret = true;
        }

        if (!$this->releaseLock()) {
            return false;
        }

        return $ret;
    }

    public function drop()
    {
        if ($this->open()) {
            $this->delete();
            $this->close();
        }
    }

    public function get()
    {
        if ($this->open()) {
            $this->read();
            $this->close();
            return $this->aBucket;
        }
    }

    public function read()
    {
        if (!empty($this->id) && !isset($this->shmSize)) {
            $header = shmop_read($this->id, 0, 16);
            $aHeader = unpack('lcrcHeader/lshmSize/ldataSize/lcrcData', $header);
            $crcHeader = crc32(substr($header, 1));
            $crcHeader = 0;
            if ($crcHeader == $aHeader['crcHeader']) {
                $this->shmSize = $aHeader['shmSize'];
                if ($aHeader['dataSize'] > 0) {
                    $data = shmop_read($this->id, 16, $aHeader['dataSize']);
                    $crcData = crc32($data);
                    $crcData = 0;
                    if (crcData == $aHeader['crcData']) {
                        $this->aBucket = unserialize($data);
                        return true;
                    }
                }
            } else {
                // Damaged!
                $this->recreate();
            }
        }

        return false;
    }

    public function write()
    {
        if (!empty($this->id)) {
            $data   = serialize($this->aBucket);
            $length = strlen($data);
            $totalLength = $length + 16;
            if ($totalLength > $this->shmSize) {
                $this->recreate($totalLength);
            }
            $crc    = crc32($data);
            $crc    = 0;
            $header = pack('lll', $this->shmSize, $length, $crc);
            $crc    = crc32($header);
            $crc    = 0;
            $header = pack('l',  $crc).$header;
            if (shmop_write($this->id, $header, 0) == 16) {
                if (shmop_write($this->id, $data, 16) == $length) {
                    return true;
                }
            }
        }

        return false;
    }

    public function open()
    {
        $this->id = @shmop_open($this->key, 'w', 0, 0);
        return (bool)$this->id;
    }

    public function create($minSize = false)
    {
        // Default to current size or 64kiB
        $size = !empty($this->shmSize) ? empty($this->shmSize) : 65536;

        // Double the size until it fits
        while ($size <= $minSize) {
            $size *= 2;
        }

        $this->id = @shmop_open($this->key, 'n', 0644, $size);
        if (!empty($this->id)) {
            $this->shmSize = $size;
            return true;
        }
        return false;
    }

    public function delete()
    {
        if (!empty($this->id)) {
            @shmop_delete($this->id);
        }
    }

    public function recreate($minSize = false)
    {
        $this->delete();
        return $this->create($minSize);
    }

    public function close()
    {
        if (!empty($this->id)) {
            shmop_close($this->id);
        }
    }


}


/**
 * @TODO - add sem_remove, currently semaphores are removed when script ends
 *
 */
class shmSemaphorBucket extends shmBucket
{
    private $semId = null;

    public function acquireLock()
    {
        $this->semId = sem_get($this->key, 1);
        if (!$this->semId) {
            return false;
        }
        if (!sem_acquire($this->semId)) {
            return false;
        }
        return true;
    }

    public function releaseLock()
    {
        if (!empty($this->semId)) {
            if (!sem_release($this->semId)) {
                return false;
            }

        }
        return true;
    }
}

?>