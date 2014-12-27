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
            case 'affiliateid-dropdown':
            case 'publisherid-dropdown': $oField = new Admin_UI_PublisherIdField(); break;
            case 'campaignid-dropdown':  $oField = new Admin_UI_CampaignSelectionField(); break;
            case 'clientid-dropdown':    $oField = new Admin_UI_AdvertiserIdField(); break;
            case 'channelid-dropdown':   $oField = new Admin_UI_ChannelIdField(); break;
            case 'date-month':
            case 'day-span':
            case 'day-span-selector':    $oField = new Admin_UI_DaySpanField(); break;
            case 'dropdown':             $oField = new Admin_UI_DropdownField(); break;
            case 'edit':                 $oField = new Admin_UI_TextField(); break;
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
