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

require_once MAX_PATH . '/plugins/reports/Reports.php';

/**
 * Plugins_ReportsScope is an abstract class that extends the interface defined
 * in {@link Plugins_Reports} to add methods for reports that are based on an
 * Admin_UI_OrganisationScope advertiser/publisher limitation object.
 *
 * @abstract
 * @package    MaxPlugin
 * @subpackage Reports
 * @author     Andrew Hill <andrew.hill@openads.org>
 */
class Plugins_ReportsScope extends Plugins_Reports
{

    function _getDisplayableParametersFromScope($oScope)
    {
        $aParams = array();

        $key = MAX_Plugin_Translation::translate('Advertiser', $this->module);
        $advertiserId = $oScope->getAdvertiserId();
        if (!empty($advertiserId)) {
            $advertiser_name = $this->dal->getNameForAdvertiser($advertiserId);
            $aParams[$key] = $advertiser_name;
        } else {
            if ($oScope->getAnonymous()) {
                $aParams[$key] = MAX_Plugin_Translation::translate('Anonymous advertisers', $this->module);
            } else {
                $aParams[$key] = MAX_Plugin_Translation::translate('All advertisers', $this->module);
            }
        }

        $key = MAX_Plugin_Translation::translate('Publisher', $this->module);
        $publisherId = $oScope->getPublisherId();
        if (!empty($publisherId)) {
            $publisher_name = $this->dal->getNameForPublisher($publisherId);
            $aParams[$key] = $publisher_name;
        } else {
            if ($oScope->getAnonymous()) {
                $aParams[$key] = MAX_Plugin_Translation::translate('Anonymous publishers', $this->module);
            } else {
                $aParams[$key] = MAX_Plugin_Translation::translate('All publishers', $this->module);
            }
        }

        return $aParams;
    }

}

?>