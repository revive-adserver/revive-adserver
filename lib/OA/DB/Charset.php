<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2009 OpenX Limited                                     |
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

require_once MAX_PATH . '/lib/OA.php';
require_once MAX_PATH . '/lib/OA/DB.php';

/**
 * An abstract class defining the methods to deal with database charsets
 *
 * @package    OpenXDB
 * @subpackage Charset
 * @author     Matteo Beccati <matteo.beccati@openx.org>
 */
class OA_DB_Charset
{
    /**
     * @var MDB2_Driver_Common
     */
    var $oDbh;

    /**
     * Class constructor
     *
     * @param MDB2_Driver_Common $oDbh
     * @return OA_DB_Charset
     */
    function OA_DB_Charset(&$oDbh)
    {
        if (!empty($oDbh) && !PEAR::isError($oDbh)) {
            $connection = $oDbh->getConnection();
            if (!empty($connection) && !PEAR::isError($connection)) {
                $this->oDbh = &$oDbh;
            }
        }
    }

    /**
     * A factory method to return the correct subclass depending on the currently used database
     *
     * @static
     *
     * @param MDB2_Driver_Common $oDbh
     * @return OA_DB_Charset
     */
    function &factory(&$oDbh)
    {
        if (!empty($oDbh) && !PEAR::isError($oDbh)) {
            $driver = strtolower($oDbh->dbsyntax);
            $class  = 'OA_DB_Charset_'.$driver;
            require_once dirname(__FILE__).'/Charset/'.$driver.'.php';

            $class = new $class($oDbh);
            return $class;
        }
    }

    /**
     * A method to retrieve the currently used database character set
     *
     * @abstract
     *
     * @return mixed A string containing the charset or false if it cannot be retrieved
     */
    function getDatabaseCharset()
    {
        OA::debug('Cannot run abstract method');
        exit;
    }

    /**
     * A method to retrieve the currently used client character set
     *
     * @abstract
     *
     * @return mixed A string containing the charset or false if it cannot be retrieved
     */
    function getClientCharset()
    {
        OA::debug('Cannot run abstract method');
        exit;
    }

    /**
     * A method to retrieve the configuration value for the client charset/encoding
     *
     * @return mixed A string containing the charset or false if no action is needed after connection
     */
    function getConfigurationValue()
    {
        $databaseCharset = $this->getDatabaseCharset();
        $clientCharset   = $this->getClientCharset();

        if (!empty($databaseCharset) && !empty($clientCharset) && $clientCharset != $databaseCharset) {
            return $clientCharset;
        }

        return false;
    }

    /**
     * A method to set the client charset
     *
     * @abstract
     *
     * @param string $charset
     * @return mixed True on success, PEAR_Error otherwise
     */
    function setClientCharset($charset)
    {
        OA::debug('Cannot run abstract method');
        exit;
    }
}

?>
