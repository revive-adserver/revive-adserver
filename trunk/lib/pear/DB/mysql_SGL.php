<?php
require_once "DB/mysql.php";

class DB_mysql_SGL extends DB_mysql
{
    
    var $debug = false;
    
    /**
     * Variable for storing the depth of transaction.
     */
    var $transactionDepth = 0;
    
    /**
     * Returns the next free id in a sequence using the standard
     * PEAR::Db / AdoDb method
     *
     * @param string  $seq_name  name of the sequence
     * @param boolean $ondemand  when true, the seqence is automatically
     *                            created if it does not exist
     *
     * @return int  the next id number in the sequence.
     *               A DB_Error object on failure.
     *
     * @see DB_common::nextID(), DB_common::getSequenceName(),
     *      DB_mysql::createSequence(), DB_mysql::dropSequence()
     */
    function nextId_AdoDb($seq_name, $ondemand = true)
    {
        return parent::nextId($seq_name, $ondemand);
    }
    
    function getSequenceName($seq_name)
    {
        return $seq_name;
    }
    
    /**
     * Overwritten method from parent class to allow logging facility
     *
     * @param the SQL query
     *
     * @access public
     *
     * @return mixed returns a valid MySQL result for successful SELECT
     * queries, DB_OK for other successful queries.  A DB error is
     * returned on failure.
     */
    function simpleQuery($query)
    {
        if ($this->debug) {
            
            // to mysql server are sent not only queries passed as a parameters
            // also the simpleQuery function when special condition occurs send
            // some commands by itself, so we have to log it as well - that is
            // why this condition.
            if (!$this->autocommit && DB::isManip($query) && $this->transaction_opcount == 0) {
                echo "SET AUTOCOMMIT=0<br>";
                echo "START TRANSACTION<br>";
            }
            //echo "<pre>$query</pre>";
        }
        
        return parent::simpleQuery($query);
    }
    
    /**
     * Sets the debug mode
     *
     * @param $debug boolean If debug should be on or off
     */
    function setDebug($debug)
    {
        $this->debug = (boolean) $debug;
    }
    
    /**
     * gets the debug value
     *
     * @return boolean if debug is on or off
     */
    function getDebug()
    {
        return $this->debug;
    }
    
    /**
     * Starts a new transaction or a sub-transaction if a transaction has
     * already been started. Optionally, you can specify a transaction name
     * identifier, to allow implementation of rollbacks to savepoints.
     * Transaction isolation level is set to REPETABLE READ which is default
     * for mysql transaction but this default value could be changed during
     * mysql startup.
     *
     * @param  String  $name The name of a sub-transaction
     * @return Integer DB_OK
     * @access public
     */
    function startTransaction($name = null)
    {
        if ($this->transactionDepth < 0) {
            $this->transactionDepth = 0;
        }

        if ($this->transactionDepth > 0 && strlen($name) > 0) {
            $result = $this->simpleQuery('SAVEPOINT ' . $name);
        } else {
            // Need this otherwise simpleQuery() will start a new transaction
            $this->transaction_opcount++;
            $result = $this->simpleQuery('SET AUTOCOMMIT=0');
            $result = $this->simpleQuery('SET TRANSACTION ISOLATION LEVEL REPEATABLE READ');
            
            $this->autoCommit(false);
            // Need this otherwise simpleQuery() will start a new transaction
            $this->transaction_opcount++;
        }

        if(! $result) {
            return $this->mysqlRaiseError();
        }

        $this->transactionDepth++;
        
        return DB_OK;
    }

    /**
     * Commit a transaction or sub-transaction if one exists.
     *
     * @return Integer DB_OK
     * @access public
     */
    function commit()
    {
        // No transaction started! Ignore commit()
        if ($this->transactionDepth < 1) {
            $this->transactionDepth = 0;
            return DB_OK;   
        }
        $this->transactionDepth--;
        
        // We only commit if we are at the top level and there were relevant queries,
        // otherwise ignore...
        if ($this->transactionDepth === 0 && $this->transaction_opcount > 0) {
            
            $this->autocommit = true;
            
            if ($this->_db) {
                if (!@mysql_select_db($this->_db, $this->connection)) {
                    return $this->mysqlRaiseError(DB_ERROR_NODBSELECTED);
                }
            }
            $this->transaction_opcount = 0;
            if (!$this->simpleQuery('COMMIT', $this->connection) || 
                !$this->simpleQuery('SET AUTOCOMMIT=1', $this->connection)) {
                return $this->mysqlRaiseError();
            }
        }
        
        return DB_OK;
    }
    
    
    /**
     * Rollback an existing transaction or sub-transaction.
     *
     * @return Integer DB_OK
     * @access public
     */
    function rollback($name = null)
    {
        // No transaction started! Ignore rollback()
        if ($this->transactionDepth < 1) {
            $this->transactionDepth = 0;
            return DB_OK;
        }
        
        $this->transactionDepth--;

        // Only rollback if there were any relevant transactions.
        if ($this->transaction_opcount > 0) {
            /*
            if ($this->_db) {
                if (!@mysql_select_db($this->_db, $this->connection)) {
                    return $this->mysqlRaiseError(DB_ERROR_NODBSELECTED);
                }
            }
            */
            // If this is a sub-transaction and a rollback to a named transaction was
            // called, rollback to savepoint...
            if ($this->transactionDepth > 0 && strlen($name) > 0) {
                $result = $this->simpleQuery('ROLLBACK TO SAVEPOINT ' . $name, $this->connection);
            } else {
            // ...otherwise rollback the whole transaction
                $result = $this->simpleQuery('ROLLBACK', $this->connection);
                $result = $this->simpleQuery('SET AUTOCOMMIT=1', $this->connection);
                $this->transaction_opcount = 0;
                $this->transactionDepth    = 0;
            }

            if (!$result) {
                return $this->mysqlRaiseError();
            }
        }
        
        return DB_OK;
    }
    
    
   
}

?>
