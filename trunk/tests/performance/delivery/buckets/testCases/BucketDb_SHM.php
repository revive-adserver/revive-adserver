<?php

require_once 'classes/ShmBucket.php';
require_once 'BucketDB.php';

class BucketDb_SHM extends bucketDB
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

?>