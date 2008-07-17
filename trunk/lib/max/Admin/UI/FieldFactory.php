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

require_once MAX_PATH . '/lib/max/Admin/UI/Field/AdvertiserIdField.php';
require_once MAX_PATH . '/lib/max/Admin/UI/Field/CampaignSelectionField.php';
require_once MAX_PATH . '/lib/max/Admin/UI/Field/ChannelIdField.php';
require_once MAX_PATH . '/lib/max/Admin/UI/Field/DaySpanField.php';
require_once MAX_PATH . '/lib/max/Admin/UI/Field/DropdownField.php';
require_once MAX_PATH . '/lib/max/Admin/UI/Field/OrganisationSelectionField.php';
require_once MAX_PATH . '/lib/max/Admin/UI/Field/PublisherIdField.php';
require_once MAX_PATH . '/lib/max/Admin/UI/Field/SheetSelectionField.php';
require_once MAX_PATH . '/lib/max/Admin/UI/Field/TextField.php';
require_once MAX_PATH . '/lib/max/Admin/UI/Field/TrackerField.php';
require_once MAX_PATH . '/lib/max/Admin/UI/Field/ZoneIdField.php';
require_once MAX_PATH . '/lib/max/Admin/UI/Field/ZoneScopeField.php';

/**
 * Report field factory class for Openads
 *
 * @package    Max
 * @author     Scott Switzer <scott@switzer.org>
 */
class FieldFactory
{

    /**
     * Creates a new Field object of the appropriate subclass.
     *
     * @param string $fieldType The type of field to create.
     * @return Admin_UI_Field An instance of the correct {@link Admin_UI_Field} subclass.
     */
    function &newField($fieldType)
    {
        switch ($fieldType) {
            case 'advertiser':           $oField = new Admin_UI_AdvertiserIdField(); break;
            case 'affiliateid-dropdown': $oField = new Admin_UI_PublisherIdField(); break;
            case 'campaignid-dropdown':  $oField = new Admin_UI_CampaignSelectionField(); break;
            case 'clientid-dropdown':    $oField = new Admin_UI_AdvertiserIdField(); break;
            case 'channelid-dropdown':   $oField = new Admin_UI_ChannelIdField(); break;
            case 'date-month':           $oField = new Admin_UI_DaySpanField(); break;
            case 'day-span':             $oField = new Admin_UI_DaySpanField(); break;
            case 'day-span-selector':    $oField = new Admin_UI_DaySpanField(); break;
            case 'dropdown':             $oField = new Admin_UI_DropdownField(); break;
            case 'edit':                 $oField = new Admin_UI_TextField(); break;
            case 'publisher':            $oField = new Admin_UI_PublisherIdField(); break;
            case 'scope':                $oField = new Admin_UI_OrganisationSelectionField(); break;
            case 'sheet':                $oField = new Admin_UI_SheetSelectionField(); break;
            case 'trackerid-dropdown':   $oField = new Admin_UI_TrackerField(); break;
            case 'zone-scope':           $oField = new Admin_UI_ZoneScopeField(); break;
            case 'zoneid-dropdown':      $oField = new Admin_UI_ZoneIdField(); break;
            default:                     MAX::raiseError("The report module discovered a field type that it didn't know how to handle.", MAX_ERROR_INVALIDARGS);
        }
        return $oField;
    }

}

?>
