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