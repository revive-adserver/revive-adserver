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

require_once LIB_PATH . '/Extension/deliveryLog/BucketProcessingStrategyFactory.php';
require_once LIB_PATH . '/Plugin/Component.php';

/**
 * Abstract ancestor class for all plugin components that use the
 * deliveryLog extension.
 *
 * @package    OpenXExtension
 * @subpackage DeliveryLog
 */
abstract class Plugins_DeliveryLog extends OX_Component
{

    // @todo - add database specific mapping in db layer
    const TIMESTAMP_WITHOUT_ZONE = 'timestamp without time zone';
    const INTEGER = 'integer';
    const CHAR = 'char';

    const COUNT_COLUMN = 'count';

    /**
     * The type of bucket data that is stored, either
     * "aggregate" or "raw". Default is "aggregate".
     *
     * @var string
     */
    protected $type = 'aggregate';

    /**
     * An object that implements the bucket processing strategy
     * interface, so that the processing of the bucket data can
     * be delegated to another class.
     *
     * @var OX_Extension_DeliveryLog_BucketProcessingStrategy
     */
    protected $oProcessingStrategy;

    /**
     * The class constructor method, to be used by child implementations.
     */
    function __construct()
    {
        // Set the bucket processing strategy, based on the type.
        $dbType = $GLOBALS['_MAX']['CONF']['database']['type'];
        if ($this->type == 'aggregate') {
            $this->oProcessingStrategy =
                OX_Extension_DeliveryLog_BucketProcessingStrategyFactory::getAggregateBucketProcessingStrategy($dbType);
        } else {
            $this->oProcessingStrategy =
                OX_Extension_DeliveryLog_BucketProcessingStrategyFactory::getRawBucketProcessingStrategy($dbType);
        }
    }

    /**
     * Carry on any additional post-installs actions
     * (for example install postgres specific stored procedures)
     *
     * @return boolean True on success, false otherwise.
     */
    public function onInstall()
    {
        $oDbLayer = $this->_factoryDBLayer();
        if (!$oDbLayer || !$oDbLayer->install($this)) {
            return false;
        }
        return true;
    }

    /**
     * Carry on any additional post-uninstalls actions
     * (for example uninstall postgres specific stored procedures)
     *
     * @return boolean True on success, false otherwise.
     */
    public function onUninstall()
    {
        return true;
    }

    /**
     * A private factory method to create the required OX_Extension_DeliveryLog_DB_Common
     * database layer class used in installing components that utilise the deliveryLog
     * extension.
     *
     * @param string $dbType Optional database type, eg. "mysql" or "pgsql". By default,
     *                       the database type will be taken from the database connection
     *                       defined in the OpenX installation.
     * @return mixed The boolean false on error, class of type
     *               OX_Extension_DeliveryLog_DB_Common on success.
     */
    private function _factoryDBLayer($dbType = null)
    {
        if (is_null($dbType)) {
            $oDbh = OA_DB::singleton();
            $dbType = $oDbh->dsn['phptype'];
        }
        // Include the required database layer file for the deliveryLog extension
        if (!$this->_includeDbLayerFile($oDbh->dsn['phptype'])) {
            $message = 'Error when including the required database layer file ' .
                       "for the deliveryLog extension, for the '$dbType' database type.";
            $this->_logError($message);
            return false;
        }
        // Generate the class name expected for the deliveryLog extension database layer
        $className = 'OX_Extension_DeliveryLog_DB_' . ucfirst(strtolower($oDbh->dsn['phptype']));
        if (!class_exists($className)) {
            // Class name does not exist, use the default class name instead
            $className = 'OX_Extension_DeliveryLog_DB_Common';
            if (!class_exists($className)) {
                $message = "Expected class of '$className' not located in the deliveryLog extension " .
                           "database layer file, for the '$dbType' database type.";
                $this->_logError($message);
                return false;
            }
        }
        // Instantiate and return the deliveryLog extenion database layer support class
        return new $className();
    }

    /**
     * A private method to include the appropriate deliveryLog extension
     * database layer class.
     *
     * @access private
     * @param string $dbType The database type, eg "mysql" or "pgsql".
     * @return boolean True on success (correct inclusion of the file),
     *                 false otherwise.
     */
    private function _includeDbLayerFile($dbType)
    {
        // Prepare the path to the database layer support class file for the
        // deliveryLog extension
        $fileName = LIB_PATH . '/Extension/deliveryLog/DB/' . ucfirst(strtolower($dbType)) . '.php';
        if (!file_exists($fileName)) {
            // The file could not be found - use the default class instead
            $fileName = LIB_PATH . '/Extension/deliveryLog/DB/Common.php';
            if (!file_exists($fileName)) {
                return false;
            }
        }
        @include_once $fileName;
        return true;
    }

