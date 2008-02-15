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

// Require the initialisation file
require_once '../../init.php';

// Required files
require_once MAX_PATH . '/lib/OA/Dal.php';
require_once MAX_PATH . '/www/admin/config.php';
require_once MAX_PATH . '/www/admin/lib-maintenance.inc.php';
require_once MAX_PATH . '/www/admin/lib-statistics.inc.php';
require_once MAX_PATH . '/lib/max/Admin_DA.php';
require_once MAX_PATH . '/lib/max/Admin/UI/Field/DaySpanField.php';

// Security check
//OA_Permission::enforceAccount(OA_ACCOUNT_ADMIN, OA_ACCOUNT_ADVERTISER);

// Switched off
OA_Permission::enforceAccount(0);


/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

phpAds_PageHeader("5.4");
if (OA_Permission::isAccount(OA_ACCOUNT_MANAGER)) {
	phpAds_ShowSections(array("5.2", "5.4", "5.3"));
} else {
	phpAds_ShowSections(array("5.1", "5.2", "5.4", "5.5", "5.3", "5.6", "5.7"));
}
phpAds_MaintenanceSelection("finance");



/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/



echo "<br />".'Finance explaination';

echo "<br /><br />";

echo "<form name='zoneform' method='post' action='".(empty($zoneid) ? 'maintenance-finance.php' : 'maintenance-finance-rebuild.php')."'>";

echo "<br /><table border='0' width='100%' cellpadding='0' cellspacing='0'>";
echo "<tr><td height='25' colspan='3'><b>".$strBasicInformation."</b></td></tr>";
echo "<tr height='1'><td colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";

echo "<tr><td width='30'>&nbsp;</td><td width='200'>".$strZone."</td><td>";

$aParams = array();

if (OA_Permission::isAccount(OA_ACCOUNT_MANAGER)) {
	$aParams['agency_id'] = OA_Permission::getEntityId();
}

if (empty($zoneid)) {
	echo "<select name='zoneid' id='zoneid' tabindex='".($tabindex++)."'>";

	$aZones = Admin_DA::fromCache('getZones', $aParams);

	foreach ($aZones as $zoneId => $zone) {
		echo "<option value='{$zone['zone_id']}'>".strip_tags(phpAds_buildZoneName($zoneId, $zone['name']))."</option>";
	}

	echo "</select>";
} else {
	$aParams['zone_id'] = $zoneid;
	$aZones = Admin_DA::fromCache('getZones', $aParams, true);

	foreach ($aZones as $zoneId => $zone) {
		echo "<b>".strip_tags(phpAds_buildZoneName($zoneId, $zone['name']))."</b>";
		echo "<input type='hidden' name='zoneid' value='".$zoneId."' />";
	}
}

echo "</td>";
echo "</tr><tr><td><img src='images/spacer.gif' height='1' width='100%'></td>";

