<?php

require_once('MDB2.php');

/**
 * Event handling class for Openads deployment system
 *
 */

class Migration
{
    var $mdb2 = null;

    function Migration($mdb2)
    {
        $this->__construct($mdb2);
    }

    function __construct($mdb2)
    {
        $this->mdb2 = $mdb2;
    }

    function logEvent($event, $params=array())
    {
    }

    function backupTable($table)
    {
    }

    function restoreTable($table)
    {

    }

    function copyData($fromTable, $fromColumn, $toTable, $toColumn)
    {

    }

}

?>