    /**
     * Returns the dependencies between deliveryLog components.
     * Used to schedule the delivery log components so the required
     * data prepare components are run in the proper order and are
     * run before the logging hooks.
     *
     * @return array  Format: array(componentId => array(depends on componentId, ...), ...)
     */
    abstract function getDependencies();

    /**
     * Returns the bucket table name
     *
     * @return string The bucket table bucket name without prefix.
     */
    abstract function getBucketName();

    /**
     * Returns the bucket table name.
     *
     * @return string The bucket table name with added prefix.
     */
    public function getBucketTableName()
    {
        return OA_Dal::getTablePrefix() . $this->getBucketName();
    }

    /**
     * Returns the columns in the bucket table.
     *
     * @return array Format: array(column name => column type, ...)
     */
    abstract public function getBucketTableColumns();

    /**
     * Returns the bucket's destination statistics table name, that is,
     * the table that is defined in the component's plugin to store the
     * aggregate bucket data for the components, but without the table
     * prefix
     *
     * @return string The statistics table name without prefix.
     */
    abstract function getStatisticsName();

    /**
     * Returns the bucket's destination statistics table, that is, the
     * table that is defined in the component's plugin to store the
     * aggregate bucket data for the components.
     *
     * @return string The statistics table name with added prefix.
     */
    public function getStatisticsTableName()
    {
        return OA_Dal::getTablePrefix() . $this->getStatisticsName();
    }

