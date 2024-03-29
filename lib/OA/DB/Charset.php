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

require_once RV_PATH . '/lib/RV.php';

require_once MAX_PATH . '/lib/OA.php';
require_once MAX_PATH . '/lib/OA/DB.php';

/**
 * An abstract class defining the methods to deal with database charsets
 *
 * @package    OpenXDB
 * @subpackage Charset
 */
abstract class OA_DB_Charset
{
    /**
     * @var MDB2_Driver_Common
     */
    public $oDbh;

    /**
     * Class constructor
     *
     * @param MDB2_Driver_Common $oDbh
     * @return OA_DB_Charset
     */
    public function __construct($oDbh)
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
     * @param MDB2_Driver_Common $oDbh
     * @return OA_DB_Charset
     */
    public static function factory(&$oDbh)
    {
        if (!empty($oDbh) && !PEAR::isError($oDbh)) {
            $driver = strtolower($oDbh->dbsyntax);
            $class = 'OA_DB_Charset_' . $driver;
            require_once __DIR__ . '/Charset/' . $driver . '.php';
            return new $class($oDbh);
        }
    }

    /**
     * A method to retrieve the currently used database character set
     *
     * @return mixed A string containing the charset or false if it cannot be retrieved
     */
    abstract public function getDatabaseCharset();

    /**
     * A method to retrieve the currently used client character set
     *
     * @return mixed A string containing the charset or false if it cannot be retrieved
     */
    abstract public function getClientCharset();

    /**
     * A method to retrieve the configuration value for the client charset/encoding
     *
     * @return mixed A string containing the charset or false if no action is needed after connection
     */
    public function getConfigurationValue()
    {
        $databaseCharset = $this->getDatabaseCharset();
        $clientCharset = $this->getClientCharset();

        if (!empty($databaseCharset) && !empty($clientCharset) && $clientCharset != $databaseCharset) {
            return $databaseCharset;
        }

        return false;
    }

    /**
     * A method to set the client charset
     *
     * @param string $charset
     * @return mixed True on success, PEAR_Error otherwise
     */
    abstract public function setClientCharset($charset);
}
