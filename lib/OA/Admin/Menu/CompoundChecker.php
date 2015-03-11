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

require_once(MAX_PATH . '/lib/OA/Admin/Menu/IChecker.php');

/**
 * Compound checker whose result is a logical OR / AND between the results of all the
 * enclosed checkers. For OR mode, checking is stopped at first success so invocations should
 * not assume that every checker will be invoked.
 */
class OA_Admin_Menu_Compound_Checker
    implements OA_Admin_Menu_IChecker
{
    var $aCheckers;
    var $mode;

    function __construct($aCheckers = array(), $mode = 'AND')
    {
        $this->aCheckers = $aCheckers;
        $this->mode = $mode;
    }

    function check($oSection)
    {
        $aCheckers = $this->_getCheckers();

        if (empty($aCheckers)) {
            return true;
        }

        $checkOK = false;
        for ($i = 0; $i < count($aCheckers); $i++) {
            $checkOK = $aCheckers[$i]->check($oSection);
            if ($this->mode == 'AND' && !$checkOK) {
                break;
            } elseif ($this->mode == 'OR' && $checkOK) {
                break;
            }
        }

        return $checkOK;
    }

    function _getCheckers()
    {
        return $this->aCheckers;
    }
}

?>