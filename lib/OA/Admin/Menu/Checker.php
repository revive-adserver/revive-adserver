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

/**
 * Compound checker whose result is a logical OR between the results of all the
 * enclosed checkers. Checking is stopped at first success so invocations should
 * not assume that every checker will be invoked.
 */
class OA_Admin_Menu_Checker
{
    var $aCheckers;
    var $mode;

    function OA_Admin_Menu_Checker($aCheckers = array(), $mode = 'AND')
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
            } elseif ($checkOK) {
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