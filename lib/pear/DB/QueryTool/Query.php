<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * Contains the DB_QueryTool_Query class
 *
 * PHP versions 4 and 5
 *
 * LICENSE: This source file is subject to version 3.0 of the PHP license
 * that is available through the world-wide-web at the following URI:
 * http://www.php.net/license/3_0.txt.  If you did not receive a copy of
 * the PHP License and are unable to obtain it through the web, please
 * send a note to license@php.net so we can mail you a copy immediately.
 *
 * @category   Database
 * @package    DB_QueryTool
 * @author     Wolfram Kriesing <wk@visionp.de>
 * @author     Paolo Panto <wk@visionp.de>
 * @author     Lorenzo Alberton <l dot alberton at quipo dot it>
 * @copyright  2003-2005 Wolfram Kriesing, Paolo Panto, Lorenzo Alberton
 * @license    http://www.php.net/license/3_0.txt  PHP License 3.0
 * @version    CVS: $Id$
 * @link       http://pear.php.net/package/DB_QueryTool
 */

/**
 * require the PEAR and DB classes
 */
require_once 'PEAR.php';
require_once 'DB.php';

/**
 * DB_QueryTool_Query class
 *
 * This class should be extended
 *
 * @category   Database
 * @package    DB_QueryTool
 * @author     Wolfram Kriesing <wk@visionp.de>
 * @author     Paolo Panto <wk@visionp.de>
 * @author     Lorenzo Alberton <l dot alberton at quipo dot it>
 * @copyright  2003-2005 Wolfram Kriesing, Paolo Panto, Lorenzo Alberton
 * @license    http://www.php.net/license/3_0.txt  PHP License 3.0
 * @link       http://pear.php.net/package/DB_QueryTool
 */
class DB_QueryTool_Query
{
    // {{{ class vars

    /**
     * @var string  the name of the primary column
     */
    var $primaryCol = 'id';

    /**
     * @var string  the current table the class works on
     */
    var $table      = '';

    /**
     * @var string  the name of the sequence for this table
     */
    var $sequenceName = null;

    /**
     * @var object  the db-object, a PEAR::DB instance
     */
    var $db = null;

    /**
     * @var string  the where condition
     * @access private
     */
    var $_where = '';

    /**
     * @var string  the order condition
     * @access private
     */
    var $_order = '';

    /**
     * @var    string  the having definition
     * @access private
     */
    var $_having = '';

    /**
     * @var array   contains the join content
     *              the key is the join type, for now we have 'default' and 'left'
     *              inside each key 'table' contains the table
     *                          key 'where' contains the where clause for the join
     * @access private
     */
    var $_join = array();

    /**
     * @var    string  which column to index the result by
     * @access private
     */
    var $_index = null;

    /**
     * @var    string  the group-by clause
     * @access private
     */
    var $_group = '';

    /**
     * @var    array   the limit
     * @access private
     */
    var $_limit = array();

    /**
     * @var    string  type of result to return
     * @access private
     */
    var $_resultType = 'none';

    /**
     * @var    array   the metadata temporary saved
     * @access private
     */
    var $_metadata = array();

    /**
     * @var    string
     * @access private
     */
    var $_lastQuery = null;

    /**
     * @var    string   the rows that shall be selected
     * @access private
     */
    var $_select = '*';

    /**
     * @var    string   the rows that shall not be selected
     * @access private
     */
    var $_dontSelect = '';

    /**
     * @var array  this array saves different modes in which this class works
     *             i.e. 'raw' means no quoting before saving/updating data
     * @access private
     */
    var $options = array(
        'raw'      =>  false,
        'verbose'  =>  true,    // set this to false in a productive environment
                                // it will produce error-logs if set to true
        'useCache' =>  false,
        'logFile'  =>  false,
    );

    /**
     * this array contains information about the tables
     * those are
     * - 'name' => the real table name
     * - 'shortName' => the short name used, so that when moving the table i.e.
     *                  onto a provider's db and u have to rename the tables to
     *                  longer names this name will be relevant, i.e. when
     *                  autoJoining, i.e. a table name on your local machine is:
     *                  'user' but online it has to be 'applName_user' then the
     *                  shortName will be used to determine if a column refers to
     *                  another table, if the colName is 'user_id', it knows the
     *                  shortName 'user' refers to the table 'applName_user'
     */
    var $tableSpec = array();

    /**
     * this is the regular expression that shall be used to find a table's shortName
     * in a column name, the string found by using this regular expression will be removed
     * from the column name and it will be checked if it is a table name
     * i.e. the default '/_id$/' would find the table name 'user' from the column name 'user_id'
     */
    var $_tableNameToShortNamePreg = '/^.*_/';

    /**
     * @var array this array caches queries that have already been built once
     *            to reduce the execution time
     */
    var $_queryCache = array();

    /**
     * The object that contains the log-instance
     */
    var $_logObject = null;

    /**
     * Some internal data the logging needs
     */
    var $_logData = array();

    // }}}
    // {{{ __construct()

    /**
     * this is the constructor, as it will be implemented in ZE2 (php5)
     *
     * @version    2002/04/02
     * @access     public
     * @author     Wolfram Kriesing <wk@visionp.de>
     * @param      object  db-object
     */
/*
    function __construct($dsn=false, $options=array())
    {
        if (!isset($options['autoConnect'])) {
            $autoConnect = true;
        } else {
            $autoConnect = $options['autoConnect'];
        }
        if (isset($options['errorCallback'])) {
            $this->setErrorCallback($options['errorCallback']);
        }
        if (isset($options['errorSetCallback'])) {
            $this->setErrorSetCallback($options['errorSetCallback']);
        }
        if (isset($options['errorLogCallback'])) {
            $this->setErrorLogCallback($options['errorLogCallback']);
        }

        if ($autoConnect && $dsn) {
            $this->connect($dsn, $options);
        }
        //we would need to parse the dsn first ... i dont feel like now :-)
        // oracle has all column names in upper case
//FIXXXME make the class work only with upper case when we work with oracle
        //if ($this->db->phptype=='oci8' && !$this->primaryCol) {
        //    $this->primaryCol = 'ID';
        //}

        if ($this->sequenceName == null) {
            $this->sequenceName = $this->table;
        }
    }
*/

    // }}}
    // {{{ DB_QueryTool_Query()

    /**
     * @version    2002/04/02
     * @access     public
     * @author     Wolfram Kriesing <wk@visionp.de>
     * @param mixed $dsn DSN string, DSN array or DB object
     * @param array $options
     */
    function DB_QueryTool_Query($dsn=false, $options=array())
    {
        //$this->__construct($dsn, $options);
        if (!isset($options['autoConnect'])) {
            $autoConnect = true;
        } else {
            $autoConnect = $options['autoConnect'];
            unset($options['autoConnect']);
        }
        if (isset($options['errorCallback'])) {
            $this->setErrorCallback($options['errorCallback']);
            unset($options['errorCallback']);
        }
        if (isset($options['errorSetCallback'])) {
            $this->setErrorSetCallback($options['errorSetCallback']);
            unset($options['errorSetCallback']);
        }
        if (isset($options['errorLogCallback'])) {
            $this->setErrorLogCallback($options['errorLogCallback']);
            unset($options['errorLogCallback']);
        }
        if ($autoConnect && $dsn) {
            $this->connect($dsn, $options);
        }
        if (is_null($this->sequenceName)) {
            $this->sequenceName = $this->table;
        }
    }

    // }}}
    // {{{ connect()

    /**
     * use this method if you want to connect manually
     * @param mixed $dsn DSN string, DSN array or MDB object
     * @param array $options
     */
    function connect($dsn, $options=array())
    {
        if (is_object($dsn)) {
            $res = $this->db =& $dsn;
        } else {
            $res = $this->db = DB::connect($dsn, $options);
        }
        if (DB::isError($res)) {
// FIXXME what shall we do here?
            $this->_errorLog($res->getUserInfo());
        } else {
            $this->db->setFetchMode(DB_FETCHMODE_ASSOC);
        }
    }

    // }}}
    // {{{ getDbInstance()

    /**
     * @return reference to current DB instance
     */
    function &getDbInstance()
    {
        return $this->db;
    }

    // }}}
    // {{{ setDbInstance()

    /**
     * Setup using an existing connection.
     * this also sets the DB_FETCHMODE_ASSOC since this class
     * needs this to be set!
     *
     * @param object a reference to an existing DB-object
     * @return void
     */
    function setDbInstance(&$dbh)
    {
        $this->db =& $dbh;
        $this->db->setFetchMode(DB_FETCHMODE_ASSOC);
    }

    // }}}
    // {{{ get()

