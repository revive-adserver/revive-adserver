<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
| For contact details, see: http://www.openx.org/                           |
|                                                                           |
| This program is free software; you can redistribute it and/or modify      |
| it under the terms of the GNU General Public License as published by      |
| the Free Software Foundation; either version 2 of the License, or         |
| (at your option) any later version.                                       |
|                                                                           |
| This program is distributed in the hope that it will be useful,           |
| but WITHOUT ANY WARRANTY; without even the implied warranty of            |
| MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             |
| GNU General Public License for more details.                              |
|                                                                           |
| You should have received a copy of the GNU General Public License         |
| along with this program; if not, write to the Free Software               |
| Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA |
+---------------------------------------------------------------------------+
$Id$
*/

require_once MAX_PATH . '/lib/OX/Plugin/Component.php';

/**
 * Abstract DeliveryLog class.
 *
 * Keeps additional information about components from deliveryLog extension.
 *
 * @package    OpenXPlugin
 * @subpackage Plugins_DeliveryLog
 * @author     Radek Maciaszek <radek.maciaszek@openx.org>
 */
abstract class Plugins_DeliveryLog_LogCommon extends OX_Component
{
    // @todo - add database specific mapping in db layer
    const TIMESTAMP_WITHOUT_ZONE = 'timestamp without time zone';
    const INTEGER = 'integer';
    const CHAR = 'char';

    const COUNT_COLUMN = 'count';

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
     * Factory methods which creates a specific db type layer for installing plugins.
     *
     * @param string $dbType  By default it reads the db type from default connection
     * @return
     */
    function factoryDBLayer($dbType = null)
    {
        if (is_null($dbType)) {
            $oDbh = OA_DB::singleton();
            $dbType = $oDbh->dsn['phptype'];
        }

        if(!$this->_includeDbLayerFile($oDbh->dsn['phptype'])) {
            $this->_logError('Error when including db layer: '.$dbType);
            return false;
        }
        $className = 'Plugins_DeliveryLog_DB_'.ucfirst($oDbh->dsn['phptype']);
        if (!class_exists($className)) {
            $this->_logError('Db layer class doesn\' exist: '.$className);
            return false;
        }
        return new $className();
    }

    function _includeDbLayerFile($dbType)
    {
        $file = MAX_PATH . '/extensions/deliveryLog/DB_'.ucfirst($dbType).'.php';
        if (!file_exists($file)) {
            return false;
        }
        include_once $file;
        return true;
    }

    /**
     * Carry on any additional post-installs actions
     * (for example install postgres specific stored procedures)
     *
     * @return boolean  True on success otherwise false
     */
    public function onInstall()
    {
        $dbLayer = $this->factoryDBLayer();
        if (!$dbLayer || !$dbLayer->install($this)) {
            return false;
        }
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
     * Returns prefixed table bucket name
     *
     * @return string  Table bucket name with added prefix
     */
    public function getTableBucketName()
    {
        return OA_Dal::getTablePrefix() . $this->getBucketName();
    }

    /**
     * Returns the table bucket columns.
     *
     * @return array  Format: array(column name => column type, ...)
     */
    abstract public function getTableBucketColumns();

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
}

?>