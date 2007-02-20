<?php
/**
 * Table Definition for campaigns
 */
require_once 'DB/DataObject.php';

class DB_DataObjectCommon extends DB_DataObject 
{
   
    function databaseStructure()
    {
        global $_DB_DATAOBJECT;
        
        $_DB_DATAOBJECT['CONFIG']["ini_{$this->_database}"] = array(
            "{$_DB_DATAOBJECT['CONFIG']['schema_location']}/db_schema.ini"
        );
        
        if (!parent::databaseStructure() && empty($_DB_DATAOBJECT['INI'][$this->_database])) {
            return false;
        }
        
        $tableNameWithoutPrefix = $this->__table;

        $this->prefix = $GLOBALS['MAX']['conf']['table']['prefix'];
        $this->__table = $this->prefix . $this->__table;
        
        $configDatabase = &$_DB_DATAOBJECT['INI'][$this->_database];
        
        // "__table" has a prefix already, make sure it points to the same definition as used to before adding prefix
        if (!isset($configDatabase[$this->__table])) {
            $configDatabase[$this->__table] = $configDatabase[$this->tableNameWithoutPrefix];
        }
        
        if (!isset($configDatabase[$this->__table."__keys"])) {
            $configDatabase[$this->__table."__keys"] = $configDatabase[$this->tableNameWithoutPrefix."__keys"];
        }
    }
    
}
