<?php

class Cache_memcached extends Cache
{
    private $memcache;
    public $defaultExpire = 1;
    static $counter = 0;

    function __construct($aConf)
    {
        parent::__construct($aConf);
        $this->memcache = new Memcache();
    }

    function __destruct()
    {
        $this->disconnect();
    }

    function invalidateAll()
    {
        $this->connect();
        return $this->memcache->flush();
    }

    function disconnect()
    {
        if ($this->connected) {
            $this->connected = false;
            return $this->memcache->close();
        }
        return true;
    }

    function connect()
    {
        if (!$this->connected) {
            $this->memcache->connect($this->aConf['host'], $this->aConf['port']) or die ("Could not connect");
        }
        return $this->connected;
    }

    function set($key, $val)
    {
        return $this->memcache->set($key, $val);
    }

    function update($key, $val)
    {
        return $this->memcache->replace($key, $val);
    }

    function get($key)
    {
        return $this->memcache->get($key);
    }

    function delete($key)
    {
        return $this->memcache->delete($key);
    }

    function updateCounter()
    {
        echo "-- increment " . self::$counter . "\n";
        self::$counter++;
        return $this->memcache->increment($this->counterKey);
    }
}

?>