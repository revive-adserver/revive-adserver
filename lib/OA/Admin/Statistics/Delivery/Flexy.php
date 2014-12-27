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

require_once MAX_PATH . '/lib/OA/Admin/Statistics/Common.php';

/**
 * A class of helper methods that can be called from the delivery statistics
 * Flexy templates to help display the required data.
 *
 * @package    OpenXAdmin
 * @subpackage StatisticsDelivery
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