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

require_once MAX_PATH . '/lib/max/Admin_DA.php';
require_once MAX_PATH . '/www/admin/lib-statistics.inc.php';
require_once LIB_PATH . '/Plugin/Component.php';
require_once MAX_PATH . '/lib/OX/Util/Utils.php';
require_once MAX_PATH . '/lib/OA/Admin/UI/model/InventoryPageHeaderModelBuilder.php';


function MAX_getDisplayName($name, $length = 60, $append = '...')
{
    $displayName = strlen($name) > $length ? rtrim(substr($name, 0, $length - strlen($append))) . $append : $name;
    if (empty($displayName)) {
        $displayName = $GLOBALS['strUntitled'];
    }
    return $displayName;
}

function MAX_buildName($id, $name)
{
    return htmlspecialchars($name);
}

function MAX_getEntityIcon($entity, $active = true, $type = '', $marketAdvertiserid = '')
{
    include_once MAX_PATH . '/www/admin/lib-zones.inc.php';

    $icon = '';
    switch ($entity) {
        case 'advertiser':
            $icon = $active ? 'images/icon-advertiser.gif' : 'images/icon-advertiser-d.gif';
            break;

        case 'placement':
            $icon = $active ? 'images/icon-campaign.gif' : 'images/icon-campaign-d.gif';
            break;

        case 'publisher':
            $icon = 'images/icon-affiliate.gif';
            break;

        case 'ad':
            switch ($type) {
                case 'html': $icon = $active ? 'images/icon-banner-html.gif' : 'images/icon-banner-html-d.gif'; break;
                case 'txt': $icon = $active ? 'images/icon-banner-text.gif' : 'images/icon-banner-text-d.gif'; break;
                case 'url': $icon = $active ? 'images/icon-banner-url.gif' : 'images/icon-banner-url-d.gif'; break;
                case 'web': $icon = $active ? 'images/icon-banner-stored.gif' : 'images/icon-banner-stored-d.gif'; break;
                default: $icon = $active ? 'images/icon-banner-stored.gif' : 'images/icon-banner-stored-d.gif'; break;
            }
            break;

        case 'zone':
            switch ($type) {
                case MAX_ZoneMarketMigrated: $icon = 'images/icon-advertiser-openx.png'; break;
                case phpAds_ZoneBanner: $icon = 'images/icon-zone.gif'; break;
                case phpAds_ZoneInterstitial: $icon = 'images/icon-interstitial.gif'; break;
                case phpAds_ZonePopup: $icon = 'images/icon-popup.gif'; break;
                case phpAds_ZoneText: $icon = 'images/icon-textzone.gif'; break;
                case MAX_ZoneEmail: $icon = 'images/icon-zone-email.gif'; break;
                case MAX_ZoneClick: $icon = 'images/icon-zone-click.gif'; break;
                default: $icon = 'images/icon-zone.gif'; break;
            }
            break;
    }

    return substr($icon, 0, 4) == 'http' ? $icon : (OX::assetPath() . "/" . $icon);
}

function MAX_displayZoneHeader($pageName, $listorder, $orderdirection, $entityIds = null, $anonymous = false)
{
    global $phpAds_TextAlignRight;
    $column1 = _getHtmlHeaderColumn($GLOBALS['strName'], 'name', $pageName, $entityIds, $listorder, $orderdirection);
    $column2 = _getHtmlHeaderColumn($GLOBALS['strID'], 'id', $pageName, $entityIds, $listorder, $orderdirection, ($anonymous == false));
    $column3 = _getHtmlHeaderColumn($GLOBALS['strDescription'], 'description', $pageName, $entityIds, $listorder, $orderdirection);
    echo "
    <tr height='1'>
        <td><img src='" . OX::assetPath() . "/images/spacer.gif' width='300' height='1' border='0' alt='' title=''></td>
        <td><img src='" . OX::assetPath() . "/images/spacer.gif' width='80' height='1' border='0' alt='' title=''></td>
        <td width='100%'><img src='" . OX::assetPath() . "/images/spacer.gif' width='80' height='1' border='0' alt='' title=''></td>
    </tr>
    <tr height='25'>
        <td>$column1</td>
        <td>$column2</td>
        <td>$column3</td>
    </tr>
    <tr height='1'><td colspan='3' bgcolor='#888888'><img src='" . OX::assetPath() . "/images/break.gif' height='1' width='100%'></td></tr>";
}

function MAX_displayStatsHeader($pageName, $listorder, $orderdirection, $entityIds = null, $anonymous = false)
{
    global $phpAds_TextAlignRight;
    $column1 = _getHtmlHeaderColumn($GLOBALS['strName'], 'name', $pageName, $entityIds, $listorder, $orderdirection);
    $column2 = _getHtmlHeaderColumn($GLOBALS['strID'], 'id', $pageName, $entityIds, $listorder, $orderdirection, ($anonymous == false));
    $column3 = _getHtmlHeaderColumn($GLOBALS['strRequests'], 'sum_requests', $pageName, $entityIds, $listorder, $orderdirection);
    $column4 = _getHtmlHeaderColumn($GLOBALS['strImpressions'], 'sum_views', $pageName, $entityIds, $listorder, $orderdirection);
    $column5 = _getHtmlHeaderColumn($GLOBALS['strClicks'], 'sum_clicks', $pageName, $entityIds, $listorder, $orderdirection);
    $column6 = _getHtmlHeaderColumn($GLOBALS['strCTRShort'], 'ctr', $pageName, $entityIds, $listorder, $orderdirection);
    $column7 = _getHtmlHeaderColumn($GLOBALS['strConversions'], 'sum_conversions', $pageName, $entityIds, $listorder, $orderdirection);
    $column8 = _getHtmlHeaderColumn($GLOBALS['strCNVRShort'], 'cnvr', $pageName, $entityIds, $listorder, $orderdirection);
    echo "
    <tr height='1'>
        <td><img src='" . OX::assetPath() . "/images/spacer.gif' width='200' height='1' border='0' alt='' title=''></td>
        <td><img src='" . OX::assetPath() . "/images/spacer.gif' width='80' height='1' border='0' alt='' title=''></td>
        <td><img src='" . OX::assetPath() . "/images/spacer.gif' width='80' height='1' border='0' alt='' title=''></td>
        <td><img src='" . OX::assetPath() . "/images/spacer.gif' width='80' height='1' border='0' alt='' title=''></td>
        <td><img src='" . OX::assetPath() . "/images/spacer.gif' width='80' height='1' border='0' alt='' title=''></td>
        <td><img src='" . OX::assetPath() . "/images/spacer.gif' width='80' height='1' border='0' alt='' title=''></td>
        <td><img src='" . OX::assetPath() . "/images/spacer.gif' width='80' height='1' border='0' alt='' title=''></td>
        <td><img src='" . OX::assetPath() . "/images/spacer.gif' width='80' height='1' border='0' alt='' title=''></td>
    </tr>
    <tr height='25'>
        <td width='30%'>$column1</td>
        <td align='$phpAds_TextAlignRight'>$column2</td>
        <td align='$phpAds_TextAlignRight'>$column3</td>
        <td align='$phpAds_TextAlignRight'>$column4</td>
        <td align='$phpAds_TextAlignRight'>$column5</td>
        <td align='$phpAds_TextAlignRight'>$column6</td>
        <td align='$phpAds_TextAlignRight'>$column7</td>
        <td align='$phpAds_TextAlignRight'>$column8</td>
    </tr>
    <tr height='1'><td colspan='8' bgcolor='#888888'><img src='" . OX::assetPath() . "/images/break.gif' height='1' width='100%'></td></tr>";
}

function MAX_displayStatsHistoryHeader($pageName, $listorder, $orderdirection, $entityIds = null)
{
    global $phpAds_TextAlignRight;
    $column1 = _getHtmlHeaderColumn($GLOBALS['strDays'], 'name', $pageName, $entityIds, $listorder, $orderdirection);
    $column2 = _getHtmlHeaderColumn($GLOBALS['strImpressions'], 'sum_views', $pageName, $entityIds, $listorder, $orderdirection);
    $column3 = _getHtmlHeaderColumn($GLOBALS['strClicks'], 'sum_clicks', $pageName, $entityIds, $listorder, $orderdirection);
    $column4 = _getHtmlHeaderColumn($GLOBALS['strCTRShort'], 'ctr', $pageName, $entityIds, $listorder, $orderdirection);
    $column5 = _getHtmlHeaderColumn($GLOBALS['strConversions'], 'sum_conversions', $pageName, $entityIds, $listorder, $orderdirection);
    $column6 = _getHtmlHeaderColumn($GLOBALS['strCNVRShort'], 'cnvr', $pageName, $entityIds, $listorder, $orderdirection);
    echo "
        <table border='0' cellpadding='0' cellspacing='0' width='100%'>
        <tr height='1'>
            <td><img src='" . OX::assetPath() . "/images/spacer.gif' width='200' height='1' border='0' alt='' title=''></td>
            <td><img src='" . OX::assetPath() . "/images/spacer.gif' width='80' height='1' border='0' alt='' title=''></td>
            <td><img src='" . OX::assetPath() . "/images/spacer.gif' width='80' height='1' border='0' alt='' title=''></td>
            <td><img src='" . OX::assetPath() . "/images/spacer.gif' width='80' height='1' border='0' alt='' title=''></td>
            <td><img src='" . OX::assetPath() . "/images/spacer.gif' width='80' height='1' border='0' alt='' title=''></td>
            <td><img src='" . OX::assetPath() . "/images/spacer.gif' width='80' height='1' border='0' alt='' title=''></td>
        </tr>
        <tr height='25'>
            <td width='30%'>$column1</td>
            <td align='$phpAds_TextAlignRight'>$column2</td>
            <td align='$phpAds_TextAlignRight'>$column3</td>
            <td align='$phpAds_TextAlignRight'>$column4</td>
            <td align='$phpAds_TextAlignRight'>$column5</td>
            <td align='$phpAds_TextAlignRight'>$column6</td>
        </tr>
        <tr height='1'><td colspan='7' bgcolor='#888888'><img src='" . OX::assetPath() . "/images/break.gif' height='1' width='100%'></td></tr>
    ";
}

function MAX_displayNoStatsMessage()
{
    echo "
    <br /><br /><div class='errormessage'><img class='errormessage' src='" . OX::assetPath() . "/images/info.gif' width='16' height='16' border='0' align='absmiddle'>{$GLOBALS['strNoStats']}</div>";
}

function _getHtmlHeaderColumn($title, $name, $pageName, $entityIds, $listorder, $orderdirection, $showColumn = true)
{
    $str = '';
    $entity = htmlspecialchars(_getEntityString($entityIds), ENT_QUOTES);
    $pageName = htmlspecialchars($pageName, ENT_QUOTES);
    if ($listorder == $name) {
        if (($orderdirection == '') || ($orderdirection == 'down')) {
            $str = "<a href='$pageName?{$entity}orderdirection=up'><img src='" . OX::assetPath() . "/images/caret-ds.gif' border='0' alt='' title=''></a>";
        } else {
            $str = "<a href='$pageName?{$entity}orderdirection=down'><img src='" . OX::assetPath() . "/images/caret-u.gif' border='0' alt='' title=''></a>";
        }
    }
    return $showColumn ? "<b><a href='$pageName?{$entity}listorder=" . urlencode($name) . "'>$title</a>$str</b>" : '';
}

function _getEntityString($entityIds)
{
    $entity = '';
    if (!empty($entityIds)) {
        $entityArr = [];
        foreach ($entityIds as $entityId => $entityValue) {
            $entityArr[] = "$entityId=" . urlencode($entityValue);
        }
        $entity = implode('&', $entityArr) . '&';
    }

    return $entity;
}

function MAX_displayDateSelectionForm($period, $period_start, $period_end, $pageName, &$tabindex, $hiddenValues = null)
{
    global $tabindex;
    require_once MAX_PATH . '/lib/max/Admin/UI/FieldFactory.php';

    $oDaySpan = &FieldFactory::newField('day-span');
    $oDaySpan->_name = 'period';
    $oDaySpan->_autoSubmit = true;
    $oDaySpan->setValueFromArray(['period_preset' => $period, 'period_start' => $period_start, 'period_end' => $period_end]);
    $oDaySpan->_tabIndex = $tabindex;
    echo "
    <form id='period_form' name='period_form' action='$pageName'>";
    $oDaySpan->display();
    $tabindex = $oDaySpan->_tabIndex;
    echo "
    <input type='button' value='Go' onclick='return periodFormSubmit()' style='margin-left: 1em' tabindex='" . $tabindex++ . "' />";
    _displayHiddenValues($hiddenValues);
    echo "
    </form>";
}

function _displayHiddenValues($hiddenValues)
{
    if (!empty($hiddenValues) && is_array($hiddenValues)) {
        foreach ($hiddenValues as $name => $value) {
            echo "
    <input type='hidden' name='$name' value='$value'>";
        }
    }
}

function MAX_displayPeriodSelectionForm($period, $pageName, &$tabindex, $hiddenValues = null)
{
    global $phpAds_TextDirection;

    echo "
    <form action='$pageName'>
    <select name='period' onChange='this.form.submit();' tabindex='" . $tabindex++ . "'>
        <option value='daily'" . ($period == 'daily' ? ' selected' : '') . ">{$GLOBALS['strDailyHistory']}</option>
        <option value='w'" . ($period == 'weekly' ? ' selected' : '') . ">{$GLOBALS['strWeeklyHistory']}</option>
        <option value='m'" . ($period == 'monthly' ? ' selected' : '') . ">{$GLOBALS['strMonthlyHistory']}</option>
    </select>
    &nbsp;&nbsp;
    <input type='image' src='" . OX::assetPath() . "/images/$phpAds_TextDirection/go_blue.gif' border='0' name='submit'>
    &nbsp;";
    _displayHiddenValues($hiddenValues);
    echo "
    </form>
    ";
}