if (!empty($zoneid)) {
	$zone = end($aZones);

	echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";
	echo "<tr><td width='30'>&nbsp;</td><td width='200'>". 'Period' ."</td><td>";

	$oDaySpan =& new Admin_UI_DaySpanField('period');
	$oDaySpan->display();

	echo "</td>";
	echo "</tr><tr><td><img src='images/spacer.gif' height='1' width='100%'></td>";
	echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";

	echo "<tr><td width='30'>&nbsp;</td>";
	echo "<td width='200'>".$strCostInfo."</td>";
	echo "<td>";
	echo "<input type='text' name='cost' size='10' value='".($zone['cost'] ? $zone['cost'] : '0.0000')."' tabindex='".($tabindex++)."'>&nbsp;";
	echo "&nbsp;&nbsp;";
	echo "<select name='cost_type' id='cost_type' onchange='m3_updateFinance()'>";
	echo "  <option value='".MAX_FINANCE_CPM."' ".(($zone['cost_type'] == MAX_FINANCE_CPM) ? ' SELECTED ' : '').">$strFinanceCPM</option>";
	echo "  <option value='".MAX_FINANCE_CPC."' ".(($zone['cost_type'] == MAX_FINANCE_CPC) ? ' SELECTED ' : '').">$strFinanceCPC</option>";
	echo "  <option value='".MAX_FINANCE_CPA."' ".(($zone['cost_type'] == MAX_FINANCE_CPA) ? ' SELECTED ' : '').">$strFinanceCPA</option>";
	echo "  <option value='".MAX_FINANCE_MT."' ".(($zone['cost_type'] == MAX_FINANCE_MT) ? ' SELECTED ' : '').">$strFinanceMT</option>";
	echo "  <option value='".MAX_FINANCE_RS."' ".(($zone['cost_type'] == MAX_FINANCE_RS) ? ' SELECTED ' : '').">". '% Revenue split' ."</option>";
	echo "  <option value='".MAX_FINANCE_BV."' ".(($zone['cost_type'] == MAX_FINANCE_BV) ? ' SELECTED ' : '').">". '% Basket value' ."</option>";
	echo "  <option value='".MAX_FINANCE_AI."' ".(($zone['cost_type'] == MAX_FINANCE_AI) ? ' SELECTED ' : '').">". 'Amount per item' ."</option>";
	echo "  <option value='".MAX_FINANCE_ANYVAR."' ".(($zone['cost_type'] == MAX_FINANCE_ANYVAR) ? ' SELECTED ' : '').">". '% Custom variable' ."</option>";
    echo "  <option value='".MAX_FINANCE_VARSUM."' ".(($zone['cost_type'] == MAX_FINANCE_VARSUM) ? ' SELECTED ' : '').">". '% Sum of variables' ."</option>";
	echo "</select>";
	echo "&nbsp;&nbsp;";

	$dalVariables = OA_Dal::factoryDAL('variables');
    $rsVariables = $dalVariables->getTrackerVariables($zoneid, $affiliateid, OA_Permission::isAccount(OA_ACCOUNT_TRAFFICKER));
    $res_tracker_variables = $rsVariables->getAll();

    echo "<select name='cost_variable_id' id='cost_variable_id'>";

    if (empty($res_tracker_variables)) {
        echo "<option value=''>-- No linked tracker --</option>";
    } else {
        foreach ($res_tracker_variables as $k=>$v) {
            echo "<option value='{$v['variable_id']}' ".(($zone['cost_variable_id'] == $v['variable_id']) ? ' SELECTED ' : '').">".
                "[id".$v['tracker_id']."] ".
                htmlspecialchars(empty($v['tracker_description']) ? $v['tracker_name'] : $v['tracker_description']).
                ": ".
                htmlspecialchars(empty($v['variable_description']) ? $v['variable_name'] : $v['variable_description']).
            "</option>";
        }
    }

    echo "</select>";

    if (strpos($zone['cost_variable_id'], ',')) {
        $cost_variable_ids = explode(',', $zone['cost_variable_id']);
    } else {
        $cost_variable_ids = array($zone['cost_variable_id']);
    }

    echo "<select name='cost_variable_id_mult[]' id='cost_variable_id_mult' multiple='multiple' size='3'>";

    if (empty($res_tracker_variables)) {
        echo "<option value=''>-- No linked tracker --</option>";
    } else {
        foreach ($res_tracker_variables as $k=>$v) {
            echo "<option value='{$v['variable_id']}' ".(in_array($v['variable_id'], $cost_variable_ids) ? ' SELECTED ' : '').">".
                "[id".$v['tracker_id']."] ".
                htmlspecialchars(empty($v['tracker_description']) ? $v['tracker_name'] : $v['tracker_description']).
                ": ".
                htmlspecialchars(empty($v['variable_description']) ? $v['variable_name'] : $v['variable_description']).
            "</option>";
        }
    }

    echo "</select>";
	echo "</td>";
	echo "</tr><tr><td><img src='images/spacer.gif' height='1' width='100%'></td>";
	echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";

	echo "<tr><td width='30'>&nbsp;</td>";
	echo "<td width='200'>".$strTechnologyCost."</td>";
	echo "<td>";
	echo "<input type='text' name='technology_cost' size='10' value='".($zone['technology_cost'] ? $zone['technology_cost'] : '0.0000')."' tabindex='".($tabindex++)."'>&nbsp;";
	echo "&nbsp;&nbsp;";
	echo "<select name='technology_cost_type' id='technology_cost_type' onchange='m3_updateFinance()'>";
	echo "  <option value='".MAX_FINANCE_CPM."' ".(($zone['technology_cost_type'] == MAX_FINANCE_CPM) ? ' SELECTED ' : '').">$strFinanceCPM</option>";
	echo "  <option value='".MAX_FINANCE_CPC."' ".(($zone['technology_cost_type'] == MAX_FINANCE_CPC) ? ' SELECTED ' : '').">$strFinanceCPC</option>";
	echo "  <option value='".MAX_FINANCE_RS."' ".(($zone['technology_cost_type'] == MAX_FINANCE_RS) ? ' SELECTED ' : '').">". '% Revenue split' ."</option>";
	echo "</select>";
	echo "</td></tr>";
}

echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";
echo "<tr height='1'><td colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
echo "</table>";

echo "<br /><br />";

if (!empty($zoneid)) {
	echo "<input type='button' value='Back' onclick='location.href=\"maintenance-finance.php\"' />&nbsp;&nbsp;";
}

echo "<input type='submit' name='submit' value='".(isset($zoneid) && $zoneid != '' ? $strProceed : $strNext.' >')."' tabindex='".($tabindex++)."'>";
echo "</form>";

echo "<br /><br />";

?>

<script language='JavaScript'>
<!--

    function m3_updateFinance()
    {
        var o = document.getElementById('cost_type');
        var p = document.getElementById('cost_variable_id');
        var p2 = document.getElementById('cost_variable_id_mult');

        if ( o.options[o.selectedIndex].value == <?php echo MAX_FINANCE_ANYVAR; ?>) {
            p.style.display = '';
            p2.style.display = 'none';
        } else if (o.options[o.selectedIndex].value == <?php echo MAX_FINANCE_VARSUM; ?>) {
            p.style.display = 'none';
            p2.style.display = '';
        } else {
            p.style.display = 'none';
            p2.style.display = 'none';
        }
    }

    m3_updateFinance();

//-->
</script>

<?php

/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

phpAds_PageFooter();

?>
