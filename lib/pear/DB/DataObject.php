<?php
/**
 * Object Based Database Query Builder and data store
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
 * @package    DB_DataObject
 * @author     Alan Knowles <alan@akbkhome.com>
 * @copyright  1997-2006 The PHP Group
 * @license    http://www.php.net/license/3_0.txt  PHP License 3.0
 * @link       http://pear.php.net/package/DB_DataObject
 */


/* ===========================================================================
 *
 *    !!!!!!!!!!!!!               W A R N I N G                !!!!!!!!!!!
 *
 *  THIS MAY SEGFAULT PHP IF YOU ARE USING THE ZEND OPTIMIZER (to fix it,
 *  just add "define('DB_DATAOBJECT_NO_OVERLOAD',true);" before you include
 *  this file. reducing the optimization level may also solve the segfault.
 *  ===========================================================================
 */

/**
 * The main "DB_DataObject" class is really a base class for your own tables classes
 *
 * // Set up the class by creating an ini file (refer to the manual for more details
 * [DB_DataObject]
 * database         = mysql:/username:password@host/database
 * schema_location = /home/myapplication/database
 * class_location  = /home/myapplication/DBTables/
 * clase_prefix    = DBTables_
 *
 *
 * //Start and initialize...................... - dont forget the &
 * $config = parse_ini_file('example.ini',true);
 * $options = PEAR::getStaticProperty('DB_DataObject','options');
 * $options = $config['DB_DataObject'];
 *
 * // example of a class (that does not use the 'auto generated tables data')
 * class mytable extends DB_DataObject {
 *     // mandatory - set the table
 *     var $_database_dsn = "mysql://username:password@localhost/database";
 *     var $__table = "mytable";
 *     function table() {
 *         return array(
 *             'id' => 1, // integer or number
 *             'name' => 2, // string
 *        );
 *     }
 *     function keys() {
 *         return array('id');
 *     }
 * }
 *
 * // use in the application
 *
 *
 * Simple get one row
 *
 * $instance = new mytable;
 * $instance->get("id",12);
 * echo $instance->somedata;
 *
 *
 * Get multiple rows
 *
 * $instance = new mytable;
 * $instance->whereAdd("ID > 12");
 * $instance->whereAdd("ID < 14");
 * $instance->find();
 * while ($instance->fetch()) {
 *     echo $instance->somedata;
 * }


/**
 * Needed classes
 * - we use getStaticProperty from PEAR pretty extensively (cant remove it ATM)
 */

require_once 'PEAR.php';

/**
 * We are duping fetchmode constants to be compatible with
 * both DB and MDB2
 */
define('DB_DATAOBJECT_FETCHMODE_ORDERED',1);
define('DB_DATAOBJECT_FETCHMODE_ASSOC',2);





/**
 * these are constants for the get_table array
 * user to determine what type of escaping is required around the object vars.
 */
define('DB_DATAOBJECT_INT',  1);  // does not require ''
define('DB_DATAOBJECT_STR',  2);  // requires ''

define('DB_DATAOBJECT_DATE', 4);  // is date #TODO
define('DB_DATAOBJECT_TIME', 8);  // is time #TODO
define('DB_DATAOBJECT_BOOL', 16); // is boolean #TODO
define('DB_DATAOBJECT_TXT',  32); // is long text #TODO
define('DB_DATAOBJECT_BLOB', 64); // is blob type


define('DB_DATAOBJECT_NOTNULL', 128);           // not null col.
define('DB_DATAOBJECT_MYSQLTIMESTAMP'   , 256);           // mysql timestamps (ignored by update/insert)
/*
 * Define this before you include DataObjects.php to  disable overload - if it segfaults due to Zend optimizer..
 */
//define('DB_DATAOBJECT_NO_OVERLOAD',true)


/**
 * Theses are the standard error codes, most methods will fail silently - and return false
 * to access the error message either use $table->_lastError
 * or $last_error = PEAR::getStaticProperty('DB_DataObject','lastError');
 * the code is $last_error->code, and the message is $last_error->message (a standard PEAR error)
 */

define('DB_DATAOBJECT_ERROR_INVALIDARGS',   -1);  // wrong args to function
define('DB_DATAOBJECT_ERROR_NODATA',        -2);  // no data available
define('DB_DATAOBJECT_ERROR_INVALIDCONFIG', -3);  // something wrong with the config
define('DB_DATAOBJECT_ERROR_NOCLASS',       -4);  // no class exists
define('DB_DATAOBJECT_ERROR_INVALID_CALL'  ,-7);  // overlad getter/setter failure

/**
 * Used in methods like delete() and count() to specify that the method should
 * build the condition only out of the whereAdd's and not the object parameters.
 */
define('DB_DATAOBJECT_WHEREADD_ONLY', true);

/**
 *
 * storage for connection and result objects,
 * it is done this way so that print_r()'ing the is smaller, and
 * it reduces the memory size of the object.
 * -- future versions may use $this->_connection = & PEAR object..
 *   although will need speed tests to see how this affects it.
 * - includes sub arrays
 *   - connections = md5 sum mapp to pear db object
 *   - results     = [id] => map to pear db object
 *   - resultseq   = sequence id for results & results field
 *   - resultfields = [id] => list of fields return from query (for use with toArray())
 *   - ini         = mapping of database to ini file results
 *   - links       = mapping of database to links file
 *   - lasterror   = pear error objects for last error event.
 *   - config      = aliased view of PEAR::getStaticPropery('DB_DataObject','options') * done for performance.
 *   - array of loaded classes by autoload method - to stop it doing file access request over and over again!
 */
$GLOBALS['_DB_DATAOBJECT']['RESULTS']   = array();
$GLOBALS['_DB_DATAOBJECT']['RESULTSEQ'] = 1;
$GLOBALS['_DB_DATAOBJECT']['RESULTFIELDS'] = array();
$GLOBALS['_DB_DATAOBJECT']['CONNECTIONS'] = array();
$GLOBALS['_DB_DATAOBJECT']['INI'] = array();
$GLOBALS['_DB_DATAOBJECT']['LINKS'] = array();
$GLOBALS['_DB_DATAOBJECT']['SEQUENCE'] = array();
$GLOBALS['_DB_DATAOBJECT']['LASTERROR'] = null;
$GLOBALS['_DB_DATAOBJECT']['CONFIG'] = array();
$GLOBALS['_DB_DATAOBJECT']['CACHE'] = array();
$GLOBALS['_DB_DATAOBJECT']['OVERLOADED'] = false;
$GLOBALS['_DB_DATAOBJECT']['QUERYENDTIME'] = 0;



class DB_DataObject_Overload
{
    function __call($method,$args)
    {
        $return = null;
        $this->_call($method,$args,$return);
        return $return;
    }
    function __sleep()
    {
        return array_keys(get_object_vars($this)) ;
    }
}




 /*
 *
 * @package  DB_DataObject
 * @author   Alan Knowles <alan@akbkhome.com>
 * @since    PHP 4.0
 */

class DB_DataObject extends DB_DataObject_Overload
{
   /**
    * The Version - use this to check feature changes
    *
    * @access   private
    * @var      string
    */
    var $_DB_DataObject_version = "1.8.5";

    /**
     * The Database table (used by table extends)
     *
     * @access  private
     * @var     string
     */
    var $__table = '';  // database table

    /**
     * The Number of rows returned from a query
     *
     * @access  public
     * @var     int
     */
    var $N = 0;  // Number of rows returned from a query

    /* ============================================================= */
    /*                      Major Public Methods                     */
    /* (designed to be optionally then called with parent::method()) */
    /* ============================================================= */


    /**
     * Get a result using key, value.
     *
     * for example
     * $object->get("ID",1234);
     * Returns Number of rows located (usually 1) for success,
     * and puts all the table columns into this classes variables
     *
     * see the fetch example on how to extend this.
     *
     * if no value is entered, it is assumed that $key is a value
     * and get will then use the first key in keys()
     * to obtain the key.
     *
     * @param   string  $k column
     * @param   string  $v value
     * @access  public
     * @return  int     No. of rows
     */
    function get($k = null, $v = null)
    {
        global $_DB_DATAOBJECT;
        if (empty($_DB_DATAOBJECT['CONFIG'])) {
            DB_DataObject::_loadConfig();
        }
        $keys = array();

        if ($v === null) {
            $v = $k;
            $keys = $this->keys();
            if (!$keys) {
                $this->raiseError("No Keys available for {$this->__table}", DB_DATAOBJECT_ERROR_INVALIDCONFIG);
                return false;
            }
            $k = $keys[0];
        }
        if (!empty($_DB_DATAOBJECT['CONFIG']['debug'])) {
            $this->debug("$k $v " .print_r($keys,true), "GET");
        }

        if ($v === null) {
            $this->raiseError("No Value specified for get", DB_DATAOBJECT_ERROR_INVALIDARGS);
            return false;
        }
        $this->$k = $v;
        return $this->find(1);
    }

    /**
     * An autoloading, caching static get method  using key, value (based on get)
     *
     * Usage:
     * $object = DB_DataObject::staticGetFromClassName("DbTable_mytable",12);
     * or
     * $object =  DB_DataObject::staticGetFromClassName("DbTable_mytable","name","fred");
     *
     * or write it into your extended class:
     * function staticGet($k,$v=NULL) { return DB_DataObject::staticGetFromClassName("This_Class",$k,$v);  }
     *
     * @param   string  $class class name
     * @param   string  $k     column (or value if using keys)
     * @param   string  $v     value (optional)
     * @access  public
     * @return  object
     */
    static function staticGetFromClassName($class, $k, $v = null)
    {
        $lclass = strtolower($class);
        global $_DB_DATAOBJECT;
        if (empty($_DB_DATAOBJECT['CONFIG'])) {
            DB_DataObject::_loadConfig();
        }



        $key = "$k:$v";
        if ($v === null) {
            $key = $k;
        }
        if (!empty($_DB_DATAOBJECT['CONFIG']['debug'])) {
            DB_DataObject::debug("$class $key","STATIC GET - TRY CACHE");
        }
        if (!empty($_DB_DATAOBJECT['CACHE'][$lclass][$key])) {
            return $_DB_DATAOBJECT['CACHE'][$lclass][$key];
        }
        if (!empty($_DB_DATAOBJECT['CONFIG']['debug'])) {
            DB_DataObject::debug("$class $key","STATIC GET - NOT IN CACHE");
        }

        $obj = DB_DataObject::factory(substr($class,strlen($_DB_DATAOBJECT['CONFIG']['class_prefix'])));
        if (PEAR::isError($obj)) {
            DB_DataObject::raiseError("could not autoload $class", DB_DATAOBJECT_ERROR_NOCLASS);
            $r = false;
            return $r;
        }

        if (!isset($_DB_DATAOBJECT['CACHE'][$lclass])) {
            $_DB_DATAOBJECT['CACHE'][$lclass] = array();
        }
        if (!$obj->get($k,$v)) {
            DB_DataObject::raiseError("No Data return from get $k $v", DB_DATAOBJECT_ERROR_NODATA);

            $r = false;
            return $r;
        }
        $_DB_DATAOBJECT['CACHE'][$lclass][$key] = $obj;
        return $_DB_DATAOBJECT['CACHE'][$lclass][$key];
    }

    /**
     * find results, either normal or crosstable
     *
     * for example
     *
     * $object = new mytable();
     * $object->ID = 1;
     * $object->find();
     *
     *
     * will set $object->N to number of rows, and expects next command to fetch rows
     * will return $object->N
     *
     * @param   boolean $n Fetch first result
     * @access  public
     * @return  mixed (number of rows returned, or true if numRows fetching is not supported)
     */
    function find($n = false)
    {
        global $_DB_DATAOBJECT;
        if (!isset($this->_query)) {
            $this->raiseError(
                "You cannot do two queries on the same object (copy it before finding)",
                DB_DATAOBJECT_ERROR_INVALIDARGS);
            return false;
        }

        if (empty($_DB_DATAOBJECT['CONFIG'])) {
            DB_DataObject::_loadConfig();
        }

        if (!empty($_DB_DATAOBJECT['CONFIG']['debug'])) {
            $this->debug($n, "find",1);
        }
        if (!$this->__table) {
            // xdebug can backtrace this!
            trigger_error("NO \$__table SPECIFIED in class definition",E_USER_ERROR);
        }
        $this->N = 0;
        $query_before = $this->_query;
        $this->_build_condition($this->table()) ;

        $quoteIdentifiers = !empty($_DB_DATAOBJECT['CONFIG']['quote_identifiers']);
        $this->_connect();
        $DB = $_DB_DATAOBJECT['CONNECTIONS'][$this->_database_dsn_md5];

        /* We are checking for method modifyLimitQuery as it is PEAR DB specific */
        $sql = 'SELECT ' .
            $this->_query['data_select'] . " \n" .
            ' FROM ' . ($quoteIdentifiers ? $DB->quoteIdentifier($this->__table) : $this->__table) . " \n" .
            $this->_join . " \n" .
            $this->_query['condition'] . " \n" .
            $this->_query['group_by']  . " \n" .
            $this->_query['having']    . " \n" .
            $this->_query['order_by']  . " \n";

        if ((!isset($_DB_DATAOBJECT['CONFIG']['db_driver'])) ||
            ($_DB_DATAOBJECT['CONFIG']['db_driver'] == 'DB')) {
            /* PEAR DB specific */

            if (isset($this->_query['limit_start']) && strlen($this->_query['limit_start'] . $this->_query['limit_count'])) {
                $sql = $DB->modifyLimitQuery($sql,$this->_query['limit_start'], $this->_query['limit_count']);
            }
        } else {
            /* theoretically MDB2! */
            if (isset($this->_query['limit_start']) && strlen($this->_query['limit_start'] . $this->_query['limit_count'])) {
	            $DB->setLimit($this->_query['limit_count'],$this->_query['limit_start']);
	        }
        }


        $this->_query($sql);

        if (!empty($_DB_DATAOBJECT['CONFIG']['debug'])) {
            $this->debug("CHECK autofetchd $n", "find", 1);
        }

        // find(true)

        $ret = $this->N;
        if (!$ret && !empty($_DB_DATAOBJECT['RESULTS'][$this->_DB_resultid])) {
            // clear up memory if nothing found!?
            unset($_DB_DATAOBJECT['RESULTS'][$this->_DB_resultid]);
        }

        if ($n && $this->N > 0 ) {
            if (!empty($_DB_DATAOBJECT['CONFIG']['debug'])) {
                $this->debug("ABOUT TO AUTOFETCH", "find", 1);
            }
            $fs = $this->fetch();
            // if fetch returns false (eg. failed), then the backend doesnt support numRows (eg. ret=true)
            // - hence find() also returns false..
            $ret = ($ret === true) ? $fs : $ret;
        }
        if (!empty($_DB_DATAOBJECT['CONFIG']['debug'])) {
            $this->debug("DONE", "find", 1);
        }
        $this->_query = $query_before;
        return $ret;
    }

