<?php

abstract class Cache
{
    protected $aConf;
    protected $connected = false;
    public $counterKey = 'counter';
    public $numberOfRecords = 1000;

    function __construct($aConf)
    {
        $this->aConf = $aConf;
    }

    function __destruct()
    {
    }

    static function factory($aConf)
    {
        $className = 'Cache_'.$aConf['type'];
        require_once $className . '.php';
        return new $className($aConf);
    }

    abstract function connect();

    abstract function set($key, $val);

    abstract function update($key, $val);

    abstract function get($key);

    abstract function delete($key);

    abstract function invalidateAll();

    function updateTest($key, $val)
    {
//        if (!$this->update($key, $val)) {
//            if (!$this->set($key, $val)) {
//                return false;
//            }
//        }
        return $this->updateCounter();
        return true;

        $check = $this->get($key);
        if ($check != $val) {
            return false;
        }
        if (!$this->delete($key)) {
            return false;
        }
        return $this->updateCounter();
    }

    function updateCounter()
    {
        $check = $this->get($this->counterKey);
        if ($check) {
            return $this->update($this->counterKey, ++$check);
        } else {
            return $this->set($this->counterKey, 1);
        }
    }

    function updateResult()
    {
        $this->connect();
        return $this->get($this->counterKey);
    }

    function init()
    {
        $this->connect();
        return $this->set($this->counterKey, 0);
    }
}

?>