function MAX_displayHistoryStatsDaily($aHistoryStats, $aTotalHistoryStats, $pageName, $hiddenValues = null)
{
    $i = 0;
    $entity = _getEntityString($hiddenValues);
    foreach ($aHistoryStats as $day => $stats) {
        $bgColor = ($i++ % 2 == 0) ? '#F6F6F6' : '#FFFFFF';
        $views = phpAds_formatNumber($stats['sum_views']);
        $clicks = phpAds_formatNumber($stats['sum_clicks']);
        $conversions = phpAds_formatNumber($stats['sum_conversions']);
        $ctr = phpAds_buildRatioPercentage($stats['sum_clicks'], $stats['sum_views']);
        $cnvr = phpAds_buildRatioPercentage($stats['sum_conversions'], $stats['sum_clicks']);
        echo "
        <tr height='25' bgcolor='$bgColor'>
            <td>&nbsp;<img src='" . OX::assetPath() . "/images/icon-date.gif' align='absmiddle' alt=''>&nbsp;<a href='$pageName?{$entity}'>$day</a></td>
            <td align='right'>$views</td>
            <td align='right'>$clicks</td>
            <td align='right'>$ctr</td>
            <td align='right'>$conversions</td>
            <td align='right'>$cnvr</td>
        </tr>
        <tr><td height='1' colspan='6' bgcolor='#888888'><img src='" . OX::assetPath() . "/images/break.gif' height='1' width='100%' alt=''></td></tr>
        ";
    }
    echo "
    </table>";
}

function MAX_displayPublisherZoneStats($aParams, $pageName, $anonymous, $aNodes, $expand, $listorder, $orderdirection, $hideinactive, $showPublisher, $entityIds)
{
    global $phpAds_TextAlignLeft, $phpAds_TextAlignRight, $phpAds_TextDirection;

    // Get the icons for all levels (publisher/zone)
    $entity = _getEntityString($entityIds);
    $publishersHidden = 0;

    $aPublishers = Admin_DA::fromCache('getPublishersStats', $aParams);
    if (!empty($aPublishers)) {
        echo "
        <br /><br />
        <table border='0' width='100%' cellpadding='0' cellspacing='0'>";
        MAX_displayStatsHeader($pageName, $listorder, $orderdirection, $entityIds);

        // Variable to determine if the row should be grey or white...
        $i = 0;

        // Loop through publishers
        $totalRequests = 0;
        $totalViews = 0;
        $totalClicks = 0;
        $totalConversions = 0;
        MAX_sortArray($aPublishers, ($listorder == 'id' ? 'publisher_id' : $listorder), $orderdirection == 'up');
        foreach ($aPublishers as $publisherId => $publisher) {
            $publisherRequests = phpAds_formatNumber($publisher['sum_requests']);
            $publisherViews = phpAds_formatNumber($publisher['sum_views']);
            $publisherClicks = phpAds_formatNumber($publisher['sum_clicks']);
            $publisherConversions = phpAds_formatNumber($publisher['sum_conversions']);
            $publisherCtr = phpAds_buildRatioPercentage($publisher['sum_clicks'], $publisher['sum_views']);
            $publisherSr = phpAds_buildRatioPercentage($publisher['sum_conversions'], $publisher['sum_clicks']);
            $publisherExpanded = MAX_isExpanded($publisherId, $expand, $aNodes, 'p');
            $publisherActive = true;
            $publisherIcon = MAX_getEntityIcon('publisher', $publisherActive);

            if (!$hideinactive || $publisherActive) {
                $bgcolor = ($i++ % 2 == 0) ? " bgcolor='#F6F6F6'" : '';
                echo "
            <tr height='25'$bgcolor>
                <td>";
                if (!empty($publisher['num_children'])) {
                    if ($publisherExpanded) {
                        echo "&nbsp;<a href='$pageName?{$entity}collapse=p$publisherId'><img src='" . OX::assetPath() . "/images/triangle-d.gif' align='absmiddle' border='0'></a>&nbsp;";
                    } else {
                        echo "&nbsp;<a href='$pageName?{$entity}expand=p$publisherId'><img src='" . OX::assetPath() . "/images/$phpAds_TextDirection/triangle-l.gif' align='absmiddle' border='0'></a>&nbsp;";
                    }
                } else {
                    echo "&nbsp;<img src='" . OX::assetPath() . "/images/spacer.gif' height='16' width='16'>&nbsp;";
                }

                echo "
                    <img src='$publisherIcon' align='absmiddle'>&nbsp;
                    <a href='stats.php?entity=affiliate&breakdown=history&affiliateid=$publisherId'>{$publisher['name']}</a>
                </td>";
                if ($anonymous) {
                    echo "
                <td align='$phpAds_TextAlignRight'>&nbsp;</td>";
                } else {
                    echo "
                <td align='$phpAds_TextAlignRight'>$publisherId</td>";
                }
                echo "
                <td align='$phpAds_TextAlignRight'>$publisherRequests</td>
                <td align='$phpAds_TextAlignRight'>$publisherViews</td>
                <td align='$phpAds_TextAlignRight'>$publisherClicks</td>
                <td align='$phpAds_TextAlignRight'>$publisherCtr</td>
                <td align='$phpAds_TextAlignRight'>$publisherConversions</td>
                <td align='$phpAds_TextAlignRight'>$publisherSr</td>
            </tr>";

                if (!empty($publisher['num_children']) && $publisherExpanded) {
                    echo "
            <tr height='1'>
                <td$bgcolor><img src='" . OX::assetPath() . "/images/spacer.gif' width='1' height='1'></td>
                <td colspan='8' bgcolor='#888888'><img src='" . OX::assetPath() . "/images/break-l.gif' height='1' width='100%'></td>
            </tr>";


                    // Loop through zones
                    $aZones = Admin_DA::fromCache('getZonesStats', $aParams);
                    MAX_sortArray($aZones, ($listorder == 'id' ? 'zone_id' : $listorder), $orderdirection == 'up');
                    foreach ($aZones as $zoneId => $zone) {
                        $zoneRequests = phpAds_formatNumber($zone['sum_requests']);
                        $zoneViews = phpAds_formatNumber($zone['sum_views']);
                        $zoneClicks = phpAds_formatNumber($zone['sum_clicks']);
                        $zoneConversions = phpAds_formatNumber($zone['sum_conversions']);
                        $zoneCtr = phpAds_buildRatioPercentage($zone['sum_clicks'], $zone['sum_views']);
                        $zoneSr = phpAds_buildRatioPercentage($zone['sum_conversions'], $zone['sum_clicks']);
                        $zoneActive = true;
                        $zoneIcon = MAX_getEntityIcon('zone', $zoneActive, $zone['type']);

                        echo "
            <tr height='25'$bgcolor>
                <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <img src='" . OX::assetPath() . "/images/spacer.gif' height='16' width='16' align='absmiddle'>&nbsp;
                    <img src='$zoneIcon' align='absmiddle'>&nbsp;
                    <a href='stats.php?entity=zone&breakdown=history&affiliateid=$publisherId&zoneid=$zoneId'>{$zone['name']}</a>
                </td>
                <td align='$phpAds_TextAlignRight'>$zoneId</td>
                <td align='$phpAds_TextAlignRight'>$zoneRequests</td>
                <td align='$phpAds_TextAlignRight'>$zoneViews</td>
                <td align='$phpAds_TextAlignRight'>$zoneClicks</td>
                <td align='$phpAds_TextAlignRight'>$zoneCtr</td>
                <td align='$phpAds_TextAlignRight'>$zoneConversions</td>
                <td align='$phpAds_TextAlignRight'>$zoneSr</td>
            </tr>";
                    }
                }
                echo "
                <tr height='1'><td colspan='8' bgcolor='#888888'><img src='" . OX::assetPath() . "/images/break.gif' height='1' width='100%'></td></tr>";
            } else {
                $publishersHidden++;
            }
            $totalRequests += $publisher['sum_requests'];
            $totalViews += $publisher['sum_views'];
            $totalClicks += $publisher['sum_clicks'];
            $totalConversions += $publisher['sum_conversions'];
        }

        // Total
        echo "
        <tr height='25'$bgcolor>
            <td>&nbsp;&nbsp;<b>{$GLOBALS['strTotal']}</b></td>
            <td>&nbsp;</td>
            <td align='$phpAds_TextAlignRight'>" . phpAds_formatNumber($totalRequests) . "</td>
            <td align='$phpAds_TextAlignRight'>" . phpAds_formatNumber($totalViews) . "</td>
            <td align='$phpAds_TextAlignRight'>" . phpAds_formatNumber($totalClicks) . "</td>
            <td align='$phpAds_TextAlignRight'>" . phpAds_buildCTR($totalViews, $totalClicks) . "</td>
            <td align='$phpAds_TextAlignRight'>" . phpAds_formatNumber($totalConversions) . "</td>
            <td align='$phpAds_TextAlignRight'>" . phpAds_buildCTR($totalClicks, $totalConversions) . "</td>
        </tr>
        <tr height='1'>
            <td colspan='8' bgcolor='#888888'><img src='" . OX::assetPath() . "/images/break.gif' height='1' width='100%'></td>
        </tr>";
        if (!$anonymous) {
            $publisherIcon = MAX_getEntityIcon('publisher');
            echo "
        <tr>
            <td colspan='4' align='$phpAds_TextAlignLeft' nowrap>";

            if ($hideinactive == true) {
                echo "&nbsp;&nbsp;<img src='" . OX::assetPath() . "/images/icon-activate.gif' align='absmiddle' border='0'>&nbsp;<a href='$pageName?{$entity}hideinactive=0'>{$GLOBALS['strShowAll']}</a>&nbsp;&nbsp;|&nbsp;&nbsp;$publishersHidden {$GLOBALS['strInactivePublishersHidden']}";
            } else {
                echo "&nbsp;&nbsp;<img src='" . OX::assetPath() . "/images/icon-hideinactivate.gif' align='absmiddle' border='0'>&nbsp;<a href='$pageName?{$entity}hideinactive=1'>{$GLOBALS['strHideInactivePublishers']}</a>";
            }

            echo "
            </td>
            <td colspan='4' align='$phpAds_TextAlignRight' nowrap><img src='" . OX::assetPath() . "/images/triangle-d.gif' align='absmiddle' border='0'>&nbsp;<a href='$pageName?{$entity}expand=all' accesskey='{$GLOBALS['keyExpandAll']}'>{$GLOBALS['strExpandAll']}</a>&nbsp;&nbsp;|&nbsp;&nbsp;<img src='" . OX::assetPath() . "/images/$phpAds_TextDirection/triangle-l.gif' align='absmiddle' border='0'>&nbsp;<a href='$pageName?{$entity}expand=none' accesskey='{$GLOBALS['keyCollapseAll']}'>{$GLOBALS['strCollapseAll']}</a>&nbsp;&nbsp;</td>
        </tr>
        <tr height='25'>";
            if ($showPublisher == 't') {
                echo "
            <td colspan='8' align='$phpAds_TextAlignLeft' nowrap>&nbsp;&nbsp;<img src='$publisherIcon' align='absmiddle'><a href='$pageName?{$entity}showpublisher=f'> Hide parent publisher</a></td>";
            } else {
                echo "
            <td colspan='8' align='$phpAds_TextAlignLeft' nowrap>&nbsp;&nbsp;<img src='$publisherIcon' align='absmiddle'><a href='$pageName?{$entity}showpublisher=t'> Show parent publisher</a></td>";
            }
            echo "
        </tr>";
        }
        echo "
        </table>
        <br /><br />";
    } else {
        MAX_displayNoStatsMessage();
    }
}