    /**
     * get the data of a single entry
     * if the second parameter is only one column the result will be returned
     * directly not as an array!
     *
     * @version    2002/03/05
     * @access     public
     * @author     Wolfram Kriesing <wk@visionp.de>
     * @param      integer the id of the element to retrieve
     * @param      string  if this is given only one row shall be returned, directly, not an array
     * @return     mixed   (1) an array of the retrieved data
     *                     (2) if the second parameter is given and its only one column,
     *                         only this column's data will be returned
     *                     (3) false in case of failure
     */
    function get($id, $column='')
    {
        $table = $this->table;
        $getMethod = 'getRow';
        if ($column && !strpos($column, ',')) {   // if only one column shall be selected
            $getMethod = 'getOne';
        }
        // we dont use 'setSelect' here, since this changes the setup of the class, we
        // build the query directly
        // if $column is '' then _buildSelect selects '*' anyway, so that's the same behaviour as before
        $query['select'] = $this->_buildSelect($column);
        $query['where']  = $this->_buildWhere($this->table.'.'.$this->primaryCol.'='.$id);
        $queryString = $this->_buildSelectQuery($query);

        return $this->returnResult($this->execute($queryString,$getMethod));
    }

    // }}}
    // {{{ getMultiple()

    /**
     * gets the data of the given ids
     *
     * @version    2002/04/23
     * @access     public
     * @author     Wolfram Kriesing <wk@visionp.de>
     * @param      array   this is an array of ids to retreive
     * @param      string  the column to search in for
     * @return     mixed   an array of the retreived data, or false in case of failure
     *                       when failing an error is set in $this->_error
     */
    function getMultiple($ids, $column='')
    {
        $col = $this->primaryCol;
        if ($column) {
            $col = $column;
        }
// FIXXME if $ids has no table.col syntax and we are using joins, the table better be put in front!!!
        $ids = $this->_quoteArray($ids);

        $query['where'] = $this->_buildWhere($col.' IN ('.implode(',', $ids).')');
        $queryString = $this->_buildSelectQuery($query);

        return $this->returnResult($this->execute($queryString));
    }

    // }}}
    // {{{ getAll()

    /**
     * get all entries from the DB
     * for sorting use setOrder!!!, the last 2 parameters are deprecated
     *
     * @version    2002/03/05
     * @access     public
     * @author     Wolfram Kriesing <wk@visionp.de>
     * @param      int     to start from
     * @param      int     the number of rows to show
     * @param      string  the DB-method to use, i dont know if we should leave this param here ...
     * @return     mixed   an array of the retreived data, or false in case of failure
     *                       when failing an error is set in $this->_error
     */
    function getAll($from=0,$count=0,$method='getAll')
    {
        $query = array();
        if ($count) {
            $query = array('limit' => array($from, $count));
        }

        // JSS - temp bug fix...  Permanent fix suggested and is being
        // tracked at pear.php.net/bugs Bug #7316
        $res = $this->execute($this->_buildSelectQuery($query), $method);
        return $this->returnResult($res);
    }

    // }}}
    // {{{ getCol()

    /**
     * this method only returns one column, so the result will be a one dimensional array
     * this does also mean that using setSelect() should be set to *one* column, the one you want to
     * have returned a most common use case for this could be:
     *      $table->setSelect('id');
     *      $ids = $table->getCol();
     * OR
     *      $ids = $table->getCol('id');
     * so ids will be an array with all the id's
     *
     * @version    2003/02/25
     * @access     public
     * @author     Wolfram Kriesing <wk@visionp.de>
     * @param      string  the column that shall be retreived
     * @param      int     to start from
     * @param      int     the number of rows to show
     * @return     mixed   an array of the retreived data, or false in case of failure
     *                     when failing an error is set in $this->_error
     */
    function getCol($column=null, $from=0, $count=0)
    {
        $query = array();
        if (!is_null($column)) {
            // by using _buildSelect() i can be sure that the table name will not be ambigious
            // i.e. in a join, where all the joined tables have a col 'id'
            // _buildSelect() will put the proper table name in front in case there is none
            $query['select'] = $this->_buildSelect($column);
        }
        if ($count) {
            $query['limit'] = array($from,$count);
        }
        return $this->returnResult($this->execute($this->_buildSelectQuery($query), 'getCol'));
    }

    // }}}
    // {{{ getCount()

    /**
     * get the number of entries
     *
     * @version    2002/04/02
     * @access     public
     * @author     Wolfram Kriesing <wk@visionp.de>
     * @param
     * @return     mixed   an array of the retreived data, or false in case of failure
     *                       when failing an error is set in $this->_error
     */
    function getCount()
    {
/* the following query works on mysql
SELECT count(DISTINCT image.id) FROM image2tree
RIGHT JOIN image ON image.id = image2tree.image_id
the reason why this is needed - i just wanted to get the number of rows that do exist if the result is grouped by image.id
the following query is what i tried first, but that returns the number of rows that have been grouped together
for each image.id
SELECT count(*) FROM image2tree
RIGHT JOIN image ON image.id = image2tree.image_id GROUP BY image.id

so that's why we do the following, i am not sure if that is standard SQL and absolutley correct!!!
*/

//FIXXME see comment above if this is absolutely correct!!!
        if ($group = $this->_buildGroup()) {
            $query['select'] = 'COUNT(DISTINCT '.$group.')';
            $query['group'] = '';
        } else {
            $query['select'] = 'COUNT(*)';
        }

        $query['order'] = '';   // order is not of importance and might freak up the special group-handling up there, since the order-col is not be known
/*# FIXXME use the following line, but watch out, then it has to be used in every method, or this
# value will be used always, simply try calling getCount and getAll afterwards, getAll will return the count :-)
# if getAll doesn't use setSelect!!!
*/
        //$this->setSelect('count(*)');
        $queryString = $this->_buildSelectQuery($query, true);

        return ($res = $this->execute($queryString, 'getOne')) ? $res : 0;
    }

    // }}}
    // {{{ getDefaultValues()

    /**
     * return an empty element where all the array elements do already exist
     * corresponding to the columns in the DB
     *
     * @version    2002/04/05
     * @access     public
     * @author     Wolfram Kriesing <wk@visionp.de>
     * @return     array   an empty, or pre-initialized element
     */
    function getDefaultValues()
    {
        $ret = array();
        // here we read all the columns from the DB and initialize them
        // with '' to prevent PHP-warnings in case we use error_reporting=E_ALL
        foreach ($this->metadata() as $aCol=>$x) {
            $ret[$aCol] = '';
        }
        return $ret;
    }

    // }}}
    // {{{ getEmptyElement()

    /**
     * this is just for BC
     * @deprecated
     */
    function getEmptyElement()
    {
        $this->getDefaultValues();
    }

    // }}}
    // {{{ getQueryString()

    /**
     * Render the current query and return it as a string.
     *
     * @return string the current query
     */
    function getQueryString()
    {
        $ret = $this->_buildSelectQuery();
        if (is_string($ret)) {
            $ret = trim($ret);
        }
        return $ret;
    }

    // }}}
    // {{{ save()

    /**
     * save data, calls either update or add
     * if the primaryCol is given in the data this method knows that the
     * data passed to it are meant to be updated (call 'update'), otherwise it will
     * call the method 'add'.
     * If you dont like this behaviour simply stick with the methods 'add'
     * and 'update' and ignore this one here.
     * This method is very useful when you have validation checks that have to
     * be done for both adding and updating, then you can simply overwrite this
     * method and do the checks in here, and both cases will be validated first.
     *
     * @version    2002/03/11
     * @access     public
     * @author     Wolfram Kriesing <wk@visionp.de>
     * @param      array   contains the new data that shall be saved in the DB
     * @return     mixed   the data returned by either add or update-method
     */
    function save($data)
    {
        if (!empty($data[$this->primaryCol])) {
            return $this->update($data);
        }
        return $this->add($data);
    }

    // }}}
    // {{{ update()

    /**
     * update the member data of a data set
     *
     * @version    2002/03/06
     * @access     public
     * @author     Wolfram Kriesing <wk@visionp.de>
     * @param      array   contains the new data that shall be saved in the DB
     *                     the id has to be given in the field with the key 'ID'
     * @return     mixed   true on success, or false otherwise
     */
    function update($newData)
    {
        $query = array();
        // do only set the 'where' part in $query, if a primary column is given
        // if not the default 'where' clause is used
        if (isset($newData[$this->primaryCol])) {
            $query['where'] = $this->primaryCol.'='.$newData[$this->primaryCol];
        }
        $newData = $this->_checkColumns($newData, 'update');
        $values = array();
        $raw = $this->getOption('raw');
        foreach ($newData as $key => $aData) {         // quote the data
            //$values[] = "{$this->table}.$key=". ($raw ? $aData : $this->db->quote($aData));
            $values[] = "$key=". ($raw ? $aData : $this->db->quote($aData));
        }

        $query['set'] = implode(',', $values);
//FIXXXME _buildUpdateQuery() seems to take joins into account, whcih is bullshit here
        $updateString = $this->_buildUpdateQuery($query);
#print '$updateString = '.$updateString;
        return $this->execute($updateString, 'query') ? true : false;
    }

