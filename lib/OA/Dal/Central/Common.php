<?php

/*
+---------------------------------------------------------------------------+
| OpenX  v${RELEASE_MAJOR_MINOR}                                                              |
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

require_once MAX_PATH.'/lib/OA.php';
require_once MAX_PATH.'/lib/OA/Dal.php';


/**
 * Dal methods for the common OAC API
 *
 */
class OA_Dal_Central_Common
{
    /**
     * @var MDB2_Driver_Common
     */
    var $oDbh;

    /**
     * @var boolean
     */
    var $hasTransactions;

    /**
     * The class constructor
     *
     * @return OA_Dal_Central_AdNetworks
     */
    function OA_Dal_Central_Common()
    {
        $this->oDbh = OA_DB::singleton();
        $this->hasTransactions = $this->oDbh->supports('transactions');
    }

    function beginTransaction()
    {
        if ($this->hasTransactions) {
            $result = $this->oDbh->beginTransaction();

            return !PEAR::isError($result) ;
        }

        return true;
    }

    function commit()
    {
        if ($this->hasTransactions) {
            $result = $this->oDbh->commit();

            return !PEAR::isError($result) ;
        }

        return true;
    }

    function rollback()
    {
        if ($this->hasTransactions) {
            $this->oDbh->rollback();

            return true;
        }

        return false;
    }

    function rollbackAndReturnFalse()
    {
        $this->rollback();

        return false;
    }
}

?>