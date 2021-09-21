<?php

/*
+---------------------------------------------------------------------------+
| Revive Adserver                                                           |
| http://www.revive-adserver.com                                            |
|                                                                           |
| Copyright: See the COPYRIGHT.txt file.                                    |
| License: GPLv2 or later, see the LICENSE.txt file.                        |
+---------------------------------------------------------------------------+
*/

require_once MAX_PATH . '/lib/OA/Dal.php';
require_once MAX_PATH . '/lib/OA/DB.php';
require_once MAX_PATH . '/lib/OA/DB/AdvisoryLock.php';
require_once MAX_PATH . '/lib/OA/ServiceLocator.php';
require_once MAX_PATH . '/lib/wact/db/db.inc.php';
require_once 'DB/QueryTool.php';

/**
 * A non-DB specific base Data Access Layer (DAL) class for other DAL
 * classes to inherit from. Provides the basic database connectivity and
 * querying methods.
 *
 * @package    MaxDal
 */
class MAX_Dal_Common
{
    /**
     * @var MDB2_Driver_Common
     */
    public $oDbh;
    public $queryBuilder;
    public $conf;
    public $prefix;

    /**
     * Usually most of models will be created to handle persistent operation per
     * specific table. This variable store that table name and it is used by factoryDO() method
     *
     * @var string
     */
    public $table;

    /**
     * @var OA_DB_AdvisoryLock
     */
    public $oLock;

    /**
     * This array is used by getSqlListOrder(), getOrderColumn to decide how to sort
     * rows. It should be overwritten in child classes.
     * Format is:
     *  'name' => 'nameField',
     *  'id'   => 'idField',
     *  etc...
     *  Each value may be an array if ordering by multiple columns is desired.
     *
     * It replaces deprecated phpAds_getListOrder
     *
     * @see MAX_Dal_Common::getSqlListOrder()
     * @var array
     */
    public $orderListName = [];

    // Default column to order by.
    public $defaultOrderListName = 'name';

    /**
     * The class constructor method.
     */
    public function __construct()
    {
        $this->conf = $GLOBALS['_MAX']['CONF'];
        $this->prefix = $this->getTablePrefix();
        $this->oDbh = &$this->_getDbConnection();
        $this->queryBuilder = $this->_getQueryTool($this->oDbh);
    }

    /**
     * Factory method for loading model class
     *
     * @param string $modelName
     * @return self|false
     */
    public static function factory($modelName)
    {
        if (empty($modelName)) {
            PEAR::raiseError("Factory did not recive model name");
            return false;
        }
        $modelName = ucfirst($modelName);
        $class = self::getClassName($modelName);
        if (!class_exists($class)) {
            $class = self::autoLoadClass($modelName);
            if (!$class) {
                return false;
            }
        }

        return new $class();
    }

    /**
     * Autoload class
     *
     * @param string $modelName  Class model name
     * @return boolean  True on success
     */
    private static function autoLoadClass($modelName)
    {
        $path = MAX_PATH . '/lib/max/Dal/Admin/' . $modelName . '.php';
        if (!file_exists($path)) {
            PEAR::raiseError("autoload:File doesn't exist {$path}");
            return false;
        }
        include_once $path;

        $class = MAX_Dal_Common::getClassName($modelName);
        if (!class_exists($class)) {
            PEAR::raiseError("autoload:Could not autoload {$class}");
            return false;
        }
        return $class;
    }

    public static function getClassName($table)
    {
        return 'MAX_Dal_Admin_' . ucfirst($table);
    }

    public static function getTablePrefix()
    {
        return OA_Dal::getTablePrefix();
    }

    /**
     * A private method to manage creation of the utilised OA_DB class.
     *
     * @access private
     * @return mixed An instance of the OA_DB class.
     */
    public function &_getDbConnection()
    {
        return OA_DB::singleton();
    }

    /**
     * A private method for instantiating the DB_QueryTool class.
     *
     * @access private
     * @param mixed $dsn DSN string, DSN array or DB object
     */
    public function _getQueryTool($dsn)
    {
        return new DB_QueryTool($dsn);
    }