    /**
     * A method that returns the bucket to statistics column mapping
     * for the component.
     *
     * Notes:
     *
     * 1) While any number of plugin componets are welcome to migrate
     *    data to the same statsitsics table, raw and supplementary
     *    raw bucket data are treated independently. However, aggregate
     *    bucket data are not.
     *
     * 2) The above means that, wherever more than one plugin component
     *    migrates data to the same statistics table, and one of the
     *    components is of the "aggregate" method, then ALL of the
     *    plugin components must be of the "aggregate" method. Any
     *    components that are not WILL BE IGNORED, and any raw or
     *    supplementary raw data will not be migrated.
     *
     * 3) Finally, whenever multiple aggregate plugin components migrate
     *    data to the same statistics table, then all of the
     *    "groupDestination" columns names used in ALL of the components
     *    MUST be IDENTICAL between the components.
     *
     * @abstract
     * @return array The array describing how the bucket data should
     *               be migrated to the final statistics table. There
     *               are three possible formats, described below:
     *
     * 1. Migration of Aggregate Bucket Data
     *
     * Required map keys & values:
     * - method             => The value "aggregate".
     * - bucketTable        => The name of the bucket table, including prefix
     *                         if required, where the aggregate bucked data
     *                         is stored.
     * - dateTimeColumn     => The name of the column in the bucket table that
     *                         defines the date/time for which the data is
     *                         relevant (and which will be used to limit which
     *                         data are migrated to the statistics table).
     * - groupSource        => An array, indexed by integers, of the column(s) in
     *                         the bucket table which are to be used to group
     *                         the aggregate data when they are migrated to the
     *                         statistics table.
     * - groupDestination   => An array, indexed by the same integers as the
     *                         "groupSource" array, of the column(s) in the
     *                         statistics table which will accept the grouping
     *                         values defined by the "groupSource" array. ALL
     *                         plugin components migrating data into the same
     *                         aggregate statistics table MUST use IDENTICAL
     *                         "groupDesintation" keys and values.
     * - sumSource          => An array, indexed by integers, of the column(s)
     *                         in the bucket table which are to be used as the
     *                         source of data which can be aggregated when they
     *                         are migrated to the statistics table.
     * - sumDestination     => An array, indexed by the same integers as the
     *                         "sumSource" array, of the columns which will
     *                         accept the aggregated values defined by the
     *                         "sumSource" array.
     * - sumDefault         => In the event that data from more than one bucket
     *                         table are being migrated into the same statistics
     *                         table, although the "groupDestination" array MUST
     *                         be IDENTICAL for all plugin components, this is
     *                         not the case with the aggregate data. As a result,
     *                         different plugin components may not have any
     *                         data for certain "sumDestination" columns in the
     *                         statistics table. As a result, each column defined
     *                         must have a default value that will be used when
     *                         aggregating the data. Generally, default values
     *                         will be zero.
     *
     * 2. Migration of Raw Bucket Data
     *
     * Required map keys & values:
     * - method             => The value "raw".
     * - bucketTable        => The name of the bucket table, including prefix
     *                         if required, where the aggregate bucked data
     *                         is stored.
     * - dateTimeColumn     => The name of the column in the bucket table that
     *                         defines the date/time for which the data is
     *                         relevant (and which will be used to limit which
     *                         data are migrated to the statistics table).
     * - source             => An array, indexed by integers, of the column(s)
     *                         in the bucket table which should be used as the
     *                         source(s) of raw data to be migrated to the
     *                         statistics table.
     * - destination        => An array, indexed by the same integers as the
     *                         "source" array, of the column(s) in the statistics
     *                         table which should be used to store the corresponding
     *                         raw data when they are migrated.
     * - extrasDestination  => An array, indexed by integers, of any column(s)
     *                         in the statstics table that should have a custom
     *                         value set whenever a row is inserted in the table
     *                         whenever data are migrated. Generally, this will
     *                         be an empty array.
     * - extrasValue        => An array, indexed by the same integers as the
     *                         "extrasDestination" array, of the custom value(s)
     *                         that correspond with the columns of the statistics
     *                         table specified in the "extrasDestination" array.
     *
     * 3. Migration of Supplementary Raw Bucket Data
     *
     * Required map keys & values:
     * - method                 => The value "rawSupplementary".
     * - masterTable            => The name of the statistics table, including
     *                             prefix if required, where the previously migrated
     *                             raw data are stored, to which the supplementary
     *                             raw data related.
     * - masterTablePrimaryKeys => An array, indexed by integers, of the columns(s)
     *                             in the "masterTable" that are to be used to connect
     *                             (i.e. in a foreign key style relationship) the
     *                             previously migrated raw data, and the to be migrated
     *                             supplementary raw data, when it has been migrated
     *                             to the summplementary raw data statisics table
     *                             (i.e. post-migration).
     * - bucketTablePrimaryKeys => An array, indexed bu the same integers as the
     *                             "masterTablePrimaryKeys" array, of the corresponding
     *                             columns(s) in the statistics table the supplementary
     *                             raw data will be migrated to.
     * - masterTableKeys        => An array, indexed by integers, of the columns(s) in
     *                             the "masterTable" that are to be used to connect
     *                             (i.e. in a foriegn key style relationship) the
     *                             previously migrated raw data, and the to be migrated
     *                             supplementarty raw data, before it has been migrated
     *                             from the summplementary raw data bucket table
     *                             (i.e. pre-migration).
     * - bucketTableKeys        => An array, indexed bu the same integers as the
     *                             "masterTableKeys" array, of the corresponding
     *                             columns(s) in the bucket table the supplementary
     *                             raw data will be migrated from.
     * - masterDateTimeColumn   => The name of the column in the "masterTable" that
     *                             defines the date/time for which the previously
     *                             migrated raw data is relevant (and which will be
     *                             used to limit which previously migrated raw data
     *                             are used to locate matching supplementary raw data
     *                             to be migrated to the supplementary raw data
     *                             statistics table).
     * - bucketTable            => The name of the bucket table, including prefix
     *                             if required, where the aggregate bucked data
     *                             is stored.
     * - source                 => An array, indexed by integers, of the column(s)
     *                             in the bucket table which should be used as the
     *                             source(s) of supplementary raw data to be migrated
     *                             to the supplementary raw data statistics table.
     * - destination            => An array, indexed by the same integers as the
     *                             "source" array, of the column(s) in the supplementary
     *                             raw statistics table which should be used to store the
     *                             corresponding supplementary raw data when they are migrated.
     *
     * 4. Custom Migration of Bucket Data
     *
     * Required map keys & values:
     * - method             => The value "custom".
     * - bucketTable        => The name of the bucket table, including prefix
     *                         if required, where the aggregate bucked data
     *                         is stored.
     * - dateTimeColumn     => The name of the column in the bucket table that
     *                         defines the date/time for which the data is
     *                         relevant (and which will be used to limit which
     *                         data are migrated to the statistics table).
     */
    abstract function getStatisticsMigration();

