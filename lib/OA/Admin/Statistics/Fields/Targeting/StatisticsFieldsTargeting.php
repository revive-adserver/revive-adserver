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

require_once MAX_PATH . '/lib/OA/Admin/Statistics/Fields/Delivery.php';
require_once MAX_PATH . '/lib/max/Plugin/Translation.php';

/**
 * Plugins_statisticsFieldsTargeting_statisticsFieldsTargeting is an abstract
 * class for every targeting statistics fields plugin.
 *
 * @abstract
 * @package    OpenXPlugin
 * @subpackage StatisticsFields
 * @author     Andrew Hill <andrew.hill@openx.org>
 */
class OA_StatisticsFieldsTargeting extends OA_StatisticsFieldsDelivery
{

    /**
     * A method to prepare the array of columns that should be displayed
     * (ie. not hidden) by the calling OA_Admin_Statistics_Common or child class.
     *
     * Overrides the parent class, as targeting statistics fields cannot be
     * enabled/disabled - instead, visibility is based on the "activity" of
     * the column in the {@link $this->_aFields} array.
     *
     * @return array An array of fields, indexed by "field", giving a true
     *               or false value for display - {@see $this->_aFields}.
     */
    function getVisibleColumns()
    {
        // Get the preferences
        $aColumns = array();
        foreach ($this->_aFields as $k => $v) {
            if ($v['active']) {
                $aColumns[$k] = true;
            } else {
                $aColumns[$k] = false;
            }
        }
        return $aColumns;
    }

    /**
     * A method that returns an array of parameters representing custom columns
     * to use to determine the span of history when displaying targeting statistics.
     *
     * That is, either an empty array if the targeting statistics plugin does not
     * need to alter the stanard span of targeting statistics, or, an array of two
     * elements:
     *
     *      'custom_table'   => The name of the table to look for data in to
     *                          determine if the span of the data to be shown needs
     *                          to be extended beyond the default; and
     *      'custom_columns' => An array of one element, "start_date", which is
     *                          indexed by SQL code that can be run to determine the
     *                          starting date in the span.
     *
     * For example, if you have a custom data table "foo", and the earliest date
     * in this table can be found by using the SQL "SELECT DATE_FORMAT(MIN(bar), '%Y-%m-%d')",
     * then the array to return would be:
     *
     * array(
     *      'custom_table'   => 'foo',
     *      'custom_columns' => array("DATE_FORMAT(MIN(bar), '%Y-%m-%d')" => 'start_date')
     * );
     *
     * @return array As described above.
     */
    function getTargetingSpanParams()
    {
        return array();
    }

}

?>