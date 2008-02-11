<?php

/*
+---------------------------------------------------------------------------+
| OpenX  v${RELEASE_MAJOR_MINOR}                                                              |
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

require_once MAX_PATH . '/plugins/deliveryLimitations/DeliveryLimitationsCommaSeparatedData.php';

/**
 * A Site delivery limitation plugin, for filtering delivery of ads on the
 * basis of the pre-defined channels.
 *
 * Works with:
 * A comma separated list of channel IDs.
 *
 * Valid comparison operators:
 * ==, =~, !=, !~
 *
 * @package    OpenXPlugin
 * @subpackage DeliveryLimitations
 * @author     Andrew Hill <andrew@m3.net>
 * @author     Chris Nutting <chris@m3.net>
 *
 * @TODO overlap() methods now checks only if there is an overlap of channel ids.
 * Id does not check if contents of different channels overlap.
 */
class Plugins_DeliveryLimitations_Site_Channel extends Plugins_DeliveryLimitations_CommaSeparatedData
{
    var $bannerid;
    var $agencyid;
    var $defaultComparison = '=~';

    function Plugins_DeliveryLimitations_Site_Channel()
    {
        $this->Plugins_DeliveryLimitations_ArrayData();
        $this->aOperations['=='] = MAX_Plugin_Translation::translate(
            'Is all of', $this->module, $this->package);
    }

    /**
     * Return name of plugin
     *
     * @return string
     */
    function getName()
    {
        return MAX_Plugin_Translation::translate('Channel', $this->module, $this->package);
    }


    /**
     * Return if this plugin is available in the current context
     *
     * @return boolean
     */
    function isAllowed($page = false)
    {
        return ($page != 'channel-acl.php');
    }

    /**
     * Outputs the HTML to display the data for this limitation
     *
     * @return void
     */
    function displayArrayData()
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        $this->bannerid = (isset($GLOBALS['bannerid'])) ? $GLOBALS['bannerid'] : 0;
        $tabindex =& $GLOBALS['tabindex'];

        // Get list of all publishers (affiliates) which are linked to the banner
        $aAffiliates = array();
        $query = "
            SELECT
                z.affiliateid AS affiliateid
            FROM
                {$conf['table']['prefix']}{$conf['table']['ad_zone_assoc']} AS aza,
                {$conf['table']['prefix']}{$conf['table']['zones']} AS z
            WHERE
                aza.zone_id = z.zoneid
                AND
                aza.ad_id = " . DBC::makeLiteral($this->bannerid);
        $rsAffiliates = DBC::NewRecordSet($query);
        $rsAffiliates->find();
        while ($rsAffiliates->fetch()) {
            $aAffiliates[] = $rsAffiliates->get('affiliateid');
        }

        // Select the agency ID that owns this banner (it may be the admin ID, 0)
        $query = "
            SELECT
                a.agencyid AS agencyid
            FROM
                {$conf['table']['prefix']}{$conf['table']['banners']} AS b,
                {$conf['table']['prefix']}{$conf['table']['campaigns']} AS m,
                {$conf['table']['prefix']}{$conf['table']['clients']} AS a
            WHERE
                a.clientid = m.clientid
                AND
                m.campaignid = b.campaignid
                AND
                b.bannerid = " . DBC::makeLiteral($this->bannerid);
        $rsAgency = DBC::NewRecordSet($query);
        $rsAgency->find();
        $rsAgency->fetch();
        $this->agencyid = $rsAgency->get('agencyid');

        if (PEAR::isError($this->agencyid)) {
            phpAds_sqlDie();
        }

        $aChannels = array();

        // Get all of the admin channels that could be used for this banner
        $aAdminChannels = Admin_DA::getChannels(array('channel_type' => 'admin'), true);
        foreach ($aAdminChannels as $aChannel) {
            $channelId = $aChannel['channel_id'];
            $aChannels[$channelId] = $aChannel;
        }

        // Get all of the agency channels that could be used for this banner
        if ($this->agencyid != 0) {
            $aAgencyChannels = Admin_DA::getChannels(array('agency_id' => $this->agencyid, 'channel_type' => 'agency'), true);
            foreach ($aAgencyChannels as $aChannel) {
                $channelId = $aChannel['channel_id'];
                $aChannels[$channelId] = $aChannel;
            }
        }

        // Get all of the publisher channels that could be used for this banner
        if ($this->agencyid != 0) {
            $aPublisherChannels = Admin_DA::getChannels(array('agency_id' => $this->agencyid, 'channel_type' => 'publisher'), true);
            foreach ($aPublisherChannels as $aChannel) {
                $channelId = $aChannel['channel_id'];
                $aChannels[$channelId] = $aChannel;
            }
        }

