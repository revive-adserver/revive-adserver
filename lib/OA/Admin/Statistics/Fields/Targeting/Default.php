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
 * The default targeting statistics fields plugin.
 *
 * @abstract
 * @package    OpenXPlugin
 * @subpackage StatisticsFields
 * @author     Andrew Hill <andrew.hill@openx.org>
 */
class OA_StatisticsFieldsTargeting_Default extends OA_StatisticsFieldsDelivery
{

    /**
     * Constructor
     */
    function OA_StatisticsFieldsTargeting_Default()
    {
        // Set ordering to a low value to move columns to the left
        $this->displayOrder = -10;

        // Set module and package because they aren't set when running the constructor method
        /*$this->module  = 'statisticsFieldsTargeting';
        $this->package = 'default';*/

        $this->_aFields = array(
            'placement_required_impressions'  => array('name'   => MAX_Plugin_Translation::translate('_Required', $this->module, $this->package),
                                                       'format' => 'default',
                                                       'active' => false
                                                      ),
            'ad_required_impressions'         => array('name'   => MAX_Plugin_Translation::translate('_Required', $this->module, $this->package),
                                                       'format' => 'default',
                                                       'active' => false
                                                      ),
            'placement_requested_impressions' => array('name'   => MAX_Plugin_Translation::translate('_Requested', $this->module, $this->package),
                                                       'format' => 'default',
                                                       'active' => false
                                                      ),
            'ad_requested_impressions'        => array('name'   => MAX_Plugin_Translation::translate('_Requested', $this->module, $this->package),
                                                       'format' => 'default',
                                                       'active' => false
                                                      ),
            'placement_actual_impressions'    => array('name'   => MAX_Plugin_Translation::translate('_Actual', $this->module, $this->package),
                                                       'format' => 'default',
                                                       'active' => false
                                                      ),
            'ad_actual_impressions'           => array('name'   => MAX_Plugin_Translation::translate('_Actual', $this->module, $this->package),
                                                       'format' => 'default',
                                                       'active' => false
                                                      ),
            'zone_forecast_impressions'       => array('name'   => MAX_Plugin_Translation::translate('_Zone Forecast', $this->module, $this->package),
                                                       'format' => 'default',
                                                       'active' => false
                                                      ),
            'zones_forecast_impressions'      => array('name'   => MAX_Plugin_Translation::translate('_Zones Forecast', $this->module, $this->package),
                                                       'format' => 'default',
                                                       'active' => false
                                                      ),
            'zone_actual_impressions'         => array('name'   => MAX_Plugin_Translation::translate('_Zone Impressions', $this->module, $this->package),
                                                       'format' => 'default',
                                                       'active' => false
                                                      ),
            'zones_actual_impressions'        => array('name'   => MAX_Plugin_Translation::translate('_Zones Impressions', $this->module, $this->package),
                                                       'format' => 'default',
                                                       'active' => false
                                                      ),
            'average'                         => array('name'   => MAX_Plugin_Translation::translate('_Average', $this->module, $this->package),
                                                       'format' => 'boolean',
                                                       'active' => true
                                                      ),
            'target_ratio'                    => array('name'   => MAX_Plugin_Translation::translate('_TargetRatio', $this->module, $this->package),
                                                       'format' => 'percent',
                                                       'active' => true
                                                      )
        );
    }

    /**
     * Generate target ratio
     *
     * @static
     *
     * @param array Row of stats
     */
    function summarizeStats(&$row)
    {
        $row['target_ratio'] = $row['placement_required_impressions'] ?
            $row['placement_actual_impressions'] / $row['placement_required_impressions'] :
            0;
    }
}

?>