function MAX_displayZoneStats($aParams, $pageName, $anonymous, $aNodes, $expand, $listorder, $orderdirection, $hideinactive, $showPublisher, $entityIds)
{
    global $phpAds_TextAlignLeft, $phpAds_TextAlignRight, $phpAds_TextDirection;

    // Get the icons for all levels (publisher/zone)
    $entity = _getEntityString($entityIds);
    $publishersHidden = 0;

    $aZones = Admin_DA::fromCache('getZonesStats', $aParams);
    if (!empty($aZones)) {
        echo "
        <br /><br />
        <table border='0' width='100%' cellpadding='0' cellspacing='0'>";
        MAX_displayStatsHeader($pageName, $listorder, $orderdirection, $entityIds, $anonymous);

        // Variable to determine if the row should be grey or white...
        $i = 0;
        $totalRequests = 0;
        $totalViews = 0;
        $totalClicks = 0;
        $totalConversions = 0;

        // Loop through publishers
        MAX_sortArray($aZones, ($listorder == 'id' ? 'zone_id' : $listorder), $orderdirection == 'up');
        foreach ($aZones as $zoneId => $zone) {
            $zoneRequests = phpAds_formatNumber($zone['sum_requests']);
            $zoneViews = phpAds_formatNumber($zone['sum_views']);
            $zoneClicks = phpAds_formatNumber($zone['sum_clicks']);
            $zoneConversions = phpAds_formatNumber($zone['sum_conversions']);
            $zoneCtr = phpAds_buildRatioPercentage($zone['sum_clicks'], $zone['sum_views']);
            $zoneSr = phpAds_buildRatioPercentage($zone['sum_conversions'], $zone['sum_clicks']);
            $zoneActive = true;
            $zoneIcon = MAX_getEntityIcon('zone', $zoneActive, $zone['type']);

            if (!$hideinactive || $zoneActive) {
                $bgcolor = ($i++ % 2 == 0) ? " bgcolor='#F6F6F6'" : '';
                echo "
        <tr height='25'$bgcolor>
            <td>&nbsp;<img src='" . OX::assetPath() . "/images/spacer.gif' height='16' width='16'>&nbsp;
                <img src='$zoneIcon' align='absmiddle'>&nbsp;";
                if ($anonymous) {
                    echo "
                Hidden zone {$zone['id']}";
                } else {
                    echo "
                <a href='stats.php?entity=zone&breakdown=history&affiliateid={$zone['publisher_id']}'>{$zone['name']}</a>";
                }
                echo "
            </td>";
                if ($anonymous) {
                    echo "
            <td align='$phpAds_TextAlignRight'>&nbsp;</td>";
                } else {
                    echo "
            <td align='$phpAds_TextAlignRight'>$zoneId</td>";
                }
                echo "
            <td align='$phpAds_TextAlignRight'>$zoneRequests</td>
            <td align='$phpAds_TextAlignRight'>$zoneViews</td>
            <td align='$phpAds_TextAlignRight'>$zoneClicks</td>
            <td align='$phpAds_TextAlignRight'>$zoneCtr</td>
            <td align='$phpAds_TextAlignRight'>$zoneConversions</td>
            <td align='$phpAds_TextAlignRight'>$zoneSr</td>
        </tr>
        <tr height='1'><td colspan='8' bgcolor='#888888'><img src='" . OX::assetPath() . "/images/break.gif' height='1' width='100%'></td></tr>";
            } else {
                $publishersHidden++;
            }
            $totalRequests += $zone['sum_requests'];
            $totalViews += $zone['sum_views'];
            $totalClicks += $zone['sum_clicks'];
            $totalConversions += $zone['sum_conversions'];
        }

        // Total
        echo "
        <tr height='25'$bgcolor>
            <td>&nbsp;&nbsp;<b>{$GLOBALS['strTotal']}</b></td>
            <td>&nbsp;</td>
            <td align='$phpAds_TextAlignRight'>" . phpAds_formatNumber($totalRequests) . "</td>
            <td align='$phpAds_TextAlignRight'>" . phpAds_formatNumber($totalViews) . "</td>
            <td align='$phpAds_TextAlignRight'>" . phpAds_formatNumber($totalClicks) . "</td>
            <td align='$phpAds_TextAlignRight'>" . phpAds_buildCTR($totalViews, $totalClicks) . "</td>
            <td align='$phpAds_TextAlignRight'>" . phpAds_formatNumber($totalConversions) . "</td>
            <td align='$phpAds_TextAlignRight'>" . phpAds_buildCTR($totalClicks, $totalConversions) . "</td>
        </tr>
        <tr height='1'>
            <td colspan='8' bgcolor='#888888'><img src='" . OX::assetPath() . "/images/break.gif' height='1' width='100%'></td>
        </tr>";
        if (!$anonymous) {
            echo "
        <tr>
            <td colspan='4' align='$phpAds_TextAlignLeft' nowrap>";

            if ($hideinactive == true) {
                echo "&nbsp;&nbsp;<img src='" . OX::assetPath() . "/images/icon-activate.gif' align='absmiddle' border='0'>&nbsp;<a href='$pageName?{$entity}hideinactive=0'>{$GLOBALS['strShowAll']}</a>&nbsp;&nbsp;|&nbsp;&nbsp;$publishersHidden {$GLOBALS['strInactivePublishersHidden']}";
            } else {
                echo "&nbsp;&nbsp;<img src='" . OX::assetPath() . "/images/icon-hideinactivate.gif' align='absmiddle' border='0'>&nbsp;<a href='$pageName?{$entity}hideinactive=1'>{$GLOBALS['strHideInactivePublishers']}</a>";
            }

            echo "
            </td>
            <td colspan='4' align='$phpAds_TextAlignRight' nowrap><img src='" . OX::assetPath() . "/images/triangle-d.gif' align='absmiddle' border='0'>&nbsp;<a href='$pageName?{$entity}expand=all'>{$GLOBALS['strExpandAll']}</a>&nbsp;&nbsp;|&nbsp;&nbsp;<img src='" . OX::assetPath() . "/images/$phpAds_TextDirection/triangle-l.gif' align='absmiddle' border='0'>&nbsp;<a href='$pageName?{$entity}expand=none'>{$GLOBALS['strCollapseAll']}</a>&nbsp;&nbsp;</td>
        </tr>
        <tr height='25'>";
            if ($showPublisher == 't') {
                echo "
            <td colspan='7' align='$phpAds_TextAlignLeft' nowrap>&nbsp;&nbsp;<img src='" . OX::assetPath() . "/images/icon-affiliate.gif' align='absmiddle'><a href='$pageName?{$entity}showpublisher=f'> Hide parent publisher</a></td>";
            } else {
                echo "
            <td colspan='7' align='$phpAds_TextAlignLeft' nowrap>&nbsp;&nbsp;<img src='" . OX::assetPath() . "/images/icon-affiliate.gif' align='absmiddle'><a href='$pageName?{$entity}showpublisher=t'> Show parent publisher</a></td>";
            }
            echo "
        </tr>";
        }
        echo "
        </table>
        <br /><br />";
    } else {
        MAX_displayNoStatsMessage();
    }
}

function MAX_displayInventoryBreadcrumbs($aEntityNamesUrls, $entityClass, $newEntity = false)
{
    MAX_displayInventoryBreadcrumbsInternal($aEntityNamesUrls, MAX_buildBreadcrumbPath($entityClass), $newEntity);
}

function MAX_displayInventoryBreadcrumbsInternal($aEntityNamesUrls, $breadcrumbPath, $newEntity = false)
{
    global $phpAds_breadcrumbs;

    $path = [];

    // Breadcrumbs above the main title
    for ($i = 0; $i < count($aEntityNamesUrls); $i++) {
        $breadcrumbInfo = MAX_buildBreadcrumbInfo($breadcrumbPath[$i]);

        $path[] = [
            'name' => $aEntityNamesUrls[$i]["name"],
            'url' => $aEntityNamesUrls[$i]["url"],
            'label' => ($newEntity && $i == count($aEntityNamesUrls) - 1 ? $breadcrumbInfo['newLabel'] : $breadcrumbInfo['label']),
            'newTarget' => $breadcrumbInfo['newTarget'],
            'cssClass' => $breadcrumbInfo['class']
        ];
    }

    $phpAds_breadcrumbs = [
        'path' => $path,
        'newEntity' => $newEntity
    ];
}

function MAX_buildBreadcrumbInfo($entityClass)
{
    switch ($entityClass) {
        case 'advertiser':
           return ["label" => $GLOBALS['strClient'], "newLabel" => $GLOBALS['strAddClient'], "class" => "adv"];

        case 'campaign':
           return ["label" => $GLOBALS['strCampaign'], "newLabel" => $GLOBALS['strAddCampaign'], "newTarget" => $GLOBALS['strCampaignForAdvertiser'], "class" => "camp"];

        case 'tracker':
           return ["label" => $GLOBALS['strTracker'], "newLabel" => $GLOBALS['strAddTracker'], "newTarget" => $GLOBALS['strTrackerForAdvertiser'], "class" => "track"];

        case 'banner':
           return ["label" => $GLOBALS['strBanner'], "newLabel" => $GLOBALS['strAddBanner'], "newTarget" => $GLOBALS['strBannerToCampaign'], "class" => "ban"];

        case 'website':
           return ["label" => $GLOBALS['strAffiliate'], "newLabel" => $GLOBALS['strAddNewAffiliate'], "class" => "webs"];

        case 'zone':
            return ["label" => $GLOBALS['strZone'], "newLabel" => $GLOBALS['strAddNewZone'], "newTarget" => $GLOBALS['strZoneToWebsite'], "class" => "zone"];

        case 'channel':
           return ["label" => $GLOBALS['strChannel'], "newLabel" => $GLOBALS['strAddNewChannel'], "newTarget" => $GLOBALS['strChannelToWebsite'], "class" => "chan"];

        case 'agency':
           return ["label" => $GLOBALS['strAgency'], "newLabel" => $GLOBALS['strAddAgency'], "class" => "agen"];

        case 'day':
           return ["label" => $GLOBALS['strDay'], "newLabel" => '', "class" => "day"];
    }

    return null;
}

function MAX_buildBreadcrumbPath($entityClass)
{
    switch ($entityClass) {
        case 'banner':
        case 'campaign':
        case 'advertiser':
            return ['advertiser', 'campaign', 'banner'];

        case 'tracker':
            return ['advertiser', 'tracker'];

        case 'website':
        case 'zone':
            return ['website', 'zone'];

        case 'trafficker-zone':
            return ['zone'];

        case 'channel':
            return ['website', 'channel'];

        case 'global-channel':
            return ['channel'];

        case 'agency':
            return ['agency'];
    }

    return null;
}

/**
 * Builds header model for advertiser edit page tabs
 *
 * @param mixed $idOrAdvertiser - either advertiser id or advertiser array
 * @return OA_Admin_UI_Model_PageHeaderModel
 */
function buildAdvertiserHeaderModel($idOrAdvertiser)
{
    if (is_array($idOrAdvertiser)) {
        $aAdvertiser = $idOrAdvertiser;
    } elseif (!empty($idOrAdvertiser)) {
        $aAdvertiser = phpAds_getClientDetails($idOrAdvertiser);
    } else {
        $aAdvertiser = [];
    }

    $builder = new OA_Admin_UI_Model_InventoryPageHeaderModelBuilder();
    $pageType = empty($aAdvertiser['clientid']) ? 'edit-new' : 'edit';

    $oHeaderModel = $builder->buildEntityHeader(
        [
        ["name" => $aAdvertiser['clientname']]],
        "advertiser",
        $pageType
    );
    return $oHeaderModel;
}

function MAX_displayTrackerBreadcrumbs($clientid, $trackerid = null)
{
    if ($trackerid) {
        $parentClientId = phpAds_getTrackerParentClientID($trackerid);
        $tracker = phpAds_getTrackerDetails($trackerid);
        $trackerName = $tracker['trackername'];
        $pageType = 'edit';
    } else {
        $parentClientId = $clientid;
        $trackerName = "";
        $pageType = 'edit-new';
    }
    $advertiserEditUrl = "advertiser-edit.php?clientid=$parentClientId";
    $advertiser = phpAds_getClientDetails($parentClientId);
    $advertiserName = $advertiser['clientname'];

    $builder = new OA_Admin_UI_Model_InventoryPageHeaderModelBuilder();
    $oHeaderModel = $builder->buildEntityHeader(
        [
                                        ["name" => $advertiserName, "url" => $advertiserEditUrl],
                                        ["name" => $trackerName]],
        'tracker',
        $pageType
    );

    return $oHeaderModel;
}

function MAX_displayWebsiteBreadcrumbs($affiliateid)
{
    if ($affiliateid) {
        $publisher = Admin_DA::getPublisher($affiliateid);
        $websiteName = $publisher['name'];
        $pageType = "edit";
    } else {
        $websiteName = "";
        $pageType = "edit-new";
    }
    $builder = new OA_Admin_UI_Model_InventoryPageHeaderModelBuilder();
    $oHeaderModel = $builder->buildEntityHeader([
        ["name" => $websiteName]], "website", $pageType);

    return $oHeaderModel;
}



function MAX_displayZoneEntitySelection($entity, $aOtherAdvertisers, $aOtherPlacements, $aOtherAds, $advertiserId, $placementId, $adId, $publisherId, $zoneId, $title, $pageName, &$tabIndex)
{
    echo "
<br />$title<br /><br />
<table cellpadding='0' cellspacing='0' border='0'>
<tr>";
    $aSavedEntities = ['affiliateid' => $publisherId, 'zoneid' => $zoneId];
    _displayZoneEntitySelectionCell('advertiser', $advertiserId, $aOtherAdvertisers, 'clientid', $aSavedEntities, ($entity != 'advertiser'), $pageName, $tabIndex);

    if (!empty($advertiserId) && $entity != 'advertiser') {
        $aSavedEntities['clientid'] = $advertiserId;
        _displayZoneEntitySelectionCell('placement', $placementId, $aOtherPlacements, 'campaignid', $aSavedEntities, ($entity != 'placement'), $pageName, $tabIndex);

        if (!empty($placementId) && $entity != 'placement') {
            $aSavedEntities['campaignid'] = $placementId;
            _displayZoneEntitySelectionCell('ad', $adId, $aOtherAds, 'bannerid', $aSavedEntities, ($entity != 'ad'), $pageName, $tabIndex);
        }
    }
    echo "
</tr>
</table>
<br /><br />";
}

