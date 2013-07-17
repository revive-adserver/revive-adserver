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
 * An class defining the methods to deal with database charsets in PgSQL
 *
 * @package    OpenXDB
 * @subpackage Charset
 * @author     Matteo Beccati <matteo.beccati@openx.org>
 */
class OA_DB_Charset_pgsql extends OA_DB_Charset
{
    /**
     * A method to retrieve the currently used database character set
     *
     * @return mixed A string containing the charset or false if it cannot be retrieved
     */
    function getDatabaseCharset()
    {
        if ($this->oDbh) {
            return $this->oDbh->queryOne("SHOW server_encoding", 'text');
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
            return $this->oDbh->queryOne("SHOW client_encoding", 'text');
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
            $pg = $this->oDbh->getConnection();
            if (@pg_set_client_encoding($pg, $charset) == -1) {
                return new PEAR_Error(pg_errormessage($pg));
            }
        }

        return true;
    }
}

?>
