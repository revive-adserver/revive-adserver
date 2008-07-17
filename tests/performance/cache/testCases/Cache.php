<?php

abstract class Cache
{
    protected $aConf;
    protected $connected = false;
    public $counterKey = 'counter';
    protected $numberOfRecords;
    protected $concurrency;
    protected $iterations;

    function __construct($aConf)
    {
        $this->aConf = $aConf;
    }

    static function factory($aConf)
    {
        $className = 'Cache_'.$aConf['type'];
        require_once $className . '.php';
        return new $className($aConf);
    }

    function init($concurrency, $iterations)
    {
        $this->connect();
        $this->concurrency = $concurrency;
        $this->iterations = $iterations;
    }

    abstract function connect();

    abstract function set($key, $val);

    abstract function update($key, $val);

    abstract function get($key);

    abstract function delete($key);

    function invalidateAll()
    {
        for ($c = 0; $c < $this->concurrency; $c++) {
            for ($i = 0; $i < $this->iterations; $i++) {
                $key = $this->getKey($i, $c);
                if (!$this->delete($key)) {
                    return false;
                }
            }
        }
    }

    function getKey($postfix, $prefix)
    {
        return $prefix . 666 . $postfix;
    }

    function updateTest($c, $i)
    {
        $val = serialize('val'.$c.'-'.$i);
        $key = $this->getKey($i, $c);
        if (!$this->set($key, $val)) {
            return false;
        }

        if (!$this->update($key, $val)) {
            return false;
        }

        for($i = 0; $i < TEST_READS; $i++) {
            $check = $this->get($key);
            if ($check != unserialize($val)) {
                return false;
            }
        }
        return true;
    }

    function updateResult()
    {
        $this->connect();
        $results = 0;
        for ($c = 0; $c < $this->concurrency; $c++) {
            for ($i = 0; $i < $this->iterations; $i++) {
                $key = $this->getKey($i, $c);
                if ($this->get($key)) {
                    $results++;
                }
            }
        }
        return $results;
    }
}

?>