function _displayZoneEntitySelectionCell($entity, $entityId, $aOtherEntities, $entityIdName, $aSavedEntities, $autoSubmit, $pageName, &$tabIndex)
{
    global $phpAds_TextDirection;

    $onChange = $autoSubmit ? " onChange='this.form.submit();'" : '';
    $submitIcon = $autoSubmit ? '' : "&nbsp;<input type='hidden' name='action' value='set'><input id='link_submit' name='submitimage' id='submitimage' type='image' src='" . OX::assetPath() . "/images/$phpAds_TextDirection/go_blue.gif' border='0' tabindex='" . ($tabIndex++) . "'>";
    $tabInfo = " tabindex='" . ($tabIndex++) . "'";
    $entityIcon = MAX_getEntityIcon($entity);
    echo "
<td>
<form name='zonetypeselection' method='get' action='$pageName'>";
    foreach ($aSavedEntities as $savedEntityName => $savedEntityId) {
        echo "
<input type='hidden' name='$savedEntityName' value='$savedEntityId'>";
    }
    echo "
    &nbsp;&nbsp;<img src='$entityIcon' align='absmiddle'>&nbsp;
    <select name='$entityIdName'{$onChange}{$tabInfo}>";
    // Show an empty value in the dropdown if none is selected
    if (empty($entityId)) {
        switch ($entity) {
            case 'advertiser': $description = "-- {$GLOBALS['strSelectAdvertiser']} --"; break;
            case 'placement': $description = "-- {$GLOBALS['strSelectPlacement']} --"; break;
            case 'ad': $description = "-- {$GLOBALS['strSelectAd']} --"; break;
            default: $description = '';
        }
        echo "
        <option value='' selected>$description</option>";
    }

    $aOtherEntities = _multiSort($aOtherEntities, 'name', 'advertiser_id');
    foreach ($aOtherEntities as $aOtherEntity) {
        switch ($entity) {
            case 'advertiser':
                $otherEntityId = $aOtherEntity['advertiser_id'];
                break;
            case 'placement':
                $otherEntityId = $aOtherEntity['placement_id'];
                break;
            case 'ad':
                $otherEntityId = $aOtherEntity['ad_id'];
                break;
        }
        $selected = $otherEntityId == $entityId ? ' selected' : '';

        $adsCount = '';
        if ($entity == 'placement') {
            $aParams = ['placement_id' => $otherEntityId];
            $aParams += MAX_getLinkedAdParams($GLOBALS['zoneId']);

            $doCampaign = OA_Dal::factoryDO('campaigns');
            $doCampaign->campaignid = $otherEntityId;
            $doCampaign->find();
            $doCampaign->fetch();

            if ($doCampaign->type == DataObjects_Campaigns::CAMPAIGN_TYPE_DEFAULT) {
                $translation = new OX_Translation();
                $aStringParams["bannerCount"] = count(Admin_DA::getAds($aParams));
                $translated = $translation->translate($GLOBALS['strWithXBanners'], $aStringParams);
                $adsCount = "(" . $translated . ")";
            }
        }

        echo "<option value='$otherEntityId'{$selected}>" . htmlspecialchars($aOtherEntity['name']) . " $adsCount</option>";
    }
    echo "
    </select>
    $submitIcon
</form>
</td>";
}

function MAX_displayLinkedAdsPlacements($aParams, $publisherId, $zoneId, $hideInactive, $showParentPlacements, $pageName, &$tabIndex)
{
    global $phpAds_TextDirection, $phpAds_TextAlignRight;

    echo "
<table id='linked-banners' width='100%' border='0' align='center' cellspacing='0' cellpadding='0'>
<tr height='25'>
<td width='40%'><b>&nbsp;&nbsp;{$GLOBALS['strName']}</b></td>
<td><b>{$GLOBALS['strID']}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></td>
<td>&nbsp;</td>
</tr>
<tr height='1'>
<td colspan='3' bgcolor='#888888'><img src='" . OX::assetPath() . "/images/break.gif' height='1' width='100%'></td>
</tr>";
    $i = 0;
    $inactive = 0;
    $aPlacements = !empty($aParams) ? Admin_DA::getPlacements($aParams) : [];
    foreach ($aPlacements as $placementId => $aPlacement) {
        $aAds = Admin_DA::getAds($aParams + ['placement_id' => $placementId], true);
        $placementActive = $aPlacement['status'] == OA_ENTITY_STATUS_RUNNING;
        if (!$hideInactive || $placementActive) {
            $bgcolor = $i % 2 == 0 ? " bgcolor='#F6F6F6'" : '';
            if ($showParentPlacements) {
                $placementIcon = MAX_getEntityIcon('placement', $placementActive);
                $placementName = MAX_getDisplayName($aPlacement['name']);
                $placementLink = (OA_Permission::isAccount(OA_ACCOUNT_ADMIN) || OA_Permission::isAccount(OA_ACCOUNT_MANAGER)) ? "<a href='campaign-edit.php?clientid={$aPlacement['advertiser_id']}&campaignid=$placementId'>$placementName</a>" : $placementName;
                if ($i > 0) {
                    echo "
<tr height='1'>
<td colspan='3' bgcolor='#888888'><img src='" . OX::assetPath() . "/images/break-l.gif' height='1' width='100%'></td>
</tr>";
                }
                echo "
<tr height='25'$bgcolor>
<td>
    &nbsp;&nbsp;<img src='$placementIcon' align='absmiddle'>
    &nbsp;$placementLink
</td>
<td>$placementId</td>
<td>&nbsp;</td>
</tr>";
            }
            foreach ($aAds as $adId => $aAd) {
                $adActive = ($aAd['status'] == OA_ENTITY_STATUS_RUNNING && $aPlacement['status'] == OA_ENTITY_STATUS_RUNNING);
                if (!$hideInactive || $adActive) {
                    $adIcon = MAX_getEntityIcon('ad', $adActive, $aAd['type']);
                    $adName = htmlspecialchars(MAX_getDisplayName($aAd['name']));
                    $adLink = (OA_Permission::isAccount(OA_ACCOUNT_ADMIN) || OA_Permission::isAccount(OA_ACCOUNT_MANAGER)) ? "<a href='banner-edit.php?clientid={$aPlacement['advertiser_id']}&campaignid=$placementId&bannerid=$adId'>$adName</a>" : $adName;
                    $adWidth = $aAd['contenttype'] == 'txt' ? 300 : $aAd['width'] + 64;
                    $adHeight = $aAd['contenttype'] == 'txt' ? 200 : $aAd['height'] + (!empty($aAd['bannertext']) ? 90 : 64);
                    echo "
<tr height='1'>
<td$bgcolor><img src='" . OX::assetPath() . "/images/spacer.gif' width='1' height='1'></td>
<td colspan='2' bgcolor='#888888'><img src='" . OX::assetPath() . "/images/break-el.gif' height='1' width='100%'></td>
</tr>
<tr height='25'$bgcolor>
<td>
    &nbsp;&nbsp;<a href='$pageName?affiliateid=$publisherId&zoneid=$zoneId&bannerid=$adId&action=remove'><img src='" . OX::assetPath() . "/images/caret-l.gif' border='0' align='absmiddle'></a>
    &nbsp;&nbsp;&nbsp;&nbsp;<img src='$adIcon' align='absmiddle'>&nbsp;$adLink</td>
<td>$adId</td>
<td align='$phpAds_TextAlignRight'>
    <img src='" . OX::assetPath() . "/images/icon-zoom.gif' align='absmiddle' border='0'>&nbsp;<a href='banner-htmlpreview.php?bannerid=$adId' target='_new' onClick=\"return openWindow('banner-htmlpreview.php?bannerid=$adId', '', 'status=no,scrollbars=no,resizable=no,width=$adWidth,height=$adHeight');\">{$GLOBALS['strShowBanner']}</a>&nbsp;&nbsp;
</td>
</tr>";
                } else {
                    $inactive++;
                }
            }
            $i++;
        } else {
            $inactive += count($aAds);
        }
    }
    $showParentText = $showParentPlacements ? $GLOBALS['strHideParentCampaigns'] : $GLOBALS['strShowParentCampaigns'];
    $showParentValue = $showParentPlacements ? '0' : '1';
    $hideInactiveText = $hideInactive ? $GLOBALS['strShowAll'] : $GLOBALS['strHideInactiveBanners'];
    $hideInactiveStats = $hideInactive ? "&nbsp;&nbsp;|&nbsp;&nbsp;$inactive {$GLOBALS['strInactiveBannersHidden']}" : '';
    $hideInactiveValue = $hideInactive ? '0' : '1';
    $hideInactiveIcon = OX::assetPath($hideInactive ? 'images/icon-activate.gif' : 'images/icon-hideinactivate.gif');
    echo "
<tr height='1'>
<td colspan='3' bgcolor='#888888'><img src='" . OX::assetPath() . "/images/break.gif' height='1' width='100%'></td>
</tr>
<tr height='25'>
<td colspan='2'>
    <img src='$hideInactiveIcon' align='absmiddle' border='0'>
    <a href='$pageName?affiliateid=$publisherId&zoneid=$zoneId&hideinactive=$hideInactiveValue'>$hideInactiveText</a>$hideInactiveStats
</td>
<td align='right'>
    <img src='" . OX::assetPath() . "/images/icon-campaign-d.gif' align='absmiddle' border='0'>
    <a href='$pageName?affiliateid=$publisherId&zoneid=$zoneId&showcampaigns=$showParentValue'>$showParentText</a>
</table>";
}

function MAX_displayLinkedPlacementsAds($aParams, $publisherId, $zoneId, $hideInactive, $showMatchingAds, $pageName, &$tabIndex, $directLinkedAds = false)
{
    echo "
    <br /><strong>{$GLOBALS['strCampaignLinkedAds']}:</strong><br />
    <table id='linked-campaigns' width='100%' border='0' align='center' cellspacing='0' cellpadding='0'>
    <tr height='25'>
        <td width='40%'><b>&nbsp;&nbsp;{$GLOBALS['strName']}</b></td>
        <td width='20%'><b>&nbsp;&nbsp;{$GLOBALS['strType']}</b></td>
        <td><b>{$GLOBALS['strID']}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></td>
        <td>&nbsp;</td>
    </tr>
    <tr height='1'>
        <td colspan='4' bgcolor='#888888'><img src='" . OX::assetPath() . "/images/break.gif' height='1' width='100%'></td>
    </tr>";

    $i = 0;
    $inactive = 0;
    $aPlacements = (!empty($aParams)) ? Admin_DA::getPlacements($aParams) : [];
    foreach ($aPlacements as $placementId => $aPlacement) {
        $placementActive = $aPlacement['status'] == OA_ENTITY_STATUS_RUNNING;
        if (!$hideInactive || $placementActive) {
            $pParams = $aParams;
            $pParams['placement_id'] = $placementId;
            $aAds = Admin_DA::getAds($pParams, true);
            $bgcolor = $i % 2 == 0 ? " bgcolor='#F6F6F6'" : '';
            // Remove these ad(s) from the direct linked ads
            foreach ($aAds as $dAdId) {
                unset($directLinkedAds[$dAdId['ad_id']]);
            }

            // Remove from array any ads not linked to the zone.
            // These might exist if campaign has been linked to zone
            // and indivual ads have then been unlinked
            $pParams = ['zone_id' => $zoneId];
            $aAdZones = Admin_DA::getAdZones($pParams, true);
            $aAdZoneLinks = [];
            foreach ($aAdZones as $aAdZone) {
                $aAdZoneLinks[] = $aAdZone['ad_id'];
            }
            foreach ($aAds as $adId => $aAd) {
                if (!in_array($adId, $aAdZoneLinks)) {
                    unset($aAds[$adId]);
                }
            }

            $placementIcon = MAX_getEntityIcon('placement', $placementActive);
            $placementName = htmlspecialchars(MAX_getDisplayName($aPlacement['name']));
            $placementLink = (OA_Permission::isAccount(OA_ACCOUNT_ADMIN) || OA_Permission::isAccount(OA_ACCOUNT_MANAGER)) ? "<a href='campaign-edit.php?clientid={$aPlacement['advertiser_id']}&campaignid=$placementId'>$placementName</a>" : $placementName;
            $placementTypeName = OX_Util_Utils::getCampaignTypeName($aPlacement['priority']);
            $adCount = empty($aAds) ? 0 : count($aAds);
            $placementDescription = $showMatchingAds ? '&nbsp;' : str_replace('{count}', $adCount, $GLOBALS['strMatchingBanners']);
            if ($i > 0) {
                echo "
    <tr height='1'>
        <td colspan='4' bgcolor='#888888'><img src='" . OX::assetPath() . "/images/break-l.gif' height='1' width='100%'></td>
    </tr>";
            }
            echo "
    <tr height='25'$bgcolor>
        <td>
            &nbsp;&nbsp;<a href='$pageName?affiliateid=$publisherId&zoneid=$zoneId&campaignid=$placementId&action=remove'><img src='" . OX::assetPath() . "/images/caret-l.gif' border='0' align='absmiddle'></a>
            &nbsp;&nbsp;<img src='$placementIcon' align='absmiddle'>
            &nbsp;$placementLink
        </td>
        <td><span class='campaign-type'>$placementTypeName</span></td>
        <td>$placementId</td>
        <td>$placementDescription</td>
    </tr>";
            if ($showMatchingAds && !empty($aAds)) {
                foreach ($aAds as $adId => $aAd) {
                    $adActive = ($aAd['status'] == OA_ENTITY_STATUS_RUNNING && $aPlacement['status'] == OA_ENTITY_STATUS_RUNNING);
                    if (!$hideInactive || $adActive) {
                        $adIcon = MAX_getEntityIcon('ad', $adActive, $aAd['type']);
                        $adName = htmlspecialchars(MAX_getDisplayName($aAd['name']));
                        $adLink = (OA_Permission::isAccount(OA_ACCOUNT_ADMIN) || OA_Permission::isAccount(OA_ACCOUNT_MANAGER)) ? "<a href='banner-edit.php?clientid={$aPlacement['advertiser_id']}&campaignid=$placementId&bannerid=$adId'>$adName</a>" : $adName;
                        $adWidth = $aAd['contenttype'] == 'txt' ? 300 : $aAd['width'] + 64;
                        $adHeight = $aAd['contenttype'] == 'txt' ? 200 : $aAd['height'] + (!empty($aAd['bannertext']) ? 90 : 64);
                        echo "
    <tr height='1'>
        <td$bgcolor><img src='" . OX::assetPath() . "/images/spacer.gif' width='1' height='1'></td>
        <td colspan='3' bgcolor='#888888'><img src='" . OX::assetPath() . "/images/break-el.gif' height='1' width='100%'></td>
    </tr>
    <tr height='25'$bgcolor>
        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src='$adIcon' align='absmiddle'>&nbsp;$adLink</td>
        <td></td>
        <td>$adId</td>
        <td align=" . $GLOBALS['phpAds_TextAlignRight'] . ">
            <img src='" . OX::assetPath() . "/images/icon-zoom.gif' align='absmiddle' border='0'>&nbsp;<a href='banner-htmlpreview.php?bannerid=$adId' target='_new' onClick=\"return openWindow('banner-htmlpreview.php?bannerid=$adId', '', 'status=no,scrollbars=no,resizable=no,width=$adWidth,height=$adHeight');\">{$GLOBALS['strShowBanner']}</a>&nbsp;&nbsp;
        </td>
    </tr>";
                    } else {
                        $inactive++;
                    }
                }
            }
            $i++;
        } else {
            $inactive++;
        }
    }
    $showMatchingText = $showMatchingAds ? $GLOBALS['strHideMatchingBanners'] : $GLOBALS['strShowMatchingBanners'];
    $showMatchingValue = $showMatchingAds ? '0' : '1';
    $hideInactiveText = $hideInactive ? $GLOBALS['strShowAll'] : $GLOBALS['strHideInactiveCampaigns'];
    $hideInactiveStats = $hideInactive ? "&nbsp;&nbsp;|&nbsp;&nbsp;$inactive {$GLOBALS['strInactiveCampaignsHidden']}" : '';
    $hideInactiveValue = $hideInactive ? '0' : '1';
    $hideInactiveIcon = OX::assetPath($hideInactive ? 'images/icon-activate.gif' : 'images/icon-hideinactivate.gif');
    echo "
    <tr height='1'>
        <td colspan='4' bgcolor='#888888'><img src='" . OX::assetPath() . "/images/break.gif' height='1' width='100%'></td>
    </tr>
    <tr height='25'>
        <td colspan='3'>
            <img src='$hideInactiveIcon' align='absmiddle' border='0'>
            <a href='$pageName?affiliateid=$publisherId&zoneid=$zoneId&hideinactive=$hideInactiveValue'>$hideInactiveText</a>$hideInactiveStats
        </td>
        <td align='right'>
            <img src='" . OX::assetPath() . "/images/icon-banner-stored-d.gif' align='absmiddle' border='0'>
            <a href='$pageName?affiliateid=$publisherId&zoneid=$zoneId&showbanners=$showMatchingValue'>$showMatchingText</a>
    </table>";
    if (!empty($directLinkedAds)) {
        echo "<br /><strong>{$GLOBALS['strBannerLinkedAds']}:</strong><br />";
        $aParams = ['ad_id' => implode(',', array_keys($directLinkedAds))];
        MAX_displayLinkedAdsPlacements($aParams, $publisherId, $zoneId, $hideInactive, false, $pageName, $tabIndex);
    }
}