    // }}}
    // {{{ add()

    /**
     * add a new member in the DB
     *
     * @version    2002/04/02
     * @access     public
     * @author     Wolfram Kriesing <wk@visionp.de>
     * @param      array   contains the new data that shall be saved in the DB
     * @return     mixed   the inserted id on success, or false otherwise
     */
    function add($newData)
    {
        // if no primary col is given, get next sequence value
        if (empty($newData[$this->primaryCol])) {
            if ($this->primaryCol) {    // do only use the sequence if a primary column is given
                                        // otherwise the data are written as given
                $id = $this->db->nextId($this->sequenceName);
                $newData[$this->primaryCol] = (int)$id;
            } else {
                // if no primary col is given return true on success
                $id = true;
            }
        } else {
            $id = $newData[$this->primaryCol];
        }

        //unset($newData[$this->primaryCol]);

        $newData = $this->_checkColumns($newData, 'add');
        $newData = $this->_quoteArray($newData);

        $query = sprintf(   'INSERT INTO %s (%s) VALUES (%s)',
                            $this->table,
                            implode(', ', array_keys($newData)),
                            implode(', ', $newData)
                       );
        return $this->execute($query, 'query') ? $id : false;
    }

    // }}}
    // {{{ addMultiple()

    /**
     * adds multiple new members in the DB
     *
     * @version    2002/07/17
     * @access     public
     * @author     Wolfram Kriesing <wk@visionp.de>
     * @param      array   contains an array of new data that shall be saved in the DB
     *                     the key-value pairs have to be the same for all the data!!!
     * @return     mixed   the inserted ids on success, or false otherwise
     */
    function addMultiple($data)
    {
        if (!sizeof($data)) {
            return false;
        }
        // the inserted ids which will be returned or if no primaryCol is given
        // we return true by default
        $retIds = $this->primaryCol ? array() : true;
        $allData = array();     // each row that will be inserted
        foreach ($data as $key => $aData) {
            $aData = $this->_checkColumns($aData, 'add');
            $aData = $this->_quoteArray($aData);

            if (empty($aData[$this->primaryCol])) {
                if ($this->primaryCol) {    // do only use the sequence if a primary column is given
                                            // otherwise the data are written as given
                    $retIds[] = $id = (int)$this->db->nextId($this->sequenceName);
                    $aData[$this->primaryCol] = $id;
                }
            } else {
                $retIds[] = $aData[$this->primaryCol];
            }
            $allData[] = '('.implode(', ', $aData).')';
        }

        $query = sprintf(   'INSERT INTO %s (%s) VALUES %s',
                            $this->table,
                            implode(', ', array_keys($aData)), // use the keys of the last element built
                            implode(', ', $allData)
                        );
        return $this->execute($query, 'query') ? $retIds : false;
    }

    // }}}
    // {{{ remove()

   /**
     * removes a member from the DB
     *
     * @version    2002/04/08
     * @access     public
     * @author     Wolfram Kriesing <wk@visionp.de>
     * @param      mixed   integer/string - the value of the column that shall be removed
     *                       array   - multiple columns that shall be matched, the second parameter will be ignored
     * @param      string  the column to match the data against, only if $data is not an array
     * @return     boolean
     */
    function remove($data, $whereCol='')
    {
        $raw = $this->getOption('raw');

        if (is_array($data)) {
//FIXXME check $data if it only contains columns that really exist in the table
            $wheres = array();
            foreach ($data as $key => $val) {
                $wheres[] = $key.'='. ($raw ? $val : $this->db->quote($val));
            }
            $whereClause = implode(' AND ',$wheres);
        } else {
            if (empty($whereCol)) {
                $whereCol = $this->primaryCol;
            }
            $whereClause = $whereCol.'='. ($raw ? $data : $this->db->quote($data));
        }

        $query = sprintf(   'DELETE FROM %s WHERE %s',
                            $this->table,
                            $whereClause
                            );
        return $this->execute($query, 'query') ? true : false;
// i think this method should return the ID's that it removed, this way we could simply use the result
// for further actions that depend on those id ... or? make stuff easier, see ignaz::imail::remove
    }

    // }}}
    // {{{ removeAll()

    /**
     * empty a table
     *
     * @version    2002/06/17
     * @access     public
     * @author     Wolfram Kriesing <wk@visionp.de>
     * @return
     */
    function removeAll()
    {
        $query = 'DELETE FROM '.$this->table;
        return $this->execute($query, 'query') ? true : false;
    }

    // }}}
    // {{{ removeMultiple()

    /**
     * remove the datasets with the given ids
     *
     * @version    2002/04/24
     * @access     public
     * @author     Wolfram Kriesing <wk@visionp.de>
     * @param      array   the ids to remove
     * @return
     */
    function removeMultiple($ids, $colName='')
    {
        if (empty($colName)) {
            $colName = $this->primaryCol;
        }
        $ids = $this->_quoteArray($ids);

        $query = sprintf(   'DELETE FROM %s WHERE %s IN (%s)',
                            $this->table,
                            $colName,
                            implode(',', $ids)
                        );
        return $this->execute($query, 'query') ? true : false;
    }

    // }}}
    // {{{ removePrimary()

    /**
     * removes a member from the DB and calls the remove methods of the given objects
     * so all rows in another table that refer to this table are erased too
     *
     * @version    2002/04/08
     * @access     public
     * @author     Wolfram Kriesing <wk@visionp.de>
     * @param      integer the value of the primary key
     * @param      string  the column name of the tables with the foreign keys
     * @param      object  just for convinience, so nobody forgets to call this method
     *                       with at least one object as a parameter
     * @return     boolean
     */
    function removePrimary($id, $colName, $atLeastOneObject)
    {
        $argCounter = 2;    // we have 2 parameters that need to be given at least
        // func_get_arg returns false and a warning if there are no more parameters, so
        // we suppress the warning and check for false
        while ($object = @func_get_arg($argCounter++)) {
//FIXXXME let $object also simply be a table name
            if (!$object->remove($id, $colName)) {
//FIXXXME do this better
                $this->_errorSet("Error removing '$colName=$id' from table {$object->table}.");
               return false;
            }
        }

        return ($this->remove($id) ? true : false);
    }

    // }}}
    // {{{ setLimit()

    /**
     * @param integer $from
     * @param integer $count
     */
    function setLimit($from=0, $count=0)
    {
        if ($from==0 && $count==0) {
            $this->_limit = array();
        } else {
            $this->_limit = array($from, $count);
        }
    }

    // }}}
    // {{{ getLimit()

    /**
     * @return array
     */
    function getLimit()
    {
        return $this->_limit;
    }

    // }}}
    // {{{ setWhere()

    /**
     * sets the where condition which is used for the current instance
     *
     * @version    2002/04/16
     * @access     public
     * @author     Wolfram Kriesing <wk@visionp.de>
     * @param      string  the where condition, this can be complete like 'X=7 AND Y=8'
     */
    function setWhere($whereCondition='')
    {
        $this->_where = $whereCondition;
//FIXXME parse the where condition and replace ambigious column names, such as "name='Deutschland'" with "country.name='Deutschland'"
// then the users dont have to write that explicitly and can use the same name as in the setOrder i.e. setOrder('name,_net_name,_netPrefix_prefix');
    }

    // }}}
    // {{{ getWhere()

    /**
     * gets the where condition which is used for the current instance
     *
     * @version    2002/04/22
     * @access     public
     * @author     Wolfram Kriesing <wk@visionp.de>
     * @return     string  the where condition, this can be complete like 'X=7 AND Y=8'
     */
    function getWhere()
    {
        return $this->_where;
    }

    // }}}
    // {{{ addWhere()

    /**
     * only adds a string to the where clause
     *
     * @version    2002/07/22
     * @access     public
     * @author     Wolfram Kriesing <wk@visionp.de>
     * @param      string  the where clause to add to the existing one
     * @param      string  the condition for how to concatenate the new where clause
     *                       to the existing one
     */
    function addWhere($where, $condition='AND')
    {
        if ($this->getWhere()) {
            $where = $this->getWhere().' '.$condition.' '.$where;
        }
        $this->setWhere($where);
    }

    // }}}
    // {{{ addWhereSearch()

    /**
     * add a where-like clause which works like a search for the given string
     * i.e. calling it like this:
     *     $this->addWhereSearch('name', 'otto hans')
     * produces a where clause like this one
     *     LOWER(name) LIKE "%otto%hans%"
     * so the search finds the given string
     *
     * @version    2002/08/14
     * @access     public
     * @author     Wolfram Kriesing <wk@visionp.de>
     * @param      string  the column to search in for
     * @param      string  the string to search for
     */
    function addWhereSearch($column, $string, $condition='AND')
    {
        // if the column doesn't contain a tablename use the current table name
        // in case it is a defined column to prevent ambiguous rows
        if (strpos($column, '.') === false) {
            $meta = $this->metadata();
            if (isset($meta[$column])) {
                $column = $this->table.".$column";
            }
        }

        $string = $this->db->quote('%'.str_replace(' ', '%', strtolower($string)).'%');
        $this->addWhere("LOWER($column) LIKE $string", $condition);
    }