    /**
     * fetches next row into this objects var's
     *
     * returns 1 on success 0 on failure
     *
     *
     *
     * Example
     * $object = new mytable();
     * $object->name = "fred";
     * $object->find();
     * $store = array();
     * while ($object->fetch()) {
     *   echo $this->ID;
     *   $store[] = $object; // builds an array of object lines.
     * }
     *
     * to add features to a fetch
     * function fetch () {
     *    $ret = parent::fetch();
     *    $this->date_formated = date('dmY',$this->date);
     *    return $ret;
     * }
     *
     * @access  public
     * @return  boolean on success
     */
    function fetch()
    {

        global $_DB_DATAOBJECT;
        if (empty($_DB_DATAOBJECT['CONFIG'])) {
            DB_DataObject::_loadConfig();
        }
        if (empty($this->N)) {
            if (!empty($_DB_DATAOBJECT['CONFIG']['debug'])) {
                $this->debug("No data returned from FIND (eg. N is 0)","FETCH", 3);
            }
            return false;
        }

        if (empty($_DB_DATAOBJECT['RESULTS'][$this->_DB_resultid]) ||
            !is_object($result = &$_DB_DATAOBJECT['RESULTS'][$this->_DB_resultid]))
        {
            if (!empty($_DB_DATAOBJECT['CONFIG']['debug'])) {
                $this->debug('fetched on object after fetch completed (no results found)');
            }
            return false;
        }


        $array = $result->fetchRow(DB_DATAOBJECT_FETCHMODE_ASSOC);
        if (!empty($_DB_DATAOBJECT['CONFIG']['debug'])) {
            $this->debug(serialize($array),"FETCH");
        }

        // fetched after last row..
        if ($array === null) {
            if (!empty($_DB_DATAOBJECT['CONFIG']['debug'])) {
                $t= explode(' ',microtime());

                $this->debug("Last Data Fetch'ed after " .
                        ($t[0]+$t[1]- $_DB_DATAOBJECT['QUERYENDTIME']  ) .
                        " seconds",
                    "FETCH", 1);
            }
            // reduce the memory usage a bit... (but leave the id in, so count() works ok on it)
            unset($_DB_DATAOBJECT['RESULTS'][$this->_DB_resultid]);

            // we need to keep a copy of resultfields locally so toArray() still works
            // however we dont want to keep it in the global cache..

            if (!empty($_DB_DATAOBJECT['RESULTFIELDS'][$this->_DB_resultid])) {
                $this->_resultFields = $_DB_DATAOBJECT['RESULTFIELDS'][$this->_DB_resultid];
                unset($_DB_DATAOBJECT['RESULTFIELDS'][$this->_DB_resultid]);
            }
            // this is probably end of data!!
            //DB_DataObject::raiseError("fetch: no data returned", DB_DATAOBJECT_ERROR_NODATA);
            return false;
        }
        // make sure resultFields is always empty..
        $this->_resultFields = false;

        if (!isset($_DB_DATAOBJECT['RESULTFIELDS'][$this->_DB_resultid])) {
            // note: we dont declare this to keep the print_r size down.
            $_DB_DATAOBJECT['RESULTFIELDS'][$this->_DB_resultid]= array_flip(array_keys($array));
        }

        foreach($array as $k=>$v) {
            $kk = str_replace(".", "_", $k);
            $kk = str_replace(" ", "_", $kk);
            if (!empty($_DB_DATAOBJECT['CONFIG']['debug'])) {
                $this->debug("$kk = ". $array[$k], "fetchrow LINE", 3);
            }
            $this->$kk = $array[$k];
        }

        // set link flag
        $this->_link_loaded=false;
        if (!empty($_DB_DATAOBJECT['CONFIG']['debug'])) {
            $this->debug("{$this->__table} DONE", "fetchrow",2);
        }
        if (isset($this->_query) &&  empty($_DB_DATAOBJECT['CONFIG']['keep_query_after_fetch'])) {
            unset($this->_query);
        }
        return true;
    }

    /**
     * Adds a condition to the WHERE statement, defaults to AND
     *
     * $object->whereAdd(); //reset or cleaer ewhwer
     * $object->whereAdd("ID > 20");
     * $object->whereAdd("age > 20","OR");
     *
     * @param    string  $cond  condition
     * @param    string  $logic optional logic "OR" (defaults to "AND")
     * @access   public
     * @return   string|PEAR::Error - previous condition or Error when invalid args found
     */
    function whereAdd($cond = false, $logic = 'AND')
    {

	if (!isset($this->_query)) {
            return $this->raiseError(
                "You cannot do two queries on the same object (clone it before finding)",
                DB_DATAOBJECT_ERROR_INVALIDARGS);
        }

        if ($cond === false) {
            $r = $this->_query['condition'];
            $this->_query['condition'] = '';
            return preg_replace('/^\s+WHERE\s+/','',$r);
        }
        // check input...= 0 or '   ' == error!
        if (!trim($cond)) {
            return $this->raiseError("WhereAdd: No Valid Arguments", DB_DATAOBJECT_ERROR_INVALIDARGS);
        }
        $r = $this->_query['condition'];
        if ($this->_query['condition']) {
            $this->_query['condition'] .= " {$logic} ( {$cond} )";
            return $r;
        }
        $this->_query['condition'] = " WHERE ( {$cond} ) ";
        return $r;
    }

    /**
     * Adds a order by condition
     *
     * $object->orderBy(); //clears order by
     * $object->orderBy("ID");
     * $object->orderBy("ID,age");
     *
     * @param  string $order  Order
     * @access public
     * @return none|PEAR::Error - invalid args only
     */
    function orderBy($order = false)
    {
        if (!isset($this->_query)) {
            $this->raiseError(
                "You cannot do two queries on the same object (copy it before finding)",
                DB_DATAOBJECT_ERROR_INVALIDARGS);
            return false;
        }
        if ($order === false) {
            $this->_query['order_by'] = '';
            return;
        }
        // check input...= 0 or '    ' == error!
        if (!trim($order)) {
            return $this->raiseError("orderBy: No Valid Arguments", DB_DATAOBJECT_ERROR_INVALIDARGS);
        }

        if (!$this->_query['order_by']) {
            $this->_query['order_by'] = " ORDER BY {$order} ";
            return;
        }
        $this->_query['order_by'] .= " , {$order}";
    }

    /**
     * Adds a group by condition
     *
     * $object->groupBy(); //reset the grouping
     * $object->groupBy("ID DESC");
     * $object->groupBy("ID,age");
     *
     * @param  string  $group  Grouping
     * @access public
     * @return none|PEAR::Error - invalid args only
     */
    function groupBy($group = false)
    {
        if (!isset($this->_query)) {
            $this->raiseError(
                "You cannot do two queries on the same object (copy it before finding)",
                DB_DATAOBJECT_ERROR_INVALIDARGS);
            return false;
        }
        if ($group === false) {
            $this->_query['group_by'] = '';
            return;
        }
        // check input...= 0 or '    ' == error!
        if (!trim($group)) {
            return $this->raiseError("groupBy: No Valid Arguments", DB_DATAOBJECT_ERROR_INVALIDARGS);
        }


        if (!$this->_query['group_by']) {
            $this->_query['group_by'] = " GROUP BY {$group} ";
            return;
        }
        $this->_query['group_by'] .= " , {$group}";
    }

    /**
     * Adds a having clause
     *
     * $object->having(); //reset the grouping
     * $object->having("sum(value) > 0 ");
     *
     * @param  string  $having  condition
     * @access public
     * @return none|PEAR::Error - invalid args only
     */
    function having($having = false)
    {
        if (!isset($this->_query)) {
            $this->raiseError(
                "You cannot do two queries on the same object (copy it before finding)",
                DB_DATAOBJECT_ERROR_INVALIDARGS);
            return false;
        }
        if ($having === false) {
            $this->_query['having'] = '';
            return;
        }
        // check input...= 0 or '    ' == error!
        if (!trim($having)) {
            return $this->raiseError("Having: No Valid Arguments", DB_DATAOBJECT_ERROR_INVALIDARGS);
        }


        if (!$this->_query['having']) {
            $this->_query['having'] = " HAVING {$having} ";
            return;
        }
        $this->_query['having'] .= " AND {$having}";
    }

    /**
     * Sets the Limit
     *
     * $boject->limit(); // clear limit
     * $object->limit(12);
     * $object->limit(12,10);
     *
     * Note this will emit an error on databases other than mysql/postgress
     * as there is no 'clean way' to implement it. - you should consider refering to
     * your database manual to decide how you want to implement it.
     *
     * @param  string $a  limit start (or number), or blank to reset
     * @param  string $b  number
     * @access public
     * @return none|PEAR::Error - invalid args only
     */
    function limit($a = null, $b = null)
    {
        if (!isset($this->_query)) {
            $this->raiseError(
                "You cannot do two queries on the same object (copy it before finding)",
                DB_DATAOBJECT_ERROR_INVALIDARGS);
            return false;
        }

        if ($a === null) {
           $this->_query['limit_start'] = '';
           $this->_query['limit_count'] = '';
           return;
        }
        // check input...= 0 or '    ' == error!
        if ((!is_int($a) && ((string)((int)$a) !== (string)$a))
            || (($b !== null) && (!is_int($b) && ((string)((int)$b) !== (string)$b)))) {
            return $this->raiseError("limit: No Valid Arguments", DB_DATAOBJECT_ERROR_INVALIDARGS);
        }
        global $_DB_DATAOBJECT;
        $this->_connect();
        $DB = &$_DB_DATAOBJECT['CONNECTIONS'][$this->_database_dsn_md5];

        $this->_query['limit_start'] = ($b == null) ? 0 : (int)$a;
        $this->_query['limit_count'] = ($b == null) ? (int)$a : (int)$b;

    }

    /**
     * Adds a select columns
     *
     * $object->selectAdd(); // resets select to nothing!
     * $object->selectAdd("*"); // default select
     * $object->selectAdd("unixtime(DATE) as udate");
     * $object->selectAdd("DATE");
     *
     * to prepend distict:
     * $object->selectAdd('distinct ' . $object->selectAdd());
     *
     * @param  string  $k
     * @access public
     * @return mixed null or old string if you reset it.
     */
    function selectAdd($k = null)
    {
        if (!isset($this->_query)) {
            $this->raiseError(
                "You cannot do two queries on the same object (copy it before finding)",
                DB_DATAOBJECT_ERROR_INVALIDARGS);
            return false;
        }
        if ($k === null) {
            $old = $this->_query['data_select'];
            $this->_query['data_select'] = '';
            return $old;
        }

        // check input...= 0 or '    ' == error!
        if (!trim($k)) {
            return $this->raiseError("selectAdd: No Valid Arguments", DB_DATAOBJECT_ERROR_INVALIDARGS);
        }

        if ($this->_query['data_select']) {
            $this->_query['data_select'] .= ', ';
        }
        $this->_query['data_select'] .= " $k ";
    }
    /**
     * Adds multiple Columns or objects to select with formating.
     *
     * $object->selectAs(null); // adds "table.colnameA as colnameA,table.colnameB as colnameB,......"
     *                      // note with null it will also clear the '*' default select
     * $object->selectAs(array('a','b'),'%s_x'); // adds "a as a_x, b as b_x"
     * $object->selectAs(array('a','b'),'ddd_%s','ccc'); // adds "ccc.a as ddd_a, ccc.b as ddd_b"
     * $object->selectAdd($object,'prefix_%s'); // calls $object->get_table and adds it all as
     *                  objectTableName.colnameA as prefix_colnameA
     *
     * @param  array|object|null the array or object to take column names from.
     * @param  string           format in sprintf format (use %s for the colname)
     * @param  string           table name eg. if you have joinAdd'd or send $from as an array.
     * @access public
     * @return void
     */
    function selectAs($from = null,$format = '%s',$tableName=false)
    {
        global $_DB_DATAOBJECT;

        if (!isset($this->_query)) {
            $this->raiseError(
                "You cannot do two queries on the same object (copy it before finding)",
                DB_DATAOBJECT_ERROR_INVALIDARGS);
            return false;
        }

        if ($from === null) {
            // blank the '*'
            $this->selectAdd();
            $from = $this;
        }


        $table = $this->__table;
        if (is_object($from)) {
            $table = $from->__table;
            $from = array_keys($from->table());
        }

        if ($tableName !== false) {
            $table = $tableName;
        }
        $s = '%s';
        if (!empty($_DB_DATAOBJECT['CONFIG']['quote_identifiers'])) {
            $this->_connect();
            $DB = &$_DB_DATAOBJECT['CONNECTIONS'][$this->_database_dsn_md5];
            $s      = $DB->quoteIdentifier($s);
            $format = $DB->quoteIdentifier($format);
        }
        foreach ($from as $k) {
            $this->selectAdd(sprintf("{$s}.{$s} as {$format}",$table,$k,$k));
        }
        $this->_query['data_select'] .= "\n";
    }
    /**
     * Insert the current objects variables into the database
     *
     * Returns the ID of the inserted element (if auto increment or sequences are used.)
     *
     * for example
     *
     * Designed to be extended
     *
     * $object = new mytable();
     * $object->name = "fred";
     * echo $object->insert();
     *
     * @access public
     * @return mixed false on failure, int when auto increment or sequence used, otherwise true on success
     */
    function insert()
    {
        global $_DB_DATAOBJECT;

        // we need to write to the connection (For nextid) - so us the real
        // one not, a copyied on (as ret-by-ref fails with overload!)

        if (!isset($_DB_DATAOBJECT['CONNECTIONS'][$this->_database_dsn_md5])) {
            $this->_connect();
        }

        $quoteIdentifiers  = !empty($_DB_DATAOBJECT['CONFIG']['quote_identifiers']);

        $DB = &$_DB_DATAOBJECT['CONNECTIONS'][$this->_database_dsn_md5];

        $items =  isset($_DB_DATAOBJECT['INI'][$this->_database][$this->__table]) ?
            $_DB_DATAOBJECT['INI'][$this->_database][$this->__table] : $this->table();

        if (!$items) {
            $this->raiseError("insert:No table definition for {$this->__table}",
                DB_DATAOBJECT_ERROR_INVALIDCONFIG);
            return false;
        }
        $options = &$_DB_DATAOBJECT['CONFIG'];


        $datasaved = 1;
        $leftq     = '';
        $rightq    = '';

        $seqKeys   = isset($_DB_DATAOBJECT['SEQUENCE'][$this->_database][$this->__table]) ?
                        $_DB_DATAOBJECT['SEQUENCE'][$this->_database][$this->__table] :
                        $this->sequenceKey();

        $key       = isset($seqKeys[0]) ? $seqKeys[0] : false;
        $useNative = isset($seqKeys[1]) ? $seqKeys[1] : false;
        $seq       = isset($seqKeys[2]) ? $seqKeys[2] : false;

        $dbtype    = $_DB_DATAOBJECT['CONNECTIONS'][$this->_database_dsn_md5]->dsn["phptype"];


        // nativeSequences or Sequences..

        // big check for using sequences

        if (($key !== false) && !$useNative) {

            if (!$seq) {
                // Since recent versions OA_DB is capable to generate sequence names for nextId
                // with both MySQL and PgSQL compatibility
                $seq = OA_DB::getSequenceName($DB, $this->_tableName, $key, false);
                $keyvalue =  $DB->nextId($seq);
            } else {
                $f = $DB->getOption('seqname_format');
                $DB->setOption('seqname_format','%s');
                $keyvalue = $DB->nextId($seq);
                $DB->setOption('seqname_format',$f);
            }
            if (PEAR::isError($keyvalue)) {
                $this->raiseError($keyvalue->toString(), DB_DATAOBJECT_ERROR_INVALIDCONFIG);
                return false;
            }
            $this->$key = $keyvalue;
        }



        foreach($items as $k => $v) {

            // if we are using autoincrement - skip the column...
            if ($key && ($k == $key) && $useNative) {
                continue;
            }


            if (!isset($this->$k)) {
                continue;
            }
            // dont insert data into mysql timestamps
            // use query() if you really want to do this!!!!
            if ($v & DB_DATAOBJECT_MYSQLTIMESTAMP) {
                continue;
            }

            if ($leftq) {
                $leftq  .= ', ';
                $rightq .= ', ';
            }

            $leftq .= ($quoteIdentifiers ? ($DB->quoteIdentifier($k) . ' ')  : "$k ");

            if (is_a($this->$k,'DB_DataObject_Cast')) {
                $value = $this->$k->toString($v,$DB);
                if (PEAR::isError($value)) {
                    $this->raiseError($value->toString() ,DB_DATAOBJECT_ERROR_INVALIDARGS);
                    return false;
                }
                $rightq .=  $value;
                continue;
            }



            if (is_string($this->$k) && (strtolower($this->$k) === 'null') && !($v & DB_DATAOBJECT_NOTNULL)) {
                $rightq .= " NULL ";
                continue;
            }
            // DATE is empty... on a col. that can be null..
            // note: this may be usefull for time as well..
            if (!$this->$k &&
                    (($v & DB_DATAOBJECT_DATE) || ($v & DB_DATAOBJECT_TIME)) &&
                    !($v & DB_DATAOBJECT_NOTNULL)) {

                $rightq .= " NULL ";
                continue;
            }


            if ($v & DB_DATAOBJECT_STR) {
                $rightq .= $this->_quote((string) (
                        ($v & DB_DATAOBJECT_BOOL) ?
                            // this is thanks to the braindead idea of postgres to
                            // use t/f for boolean.
                            (($this->$k === 'f') ? 0 : (int)(bool) $this->$k) :
                            $this->$k
                    )) . " ";
                continue;
            }
            if (is_numeric($this->$k)) {
                $rightq .=" {$this->$k} ";
                continue;
            }
            /* flag up string values - only at debug level... !!!??? */
            if (is_object($this->$k) || is_array($this->$k)) {
                $this->debug('ODD DATA: ' .$k . ' ' .  print_r($this->$k,true),'ERROR');
            }

            // at present we only cast to integers
            // - V2 may store additional data about float/int
            $rightq .= ' ' . intval($this->$k) . ' ';

        }

        // not sure why we let empty insert here.. - I guess to generate a blank row..


        if ($leftq || $useNative) {
            $table = ($quoteIdentifiers ? $DB->quoteIdentifier($this->__table)    : $this->__table);

            $r = $this->_query("INSERT INTO {$table} ($leftq) VALUES ($rightq) ");



            if (PEAR::isError($r)) {
                $this->raiseError($r);
                return false;
            }

            if ($r < 1) {
                return 0;
            }


            // now do we have an integer key!

            if ($key && $useNative) {
                switch ($dbtype) {
                    case 'mysql':
                    case 'mysqli':
                        $method = "{$dbtype}_insert_id";
                        $this->$key = $method(
                            $_DB_DATAOBJECT['CONNECTIONS'][$this->_database_dsn_md5]->connection
                        );
                        break;

                    case 'mssql':
                        // note this is not really thread safe - you should wrapp it with
                        // transactions = eg.
                        // $db->query('BEGIN');
                        // $db->insert();
                        // $db->query('COMMIT');

                        $mssql_key = $DB->getOne("SELECT @@IDENTITY");
                        if (PEAR::isError($mssql_key)) {
                            $this->raiseError($r);
                            return false;
                        }
                        $this->$key = $mssql_key;
                        break;

                    case 'pgsql':
                        if (!$seq) {
                            $seq = $DB->getSequenceName($this->__table );
                        }
                        $pgsql_key = $DB->getOne("SELECT currval('".$seq . "')");

                        if (PEAR::isError($pgsql_key)) {
                            $this->raiseError($r);
                            return false;
                        }
                        $this->$key = $pgsql_key;
                        break;

                    case 'ifx':
                        $this->$key = array_shift (
                            ifx_fetch_row (
                                ifx_query(
                                    "select DBINFO('sqlca.sqlerrd1') FROM systables where tabid=1",
                                    $_DB_DATAOBJECT['CONNECTIONS'][$this->_database_dsn_md5]->connection,
                                    IFX_SCROLL
                                ),
                                "FIRST"
                            )
                        );
                        break;

                }

            }

            if (isset($_DB_DATAOBJECT['CACHE'][strtolower(get_class($this))])) {
                $this->_clear_cache();
            }
            if ($key) {
                return $this->$key;
            }
            return true;
        }
        $this->raiseError("insert: No Data specifed for query", DB_DATAOBJECT_ERROR_NODATA);
        return false;
    }

