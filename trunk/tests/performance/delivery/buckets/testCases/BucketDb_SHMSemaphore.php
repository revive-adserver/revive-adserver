<?php

require_once 'BucketDb_SHM.php';
require_once 'classes/ShmSemaphorBucket.php';

class BucketDb_SHMSemaphore extends bucketDb_SHM
{
    public $bucketClass = 'shmSemaphorBucket';

    /**
     * In shared memory case querying the memory is not very fast. One of the reasons
     * is that the zone ids are not saved anywhere and this script is checking all possible
     * zone-creative combinations
     *
     * @return unknown
     */
    function updateResult()
    {
        $counter = 0;
        $oShm = new $this->bucketClass();
        $oShm->open();
        foreach (range(1,TEST_CREATIVES) as $id1) {
            foreach (range(1,TEST_ZONES) as $id2) {
                $key = $oShm->getKey('', $id1, $id2);
                $v = $oShm->read($key);
                if (is_int($v)) {
                    $counter += $v;
                }
            }
        }
        return $counter;
    }
}

?>