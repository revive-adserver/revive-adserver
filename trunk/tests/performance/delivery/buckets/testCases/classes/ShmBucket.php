<?php

class ShmBucket
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
                    if ($crcData == $aHeader['crcData']) {
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

?>