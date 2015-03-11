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

require_once MAX_PATH . '/lib/OA.php';
require_once MAX_PATH . '/lib/OA/DB.php';

/**
 * An abstract class defining the methods to deal with database charsets
 *
 * @package    OpenXDB
 * @subpackage Charset
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
    function __construct(&$oDbh)
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
