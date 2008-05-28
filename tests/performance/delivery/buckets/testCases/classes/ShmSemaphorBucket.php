<?php

class ShmSemaphorBucket
{
    private $projectId = 'B'; // B for buckets
    private $shmId = null;
    private $semId = null;
    private $semKey = 120177; // different than $this->key

    function __construct()
    {
        $this->key     = 120176;
        $this->aBucket = array();
    }

    public function acquireLock()
    {
        $this->semId = sem_get($this->semKey, 1);
        if (!$this->semId) {
            echo __LINE__;
            return false;
        }
        if (!sem_acquire($this->semId)) {
            echo __LINE__;
            return false;
        }
        return true;
    }

    public function releaseLock()
    {
        if (!empty($this->semId)) {
            if (!sem_release($this->semId)) {
                echo __LINE__;
                return false;
            }

        }
        return true;
    }

    public function open()
    {
        $shmKey = ftok(__FILE__, $this->projectId);
        $this->shmId = shm_attach($shmKey); // TEST_CREATIVES * TEST_ZONES * 1024
        $ret = (bool)$this->shmId;
        if (!$ret) {
            echo __LINE__;
        }
        return $ret;
    }

    public function read($key)
    {
        if ($this->shmId) {
            return @shm_get_var($this->shmId, $key);
        }
        return false;
    }

    public function write($key, $value)
    {
        if ($this->shmId) {
            return shm_put_var($this->shmId, $key, $value);
        }
        return false;
    }

    public function close()
    {
        return shm_detach($this->shmId);
    }

    /**
     * Some hashing function should be used here (crc32?)
     *
     * @param string $dateTime
     * @param int $creativeId
     * @param int $zoneId
     * @return int
     */
    public function getKey($dateTime, $creativeId, $zoneId)
    {
        static $keys = array();
        $power = (int) ceil(log(TEST_ZONES, 10));
        return $creativeId * pow(10, $power) + $zoneId;
    }

    public function log($dateTime, $creativeId, $zoneId)
    {
        if (!$this->acquireLock()) {
            return false;
        }
        if (!$this->open()) {
            return false;
        }
        // Log
        $key = $this->getKey($dateTime, $creativeId, $zoneId);
        $counter = $this->read($key);
        if (is_int($counter)) {
            $counter++;
        } else {
            $counter = 1;
        }

        if (!$this->write($key, $counter)) {
            return false;
        }
        if (!$this->close()) {
            return false;
        }

        if (!$this->releaseLock()) {
            return false;
        }

        return true;
    }

    public function drop()
    {
        $this->open();
        if ($this->shmId) {
            $ret = shm_remove($this->shmId);
            $this->shmId = null;
            return $ret;
        }
        return false;
    }
}

?>