        $aSelectedChannels = array();
        // Sort the list, and move selected items to the top of the list
        usort($aChannels, '_sortByChannelName');
        foreach ($aChannels as $index => $aChannel) {
            if (in_array($aChannel['channel_id'], $this->data)) {
                $aSelectedChannels[$index] = $aChannel;
                unset($aChannels[$index]);
            }
        }
        $aChannels = $aSelectedChannels + $aChannels;
        echo "<div class='box'>";
        foreach ($aChannels as $aChannel) {
            if (!empty($aChannel['publisher_id']) && !in_array($aChannel['publisher_id'], $aAffiliates)) {
                continue;
            }
            if (empty($aChannel['publisher_id'])) {
                $editUrl = "channel-acl.php?agencyid={$this->agencyid}&channelid={$aChannel['channel_id']}";
            } else {
                $editUrl = "channel-acl.php?affiliateid={$aChannel['publisher_id']}&channelid={$aChannel['channel_id']}";
            }
            echo "
                <div class='boxrow'>
                    <input
                        tabindex='".($tabindex++)."'
                        type='checkbox'
                        id='c_{$this->executionorder}_{$aChannel['channel_id']}'
                        name='acl[{$this->executionorder}][data][]'
                        value='{$aChannel['channel_id']}'".(in_array($aChannel['channel_id'], $this->data) ? ' checked="checked"' : '')."
                    />
                    {$aChannel['name']}
                    <a href='{$editUrl}' target='_blank'><img src='images/{$GLOBALS['phpAds_TextDirection']}/go_blue.gif' border='0' align='absmiddle' alt='{$GLOBALS['strView']}'></a>
                </div>";
        }
        echo "</div>";
    }

    /**
     * Returns the compiledlimitation string for this limitation
     *
     * @return string
     */
    function compile()
    {
        switch ($this->comparison) {
            case '==':
                $join = ' && ';
                break;
            case '=~':
                $join = ' || ';
                break;
            case '!~':
                $join = ' || ';
                break;
        }
        $aChannelIds = MAX_limitationsGetAFromS($this->data);
        if (empty($aChannelIds)) {
            return 'true';
        }

        $compile = array();
        foreach ($aChannelIds as $channelId) {
            $compile[] = $this->compileData($channelId);
        }

        $result .= '(' . implode($join, $compile) . ')';
        if ('!~' == $this->comparison) {
            $result = '!' . $result;
        }
        return $result;
    }

    /**
     * A private method to return this delivery limitation plugin as a SQL limiation.
     *
     * Always returns false, as never need to convert a channel delivery limiation plugin
     * into SQL - only ever convert the channel delivery limitation's consituent parts;
     * and a channel delivery limitations CANNOT contain another channel delivery limtiation.
     *
     * @access private
     * @param string $comparison As for Plugins_DeliveryLimitations::_getSqlLimitation(),
     *                           but only '=', '!=', '=~' and '!~' permitted.
     * @param string $data The channel data.
     * @return boolean False.
     */
    function _getSqlLimitation($comparison, $data)
    {
        return false;
    }

    /**
     * A method to compare two comparison and data groups of the same delivery
     * limitation type, and determine if the delivery limitations have any
     * overlap, or not.
     *
     * @param array $aLimitation1 An array containing the "comparison" and "data"
     *                            fields of the first delivery limitation.
     * @param array $aLimitation2 An array containing the "comparison" and "data"
     *                            fields of the second delivery limitation.
     * @return boolean True if there is overlap between the two delivery limitations,
     *                 false if there is NOT any overlap.
     */
    function overlap($aLimitation1, $aLimitation2)
    {
        $op1 = $aLimitation1['comparison'];
        $aChannelIds1 = MAX_limitationsGetAFromS($aLimitation1['data']);
        $op2 = $aLimitation2['comparison'];
        $aChannelIds2 = MAX_limitationsGetAFromS($aLimitation2['data']);

        if ($op1 == '==' && $op2 == '==') {
            return count(array_diff($aChannelIds1, $aChannelIds2)) == 0
                || count(array_diff($aChannelIds1, $aChannelIds2)) == 0;
        } elseif (($op1 == '!~' && $op2 != '!~') ||
            ($op1 != '!~' && $op2 == '!~')) {
            return !MAX_limitationsDoArraysOverlap($aChannelIds1, $aChannelIds2);
        } elseif ($op1 == '=~' || $op2 == '=~') {
            return MAX_limitationsDoArraysOverlap($aChannelIds1, $aChannelIds2);
        }
        return true;
    }
}

function _sortByChannelName($a, $b) {
    $a['name'] = strtolower($a['name']);
    $b['name'] = strtolower($b['name']);

    if ($a['name'] == $b['name']) return 0;
    return strcmp($a['name'], $b['name']);
}
?>
