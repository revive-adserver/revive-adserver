<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
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

require_once MAX_PATH . '/lib/OA/Admin/Statistics/Common.php';

/**
 * A class of helper methods that can be called from the targeting statistics
 * Flexy templates to help display the required data.
 *
 * @package    OpenXAdmin
 * @subpackage StatisticsDelivery
 * @author     Matteo Beccati <matteo@beccati.com>
 * @author     Andrew Hill <andrew.hill@openx.org>
 */
class OA_Admin_Statistics_Targeting_Flexy extends OA_Admin_Statistics_Common
{

    /**
     * A Flexy helper method to return the value of a field for display.
     *
     * Overrides the parent Flexy helper method so that it can deal with
     * displaying warnings for average calculations, etc.
     *
     * @param array  $aArray An array of items.
     * @param string $k      The index name of the item to display.
     * @return mixed The item to display.
     */
    function showValue($aArray, $k)
    {
        if ($k == 'average') {
            if ($aArray[$k] === true || (is_numeric($aArray[$k]) && $aArray[$k] > 0)) {
                return '<img src="' . OX::assetPath() . '/images/warning.gif" width="16 height="16" alt="" title="" />';
            } else if (preg_match('/light$/', $aArray[$k])) {
                return parent::showValue($aArray, $k);
            } else if (preg_match('/dark$/', $aArray[$k])) {
                return parent::showValue($aArray, $k);
            } else {
                return '';
            }
        } else {
            return parent::showValue($aArray, $k);
        }
    }

}

?>