    /**
     * A public method to test the returned migration map array from
     * the getStatisticsMigration() method. Cannot be overwritten.
     *
     * @param array $aMap The migration map array result from calling
     *                    getStatisticsMigration();
     * @return boolean True on the map being valid, false otherwise.
     */
    final public function testStatisticsMigration($aMap)
    {
        // Firstly, test that the migration details map is an array, is
        // not empty, and contains a valid migration method name
        if (is_null($aMap) || !is_array($aMap) || count($aMap) == 0) {
            return false;
        }
        if (is_null($aMap['method'])) {
            return false;
        }
        if ($aMap['method'] == 'aggregate') {
            return $this->_testStatisticsMigrationAggregate($aMap);
        } else if ($aMap['method'] == 'raw') {
            return $this->_testStatisticsMigrationRaw($aMap);
        } else if ($aMap['method'] == 'rawSupplementary') {
            return $this->_testStatisticsMigrationRawSupplementary($aMap);
        } else if ($aMap['method'] == 'custom') {
            return $this->_testStatisticsMigrationCustom($aMap);
        }
        return false;
    }

    /**
     * A private method to test the returned migration map array from
     * the getStatisticsMigration() method for plugins that require
     * the migration of aggregate data. Cannot be overwritten.
     *
     * @access private
     * @param array $aMap The migration map array result from calling
     *                    getStatisticsMigration();
     * @return boolean True on the map being valid, false otherwise.
     */
    final private function _testStatisticsMigrationAggregate($aMap)
    {
        // Must have a valid "bucketTable" value
        if (!$this->_testMigrationValidTableOrColumn($aMap['bucketTable'])) {
            return false;
        }

        // Must have a valid "dateTimeColumn" value
        if (!$this->_testMigrationValidTableOrColumn($aMap['dateTimeColumn'])) {
            return false;
        }

        // Must have valid "groupSource" and "groupDestination" arrays
        if (!$this->_testValidNotNullArray($aMap['groupSource'])) {
            return false;
        }
        if (!$this->_testValidNotNullArray($aMap['groupDestination'])) {
            return false;
        }

        // There must be the same number of entries in the "groupSource" and "groupDestination"
        // arrays, and the indexes used should match
        if (!$this->_testValidArrayKeys($aMap['groupSource'], $aMap['groupDestination'])) {
            return false;
        }

        // Must have valid "sumSource" and "sumDestination" arrays
        if (!$this->_testValidNotNullArray($aMap['sumSource'])) {
            return false;
        }
        if (!$this->_testValidNotNullArray($aMap['sumDestination'])) {
            return false;
        }

        // There must be the same number of entries in the "sumSource" and "sumDestination"
        // arrays, and the indexes used should match
        if (!$this->_testValidArrayKeys($aMap['sumSource'], $aMap['sumDestination'])) {
            return false;
        }

        // There must be the same number of entries in the "sumSource" and "sumDefault"
        // arrays, and the indexes used should match
        if (!$this->_testValidArrayKeys($aMap['sumSource'], $aMap['sumDefault'])) {
            return false;
        }

        // Everything looks okay!
        return true;
    }

    /**
     * A private method to test the returned migration map array from
     * the getStatisticsMigration() method for plugins that require
     * the migration of raw data. Cannot be overwritten.
     *
     * @access private
     * @param array $aMap The migration map array result from calling
     *                    getStatisticsMigration();
     * @return boolean True on the map being valid, false otherwise.
     */
    final private function _testStatisticsMigrationRaw($aMap)
    {
        // Must have a valid "bucketTable" value
        if (!$this->_testMigrationValidTableOrColumn($aMap['bucketTable'])) {
            return false;
        }

        // Must have a valid "dateTimeColumn" value
        if (!$this->_testMigrationValidTableOrColumn($aMap['dateTimeColumn'])) {
            return false;
        }

        // Must have valid "source" and "destination" arrays
        if (!$this->_testValidNotNullArray($aMap['source'])) {
            return false;
        }
        if (!$this->_testValidNotNullArray($aMap['destination'])) {
            return false;
        }

        // There must be the same number of entries in the "source" and "destination"
        // arrays, and the indexes used should match
        if (!$this->_testValidArrayKeys($aMap['source'], $aMap['destination'])) {
            return false;
        }

        // Must have valid "extrasDestination" and "extrasValue" arrays
        if (!$this->_testValidArray($aMap['extrasDestination'])) {
            return false;
        }
        if (!$this->_testValidArray($aMap['extrasValue'])) {
            return false;
        }

        // There must be the same number of entries in the "extrasDestination" and "extrasValue"
        // arrays, and the indexes used should match
        if (!$this->_testValidArrayKeys($aMap['extrasDestination'], $aMap['extrasValue'])) {
            return false;
        }

        // Everything looks okay!
        return true;
    }

