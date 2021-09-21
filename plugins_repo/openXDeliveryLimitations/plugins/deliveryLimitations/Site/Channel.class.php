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

require_once LIB_PATH . '/Extension/deliveryLimitations/DeliveryLimitationsCommaSeparatedData.php';

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
 *
 * @TODO overlap() methods now checks only if there is an overlap of channel ids.
 * Id does not check if contents of different channels overlap.
 */
class Plugins_DeliveryLimitations_Site_Channel extends Plugins_DeliveryLimitations_CommaSeparatedData
{
    public $bannerid;
    public $agencyid;
    public $defaultComparison = '=~';

    public function __construct()
    {
        parent::__construct();
        $this->nameEnglish = 'Site - Delivery Rule Set';
    }

    public function init($data)
    {
        parent::init($data);
        $this->aOperations['=='] = $this->translate('Is all of');
    }

    /**
     * Return if this plugin is available in the current context
     *
     * @return boolean
     */
    public function isAllowed($page = false)
    {
        return ($page != 'channel-acl.php');
    }

    /**
     * Outputs the HTML to display the data for this limitation
     *
     * @return void
     */
    public function displayArrayData()
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        $this->bannerid = (isset($GLOBALS['bannerid'])) ? $GLOBALS['bannerid'] : 0;
        $tabindex = &$GLOBALS['tabindex'];

        $aChannels = [];

        // Get all of the agency channels that could be used for this banner
        //  select the agency ID that owns this banner (it may be the admin ID, 0)
        $doChannel = OA_Dal::factoryDO('channel');
        $doAgency = OA_Dal::factoryDO('agency');
        $doClients = OA_Dal::factoryDO('clients');
        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $doBanners = OA_Dal::factoryDO('banners');
        $doBanners->bannerid = $this->bannerid;
        $doCampaigns->joinAdd($doBanners);
        $doClients->joinAdd($doCampaigns);
        $doAgency->joinAdd($doClients);
        $doChannel->joinAdd($doAgency);
        $doChannel->affiliateid = 0;
        $doChannel->selectAdd("{$doChannel->tableName()}.name as channelname");
        $doChannel->find();
        while ($doChannel->fetch()) {
            $aChannel = $doChannel->toArray();
            $channelId = $aChannel['channelid'];
            $aChannels[$channelId] = $aChannel;
        }

        // Get all of the publisher channels that could be used for this banner
        //  only publishers (affiliates) which are linked to the banner
        $doChannel = OA_Dal::factoryDO('channel');
        $doAffiliates = OA_Dal::factoryDO('affiliates');
        $doZones = OA_Dal::factoryDO('zones');
        $doAdZoneAssoc = OA_Dal::factoryDO('ad_zone_assoc');
        $doAdZoneAssoc->ad_id = $this->bannerid;
        $doZones->joinAdd($doAdZoneAssoc);
        $doAffiliates->joinAdd($doZones);
        $doChannel->joinAdd($doAffiliates);
        $doChannel->selectAdd("{$doChannel->tableName()}.name as channelname");
        $doChannel->find();
        while ($doChannel->fetch()) {
            $aChannel = $doChannel->toArray();
            $channelId = $aChannel['channelid'];
            $aChannels[$channelId] = $aChannel;
        }

        $aSelectedChannels = [];
        // Sort the list, and move selected items to the top of the list
        usort($aChannels, '_sortByChannelName');
        foreach ($aChannels as $index => $aChannel) {
            if (in_array($aChannel['channelid'], $this->data)) {
                $aSelectedChannels[$index] = $aChannel;
                unset($aChannels[$index]);
            }
        }
        $aChannels = $aSelectedChannels + $aChannels;
        echo "<div class='box'>";
        foreach ($aChannels as $aChannel) {
            if (empty($aChannel['affiliateid'])) {
                $editUrl = "channel-acl.php?agencyid={$this->agencyid}&channelid={$aChannel['channelid']}";
            } else {
                $editUrl = "channel-acl.php?affiliateid={$aChannel['affiliateid']}&channelid={$aChannel['channelid']}";
            }
            echo "
                <div class='boxrow'>
                    <input
                        tabindex='" . ($tabindex++) . "'
                        type='checkbox'
                        id='c_{$this->executionorder}_{$aChannel['channelid']}'
                        name='acl[{$this->executionorder}][data][]'
                        value='{$aChannel['channelid']}'" . (in_array($aChannel['channelid'], $this->data) ? ' checked="checked"' : '') . "
                    />
                    " . htmlspecialchars($aChannel['channelname']) . "
                    <a href='{$editUrl}' target='_blank'><img src='" . OX::assetPath() . "/images/{$GLOBALS['phpAds_TextDirection']}/go_blue.gif' border='0' align='absmiddle' alt='{$GLOBALS['strView']}'></a>
                </div>";
        }
        echo "</div>";
    }

    /**
     * Returns the compiledlimitation string for this limitation
     *
     * @return string
     */
    public function compile()
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

        $compile = [];
        foreach ($aChannelIds as $channelId) {
            $compile[] = $this->compileData($channelId);
        }

        $result = '(' . implode($join, $compile) . ')';
        if ('!~' == $this->comparison) {
            $result = '!' . $result;
        }
        return $result;
    }
}

function _sortByChannelName($a, $b)
{
    $a['channelname'] = strtolower($a['channelname']);
    $b['channelname'] = strtolower($b['channelname']);

    if ($a['channelname'] == $b['channelname']) {
        return 0;
    }
    return strcmp($a['channelname'], $b['channelname']);
}
