<?php

class Cache_memcached extends Cache
{
    /**
     * Memcache class
     *
     * @var Memcache
     */
    private $cache;
    public $defaultExpire = 1;
    static $counter = 0;

    function __construct($aConf)
    {
        parent::__construct($aConf);
        $this->cache = new Memcache();
    }

    function __destruct()
    {
        $this->disconnect();
    }

    function invalidateAll()
    {
        $this->connect();
        return $this->cache->flush();
    }

    function disconnect()
    {
        if ($this->connected) {
            $this->connected = false;
            return $this->cache->close();
        }
        return true;
    }

    function connect()
    {
        if (!$this->connected) {
            $this->cache->connect($this->aConf['host'], $this->aConf['port'])
                or die ("Could not connect");
        }
        return $this->connected;
    }

    function set($key, $val)
    {
        return $this->cache->set($key, $val);
    }

    function update($key, $val)
    {
        return $this->cache->replace($key, $val);
    }

    function get($key)
    {
        return $this->cache->get($key);
    }

    function delete($key)
    {
        return $this->cache->delete($key);
    }
}

?>