function MAX_displayPlacementAdSelectionViewForm($publisherId, $zoneId, $view, $pageName, &$tabIndex, $aOtherZones = [])
{
    global $phpAds_TextDirection;

    $disabled = null;
    $disabledHidden = null;
    if (!empty($aOtherZones[$zoneId]['type'])) {
        if ($aOtherZones[$zoneId]['type'] == MAX_ZoneEmail) {
            $view = 'ad';
            $disabled = ' disabled';
            $disabledHidden = "<input type='hidden' name='view' value='ad' />";
        }
    }
    $placementSelected = $view == 'placement' ? ' selected' : '';
    $categorySelected = $view == 'category' ? ' selected' : '';
    $adSelected = $view == 'ad' ? ' selected' : '';

    echo "
<form name='zoneview' method='post' action='$pageName'>
<input type='hidden' name='zoneid' value='$zoneId'>
<input type='hidden' name='affiliateid' value='$publisherId'>
<table border='0' width='100%' cellpadding='0' cellspacing='0'>
<tr height='25'>
<td colspan='3'><b>{$GLOBALS['strSelectZoneType']}</b></td>
</tr>
<tr height='25'>
<td>
    <select name='view' onchange='this.form.submit();' $disabled>
        <option value='placement'$placementSelected>{$GLOBALS['strCampaignDefaults']}</option>
        <!--option value='category'$categorySelected>{$GLOBALS['strLinkedCategories']}</option-->
        <option value='ad'$adSelected>{$GLOBALS['strLinkedBanners']}</option>
    </select>
    &nbsp;<input type='image' id='link_type_submit' src='" . OX::assetPath() . "/images/$phpAds_TextDirection/go_blue.gif' border='0'>
    $disabledHidden
</td>
</tr>
</table>
</form>";
    phpAds_ShowBreak();
    echo "
<br />";
}

function MAX_displayAcls($acls, $aParams)
{
    global $session;
    
    $tabindex = &$GLOBALS['tabindex'];
    $page = basename($_SERVER['SCRIPT_NAME']);
    $conf = $GLOBALS['_MAX']['CONF'];

    echo "<form action='{$page}' method='post'>";
    echo "<input type='hidden' name='token' value='" . urlencode(phpAds_SessionGetToken()) . "' />";

    echo "<label><img src='" . OX::assetPath() . "/images/icon-acl-add.gif' align='absmiddle'>&nbsp;" . $GLOBALS['strACLAdd'] . ": &nbsp;";
    echo "<select name='type' accesskey='{$GLOBALS['keyAddNew']}' tabindex='" . ($tabindex++) . "'>";

    $deliveryLimitations = OX_Component::getComponents('deliveryLimitations', null, false);
    foreach ($deliveryLimitations as $pluginName => $plugin) {
        if ($plugin->isAllowed($page)) {
            echo "<option value='{$pluginName}'>" . $plugin->getName() . "</option>";
        }
    }

    echo "</select></label>";
    echo "&nbsp;";
    echo "<input type='submit' class='flat' name='action[new]' value='" . $GLOBALS['strAdd'] . "'";

    phpAds_ShowBreak();
    echo "<br />";
    $aErrors = OX_AclCheckInputsFields($acls, $page);
    if (!empty($GLOBALS['action'])) {
        // We are part way through making changes, show a message
        echo "<div class='errormessage'><img class='errormessage' src='" . OX::assetPath() . "/images/warning.gif' align='absmiddle'>";
        echo "<span class='tab-s'>{$GLOBALS['strUnsavedChanges']}</span><br>";
        echo "</div>";
    } elseif ($session['aclsDbError']) {
        unset($session['aclsDbError']);
        phpAds_SessionDataStore();
        echo "<div class='errormessage'><img class='errormessage' src='" . OX::assetPath() . "/images/warning.gif' align='absmiddle'>";
        echo "<span class='tab-r'>{$GLOBALS['strDeliveryRulesDbError']}</span><br>";
        echo "</div>";
    } elseif ($session['aclsTruncation']) {
        unset($session['aclsTruncation']);
        phpAds_SessionDataStore();
        echo "<div class='errormessage'><img class='errormessage' src='" . OX::assetPath() . "/images/warning.gif' align='absmiddle'>";
        echo "<span class='tab-r'>{$GLOBALS['strDeliveryRulesTruncation']}</span><br>";
        echo "</div>";
    } elseif (!MAX_AclValidate($page, $aParams)) {
        echo "<div class='errormessage'><img class='errormessage' src='" . OX::assetPath() . "/images/warning.gif' align='absmiddle'>";
        echo "<span class='tab-r'>{$GLOBALS['strDeliveryLimitationsDisagree']}</span><br>";
        echo "</div>";
    }

    if ($aErrors !== true) {
        echo "<div class='errormessage'><img class='errormessage' src='" . OX::assetPath() . "/images/warning.gif' align='absmiddle'>";
        echo "<span class='tab-s'>{$GLOBALS['strDeliveryLimitationsInputErrors']}</span><br><ul>";
        foreach ($aErrors as $error) {
            echo "<li><span class='tab-s'>{$error}</span><br></li>";
        }
        echo "</ul></div>";
    }

    foreach ($aParams as $name => $value) {
        echo "<input type='hidden' name='{$name}' value='{$value}' />";
    }
    echo "<table border='0' width='100%' cellpadding='0' cellspacing='0'>";
    echo "<tr><td height='25' colspan='4' bgcolor='#FFFFFF'><b>{$GLOBALS['strDeliveryLimitations']}</b></td></tr>";
    echo "<tr><td height='1' colspan='4' bgcolor='#888888'><img src='" . OX::assetPath() . "/images/break.gif' height='1' width='100%'></td></tr>";

    if (empty($acls)) {
        echo "<tr><td height='24' colspan='4' bgcolor='#F6F6F6'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$GLOBALS['strNoLimitations']}</td></tr>";
        echo "<tr><td height='1' colspan='4' bgcolor='#888888'><img src='" . OX::assetPath() . "/images/break.gif' height='1' width='100%'></td></tr>";
    } else {
        echo "<tr><td height='25' colspan='4' bgcolor='#F6F6F6'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$GLOBALS['strOnlyDisplayWhen']}</td></tr>";
        echo "<tr><td colspan='4'><img src='" . OX::assetPath() . "/images/break-el.gif' width='100%' height='1'></td></tr>";

        foreach ($acls as $aclId => $acl) {
            if ($deliveryLimitationPlugin = OA_aclGetComponentFromRow($acl)) {
                $deliveryLimitationPlugin->init($acl);
                $deliveryLimitationPlugin->count = count($acls);
                if ($deliveryLimitationPlugin->isAllowed($page)) {
                    $deliveryLimitationPlugin->display();
                }
            }
        }
    }

    echo "<tr><td height='30' colspan='2'>";

    if (!empty($acls)) {
        $url = $page . '?';
        foreach ($aParams as $name => $value) {
            $url .= "{$name}={$value}&";
        }
        $url .= "action[clear]=true";
        echo "<img src='" . OX::assetPath() . "/images/icon-recycle.gif' border='0' align='absmiddle'>&nbsp;
                <a href='{$url}'>{$GLOBALS['strRemoveAllLimitations']}</a>&nbsp;&nbsp;&nbsp;&nbsp;
        ";
    }

    echo "</td><td height='30' colspan='2' align='{$GLOBALS['phpAds_TextAlignRight']}'>";
    echo "</td></tr>";

    echo "</table>";
}

