<?php

require_once dirname(__FILE__) . './../lib/PHPDance/sharedance.class.php';

class Cache_sharedance extends Cache
{
    /**
     * Memcached class
     *
     * @var Sharedance
     */
    private $cache;

    function __construct($aConf)
    {
        parent::__construct($aConf);
        $this->cache = new Sharedance();
//        $this->cache->addServer(new SharedanceServer($aConf['host']));
    }

    function __destruct()
    {
        $this->disconnect();
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
        try {
            $this->cache->connect(new SharedanceServer($this->aConf['host']));
        } catch(SharedanceException $e) {
            debug($e);
            die ("Could not connect\n");
        }
    }

    function set($key, $val)
    {
        try {
            $this->connect();
            $this->cache->set($key, $val);
        } catch (SharedanceException $e) {
            debug($e);
            return false;
        }
        return true;
    }

    function update($key, $val)
    {
        $this->connect();
        return $this->set($key, $val);
    }

    function get($key)
    {
        try {
            $this->connect();
            return $this->cache->get($key);
        } catch (SharedanceException $e) {
            debug($e);
            return false;
        }
    }

    function delete($key)
    {
        try {
            $this->connect();
            $this->cache->delete($key);
        } catch (SharedanceException $e) {
            debug($e);
            return false;
        }
        return true;
    }
}

?>