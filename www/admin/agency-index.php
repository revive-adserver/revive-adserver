<?php

/*
+---------------------------------------------------------------------------+
| Max Media Manager v0.3                                                    |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2006 m3 Media Services Limited                         |
| For contact details, see: http://www.m3.net/                              |
|                                                                           |
| Copyright (c) 2000-2003 the phpAdsNew developers                          |
| For contact details, see: http://www.phpadsnew.com/                       |
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

// Require the initialisation file
require_once '../../init.php';

// Required files
require_once MAX_PATH . '/www/admin/config.php';
require_once MAX_PATH . '/www/admin/lib-statistics.inc.php'; 

// Register input variables
phpAds_registerGlobal('expand', 'collapse', 'hideinactive', 'listorder',
                      'orderdirection');

// Security check
MAX_Permission::checkAccess(phpAds_Admin);

/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

phpAds_PrepareHelp();
phpAds_PageHeader("5.5");
phpAds_ShowSections(array("5.1", "5.3", "5.4", "5.2", "5.5", "5.6"));


/*-------------------------------------------------------*/
/* Get preferences                                       */
/*-------------------------------------------------------*/

if (!isset($hideinactive))
{
    if (isset($session['prefs']['agency-index.php']['hideinactive'])) {
        $hideinactive = $session['prefs']['agency-index.php']['hideinactive'];
    } else {
        $pref = &$GLOBALS['_MAX']['PREF'];
        $hideinactive = ($pref['gui_hide_inactive'] == 't');
    }
}

if (!isset($listorder))
{
    if (isset($session['prefs']['agency-index.php']['listorder']))
        $listorder = $session['prefs']['agency-index.php']['listorder'];
    else
        $listorder = '';
}

if (!isset($orderdirection))
{
    if (isset($session['prefs']['agency-index.php']['orderdirection']))
        $orderdirection = $session['prefs']['agency-index.php']['orderdirection'];
    else
        $orderdirection = '';
}

if (isset($session['prefs']['agency-index.php']['nodes']))
    $node_array = explode (",", $session['prefs']['agency-index.php']['nodes']);
else
    $node_array = array();



/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

// Get agencies & campaign and build the tree
if (phpAds_isUser(phpAds_Admin))
{
    $doAgency = MAX_DB::factoryDO('agency');
    $agencies = $doAgency->getAll(array('name', 'agencyid'), true, false);
}

foreach ($agencies as $k => $v) {
    $agencies[$k]['expand'] = 0;
    $agencies[$k]['count'] = 0;
    $agencies[$k]['hideinactive'] = 0;
}


// using same icons and images for agencies as we do for advertisers...
echo "\t\t\t\t<img src='images/icon-advertiser-new.gif' border='0' align='absmiddle'>&nbsp;\n";
echo "\t\t\t\t<a href='agency-edit.php' accesskey='".$keyAddNew."'>".$strAddAgency_Key."</a>&nbsp;&nbsp;\n";
phpAds_ShowBreak();



echo "\t\t\t\t<br /><br />\n";
echo "\t\t\t\t<table border='0' width='100%' cellpadding='0' cellspacing='0'>\n";

echo "\t\t\t\t<tr height='25'>\n";
echo "\t\t\t\t\t<td height='25' width='40%'>\n";
echo "\t\t\t\t\t\t<b>&nbsp;&nbsp;<a href='agency-index.php?listorder=name'>".$GLOBALS['strName']."</a>";

if (($listorder == "name") || ($listorder == ""))
{
    if  (($orderdirection == "") || ($orderdirection == "down"))
    {
        echo " <a href='agency-index.php?orderdirection=up'>";
        echo "<img src='images/caret-ds.gif' border='0' alt='' title=''>";
    }
    else
    {
        echo " <a href='agency-index.php?orderdirection=down'>";
        echo "<img src='images/caret-u.gif' border='0' alt='' title=''>";
    }
    echo "</a>";
}

echo "</b>\n";
echo "\t\t\t\t\t</td>\n";
echo "\t\t\t\t\t<td height='25'>\n";
echo "\t\t\t\t\t\t<b><a href='agency-index.php?listorder=id'>".$GLOBALS['strID']."</a>";

if ($listorder == "id")
{
    if  (($orderdirection == "") || ($orderdirection == "down"))
    {
        echo " <a href='agency-index.php?orderdirection=up'>";
        echo "<img src='images/caret-ds.gif' border='0' alt='' title=''>";
    }
    else
    {
        echo " <a href='agency-index.php?orderdirection=down'>";
        echo "<img src='images/caret-u.gif' border='0' alt='' title=''>";
    }
    echo "</a>";
}

echo "</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\n";
echo "\t\t\t\t\t</td>\n";
echo "\t\t\t\t\t<td height='25'>&nbsp;</td>\n";
echo "\t\t\t\t\t<td height='25'>&nbsp;</td>\n";
echo "\t\t\t\t\t<td height='25'>&nbsp;</td>\n";
echo "\t\t\t\t\t<td height='25'>&nbsp;</td>\n";
echo "\t\t\t\t</tr>\n";

echo "\t\t\t\t<tr height='1'>\n";
echo "\t\t\t\t\t<td colspan='6' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td>\n";
echo "\t\t\t\t</tr>\n";


