<?php
class OA_BaseUpgradeAuditor
{

    // needs to be defined in the child class
    var $action_table_xml_filename;

    var $logTable   = '';

	function OA_BaseUpgradeAuditor()
	{
	}

	/**
     * audit actions taken
     *
     * @param array $aParams
     * @return boolean
     */
    function logAuditAction($aParams=array())
    {
        $aParams = $this->_escapeParams($aParams);
        $columns = implode(",", array_keys($this->aParams)).','.implode(",", array_keys($aParams));
        $values  = implode(",", array_values($this->aParams)).','.implode(",", array_values($aParams));

        $query = "INSERT INTO {$this->prefix}{$this->logTable} ({$columns}, updated) VALUES ({$values}, '". OA::getNow() ."')";
        $result = $this->oDbh->exec($query);

        if ($this->isPearError($result, "error inserting {$this->prefix}{$this->logTable}"))
        {
            return false;
        }
        return true;
    }

    function setKeyParams($aParams='')
    {
        $this->aParams = $this->_escapeParams($aParams);
    }

    /**
     * the action_table_name table must exist for all upgrade events
     * currently the schema is stored in a separate xml file which is not part of an upgrade pkg
     * eventually this table schema should be merged into the core tables schema
     *
     * @return boolean
     */
    function _createAuditTable()
    {
        $xmlfile = MAX_PATH.$this->action_table_xml_filename;

        $oTable = new OA_DB_Table();
        $oTable->init($xmlfile);
        return $oTable->createTable($this->logTable);
    }

    function _checkCreateAuditTable()
    {
        $this->aDBTables = $this->oDbh->manager->listTables();
        if (!in_array($this->prefix.$this->logTable, $this->aDBTables))
        {
            $this->log('creating '.$this->logTable.' audit table');
            if (!$this->_createAuditTable())
            {
                $this->logError('failed to create '.$this->logTable.' audit table');
                return false;
            }
            $this->log('successfully created '.$this->logTable.' audit table');
        }
        return true;
    }

    function _escapeParams($aParams)
    {
        foreach ($aParams AS $k => $v)
        {
            $aParams[$k] = $this->oDbh->quote($v);
        }
        return $aParams;
    }

}
?>
