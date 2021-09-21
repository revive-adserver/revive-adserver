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
class OA_Admin_Menu_Compound_Checker implements OA_Admin_Menu_IChecker
{
    public $aCheckers;
    public $mode;

    public function __construct($aCheckers = [], $mode = 'AND')
    {
        $this->aCheckers = $aCheckers;
        $this->mode = $mode;
    }

    public function check($oSection)
    {
        $aCheckers = $this->_getCheckers();

        if (empty($aCheckers)) {
            return true;
        }

        $checkOK = false;
        foreach ($aCheckers as $i => $aChecker) {
            $checkOK = $aChecker->check($oSection);
            if ($this->mode == 'AND' && !$checkOK) {
                break;
            } elseif ($this->mode == 'OR' && $checkOK) {
                break;
            }
        }

        return $checkOK;
    }

    public function _getCheckers()
    {
        return $this->aCheckers;
    }
}