function MAX_displayChannels($channels, $aParams)
{
    $entityString = _getEntityString($aParams);
    echo "<table border='0' width='100%' cellpadding='0' cellspacing='0'>";

    echo "<tr height='25'><td height='25'><b>&nbsp;&nbsp;{$GLOBALS['strName']}</a></b></td>";

    echo "<td height='25'><b>{$GLOBALS['strID']}</a></td>";
    echo "<td height='25'>&nbsp;</td>";
    echo "</tr>";

    echo "<tr height='1'><td colspan='3' bgcolor='#888888'><img src='" . OX::assetPath() . "/images/break.gif' height='1' width='100%'></td></tr>";

    if (empty($channels)) {
        echo "<tr height='25' bgcolor='#F6F6F6'><td height='25' colspan='3'>";
        echo "&nbsp;&nbsp;{$GLOBALS['strNoChannels']}</td></tr>";

        echo "<td colspan='3' bgcolor='#888888'><img src='" . OX::assetPath() . "/images/break.gif' height='1' width='100%'></td></tr>";
    } else {
        $i = 0;
        foreach ($channels as $channelId => $channel) {
            if ($i > 0) {
                echo "<td colspan='3' bgcolor='#888888'><img src='" . OX::assetPath() . "/images/break.gif' height='1' width='100%'></td>";
            }
            echo "<tr height='25' " . ($i % 2 == 0 ? "bgcolor='#F6F6F6'" : "") . ">";
            echo "<td height='25'>&nbsp;&nbsp;";
            echo "<img src='" . OX::assetPath() . "/images/icon-channel.gif' align='absmiddle'>&nbsp;";

            // set channel ownership info for display
            if ($GLOBALS['pageName'] != 'affiliate-channels.php') {
                if (!empty($channel['publisher_id'])) {
                    $ownerTypeStr = 'Publisher: ';
                    $publisher = Admin_DA::getPublisher($channel['publisher_id']);
                    $ownerNameStr = '[id' . $channel['publisher_id'] . '] ' . $publisher['name'];
                } elseif (!empty($channel['agency_id']) && empty($channel['publisher_id'])
                       && !OA_Permission::isAccount(OA_ACCOUNT_MANAGER)) {
                    $ownerTypeStr = 'Agency: ';
                    $agency = Admin_DA::getAgency($channel['agency_id']);
                    $ownerNameStr = '[id' . $channel['agency_id'] . '] ' . $agency['name'];
                } else {
                    $ownerTypeStr = '';
                    $ownerNameStr = '';
                }
            }
            $ownerStr = !empty($ownerTypeStr) ? '&nbsp&nbsp<i>' . $ownerTypeStr . '</i>' . htmlspecialchars($ownerNameStr) : '';

            echo "<a href='channel-edit.php?{$entityString}channelid={$channel['channel_id']}'>" . htmlspecialchars($channel['name'] . $ownerStr) . "</a>";
            echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
            echo "</td>";
            echo "<td height='25'>{$channel['channel_id']}</td>";
            echo "<td>&nbsp;</td></tr>";

            // Description
            echo "<tr height='25' " . ($i % 2 == 0 ? "bgcolor='#F6F6F6'" : "") . ">";
            echo "<td>&nbsp;</td>";
            echo "<td height='25' colspan='3'>" . htmlspecialchars(stripslashes($channel['description'])) . "</td>";
            echo "</tr>";

            echo "<tr height='1'>";
            echo "<td " . ($i % 2 == 0 ? "bgcolor='#F6F6F6'" : "") . "><img src='" . OX::assetPath() . "/images/spacer.gif' width='1' height='1'></td>";
            echo "<td colspan='3' bgcolor='#888888'><img src='" . OX::assetPath() . "/images/break-l.gif' height='1' width='100%'></td>";
            echo "</tr>";
            echo "<tr height='25' " . ($i % 2 == 0 ? "bgcolor='#F6F6F6'" : "") . ">";

            // Empty
            echo "<td>&nbsp;</td>";

            // Buttons
            echo "<td height='25' colspan='3'>";

            echo "<img src='" . OX::assetPath() . "/images/icon-acl.gif' border='0' align='absmiddle' alt='{$GLOBALS['strIncludedBanners']}'>&nbsp;<a href='channel-acl.php?{$entityString}channelid={$channel['channel_id']}'>{$GLOBALS['strEditChannelLimitations']}</a>&nbsp;&nbsp;&nbsp;&nbsp;";
            echo "<img src='" . OX::assetPath() . "/images/icon-recycle.gif' border='0' align='absmiddle' alt='{$GLOBALS['strDelete']}'>&nbsp;<a href='channel-delete.php?token=" . urlencode(phpAds_SessionGetToken()) . "&{$entityString}channelid={$channel['channel_id']}&returnurl=" . (empty($aParams['affiliateid']) ? 'channel-index.php' : 'affiliate-channels.php') . "'" . phpAds_DelConfirm($GLOBALS['strConfirmDeleteChannel']) . ">{$GLOBALS['strDelete']}</a>&nbsp;&nbsp;&nbsp;&nbsp;";

            echo "</td></tr>";
            $i++;
        }
        if (!empty($channels)) {
            echo "<tr height='1'><td colspan='4' bgcolor='#888888'><img src='" . OX::assetPath() . "/images/break.gif' height='1' width='100%'></td></tr>";
        }
    }
    echo "</table>";
}

/**
 * Show a confirm message for zone delete
 *
 * @param int $zoneId Zone ID
 * @return string
 */
function MAX_zoneDelConfirm($zoneId)
{
    $dalZones = OA_Dal::factoryDAL('zones');
    return phpAds_DelConfirm(
        ($dalZones->checkZoneLinkedToActiveCampaign($zoneId)) ?
                    $GLOBALS['strConfirmDeleteZoneLinkActive'] . '\n' . $GLOBALS['strConfirmDeleteZone']
                    : $GLOBALS['strConfirmDeleteZone']
    );
}

function OX_Display_ConversionWindowHTML($varName, $windowSeconds, &$tabindex, $enabled = true)
{
    $window = _secondsToWindowArray($windowSeconds);
    echo "
        " . (($enabled) ? "<input id='{$varName}daytrk' class='flat' type='text' size='3' name='{$varName}day' value='{$window['days']}' onKeyUp=\"phpAds_formLimitUpdate();\" tabindex='" . ($tabindex++) . "' />" : $window['days']) . " {$GLOBALS['strDays']} &nbsp;&nbsp;
        " . (($enabled) ? "<input id='{$varName}hourtrk' class='flat' type='text' size='3' name='{$varName}hour' value='{$window['hours']}' onKeyUp=\"phpAds_formLimitUpdate();\" tabindex='" . ($tabindex++) . "' />" : $window['hours']) . " {$GLOBALS['strHours']} &nbsp;&nbsp;
        " . (($enabled) ? "<input id='{$varName}minutetrk' class='flat' type='text' size='3' name='{$varName}minute' value='{$window['minutes']}' onKeyUp=\"phpAds_formLimitUpdate();\" tabindex='" . ($tabindex++) . "' />" : $window['minutes']) . " {$GLOBALS['strMinutes']} &nbsp;&nbsp;
        " . (($enabled) ? "<input id='{$varName}secondtrk' class='flat' type='text' size='3' name='{$varName}second' value='{$window['seconds']}' onKeyUp=\"phpAds_formLimitUpdate();\" tabindex='" . ($tabindex++) . "' />" : $window['seconds']) . " {$GLOBALS['strSeconds']} &nbsp;&nbsp;
    ";
}

// Determine whether an advertiser has an active placement/ad running under it...
function _isAdvertiserActive($aAdvertiserPlacementAd)
{
    $active = false;
    if (isset($aAdvertiserPlacementAd['children'])) {
        foreach ($aAdvertiserPlacementAd['children'] as $aPlacementAd) {
            if (_isPlacementActive($aPlacementAd)) {
                $active = true;
                break;
            }
        }
    }
    return $active;
}

// Determine whether a placement has an active ad running under it...
function _isPlacementActive($aPlacementAd)
{
    $active = false;
    if ($aPlacementAd['status'] == OA_ENTITY_STATUS_RUNNING) {
        if (isset($aPlacementAd['children'])) {
            foreach ($aPlacementAd['children'] as $aAd) {
                if ($aAd['status'] == OA_ENTITY_STATUS_RUNNING) {
                    $active = true;
                    break;
                }
            }
        }
    }
    return $active;
}

// Determine whether a publisher is active...
function _isPublisherActive($aPublisherZone)
{
    return true;  // for now, all publishers are active.
}

// Determine whether a zone is active...
function _isZoneActive($aZone)
{
    return true;  // for now, all zones are active.
}

function _secondsToWindowArray($seconds)
{
    $return['days'] = floor($seconds / (60 * 60 * 24));
    $seconds = $seconds % (60 * 60 * 24);
    $return['hours'] = floor($seconds / (60 * 60));
    $seconds = $seconds % (60 * 60);
    $return['minutes'] = floor($seconds / (60));
    $seconds = $seconds % (60);
    $return['seconds'] = $seconds;
    return $return;
}

function _windowValuesToseconds($days, $hours, $minutes, $seconds)
{
    $days = ($days > 0) ? $days : 0;
    $hours = ($hours > 0) ? $hours : 0;
    $minutes = ($minutes > 0) ? $minutes : 0;
    $seconds = ($seconds > 0) ? $seconds : 0;
    return $days * (24 * 60 * 60) + $hours * (60 * 60) + $minutes * (60) + $seconds;
}

function _multiSort($array, $arg1, $arg2)
{
    $arr1 = [];
    $arr2 = [];

    foreach ($array as $key => $value) {
        $arr1[$key] = strtolower($value[$arg1]);
        $arr2[$key] = $value[$arg2];
    }

    array_multisort($arr1, $arr2, $array);
    return $array;
}

/** Tools and Breadcrumbs **/
function MAX_displayNavigationTracker($advertiserId, $trackerId, $aOtherAdvertisers)
{
    addTrackerPageTools($advertiserId, $trackerId, $aOtherAdvertisers);
    $oHeaderModel = MAX_displayTrackerBreadcrumbs($advertiserId, $trackerId);
    phpAds_PageHeader(null, $oHeaderModel);
}


function MAX_displayNavigationCampaign($campaignId, $aOtherAdvertisers, $aOtherCampaigns, $aEntities)
{
    $advertiserId = $aEntities['clientid'];


    $doCampaign = OA_Dal::factoryDO('campaigns');
    $doCampaign->campaignid = $campaignId;
    $doCampaign->find();
    $doCampaign->fetch();
    $campaignName = $doCampaign->campaignname;

    $advertiserName = $aOtherAdvertisers[$advertiserId]['name'];
    $advertiserEditUrl = '';
    if (OA_Permission::hasAccessToObject('clients', $advertiserId, OA_Permission::OPERATION_EDIT)) {
        $advertiserEditUrl = "advertiser-edit.php?clientid=$advertiserId";
    }

    addCampaignPageTools($advertiserId, $campaignId, $aOtherAdvertisers, $aEntities);

    $builder = new OA_Admin_UI_Model_InventoryPageHeaderModelBuilder();
    $oHeaderModel = $builder->buildEntityHeader(
        [
                                          ["name" => $advertiserName, "url" => $advertiserEditUrl],
                                          ["name" => $campaignName]],
        "campaign",
        "edit"
    );
    phpAds_PageHeader(null, $oHeaderModel);
}


function MAX_displayNavigationBanner($pageName, $aOtherCampaigns, $aOtherBanners, $aEntities)
{
    global $phpAds_TextDirection;

    $advertiserId = $aEntities['clientid'];
    $campaignId = $aEntities['campaignid'];
    $bannerId = $aEntities['bannerid'];
    $entityString = _getEntityString($aEntities);
    $aOtherEntities = $aEntities;
    unset($aOtherEntities['bannerid']);
    $otherEntityString = _getEntityString($aOtherEntities);
    if ($pageName == 'banner-edit.php' && empty($bannerId)) {
        $tabValue = 'banner-edit_new';
        $pageType = 'edit-new';
    } else {
        $pageType = 'edit';
    }

    $advertiserEditUrl = '';
    $campaignEditUrl = '';

    if (OA_Permission::hasAccessToObject('clients', $advertiserId)) {
        $advertiserEditUrl = "advertiser-edit.php?clientid=$advertiserId";
    }
    if (!OA_Permission::isAccount(OA_ACCOUNT_ADVERTISER)) {
        $campaignEditUrl = "campaign-edit.php?clientid=$advertiserId&campaignid=$campaignId";
    }

    // Build banner preview
    if ($bannerId && !empty($GLOBALS['_MAX']['PREF']['ui_show_banner_preview']) && empty($_GET['nopreview'])) {
        $bannerCode = MAX_bannerPreview($bannerId);
    } else {
        $bannerCode = '';
    }

    $advertiserDetails = phpAds_getClientDetails($advertiserId);
    $advertiserName = $advertiserDetails['clientname'];
    $campaignDetails = Admin_DA::getPlacement($campaignId);
    $campaignName = $campaignDetails['name'];
    $bannerName = $aOtherBanners[$bannerId]['name'];

    $builder = new OA_Admin_UI_Model_InventoryPageHeaderModelBuilder();
    $oHeaderModel = $builder->buildEntityHeader(
        [
                                      ["name" => $advertiserName, "url" => $advertiserEditUrl],
                                      ["name" => $campaignName, "url" => $campaignEditUrl],
                                      ["name" => $bannerName]],
        "banner",
        $pageType
    );

    global $phpAds_breadcrumbs_extra;
    $phpAds_breadcrumbs_extra .= "<div class='bannercode'>$bannerCode</div>";
    if ($bannerCode != '') {
        $phpAds_breadcrumbs_extra .= "<br />";
    }

    addBannerPageTools($advertiserId, $campaignId, $bannerId, $aOtherCampaigns, $aOtherBanners, $aEntities);
    phpAds_PageHeader($tabValue, $oHeaderModel);
}

function MAX_bannerPreview($bannerId)
{
    require_once(MAX_PATH . '/lib/max/Delivery/adRender.php');
    $aBanner = Admin_DA::getAd($bannerId);
    $aBanner['storagetype'] = $aBanner['type'];
    $aBanner['bannerid'] = $aBanner['ad_id'];

    return MAX_adRender($aBanner, 0, '', '', '', true, '', false, false);
}