if (!isset($agencies) || !is_array($agencies) || count($agencies) == 0)
{
    echo "\t\t\t\t<tr height='25' bgcolor='#F6F6F6'>\n";
    echo "\t\t\t\t\t<td height='25' colspan='5'>&nbsp;&nbsp;".$strNoAgencies."</td>\n";
    echo "\t\t\t\t</tr>\n";
    
    echo "\t\t\t\t<tr>\n";
    echo "\t\t\t\t\t<td colspan='6' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td>\n";
    echo "\t\t\t\t<tr>\n";
}
else
{
    $i=0;
    foreach (array_keys($agencies) as $key)
    {
        $agency = $agencies[$key];
        $channels = Admin_DA::getChannels(array('agency_id' => $agency['agencyid'], 'channel_type' => 'agency'));
        
        echo "\t\t\t\t<tr height='25' ".($i%2==0?"bgcolor='#F6F6F6'":"").">\n";
        
        // Icon & name
        echo "\t\t\t\t\t<td height='25'>\n";
        echo "\t\t\t\t\t\t<img src='images/spacer.gif' height='16' width='16' align='absmiddle'>\n";
            
        echo "\t\t\t\t\t\t<img src='images/icon-advertiser.gif' align='absmiddle'>\n";
        echo "\t\t\t\t\t\t<a href='agency-edit.php?agencyid=".$agency['agencyid']."'>".$agency['name']."</a>\n";
        echo "\t\t\t\t\t</td>\n";
        
        // ID
        echo "\t\t\t\t\t<td height='25'>".$agency['agencyid']."</td>\n";
        
        echo "\t\t\t\t\t<td height='25'>&nbsp;</td>\n";
        echo "\t\t\t\t\t<td height='25'>&nbsp;</td>\n";
        
        // Button - Channel overview
        echo "<td height='25'>";
        echo "<a href='channel-index.php?agencyid={$agency['agencyid']}'>";
        if (empty($channels)) {
            echo "<img src='images/icon-channel-d.gif' border='0' align='absmiddle' alt='{$GLOBALS['strChannels']}'>";
        } else {
            echo "<img src='images/icon-channel.gif' border='0' align='absmiddle' alt='{$GLOBALS['strChannels']}'>";
        }
        echo "&nbsp;{$GLOBALS['strChannels']}</a>&nbsp;&nbsp;";
        
        echo "</td>";
        
        // Delete
        echo "\t\t\t\t\t<td height='25'>";
        echo "<a href='agency-delete.php?agencyid=".$agency['agencyid']."&returnurl=agency-index.php'".phpAds_DelConfirm($strConfirmDeleteAgency)."><img src='images/icon-recycle.gif' border='0' align='absmiddle' alt='$strDelete'>&nbsp;$strDelete</a>&nbsp;&nbsp;&nbsp;&nbsp;";
        echo "</td>\n";

        echo "\t\t\t\t</tr>\n";
        
        echo "\t\t\t\t<tr height='1'>\n";
        echo "\t\t\t\t\t<td colspan='6' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td>\n";
        echo "\t\t\t\t</tr>\n";
        $i++;
    }
}

echo "\t\t\t\t<tr>\n";
echo "\t\t\t\t\t<td height='25' colspan='4' align='".$phpAds_TextAlignLeft."' nowrap>";

if ($hideinactive == true)
{
    echo "&nbsp;&nbsp;<img src='images/icon-activate.gif' align='absmiddle' border='0'>";
    echo "&nbsp;<a href='agency-index.php?hideinactive=0'>".$strShowAll."</a>";
    echo "&nbsp;&nbsp;|&nbsp;&nbsp;" . $strInactiveAgenciesHidden;
}
else
{
    echo "&nbsp;&nbsp;<img src='images/icon-hideinactivate.gif' align='absmiddle' border='0'>";
    echo "&nbsp;<a href='agency-index.php?hideinactive=1'>".$strHideInactiveAgencies."</a>";
}

echo "</td>\n";

echo "<td></td>\n";
echo "\t\t\t\t</tr>\n";

echo "\t\t\t\t</table>\n";


// total number of agencies
$agencyCount = $doAgency->getRowCount();

echo "\t\t\t\t<br /><br /><br /><br />\n";
echo "\t\t\t\t<table width='100%' border='0' align='center' cellspacing='0' cellpadding='0'>\n";
echo "\t\t\t\t<tr>\n";
echo "\t\t\t\t\t<td height='25' colspan='3'>&nbsp;&nbsp;<b>".$strOverall."</b></td>\n";
echo "\t\t\t\t</tr>\n";
echo "\t\t\t\t<tr height='1'>\n";
echo "\t\t\t\t\t<td colspan='4' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td>\n";
echo "\t\t\t\t</tr>\n";

echo "\t\t\t\t<tr>\n";
echo "\t\t\t\t\t<td height='25'>&nbsp;&nbsp;".$strTotalAgencies.": <b>" . $agencyCount . "</b></td>\n";
echo "\t\t\t\t\t<td height='25' colspan='2'></td>\n";
echo "\t\t\t\t</tr>\n";

echo "\t\t\t\t<tr height='1'>\n";
echo "\t\t\t\t\t<td colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td>\n";
echo "\t\t\t\t</tr>\n";

echo "\t\t\t\t</table>\n";
echo "\t\t\t\t<br /><br />\n";

/*-------------------------------------------------------*/
/* Store preferences                                     */
/*-------------------------------------------------------*/

$session['prefs']['agency-index.php']['hideinactive']   = $hideinactive;
$session['prefs']['agency-index.php']['listorder']      = $listorder;
$session['prefs']['agency-index.php']['orderdirection'] = $orderdirection;
$session['prefs']['agency-index.php']['nodes']          = implode (",", $node_array);

phpAds_SessionDataStore();

/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

phpAds_PageFooter();

?>
