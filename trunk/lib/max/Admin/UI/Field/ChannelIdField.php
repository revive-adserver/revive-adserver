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

require_once MAX_PATH . '/lib/max/Dal/Reporting.php';
require_once MAX_PATH . '/lib/max/Admin/UI/Field.php';

class Admin_UI_ChannelIdField extends Admin_UI_Field
{

    function display()
    {
        echo "
        <select name='{$this->_name}' tabindex='".($this->_tabIndex++)."'>";
        $this->displayChannelsAsOptionList();
        echo "
        </select>";
    }

    function getChannels()
    {
        global $list_filters;
    
        if (OA_Permission::isAccount(OA_ACCOUNT_ADMIN)) {
            // set publisher id if list is to be filtered by publisher
            if (isset($list_filters['publisher'])) {
                $aParams = array('publisher_id' => $list_filters['publisher']);
                // get channels owned by this publisher's agency
                $aPublisher = Admin_DA::getPublisher($list_filters['publisher']);
                $agencyId = $aPublisher['agency_id'];
                if ($agencyId != 0) { // check that this publisher actually has an agency
                    $aParams2 = array('agency_id' => $agencyId, 'publisher_id' => 0);
                    $aAgencyChannels = Admin_DA::getChannels($aParams2);
                }
            }
            $aChannels = Admin_DA::getChannels($aParams);
            // add any agency-owned channels
            if (isset($aAgencyChannels)) {
                foreach ($aAgencyChannels as $channelId => $aAgencyChannel) {
                    $aChannels[$channelId] = $aAgencyChannel;
                }
            }
        } elseif (OA_Permission::isAccount(OA_ACCOUNT_MANAGER)) {
            $aParams = array('agency_id' => OA_Permission::getEntityId());
            // set publisher id if list is to be filtered by publisher
            if (isset($list_filters['publisher'])) {
                $aParams = array('agency_id' => OA_Permission::getEntityId(), 'publisher_id' => $list_filters['publisher']);
            }
            $aChannels = Admin_DA::getChannels($aParams);
            // add agency-owned channels
            $aParams = array('agency_id' => OA_Permission::getEntityId(), 'publisher_id' => 0);
            $aAgencyChannels = Admin_DA::getChannels($aParams);
            foreach ($aAgencyChannels as $channelId => $aAgencyChannel) {
                $aChannels[$channelId] = $aAgencyChannel;
            }
        } elseif (OA_Permission::isAccount(OA_ACCOUNT_TRAFFICKER)) {
            $aParams = array('publisher_id' => OA_Permission::getEntityId());
            $aPublishers = Admin_DA::getPublishers($aParams);
            $aParams = array('publisher_id' => implode(',',array_keys($aPublishers)));
            $aChannels = Admin_DA::getChannels($aParams);
            // get channels owned by this publisher's agency
            $aPublisher = Admin_DA::getPublisher(OA_Permission::getEntityId());
            $agencyId = $aPublisher['agency_id'];
            if ($agencyId != 0) { // check that this publisher actually has an agency
                $aParams2 = array('agency_id' => $agencyId, 'publisher_id' => 0);
                $aAgencyChannels = Admin_DA::getChannels($aParams2);
            }
            // add agency-owned channels
            if (isset($aAgencyChannels)) {
                foreach ($aAgencyChannels as $channelId => $aAgencyChannel) {
                    $aChannels[$channelId] = $aAgencyChannel;
                }
            }
        } else {
            $aPublishers = array();
            $aChannels = array();
        }
        
        // add admin-owned channels
        if (OA_Permission::isAccount(OA_ACCOUNT_ADMIN) || 
            OA_Permission::isAccount(OA_ACCOUNT_MANAGER) ||
            OA_Permission::isAccount(OA_ACCOUNT_TRAFFICKER)) {
            // add admin-owned channels
            $aParams = array('agency_id' => 0, 'publisher_id' => 0);
            $aAdminChannels = Admin_DA::getChannels($aParams);
            foreach ($aAdminChannels as $channelId => $aAdminChannel) {
                $aChannels[$channelId] = $aAdminChannel;
            }
         }
        
        $aChannelArray = array();
        foreach ($aChannels as $channelId => $aChannel) {
            $aChannelArray[$channelId] = "[$channelId]" . $aChannel['name'];
        }
        return $aChannelArray;
    }
    
    function displayChannelsAsOptionList()
    {
        $aChannels = $this->getChannels();
        foreach ($aChannels as $channelId => $aChannel) {
            $selected = $channelId == $this->getValue() ? " selected='selected'" : '';
            echo "<option value='$channelId'$selected>$aChannel</option>";
        }
    }
}

?>
