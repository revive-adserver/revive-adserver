<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2007 Openads Limited                                   |
| For contact details, see: http://www.openads.org/                         |
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

require_once MAX_PATH . '/plugins/statisticsFieldsTargeting/statisticsFieldsTargeting.php';
require_once MAX_PATH . '/lib/max/Plugin/Translation.php';

/**
 * The default targeting statistics fields plugin.
 *
 * @abstract
 * @package    OpenadsPlugin
 * @subpackage StatisticsFields
 * @author     Andrew Hill <andrew.hill@openads.org>
 */
class Plugins_statisticsFieldsTargeting_default_default extends Plugins_statisticsFieldsTargeting_statisticsFieldsTargeting
{

    /**
     * Constructor
     */
    function Plugins_statisticsFieldsTargeting_default_default()
    {
        // Set ordering to a low value to move columns to the left
        $this->displayOrder = -10;

        // Set module and package because they aren't set when running the constructor method
        $this->module  = 'targetingFields';
        $this->package = 'default';

        $this->_fields = array(
            'id'               => array('name'   => MAX_Plugin_Translation::translate('_ID', $this->module, $this->package),
                                        'short'  => MAX_Plugin_Translation::translate('ID', $this->module, $this->package),
                                        'pref'   => 'gui_column_id',
                                        'ctrl'     => 'StatsByEntityController',
                                        'format' => 'id'),
            'required'         => array('name'   => MAX_Plugin_Translation::translate('_Required', $this->module, $this->package),
                                        'short'  => MAX_Plugin_Translation::translate('Required', $this->module, $this->package),
                                        'pref'   => 'placement_required_impressions',
                                        'active' => true,
                                        'format' => 'default'),
            'requested'        => array('name'   => MAX_Plugin_Translation::translate('_Requested', $this->module, $this->package),
                                        'short'  => MAX_Plugin_Translation::translate('Requested', $this->module, $this->package),
                                        'pref'   => 'placement_requested_impressions',
                                        'active' => true,
                                        'format' => 'default'),
            'zone_forecast'    => array('name'   => MAX_Plugin_Translation::translate('_Zone Forecast', $this->module, $this->package),
                                        'short'  => MAX_Plugin_Translation::translate('Zone Forecast', $this->module, $this->package),
                                        'pref'   => 'zone_forecast_impressions',
                                        'active' => true,
                                        'format' => 'default'),
            'zone_impressions' => array('name'   => MAX_Plugin_Translation::translate('_Zone Impressions', $this->module, $this->package),
                                        'short'  => MAX_Plugin_Translation::translate('Zone Impressions', $this->module, $this->package),
                                        'pref'   => 'zone_actual_impressions',
                                        'format' => 'default')

        );
    }

}

?>