    // }}}
    // {{{ setOrder()

    /**
     * sets the order condition which is used for the current instance
     *
     * @version    2002/05/16
     * @access     public
     * @author     Wolfram Kriesing <wk@visionp.de>
     * @param      string  the where condition, this can be complete like 'X=7 AND Y=8'
     * @param      boolean sorting order (TRUE => ASC, FALSE => DESC)
     */
    function setOrder($orderCondition='', $desc=false)
    {
        $this->_order = $orderCondition .($desc ? ' DESC' : '');
    }

    // }}}
    // {{{ addOrder()

    /**
     * Add a order parameter to the query.
     *
     * @version    2003/05/28
     * @access     public
     * @author     Wolfram Kriesing <wk@visionp.de>
     * @param      string  the where condition, this can be complete like 'X=7 AND Y=8'
     * @param      boolean sorting order (TRUE => ASC, FALSE => DESC)
     */
    function addOrder($orderCondition='', $desc=false)
    {
        $order = $orderCondition .($desc ? ' DESC' : '');
        if ($this->_order) {
            $this->_order = $this->_order.','.$order;
        } else {
            $this->_order = $order;
        }
    }

    // }}}
    // {{{ getOrder()

    /**
     * gets the order condition which is used for the current instance
     *
     * @version    2002/05/16
     * @access     public
     * @author     Wolfram Kriesing <wk@visionp.de>
     * @return     string  the order condition, this can be complete like 'ID,TIMESTAMP DESC'
     */
    function getOrder()
    {
        return $this->_order;
    }

    // }}}
    // {{{ setHaving()

    /**
     * sets the having definition
     *
     * @version    2003/06/05
     * @access     public
     * @author     Johannes Schaefer <johnschaefer@gmx.de>
     * @param      string  the having definition
     */
    function setHaving($having='')
    {
        $this->_having = $having;
    }

    // }}}
    // {{{ getHaving()

    /**
     * gets the having definition which is used for the current instance
     *
     * @version    2003/06/05
     * @access     public
     * @author     Johannes Schaefer <johnschaefer@gmx.de>
     * @return     string  the having definition
     */
    function getHaving()
    {
        return $this->_having;
    }

    // }}}
    // {{{ addHaving()

    /**
     * Extend the current having clause. This is very useful, when you are building
     * this clause from different places and don't want to overwrite the currently
     * set having clause, but extend it.
     *
     * @param string this is a having clause, i.e. 'column' or 'table.column' or 'MAX(column)'
     * @param string the connection string, which usually stays the default, which is ',' (a comma)
     */
    function addHaving($what='*', $connectString=' AND ')
    {
        if ($this->_having) {
            $this->_having = $this->_having.$connectString.$what;
        } else {
            $this->_having = $what;
        }
    }

    // }}}
    // {{{ setJoin()

    /**
     * sets a join-condition
     *
     * @version    2002/06/10
     * @access     public
     * @author     Wolfram Kriesing <wk@visionp.de>
     * @param      mixed   either a string or an array that contains
     *                       the table(s) to join on the current table
     * @param      string  the where clause for the join
     */
    function setJoin($table=null, $where=null, $joinType='default')
    {
//FIXXME make it possible to pass a table name as a string like this too 'user u'
// where u is the string that can be used to refer to this table in a where/order
// or whatever condition
// this way it will be possible to join tables with itself, like setJoin(array('user u','user u1'))
// this wouldnt work yet, but for doing so we would need to change the _build methods too!!!
// because they use getJoin('tables') and this simply returns all the tables in use
// but don't take care of the mentioned syntax

        if (is_null($table) || is_null($where)) {   // remove the join if not sufficient parameters are given
            $this->_join[$joinType] = array();
            return;
        }
/* this causes problems if we use the order-by, since it doenst know the name to order it by ... :-)
        // replace the table names with the internal name used for the join
        // this way we can also join one table multiple times if it will be implemented one day
        $this->_join[$table] = preg_replace('/'.$table.'/','j1',$where);
*/
        $this->_join[$joinType][$table] = $where;
    }

    // }}}
    // {{{ setJoin()

    /**
     * if you do a left join on $this->table you will get all entries
     * from $this->table, also if there are no entries for them in the joined table
     * if both parameters are not given the left-join will be removed
     * NOTE: be sure to only use either a right or a left join
     *
     * @version    2002/07/22
     * @access     public
     * @author     Wolfram Kriesing <wk@visionp.de>
     * @param      string  the table(s) to be left-joined
     * @param      string  the where clause for the join
     */
    function setLeftJoin($table=null, $where=null)
    {
        $this->setJoin($table, $where, 'left');
    }

    // }}}
    // {{{ addLeftJoin()

    /**
     * @param string the table to be left-joined
     * @param string the where clause for the join
     * @param string the join type
     */
    function addLeftJoin($table, $where, $type='left')
    {
        // init value, to prevent E_ALL-warning
        if (!isset($this->_join[$type]) || !$this->_join[$type]) {
            $this->_join[$type] = array();
        }
        $this->_join[$type][$table] = $where;
    }

    // }}}
    // {{{ setRightJoin()

    /**
     * see setLeftJoin for further explaination on what a left/right join is
     * NOTE: be sure to only use either a right or a left join
//FIXXME check if the above sentence is necessary and if sql doesnt allow the use of both
     *
     * @see        setLeftJoin()
     * @version    2002/09/04
     * @access     public
     * @author     Wolfram Kriesing <wk@visionp.de>
     * @param      string  the table(s) to be right-joined
     * @param      string  the where clause for the join
     */
    function setRightJoin($table=null, $where=null)
    {
        $this->setJoin($table, $where, 'right');
    }

    // }}}
    // {{{ getJoin()

    /**
     * gets the join-condition
     *
     * @access public
     * @param  string  [null|''|'table'|'tables'|'right'|'left']
     * @return array   gets the join parameters
     */
    function getJoin($what=null)
    {
        // if the user requests all the join data or if the join is empty, return it
        if (is_null($what) || empty($this->_join)) {
            return $this->_join;
        }

        $ret = array();
        switch (strtolower($what)) {
            case 'table':
            case 'tables':
                foreach ($this->_join as $aJoin) {
                    if (count($aJoin)) {
                        $ret = array_merge($ret, array_keys($aJoin));
                    }
                }
                break;
            case 'right':   // return right-join data only
            case 'left':    // return left join data only
                if (count($this->_join[$what])) {
                    $ret = array_merge($ret, $this->_join[$what]);
                }
                break;
        }
        return $ret;
    }

    // }}}
    // {{{ addJoin()

    /**
     *   adds a table and a where clause that shall be used for the join
     *   instead of calling
     *       setJoin(array(table1,table2),'<where clause1> AND <where clause2>')
     *   you can also call
     *       setJoin(table1,'<where clause1>')
     *       addJoin(table2,'<where clause2>')
     *   or where it makes more sense is to build a query which is made out of a
     *   left join and a standard join
     *       setLeftJoin(table1,'<where clause1>')
     *       // results in ... FROM $this->table LEFT JOIN table ON <where clause1>
     *       addJoin(table2,'<where clause2>')
     *       // results in ...  FROM $this->table,table2 LEFT JOIN table ON <where clause1> WHERE <where clause2>
     *
     * @access     public
     * @param      string the table to be joined
     * @param      string the where clause for the join
     * @param      string the join type
     */
    function addJoin($table, $where, $type='default')
    {
        if ($table == $this->table) {
            return;  //skip. Self joins are not supported.
        }
        // init value, to prevent E_ALL-warning
        if (!isset($this->_join[$type]) || !$this->_join[$type]) {
            $this->_join[$type] = array();
        }
        $this->_join[$type][$table] = $where;
    }

    // }}}
    // {{{ setTable()

    /**
     * sets the table this class is currently working on
     *
     * @version    2002/07/11
     * @access     public
     * @author     Wolfram Kriesing <wk@visionp.de>
     * @param      string  the table name
     */
    function setTable($table)
    {
        $this->table = $table;
    }

    // }}}
    // {{{ getTable()

    /**
     * gets the table this class is currently working on
     *
     * @version    2002/07/11
     * @access     public
     * @author     Wolfram Kriesing <wk@visionp.de>
     * @return     string  the table name
     */
    function getTable()
    {
        return $this->table;
    }

    // }}}
    // {{{ setGroup()

