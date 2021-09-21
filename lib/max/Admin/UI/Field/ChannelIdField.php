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

require_once MAX_PATH . '/lib/max/Admin/UI/Field.php';

class Admin_UI_ChannelIdField extends Admin_UI_Field
{
    public function display()
    {
        echo "
        <select name='{$this->_name}' tabindex='" . ($this->_tabIndex++) . "'>";
        $this->displayChannelsAsOptionList();
        echo "
        </select>";
    }

    public function getChannels()
    {
        global $list_filters;

        if (OA_Permission::isAccount(OA_ACCOUNT_ADMIN)) {
            // set publisher id if list is to be filtered by publisher
            if (isset($list_filters['publisher'])) {
                $aParams = ['publisher_id' => $list_filters['publisher']];
                // get channels owned by this publisher's agency
                $aPublisher = Admin_DA::getPublisher($list_filters['publisher']);
                $agencyId = $aPublisher['agency_id'];
                if ($agencyId != 0) { // check that this publisher actually has an agency
                    $aParams2 = ['agency_id' => $agencyId, 'publisher_id' => 0];
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
            $aParams = ['agency_id' => OA_Permission::getEntityId()];
            // set publisher id if list is to be filtered by publisher
            if (isset($list_filters['publisher'])) {
                $aParams = ['agency_id' => OA_Permission::getEntityId(), 'publisher_id' => $list_filters['publisher']];
            }
            $aChannels = Admin_DA::getChannels($aParams);
            // add agency-owned channels
            $aParams = ['agency_id' => OA_Permission::getEntityId(), 'publisher_id' => 0];
            $aAgencyChannels = Admin_DA::getChannels($aParams);
            foreach ($aAgencyChannels as $channelId => $aAgencyChannel) {
                $aChannels[$channelId] = $aAgencyChannel;
            }
        } elseif (OA_Permission::isAccount(OA_ACCOUNT_TRAFFICKER)) {
            $aParams = ['publisher_id' => OA_Permission::getEntityId()];
            $aPublishers = Admin_DA::getPublishers($aParams);
            $aParams = ['publisher_id' => implode(',', array_keys($aPublishers))];
            $aChannels = Admin_DA::getChannels($aParams);
            // get channels owned by this publisher's agency
            $aPublisher = Admin_DA::getPublisher(OA_Permission::getEntityId());
            $agencyId = $aPublisher['agency_id'];
            if ($agencyId != 0) { // check that this publisher actually has an agency
                $aParams2 = ['agency_id' => $agencyId, 'publisher_id' => 0];
                $aAgencyChannels = Admin_DA::getChannels($aParams2);
            }
            // add agency-owned channels
            if (isset($aAgencyChannels)) {
                foreach ($aAgencyChannels as $channelId => $aAgencyChannel) {
                    $aChannels[$channelId] = $aAgencyChannel;
                }
            }
        } else {
            $aPublishers = [];
            $aChannels = [];
        }

        // add admin-owned channels
        if (OA_Permission::isAccount(OA_ACCOUNT_ADMIN) ||
            OA_Permission::isAccount(OA_ACCOUNT_MANAGER) ||
            OA_Permission::isAccount(OA_ACCOUNT_TRAFFICKER)) {
            // add admin-owned channels
            $aParams = ['agency_id' => 0, 'publisher_id' => 0];
            $aAdminChannels = Admin_DA::getChannels($aParams);
            foreach ($aAdminChannels as $channelId => $aAdminChannel) {
                $aChannels[$channelId] = $aAdminChannel;
            }
        }

        $aChannelArray = [];
        foreach ($aChannels as $channelId => $aChannel) {
            $aChannelArray[$channelId] = phpAds_buildName($channelId, $aChannel['name']);
        }
        return $aChannelArray;
    }

    public function displayChannelsAsOptionList()
    {
        $aChannels = $this->getChannels();
        foreach ($aChannels as $channelId => $aChannel) {
            $selected = $channelId == $this->getValue() ? " selected='selected'" : '';
            echo "<option value='$channelId'$selected>$aChannel</option>";
        }
    }
}
