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

require_once MAX_PATH . '/lib/OA/DB/Charset.php';

/**
 * An class defining the methods to deal with database charsets in MySQL
 *
 * Note: Charset support has been added in MySQL 4.1.2
 *
 * @package    OpenXDB
 * @subpackage Charset
 */
class OA_DB_Charset_mysql extends OA_DB_Charset
{
    /**
     * Class constructor
     *
     * @param MDB2_Driver_Common $oDbh
     * @return OA_DB_Charset
     */
    function __construct(&$oDbh)
    {
        $aVersion = $oDbh->getServerVersion();
        if (version_compare($aVersion['native'], '4.1.2', '>=')) {
            parent::__construct($oDbh);
        }
    }

    /**
     * A method to retrieve the currently used database character set
     *
     * @return mixed A string containing the charset or false if it cannot be retrieved
     */
    function getDatabaseCharset()
    {
        if ($this->oDbh) {
            return $this->oDbh->queryOne("SHOW VARIABLES LIKE 'character_set_database'", 'text', 1);
        }

        return false;
    }

    /**
     * A method to retrieve the currently used client character set
     *
     * @return mixed A string containing the charset or false if it cannot be retrieved
     */
    function getClientCharset()
    {
        if ($this->oDbh) {
            return $this->oDbh->queryOne("SHOW VARIABLES LIKE 'character_set_client'", 'text', 1);
        }

        return false;
    }

    /**
     * A method to set the client charset
     *
     * @param string $charset
     * @return mixed True on success, PEAR_Error otherwise
     */
    function setClientCharset($charset)
    {
        if (!empty($charset) && $this->oDbh) {
            $charset = $this->oDbh->quote($charset);
            $success = $this->oDbh->exec("SET NAMES $charset");
            if (PEAR::isError($success)) {
                return $success;
            }
        }

        return true;
    }
}

?>