    /**
     * A private method to test the returned migration map array from
     * the getStatisticsMigration() method for plugins that require
     * the migration of supplementary raw data. Cannot be overwritten.
     *
     * @access private
     * @param array $aMap The migration map array result from calling
     *                    getStatisticsMigration();
     * @return boolean True on the map being valid, false otherwise.
     */
    final private function _testStatisticsMigrationRawSupplementary($aMap)
    {
        // Must have a valid "masterTable" value
        if (!$this->_testMigrationValidTableOrColumn($aMap['masterTable'])) {
            return false;
        }

        // Must have valid "masterTablePrimaryKeys" and "bucketTablePrimaryKeys" arrays
        if (!$this->_testValidNotNullArray($aMap['masterTablePrimaryKeys'])) {
            return false;
        }
        if (!$this->_testValidNotNullArray($aMap['bucketTablePrimaryKeys'])) {
            return false;
        }

        // There must be the same number of entries in the "masterTablePrimaryKeys" and "bucketTablePrimaryKeys"
        // arrays, and the indexes used should match
        if (!$this->_testValidArrayKeys($aMap['masterTablePrimaryKeys'], $aMap['bucketTablePrimaryKeys'])) {
            return false;
        }

        // Must have valid "masterTableKeys" and "bucketTableKeys" arrays
        if (!$this->_testValidNotNullArray($aMap['masterTableKeys'])) {
            return false;
        }
        if (!$this->_testValidNotNullArray($aMap['bucketTableKeys'])) {
            return false;
        }

        // There must be the same number of entries in the "masterTableKeys" and "bucketTableKeys"
        // arrays, and the indexes used should match
        if (!$this->_testValidArrayKeys($aMap['masterTableKeys'], $aMap['bucketTableKeys'])) {
            return false;
        }

        // Must have a valid "masterDateTimeColumn" value
        if (!$this->_testMigrationValidTableOrColumn($aMap['masterDateTimeColumn'])) {
            return false;
        }

        // Must have a valid "bucketTable" value
        if (!$this->_testMigrationValidTableOrColumn($aMap['bucketTable'])) {
            return false;
        }

        // Must have valid "source" and "destination" arrays
        if (!$this->_testValidNotNullArray($aMap['source'])) {
            return false;
        }
        if (!$this->_testValidNotNullArray($aMap['destination'])) {
            return false;
        }

        // There must be the same number of entries in the "source" and "destination"
        // arrays, and the indexes used should match
        if (!$this->_testValidArrayKeys($aMap['source'], $aMap['destination'])) {
            return false;
        }

        // Everything looks okay!
        return true;

    }

    /**
     * A private method to test the returned migration map array from
     * the getStatisticsMigration() method for plugins that require
     * custom migration of bucket data. Cannot be overwritten.
     *
     * @access private
     * @param array $aMap The migration map array result from calling
     *                    getStatisticsMigration();
     * @return boolean True on the map being valid, false otherwise.
     */
    final private function _testStatisticsMigrationCustom($aMap)
    {
        // Must have a valid "bucketTable" value
        if (!$this->_testMigrationValidTableOrColumn($aMap['bucketTable'])) {
            return false;
        }

        // Must have a valid "dateTimeColumn" value
        if (!$this->_testMigrationValidTableOrColumn($aMap['dateTimeColumn'])) {
            return false;
        }

        // Everything looks okay!
        return true;
    }

    /**
     * A private method to test if a value is valid to use as a table
     * or column name.
     *
     * @access private
     * @param mixed $value A potential database table or column name.
     * @return boolean True if the value supplied is okay to use as a
     *                 table or column name - but does not test if the
     *                 table or column actually exists!
     */
    final private function _testMigrationValidTableOrColumn($value)
    {
        if (is_null($value) || !is_string($value)) {
            return false;
        }
        return true;
    }

    /**
     * A private method to test if an array map of columns is valid,
     * where that array map must contain at least ONE value.
     *
     * @access private
     * @param array $aArray The array of columns.
     * @return boolean True if the array is valid, false otherwise.
     */
    final private function _testValidNotNullArray($aArray)
    {
        if (!$this->_testValidArray($aArray)) {
            return false;
        }
        if (empty($aArray)) {
            return false;
        }
        return true;
    }