    /**
     * sets the group-by condition
     *
     * @version    2002/07/22
     * @access     public
     * @author     Wolfram Kriesing <wk@visionp.de>
     * @param      string  the group condition
     */
    function setGroup($group='')
    {
        $this->_group = $group;
//FIXXME parse the condition and replace ambigious column names, such as "name='Deutschland'" with "country.name='Deutschland'"
// then the users dont have to write that explicitly and can use the same name as in the setOrder i.e. setOrder('name,_net_name,_netPrefix_prefix');
    }

    // }}}
    // {{{ getGroup()

    /**
     *   gets the group condition which is used for the current instance
     *
     * @version    2002/07/22
     * @access     public
     * @author     Wolfram Kriesing <wk@visionp.de>
     * @return     string  the group condition
     */
    function getGroup()
    {
        return $this->_group;
    }

    // }}}
    // {{{ setSelect()

    /**
     * limit the result to return only the columns given in $what
     * @param string fields that shall be selected
     */
    function setSelect($what='*')
    {
        $this->_select = $what;
    }

    // }}}
    // {{{ addSelect()

    /**
     * add a string to the select part of the query
     *
     * add a string to the select-part of the query and connects it to an existing
     * string using the $connectString, which by default is a comma.
     * (SELECT xxx FROM - xxx is the select-part of a query)
     *
     * @version    2003/01/08
     * @access     public
     * @author     Wolfram Kriesing <wk@visionp.de>
     * @param      string  the string that shall be added to the select-part
     * @param      string  the string to connect the new string with the existing one
     * @return     void
     */
    function addSelect($what='*', $connectString=',')
    {
        // if the select string is not empty add the string, otherwise simply set it
        if ($this->_select) {
            $this->_select = $this->_select.$connectString.$what;
        } else {
            $this->_select = $what;
        }
    }

    // }}}
    // {{{ getSelect()

    /**
     * @return     string
     */
    function getSelect()
    {
        return $this->_select;
    }

    // }}}
    // {{{ setDontSelect()

    /**
     * @param     string
     */
    function setDontSelect($what='')
    {
        $this->_dontSelect = $what;
    }

    // }}}
    // {{{ getDontSelect()

    /**
     * @return     string
     */
    function getDontSelect()
    {
        return $this->_dontSelect;
    }

    // }}}
    // {{{ reset()

    /**
     * reset all the set* settings; with no parameter given, it resets them all
     *
     * @version    2002/09/16
     * @access     public
     * @author     Wolfram Kriesing <wk@visionp.de>
     * @return     void
     */
    function reset($what=array())
    {
        if (!sizeof($what)) {
            $what = array(
                'select',
                'dontSelect',
                'group',
                'having',
                'limit',
                'where',
                'index',
                'order',
                'join',
                'leftJoin',
                'rightJoin'
            );
        }

        foreach ($what as $aReset) {
            $this->{'set'.ucfirst($aReset)}();
        }
    }

    // }}}
    // {{{ setOption()

    /**
     * set mode the class shall work in
     * currently we have the modes:
     * 'raw'   does not quote the data before building the query
     *
     * @version    2002/09/17
     * @access     public
     * @author     Wolfram Kriesing <wk@visionp.de>
     * @param      string      the mode to be set
     * @param      mixed       the value of the mode
     * @return     void
     */
    function setOption($option, $value)
    {
        $this->options[strtolower($option)] = $value;
    }

    // }}}
    // {{{ getOption()

    /**
     * @return     string
     */
    function getOption($option)
    {
        return $this->options[strtolower($option)];
    }

    // }}}
    // {{{ _quoteArray()

    /**
     * quotes all the data in this array if we are not in raw mode!
     * @param array
     */
    function _quoteArray($data)
    {
        if (!$this->getOption('raw')) {
            foreach ($data as $key => $val) {
                $data[$key] = $this->db->quote($val);
            }
        }
        return $data;
    }

    // }}}
    // {{{ _checkColumns()

    /**
     * checks if the columns which are given as the array's indexes really exist
     * if not it will be unset anyway
     *
     * @version    2002/04/16
     * @access     public
     * @author     Wolfram Kriesing <wk@visionp.de>
     * @param      string  the actual message, first word should always be the method name,
     *                       to build the message like this: className::methodname
     * @param      integer the line number
     */
    function _checkColumns($newData, $method='unknown')
    {
        if (!$meta = $this->metadata()) {   // if no metadata available, return data as given
            return $newData;
        }

        foreach ($newData as $colName => $x) {
            if (!isset($meta[$colName])) {
                $this->_errorLog("$method, column {$this->table}.$colName doesnt exist, value was removed before '$method'",__LINE__);
                unset($newData[$colName]);
            } else {
                // if the current column exists, check the length too, not to write content that is too long
                // prevent DB-errors here
                // do only check the data length if this field is given
                if (isset($meta[$colName]['len']) && ($meta[$colName]['len'] != -1) &&
                    ($oldLength=strlen($newData[$colName])) > $meta[$colName]['len']
                ) {
                    $this->_errorLog("_checkColumns, had to trim column '$colName' from $oldLength to ".
                                        $meta[$colName]['DATA_LENGTH'].' characters.', __LINE__);
                    $newData[$colName] = substr($newData[$colName], 0, $meta[$colName]['len']);
                }
            }
        }
        return $newData;
    }

    // }}}
    // {{{ debug()

    /**
     * overwrite this method and i.e. print the query $string
     * to see the final query
     *
     * @param      string  the query mostly
     */
    function debug($string){}

    //
    //
    //  ONLY ORACLE SPECIFIC, not very nice since it is DB dependent, but we need it!!!
    //
    //

    // }}}
    // {{{ metadata()

    /**
     * !!!! query COPIED FROM db_oci8.inc - from PHPLIB !!!!
     *
     * @access   public
     * @see
     * @version  2001/09
     * @author   PHPLIB
     * @param
     * @return
     */
    function metadata($table='')
    {
        // is there an alias in the table name, then we have something like this: 'user ua'
        // cut of the alias and return the table name
        if (strpos($table, ' ') !== false) {
            $split = explode(' ', trim($table));
            $table = $split[0];
        }

        $full = false;
        if (empty($table)) {
            $table = $this->table;
        }
        // to prevent multiple selects for the same metadata
        if (isset($this->_metadata[$table])) {
            return $this->_metadata[$table];
        }

// FIXXXME use oci8 implementation of newer PEAR::DB-version
        if ($this->db->phptype == 'oci8') {
            $count = 0;
            $id    = 0;
            $res   = array();

            //# This is a RIGHT OUTER JOIN: "(+)", if you want to see, what
            //# this query results try the following:
            //// $table = new Table; $this->db = new my_DB_Sql; // you have to make
            ////                                          // your own class
            //// $table->show_results($this->db->query(see query vvvvvv))
            ////
            $res = $this->db->getAll("SELECT T.column_name,T.table_name,T.data_type,".
                "T.data_length,T.data_precision,T.data_scale,T.nullable,".
                "T.char_col_decl_length,I.index_name".
                " FROM ALL_TAB_COLUMNS T,ALL_IND_COLUMNS I".
                " WHERE T.column_name=I.column_name (+)".
                " AND T.table_name=I.table_name (+)".
                " AND T.table_name=UPPER('$table') ORDER BY T.column_id");

            if (DB::isError($res)) {
                //$this->_errorSet($res->getMessage());
                // i think we only need to log here, since this method is never used
                // directly for the user's functionality, which means if it fails it
                // is most probably an appl error
                $this->_errorLog($res->getUserInfo());
                return false;
            }
            foreach ($res as $key=>$val) {
                $res[$key]['name'] = $val['COLUMN_NAME'];
            }
        } else {
            if (!is_object($this->db)) {
                return false;
            }
            $res = $this->db->tableinfo($table);
            if (DB::isError($res)) {
                $this->_errorSet($res->getUserInfo());
                return false;
            }
        }

        $ret = array();
        foreach ($res as $key => $val) {
            $ret[$val['name']] = $val;
        }
        $this->_metadata[$table] = $ret;
        return $ret;
    }



    //
    //  methods for building the query
    //

    // }}}
    // {{{ _buildFrom()

