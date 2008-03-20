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

require_once MAX_PATH . '/lib/OA/DB/Charset.php';

/**
 * An class defining the methods to deal with database charsets in MySQL
 *
 * Note: Charset support has been added in MySQL 4.1.2
 *
 * @package    OpenXDB
 * @subpackage Charset
 * @author     Matteo Beccati <matteo.beccati@openx.org>
 */
class OA_DB_Charset_mysql extends OA_DB_Charset
{
    /**
     * Class constructor
     *
     * @param MDB2_Driver_Common $oDbh
     * @return OA_DB_Charset
     */
    function OA_DB_Charset_mysql(&$oDbh)
    {
        parent::OA_DB_Charset($oDbh);

        $aVersion = $this->oDbh->getServerVersion();
        if (version_compare($aVersion['native'], '4.1.2', '<')) {
            $this->oDbh = null;
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