    /**
     * Updates  current objects variables into the database
     * uses the keys() to decide how to update
     * Returns the  true on success
     *
     * for example
     *
     * $object = DB_DataObject::factory('mytable');
     * $object->get("ID",234);
     * $object->email="testing@test.com";
     * if(!$object->update())
     *   echo "UPDATE FAILED";
     *
     * to only update changed items :
     * $dataobject->get(132);
     * $original = $dataobject; // clone/copy it..
     * $dataobject->setFrom($_POST);
     * if ($dataobject->validate()) {
     *    $dataobject->update($original);
     * } // otherwise an error...
     *
     * performing global updates:
     * $object = DB_DataObject::factory('mytable');
     * $object->status = "dead";
     * $object->whereAdd('age > 150');
     * $object->update(DB_DATAOBJECT_WHEREADD_ONLY);
     *
     * @param object dataobject (optional) | DB_DATAOBJECT_WHEREADD_ONLY - used to only update changed items.
     * @access public
     * @return  int rows affected or false on failure
     */
    function update($dataObject = false)
    {
        global $_DB_DATAOBJECT;
        // connect will load the config!
        $this->_connect();


        $original_query = isset($this->_query) ? $this->_query : null;

        $items =  isset($_DB_DATAOBJECT['INI'][$this->_database][$this->__table]) ?
            $_DB_DATAOBJECT['INI'][$this->_database][$this->__table] : $this->table();

        // only apply update against sequence key if it is set?????

        $seq = $this->sequenceKey();
        if ($seq[0] !== false) {
            $keys = array($seq[0]);
            if (empty($this->{$keys[0]}) && $dataObject !== true) {
                $this->raiseError("update: trying to perform an update without
                        the key set, and argument to update is not
                        DB_DATAOBJECT_WHEREADD_ONLY
                    ", DB_DATAOBJECT_ERROR_INVALIDARGS);
                return false;
            }
        } else {
            $keys = $this->keys();
        }


        if (!$items) {
            $this->raiseError("update:No table definition for {$this->__table}", DB_DATAOBJECT_ERROR_INVALIDCONFIG);
            return false;
        }
        $datasaved = 1;
        $settings  = '';
        $this->_connect();

        $DB               = &$_DB_DATAOBJECT['CONNECTIONS'][$this->_database_dsn_md5];
        $dbtype           = $DB->dsn["phptype"];
        $quoteIdentifiers = !empty($_DB_DATAOBJECT['CONFIG']['quote_identifiers']);

        foreach($items as $k => $v) {
            if (!isset($this->$k)) {
                continue;
            }
            // ignore stuff thats

            // dont write things that havent changed..
            if (($dataObject !== false) && isset($dataObject->$k) && ($dataObject->$k === $this->$k)) {
                continue;
            }

            // - dont write keys to left.!!!
            if (in_array($k,$keys)) {
                continue;
            }

             // dont insert data into mysql timestamps
            // use query() if you really want to do this!!!!
            if ($v & DB_DATAOBJECT_MYSQLTIMESTAMP) {
                continue;
            }

            if ($settings)  {
                $settings .= ', ';
            }

            $kSql = ($quoteIdentifiers ? $DB->quoteIdentifier($k) : $k);

            if (is_a($this->$k,'DB_DataObject_Cast')) {
                $value = $this->$k->toString($v,$DB);
                if (PEAR::isError($value)) {
                    $this->raiseError($value->getMessage() ,DB_DATAOBJECT_ERROR_INVALIDARG);
                    return false;
                }
                $settings .= "$kSql = $value ";
                continue;
            }

            // special values ... at least null is handled...
            if ((strtolower($this->$k) === 'null') && !($v & DB_DATAOBJECT_NOTNULL)) {
                $settings .= "$kSql = NULL ";
                continue;
            }
            // DATE is empty... on a col. that can be null..
            // note: this may be usefull for time as well..
            if (!$this->$k &&
                    (($v & DB_DATAOBJECT_DATE) || ($v & DB_DATAOBJECT_TIME)) &&
                    !($v & DB_DATAOBJECT_NOTNULL)) {

                $settings .= "$kSql = NULL ";
                continue;
            }

            if ($v & DB_DATAOBJECT_STR) {
                $settings .= "$kSql = ". $this->_quote((string) (
                        ($v & DB_DATAOBJECT_BOOL) ?
                            // this is thanks to the braindead idea of postgres to
                            // use t/f for boolean.
                            (($this->$k === 'f') ? 0 : (int)(bool) $this->$k) :
                            $this->$k
                    )) . ' ';
                continue;
            }

            if (is_numeric($this->$k)) {
                $settings .= "$kSql = {$this->$k} ";
                continue;
            }
            // at present we only cast to integers
            // - V2 may store additional data about float/int
            $settings .= "$kSql = " . intval($this->$k) . ' ';
        }


        if (!empty($_DB_DATAOBJECT['CONFIG']['debug'])) {
            $this->debug("got keys as ".serialize($keys),3);
        }
        if ($dataObject !== true) {
            $this->_build_condition($items,$keys);
        } else {
            // prevent wiping out of data!
            if (empty($this->_query['condition'])) {
                 $this->raiseError("update: global table update not available
                        do \$do->whereAdd('1=1'); if you really want to do that.
                    ", DB_DATAOBJECT_ERROR_INVALIDARGS);
                return false;
            }
        }



        //  echo " $settings, $this->condition ";
        if ($settings && isset($this->_query) && $this->_query['condition']) {

            $table = ($quoteIdentifiers ? $DB->quoteIdentifier($this->__table) : $this->__table);

            $r = $this->_query("UPDATE  {$table}  SET {$settings} {$this->_query['condition']} ");

            // restore original query conditions.
            $this->_query = $original_query;

            if (PEAR::isError($r)) {
                $this->raiseError($r);
                return false;
            }
            if ($r < 1) {
                return 0;
            }

            $this->_clear_cache();
            return $r;
        }
        // restore original query conditions.
        $this->_query = $original_query;

        // if you manually specified a dataobject, and there where no changes - then it's ok..
        if ($dataObject !== false) {
            return true;
        }

        $this->raiseError(
            "update: No Data specifed for query $settings , {$this->_query['condition']}",
            DB_DATAOBJECT_ERROR_NODATA);
        return false;
    }

    /**
     * Deletes items from table which match current objects variables
     *
     * Returns the true on success
     *
     * for example
     *
     * Designed to be extended
     *
     * $object = new mytable();
     * $object->ID=123;
     * echo $object->delete(); // builds a conditon
     *
     * $object = new mytable();
     * $object->whereAdd('age > 12');
     * $object->limit(1);
     * $object->orderBy('age DESC');
     * $object->delete(true); // dont use object vars, use the conditions, limit and order.
     *
     * @param bool $useWhere (optional) If DB_DATAOBJECT_WHEREADD_ONLY is passed in then
     *             we will build the condition only using the whereAdd's.  Default is to
     *             build the condition only using the object parameters.
     *
     * @access public
     * @return mixed True on success, false on failure, 0 on no data affected
     */
    function delete($useWhere = false)
    {
        global $_DB_DATAOBJECT;
        // connect will load the config!
        $this->_connect();
        $DB = &$_DB_DATAOBJECT['CONNECTIONS'][$this->_database_dsn_md5];
        $quoteIdentifiers  = !empty($_DB_DATAOBJECT['CONFIG']['quote_identifiers']);

        $extra_cond = ' ' . (isset($this->_query['order_by']) ? $this->_query['order_by'] : '');

        if (!$useWhere) {

            $keys = $this->keys();
            $this->_query = array(); // as it's probably unset!
            $this->_query['condition'] = ''; // default behaviour not to use where condition
            $this->_build_condition($this->table(),$keys);
            // if primary keys are not set then use data from rest of object.
            if (!$this->_query['condition']) {
                $this->_build_condition($this->table(),array(),$keys);
            }
            $extra_cond = '';
        }


        // don't delete without a condition
        if (isset($this->_query) && $this->_query['condition']) {

            $table = ($quoteIdentifiers ? $DB->quoteIdentifier($this->__table) : $this->__table);
            $sql = "DELETE FROM {$table} {$this->_query['condition']}{$extra_cond}";

            // add limit..

            if (isset($this->_query['limit_start']) && strlen($this->_query['limit_start'] . $this->_query['limit_count'])) {

                if (!isset($_DB_DATAOBJECT['CONFIG']['db_driver']) ||
                    ($_DB_DATAOBJECT['CONFIG']['db_driver'] == 'DB')) {
                    // pear DB
                    $sql = $DB->modifyLimitQuery($sql,$this->_query['limit_start'], $this->_query['limit_count']);

                } else {
                    // MDB2
                    $DB->setLimit( $this->_query['limit_count'],$this->_query['limit_start']);
                }

            }


            $r = $this->_query($sql);


            if (PEAR::isError($r)) {
                $this->raiseError($r);
                return false;
            }
            if ($r < 1) {
                return 0;
            }
            $this->_clear_cache();
            return $r;
        } else {
            $this->raiseError("delete: No condition specifed for query", DB_DATAOBJECT_ERROR_NODATA);
            return false;
        }
    }

    /**
     * fetches a specific row into this object variables
     *
     * Not recommended - better to use fetch()
     *
     * Returens true on success
     *
     * @param  int   $row  row
     * @access public
     * @return boolean true on success
     */
    function fetchRow($row = null)
    {
        global $_DB_DATAOBJECT;
        if (empty($_DB_DATAOBJECT['CONFIG'])) {
            $this->_loadConfig();
        }
        if (!empty($_DB_DATAOBJECT['CONFIG']['debug'])) {
            $this->debug("{$this->__table} $row of {$this->N}", "fetchrow",3);
        }
        if (!$this->__table) {
            $this->raiseError("fetchrow: No table", DB_DATAOBJECT_ERROR_INVALIDCONFIG);
            return false;
        }
        if ($row === null) {
            $this->raiseError("fetchrow: No row specified", DB_DATAOBJECT_ERROR_INVALIDARGS);
            return false;
        }
        if (!$this->N) {
            $this->raiseError("fetchrow: No results avaiable", DB_DATAOBJECT_ERROR_NODATA);
            return false;
        }
        if (!empty($_DB_DATAOBJECT['CONFIG']['debug'])) {
            $this->debug("{$this->__table} $row of {$this->N}", "fetchrow",3);
        }


        $result = &$_DB_DATAOBJECT['RESULTS'][$this->_DB_resultid];
        $array  = $result->fetchrow(DB_DATAOBJECT_FETCHMODE_ASSOC,$row);
        if (!is_array($array)) {
            $this->raiseError("fetchrow: No results available", DB_DATAOBJECT_ERROR_NODATA);
            return false;
        }

        foreach($array as $k => $v) {
            $kk = str_replace(".", "_", $k);
            if (!empty($_DB_DATAOBJECT['CONFIG']['debug'])) {
                $this->debug("$kk = ". $array[$k], "fetchrow LINE", 3);
            }
            $this->$kk = $array[$k];
        }

        if (!empty($_DB_DATAOBJECT['CONFIG']['debug'])) {
            $this->debug("{$this->__table} DONE", "fetchrow", 3);
        }
        return true;
    }

    /**
     * Find the number of results from a simple query
     *
     * for example
     *
     * $object = new mytable();
     * $object->name = "fred";
     * echo $object->count();
     * echo $object->count(true);  // dont use object vars.
     * echo $object->count('distinct mycol');   count distinct mycol.
     * echo $object->count('distinct mycol',true); // dont use object vars.
     * echo $object->count('distinct');      // count distinct id (eg. the primary key)
     *
     *
     * @param bool|string  (optional)
     *                  (true|false => see below not on whereAddonly)
     *                  (string)
     *                      "DISTINCT" => does a distinct count on the tables 'key' column
     *                      otherwise  => normally it counts primary keys - you can use
     *                                    this to do things like $do->count('distinct mycol');
     *
     * @param bool      $whereAddOnly (optional) If DB_DATAOBJECT_WHEREADD_ONLY is passed in then
     *                  we will build the condition only using the whereAdd's.  Default is to
     *                  build the condition using the object parameters as well.
     *
     * @access public
     * @return int
     */
    function count($countWhat = false,$whereAddOnly = false)
    {
        global $_DB_DATAOBJECT;

        if (is_bool($countWhat)) {
            $whereAddOnly = $countWhat;
        }

        $t = clone($this);

        $quoteIdentifiers = !empty($_DB_DATAOBJECT['CONFIG']['quote_identifiers']);

        $items   = $t->table();
        if (!isset($t->_query)) {
            $this->raiseError(
                "You cannot do run count after you have run fetch()",
                DB_DATAOBJECT_ERROR_INVALIDARGS);
            return false;
        }
        $this->_connect();
        $DB = &$_DB_DATAOBJECT['CONNECTIONS'][$this->_database_dsn_md5];


        if (!$whereAddOnly && $items)  {
            $t->_build_condition($items);
        }
        $keys = $this->keys();

        if (!$keys[0] && !is_string($countWhat)) {
            $this->raiseError(
                "You cannot do run count without keys - use \$do->keys('id');",
                DB_DATAOBJECT_ERROR_INVALIDARGS,PEAR_ERROR_DIE);
            return false;

        }
        $table   = ($quoteIdentifiers ? $DB->quoteIdentifier($this->__table) : $this->__table);
        $key_col = ($quoteIdentifiers ? $DB->quoteIdentifier($keys[0]) : $keys[0]);
        $as      = ($quoteIdentifiers ? $DB->quoteIdentifier('DATAOBJECT_NUM') : 'DATAOBJECT_NUM');

        // support distinct on default keys.
        $countWhat = (strtoupper($countWhat) == 'DISTINCT') ?
            "DISTINCT {$table}.{$key_col}" : $countWhat;

        $countWhat = is_string($countWhat) ? $countWhat : "{$table}.{$key_col}";

        $r = $t->_query(
            "SELECT count({$countWhat}) as $as
                FROM $table {$t->_join} {$t->_query['condition']}");
        if (PEAR::isError($r)) {
            return false;
        }

        $result  = &$_DB_DATAOBJECT['RESULTS'][$t->_DB_resultid];
        $l = $result->fetchRow(DB_DATAOBJECT_FETCHMODE_ORDERED);
        // free the results - essential on oracle.
        $t->free();

        return (int) $l[0];
    }

    /**
     * sends raw query to database
     *
     * Since _query has to be a private 'non overwriteable method', this is a relay
     *
     * @param  string  $string  SQL Query
     * @access public
     * @return void or DB_Error
     */
    function query($string)
    {
        return $this->_query($string);
    }


    /**
     * an escape wrapper around DB->escapeSimple()
     * can be used when adding manual queries or clauses
     * eg.
     * $object->query("select * from xyz where abc like '". $object->escape($_GET['name']) . "'");
     *
     * @param  string  $string  value to be escaped
     * @access public
     * @return string
     */
    function escape($string)
    {
        global $_DB_DATAOBJECT;
        $this->_connect();
        $DB = &$_DB_DATAOBJECT['CONNECTIONS'][$this->_database_dsn_md5];
        // mdb2 uses escape...
        $dd = empty($_DB_DATAOBJECT['CONFIG']['db_driver']) ? 'DB' : $_DB_DATAOBJECT['CONFIG']['db_driver'];
        return ($dd == 'DB') ? $DB->escapeSimple($string) : $DB->escape($string);
    }

    /* ==================================================== */
    /*        Major Private Vars                            */
    /* ==================================================== */

    /**
     * The Database connection dsn (as described in the PEAR DB)
     * only used really if you are writing a very simple application/test..
     * try not to use this - it is better stored in configuration files..
     *
     * @access  private
     * @var     string
     */
    var $_database_dsn = '';

    /**
     * The Database connection id (md5 sum of databasedsn)
     *
     * @access  private
     * @var     string
     */
    var $_database_dsn_md5 = '';

    /**
     * The Database name
     * created in __connection
     *
     * @access  private
     * @var  string
     */
    var $_database = '';



    /**
     * The QUERY rules
     * This replaces alot of the private variables
     * used to build a query, it is unset after find() is run.
     *
     *
     *
     * @access  private
     * @var     array
     */
    var $_query = array(
        'condition'   => '', // the WHERE condition
        'group_by'    => '', // the GROUP BY condition
        'order_by'    => '', // the ORDER BY condition
        'having'      => '', // the HAVING condition
        'limit_start' => '', // the LIMIT condition
        'limit_count' => '', // the LIMIT condition
        'data_select' => '*', // the columns to be SELECTed
    );




    /**
     * Database result id (references global $_DB_DataObject[results]
     *
     * @access  private
     * @var     integer
     */
    var $_DB_resultid;

     /**
     * ResultFields - on the last call to fetch(), resultfields is sent here,
     * so we can clean up the memory.
     *
     * @access  public
     * @var     array
     */
    var $_resultFields = false;


    /* ============================================================== */
    /*  Table definition layer (started of very private but 'came out'*/
    /* ============================================================== */

    /**
     * Autoload or manually load the table definitions
     *
     *
     * usage :
     * DB_DataObject::databaseStructure(  'databasename',
     *                                    parse_ini_file('mydb.ini',true),
     *                                    parse_ini_file('mydb.link.ini',true));
     *
     * obviously you dont have to use ini files.. (just return array similar to ini files..)
     *
     * It should append to the table structure array
     *
     *
     * @param optional string  name of database to assign / read
     * @param optional array   structure of database, and keys
     * @param optional array  table links
     *
     * @access public
     * @return true or PEAR:error on wrong paramenters.. or false if no file exists..
     *              or the array(tablename => array(column_name=>type)) if called with 1 argument.. (databasename)
     */
/*    function databaseStructure()
    {

        global $_DB_DATAOBJECT;

        // Assignment code

        if ($args = func_get_args()) {

            if (count($args) == 1) {

                // this returns all the tables and their structure..
                if (!empty($_DB_DATAOBJECT['CONFIG']['debug'])) {
                    $this->debug("Loading Generator as databaseStructure called with args",1);
                }

                $x = new DB_DataObject;
                $x->_database = $args[0];
                $this->_connect();
                $DB = &$_DB_DATAOBJECT['CONNECTIONS'][$this->_database_dsn_md5];

                $tables = $DB->getListOf('tables');
                class_exists('DB_DataObject_Generator') ? '' :
                    require_once 'DB/DataObject/Generator.php';

                foreach($tables as $table) {
                    $y = new DB_DataObject_Generator;
                    $y->fillTableSchema($x->_database,$table);
                }
                return $_DB_DATAOBJECT['INI'][$x->_database];
            } else {

                $_DB_DATAOBJECT['INI'][$args[0]] = isset($_DB_DATAOBJECT['INI'][$args[0]]) ?
                    $_DB_DATAOBJECT['INI'][$args[0]] + $args[1] : $args[1];

                if (isset($args[1])) {
                    $_DB_DATAOBJECT['LINKS'][$args[0]] = isset($_DB_DATAOBJECT['LINKS'][$args[0]]) ?
                        $_DB_DATAOBJECT['LINKS'][$args[0]] + $args[2] : $args[2];
                }
                return true;
            }

        }



        if (!$this->_database) {
            $this->_connect();
        }

        // loaded already?
        if (!empty($_DB_DATAOBJECT['INI'][$this->_database])) {

            // database loaded - but this is table is not available..
            if (
                    empty($_DB_DATAOBJECT['INI'][$this->_database][$this->__table])
                    && !empty($_DB_DATAOBJECT['CONFIG']['proxy'])
                ) {
                if (!empty($_DB_DATAOBJECT['CONFIG']['debug'])) {
                    $this->debug("Loading Generator to fetch Schema",1);
                }
                class_exists('DB_DataObject_Generator') ? '' :
                    require_once 'DB/DataObject/Generator.php';


                $x = new DB_DataObject_Generator;
                $x->fillTableSchema($this->_database,$this->__table);
            }
            return true;
        }


        if (empty($_DB_DATAOBJECT['CONFIG'])) {
            DB_DataObject::_loadConfig();
        }


        $this->getAllSchemas();
        // now have we loaded the structure..

        if (!empty($_DB_DATAOBJECT['INI'][$this->_database][$this->__table])) {
            return true;
        }
        // - if not try building it..
        if (!empty($_DB_DATAOBJECT['CONFIG']['proxy'])) {
            class_exists('DB_DataObject_Generator') ? '' :
                require_once 'DB/DataObject/Generator.php';

            $x = new DB_DataObject_Generator;
            $x->fillTableSchema($this->_database,$this->__table);
            // should this fail!!!???
            return true;
        }
        $this->debug("Cant find database schema: {$this->_database}/{$this->__table} \n".
                    "in links file data: " . print_r($_DB_DATAOBJECT['INI'],true),"databaseStructure",5);
        // we have to die here!! - it causes chaos if we dont (including looping forever!)
        $this->raiseError( "Unable to load schema for database and table (turn debugging up to 5 for full error message)", DB_DATAOBJECT_ERROR_INVALIDARGS, PEAR_ERROR_DIE);
        return false;


    }*/

    /*function getAllSchemas()
    {
        global $_DB_DATAOBJECT;

        // if you supply this with arguments, then it will take those
        // as the database and links array...

        $schemas = isset($_DB_DATAOBJECT['CONFIG']['schema_location']) ?
                        array("{$_DB_DATAOBJECT['CONFIG']['schema_location']}/{$this->_database}.ini") :
                        array();

        if (isset($_DB_DATAOBJECT['CONFIG']["ini_{$this->_database}"])) {
            $schemas = is_array($_DB_DATAOBJECT['CONFIG']["ini_{$this->_database}"]) ?
                $_DB_DATAOBJECT['CONFIG']["ini_{$this->_database}"] :
                explode(PATH_SEPARATOR,$_DB_DATAOBJECT['CONFIG']["ini_{$this->_database}"]);
        }

        if (!is_array($_DB_DATAOBJECT['INI'][$this->_database]))
        {
            $_DB_DATAOBJECT['INI'][$this->_database] = array();
        }

        foreach ($schemas as $ini) {
             if (file_exists($ini) && is_file($ini)) {
                $aIni = parse_ini_file($ini, true);
                $aMerged = array_merge($_DB_DATAOBJECT['INI'][$this->_database], $aIni);
                $_DB_DATAOBJECT['INI'][$this->_database] = $aMerged;
                if (!empty($_DB_DATAOBJECT['CONFIG']['debug'])) {
                    if (!is_readable ($ini)) {
                        $this->debug("ini file is not readable: $ini","databaseStructure",1);
                    } else {
                        $this->debug("Loaded ini file: $ini","databaseStructure",1);
                    }
                }
            } else {
                if (!empty($_DB_DATAOBJECT['CONFIG']['debug'])) {
                    $this->debug("Missing ini file: $ini","databaseStructure",1);
                }
            }

        }
    }*/


    /**
     * Return or assign the name of the current table
     *
     *
     * @param   string optinal table name to set
     * @access public
     * @return string The name of the current table
     */
    function tableName()
    {
        $args = func_get_args();
        if (count($args)) {
            $this->__table = $args[0];
        }
        return $this->__table;
    }

    /**
     * Return or assign the name of the current database
     *
     * @param   string optional database name to set
     * @access public
     * @return string The name of the current database
     */
    function database()
    {
        $args = func_get_args();
        if (count($args)) {
            $this->_database = $args[0];
        }
        return $this->_database;
    }

    /**
     * get/set an associative array of table columns
     *
     * @access public
     * @param  array key=>type array
     * @return array (associative)
     */
    function table()
    {

        // for temporary storage of database fields..
        // note this is not declared as we dont want to bloat the print_r output
        $args = func_get_args();
        if (count($args)) {
            $this->_database_fields = $args[0];
        }
        if (isset($this->_database_fields)) {
            return $this->_database_fields;
        }


        global $_DB_DATAOBJECT;
        if (!isset($_DB_DATAOBJECT['CONNECTIONS'][$this->_database_dsn_md5])) {
            $this->_connect();
        }

        if (isset($_DB_DATAOBJECT['INI'][$this->_database][$this->__table])) {
            return $_DB_DATAOBJECT['INI'][$this->_database][$this->__table];
        }

        $this->databaseStructure();


        $ret = array();
        if (isset($_DB_DATAOBJECT['INI'][$this->_database][$this->__table])) {
            $ret =  $_DB_DATAOBJECT['INI'][$this->_database][$this->__table];
        }

        return $ret;
    }

    /**
     * get/set an  array of table primary keys
     *
     * set usage: $do->keys('id','code');
     *
     * This is defined in the table definition if it gets it wrong,
     * or you do not want to use ini tables, you can override this.
     * @param  string optional set the key
     * @param  *   optional  set more keys
     * @access private
     * @return array
     */
    function keys()
    {
        // for temporary storage of database fields..
        // note this is not declared as we dont want to bloat the print_r output
        $args = func_get_args();
        if (count($args)) {
            $this->_database_keys = $args;
        }
        if (isset($this->_database_keys)) {
            return $this->_database_keys;
        }

        global $_DB_DATAOBJECT;
        if (empty($this->_database_dsn_md5) || !isset($_DB_DATAOBJECT['CONNECTIONS'][$this->_database_dsn_md5])) {
            $this->_connect();
        }
        if (isset($this->__table) && isset($_DB_DATAOBJECT['INI'][$this->_database][$this->__table."__keys"])) {
            return array_keys($_DB_DATAOBJECT['INI'][$this->_database][$this->__table."__keys"]);
        }
        $this->databaseStructure();

        if (isset($this->__table) && isset($_DB_DATAOBJECT['INI'][$this->_database][$this->__table."__keys"])) {
            return array_keys($_DB_DATAOBJECT['INI'][$this->_database][$this->__table."__keys"]);
        }
        return array();
    }
    /**
     * get/set an  sequence key
     *
     * by default it returns the first key from keys()
     * set usage: $do->sequenceKey('id',true);
     *
     * override this to return array(false,false) if table has no real sequence key.
     *
     * @param  string  optional the key sequence/autoinc. key
     * @param  boolean optional use native increment. default false
     * @param  false|string optional native sequence name
     * @access private
     * @return array (column,use_native,sequence_name)
     */
    function sequenceKey()
    {
        global $_DB_DATAOBJECT;

        // call setting
        if (!$this->_database) {
            $this->_connect();
        }

        if (!isset($_DB_DATAOBJECT['SEQUENCE'][$this->_database])) {
            $_DB_DATAOBJECT['SEQUENCE'][$this->_database] = array();
        }


        $args = func_get_args();
        if (count($args)) {
            $args[1] = isset($args[1]) ? $args[1] : false;
            $args[2] = isset($args[2]) ? $args[2] : false;
            $_DB_DATAOBJECT['SEQUENCE'][$this->_database][$this->__table] = $args;
        }
        if (isset($_DB_DATAOBJECT['SEQUENCE'][$this->_database][$this->__table])) {
            return $_DB_DATAOBJECT['SEQUENCE'][$this->_database][$this->__table];
        }
        // end call setting (eg. $do->sequenceKeys(a,b,c); )




        $keys = $this->keys();
        if (!$keys) {
            return $_DB_DATAOBJECT['SEQUENCE'][$this->_database][$this->__table]
                = array(false,false,false);
        }


        $table =  isset($_DB_DATAOBJECT['INI'][$this->_database][$this->__table]) ?
            $_DB_DATAOBJECT['INI'][$this->_database][$this->__table] : $this->table();

        $dbtype    = $_DB_DATAOBJECT['CONNECTIONS'][$this->_database_dsn_md5]->dsn['phptype'];

        $usekey = $keys[0];



        $seqname = false;

        if (!empty($_DB_DATAOBJECT['CONFIG']['sequence_'.$this->__table])) {
            $usekey = $_DB_DATAOBJECT['CONFIG']['sequence_'.$this->__table];
            if (strpos($usekey,':') !== false) {
                list($usekey,$seqname) = explode(':',$usekey);
            }
        }


        // if the key is not an integer - then it's not a sequence or native
        if (empty($table[$usekey]) || !($table[$usekey] & DB_DATAOBJECT_INT)) {
                return $_DB_DATAOBJECT['SEQUENCE'][$this->_database][$this->__table] = array(false,false,false);
        }


        if (!empty($_DB_DATAOBJECT['CONFIG']['ignore_sequence_keys'])) {
            $ignore =  $_DB_DATAOBJECT['CONFIG']['ignore_sequence_keys'];
            if (is_string($ignore) && (strtoupper($ignore) == 'ALL')) {
                return $_DB_DATAOBJECT['SEQUENCE'][$this->_database][$this->__table] = array(false,false,$seqname);
            }
            if (is_string($ignore)) {
                $ignore = $_DB_DATAOBJECT['CONFIG']['ignore_sequence_keys'] = explode(',',$ignore);
            }
            if (in_array($this->__table,$ignore)) {
                return $_DB_DATAOBJECT['SEQUENCE'][$this->_database][$this->__table] = array(false,false,$seqname);
            }
        }


        $realkeys = $_DB_DATAOBJECT['INI'][$this->_database][$this->__table."__keys"];

        // if you are using an old ini file - go back to old behaviour...
        if (is_numeric($realkeys[$usekey])) {
            $realkeys[$usekey] = 'N';
        }

        // multiple unique primary keys without a native sequence...
        if (($realkeys[$usekey] == 'K') && (count($keys) > 1)) {
            return $_DB_DATAOBJECT['SEQUENCE'][$this->_database][$this->__table] = array(false,false,$seqname);
        }
        // use native sequence keys...
        // technically postgres native here...
        // we need to get the new improved tabledata sorted out first.

        if (    in_array($dbtype , array( 'mysql', 'mysqli', 'mssql', 'ifx')) &&
                ($table[$usekey] & DB_DATAOBJECT_INT) &&
                isset($realkeys[$usekey]) && ($realkeys[$usekey] == 'N')
                ) {
            return $_DB_DATAOBJECT['SEQUENCE'][$this->_database][$this->__table] = array($usekey,true,$seqname);
        }
        // if not a native autoinc, and we have not assumed all primary keys are sequence
        if (($realkeys[$usekey] != 'N') &&
            !empty($_DB_DATAOBJECT['CONFIG']['dont_use_pear_sequences'])) {
            return array(false,false,false);
        }
        // I assume it's going to try and be a nextval DB sequence.. (not native)
        return $_DB_DATAOBJECT['SEQUENCE'][$this->_database][$this->__table] = array($usekey,false,$seqname);
    }



    /* =========================================================== */
    /*  Major Private Methods - the core part!              */
    /* =========================================================== */



    /**
     * clear the cache values for this class  - normally done on insert/update etc.
     *
     * @access private
     * @return void
     */
    function _clear_cache()
    {
        global $_DB_DATAOBJECT;

        $class = strtolower(get_class($this));

        if (!empty($_DB_DATAOBJECT['CONFIG']['debug'])) {
            $this->debug("Clearing Cache for ".$class,1);
        }

        if (!empty($_DB_DATAOBJECT['CACHE'][$class])) {
            unset($_DB_DATAOBJECT['CACHE'][$class]);
        }
    }


    /**
     * backend wrapper for quoting, as MDB2 and DB do it differently...
     *
     * @access private
     * @return string quoted
     */

    function _quote($str)
    {
        global $_DB_DATAOBJECT;
        return (empty($_DB_DATAOBJECT['CONFIG']['db_driver']) ||
                ($_DB_DATAOBJECT['CONFIG']['db_driver'] == 'DB'))
            ? $_DB_DATAOBJECT['CONNECTIONS'][$this->_database_dsn_md5]->quoteSmart($str)
            : $_DB_DATAOBJECT['CONNECTIONS'][$this->_database_dsn_md5]->quote($str);
    }


    /**
     * connects to the database
     *
     *
     * TODO: tidy this up - This has grown to support a number of connection options like
     *  a) dynamic changing of ini file to change which database to connect to
     *  b) multi data via the table_{$table} = dsn ini option
     *  c) session based storage.
     *
     * @access private
     * @return true | PEAR::error
     */
    function _connect()
    {
        global $_DB_DATAOBJECT;
        if (empty($_DB_DATAOBJECT['CONFIG'])) {
            $this->_loadConfig();
        }
        // Set database driver for reference
        $db_driver = empty($_DB_DATAOBJECT['CONFIG']['db_driver']) ? 'DB' : $_DB_DATAOBJECT['CONFIG']['db_driver'];
        // is it already connected ?

        if ($this->_database_dsn_md5 && !empty($_DB_DATAOBJECT['CONNECTIONS'][$this->_database_dsn_md5])) {
            if (PEAR::isError($_DB_DATAOBJECT['CONNECTIONS'][$this->_database_dsn_md5])) {
                return $this->raiseError(
                        $_DB_DATAOBJECT['CONNECTIONS'][$this->_database_dsn_md5]->message,
                        $_DB_DATAOBJECT['CONNECTIONS'][$this->_database_dsn_md5]->code, PEAR_ERROR_DIE
                );

            }

            if (!$this->_database) {
                $this->_database = $_DB_DATAOBJECT['CONNECTIONS'][$this->_database_dsn_md5]->dsn['database'];
                $hasGetDatabase = method_exists($_DB_DATAOBJECT['CONNECTIONS'][$this->_database_dsn_md5], 'getDatabase');

                $this->_database = ($db_driver != 'DB' && $hasGetDatabase)
                        ? $_DB_DATAOBJECT['CONNECTIONS'][$this->_database_dsn_md5]->getDatabase()
                        : $_DB_DATAOBJECT['CONNECTIONS'][$this->_database_dsn_md5]->dsn['database'];



                if (($_DB_DATAOBJECT['CONNECTIONS'][$this->_database_dsn_md5]->dsn['phptype'] == 'sqlite')
                    && is_file($this->_database))  {
                    $this->_database = basename($this->_database);
                }
                if ($_DB_DATAOBJECT['CONNECTIONS'][$this->_database_dsn_md5]->dsn['phptype'] == 'ibase')  {
                    $this->_database = substr(basename($this->_database), 0, -4);
                }

            }
            // theoretically we have a md5, it's listed in connections and it's not an error.
            // so everything is ok!
            return true;

        }

        // it's not currently connected!
        // try and work out what to use for the dsn !

        $options= &$_DB_DATAOBJECT['CONFIG'];
        $dsn = isset($this->_database_dsn) ? $this->_database_dsn : null;

        if (!$dsn) {
            if (!$this->_database) {
                $this->_database = isset($options["table_{$this->__table}"]) ? $options["table_{$this->__table}"] : null;
            }
            if (!empty($_DB_DATAOBJECT['CONFIG']['debug'])) {
                $this->debug("Checking for database database_{$this->_database} in options","CONNECT");
            }

            if ($this->_database && !empty($options["database_{$this->_database}"]))  {

                $dsn = $options["database_{$this->_database}"];
            } else if (!empty($options['database'])) {
                $dsn = $options['database'];
            }
        }

        // if still no database...
        if (!$dsn) {
            return $this->raiseError(
                "No database name / dsn found anywhere",
                DB_DATAOBJECT_ERROR_INVALIDCONFIG, PEAR_ERROR_DIE
            );

        }


        if (is_string($dsn)) {
            $this->_database_dsn_md5 = md5($dsn);
        } else {
            /// support array based dsn's
            $this->_database_dsn_md5 = md5(serialize($dsn));
        }

        if (!empty($_DB_DATAOBJECT['CONNECTIONS'][$this->_database_dsn_md5])) {
            if (!empty($_DB_DATAOBJECT['CONFIG']['debug'])) {
                $this->debug("USING CACHED CONNECTION", "CONNECT",3);
            }
            if (!$this->_database) {

                $hasGetDatabase = method_exists($_DB_DATAOBJECT['CONNECTIONS'][$this->_database_dsn_md5], 'getDatabase');
                $this->_database = ($db_driver != 'DB' && $hasGetDatabase)
                        ? $_DB_DATAOBJECT['CONNECTIONS'][$this->_database_dsn_md5]->getDatabase()
                        : $_DB_DATAOBJECT['CONNECTIONS'][$this->_database_dsn_md5]->dsn['database'];

                if (($_DB_DATAOBJECT['CONNECTIONS'][$this->_database_dsn_md5]->dsn['phptype'] == 'sqlite')
                    && is_file($this->_database))
                {
                    $this->_database = basename($this->_database);
                }
            }
            return true;
        }
        if (!empty($_DB_DATAOBJECT['CONFIG']['debug'])) {
            $this->debug("NEW CONNECTION", "CONNECT",3);
            /* actualy make a connection */
            $this->debug(print_r($dsn,true) ." {$this->_database_dsn_md5}", "CONNECT",3);
        }

        // Note this is verbose deliberatly!

        if ($db_driver == 'DB') {

            /* PEAR DB connect */

            // this allows the setings of compatibility on DB
            $db_options = PEAR::getStaticProperty('DB','options');
            require_once 'DB.php';
            if ($db_options) {
                $_DB_DATAOBJECT['CONNECTIONS'][$this->_database_dsn_md5] = DB::connect($dsn,$db_options);
            } else {
                $_DB_DATAOBJECT['CONNECTIONS'][$this->_database_dsn_md5] = DB::connect($dsn);
            }

        } else {
            /* assumption is MDB2 */
            require_once 'MDB2.php';
            // this allows the setings of compatibility on MDB2
            $db_options = PEAR::getStaticProperty('MDB2','options');
            $_DB_DATAOBJECT['CONNECTIONS'][$this->_database_dsn_md5] = MDB2::connect($dsn,$db_options);

        }


        if (!empty($_DB_DATAOBJECT['CONFIG']['debug'])) {
            $this->debug(serialize($_DB_DATAOBJECT['CONNECTIONS']), "CONNECT",5);
        }
        if (PEAR::isError($_DB_DATAOBJECT['CONNECTIONS'][$this->_database_dsn_md5])) {
            $this->debug($_DB_DATAOBJECT['CONNECTIONS'][$this->_database_dsn_md5]->toString(), "CONNECT FAILED",5);
            return $this->raiseError(
                    "Connect failed, turn on debugging to 5 see why",
                        $_DB_DATAOBJECT['CONNECTIONS'][$this->_database_dsn_md5]->code, PEAR_ERROR_DIE
            );

        }

        if (!$this->_database) {
            $hasGetDatabase = method_exists($_DB_DATAOBJECT['CONNECTIONS'][$this->_database_dsn_md5], 'getDatabase');

            $this->_database = ($db_driver != 'DB' && $hasGetDatabase)
                    ? $_DB_DATAOBJECT['CONNECTIONS'][$this->_database_dsn_md5]->getDatabase()
                    : $_DB_DATAOBJECT['CONNECTIONS'][$this->_database_dsn_md5]->dsn['database'];


            if (($_DB_DATAOBJECT['CONNECTIONS'][$this->_database_dsn_md5]->dsn['phptype'] == 'sqlite')
                && is_file($this->_database))
            {
                $this->_database = basename($this->_database);
            }
        }

        // Oracle need to optimize for portibility - not sure exactly what this does though :)
        $c = &$_DB_DATAOBJECT['CONNECTIONS'][$this->_database_dsn_md5];

        return true;
    }

    /**
     * sends query to database - this is the private one that must work
     *   - internal functions use this rather than $this->query()
     *
     * @param  string  $string
     * @access private
     * @return mixed none or PEAR_Error
     */
    function _query($string)
    {
        global $_DB_DATAOBJECT;
        $this->_connect();


        $DB = &$_DB_DATAOBJECT['CONNECTIONS'][$this->_database_dsn_md5];

        $options = &$_DB_DATAOBJECT['CONFIG'];

        $_DB_driver = empty($_DB_DATAOBJECT['CONFIG']['db_driver']) ?
                    'DB':  $_DB_DATAOBJECT['CONFIG']['db_driver'];

        if (!empty($_DB_DATAOBJECT['CONFIG']['debug'])) {
            $this->debug($string,$log="QUERY");

        }

        if (strtoupper($string) == 'BEGIN') {
            if ($_DB_driver == 'DB') {
                $DB->autoCommit(false);
            } else {
                $DB->beginTransaction();
            }
            // db backend adds begin anyway from now on..
            return true;
        }
        if (strtoupper($string) == 'COMMIT') {
            $res = $DB->commit();
            if ($_DB_driver == 'DB') {
                $DB->autoCommit(true);
            }
            return $res;
        }

        if (strtoupper($string) == 'ROLLBACK') {
            $DB->rollback();
            if ($_DB_driver == 'DB') {
                $DB->autoCommit(true);
            }
            return true;
        }


        if (!empty($options['debug_ignore_updates']) &&
            (strtolower(substr(trim($string), 0, 6)) != 'select') &&
            (strtolower(substr(trim($string), 0, 4)) != 'show') &&
            (strtolower(substr(trim($string), 0, 8)) != 'describe')) {

            $this->debug('Disabling Update as you are in debug mode');
            return $this->raiseError("Disabling Update as you are in debug mode", null) ;

        }
        //if (@$_DB_DATAOBJECT['CONFIG']['debug'] > 1) {
            // this will only work when PEAR:DB supports it.
            //$this->debug($DB->getAll('explain ' .$string,DB_DATAOBJECT_FETCHMODE_ASSOC), $log="sql",2);
        //}

        // some sim
        $t= explode(' ',microtime());
        $_DB_DATAOBJECT['QUERYENDTIME'] = $time = $t[0]+$t[1];


        if ($_DB_driver == 'DB') {
            $result = $DB->query($string);
        } else {
            switch (strtolower(substr(trim($string),0,6))) {

                case 'insert':
                case 'update':
                case 'delete':
                    $result = $DB->exec($string);
                    break;

                default:
                    $result = $DB->query($string);
                    break;
            }
        }



        if (is_a($result,'PEAR_Error')) {
            if (!empty($_DB_DATAOBJECT['CONFIG']['debug'])) {
                $this->debug($result->toString(), "Query Error",1 );
            }
            return $this->raiseError($result);
        }
        if (!empty($_DB_DATAOBJECT['CONFIG']['debug'])) {
            $t= explode(' ',microtime());
            $_DB_DATAOBJECT['QUERYENDTIME'] = $t[0]+$t[1];
            $this->debug('QUERY DONE IN  '.($t[0]+$t[1]-$time)." seconds", 'query',1);
        }
        switch (strtolower(substr(trim($string),0,6))) {
            case 'insert':
            case 'update':
            case 'delete':
                if ($_DB_driver == 'DB') {
                    // pear DB specific
                    return $DB->affectedRows();
                }
                return $result;
        }
        if (is_object($result)) {
            // lets hope that copying the result object is OK!

            $_DB_resultid  = $GLOBALS['_DB_DATAOBJECT']['RESULTSEQ']++;
            $_DB_DATAOBJECT['RESULTS'][$_DB_resultid] = $result;
            $this->_DB_resultid = $_DB_resultid;
        }
        $this->N = 0;
        if (!empty($_DB_DATAOBJECT['CONFIG']['debug'])) {
            $this->debug(serialize($result), 'RESULT',5);
        }
        if (method_exists($result, 'numrows')) {
            if ($_DB_driver == 'DB') {
                $DB->expectError(DB_ERROR_UNSUPPORTED);
            } else {
                $DB->expectError(MDB2_ERROR_UNSUPPORTED);
            }
            $this->N = $result->numrows();
            if (is_a($this->N,'PEAR_Error')) {
                $this->N = true;
            }
            $DB->popExpect();
        }
    }

    /**
     * Builds the WHERE based on the values of of this object
     *
     * @param   mixed   $keys
     * @param   array   $filter (used by update to only uses keys in this filter list).
     * @param   array   $negative_filter (used by delete to prevent deleting using the keys mentioned..)
     * @access  private
     * @return  string
     */
    function _build_condition($keys, $filter = array(),$negative_filter=array())
    {
        global $_DB_DATAOBJECT;
        $this->_connect();
        $DB = &$_DB_DATAOBJECT['CONNECTIONS'][$this->_database_dsn_md5];

        $quoteIdentifiers  = !empty($_DB_DATAOBJECT['CONFIG']['quote_identifiers']);
        // if we dont have query vars.. - reset them.
        if (!isset($this->_query)) {
            $x = new DB_DataObject;
            $this->_query= $x->_query;
        }

        foreach($keys as $k => $v) {
            // index keys is an indexed array
            /* these filter checks are a bit suspicious..
                - need to check that update really wants to work this way */

            if ($filter) {
                if (!in_array($k, $filter)) {
                    continue;
                }
            }
            if ($negative_filter) {
                if (in_array($k, $negative_filter)) {
                    continue;
                }
            }
            if (!isset($this->$k)) {
                continue;
            }

            $kSql = $quoteIdentifiers
                ? ( $DB->quoteIdentifier($this->__table) . '.' . $DB->quoteIdentifier($k) )
                : "{$this->__table}.{$k}";



            if (is_a($this->$k,'DB_DataObject_Cast')) {
                $dbtype = $DB->dsn["phptype"];
                $value = $this->$k->toString($v,$DB);
                if (PEAR::isError($value)) {
                    $this->raiseError($value->getMessage() ,DB_DATAOBJECT_ERROR_INVALIDARG);
                    return false;
                }
                if ((strtolower($value) === 'null') && !($v & DB_DATAOBJECT_NOTNULL)) {
                    $this->whereAdd(" $kSql IS NULL");
                    continue;
                }
                $this->whereAdd(" $kSql = $value");
                continue;
            }

            if ((strtolower($this->$k) === 'null') && !($v & DB_DATAOBJECT_NOTNULL)) {
                $this->whereAdd(" $kSql  IS NULL");
                continue;
            }


            if ($v & DB_DATAOBJECT_STR) {
                $this->whereAdd(" $kSql  = " . $this->_quote((string) (
                        ($v & DB_DATAOBJECT_BOOL) ?
                            // this is thanks to the braindead idea of postgres to
                            // use t/f for boolean.
                            (($this->$k === 'f') ? 0 : (int)(bool) $this->$k) :
                            $this->$k
                    )) );
                continue;
            }
            if (is_numeric($this->$k)) {
                $this->whereAdd(" $kSql = {$this->$k}");
                continue;
            }
            /* this is probably an error condition! */
            $this->whereAdd(" $kSql = ".intval($this->$k));
        }
    }

    /**
     * autoload Class relating to a table
     * (depreciated - use ::factory)
     *
     * @param  string  $table  table
     * @access private
     * @return string classname on Success
     */
    function staticAutoloadTable($table)
    {
        global $_DB_DATAOBJECT;
        if (empty($_DB_DATAOBJECT['CONFIG'])) {
            self::_loadConfig();
        }
        $p = isset($_DB_DATAOBJECT['CONFIG']['class_prefix']) ?
            $_DB_DATAOBJECT['CONFIG']['class_prefix'] : '';
        $class = $p . preg_replace('/[^A-Z0-9]/i','_',ucfirst($table));

        $ce = substr(phpversion(),0,1) > 4 ? class_exists($class,false) : class_exists($class);
        $class = $ce ? $class  : self::_autoloadClass($class);
        return $class;
    }


     /**
     * classic factory method for loading a table class
     * usage: $do = DB_DataObject::factory('person')
     * WARNING - this may emit a include error if the file does not exist..
     * use @ to silence it (if you are sure it is acceptable)
     * eg. $do = @DB_DataObject::factory('person')
     *
     * table name will eventually be databasename/table
     * - and allow modular dataobjects to be written..
     * (this also helps proxy creation)
     *
     *
     * @param  string  $table  tablename
     * @access private
     * @return self|PEAR_Error
     */
    public static function factory($table) {
        global $_DB_DATAOBJECT;

        if (empty($_DB_DATAOBJECT['CONFIG'])) {
            DB_DataObject::_loadConfig();
        }

        $p = isset($_DB_DATAOBJECT['CONFIG']['class_prefix']) ?
            $_DB_DATAOBJECT['CONFIG']['class_prefix'] : '';
        $class = $p . preg_replace('/[^A-Z0-9]/i','_',ucfirst($table));

        $ce = substr(phpversion(),0,1) > 4 ? class_exists($class,false) : class_exists($class);
        $class = $ce ? $class  : self::_autoloadClass($class);

        // proxy = full|light
        if (!$class && isset($_DB_DATAOBJECT['CONFIG']['proxy'])) {
            $proxyMethod = 'getProxy'.$_DB_DATAOBJECT['CONFIG']['proxy'];
            class_exists('DB_DataObject_Generator') ? '' :
                    require_once 'DB/DataObject/Generator.php';

            $d = new DB_DataObject;

            $d->__table = $table;
            if (is_a($ret = $d->_connect(), 'PEAR_Error')) {
                return $ret;
            }

            $x = new DB_DataObject_Generator;
            return $x->$proxyMethod( $d->_database, $table);
        }

        if (!$class) {
            return DB_DataObject::raiseError(
                "factory could not find class $class from $table",
                DB_DATAOBJECT_ERROR_INVALIDCONFIG);
        }

        return new $class;
    }
    /**
     * autoload Class
     *
     * @param  string  $class  Class
     * @access private
     * @return string classname on Success
     */
    private static function _autoloadClass($class)
    {
        global $_DB_DATAOBJECT;

        if (empty($_DB_DATAOBJECT['CONFIG'])) {
            DB_DataObject::_loadConfig();
        }
        $class_prefix = empty($_DB_DATAOBJECT['CONFIG']['class_prefix']) ?
                '' : $_DB_DATAOBJECT['CONFIG']['class_prefix'];

        $table   = substr($class,strlen($class_prefix));

        // only include the file if it exists - and barf badly if it has parse errors :)
        if (!empty($_DB_DATAOBJECT['CONFIG']['proxy']) || empty($_DB_DATAOBJECT['CONFIG']['class_location'])) {
            return false;
        }

        // CHANGED FOR PLUGINS
        // array of plugin class locations
        // see DAL _setupDataObjectOptions
        if (!is_array($_DB_DATAOBJECT['CONFIG']['class_location']))
        {
            $location = $_DB_DATAOBJECT['CONFIG']['class_location'];
            $file = DB_DataObject::findTableFile($location, $table);
        }
        else
        {
            foreach ($_DB_DATAOBJECT['CONFIG']['class_location'] as $k => $location)
            {
                $file = DB_DataObject::findTableFile($location, $table);
                if ($file)
                {
                    break;
                }
            }
        }
        if (!$file) {
            DB_DataObject::raiseError(
                "autoload:Could not find class {$class} using class_location value",
                DB_DATAOBJECT_ERROR_INVALIDCONFIG);
            return false;
        }

        include_once $file;

        $ce = substr(phpversion(),0,1) > 4 ? class_exists($class,false) : class_exists($class);

        if (!$ce) {
            DB_DataObject::raiseError(
                "autoload:Could not autoload {$class}",
                DB_DATAOBJECT_ERROR_INVALIDCONFIG);
            return false;
        }
        return $class;
    }

    // NEW METHOD FOR PLUGINS
    public static function findTableFile($location, $table)
    {
        if (strpos($location,'%s') !== false)
        {
            $file = sprintf($location, preg_replace('/[^A-Z0-9]/i','_',ucfirst($table)));
        }
        else
        {
            $file = $location.'/'.preg_replace('/[^A-Z0-9]/i','_',ucfirst($table)).".php";
        }
        if (file_exists($file))
        {
            return $file;
        }
        else
        {
            foreach(explode(PATH_SEPARATOR, ini_get('include_path')) as $p)
            {
                if (file_exists("$p/$file"))
                {
                    $file = "$p/$file";
                    return $file;
                }
            }
        }
        return false;
    }



    /**
     * Have the links been loaded?
     * if they have it contains a array of those variables.
     *
     * @access  private
     * @var     boolean | array
     */
    var $_link_loaded = false;

    /**
    * Get the links associate array  as defined by the links.ini file.
    *
    *
    * Experimental... -
    * Should look a bit like
    *       [local_col_name] => "related_tablename:related_col_name"
    *
    *
    * @return   array|null
    *           array       = if there are links defined for this table.
    *           empty array - if there is a links.ini file, but no links on this table
    *           null        - if no links.ini exists for this database (hence try auto_links).
    * @access   public
    * @see      DB_DataObject::getLinks(), DB_DataObject::getLink()
    */

    function links()
    {
        global $_DB_DATAOBJECT;
        if (empty($_DB_DATAOBJECT['CONFIG'])) {
            $this->_loadConfig();
        }
        // have to connect.. -> otherwise things break later.
        $this->_connect();

        if (isset($_DB_DATAOBJECT['LINKS'][$this->_database][$this->__table])) {
            return $_DB_DATAOBJECT['LINKS'][$this->_database][$this->__table];
        }





        // attempt to load links file here..

        if (!isset($_DB_DATAOBJECT['LINKS'][$this->_database])) {
            $schemas = isset($_DB_DATAOBJECT['CONFIG']['schema_location']) ?
                array("{$_DB_DATAOBJECT['CONFIG']['schema_location']}/{$this->_database}.ini") :
                array() ;

            if (isset($_DB_DATAOBJECT['CONFIG']["ini_{$this->_database}"])) {
                $schemas = is_array($_DB_DATAOBJECT['CONFIG']["ini_{$this->_database}"]) ?
                    $_DB_DATAOBJECT['CONFIG']["ini_{$this->_database}"] :
                    explode(PATH_SEPARATOR,$_DB_DATAOBJECT['CONFIG']["ini_{$this->_database}"]);
            }



            foreach ($schemas as $ini) {

                $links =
                    isset($_DB_DATAOBJECT['CONFIG']["links_{$this->_database}"]) ?
                        $_DB_DATAOBJECT['CONFIG']["links_{$this->_database}"] :
                        str_replace('.ini','.links.ini',$ini);

                if (empty($_DB_DATAOBJECT['LINKS'][$this->_database]) && file_exists($links) && is_file($links)) {
                    /* not sure why $links = ... here  - TODO check if that works */
                    $_DB_DATAOBJECT['LINKS'][$this->_database] = parse_ini_file($links, true);
                    if (!empty($_DB_DATAOBJECT['CONFIG']['debug'])) {
                        $this->debug("Loaded links.ini file: $links","links",1);
                    }
                } else {
                    if (!empty($_DB_DATAOBJECT['CONFIG']['debug'])) {
                        $this->debug("Missing links.ini file: $links","links",1);
                    }
                }
            }
        }


        // if there is no link data at all on the file!
        // we return null.
        if (!isset($_DB_DATAOBJECT['LINKS'][$this->_database])) {
            return null;
        }

        if (isset($_DB_DATAOBJECT['LINKS'][$this->_database][$this->__table])) {
            return $_DB_DATAOBJECT['LINKS'][$this->_database][$this->__table];
        }

        return array();
    }
    /**
     * load related objects
     *
     * There are two ways to use this, one is to set up a <dbname>.links.ini file
     * into a static property named <dbname>.links and specifies the table joins,
     * the other highly dependent on naming columns 'correctly' :)
     * using colname = xxxxx_yyyyyy
     * xxxxxx = related table; (yyyyy = user defined..)
     * looks up table xxxxx, for value id=$this->xxxxx
     * stores it in $this->_xxxxx_yyyyy
     * you can change what object vars the links are stored in by
     * changeing the format parameter
     *
     *
     * @param  string format (default _%s) where %s is the table name.
     * @author Tim White <tim@cyface.com>
     * @access public
     * @return boolean , true on success
     */
    function getLinks($format = '_%s')
    {

        // get table will load the options.
        if ($this->_link_loaded) {
            return true;
        }
        $this->_link_loaded = false;
        $cols  = $this->table();
        $links = $this->links();

        $loaded = array();

        if ($links) {
            foreach($links as $key => $match) {
                list($table,$link) = explode(':', $match);
                $k = sprintf($format, str_replace('.', '_', $key));
                // makes sure that '.' is the end of the key;
                if ($p = strpos($key,'.')) {
                      $key = substr($key, 0, $p);
                }

                $this->$k = $this->getLink($key, $table, $link);

                if (is_object($this->$k)) {
                    $loaded[] = $k;
                }
            }
            $this->_link_loaded = $loaded;
            return true;
        }
        // this is the autonaming stuff..
        // it sends the column name down to getLink and lets that sort it out..
        // if there is a links file then it is not used!
        // IT IS DEPRECIATED!!!! - USE
        if (!is_null($links)) {
            return false;
        }


        foreach (array_keys($cols) as $key) {
            if (!($p = strpos($key, '_'))) {
                continue;
            }
            // does the table exist.
            $k =sprintf($format, $key);
            $this->$k = $this->getLink($key);
            if (is_object($this->$k)) {
                $loaded[] = $k;
            }
        }
        $this->_link_loaded = $loaded;
        return true;
    }

    /**
     * return name from related object
     *
     * There are two ways to use this, one is to set up a <dbname>.links.ini file
     * into a static property named <dbname>.links and specifies the table joins,
     * the other is highly dependant on naming columns 'correctly' :)
     *
     * NOTE: the naming convention is depreciated!!! - use links.ini
     *
     * using colname = xxxxx_yyyyyy
     * xxxxxx = related table; (yyyyy = user defined..)
     * looks up table xxxxx, for value id=$this->xxxxx
     * stores it in $this->_xxxxx_yyyyy
     *
     * you can also use $this->getLink('thisColumnName','otherTable','otherTableColumnName')
     *
     *
     * @param string $row    either row or row.xxxxx
     * @param string $table  name of table to look up value in
     * @param string $link   name of column in other table to match
     * @author Tim White <tim@cyface.com>
     * @access public
     * @return mixed object on success
     */
    function getLink($row, $table = null, $link = false)
    {


        // GUESS THE LINKED TABLE.. (if found - recursevly call self)

        if ($table === null) {
            $links = $this->links();

            if (is_array($links)) {

                if ($links[$row]) {
                    list($table,$link) = explode(':', $links[$row]);
                    if ($p = strpos($row,".")) {
                        $row = substr($row,0,$p);
                    }
                    return $this->getLink($row,$table,$link);

                }

                $this->raiseError(
                    "getLink: $row is not defined as a link (normally this is ok)",
                    DB_DATAOBJECT_ERROR_NODATA);

                $r = false;
                return $r;// technically a possible error condition?

            }
            // use the old _ method - this shouldnt happen if called via getLinks()
            if (!($p = strpos($row, '_'))) {
                $r = null;
                return $r;
            }
            $table = substr($row, 0, $p);
            return $this->getLink($row, $table);


        }



        if (!isset($this->$row)) {
            $this->raiseError("getLink: row not set $row", DB_DATAOBJECT_ERROR_NODATA);
            return false;
        }

        // check to see if we know anything about this table..

        $obj = $this->factory($table);

        if (!is_a($obj,'DB_DataObject')) {
            $this->raiseError(
                "getLink:Could not find class for row $row, table $table",
                DB_DATAOBJECT_ERROR_INVALIDCONFIG);
            return false;
        }
        if ($link) {
            if ($obj->get($link, $this->$row)) {
                $obj->free();
                return $obj;
            }
            return  false;
        }

        if ($obj->get($this->$row)) {
            $obj->free();
            return $obj;
        }
        return false;

    }

    /**
     * IS THIS SUPPORTED/USED ANYMORE????
     *return a list of options for a linked table
     *
     * This is highly dependant on naming columns 'correctly' :)
     * using colname = xxxxx_yyyyyy
     * xxxxxx = related table; (yyyyy = user defined..)
     * looks up table xxxxx, for value id=$this->xxxxx
     * stores it in $this->_xxxxx_yyyyy
     *
     * @access public
     * @return array of results (empty array on failure)
     */
    function &getLinkArray($row, $table = null)
    {

        $ret = array();
        if (!$table) {
            $links = $this->links();

            if (is_array($links)) {
                if (!isset($links[$row])) {
                    // failed..
                    return $ret;
                }
                list($table,$link) = explode(':',$links[$row]);
            } else {
                if (!($p = strpos($row,'_'))) {
                    return $ret;
                }
                $table = substr($row,0,$p);
            }
        }

        $c  = $this->factory($table);

        if (!is_a($c,'DB_DataObject')) {
            $this->raiseError(
                "getLinkArray:Could not find class for row $row, table $table",
                DB_DATAOBJECT_ERROR_INVALIDCONFIG
            );
            return $ret;
        }

        // if the user defined method list exists - use it...
        if (method_exists($c, 'listFind')) {
            $c->listFind($this->id);
        } else {
            $c->find();
        }
        while ($c->fetch()) {
            $ret[] = $c;
        }
        return $ret;
    }

    /**
     * The JOIN condition
     *
     * @access  private
     * @var     string
     */
    var $_join = '';

    /**
     * joinAdd - adds another dataobject to this, building a joined query.
     *
     * example (requires links.ini to be set up correctly)
     * // get all the images for product 24
     * $i = new DataObject_Image();
     * $pi = new DataObjects_Product_image();
     * $pi->product_id = 24; // set the product id to 24
     * $i->joinAdd($pi); // add the product_image connectoin
     * $i->find();
     * while ($i->fetch()) {
     *     // do stuff
     * }
     * // an example with 2 joins
     * // get all the images linked with products or productgroups
     * $i = new DataObject_Image();
     * $pi = new DataObject_Product_image();
     * $pgi = new DataObject_Productgroup_image();
     * $i->joinAdd($pi);
     * $i->joinAdd($pgi);
     * $i->find();
     * while ($i->fetch()) {
     *     // do stuff
     * }
     *
     *
     * @param    optional $obj       object |array    the joining object (no value resets the join)
     *                                          If you use an array here it should be in the format:
     *                                          array('local_column','remotetable:remote_column');
     *                                          if remotetable does not have a definition, you should
     *                                          use @ to hide the include error message..
     *
     *
     * @param    optional $joinType  string     'LEFT'|'INNER'|'RIGHT'|'' Inner is default, '' indicates
     *                                          just select ... from a,b,c with no join and
     *                                          links are added as where items.
     *
     * @param    optional $joinAs    string     if you want to select the table as anther name
     *                                          useful when you want to select multiple columsn
     *                                          from a secondary table.

     * @param    optional $joinCol   string     The column on This objects table to match (needed
     *                                          if this table links to the child object in
     *                                          multiple places eg.
     *                                          user->friend (is a link to another user)
     *                                          user->mother (is a link to another user..)
     *
     * @return   none
     * @access   public
     * @author   Stijn de Reede      <sjr@gmx.co.uk>
     */
    function joinAdd($obj = false, $joinType='INNER', $joinAs=false, $joinCol=false)
    {
        global $_DB_DATAOBJECT;
        if ($obj === false) {
            $this->_join = '';
            return;
        }

        // support for array as first argument
        // this assumes that you dont have a links.ini for the specified table.
        // and it doesnt exist as am extended dataobject!! - experimental.

        $ofield = false; // object field
        $tfield = false; // this field
        $toTable = false;
        if (is_array($obj)) {
            $tfield = $obj[0];
            list($toTable,$ofield) = explode(':',$obj[1]);
            $obj = DB_DataObject::factory($toTable);

            if (!$obj || is_a($obj,'PEAR_Error')) {
                $obj = new DB_DataObject;
                $obj->__table = $toTable;
            }
            $obj->_connect();
            // set the table items to nothing.. - eg. do not try and match
            // things in the child table...???
            $items = array();
        }

        if (!is_object($obj) || !is_a($obj,'DB_DataObject')) {
            return $this->raiseError("joinAdd: called without an object", DB_DATAOBJECT_ERROR_NODATA,PEAR_ERROR_DIE);
        }
        /*  make sure $this->_database is set.  */
        $this->_connect();
        $DB = &$_DB_DATAOBJECT['CONNECTIONS'][$this->_database_dsn_md5];




         /* look up the links for obj table */
        //print_r($obj->links());
        if (!$ofield && ($olinks = $obj->links())) {

            foreach ($olinks as $k => $v) {
                /* link contains {this column} = {linked table}:{linked column} */
                $ar = explode(':', $v);

                // Feature Request #4266 - Allow joins with multiple keys

                $links_key_array = strpos($k,',');
                if ($links_key_array !== false) {
                    $k = explode(',', $k);
                }

                $ar_array = strpos($ar[1],',');
                if ($ar_array !== false) {
                    $ar[1] = explode(',', $ar[1]);
                }

                if ($ar[0] == $this->__table) {

                    // you have explictly specified the column
                    // and the col is listed here..
                    // not sure if 1:1 table could cause probs here..

                    if ($joinCol !== false) {
                        $this->raiseError(
                            "joinAdd: You cannot target a join column in the " .
                            "'link from' table ({$obj->__table}). " .
                            "Either remove the fourth argument to joinAdd() ".
                            "({$joinCol}), or alter your links.ini file.",
                            DB_DATAOBJECT_ERROR_NODATA);
                        return false;
                    }

                    $ofield = $k;
                    $tfield = $ar[1];
                    break;
                }
            }
        }

        /* otherwise see if there are any links from this table to the obj. */
        //print_r($this->links());
        if (($ofield === false) && ($links = $this->links())) {
            foreach ($links as $k => $v) {
                /* link contains {this column} = {linked table}:{linked column} */
                $ar = explode(':', $v);
                if ($ar[0] == $obj->__table) {
                    if ($joinCol !== false) {
                        if ($k == $joinCol) {
                            $tfield = $k;
                            $ofield = $ar[1];
                            break;
                        } else {
                            continue;
                        }
                    } else {
                        $tfield = $k;
                        $ofield = $ar[1];
                        break;
                    }
                }
            }
        }
        // finally if these two table have column names that match do a join by default on them

        if (($ofield === false) && $joinCol) {
            $ofield = $joinCol;
            $tfield = $joinCol;

        }
        /* did I find a conneciton between them? */

        if ($ofield === false) {
            $this->raiseError(
                "joinAdd: {$obj->__table} has no link with {$this->__table}",
                DB_DATAOBJECT_ERROR_NODATA);
            return false;
        }
        $joinType = strtoupper($joinType);

        // we default to joining as the same name (this is remvoed later..)

        if ($joinAs === false) {
            $joinAs = $obj->__table;
        }

        $quoteIdentifiers = !empty($_DB_DATAOBJECT['CONFIG']['quote_identifiers']);

        // not sure  how portable adding database prefixes is..
        $objTable = $quoteIdentifiers ?
                $DB->quoteIdentifier($obj->__table) :
                 $obj->__table ;

        $dbPrefix  = '';
        if (strlen($obj->_database) && in_array($DB->dsn['phptype'],array('mysql','mysqli'))) {
            $dbPrefix = ($quoteIdentifiers
                         ? $DB->quoteIdentifier($obj->_database)
                         : $obj->_database) . '.';
        }

        // if they are the same, then dont add a prefix...
        if ($obj->_database == $this->_database) {
           $dbPrefix = '';
        }
        // as far as we know only mysql supports database prefixes..
        // prefixing the database name is now the default behaviour,
        // as it enables joining mutiple columns from multiple databases...

            // prefix database (quoted if neccessary..)
        $objTable = $dbPrefix . $objTable;





        // nested (join of joined objects..)
        $appendJoin = '';
        if ($obj->_join) {
            // postgres allows nested queries, with ()'s
            // not sure what the results are with other databases..
            // may be unpredictable..
            if (in_array($DB->dsn["phptype"],array('pgsql'))) {
                $objTable = "($objTable {$obj->_join})";
            } else {
                $appendJoin = $obj->_join;
            }
        }


        $table = $this->__table;

        if ($quoteIdentifiers) {
            $joinAs   = $DB->quoteIdentifier($joinAs);
            $table    = $DB->quoteIdentifier($table);
            $ofield   = $DB->quoteIdentifier($ofield);
            $tfield   = $DB->quoteIdentifier($tfield);
        }
        // add database prefix if they are different databases


        $fullJoinAs = '';
        $addJoinAs  = ($quoteIdentifiers ? $DB->quoteIdentifier($obj->__table) : $obj->__table) != $joinAs;
        if ($addJoinAs) {
            // join table a AS b - is only supported by a few databases and is probably not needed
            // , however since it makes the whole Statement alot clearer we are leaving it in
            // for those databases.
            $fullJoinAs = in_array($DB->dsn["phptype"],array('mysql','mysqli','pgsql')) ? "AS {$joinAs}" :  $joinAs;
        } else {
            // if
            $joinAs = $dbPrefix . $joinAs;
        }


        switch ($joinType) {
            case 'INNER':
            case 'LEFT':
            case 'RIGHT': // others??? .. cross, left outer, right outer, natural..?

                // Feature Request #4266 - Allow joins with multiple keys
                $this->_join .= "\n {$joinType} JOIN {$objTable} {$fullJoinAs}";
                if (is_array($ofield)) {
                	$key_count = count($ofield);
                    for($i = 0; $i < $key_count; $i++) {
                    	if ($i == 0) {
                    		$this->_join .= " ON {$joinAs}.{$ofield[$i]}={$table}.{$tfield[$i]} {$appendJoin} ";
                    	}
                    	else {
                    		$this->_join .= " AND {$joinAs}.{$ofield[$i]}={$table}.{$tfield[$i]} {$appendJoin} ";
                    	}
                     }
                } else {
	                $this->_join .= " ON {$joinAs}.{$ofield}={$table}.{$tfield} {$appendJoin} ";
                }

                break;

            case '': // this is just a standard multitable select..
                $this->_join .= "\n , {$objTable} {$fullJoinAs} {$appendJoin}";
                $this->whereAdd("{$joinAs}.{$ofield}={$table}.{$tfield}");
        }

        // if obj only a dataobject - eg. no extended class has been defined..
        // it obvioulsy cant work out what child elements might exist...
        // untill we get on the fly querying of tables..
        if ( strtolower(get_class($obj)) == 'db_dataobject') {
            return true;
        }

        /* now add where conditions for anything that is set in the object */



        $items = $obj->table();
        // will return an array if no items..

        // only fail if we where expecting it to work (eg. not joined on a array)



        if (!$items) {
            $this->raiseError(
                "joinAdd: No table definition for {$obj->__table}",
                DB_DATAOBJECT_ERROR_INVALIDCONFIG);
            return false;
        }

        foreach($items as $k => $v) {
            if (!isset($obj->$k)) {
                continue;
            }

            $kSql = ($quoteIdentifiers ? $DB->quoteIdentifier($k) : $k);


            if ($v & DB_DATAOBJECT_STR) {
                $this->whereAdd("{$joinAs}.{$kSql} = " . $this->_quote((string) (
                        ($v & DB_DATAOBJECT_BOOL) ?
                            // this is thanks to the braindead idea of postgres to
                            // use t/f for boolean.
                            (($obj->$k === 'f') ? 0 : (int)(bool) $obj->$k) :
                            $obj->$k
                    )));
                continue;
            }
            if (is_numeric($obj->$k)) {
                $this->whereAdd("{$joinAs}.{$kSql} = {$obj->$k}");
                continue;
            }

            if (is_a($obj->$k,'DB_DataObject_Cast')) {
                $value = $obj->$k->toString($v,$DB);
                if (PEAR::isError($value)) {
                    $this->raiseError($value->getMessage() ,DB_DATAOBJECT_ERROR_INVALIDARG);
                    return false;
                }
                if (strtolower($value) === 'null') {
                    $this->whereAdd("{$joinAs}.{$kSql} IS NULL");
                    continue;
                } else {
                    $this->whereAdd("{$joinAs}.{$kSql} = $value");
                    continue;
                }
            }


            /* this is probably an error condition! */
            $this->whereAdd("{$joinAs}.{$kSql} = 0");
        }
        if (!isset($this->_query)) {
            $this->raiseError(
                "joinAdd can not be run from a object that has had a query run on it,
                clone the object or create a new one and use setFrom()",
                DB_DATAOBJECT_ERROR_INVALIDARGS);
            return false;
        }
        // and finally merge the whereAdd from the child..
        if (!$obj->_query['condition']) {
            return true;
        }
        $cond = preg_replace('/^\sWHERE/i','',$obj->_query['condition']);

        $this->whereAdd("($cond)");
        return true;

    }

    /**
     * Copies items that are in the table definitions from an
     * array or object into the current object
     * will not override key values.
     *
     *
     * @param    array | object  $from
     * @param    string  $format eg. map xxxx_name to $object->name using 'xxxx_%s' (defaults to %s - eg. name -> $object->name
     * @param    boolean  $skipEmpty (dont assign empty values if a column is empty (eg. '' / 0 etc...)
     * @access   public
     * @return   true on success or array of key=>setValue error message
     */
    function setFrom($from, $format = '%s', $skipEmpty=false)
    {
        global $_DB_DATAOBJECT;
        $keys  = $this->keys();
        $items = $this->table();
        if (!$items) {
            $this->raiseError(
                "setFrom:Could not find table definition for {$this->__table}",
                DB_DATAOBJECT_ERROR_INVALIDCONFIG);
            return;
        }
        $overload_return = array();
        foreach (array_keys($items) as $k) {
            if (in_array($k,$keys)) {
                continue; // dont overwrite keys
            }
            if (!$k) {
                continue; // ignore empty keys!!! what
            }
            if (is_object($from) && isset($from->{sprintf($format,$k)})) {
                $kk = (strtolower($k) == 'from') ? '_from' : $k;
                if (method_exists($this,'set'.$kk)) {
                    $ret = $this->{'set'.$kk}($from->{sprintf($format,$k)});
                    if (is_string($ret)) {
                        $overload_return[$k] = $ret;
                    }
                    continue;
                }
                $this->$k = $from->{sprintf($format,$k)};
                continue;
            }

            if (is_object($from)) {
                continue;
            }

            if (empty($from[$k]) && $skipEmpty) {
                continue;
            }

            if (!isset($from[sprintf($format,$k)])) {
                continue;
            }

            $kk = (strtolower($k) == 'from') ? '_from' : $k;
            if (method_exists($this,'set'. $kk)) {
                $ret =  $this->{'set'.$kk}($from[sprintf($format,$k)]);
                if (is_string($ret)) {
                    $overload_return[$k] = $ret;
                }
                continue;
            }
            if (is_object($from[sprintf($format,$k)])) {
                continue;
            }
            if (is_array($from[sprintf($format,$k)])) {
                continue;
            }
            $ret = $this->fromValue($k,$from[sprintf($format,$k)]);
            if ($ret !== true)  {
                $overload_return[$k] = 'Not A Valid Value';
            }
            //$this->$k = $from[sprintf($format,$k)];
        }
        if ($overload_return) {
            return $overload_return;
        }
        return true;
    }

    /**
     * Returns an associative array from the current data
     * (kind of oblivates the idea behind DataObjects, but
     * is usefull if you use it with things like QuickForms.
     *
     * you can use the format to return things like user[key]
     * by sending it $object->toArray('user[%s]')
     *
     * will also return links converted to arrays.
     *
     * @param   string  sprintf format for array
     * @param   bool    empty only return elemnts that have a value set.
     *
     * @access   public
     * @return   array of key => value for row
     */

    public function toArray($format = '%s', $hideEmpty = false)
    {
        global $_DB_DATAOBJECT;
        $ret = array();
        $rf = ($this->_resultFields !== false) ? $this->_resultFields :
                (isset($_DB_DATAOBJECT['RESULTFIELDS'][$this->_DB_resultid]) ? $_DB_DATAOBJECT['RESULTFIELDS'][$this->_DB_resultid] : false);
        $ar = ($rf !== false) ?
            array_merge($_DB_DATAOBJECT['RESULTFIELDS'][$this->_DB_resultid],$this->table()) :
            $this->table();

        foreach($ar as $k=>$v) {

            if (!isset($this->$k)) {
                if (!$hideEmpty) {
                    $ret[sprintf($format,$k)] = '';
                }
                continue;
            }
            // call the overloaded getXXXX() method. - except getLink and getLinks
            if (method_exists($this,'get'.$k) && !in_array(strtolower($k),array('links','link'))) {
                $ret[sprintf($format,$k)] = $this->{'get'.$k}();
                continue;
            }
            // should this call toValue() ???
            $ret[sprintf($format,$k)] = $this->$k;
        }
        if (!$this->_link_loaded) {
            return $ret;
        }
        foreach($this->_link_loaded as $k) {
            $ret[sprintf($format,$k)] = $this->$k->toArray();

        }

        return $ret;
    }

    /**
     * validate the values of the object (usually prior to inserting/updating..)
     *
     * Note: This was always intended as a simple validation routine.
     * It lacks understanding of field length, whether you are inserting or updating (and hence null key values)
     *
     * This should be moved to another class: DB_DataObject_Validate
     *      FEEL FREE TO SEND ME YOUR VERSION FOR CONSIDERATION!!!
     *
     * Usage:
     * if (is_array($ret = $obj->validate())) { ... there are problems with the data ... }
     *
     * Logic:
     *   - defaults to only testing strings/numbers if numbers or strings are the correct type and null values are correct
     *   - validate Column methods : "validate{ROWNAME}()"  are called if they are defined.
     *            These methods should return
     *                  true = everything ok
     *                  false|object = something is wrong!
     *
     *   - This method loads and uses the PEAR Validate Class.
     *
     *
     * @access  public
     * @return  array of validation results (where key=>value, value=false|object if it failed) or true (if they all succeeded)
     */
    function validate()
    {
        require_once 'Validate.php';
        $table = $this->table();
        $ret   = array();
        $seq   = $this->sequenceKey();

        foreach($table as $key => $val) {


            // call user defined validation always...
            $method = "Validate" . ucfirst($key);
            if (method_exists($this, $method)) {
                $ret[$key] = $this->$method();
                continue;
            }

            // if not null - and it's not set.......

            if (!isset($this->$key) && ($val & DB_DATAOBJECT_NOTNULL)) {
                // dont check empty sequence key values..
                if (($key == $seq[0]) && ($seq[1] == true)) {
                    continue;
                }
                $ret[$key] = false;
                continue;
            }


            if (is_string($this->$key) && (strtolower($this->$key) == 'null')) {
                if ($val & DB_DATAOBJECT_NOTNULL) {
                    $this->debug("'null' field used for '$key', but it is defined as NOT NULL", 'VALIDATION', 4);
                    $ret[$key] = false;
                    continue;
                }
                continue;
            }

            // ignore things that are not set. ?

            if (!isset($this->$key)) {
                continue;
            }

            // if the string is empty.. assume it is ok..
            if (!is_object($this->$key) && !is_array($this->$key) && !strlen((string) $this->$key)) {
                continue;
            }

            // dont try and validate cast objects - assume they are problably ok..
            if (is_object($this->$key) && is_a($this->$key,'DB_DataObject_Cast')) {
                continue;
            }
            // at this point if you have set something to an object, and it's not expected
            // the Validate will probably break!!... - rightly so! (your design is broken,
            // so issuing a runtime error like PEAR_Error is probably not appropriate..

            switch (true) {
                // todo: date time.....
                case  ($val & DB_DATAOBJECT_STR):
                    $ret[$key] = Validate::string($this->$key, VALIDATE_PUNCTUATION . VALIDATE_NAME);
                    continue 2;
                case  ($val & DB_DATAOBJECT_INT):
                    $ret[$key] = Validate::number($this->$key, array('decimal'=>'.'));
                    continue 2;
            }
        }
        // if any of the results are false or an object (eg. PEAR_Error).. then return the array..
        foreach ($ret as $key => $val) {
            if ($val !== true) {
                return $ret;
            }
        }
        return true; // everything is OK.
    }

    /**
     * Gets the DB object related to an object - so you can use funky peardb stuf with it :)
     *
     * @access public
     * @return object The DB connection
     */
    function &getDatabaseConnection()
    {
        global $_DB_DATAOBJECT;

        if (($e = $this->_connect()) !== true) {
            return $e;
        }
        if (!isset($_DB_DATAOBJECT['CONNECTIONS'][$this->_database_dsn_md5])) {
            $r = false;
            return $r;
        }
        return $_DB_DATAOBJECT['CONNECTIONS'][$this->_database_dsn_md5];
    }


    /**
     * Gets the DB result object related to the objects active query
     *  - so you can use funky pear stuff with it - like pager for example.. :)
     *
     * @access public
     * @return object The DB result object
     */

    function &getDatabaseResult()
    {
        global $_DB_DATAOBJECT;
        $this->_connect();
        if (!isset($_DB_DATAOBJECT['RESULTS'][$this->_DB_resultid])) {
            $r = false;
            return $r;
        }
        return $_DB_DATAOBJECT['RESULTS'][$this->_DB_resultid];
    }

    /**
     * Overload Extension support
     *  - enables setCOLNAME/getCOLNAME
     *  if you define a set/get method for the item it will be called.
     * otherwise it will just return/set the value.
     * NOTE this currently means that a few Names are NO-NO's
     * eg. links,link,linksarray, from, Databaseconnection,databaseresult
     *
     * note
     *  - set is automatically called by setFrom.
     *   - get is automatically called by toArray()
     *
     * setters return true on success. = strings on failure
     * getters return the value!
     *
     * this fires off trigger_error - if any problems.. pear_error,
     * has problems with 4.3.2RC2 here
     *
     * @access public
     * @return true?
     * @see overload
     */


    function _call($method,$params,&$return) {

        //$this->debug("ATTEMPTING OVERLOAD? $method");
        // ignore constructors : - mm
        if (strtolower($method) == strtolower(get_class($this))) {
            return true;
        }
        $type = strtolower(substr($method,0,3));
        $class = get_class($this);
        if (($type != 'set') && ($type != 'get')) {
            return false;
        }



        // deal with naming conflick of setFrom = this is messy ATM!

        if (strtolower($method) == 'set_from') {
            $return = $this->toValue('from',isset($params[0]) ? $params[0] : null);
            return  true;
        }

        $element = substr($method,3);

        // dont you just love php's case insensitivity!!!!

        $array =  array_keys(get_class_vars($class));
        /* php5 version which segfaults on 5.0.3 */
        if (class_exists('ReflectionClass')) {
            $reflection = new ReflectionClass($class);
            $array = array_keys($reflection->getdefaultProperties());
        }

        if (!in_array($element,$array)) {
            // munge case
            foreach($array as $k) {
                $case[strtolower($k)] = $k;
            }
            if ((substr(phpversion(),0,1) == 5) && isset($case[strtolower($element)])) {
                trigger_error("PHP5 set/get calls should match the case of the variable",E_USER_WARNING);
                $element = strtolower($element);
            }

            // does it really exist?
            if (!isset($case[$element])) {
                return false;
            }
            // use the mundged case
            $element = $case[$element]; // real case !
        }


        if ($type == 'get') {
            $return = $this->toValue($element,isset($params[0]) ? $params[0] : null);
            return true;
        }


        $return = $this->fromValue($element, $params[0]);

        return true;


    }


    /**
    * standard set* implementation.
    *
    * takes data and uses it to set dates/strings etc.
    * normally called from __call..
    *
    * Current supports
    *   date      = using (standard time format, or unixtimestamp).... so you could create a method :
    *               function setLastread($string) { $this->fromValue('lastread',strtotime($string)); }
    *
    *   time      = using strtotime
    *   datetime  = using  same as date - accepts iso standard or unixtimestamp.
    *   string    = typecast only..
    *
    * TODO: add formater:: eg. d/m/Y for date! ???
    *
    * @param   string       column of database
    * @param   mixed        value to assign
    *
    * @return   true| false     (False on error)
    * @access   public
    * @see      DB_DataObject::_call
    */


    function fromValue($col,$value)
    {
        $cols = $this->table();
        // dont know anything about this col..
        if (!isset($cols[$col])) {
            $this->$col = $value;
            return true;
        }
        //echo "FROM VALUE $col, {$cols[$col]}, $value\n";
        switch (true) {
            // set to null and column is can be null...
            case ((strtolower($value) == 'null') && (!($cols[$col] & DB_DATAOBJECT_NOTNULL))):
            case (is_object($value) && is_a($value,'DB_DataObject_Cast')):
                $this->$col = $value;
                return true;

            // fail on setting null on a not null field..
            case ((strtolower($value) == 'null') && ($cols[$col] & DB_DATAOBJECT_NOTNULL)):
                return false;

            case (($cols[$col] & DB_DATAOBJECT_DATE) &&  ($cols[$col] & DB_DATAOBJECT_TIME)):
                // empty values get set to '' (which is inserted/updated as NULl
                if (!$value) {
                    $this->$col = '';
                }

                if (is_numeric($value)) {
                    $this->$col = date('Y-m-d H:i:s', $value);
                    return true;
                }

                // eak... - no way to validate date time otherwise...
                $this->$col = (string) $value;
                return true;

            case ($cols[$col] & DB_DATAOBJECT_DATE):
                // empty values get set to '' (which is inserted/updated as NULl

                if (!$value) {
                    $this->$col = '';
                    return true;
                }

                if (is_numeric($value)) {
                    $this->$col = date('Y-m-d',$value);
                    return true;
                }

                // try date!!!!
                require_once 'Date.php';
                $x = new Date($value);
                $this->$col = $x->format("%Y-%m-%d");
                return true;

            case ($cols[$col] & DB_DATAOBJECT_TIME):
                // empty values get set to '' (which is inserted/updated as NULl
                if (!$value) {
                    $this->$col = '';
                }

                $guess = strtotime($value);
                if ($guess != -1) {
                     $this->$col = date('H:i:s', $guess);
                    return $return = true;
                }
                // otherwise an error in type...
                return false;

            case ($cols[$col] & DB_DATAOBJECT_STR):

                $this->$col = (string) $value;
                return true;

            // todo : floats numerics and ints...
            default:
                $this->$col = $value;
                return true;
        }



    }
     /**
    * standard get* implementation.
    *
    *  with formaters..
    * supported formaters:
    *   date/time : %d/%m/%Y (eg. php strftime) or pear::Date
    *   numbers   : %02d (eg. sprintf)
    *  NOTE you will get unexpected results with times like 0000-00-00 !!!
    *
    *
    *
    * @param   string       column of database
    * @param   format       foramt
    *
    * @return   true     Description
    * @access   public
    * @see      DB_DataObject::_call(),strftime(),Date::format()
    */
    function toValue($col,$format = null)
    {
        if (is_null($format)) {
            return $this->$col;
        }
        $cols = $this->table();
        switch (true) {
            case (($cols[$col] & DB_DATAOBJECT_DATE) &&  ($cols[$col] & DB_DATAOBJECT_TIME)):
                if (!$this->$col) {
                    return '';
                }
                $guess = strtotime($this->$col);
                if ($guess != -1) {
                    return strftime($format, $guess);
                }
                // eak... - no way to validate date time otherwise...
                return $this->$col;
            case ($cols[$col] & DB_DATAOBJECT_DATE):
                if (!$this->$col) {
                    return '';
                }
                $guess = strtotime($this->$col);
                if ($guess != -1) {
                    return strftime($format,$guess);
                }
                // try date!!!!
                require_once 'Date.php';
                $x = new Date($this->$col);
                return $x->format($format);

            case ($cols[$col] & DB_DATAOBJECT_TIME):
                if (!$this->$col) {
                    return '';
                }
                $guess = strtotime($this->$col);
                if ($guess > -1) {
                    return strftime($format, $guess);
                }
                // otherwise an error in type...
                return $this->$col;

            case ($cols[$col] &  DB_DATAOBJECT_MYSQLTIMESTAMP):
                if (!$this->$col) {
                    return '';
                }
                require_once 'Date.php';

                $x = new Date($this->$col);

                return $x->format($format);


            case ($cols[$col] &  DB_DATAOBJECT_BOOL):

                if ($cols[$col] &  DB_DATAOBJECT_STR) {
                    // it's a 't'/'f' !
                    return ($this->$col === 't');
                }
                return (bool) $this->$col;


            default:
                return sprintf($format,$this->col);
        }


    }


    /* ----------------------- Debugger ------------------ */

    /**
     * Debugger. - use this in your extended classes to output debugging information.
     *
     * Uses DB_DataObject::DebugLevel(x) to turn it on
     *
     * @param    string $message - message to output
     * @param    string $logtype - bold at start
     * @param    string $level   - output level
     */
    protected static function debug($message, $logtype = 0, $level = 1): void
    {
        global $_DB_DATAOBJECT;

        if (empty($_DB_DATAOBJECT['CONFIG']['debug'])  ||
            (is_numeric($_DB_DATAOBJECT['CONFIG']['debug']) &&  $_DB_DATAOBJECT['CONFIG']['debug'] < $level)) {
            return;
        }

        $class = get_class();

        if (!is_string($message)) {
            $message = print_r($message,true);
        }

        if (!is_numeric( $_DB_DATAOBJECT['CONFIG']['debug']) && is_callable( $_DB_DATAOBJECT['CONFIG']['debug'])) {
            call_user_func($_DB_DATAOBJECT['CONFIG']['debug'], $class, $message, $logtype, $level);
        }

        if (!ini_get('html_errors')) {
            echo "$class   : $logtype       : $message\n";
            flush();
            return;
        }

        if (!is_string($message)) {
            $message = print_r($message,true);
        }
        $colorize = ($logtype == 'ERROR') ? '<font color="red">' : '<font>';
        echo "<code>{$colorize}<B>$class: $logtype:</B> ". nl2br(htmlspecialchars($message)) . "</font></code><BR>\n";
    }

    /**
     * sets and returns debug level
     * eg. DB_DataObject::debugLevel(4);
     *
     * @param   int     $v  level
     * @access  public
     */
    function debugLevel($v = null)
    {
        global $_DB_DATAOBJECT;
        if (empty($_DB_DATAOBJECT['CONFIG'])) {
            DB_DataObject::_loadConfig();
        }
        if ($v !== null) {
            $r = isset($_DB_DATAOBJECT['CONFIG']['debug']) ? $_DB_DATAOBJECT['CONFIG']['debug'] : 0;
            $_DB_DATAOBJECT['CONFIG']['debug']  = $v;
            return $r;
        }
        return isset($_DB_DATAOBJECT['CONFIG']['debug']) ? $_DB_DATAOBJECT['CONFIG']['debug'] : 0;
    }

    /**
     * Last Error that has occurred
     * - use $this->_lastError or
     * $last_error = &PEAR::getStaticProperty('DB_DataObject','lastError');
     *
     * @access  public
     * @var     object PEAR_Error (or false)
     */
    var $_lastError = false;

    /**
     * Default error handling is to create a pear error, but never return it.
     * if you need to handle errors you should look at setting the PEAR_Error callback
     * this is due to the fact it would wreck havoc on the internal methods!
     *
     * @param  int $message    message
     * @param  int $type       type
     * @param  int $behaviour  behaviour (die or continue!);
     * @access public
     * @return DB_DataObject_Error|PEAR_Error
     */
    public static function raiseError($message, $type = null, $behaviour = null)
    {
        global $_DB_DATAOBJECT;

        if ($behaviour == PEAR_ERROR_DIE && !empty($_DB_DATAOBJECT['CONFIG']['dont_die'])) {
            $behaviour = null;
        }
        $error = PEAR::getStaticProperty('DB_DataObject','lastError');

        $_DB_DATAOBJECT['LASTERROR'] = $error;

        // no checks for production here?....... - we log  errors before we throw them.
        DB_DataObject::debug($message,'ERROR',1);

        if (PEAR::isError($message)) {
            $error = $message;
        } else {
            require_once 'DB/DataObject/Error.php';
            $error = PEAR::raiseError($message, $type, $behaviour,
                            $opts=null, $userinfo=null, 'DB_DataObject_Error'
                        );
        }

        return $error;
    }

    /**
     * Define the global $_DB_DATAOBJECT['CONFIG'] as an alias to  PEAR::getStaticProperty('DB_DataObject','options');
     *
     * After Profiling DB_DataObject, I discoved that the debug calls where taking
     * considerable time (well 0.1 ms), so this should stop those calls happening. as
     * all calls to debug are wrapped with direct variable queries rather than actually calling the funciton
     * THIS STILL NEEDS FURTHER INVESTIGATION
     *
     * @return   object an error object
     */
    public static function _loadConfig()
    {
        global $_DB_DATAOBJECT;

        $_DB_DATAOBJECT['CONFIG'] = &PEAR::getStaticProperty('DB_DataObject','options');
    }

     /**
     * Free global arrays associated with this object.
     */
    public function free()
    {
        global $_DB_DATAOBJECT;

        if (isset($_DB_DATAOBJECT['RESULTFIELDS'][$this->_DB_resultid])) {
            unset($_DB_DATAOBJECT['RESULTFIELDS'][$this->_DB_resultid]);
        }
        if (isset($_DB_DATAOBJECT['RESULTS'][$this->_DB_resultid])) {
            unset($_DB_DATAOBJECT['RESULTS'][$this->_DB_resultid]);
        }
        // clear the staticGet cache as well.
        $this->_clear_cache();
        // this is a huge bug in DB!
        if (isset($_DB_DATAOBJECT['CONNECTIONS'][$this->_database_dsn_md5])) {
            $_DB_DATAOBJECT['CONNECTIONS'][$this->_database_dsn_md5]->num_rows = array();
        }

    }


    /* ---- LEGACY BC METHODS - NOT DOCUMENTED - See Documentation on New Methods. ---*/

    function _get_table() { return $this->table(); }
    function _get_keys()  { return $this->keys();  }




}
// technially 4.3.2RC1 was broken!!
// looks like 4.3.3 may have problems too....
if (!defined('DB_DATAOBJECT_NO_OVERLOAD')) {

    if ((phpversion() != '4.3.2-RC1') && (version_compare( phpversion(), "4.3.1") > 0)) {
        if (version_compare( phpversion(), "5") < 0) {
           overload('DB_DataObject');
        }
        $GLOBALS['_DB_DATAOBJECT']['OVERLOADED'] = true;
    }
}