    /**
     * A private method used for generating data access SQL via the DB_QueryTool,
     * and returning the results.
     *
     * @access private
     * @param array $aParams A hash of parameters, indexed on the following strings:
     *  - "table"    The (primary) database table to select from.
     *  - "fields"   An optional array of the "table.column"s (in all tables) to
     *               select, default is all columns.
     *  - "wheres"   An optional array of arrays, each containing a two strings -
     *               the first being the where clause, and the second being 'AND'
     *               or 'OR'. Bracketing and AND/OR can be used inside the where
     *               string to make complex logic if needed.
     *  - "joins"    An optional array of arrays, each containing two strings - the
     *               first being the table to join to (ie. not $table) and the second
     *               being the complete where statement to link the tables (ie.
     *               do not have more than one join array for the same extra table).
     *  - "group"    An optional comma separated list of "table.column"s to group by.
     *  - "orderBys" An optional array of arrays, each containing two strings - the
     *               first being a "table.column" to order by, and the second being
     *               either "ASC" or "DESC".
     *  - "havings"  An optional array of arrays, each containing a two strings -
     *               the first being the having clause, and the second being 'AND'
     *               or 'OR'. Bracketing and AND/OR can be used inside the having
     *               string to make complex logic if needed.
     * @return array An array of arrays representing the result(s) of the query.
     */
    public function &_get($aParams)
    {
        if (is_null($aParams['table'])) {
            return [];
        }
        // Reset the query builder
        $this->queryBuilder->reset();
        // Set the primary table
        $this->queryBuilder->setTable($aParams['table']);
        // Add fields
        if (count($aParams['fields']) > 0) {
            $this->queryBuilder->setSelect($aParams['fields'][0]);
            if (count($aParams['fields']) > 1) {
                for ($counter = 1; $counter < count($aParams['fields']); $counter++) {
                    $this->queryBuilder->addSelect($aParams['fields'][$counter]);
                }
            }
        }
        // Add where conditions
        if (!empty($aParams['wheres'])) {
            list($constraint, $operator) = $aParams['wheres'][0];
            $this->queryBuilder->setWhere($constraint, $operator);
            if (count($aParams['wheres']) > 1) {
                for ($counter = 1; $counter < count($aParams['wheres']); $counter++) {
                    list($constraint, $operator) = $aParams['wheres'][$counter];
                    $this->queryBuilder->addWhere($constraint, $operator);
                }
            }
        }
        // Add joins
        if (!empty($aParams['joins'])) {
            foreach ($aParams['joins'] as $join) {
                list($table, $joinCond) = $join;
                $this->queryBuilder->addJoin($table, $joinCond);
            }
        }
        // Add the grouping
        if (!empty($aParams['group'])) {
            $this->queryBuilder->setGroup($aParams['group']);
        }
        // Add order by conditions
        if (!empty($aParams['orderBys'])) {
            list($field, $direction) = $aParams['orderBys'][0];
            if (!is_bool($direction)) {
                $direction = ($direction == 'DESC') ? true : false;
            }
            $this->queryBuilder->setOrder($field, $direction);
            if (count($aParams['orderBys']) > 1) {
                for ($counter = 1; $counter < count($aParams['orderBys']); $counter++) {
                    list($field, $direction) = $aParams['orderBys'][$counter];
                    if (!is_bool($direction)) {
                        $direction = ($direction == 'DESC') ? true : false;
                    }
                    $this->queryBuilder->addOrder($field, $direction);
                }
            }
        }
        // Add having conditions
        if (!empty($aParams['havings'])) {
            list($constraint, $operator) = $aParams['havings'][0];
            $this->queryBuilder->setHaving($constraint);
            if (count($aParams['havings']) > 1) {
                for ($counter = 1; $counter < count($aParams['havings']); $counter++) {
                    list($constraint, $operator) = $aParams['havings'][$counter];
                    $this->queryBuilder->addHaving($constraint, $operator);
                }
            }
        }
        // Run the query and return the result(s)
        $result = $this->queryBuilder->getAll();
        return $result;
    }

    // Get any generic list order...
    public function getSqlListOrder($listOrder, $orderDirection)
    {
        $direction = $this->getOrderDirection($this->oDbh->quote($orderDirection, 'text'));
        $nameColumn = $this->getOrderColumn($this->oDbh->quote($listOrder, 'text'));
        if (is_array($nameColumn)) {
            $sqlTableOrder = ' ORDER BY ' . implode($direction . ',', $nameColumn) . $direction;
        } else {
            $sqlTableOrder = !empty($nameColumn) ? " ORDER BY $nameColumn $direction" : '';
        }
        return $sqlTableOrder;
    }

    /**
     * Gets the direction to order by
     *
     * @param string $orderDirection the sorting direction ('up' or 'down').
     * @return string the SQL ORDER BY direction keyword
     */
    public function getOrderDirection($orderDirection)
    {
        return ($orderDirection == 'down') ? ' DESC' : ' ASC';
    }

    /**
     * Gets the column name(s) to order by.
     *
     * @param string $listOrder the "type" of column to order by, eg 'name', 'id'.
     * @return string  the name(s) of the column(s) to order by
     */
    public function getOrderColumn($listOrder)
    {
        return isset($this->orderListName[$listOrder]) ? $this->orderListName[$listOrder] : $this->orderListName[$this->defaultOrderListName];
    }

    public function _getTablename($tableName)
    {
        return $this->oDbh->quoteIdentifier($this->_getTablenameUnquoted($tableName), true);
    }

    public function _getTablenameUnquoted($tableName)
    {
        return $this->prefix . ($this->conf['table'][$tableName] ?? $tableName);
    }
}
