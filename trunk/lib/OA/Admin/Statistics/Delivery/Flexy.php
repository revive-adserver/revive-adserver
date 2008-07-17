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

require_once MAX_PATH . '/lib/OA/Admin/Statistics/Common.php';

/**
 * A class of helper methods that can be called from the delivery statistics
 * Flexy templates to help display the required data.
 *
 * @package    OpenXAdmin
 * @subpackage StatisticsDelivery
 * @author     Matteo Beccati <matteo@beccati.com>
 * @author     Andrew Hill <andrew.hill@openx.org>
 */
class OA_Admin_Statistics_Delivery_Flexy extends OA_Admin_Statistics_Common
{

    /**
     * A Flexy helper method to inspect an entity array and the
     * current $this->aColumnLinks array, and determine if an
     * URI link exists for the entity, and, if so, return it.
     *
     * @param array   $aEntity The entity array, possibly with the
     *                         'linkparams' element set.
     * @param string  $column  The name of the column to inspect
     *                         in the $this->aColumnLinks array to
     *                         see if a link is associated with the
     *                         entity item.
     * @return string The link associated with the entity/column,
     *                if applicable.
     */
    function showColumnLink($aEntity, $column)
    {
        if (empty($this->aColumnLinks[$column]) || empty($aEntity['linkparams'])) {
            return '';
        }
        return $this->aColumnLinks[$column];
    }

}

?>