function MAX_displayNavigationZone($pageName, $aOtherPublishers, $aOtherZones, $aEntities)
{
    global $phpAds_TextDirection;

    $websiteId = $aEntities['affiliateid'];
    $zoneId = $aEntities['zoneid'];
    $entityString = _getEntityString($aEntities);
    $aOtherEntities = $aEntities;
    unset($aOtherEntities['zoneid']);
    $otherEntityString = _getEntityString($aOtherEntities);
    $aPublisher = $aOtherPublishers[$websiteId];
    $publisherName = $aPublisher['name'];
    $zoneName = (empty($zoneId)) ? $GLOBALS['strUntitled'] : $aOtherZones[$zoneId]['name'];

    if (OA_Permission::isAccount(OA_ACCOUNT_ADMIN) || OA_Permission::isAccount(OA_ACCOUNT_MANAGER)) {
        $tabSections = ['4.2.3.2', '4.2.3.6', '4.2.3.3', '4.2.3.4', '4.2.3.5'];
        // Determine which tab is highlighted
        switch ($pageName) {
            case 'zone-edit.php':
                if (empty($zoneId)) {
                    $tabValue = 'zone-edit_new';
                } else {
                    $tabValue = 'zone-edit';
                }
                break;
            default: $tabSections = basename($pageName); break;
        }
    } elseif (OA_Permission::isAccount(OA_ACCOUNT_TRAFFICKER)) {
        $tabSections = [];
        if (OA_Permission::hasPermission(OA_PERM_ZONE_EDIT)) {
            $tabSections[] = '2.1.1';
        }
        if (OA_Permission::hasPermission(OA_PERM_ZONE_LINK)) {
            $tabSections[] = '2.1.2';
        }
        $tabSections[] = '2.1.3';
        if (OA_Permission::hasPermission(OA_PERM_ZONE_INVOCATION)) {
            $tabSections[] = '2.1.4';
        }
        switch ($pageName) {
            case 'zone-edit.php': {
                $tabValue = 'zone-edit';
                if (empty($zoneId)) {
                    $tabValue = 'zone-edit_new';
                }
                break;
            }
            case 'zone-include.php': $tabValue = '2.1.2'; break;
            case 'zone-probability.php': $tabValue = '2.1.3'; break;
            case 'zone-invocation.php': $tabValue = '2.1.4'; break;
        }
    }
    // Sort the zones by name...
    require_once(MAX_PATH . '/lib/max/other/stats.php');

    $publisherEditUrl = "affiliate-edit.php?affiliateid=$websiteId";
    if (!OA_Permission::isAccount(OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER)) {
        $publisherEditUrl = "affiliate-zones.php?affiliateid=$websiteId";
    }

    $builder = new OA_Admin_UI_Model_InventoryPageHeaderModelBuilder();
    $oHeaderModel = $builder->buildEntityHeader([
                                       ["name" => $publisherName, "url" => $publisherEditUrl],
                                       ["name" => empty($zoneId) ? '' : $zoneName]
                                   ], "zone", empty($zoneId));

    if (!empty($zoneId)) {
        addZonePageTools($websiteId, $zoneId, $aOtherPublishers, $aEntities);
    }
    phpAds_PageHeader($tabValue, $oHeaderModel);
    phpAds_ShowSections($tabSections);
}

function MAX_displayNavigationChannel($pageName, $aOtherChannels, $aEntities)
{
    global $phpAds_TextDirection;

    $agencyId = isset($aEntities['agencyid']) ? $aEntities['agencyid'] : null;
    $websiteId = isset($aEntities['affiliateid']) ? $aEntities['affiliateid'] : null;
    $channelId = $aEntities['channelid'];
    $channelName = $aOtherChannels[$channelId]['name'];

    $entityString = _getEntityString($aEntities);
    $aOtherEntities = $aEntities;
    unset($aOtherEntities['channelid']);
    $otherEntityString = _getEntityString($aOtherEntities);

    if (!empty($websiteId)) {
        $channelType = 'publisher';
    } else {
        $channelType = 'agency';
    }

    // Determine which set of tabs to show...
    if ($channelType == 'publisher') {
        // Determine which tab is highlighted
        switch ($pageName) {
            case 'channel-edit.php': $tabValue = (!empty($channelId)) ? 'channel-edit-affiliate' : 'channel-edit-affiliate_new'; break;
            case 'channel-acl.php': $tabValue = 'channel-affiliate-acl'; break;
        }
    } else {
        // Determine which tab is highlighted
        switch ($pageName) {
            case 'channel-edit.php': $tabValue = (!empty($channelId)) ? 'channel-edit' : 'channel-edit_new'; break;
            case 'channel-acl.php': $tabValue = 'channel-acl'; break;
        }
    }

    // Sort the channels by name...
    require_once(MAX_PATH . '/lib/max/other/stats.php');

    $publisherEditUrl = "affiliate-edit.php?affiliateid=$websiteId";
    if (!empty($channelId)) {
        addChannelPageTools($agencyId, $websiteId, $channelId, $channelType);

        // Determine which tab is highlighted
        $publisher = Admin_DA::getPublisher($websiteId);
        $publisherName = $publisher['name'];
        if (!empty($channelId)) {
            $builder = new OA_Admin_UI_Model_InventoryPageHeaderModelBuilder();
            $oHeaderModel = $builder->buildEntityHeader([
                ["name" => $publisherName, 'url' => $publisherEditUrl],
                ["name" => $channelName]], "channel", "edit");
            phpAds_PageHeader($tabValue, $oHeaderModel);
        } else {
            $builder = new OA_Admin_UI_Model_InventoryPageHeaderModelBuilder();
            $oHeaderModel = $builder->buildEntityHeader([
                ["name" => $publisherName, 'url' => $publisherEditUrl],
                ["name" => $channelName]], "channel", "edit-new");
            phpAds_PageHeader($tabValue, $oHeaderModel);
        }
    } else {
        if (!empty($channelId)) {
            $builder = new OA_Admin_UI_Model_InventoryPageHeaderModelBuilder();
            $oHeaderModel = $builder->buildEntityHeader([
                ["name" => $channelName]], "global-channel", "edit");
            phpAds_PageHeader($tabValue, $oHeaderModel);
        } else {
            $builder = new OA_Admin_UI_Model_InventoryPageHeaderModelBuilder();
            $oHeaderModel = $builder->buildEntityHeader([
                        ["name" => ""]], "global-channel", "edit-new");
            phpAds_PageHeader($tabValue, $oHeaderModel);
        }
    }
}


function addAdvertiserPageToolsAndShortcuts($advertiserId)
{
    if (!OA_Permission::isAccount(OA_ACCOUNT_ADVERTISER)) {
        $token = phpAds_SessionGetToken();

        if (OA_Permission::hasPermission(OA_PERM_MANAGER_DELETE)) {
            //delete
            $deleteConfirm = phpAds_DelConfirm($GLOBALS['strConfirmDeleteClient']);
            addPageLinkTool($GLOBALS["strDelete"], MAX::constructUrl(MAX_URL_ADMIN, "advertiser-delete.php?token=" . urlencode($token) . "&clientid=" . $advertiserId . "&returnurl=advertiser-index.php"), "iconDelete", null, $deleteConfirm);
        }

        addPageLinkTool($GLOBALS["strAddCampaign_Key"], MAX::constructUrl(MAX_URL_ADMIN, "campaign-edit.php?clientid=" . $advertiserId), "iconCampaignAdd", $GLOBALS["keyAddNew"]);
    }

    addPageShortcut($GLOBALS['strAdvertiserCampaigns'], MAX::constructUrl(MAX_URL_ADMIN, "advertiser-campaigns.php?clientid=$advertiserId"), "iconCampaigns");
    addPageShortcut($GLOBALS['strClientHistory'], MAX::constructUrl(MAX_URL_ADMIN, 'stats.php?entity=advertiser&breakdown=history&clientid=' . $advertiserId), 'iconStatistics');
}


function addTrackerPageTools($advertiserId, $trackerId, $aOtherAdvertisers)
{
    if (OA_Permission::isAccount(OA_ACCOUNT_ADMIN) || OA_Permission::isAccount(OA_ACCOUNT_MANAGER)) {
        $token = phpAds_SessionGetToken();

        //duplicate
        addPageLinkTool($GLOBALS["strDuplicate"], MAX::constructUrl(MAX_URL_ADMIN, "tracker-modify.php?token=" . urlencode($token) . "&clientid=" . $advertiserId . "&trackerid=" . $trackerId . "&duplicate=true&returnurl=" . urlencode(basename($_SERVER['SCRIPT_NAME']))), "iconTrackerDuplicate");

        //move to
        $form = "<form action='" . MAX::constructUrl(MAX_URL_ADMIN, 'tracker-modify.php') . "'>
            <input type='hidden' name='token' value='" . htmlspecialchars($token, ENT_QUOTES) . "'>
            <input type='hidden' name='trackerid' value='$trackerId'
            <input type='hidden' name='clientid' value='$advertiserId'
            <input type='hidden' name='returnurl' value='tracker-edit.php'>
            <select name='moveto'>";
        foreach ($aOtherAdvertisers as $advertiser) {
            $form .= "<option value='" . $advertiser['clientid'] . "'>" . htmlspecialchars($advertiser['clientname']) . "</option>";
        }
        $form .= "</select><input type='image' class='submit' src='" . OX::assetPath() . "/images/" . $GLOBALS['phpAds_TextDirection'] . "/go_blue.gif'></form>";
        addPageFormTool($GLOBALS['strMoveTo'], 'iconTrackerMove', $form);

        if (OA_Permission::hasPermission(OA_PERM_MANAGER_DELETE)) {
            //delete
            $deleteConfirm = phpAds_DelConfirm($GLOBALS['strConfirmDeleteTracker']);
            addPageLinkTool($GLOBALS["strDelete"], MAX::constructUrl(MAX_URL_ADMIN, "tracker-delete.php?token=" . urlencode($token) . "&clientid=" . $advertiserId . "&trackerid=" . $trackerId . "&returnurl=advertiser-trackers.php"), "iconDelete", null, $deleteConfirm);
        }

        addPageShortcut($GLOBALS['strBackToTrackers'], MAX::constructUrl(MAX_URL_ADMIN, "advertiser-trackers.php?clientid=$advertiserId"), "iconBack");
    }
}


function addCampaignPageTools($clientid, $campaignid, $aOtherAdvertisers, $aEntities)
{
    global $phpAds_TextDirection;

    if (!OA_Permission::isAccount(OA_ACCOUNT_ADVERTISER)) {
        $token = phpAds_SessionGetToken();

        addPageLinkTool($GLOBALS["strDuplicate"], MAX::constructUrl(MAX_URL_ADMIN, "campaign-modify.php?token=" . urlencode($token) . "&duplicate=1&clientid=$clientid&campaignid=$campaignid&returnurl=" . urlencode(basename($_SERVER['SCRIPT_NAME']))), "iconCampaignDuplicate");

        if (OA_Permission::hasAccessToObject('campaigns', $campaignid, OA_Permission::OPERATION_MOVE)) {
            $form = "<form action='" . MAX::constructUrl(MAX_URL_ADMIN, 'campaign-modify.php') . "'>
            <input type='hidden' name='token' value='" . htmlspecialchars($token, ENT_QUOTES) . "'>
            <input type='hidden' name='clientid' value='$clientid'>
            <input type='hidden' name='campaignid' value='$campaignid'>
            <input type='hidden' name='returnurl' value='" . htmlspecialchars(basename($_SERVER['SCRIPT_NAME'], ENT_QUOTES)) . "'>
            <select name='newclientid'>";

            $aOtherAdvertisers = _multiSort($aOtherAdvertisers, 'name', 'advertiser_id');
            foreach ($aOtherAdvertisers as $aOtherAdvertiser) {
                $otherAdvertiserId = $aOtherAdvertiser['advertiser_id'];
                $otherAdvertiserName = $aOtherAdvertiser['name'];

                if ($otherAdvertiserId != $clientid) {
                    $form .= "<option value='$otherAdvertiserId'>" . htmlspecialchars($otherAdvertiserName) . "</option>";
                }
            }

            $form .= "</select><input type='image' class='submit' src='" . OX::assetPath() . "/images/$phpAds_TextDirection/go_blue.gif'></form>";

            addPageFormTool($GLOBALS['strMoveTo'], 'iconCampaignMove', $form);
        }

        if (OA_Permission::hasPermission(OA_PERM_MANAGER_DELETE)) {
            $deleteConfirm = phpAds_DelConfirm($GLOBALS['strConfirmDeleteCampaign']);
            addPageLinkTool($GLOBALS["strDelete"], MAX::constructUrl(MAX_URL_ADMIN, "campaign-delete.php?token=" . urlencode($token) . "&clientid=$clientid&campaignid=$campaignid&returnurl=advertiser-campaigns.php"), "iconDelete", null, $deleteConfirm);
        }
    }

    //shortcuts
    if (!empty($campaignid) && !OA_Permission::isAccount(OA_ACCOUNT_ADVERTISER)) {
        if (OA_Permission::hasAccessToObject('campaigns', $campaignid, OA_Permission::OPERATION_ADD_CHILD)) {
            addPageLinkTool($GLOBALS["strAddBanner_Key"], MAX::constructUrl(MAX_URL_ADMIN, "banner-edit.php?clientid=$clientid&campaignid=$campaignid"), "iconBannerAdd", $GLOBALS["strAddNew"]);
        }
        addPageShortcut($GLOBALS['strBackToCampaigns'], MAX::constructUrl(MAX_URL_ADMIN, "advertiser-campaigns.php?clientid=$clientid"), "iconBack");
    }
    if (!empty($campaignid)) {
        if (OA_Permission::hasAccessToObject('campaigns', $campaignid, OA_Permission::OPERATION_VIEW_CHILDREN)) {
            addPageShortcut($GLOBALS['strCampaignBanners'], MAX::constructUrl(MAX_URL_ADMIN, "campaign-banners.php?clientid=$clientid&campaignid=$campaignid"), "iconBanners");
        }
        $entityString = _getEntityString($aEntities);
        addPageShortcut($GLOBALS['strCampaignHistory'], MAX::constructUrl(MAX_URL_ADMIN, "stats.php?entity=campaign&breakdown=history&$entityString"), 'iconStatistics');
    }
}