    /**
     * A private method to test if an array map of columns is valid,
     * where that array may may be empty.
     *
     * @access private
     * @param array $aArray The array of columns.
     * @return boolean True if the array is valid, false otherwise.
     */
    final private function _testValidArray($aArray)
    {
        if (is_null($aArray) || !is_array($aArray)) {
            return false;
        }
        foreach ($aArray as $key => $value) {
            if (!is_int($key)) {
                return false;
            }
            if (!is_string($value)) {
                return false;
            }
        }
        return true;
    }

    /**
     * A private method to test is two arrays of map of columns have
     * not only the same number of values in each array, but also the
     * same index keys.
     *
     * @access private
     * @param array $aArray1 The first array to compare.
     * @param array $aArray2 The second array to compare.
     * @return boolean True when both arrays have the same number of
     *                 items, and when the index keys are the same;
     *                 false otherwise.
     */
    final private function _testValidArrayKeys($aArray1, $aArray2)
    {
        if (count($aArray1) != count($aArray2)) {
            return false;
        }
        $aKeys1 = array();
        foreach ($aArray1 as $key => $value) {
            $aKeys1[] = $key;
        }
        $aKeys2 = array();
        foreach ($aArray2 as $key => $value) {
            $aKeys2[] = $key;
        }
        asort($aKeys1);
        asort($aKeys2);
        if ($aKeys1 !== $aKeys2) {
            return false;
        }
        return true;
    }

    /**
     * Debugging
     *
     * @param string $msg  Debugging message
     * @param int $err  Type of message (PEAR_LOG_INFO, PEAR_LOG_ERR, PEAR_LOG_WARN)
     */
    function _logMessage($msg, $err=PEAR_LOG_INFO)
    {
        OA::debug($msg, $err);
    }

    /**
     * Debugging - error messages
     *
     * @param string $msg  Debugging message
     */
    function _logError($msg)
    {
        $this->aErrors[] = $msg;
        $this->_logMessage($msg, PEAR_LOG_ERR);
    }

    /**
     * A method to return the date/time of the earliest logged data
     * known to the group.
     *
     * @param string $sDateTimeColumn Optional name of the column in the plugin
     *                                group's bucket table that contains the
     *                                date/time of the logged data data; by
     *                                default, uses "interval_start".
     * @return mixed A PEAR::Date object of the earliest known logged
     *               data for the plugin group, otherwise, null if no
     *               data has been logged.
     */
    public function getEarliestLoggedDataDate($sDateTimeColumn = 'interval_start')
    {
        // Test to ensure that the "$sDateTimeColumn" column really
        // is in the plugin group's bucket table, and if it's not,
        // return null
        $aColumns = $this->getBucketTableColumns();
        if (!array_key_exists($sDateTimeColumn, $aColumns)) {
            return null;
        }
        // Obtain the DB_DataObject for the plugin group's bucket table
        $sBucketName = $this->getBucketName();
        $doBucket = OA_Dal::factoryDO($sBucketName);
        if (!$doBucket) {
            return null;
        }
        // Set the correct order and limit
        $doBucket->orderBy("$sDateTimeColumn ASC");
        $doBucket->limit(1);
        // Locate the date/time of the earliest logged data in the bucket
        $doBucket->find();
        if ($doBucket->getRowCount() == 0) {
            return null;
        }
        $doBucket->fetch();
        $sDateTime = $doBucket->$sDateTimeColumn;
        $oDate = new Date($sDateTime);
        return $oDate;
    }

    /**
     * A method to delegate the processing of the bucket to the appropriate
     * strategy object.
     *
     * @param Date $intervalStart Process up to this interval_start date/time (inclusive).
     */
    public function processBucket($oEnd)
    {
        $this->oProcessingStrategy->processBucket($this, $oEnd);
    }

    /**
     * A method to delegate the pruning of the bucket to the appropriate
     * strategy object.
     *
     * @param Date $oEnd   Prune until this interval_start (inclusive).
     * @param Date $oStart Only prune before this interval_start date (inclusive)
     *                     as well. Optional.
     * @return mixed Either the number of rows pruned, or an MDB2_Error objet.
     */
    public function pruneBucket($oEnd, $oStart = null)
    {
        return $this->oProcessingStrategy->pruneBucket($this, $oEnd, $oStart);
    }

}

?>