    /**
     * build the from string
     *
     * @access     private
     * @return     string  the string added after FROM
     */
    function _buildFrom()
    {
        $from = $this->table;
        $join = $this->getJoin();

        if (!$join) {  // no join set
            return $from;
        }
        // handle the standard join thingy
        if (isset($join['default']) && count($join['default'])) {
            $from .= ','.implode(',',array_keys($join['default']));
        }

        //$from = '('.$from.')'; // mysql 5 workaround

        // handle left/right joins
        foreach (array('left', 'right') as $joinType) {
            if (isset($join[$joinType]) && count($join[$joinType])) {
                foreach($join[$joinType] as $table => $condition) {
                    // replace the _TABLENAME_COLUMNNAME by TABLENAME.COLUMNNAME
                    // since oracle doesnt work with the _TABLENAME_COLUMNNAME which i think is strange
// FIXXME i think this should become deprecated since the setWhere should not be used like this: '_table_column' but 'table.column'
                    $regExp = '/_('.$table.')_([^\s]+)/';
                    $where = preg_replace($regExp, '$1.$2', $condition);

                    // add the table name before any column that has no table prefix
                    // since this might cause "unambiguous column" errors
                    if ($meta = $this->metadata()) {
                        foreach ($meta as $aCol=>$x) {
                            // this covers the LIKE,IN stuff: 'name LIKE "%you%"'  'id IN (2,3,4,5)'
                            $condition = preg_replace('/\s'.$aCol.'\s/', " {$this->table}.$aCol ", $condition);
                            // replace also the column names which are behind a '='
                            // and do this also if the aCol is at the end of the where clause
                            // that's what the $ is for
                            $condition = preg_replace('/=\s*'.$aCol.'(\s|$)/', "={$this->table}.$aCol ", $condition);
                            // replace if colName is first and possibly also if at the beginning of the where-string
                            $condition = preg_replace('/(^\s*|\s+)'.$aCol.'\s*=/', "$1{$this->table}.$aCol=", $condition);
                        }
                    }
                    $from .= ' '.strtoupper($joinType).' JOIN '.$table.' ON '.$condition;
                }
            }
        }
        return $from;
    }

    // }}}
    // {{{ getTableShortName()

    /**
     *   this method gets the short name for a table
     *
     *   get the short name for a table, this is needed to properly build the
     *   'AS' parts in the select query
     * @param  string  the real table name
     * @return string  the table's short name
     */
    function getTableShortName($table)
    {
        $tableSpec = $this->getTableSpec(false);
        if (isset($tableSpec[$table]['shortName']) && $tableSpec[$table]['shortName']) {
//print "$table ... ".$tableSpec[$table]['shortName'].'<br>';
            return $tableSpec[$table]['shortName'];
        }

        $possibleTableShortName = preg_replace($this->_tableNameToShortNamePreg, '', $table);
//print "$table ... $possibleTableShortName<br>";
        return $possibleTableShortName;
    }

    // }}}
    // {{{ getTableSpec()

    /**
     * gets the tableSpec either indexed by the short name or the name
     * returns the array for the tables given as parameter or if no
     * parameter given for all tables that exist in the tableSpec
     *
     * @param      array   table names (not the short names!)
     * @param      boolean if true the table is returned indexed by the shortName
     *                       otherwise indexed by the name
     * @return     array   the tableSpec indexed
     */
    function getTableSpec($shortNameIndexed=true, $tables=array())
    {
        $newSpec = array();
        foreach ($this->tableSpec as $aSpec) {
            if (sizeof($tables)==0 || in_array($aSpec['name'],$tables)) {
                if ($shortNameIndexed) {
                    $newSpec[$aSpec['shortName']] = $aSpec;
                } else {
                    $newSpec[$aSpec['name']] = $aSpec;
                }
            }
        }
        return $newSpec;
    }

    // }}}
    // {{{ _buildSelect()

    /**
     *   build the 'SELECT <what> FROM ... 'for a select
     *
     * @version    2002/07/11
     * @access     public
     * @author     Wolfram Kriesing <wk@visionp.de>
     * @param      string      if given use this string
     * @return     string      the what-clause
     */
    function _buildSelect($what=null)
    {
        // what has preference, that means if what is set it is used
        // this is only because the methods like 'get' pass an individually built value, which
        // is supposed to be used, but usually it's generically build using the 'getSelect' values
        if (empty($what) && $this->getSelect()) {
            $what = $this->getSelect();
        }

        //
        // replace all the '*' by the real column names, and take care of the dontSelect-columns!
        //
        $dontSelect = $this->getDontSelect();
        $dontSelect = $dontSelect ? explode(',', $dontSelect) : array(); // make sure dontSelect is an array

        // here we will replace all the '*' and 'table.*' by all the columns that this table
        // contains. we do this so we can easily apply the 'dontSelect' values.
        // and so we can also handle queries like: 'SELECT *,count() FROM ' and 'SELECT table.*,x FROM ' too
        if (strpos($what, '*') !== false) {
            // subpattern 1 get all the table names, that are written like this: 'table.*' including '*'
            // for '*' the tablename will be ''
            preg_match_all('/([^,]*)(\.)?\*\s*(,|$)/U', $what, $res);
//print "$what ... ";print_r($res);print "<br>";
            $selectAllFromTables = array_unique($res[1]); // make the table names unique, so we do it all just once for each table
            $tables = array();
            if (in_array('', $selectAllFromTables)) { // was there a '*' ?
                // get all the tables that we need to process, depending on if joined or not
                $tables = $this->getJoin() ?
                                array_merge($this->getJoin('tables'), array($this->table)) : // get the joined tables and this->table
                                array($this->table);        // create an array with only this->table
            } else {
                $tables = $selectAllFromTables;
            }

            $cols = array();
            foreach ($tables as $aTable) {      // go thru all the tables and get all columns for each, and handle 'dontSelect'
                if ($meta = $this->metadata($aTable)) {
                    foreach ($meta as $colName => $x) {
                        // handle the dontSelect's
                        if (in_array($colName, $dontSelect) || in_array("$aTable.$colName", $dontSelect)) {
                            continue;
                        }

                        // build the AS clauses
                        // put " around them to enable use of reserved words, i.e. SELECT table.option as option FROM...
                        // and 'option' actually is a reserved word, at least in mysql
                        // put double quotes around them, since pgsql doesnt work with single quotes
                        // but don't do this for ibase because it doesn't work!
                        if ($aTable == $this->table) {
                            if ($this->db->phptype == 'ibase') {
                                $cols[$aTable][] = $this->table. '.' .$colName . ' AS '. $colName;
                            } else {
                                $cols[$aTable][] = $this->table. '.' .$colName . ' AS "'. $colName .'"';
                            }
                        } else {
                            $cols[$aTable][] = "$aTable.$colName AS \"_".$this->getTableShortName($aTable)."_$colName\"";
                        }
                    }
                }
            }

            // put the extracted select back in the $what
            // that means replace 'table.*' by the i.e. 'table.id AS _table_id'
            // or if it is the table of this class replace 'table.id AS id'
            if (in_array('', $selectAllFromTables)) {
                $allCols = array();
                foreach ($cols as $aTable) {
                    $allCols[] = implode(',', $aTable);
                }
                $what = preg_replace('/(^|,)\*($|,)/', '$1'.implode(',',$allCols).'$2', $what);
                // remove all the 'table.*' since we have selected all anyway (because there was a '*' in the select)
                $what = preg_replace('/[^,]*(\.)?\*\s*(,|$)/U', '', $what);
            } else {
                foreach ($cols as $tableName => $aTable) {
                    if (is_array($aTable) && sizeof($aTable)) {
                        // replace all the 'table.*' by their select of each column
                        $what = preg_replace('/(^|,)\s*'.$tableName.'\.\*\s*($|,)/', '$1'.implode(',',$aTable).'$2', $what);
                    }
                }
            }
        }

        if ($this->getJoin()) {
            // replace all 'column' by '$this->table.column' to prevent ambigious errors
            $metadata = $this->metadata();
            if (is_array($metadata)) {
                foreach ($metadata as $aCol => $x) {
                    // handle ',id as xid,MAX(id),id' etc.
// FIXXME do this better!!!
                    $what = preg_replace(  "/(^|,|\()(\s*)$aCol(\)|\s|,|as|$)/i",
                                            // $2 is actually just to keep the spaces, is not really
                                            // necessary, but this way the test works independent of this functionality here
                                            "$1$2{$this->table}.$aCol$3",
                                            $what);
                }
            }
            // replace all 'joinedTable.columnName' by '_joinedTable_columnName'
            // this actually only has an effect if there was no 'table.*' for 'table'
            // if that was there, then it has already been done before
            foreach ($this->getJoin('tables') as $aTable) {
                if ($meta = $this->metadata($aTable)) {
                    foreach ($meta as $aCol=>$x) {
                        // dont put the 'AS' behind it if there is already one
                        if (preg_match("/$aTable.$aCol\s*as/i",$what)) {
                            continue;
                        }
                        // this covers a ' table.colName ' surrounded by spaces, and replaces it by ' table.colName AS _table_colName'
                        $what = preg_replace('/\s'.$aTable.'.'.$aCol.'\s/', " $aTable.$aCol AS _".$this->getTableShortName($aTable)."_$aCol ", $what);
                        // replace also the column names which are behind a ','
                        // and do this also if the aCol is at the end that's what the $ is for
                        $what = preg_replace('/,\s*'.$aTable.'.'.$aCol.'(,|\s|$)/', ",$aTable.$aCol AS _".$this->getTableShortName($aTable)."_$aCol$1", $what);
                        // replace if colName is first and possibly also if at the beginning of the where-string
                        $what = preg_replace('/(^\s*|\s+)'.$aTable.'.'.$aCol.'\s*,/', "$1$aTable.$aCol AS _".$this->getTableShortName($aTable)."_$aCol,", $what);
                    }
                }
            }
        }
        return $what;
    }

