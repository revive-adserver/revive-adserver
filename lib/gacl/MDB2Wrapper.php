<?php

/**
 * A lightweight wrapper around MDB2 which implements part of ADO DB API.
 * Allows to use MDB2 in phpGacl.
 *
 * It is not a goal of this class to rewrite all ADO methods using MDB2.
 * To keep things simple and lightweight only methods (and parameters)
 * required by phpGACL were implemented.
 *
 * @author Radek Maciaszek <radek.maciaszek@openads.org>
 */
class MDB2Wrapper
{
    /**
     * Reference to MDB2 driver
     *
     * @var MDB2_Driver_Common $db
     */
    var $db;

    /**
     * Rreference to PEAR_Error
     * @var PEAR_Error $error
     */
    var $error = null;

    /**
     * Fetchmode used by phpGACL
     *
     * @var int
     */
    var $fetchMode = MDB2_FETCHMODE_ORDERED;

    /**
     * Constructor
     *
     * @param MDB2_Driver_Common $db  Reference to MDB2 connection
     * @return MDB2Wrapper
     */
    function MDB2Wrapper(&$db)
    {
        $this->setMdb2($db);
    }

    /**
     * Set a reference to MDB2 connection object
     *
     * @param MDB2_Driver_Common $mdb2
     */
    function setMdb2(&$mdb2)
    {
        $this->db = &$mdb2;
    }

    /**
     * Returns last error message
     *
     * @return string
     */
    function ErrorMsg()
    {
        return !empty($this->error) ? $this->error->getMessage() : false;
    }

    /**
     * Returns last error code
     *
     * @return int
     */
    function ErrorNo()
    {
        return !empty($this->error) ? $this->error->getCode() : false;
    }

    /**
     * Escapes string
     *
     * @param string $value
     * @return string
     */
    function quote($value)
    {
        $ret = $this->db->quote($value);
        return $this->_checkErrorReturn($ret, null);
    }

    /**
     * Returns ResultSet with limited number of rows
     *
     * @param string $query
     * @param int $nrows  Number of rows to return
     * @return MDB2ADORecordSetWrapper or false on error
     */
    function &SelectLimit($query,$nrows=-1)
    {
        if($nrows != -1) {
            $ret = $this->db->setLimit($nrows);
            if (PEAR::isError($ret)) {
                $this->error = $ret;
                return false;
            }
        }
        return $this->Execute($query);
    }

    /**
     * Execute SQL
     *
     * @param string $sql
     * @return MDB2ADORecordSetWrapper or false on error
     */
    function &Execute($sql)
    {
        $mdb2ResultSet =& $this->db->query($sql);
        if (PEAR::isError($mdb2ResultSet)) {
            $this->error = &$mdb2ResultSet;
            return false;
        }
        $rs =& new MDB2ADORecordSetWrapper();
        $rs->fetchMode = $this->fetchMode;
        $rs->res = &$mdb2ResultSet;
        $rs->db = &$this;
        $rs->MoveNext(); // preload first record
        return $rs;
    }

    /**
     * Return first element of first row of sql statement. Recordset is disposed
     * for you.
     *
     * @param string $sql
     * @return mixed  Scalar value returned by database or false on error
     */
    function &GetOne($query)
    {
        $ret = $this->db->getOne($query);
        return $this->_checkErrorReturn($ret);
    }

    /**
     * Execute the SQL, fetch value from the first column of
     * every row.
     *
     * @param string $query
     * @return Array of values from first column of all records or false on error
     */
    function &GetCol($query)
    {
        $ret = $this->db->queryCol($query);
        return $this->_checkErrorReturn($ret);
    }

    /**
     * Return one row of sql statement
     *
     * @param string $query
     * @return array  Array of values from first row or false on error
     */
    function &GetRow($query)
    {
        $ret = $this->db->getRow($query, null, array(), null, $this->fetchMode);
        return $this->_checkErrorReturn($ret);
    }

    /**
     * Generates a sequence id and stores it in table
     *
     * @param string $table  Sequence table name
     * @param int $startID  If sequence do not exist starts from this number
     * @return int  Sequence id or 0 on error
     */
    function GenID($table, $startID=1)
    {
        $genId = 0;
        if (substr($table, -4) == '_seq') {
            $table = substr($table, 0, -4);
        }
        while($startID > $genId) {
            $ret = $this->db->nextID($table, true);
            if (PEAR::isError($ret)) {
                $this->error = &$ret;
                return 0;
            }
            $genId = $ret;
        }
        return $genId;
    }

