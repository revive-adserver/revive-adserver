<?php

/*
+---------------------------------------------------------------------------+
| Max Media Manager v0.3                                                    |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2006 m3 Media Services Limited                         |
| For contact details, see: http://www.m3.net/                              |
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
$Id: OperationInverval.php 5580 2006-10-06 09:57:22Z andrew@m3.net $
*/

require_once MAX_PATH . '/lib/max/core/ServiceLocator.php';

/**
 * A library class for providing common maintenance process methods.
 *
 * @static
 * @package    Max
 * @author     Andrew Hill <andrew@m3.net>
 */
class MAX_Maintenance
{

    /**
     * A method for premaring e-mails, advising of the activation of campaigns.
     *
     * @static
     * @param string $contactName The name of the campaign contact.
     * @param string $campaignName The name of the deactivated campaign.
     * @param array $ads A reference to an array of ads
     *                              in the campaign, indexed by ad_id,
     *                              of an array containing the description, alt
     *                              description, and  destination URL of the
     *                              ad.
     * @return string The email that has been prepared.
     */
    function prepareActivateCampaignEmail($contactName, $campaignName, &$ads)
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        $message  = "Dear $contactName,\n\n";
        $message .= 'The following ads have been activated because ' . "\n";
        $message .= 'the campaign activation date has been reached.';
        $message .= "\n\n";
        $message .= "-------------------------------------------------------\n";
        foreach ($ads as $ad_id => $data) {
            $message .= "Ad [ID $ad_id] ";
            if ($data[0] != '') {
                $message .= $data[0];
            } elseif ($data[1] != '') {
                $message .= $data[1];
            } else {
                $message .= 'Untitled';
            }
            $message .= "\n";
            $message .= "Linked to: {$data[2]}\n";
            $message .= "-------------------------------------------------------\n";
        }
        $message .= "\nThank you for advertising with us.\n\n";
        $message .= "Regards,\n\n";
        $message .= $conf['email']['admin_name'];
        return $message;
    }

    /**
     * A method for preparing e-mails, advising of the deactivation of campaigns.
     *
     * @static
     * @param string $contactName The name of the campaign contact.
     * @param string $campaignName The name of the deactivated campaign.
     * @param integer $reason A binary flag field containting the reason(s) the campaign
     *                        was deactivated:
     *                        2  - No more impressions
     *                        4  - No more clicks
     *                        8  - No more conversions
     *                        16 - Campaign ended (due to date)
     * @param array $ads A reference to an array of ads
     *                              in the campaign, indexed by ad_id,
     *                              of an array containing the description, alt
     *                              description, and  destination URL of the
     *                              ad.
     * @return string The email that has been prepared.
     */
    function prepareDeactivateCampaignEmail($contactName, $campaignName, $reason, &$ads)
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        $message  = "Dear $contactName,\n\n";
        $message .= 'The following ads have been disabled because:' . "\n";
        if ($reason & MAX_PLACEMENT_DISABLED_IMPRESSIONS) {
            $message .= '  - There are no impressions remaining' . "\n";
        }
        if ($reason & MAX_PLACEMENT_DISABLED_CLICKS) {
            $message .= '  - There are no clicks remaining' . "\n";
        }
        if ($reason & MAX_PLACEMENT_DISABLED_CONVERSIONS) {
            $message .= '  - There are no conversions remaining' . "\n";
        }
        if ($reason & MAX_PLACEMENT_DISABLED_DATE) {
            $message .= '  - The campaign deactivation date has been reached' . "\n";
        }
        $message .= "\n";
        $message .= '-------------------------------------------------------' . "\n";
        foreach ($ads as $ad_id => $data) {
            $message .= "Ad [ID $ad_id] ";
            if ($data[0] != '') {
                $message .= $data[0];
            } elseif ($data[1] != '') {
                $message .= $data[1];
            } else {
                $message .= 'Untitled';
            }
            $message .= "\n";
            $message .= "Linked to: {$data[2]}\n";
            $message .= '-------------------------------------------------------' . "\n";
        }
        $message .= "\n" . 'If you would like to continue advertising on our website,' . "\n";
        $message .= 'please feel free to contact us.' . "\n";
        $message .= 'We\'d be glad to hear from you.' . "\n\n";
        $message .= 'Regards,' . "\n\n";
        $message .= "{$conf['email']['admin_name']}";
        return $message;
    }

}

?>