    // }}}
    // {{{ _buildWhere()

    /**
     * Build WHERE clause
     *
     * @param  string $where WHERE clause
     * @return string $where WHERE clause after processing
     * @access private
     */
    function _buildWhere($where='')
    {
        $where = trim($where);
        $originalWhere = $this->getWhere();
        if ($originalWhere) {
            if (!empty($where)) {
                $where = $originalWhere.' AND '.$where;
            } else {
                $where = $originalWhere;
            }
        }
        $where = trim($where);

        if ($join = $this->getJoin()) {     // is join set?
            // only those where conditions in the default-join have to be added here
            // left-join conditions are added behind 'ON', the '_buildJoin()' does that
            if (isset($join['default']) && count($join['default'])) {
                // we have to add this join-where clause here
                // since at least in mysql a query like: select * from tableX JOIN tableY ON ...
                // doesnt work, may be that's even SQL-standard...
                if (!empty($where)) {
                    $where = implode(' AND ', $join['default']).' AND '.$where;
                } else {
                    $where = implode(' AND ', $join['default']);
                }
            }
            // replace the _TABLENAME_COLUMNNAME by TABLENAME.COLUMNNAME
            // since oracle doesnt work with the _TABLENAME_COLUMNNAME which i think is strange
// FIXXME i think this should become deprecated since the setWhere should not be used like this: '_table_column' but 'table.column'
            $regExp = '/_('.implode('|', $this->getJoin('tables')).')_([^\s]+)/';
            $where = preg_replace($regExp, '$1.$2', $where);
            // add the table name before any column that has no table prefix
            // since this might cause "unambigious column" errors
            if ($meta = $this->metadata()) {
                foreach ($meta as $aCol => $x) {
                    // this covers the LIKE,IN stuff: 'name LIKE "%you%"'  'id IN (2,3,4,5)'
                    $where = preg_replace('/\s'.$aCol.'\s/', " {$this->table}.$aCol ", $where);
                    // replace also the column names which are behind a '='
                    // and do this also if the aCol is at the end of the where clause
                    // that's what the $ is for
                    $where = preg_replace('/([=<>])\s*'.$aCol.'(\s|$)/', "$1{$this->table}.$aCol ", $where);
                    // replace if colName is first and possibly also if at the beginning of the where-string
                    $where = preg_replace('/(^\s*|\s+)'.$aCol.'\s*([=<>])/', "$1{$this->table}.$aCol$2", $where);
                }
            }
        }
        return $where;
    }

    // }}}
    // {{{ _buildOrder()

    /**
     *
     *
     * @version    2002/07/11
     * @access     public
     * @author     Wolfram Kriesing <wk@visionp.de>
     * @param
     * @return
     */
    function _buildOrder()
    {
        $order = $this->getOrder();
        // replace 'column' by '$this->table.column' if the column is defined for $this->table
        if ($meta = $this->metadata()) {
            foreach ($meta as $aCol=>$x) {
                $order = preg_replace('/(^\s*|\s+|,)'.$aCol.'\s*(,)?/U', "$1{$this->table}.$aCol$2", $order);
            }
        }
        return $order;
    }

    // }}}
    // {{{ _buildGroup()

    /**
     *   Build the group-clause, replace 'column' by 'table.column'.
     *
     * @access public
     * @param void
     * @return string the rendered group clause
     */
    function _buildGroup()
    {
        $group = $this->getGroup();
        // replace 'column' by '$this->table.column' if the column is defined for $this->table
        if ($meta = $this->metadata()) {
            foreach ($meta as $aCol => $x) {
                $group = preg_replace('/(^\s*|\s+|,)'.$aCol.'\s*(,)?/U', "$1{$this->table}.$aCol$2", $group);
            }
        }
        return $group;
    }

    // }}}
    // {{{ _buildHaving()

    /**
     *
     * @version    2003/06/05
     * @access     public
     * @author     Johannes Schaefer <johnschaefer@gmx.de>
     * @param
     * @return string the having clause
     */
    function _buildHaving()
    {
        $having = $this->getHaving();
        // replace 'column' by '$this->table.column' if the column is defined for $this->table
        if ($meta = $this->metadata()) {
            foreach ($meta as $aCol => $x) {
                $having = preg_replace('/(^\s*|\s+|,)'.$aCol.'\s*(,)?/U',"$1{$this->table}.$aCol$2",$having);
            }
        }
        return $having;
    }

    // }}}
    // {{{ _buildHaving()

    /**
     *
     * @version    2002/07/11
     * @access     public
     * @author     Wolfram Kriesing <wk@visionp.de>
     * @param      array   this array contains the elements of the query,
     *                       indexed by their key, which are: 'select','from','where', etc.
     * @param      boolean whether this method is called via getCount() or not.
     * @return
     */
    function _buildSelectQuery($query=array(), $isCalledViaGetCount = false)
    {
/*FIXXXME finish this
        $cacheKey = md5(serialize(????));
        if (isset($this->_queryCache[$cacheKey])) {
            $this->_errorLog('using cached query',__LINE__);
            return $this->_queryCache[$cacheKey];
        }
*/
        $where = isset($query['where']) ? $query['where'] : $this->_buildWhere();
        if ($where) {
            $where = 'WHERE '.$where;
        }
        $order = isset($query['order']) ? $query['order'] : $this->_buildOrder();
        if ($order) {
            $order = 'ORDER BY '.$order;
        }
        $group = isset($query['group']) ? $query['group'] : $this->_buildGroup();
        if ($group) {
            $group = 'GROUP BY '.$group;
        }
        $having = isset($query['having']) ? $query['having'] : $this->_buildHaving();
        if ($having) {
            $having = 'HAVING '.$having;
        }
        $queryString = sprintf( 'SELECT %s FROM %s %s %s %s %s',
                                isset($query['select']) ? $query['select'] : $this->_buildSelect(),
                                isset($query['from']) ? $query['from'] : $this->_buildFrom(),
                                $where,
                                $group,
                                $having,
                                $order
                                );
        // $query['limit'] has preference!
        $limit = isset($query['limit']) ? $query['limit'] : $this->_limit;
        if (isset($limit[1])) {
            if (!$isCalledViaGetCount && @$limit[1]) {    // is there a count set?
                $queryString=$this->db->modifyLimitQuery($queryString,$limit[0],$limit[1]);
                if (DB::isError($queryString)) {
                    $this->_errorSet('DB_QueryTool::db::modifyLimitQuery failed '.$queryString->getMessage());
                    $this->_errorLog($queryString->getUserInfo());
                    return false;
                }
            }
        }
//        $this->_queryCache[$cacheKey] = $queryString;
        return $queryString;
    }

    // }}}
    // {{{ _buildUpdateQuery()

    /**
     * this simply builds an update query.
     *
     * @param  array   the parameter array might contain the following indexes
     *         'where'     the where clause to be added, i.e.
     *                     UPDATE table SET x=1 WHERE y=0
     *                     here the 'where' part simply would be 'y=0'
     *         'set'       the actual data to be updated
     *                     in the example above, that would be 'x=1'
     * @return string the resulting query
     */
    function _buildUpdateQuery($query=array())
    {
        $where = isset($query['where']) ? $query['where'] : $this->_buildWhere();
        if ($where) {
            $where = 'WHERE '.$where;
        }

        $updateString = sprintf('UPDATE %s SET %s %s',
                                $this->table,
                                $query['set'],
                                $where
                            );
        return $updateString;
    }

    // }}}
    // {{{ execute()

    /**
     *
     * @version    2002/07/11
     * @access     public
     * @author     Wolfram Kriesing <wk@visionp.de>
     * @param
     * @param      string  query method
     * @return     boolean
     */
    function execute($query=null, $method='getAll')
    {
        $this->writeLog();
        if (is_null($query)) {
            $query = $this->_buildSelectQuery();
        }
        $this->writeLog('query built: '.$query);

// FIXXME on ORACLE this doesnt work, since we return joined columns as _TABLE_COLNAME and the _ in front
// doesnt work on oracle, add a letter before it!!!
        $this->_lastQuery = $query;

        $this->debug($query);
        $this->writeLog('start query');
        if (DB::isError($res = $this->db->$method($query))) {
            $this->writeLog('end query (failed)');
            if ($this->getOption('verbose')) {
                $this->_errorSet($res->getMessage());
            } else {
                $this->_errorLog($res->getMessage());
            }
            $this->_errorLog($res->getUserInfo(), __LINE__);
            return false;
        } else {
            $this->writeLog('end query');
        }
        $res = $this->_makeIndexed($res);
        return $res;
    }

    // }}}
    // {{{ writeLog()

