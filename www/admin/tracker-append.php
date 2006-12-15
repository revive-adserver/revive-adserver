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
require_once MAX_PATH . '/lib/max/Admin/Inventory/TrackerAppend.php';

// Security check
phpAds_checkAccess(phpAds_Admin + phpAds_Agency);

// Initialize trackerAppend class
$trackerAppend = new Max_Admin_Inventory_TrackerAppend();


/*-------------------------------------------------------*/
/* Affiliate interface security                          */
/*-------------------------------------------------------*/

if (phpAds_isUser(phpAds_Agency)) {
    $query = "SELECT c.clientid as clientid".
        " FROM ".$conf['table']['prefix'].$conf['table']['clients']." AS c".
        ",".$conf['table']['prefix'].$conf['table']['trackers']." AS t".
        " WHERE t.clientid=c.clientid".
        " AND c.clientid='".$clientid."'".
        " AND t.trackerid='".$trackerid."'".
        " AND c.agencyid=".phpAds_getUserID();

    $res = phpAds_dbQuery($query)
        or phpAds_sqlDie();
    
    if (phpAds_dbNumRows($res) == 0) {
        phpAds_PageHeader("1");
        phpAds_Die ($strAccessDenied, $strNotAdmin);
    }
} 

/*-------------------------------------------------------*/
/* Process submitted form                                */
/*-------------------------------------------------------*/
header("Content-Type: text/html; charset=ISO-8859-1");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $trackerAppend->handlePost($_POST);
} else {
    $trackerAppend->handleGet();
}


/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

// Get other trackers
$res = phpAds_dbQuery(
    "SELECT *".
    " FROM ".$conf['table']['prefix'].$conf['table']['trackers'].
    " WHERE clientid='".$clientid."'".
    phpAds_getTrackerListOrder ($navorder, $navdirection)
);

while ($row = phpAds_dbFetchArray($res)) {
    phpAds_PageContext (
        phpAds_buildName ($row['trackerid'], $row['trackername']),
        "tracker-append.php?clientid=".$clientid."&trackerid=".$row['trackerid'],
        $trackerid == $row['trackerid']
    );
}

if (phpAds_isUser(phpAds_Admin) || phpAds_isUser(phpAds_Agency))
{
    phpAds_PageShortcut($strClientProperties, 'advertiser-edit.php?clientid='.$clientid, 'images/icon-advertiser.gif');

    $extra  = "\t\t\t\t<form action='tracker-modify.php'>"."\n";
    $extra .= "\t\t\t\t<input type='hidden' name='trackerid' value='$trackerid'>"."\n";
    $extra .= "\t\t\t\t<input type='hidden' name='clientid' value='$clientid'>"."\n";
    $extra .= "\t\t\t\t<input type='hidden' name='returnurl' value='tracker-append.php'>"."\n";
    $extra .= "\t\t\t\t<br /><br />"."\n";
    $extra .= "\t\t\t\t<b>$strModifyTracker</b><br />"."\n";
    $extra .= "\t\t\t\t<img src='images/break.gif' height='1' width='160' vspace='4'><br />"."\n";
    $extra .= "\t\t\t\t<img src='images/icon-duplicate-tracker.gif' align='absmiddle'>&nbsp;<a href='tracker-modify.php?clientid=".$clientid."&trackerid=".$trackerid."&duplicate=true&returnurl=tracker-campaigns.php'>$strDuplicate</a><br />"."\n";
    $extra .= "\t\t\t\t<img src='images/break.gif' height='1' width='160' vspace='4'><br />"."\n";
    $extra .= "\t\t\t\t<img src='images/icon-move-tracker.gif' align='absmiddle'>&nbsp;$strMoveTo<br />"."\n";
    $extra .= "\t\t\t\t<img src='images/spacer.gif' height='1' width='160' vspace='2'><br />"."\n";
    $extra .= "\t\t\t\t&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"."\n";
    $extra .= "\t\t\t\t<select name='moveto' style='width: 110;'>"."\n";

    if (phpAds_isUser(phpAds_Admin)) {
        $query = "SELECT clientid,clientname".
            " FROM ".$conf['table']['prefix'].$conf['table']['clients'].
            " WHERE clientid != '".$clientid."'";
    } elseif (phpAds_isUser(phpAds_Agency)) {
        $query = "SELECT clientid,clientname".
        " FROM ".$conf['table']['prefix'].$conf['table']['clients'].
        " WHERE clientid != '".$clientid."'".
        " AND agencyid=".phpAds_getUserID();
    }
    $res = phpAds_dbQuery($query)
        or phpAds_sqlDie();
    
    while ($row = phpAds_dbFetchArray($res)) {
        $extra .= "\t\t\t\t\t<option value='".$row['clientid']."'>".phpAds_buildName($row['clientid'], $row['clientname'])."</option>\n";
    }
    
    $extra .= "\t\t\t\t</select>&nbsp;\n";
    $extra .= "\t\t\t\t<input type='image' src='images/".$phpAds_TextDirection."/go_blue.gif'><br />\n";
    $extra .= "\t\t\t\t<img src='images/break.gif' height='1' width='160' vspace='4'><br />\n";
    $extra .= "\t\t\t\t<img src='images/icon-recycle.gif' align='absmiddle'>\n";
    $extra .= "\t\t\t\t<a href='tracker-delete.php?clientid=$clientid&trackerid=$trackerid&returnurl=advertiser-trackers.php'".phpAds_DelConfirm($strConfirmDeleteTracker).">$strDelete</a><br />\n";
    $extra .= "\t\t\t\t</form>\n";
    
    phpAds_PageHeader("4.1.4.6", $extra);
    echo "\t\t\t\t<img src='images/icon-advertiser.gif' align='absmiddle'>&nbsp;".phpAds_getClientName($clientid)."\n";
    echo "\t\t\t\t<img src='images/".$phpAds_TextDirection."/caret-rs.gif'>\n";
    echo "\t\t\t\t<img src='images/icon-tracker.gif' align='absmiddle'>\n";
    echo "\t\t\t\t<b>".phpAds_getTrackerName($trackerid)."</b><br /><br /><br />\n";
    phpAds_ShowSections(array("4.1.4.2", "4.1.4.3", "4.1.4.5", "4.1.4.6", "4.1.4.4"));
}


$trackerAppend->display();



/*-------------------------------------------------------*/
/* Store preferences                                     */
/*-------------------------------------------------------*/

$session['prefs']['tracker-variables.php']['trackerid'] = $trackerid;
    

phpAds_SessionDataStore();

phpAds_PageFooter();

?>