    /**
     * Begin a Transaction
     *
     * @return False on error, otherwise true
     */
    function BeginTrans()
    {
        if (!$this->db->supports('transactions')) {
            return true;
        }
        $res = $this->db->beginTransaction();
        return $this->_checkErrorReturn($res, false, true);
    }

    /**
     * Rollbacks the transaction
     *
     * @return False on error, otherwise true
     */
    function RollBackTrans()
    {
        if (!$this->db->supports('transactions')) {
            return true;
        }
        $res = $this->db->rollback();
        return $this->_checkErrorReturn($res, false, true);
    }

    /**
     * Commit current transaction
     *
     * @return False on error, otherwise true
     */
    function CommitTrans()
    {
        if (!$this->db->supports('transactions')) {
            return true;
        }
        $res = $this->db->commit();
        return $this->_checkErrorReturn($res, false, true);
    }

    /**
     * Returns list of tables
     *
     * @param string $ttype
     * @return array  Array of table names
     */
    function &MetaTables($ttype = 'TABLES')
    {
        $this->db->loadModule('Manager');
        $tables = $this->db->listTables();
        return $this->_checkErrorReturn($tables);
    }
    
    	
	/**
	 * Correctly quotes a string so that all strings are escaped. We prefix and append
	 * to the string single-quotes.
	 * An example is  $db->qstr("Don't bother",magic_quotes_runtime());
	 * 
	 * @param s			the string to quote
	 * @param [magic_quotes]	if $s is GET/POST var, set to get_magic_quotes_gpc().
	 *				This undoes the stupidity of magic quotes for GPC.
	 *
	 * @return  quoted string to be sent back to database
	 */
	function qstr($s,$magic_quotes=false)
	{	
		if (!$magic_quotes) {
		    return $this->quote($s);
		}
		
		// This part of method was copied from ADODBConnection class
		// undo magic quotes for "
		$s = str_replace('\\"','"',$s);
		
		if ($this->replaceQuote == "\\'")  // ' already quoted, no need to change anything
			return "'$s'";
		else {// change \' to '' for sybase/mssql
			$s = str_replace('\\\\','\\',$s);
			return "'".str_replace("\\'",$this->replaceQuote,$s)."'";
		}
	}

    /**
     * Check whether $result is an PEAR error. If $result is a PEAR_Error
     * returns $returnOnError, otherwise $returnOnSuccess (if was set) or $result
     *
     * @param mixed $result  Any PHP data type is valid
     * @param mixed $returnOnError
     * @param mixed $returnOnSuccess
     * @return Either $result, $returnOnError or $returnOnSuccess
     */
    function &_checkErrorReturn(&$result, $returnOnError = false, $returnOnSuccess = -1)
    {
        if (PEAR::isError($result)) {
            $this->error = &$result;
            return $returnOnError;
        }
        if ($returnOnSuccess != -1) {
            return $returnOnSuccess;
        }
        return $result;
    }
    
   /**
    * Will select the supplied $page number from a recordset, given that it is paginated in pages of 
    * $nrows rows per page. It also saves two boolean values saying if the given page is the first 
    * and/or last one of the recordset. Added by Iv�n Oliva to provide recordset pagination.
    *
    * See readme.htm#ex8 for an example of usage.
    *
    * @param sql
    * @param nrows        is the number of rows per page to get
    * @param page        is the page number to get (1-based)
    * @param [inputarr]    array of bind variables
    * @param [secs2cache]        is a private parameter only used by jlim
    * @return        the recordset ($rs->databaseType == 'array')
    *
    */
    function &PageExecute($sql, $nrows, $page, $inputarr=false, $secs2cache=0) 
    {
        if ($nrows <= 0) $nrows = 10;
        if (empty($page) || $page <= 0) $page = 1;
        $offset = ($page-1) * $nrows;
        $this->db->setLimit($nrows, $offset);
        $rs = $this->Execute($sql);
        $rs->AbsolutePage($page);
        return $rs;
    }
    