    /**
     *   Write events to the logfile.
     *
     *   It does some additional work, like time measuring etc. to
     *   see some additional info
     *
     */
    function writeLog($text='START')
    {
//its still really a quicky.... 'refactor' (nice word) that
        if (!isset($this->options['logfile'])) {
            return;
        }

        include_once 'Log.php';
        if (!class_exists('Log')) {
            return;
        }
        if (!$this->_logObject) {
            $this->_logObject =& Log::factory('file', $this->options['logfile']);
        }

        if ($text==='start query' || $text==='end query') {
            $bytesSent = $this->db->getAll("SHOW STATUS like 'Bytes_sent'");
            $bytesSent = $bytesSent[0]['Value'];
        }
        if ($text==='START') {
            $startTime = split(' ', microtime());
            $this->_logData['startTime'] = $startTime[1] + $startTime[0];
        }
        if ($text==='start query') {
            $this->_logData['startBytesSent'] = $bytesSent;
            $startTime = split(' ', microtime());
            $this->_logData['startQueryTime'] = $startTime[1] + $startTime[0];
            return;
        }
        if ($text==='end query') {
            $text .= ' result size: '.((int)$bytesSent-(int)$this->_logData['startBytesSent']).' bytes';
            $endTime = split(' ', microtime());
            $endTime = $endTime[1] + $endTime[0];
            $text .= ', took: '.(($endTime - $this->_logData['startQueryTime'])).' seconds';
        }
        if (strpos($text, 'query built')===0) {
            $endTime = split(' ', microtime());
            $endTime = $endTime[1] + $endTime[0];
            $this->writeLog('query building took: '.(($endTime - $this->_logData['startTime'])).' seconds');
        }
        $this->_logObject->log($text);

        if (strpos($text, 'end query')===0) {
            $endTime = split(' ', microtime());
            $endTime = $endTime[1] + $endTime[0];
            $text = 'time over all: '.(($endTime - $this->_logData['startTime'])).' seconds';
            $this->_logObject->log($text);
        }
    }

    // }}}
    // {{{ returnResult()

    /**
     * Return the chosen result type
     *
     * @version    2004/04/28
     * @access     public
     * @param object reference
     * @return mixed
     */
    function returnResult(&$result)
    {
        if ($this->_resultType == 'none') {
            return $result;
        }
        if ($result === false) {
            return false;
        }
        //what about allowing other (custom) result types?
        switch (strtolower($this->_resultType)) {
            case 'object':  return new DB_QueryTool_Result_Object($result);
            case 'array':
            default:        return new DB_QueryTool_Result($result);
        }
    }

    // }}}
    // {{{ _makeIndexed()

    /**
     *
     * @version    2002/07/11
     * @access     public
     * @author     Wolfram Kriesing <wk@visionp.de>
     * @param      mixed
     * @return     mixed
     */
    function &_makeIndexed(&$data)
    {
        // we can only return an indexed result if the result has a number of columns
        if (is_array($data) && sizeof($data) && $key = $this->getIndex()) {
            // build the string to evaluate which might be made up out of multiple indexes of a result-row
            $evalString = '$val[\''.implode('\'].\',\'.$val[\'',explode(',',$key)).'\']';   //"

            $indexedData = array();
//FIXXME actually we also need to check ONCE if $val is an array, so to say if $data is 2-dimensional
            foreach ($data as $val) {
                eval("\$keyValue = $evalString;");  // get the actual real (string-)key (string if multiple cols are used as index)
                $indexedData[$keyValue] = $val;
            }
            unset($data);
            return $indexedData;
        }

        return $data;
    }

    // }}}
    // {{{ setIndex()

    /**
     * format the result to be indexed by $key
     * NOTE: be careful, when using this you should be aware, that if you
     * use an index which's value appears multiple times you may loose data
     * since a key cant exist multiple times!!
     * the result for a result to be indexed by a key(=columnName)
     * (i.e. 'relationtoMe') which's values are 'brother' and 'sister'
     * or alike normally returns this:
     *     $res['brother'] = array('name'=>'xxx')
     *     $res['sister'] = array('name'=>'xxx')
     * but if the column 'relationtoMe' contains multiple entries for 'brother'
     * then the returned dataset will only contain one brother, since the
     * value from the column 'relationtoMe' is used
     * and which 'brother' you get depends on a lot of things, like the sortorder,
     * how the db saves the data, and whatever else
     *
     * you can also set indexes which depend on 2 columns, simply pass the parameters like
     * 'table1.id,table2.id' it will be used as a string for indexing the result
     * and the index will be built using the 2 values given, so a possible
     * index might be '1,2' or '2108,29389' this way you can access data which
     * have 2 primary keys. Be sure to remember that the index is a string!
     *
     * @version    2002/07/11
     * @access     public
     * @author     Wolfram Kriesing <wk@visionp.de>
     * @param
     * @return
     */
    function setIndex($key=null)
    {
        if ($this->getJoin()) { // is join set?
            // replace TABLENAME.COLUMNNAME by _TABLENAME_COLUMNNAME
            // since this is only the result-keys can be used for indexing :-)
            $regExp = '/('.implode('|', $this->getJoin('tables')).')\.([^\s]+)/';
            $key = preg_replace($regExp, '_$1_$2', $key);

            // remove the table name if it is in front of '<$this->table>.columnname'
            // since the key doesnt contain it neither
            if ($meta = $this->metadata()) {
                foreach ($meta as $aCol => $x) {
                    $key = preg_replace('/'.$this->table.'\.'.$aCol.'/', $aCol, $key);
                }
            }
        }
        $this->_index = $key;
    }

    // }}}
    // {{{ getIndex()

    /**
     *
     * @version    2002/07/11
     * @access     public
     * @author     Wolfram Kriesing <wk@visionp.de>
     * @param
     * @return
     */
    function getIndex()
    {
        return $this->_index;
    }

    // }}}
    // {{{ useResult()

    /**
     * Choose the type of the returned result
     *
     * @version    2004/04/28
     * @access     public
     * @param string $type  ['array' | 'object' | 'none']
     *             For BC reasons, $type=true is equal to 'array',
     *             $type=false is equal to 'none'
     */
    function useResult($type='array')
    {
        if ($type === true) {
            $type = 'array';
        } elseif ($type === false) {
            $type = 'none';
        }
        switch (strtolower($type)) {
            case 'array':
                $this->_resultType = 'array';
                require_once 'DB/QueryTool/Result.php';
                break;
            case 'object':
                $this->_resultType = 'object';
                require_once 'DB/QueryTool/Result/Object.php';
                break;
            default:
                $this->_resultType = 'none';
        }
    }

    // }}}
    // {{{ setErrorCallback()

    /**
     * set both callbacks
     * @param string
     */
    function setErrorCallback($param='')
    {
        $this->setErrorLogCallback($param);
        $this->setErrorSetCallback($param);
    }

    // }}}
    // {{{ setErrorLogCallback()

    /**
     * @param string
     */
    function setErrorLogCallback($param='')
    {
        $errorLogCallback = &PEAR::getStaticProperty('DB_QueryTool','_errorLogCallback');
        $errorLogCallback = $param;
    }

    // }}}
    // {{{ setErrorSetCallback()

    /**
     * @param string
     */
    function setErrorSetCallback($param='')
    {
        $errorSetCallback = &PEAR::getStaticProperty('DB_QueryTool','_errorSetCallback');
        $errorSetCallback = $param;
    }

    // }}}
    // {{{ _errorLog()

    /**
     * sets error log and adds additional info
     *
     * @version    2002/04/16
     * @access     public
     * @author     Wolfram Kriesing <wk@visionp.de>
     * @param      string  the actual message, first word should always be the method name,
     *                     to build the message like this: className::methodname
     * @param      integer the line number
     */
    function _errorLog($msg, $line='unknown')
    {
        $this->_errorHandler('log', $msg, $line);
/*
        if ($this->getOption('verbose') == true)
        {
            $this->_errorLog(get_class($this)."::$msg ($line)");
            return;
        }

        if ($this->_errorLogCallback)
            call_user_func($this->_errorLogCallback, $msg);
*/
    }

    // }}}
    // {{{ _errorSet()

    /**
     * @param      string
     * @param      string
     */
    function _errorSet($msg, $line='unknown')
    {
        $this->_errorHandler('set', $msg, $line);
    }

    // }}}
    // {{{ _errorHandler()

    /**
     * @param
     * @param      string
     * @param      string
     */
    function _errorHandler($logOrSet, $msg, $line='unknown')
    {
/* what did i do this for?
        if ($this->getOption('verbose') == true)
        {
            $this->_errorHandler($logOrSet, get_class($this)."::$msg ($line)");
            return;
        }
*/

        $msg = get_class($this)."::$msg ($line)";

        $logOrSet = ucfirst($logOrSet);
        $callback = &PEAR::getStaticProperty('DB_QueryTool','_error'.$logOrSet.'Callback');
        //var_dump($callback);
        //if ($callback)
        //    call_user_func($callback, $msg);
//        else
//          ?????

    }

    // }}}
}
?>