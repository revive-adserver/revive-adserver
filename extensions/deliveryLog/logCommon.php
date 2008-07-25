<?php

require_once MAX_PATH . '/lib/OX/Plugin/Component.php';

abstract class Plugins_DeliveryLog_LogCommon extends OX_Component
{
    const TIMESTAMP_WITHOUT_ZONE = 'timestamp without time zone';
    const INTEGER = 'integer';
    const CHAR = 'char';

    const COUNT_COLUMN = 'count';

    /**
     * Prefix of PostgreSQL stored procedure name which is used
     * to update the table bucket.
     *
     * @var string
     */
    protected $storedProcedurePrefix = 'bucket_update_';

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
     * Carry on any additional post-installs actions
     * (for example install postgres specific stored procedures)
     *
     * @return boolean  True on success otherwise false
     */
    public function onInstall($dbConnection)
    {
        return true;
    }

    /**
     * Carry on any additional post-uninstalls actions
     * (for example uninstall postgres specific stored procedures)
     *
     * @return boolean  True on success otherwise false
     */
    public function onUninstall()
    {
        return true;
    }

    /**
     * Returns the bucket table name
     *
     * @return string  Table bucket name
     */
    abstract function getBucketName();

    /**
     * Returns the table bucket columns.
     *
     * @return array  Format: array(column name => column type, ...)
     */
    abstract public function getTableBucketColumns();

    /**
     * Returns the bucket stored procedure name
     *
     * @return string
     */
    function getStoredProcedureName()
    {
        return $this->storedProcedurePrefix . $this->getBucketName();
    }

    /**
     * Returns the stored procedure query body. Used on install
     * to create required procedures inside postgres database
     *
     * @return string
     */
    function getCreateStoredProcedureQuery()
    {
        $tableName = $this->getBucketName();
        $query = 'CREATE OR REPLACE FUNCTION ' . $this->getStoredProcedureName() . '
            ('.$this->_getColumnTypesList().')
            RETURNS void AS
            $BODY$DECLARE
              x int;
            BEGIN
              LOOP
                -- first try to update
                UPDATE ' . $tableName . ' SET count = count + 1 WHERE '.$this->_getSPWhere().';
                GET DIAGNOSTICS x = ROW_COUNT;
                IF x > 0 THEN
                  RETURN;
                END IF;
                -- not there, so try to insert the key
                -- if someone else inserts the same key concurrently,
                -- we could get a unique-key failure
                BEGIN
                  INSERT INTO ' . $tableName . ' VALUES ('.$this->_getSPValuesList().');
                  RETURN;
                EXCEPTION WHEN unique_violation THEN
                  -- do nothing, and loop to try the UPDATE again
                END;
              END LOOP;
            END$BODY$
            LANGUAGE \'plpgsql\'';
        return $query;
    }

    /**
     * Prepares a list of columnt types. Used by PostgreSQL stored procedure
     *
     * @param array $aIgnore  List of column names to ignore (count is not included by default)
     * @return string  Comma separated ordered list of columns
     */
    protected function _getColumnTypesList($aIgnore = array(self::COUNT_COLUMN))
    {
        $str = '';
        foreach ($this->aTableBucketsColumns as $columnName => $columnType) {
            if (in_array($columnName, $aIgnore)) {
                continue;
            }
            $str .= $columnType . ', ';
        }
        return $str;
    }

    /**
     * Prepares a WHERE query, required by PostgreSQL stored procedure
     *
     * @param array $aIgnore  List of columns to ignore (count is not included by default)
     * @return string  WHERE clause
     */
    protected function _getSPWhere($aIgnore = array(self::COUNT_COLUMN))
    {
        $where = '';
        $c = 1;
        $and = '';
        foreach ($this->aTableBucketsColumns as $columnName => $columnType) {
            if (in_array($columnName, $aIgnore)) {
                continue;
            }
            $where .= $and . $columnName . ' = $' . $c;
            $c++;
        }
        return $where;
    }

    /**
     * Prepares a VALUES part of PostgreSQL stored procedure.
     *
     * @param array $aIgnore  List of columns to ignore (count is not included by default)
     * @return string  Comma separated VALUES list
     */
    protected function _getSPValuesList($aIgnore = array(self::COUNT_COLUMN))
    {
        $values = '';
        $c = 1;
        foreach ($this->aTableBucketsColumns as $column) {
            if (in_array($columnName, $aIgnore)) {
                continue;
            }
            $values .= '$'.$c.', ';
            $comma = ', ';
            $c++;
        }
        $values .= '1';
        return $values;
    }
}

?>