function addBannerPageTools($advertiserId, $campaignId, $bannerId, $aOtherCampaigns, $aOtherBanners, $aEntities)
{
    global $phpAds_TextDirection;

    if (empty($bannerId)) {
        return;
    }

    $token = phpAds_SessionGetToken();

    //duplicate
    addPageLinkTool($GLOBALS["strDuplicate"], MAX::constructUrl(MAX_URL_ADMIN, "banner-modify.php?token=" . urlencode($token) . "&duplicate=true&clientid=$advertiserId&campaignid=$campaignId&bannerid=$bannerId&returnurl=" . urlencode(basename($_SERVER['SCRIPT_NAME']))), "iconBannerDuplicate");

    //move to
    $form = "<form action='" . MAX::constructUrl(MAX_URL_ADMIN, 'banner-modify.php') . "'>
    <input type='hidden' name='token' value='" . htmlspecialchars($token, ENT_QUOTES) . "'>
    <input type='hidden' name='clientid' value='$advertiserId'>
    <input type='hidden' name='campaignid' value='$campaignId'>
    <input type='hidden' name='bannerid' value='$bannerId'>
    <input type='hidden' name='returnurl' value='" . htmlspecialchars(basename($_SERVER['SCRIPT_NAME'])) . "'>
    <select name='moveto'>";
    $aOtherCampaigns = _multiSort($aOtherCampaigns, 'name', 'placement_id');
    foreach ($aOtherCampaigns as $otherCampaignId => $aOtherCampaign) {
        // mask campaign name if anonymous campaign
        $aOtherCampaign['name'] = MAX_getPlacementName($aOtherCampaign);
        $otherCampaignName = $aOtherCampaign['name'];

        if ($aOtherCampaign['placement_id'] != $campaignId) {
            $form .= "<option value='" . $aOtherCampaign['placement_id'] . "'>" . htmlspecialchars($otherCampaignName) . "</option>";
        } else {
            $campaignName = $otherCampaignName;
        }
    }
    $form .= "</select><input name='moveto' class='submit' type='image' src='" . OX::assetPath() . "/images/$phpAds_TextDirection/go_blue.gif'></form>";
    addPageFormTool($GLOBALS['strMoveTo'], 'iconBannerMove', $form);

    //apply to
    if (basename($_SERVER['SCRIPT_NAME']) == 'banner-acl.php') {
        $form = "<form action='" . MAX::constructUrl(MAX_URL_ADMIN, 'banner-modify.php') . "'>
        <input type='hidden' name='token' value='" . htmlspecialchars($token, ENT_QUOTES) . "'>
        <input type='hidden' name='clientid' value='$advertiserId'>
        <input type='hidden' name='campaignid' value='$campaignId'>
        <input type='hidden' name='bannerid' value='$bannerId'>
        <input type='hidden' name='returnurl' value='" . htmlspecialchars(basename($_SERVER['SCRIPT_NAME'])) . "'>
        <select name='applyto'>";

        $aOtherBanners = _multiSort($aOtherBanners, 'name', 'ad_id');
        foreach ($aOtherBanners as $idx => $aOtherBanner) {
            if ($aOtherBanner['ad_id'] != $bannerId) {
                $form .= "<option value='{$aOtherBanner['ad_id']}'>" . htmlspecialchars($aOtherBanner['name']) . "</option>";
            }
        }
        $form .= "</select><input type='image' class='submit' name='applyto' src='" . OX::assetPath() . "/images/" . $phpAds_TextDirection . "/go_blue.gif'></form>";

        addPageFormTool($GLOBALS['strApplyLimitationsTo'], 'iconBannerApplyLimitations', $form);
    }

    //delete
    if (!OA_Permission::isAccount(OA_ACCOUNT_ADVERTISER) && OA_Permission::hasPermission(OA_PERM_MANAGER_DELETE)) {
        $deleteConfirm = phpAds_DelConfirm($GLOBALS['strConfirmDeleteBanner']);
        addPageLinkTool($GLOBALS["strDelete"], MAX::constructUrl(MAX_URL_ADMIN, "banner-delete.php?token=" . urlencode($token) . "&clientid=$advertiserId&campaignid=$campaignId&bannerid=$bannerId&returnurl=campaign-banners.php"), "iconDelete", null, $deleteConfirm);
    }

    /* Shortcuts */
    addPageShortcut($GLOBALS['strBackToBanners'], MAX::constructUrl(MAX_URL_ADMIN, "campaign-banners.php?clientid=$advertiserId&campaignid=$campaignId"), "iconBack");
    $entityString = _getEntityString($aEntities);
    addPageShortcut($GLOBALS['strBannerHistory'], MAX::constructUrl(MAX_URL_ADMIN, "stats.php?entity=banner&breakdown=history&$entityString"), 'iconStatistics');
}


function addWebsitePageTools($websiteId)
{
    $token = phpAds_SessionGetToken();
    
    if (!empty($websiteId) && (OA_Permission::isAccount(OA_ACCOUNT_ADMIN) || OA_Permission::isAccount(OA_ACCOUNT_MANAGER))) {
        addPageLinkTool($GLOBALS["strDuplicate"], MAX::constructUrl(MAX_URL_ADMIN, "affiliate-duplicate.php?token=" . urlencode($token) . "&affiliateid=$websiteId"), "iconWebsiteDuplicate");
    }

    if (!empty($websiteId) && OA_Permission::isAccount(OA_ACCOUNT_MANAGER) && OA_Permission::hasPermission(OA_PERM_MANAGER_DELETE)) {
        //delete
        $deleteConfirm = phpAds_DelConfirm($GLOBALS['strConfirmDeleteAffiliate']);
        addPageLinkTool($GLOBALS["strDelete"], MAX::constructUrl(MAX_URL_ADMIN, "affiliate-delete.php?token=" . urlencode($token) . "&affiliateid=" . $websiteId . "&returnurl=website-index.php"), "iconDelete", null, $deleteConfirm);
    }

    if (!empty($websiteId) && (OA_Permission::isAccount(OA_ACCOUNT_ADMIN)
        || OA_Permission::isAccount(OA_ACCOUNT_MANAGER)
        || OA_Permission::hasPermission(OA_PERM_ZONE_ADD))) {
        addPageLinkTool($GLOBALS["strAddNewZone_Key"], MAX::constructUrl(MAX_URL_ADMIN, "zone-edit.php?affiliateid=$websiteId"), "iconZoneAdd", $GLOBALS["keyAddNew"]);
        addPageShortcut($GLOBALS['strWebsiteZones'], MAX::constructUrl(MAX_URL_ADMIN, "affiliate-zones.php?affiliateid=$websiteId"), "iconZones");
    }
    addPageShortcut($GLOBALS['strAffiliateHistory'], MAX::constructUrl(MAX_URL_ADMIN, 'stats.php?entity=affiliate&breakdown=history&affiliateid=' . $websiteId), 'iconStatistics');
}


function addZonePageTools($affiliateid, $zoneid, $aOtherPublishers, $aEntities)
{
    global $phpAds_TextDirection;

    $token = phpAds_SessionGetToken();

    //duplicate
    if (OA_Permission::isAccount(OA_ACCOUNT_ADMIN)
        || OA_Permission::isAccount(OA_ACCOUNT_MANAGER)
        || OA_Permission::hasPermission(OA_PERM_ZONE_ADD)) {
        addPageLinkTool($GLOBALS["strDuplicate"], MAX::constructUrl(MAX_URL_ADMIN, "zone-modify.php?token=" . urlencode($token) . "&duplicate=true&affiliateid=$affiliateid&zoneid=$zoneid&returnurl=" . urlencode(basename($_SERVER['SCRIPT_NAME']))), "iconZoneDuplicate");
    }

    //move to
    if (OA_Permission::isAccount(OA_ACCOUNT_ADMIN)
        || OA_Permission::isAccount(OA_ACCOUNT_MANAGER)) {
        $form = "<form action='" . MAX::constructUrl(MAX_URL_ADMIN, 'zone-modify.php') . "'>
        <input type='hidden' name='token' value='" . htmlspecialchars($token, ENT_QUOTES) . "'>
        <input type='hidden' name='affiliateid' value='$affiliateid'>
        <input type='hidden' name='zoneid' value='$zoneid'>
        <input type='hidden' name='returnurl' value='" . htmlspecialchars(basename($_SERVER['SCRIPT_NAME'])) . "'>
        <select name='newaffiliateid'>";
        $aOtherPublishers = _multiSort($aOtherPublishers, 'name', 'publisher_id');
        foreach ($aOtherPublishers as $otherPublisherId => $aOtherPublisher) {
            $otherPublisherName = $aOtherPublisher['name'];
            if ($aOtherPublisher['publisher_id'] != $affiliateid) {
                $form .= "<option value='" . $aOtherPublisher['publisher_id'] . "'>" . htmlspecialchars($otherPublisherName) . "</option>";
            }
        }
        $form .= "</select><input type='image' class='submit' src='" . OX::assetPath() . "/images/" . $phpAds_TextDirection . "/go_blue.gif'></form>";

        addPageFormTool($GLOBALS['strMoveTo'], 'iconZoneMove', $form);
    }

    //delete
    if (OA_Permission::isAccount(OA_ACCOUNT_ADMIN)
       || OA_Permission::hasPermission(OA_PERM_MANAGER_DELETE)
       || OA_Permission::hasPermission(OA_PERM_ZONE_DELETE)) {
        $deleteConfirm = phpAds_DelConfirm($GLOBALS['strConfirmDeleteZone']);
        addPageLinkTool($GLOBALS["strDelete"], MAX::constructUrl(MAX_URL_ADMIN, "zone-delete.php?token=" . urlencode($token) . "&affiliateid=$affiliateid&zoneid=$zoneid&returnurl=affiliate-zones.php"), "iconDelete", null, $deleteConfirm);
    }

    //shortcut
    addPageShortcut($GLOBALS['strBackToZones'], MAX::constructUrl(MAX_URL_ADMIN, "affiliate-zones.php?affiliateid=$affiliateid"), "iconBack");
    $entityString = _getEntityString($aEntities);
    addPageShortcut($GLOBALS['strZoneHistory'], MAX::constructUrl(MAX_URL_ADMIN, "stats.php?entity=zone&breakdown=history&$entityString"), 'iconStatistics');
}

function addChannelPageTools($agencyid, $websiteId, $channelid, $channelType)
{
    if ($channelType == 'publisher') {
        $deleteReturlUrl = MAX::constructUrl(MAX_URL_ADMIN, 'affiliate-channels.php');
    } else {
        $deleteReturlUrl = MAX::constructUrl(MAX_URL_ADMIN, 'channel-index.php');
    }

    $token = phpAds_SessionGetToken();

    //duplicate
    addPageLinkTool($GLOBALS["strDuplicate"], MAX::constructUrl(MAX_URL_ADMIN, "channel-modify.php?token=" . urlencode($token) . "&duplicate=true&agencyid=$agencyid&affiliateid=$websiteId&channelid=$channelid&returnurl=" . urlencode(basename($_SERVER['SCRIPT_NAME']))), "iconTargetingChannelDuplicate");

    //delete
    $deleteConfirm = phpAds_DelConfirm($GLOBALS['strConfirmDeleteChannel']);
    addPageLinkTool($GLOBALS["strDelete"], MAX::constructUrl(MAX_URL_ADMIN, "channel-delete.php?token=" . urlencode($token) . "&agencyid=$agencyid&affiliateid=$websiteId&channelid=$channelid&returnurl=$deleteReturlUrl"), "iconDelete", null, $deleteConfirm);
}


/**
 * Builds Pear pager object, preconfigured with items per page. Pager links are
 * processed to make them more readable. Also items name in summary can be added.
 *
 * @param unknown_type $items
 * @param unknown_type $itemsPerPage
 * @param unknown_type $withNumbers
 * @param unknown_type $itemsName
 * @return unknown
 */
function OX_buildPager(
    $items,
    $itemsPerPage,
    $withNumbers = true,
    $itemsName = '',
    $delta = 4,
    $currentPage = null,
    $fileName = null,
    $params = null
) {
    require_once MAX_PATH . '/lib/pear/Pager/Pager.php';

    $oTrans = new OX_Translation();

    /** prepare paging **/
    $count = count($items);
    $delta = $withNumbers ? $delta : 0;


    $pagerOptions = [
        'mode' => 'Sliding',
        'perPage' => $itemsPerPage,
        'delta' => $delta,
        'totalItems' => $count,
        'prevImg' => '&lt; ' . $oTrans->translate('Back'),
        'nextImg' => $oTrans->translate('Next') . ' &gt;',
        'urlVar' => 'p',
        'linkClass' => 'page',
        'curPageLinkClassName' => 'current',
        'spacesBeforeSeparator' => 0,
        'httpMethod' => 'GET',
        'spacesAfterSeparator' => 0
    ];
    if (!empty($fileName)) {
        $pagerOptions['fileName'] = $fileName;
        $pagerOptions['fixFileName'] = false;
    }
    if (!empty($params)) {
        $pagerOptions['extraVars'] = $params;
    }
    if (!empty($currentPage)) {
        $pagerOptions['currentPage'] = $currentPage;
    }

    $pager = Pager::factory($pagerOptions);
    list($from, $to) = $pager->getOffsetByPageId();
    $summary = "<em>$from</em>-<em>$to</em> of <em>" . $pager->numItems() . " $itemsName</em>";
    $pager->summary = $summary;

    //override links with shorter pager controls
    if (!$withNumbers) {
        $links = $pager->links;
        $shortLinks = preg_replace("/<span class=\"current\">\d+<\/span>/i", "<span class='summary'>$summary</span>", $links);
        $shortLinks = preg_replace("/\[\d+\]/", "", $shortLinks);
        $pager->links = $shortLinks;
    }

    return $pager;
}
