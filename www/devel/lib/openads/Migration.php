<?php

require_once('MDB2.php');

/**
 * Event handling class for Openads deployment system
 *
 */

class Migration
{
    var $field_map;

    function Migration()
    {
        $this->__construct();
    }

    function __construct()
    {
		$this->field_map = array();
		// currently the only way to map renamed objects is via manual mapping
	    //$this->field_map['<totablename>']['<tofieldname>'] = array('fromTable'=>'<fromtablename>', 'fromField'=>'<fromfieldname>');
    }

    function logEvent($event, $params=array())
    {
    }

    function copyData($fromTable, $fromColumn, $toTable, $toColumn)
    {
        // do copy data
    }

    function beforeAddTable($table)
    {

    }

    function afterAddTable($table)
    {

    }

    function beforeAddField($table, $field)
    {

    }

    function afterAddField($table, $field)
    {
        if ($this->field_map[$table][$field])
        {
            $fromTable = $this->field_map[$table][$field]['fromTable'];
            $fromField = $this->field_map[$table][$field]['fromField'];
            $this->copyData($fromTable, $fromField, $table, $field);

        }
    }

    function beforeAddIndex($table, $index)
    {

    }

    function afterAddIndex($table, $index)
    {

    }

    function beforeRemoveTable($table)
    {

    }

    function afterRemoveTable($table)
    {

    }

    function beforeRemoveField($table, $field)
    {

    }

    function afterRemoveField($table, $field)
    {

    }

    function beforeRemoveIndex($table, $index)
    {

    }

    function afterRemoveIndex($table, $index)
    {

    }
}

?>