   /**
    * Get server version info...
    * 
    * @returns An array with 2 elements: $arr['string'] is the description string, 
    *    and $arr[version] is the version (also a string).
    */
    function ServerInfo()
    {
        $arr['description'] = $this->GetOne("select version()");
		$arr['version'] = MDB2Wrapper::_findvers($arr['description']);
		return $arr;
    }
    
    function _findvers($str)
	{
		if (preg_match('/([0-9]+\.([0-9\.])+)/',$str, $arr)) return $arr[1];
		else return '';
	}

}

/**
 * AdoDB recordset MB2 lighweight wrapper
 * (implements only methods required by phpGACL)
 *
 */
class MDB2ADORecordSetWrapper
{
    /**
     * Indicates whether all rows where fetched
     *
     * @var boolean
     */
    var $EOF = false;

    /**
     * Keeps the reference to currently fetched row
     *
     * @var array
     */
    var $fields = false;

    /**
     * Reference to MDB2_Result returned from MDB2
     *
     * @var MDB2_Result_Common $res
     */
    var $res;

    /**
     * Reference to MDB2_Adodb_Wrapper
     * Required to pass errors back
     *
     * @var MDB2_Adodb_Wrapper $db
     */
    var $db;

    /**
     * Fetchmode
     *
     * @var int
     */
    var $fetchMode;
    
    var $_currentPage = -1;

    /**
     * Move to next record in the recordset.
     *
     * @return boolean  True if there is next row, otherwise (on on error) false
     */
    function MoveNext()
    {
        $ret = $this->res->fetchRow($this->fetchMode);
        if (PEAR::isError($ret)) {
            $this->db->error = &$ret;
            $this->EOF = true;
            return false;
        }
        if (is_null($ret) || ($ret === false)) {
            $this->EOF = true;
            $this->fields = null;
            return false;
        }
        $this->fields = $ret;
        return true;
    }

    /**
    * Fetch a row, returning false if no more rows.
    *
    * @return false or array containing the current record
    */
    function FetchRow()
    {
        $ret = $this->fields;
        $this->MoveNext();
        return $ret;
    }
    
    /**
     * Clean up recordset
     *
     * @return true or false
     */
    function Close() 
    {
        return $this->res->free();
    }

    /**
     * Returns recordset as a 2-dimensional array
     *
     * @param int $nRows  Number of rows to return
     * @return array  An array indexed by rows
     */
    function GetRows($nRows = -1)
    {
        if ($nRows == -1) {
            return $this->_getAll();
        }
        $cRows = 0;
        $results = array();
        while ($nRows > $cRows) {
            $cRows++;
            $ret = $this->res->fetchRow($this->fetchMode);
            if (PEAR::isError($ret)) {
                $this->db->error = &$ret;
                return false;
            }
            $results[] = $ret;
        }
        return $results;
    }

    /**
     * Returns number of rows returned from last query
     *
     * @return int
     */
    function RecordCount()
    {
        if ($this->res && !PEAR::isError($this->res)) {
            return $this->res->numRows();
        }
        return -1;
    }

    /**
     * Returns number of rows returned from last query
     *
     * @see RecordCount()
     *
     * @return int
     */
    function RowCount()
    {
        return $this->RecordCount();
    }
    
    /**
     * set/returns the current recordset page when paginating
     */
    function AbsolutePage($page=-1)
    {
        if ($page != -1) $this->_currentPage = $page;
        return $this->_currentPage;
    }

    /**
     * set/returns the status of the atFirstPage flag when paginating
     */
    function AtFirstPage($status=false)
    {
        if ($status != false) $this->_atFirstPage = $status;
        return $this->_atFirstPage;
    }
    
    function LastPageNo($page = false)
    {
        if ($page != false) $this->_lastPageNo = $page;
        return $this->_lastPageNo;
    }
    
    /**
     * set/returns the status of the atLastPage flag when paginating
     */
    function AtLastPage($status=false)
    {
        if ($status != false) $this->_atLastPage = $status;
        return $this->_atLastPage;
    }
    
    /**
     * Fetch all records and check whether the result is and error or not
     *
     * @return MDB2Result or false on error
     */
    function &_getAll()
    {
        $this->res->seek(0);
        $ret = $this->res->fetchAll($this->fetchMode);
        if (PEAR::isError($ret)) {
            $this->db->error = &$ret;
            return false;
        }
        return $ret;
    }
}

?>