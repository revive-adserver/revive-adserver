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

// Require the initialisation file
require_once '../../init.php';

// Required files
require_once MAX_PATH . '/lib/OA/Dal.php';
require_once MAX_PATH . '/www/admin/config.php';
require_once MAX_PATH . '/www/admin/lib-statistics.inc.php';
require_once MAX_PATH . '/lib/max/other/html.php';

// Register input variables
phpAds_registerGlobal (
    'action',
    'variablemethod'
);

// Since there may be an unknown number of variables posted (which are accessed by $_POST directly in the code below),
// clean the whole $_POST array
MAX_commonRemoveSpecialChars($_POST);

/*-------------------------------------------------------*/
/* Affiliate interface security                          */
/*-------------------------------------------------------*/

OA_Permission::enforceAccount(OA_ACCOUNT_MANAGER);
OA_Permission::enforceAccessToObject('clients', $clientid);
OA_Permission::enforceAccessToObject('trackers', $trackerid);

/*-------------------------------------------------------*/
/* Store preferences									 */
/*-------------------------------------------------------*/
$session['prefs']['inventory_entities'][OA_Permission::getEntityId()]['clientid'] = $clientid;
phpAds_SessionDataStore();

/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

if (!isset($variables))
    if (isset($session['prefs']['tracker-variables.php']['variables']) && $session['prefs']['tracker-variables.php']['trackerid']==$trackerid)
        $variables = $session['prefs']['tracker-variables.php']['variables'];



if (!empty($trackerid))
{
    // Get publisher list
    $dalAffiliates = OA_Dal::factoryDAL('affiliates');
    $rsAffiliates = $dalAffiliates->getPublishersByTracker($trackerid);
    $rsAffiliates->find();

    $publishers = array();
    while ($rsAffiliates->fetch() && $row = $rsAffiliates->toArray()) {
        $publishers[$row['affiliateid']] = strip_tags(phpAds_BuildAffiliateName($row['affiliateid'], $row['name']));
    }

    if (!isset($variablemethod)) {
        // get variable method
        $doTrackers = OA_Dal::factoryDO('trackers');
        if ($doTrackers->get($trackerid)) {
            $variablemethod = $doTrackers->variablemethod;
        }
    }

    if (!isset($variables))
    {
        // get variables from db
        $doVariables = OA_Dal::factoryDO('variables');
        $doVariables->trackerid = $trackerid;
        $doVariables->find();

        $variables = array();
        while ($doVariables->fetch() && $vars = $doVariables->toArray())
        {
            // Remove assignment
            $vars['variablecode'] = addslashes(trim(preg_replace('/^.+?=/', '', $vars['variablecode'])));

            $vars['publisher_visible'] = array();
            $vars['publisher_hidden']  = array();

            $variables[$vars['variableid']] = $vars;
        }

        // get publisher visibility from db
        $doVariables = OA_Dal::factoryDO('variables');
        $doVariables->trackerid = $trackerid;
        $doVariable_publisher = OA_Dal::factoryDO('variable_publisher');
        $doVariables->joinAdd($doVariable_publisher);
        $doVariables->find();

        while ($doVariables->fetch() && $pubs = $doVariables->toArray())
        {
            if ($pubs['visible'] && $variables[$pubs['variable_id']]['hidden'] == 't') {
                $variables[$pubs['variable_id']]['publisher_visible'][] = $pubs['publisher_id'];
            } elseif (!$pubs['visible'] && $variables[$pubs['variable_id']]['hidden'] != 't') {
                $variables[$pubs['variable_id']]['publisher_hidden'][] = $pubs['publisher_id'];
            }
        }

        // Remove keys]
        if (isset($variables))
        {
            $variables = array_values($variables);
        }
    }
    else
    {
        // Get values on the form
        for ($f=0; $f < sizeof($variables)+1; $f++)
        if (isset($_POST['name'.$f]))
        {

            $variables[$f]['name'] = $_POST['name'.$f];
            $variables[$f]['description'] = $_POST['description'.$f];
            $variables[$f]['datatype'] = $_POST['datatype'.$f];
            $variables[$f]['purpose'] = $_POST['purpose'.$f];
            $variables[$f]['reject_if_empty'] = isset($_POST['reject_if_empty'.$f]) ? $_POST['reject_if_empty'.$f] : '';
            $variables[$f]['is_unique'] = isset($_POST['is_unique'.$f]) ? $_POST['is_unique'.$f] : '';
            // Set window delays
            $uniqueWindowSeconds = 0;
            if (!empty($_POST['uniquewindow'.$f]))
            {
                $uniqueWindow = $_POST['uniquewindow'.$f];
                if ($uniqueWindow['second'] != '-')  $uniqueWindowSeconds += (int)$uniqueWindow['second'];
                if ($uniqueWindow['minute'] != '-')  $uniqueWindowSeconds += (int)$uniqueWindow['minute'] * 60;
                if ($uniqueWindow['hour'] != '-')      $uniqueWindowSeconds += (int)$uniqueWindow['hour'] * 60*60;
                if ($uniqueWindow['day'] != '-')      $uniqueWindowSeconds += (int)$uniqueWindow['day'] * 60*60*24;
            }
            $variables[$f]['unique_window'] = $uniqueWindowSeconds;
            $variables[$f]['variablecode'] = $_POST['variablecode'.$f];

            $variables[$f]['publisher_visible'] = array();
            $variables[$f]['publisher_hidden']  = array();

            switch ($_POST['visibility'.$f]) {
                case 'all':
                    $variables[$f]['hidden'] = 't';
                    break;
                case 'none':
                    $variables[$f]['hidden'] = 'f';
                    break;
                default:
                    $variables[$f]['hidden'] = $_POST['p_default'.$f] ? 'f' : 't';
                    if ($_POST['p_default'.$f]) {
                        $variables[$f]['publisher_hidden']  = isset($_POST['p_hide'.$f]) && is_array($_POST['p_hide'.$f]) ? $_POST['p_hide'.$f] : array();
                    } else {
                        $variables[$f]['publisher_visible'] = isset($_POST['p_show'.$f]) && is_array($_POST['p_show'.$f]) ? $_POST['p_show'.$f] : array();
                    }
            }
        }
    }

    // insert a new variable
    if (isset($action['new']))
            $variables[] = array(
                'publisher_visible' => array(),
                'publisher_hidden' => array(),
                'name' => '',
                'hidden' => 'f',
                'description' => '',
                'datatype' => 'string',
                'purpose' => '',
                'reject_if_empty' => '',
                'is_unique' => null,
                'unique_window' => 0,
                'variablecode' => '',
            );


    // has user clicked on save changes?
    if (isset($action['save']))
    {
        // save variablemethod
        $doTrackers = OA_Dal::factoryDO('trackers');
        $doTrackers->get($trackerid);
        $doTrackers->variablemethod = $variablemethod;
        $doTrackers->update();

        $isUniqueAlreadyExists = false;
        foreach($variables as $k => $v)
        {
            // Set purpose to NULL when generic was chosen
            if (!empty($v['purpose'])) {
                $v['purpose'] = $v['purpose'];
            } else {
                $v['purpose'] = "NULL";
            }

            if ($v['is_unique']) {
                if($isUniqueAlreadyExists) {
                    $variables[$k]['is_unique'] = $v['is_unique'] = 0;
                } else {
                    $variables[$k]['is_unique'] = $v['is_unique'] = 1;
                }
                $isUniqueAlreadyExists = true;
            }

            switch ($variablemethod) {
                case 'js':
                    $v['variablecode'] = "var {$v['name']} = \\'%%".strtoupper($v['name'])."_VALUE%%\\'"; break;
                case 'dom':
                    $v['variablecode'] = ''; break;
                case 'custom':
                    $v['variablecode'] = "var {$v['name']} = \\'".$v['variablecode']."\\'"; break;
                default:
                    $v['variablecode'] = "var {$v['name']} = escape(\\'%%".strtoupper($v['name'])."_VALUE%%\\')"; break;
            }

            // Always delete variable_publisher entries
            if (!empty($v['variableid'])) {
                $doVariable_publisher = OA_Dal::factoryDO('variable_publisher');
                $doVariable_publisher->variable_id = $v['variableid'];
                $doVariable_publisher->delete();
            }

            $doVariables = OA_Dal::factoryDO('variables');
            if (!empty($v['variableid']) && isset($v['delete'])) {
                // delete variables from db
                $doVariables->deleteById($v['variableid']);
            } elseif (isset($v['variableid']) && !isset($v['delete'])) {
                // update variable info
                $doVariables->get($v['variableid']);
                $doVariables->setFrom($v);
                $doVariables->update();
            } else {
                $doVariables->setFrom($v);
                $doVariables->trackerid = $trackerid;
                $v['variableid'] = $doVariables->insert();
            }

            // Update variable_publisher entries
            $variable_publisher = array();
            if (is_array($v['publisher_visible'])) {
                foreach ($v['publisher_visible'] as $p) {
                    $variable_publisher[$p] = 1;
                }
            }
            if (is_array($v['publisher_hidden'])) {
                foreach ($v['publisher_hidden'] as $p) {
                    $variable_publisher[$p] = 0;
                }
            }

            foreach ($variable_publisher as $publisher_id => $visible) {
                $doVariable_publisher = OA_Dal::factoryDO('variable_publisher');
                $doVariable_publisher->variable_id = $v['variableid'];
                $doVariable_publisher->publisher_id = $publisher_id;
                $doVariable_publisher->visible = $visible;
                $doVariable_publisher->insert();
            }

        }

        // Queue confirmation message
        $translation = new OX_Translation();
        $translated_message = $translation->translate ( $GLOBALS['strTrackerVarsHaveBeenUpdated'], array(
            MAX::constructURL(MAX_URL_ADMIN, "tracker-edit.php?clientid=".$clientid."&trackerid=".$trackerid),
            htmlspecialchars($doTrackers->trackername)
        ));
        OA_Admin_UI::queueMessage($translated_message, 'local', 'confirm', 0);

        // unset variables!
        unset    ($session['prefs']['tracker-variables.php']);
        phpAds_SessionDataStore();

        // Rebuild cache
        // require_once MAX_PATH . '/lib/max/deliverycache/cache-'.$conf['delivery']['cache'].'.inc.php';
        // phpAds_CacheDelete('what=tracker:' . $trackerid);

        // redirect to the next page
        header     ("Location: tracker-variables.php?clientid=".$clientid."&trackerid=".$trackerid);
        exit;

    }

}

$doClients = OA_Dal::factoryDO('clients');
$doClients->whereAdd('clientid <>'.$trackerid);
if (OA_Permission::isAccount(OA_ACCOUNT_MANAGER)) {
    $doClients->agencyid = OA_Permission::getAgencyId();
}
$doClients->find();
$aOtherAdvertisers = array();
while ($doClients->fetch() && $row = $doClients->toArray()) {
    $aOtherAdvertisers[] = $row;
}
MAX_displayNavigationTracker($clientid, $trackerid, $aOtherAdvertisers);


//Start
$tabindex = 0;

if (isset($trackerid) && $trackerid != '')
{
            echo "<form action='".$_SERVER['SCRIPT_NAME']."?clientid=$clientid&trackerid=$trackerid' method='post' onsubmit='return m3_hideShowSubmit()'>\n";
                echo "<input type='hidden' name='submit' value='true'>";
                echo "<input type='image' name='dummy' src='" . OX::assetPath() . "/images/spacer.gif' border='0' width='1' height='1'>\n";
                echo "<br /><br />\n";

                echo "<table border='0' width='100%' cellpadding='0' cellspacing='0'>"."\n";
                echo "<tr><td height='25' colspan='3'><b>".$strTrackingSettings."</b></td></tr>"."\n";
                echo "<tr height='1'><td colspan='3' bgcolor='#888888'><img src='" . OX::assetPath() . "/images/break.gif' height='1' width='100%'></td></tr>"."\n";
                echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>"."\n";

                echo "<tr>"."\n";
                echo "\t"."<td width='30'>&nbsp;</td>"."\n";
                echo "\t"."<td width='200'>".$strTrackerType."</td>"."\n";
                echo "\t"."<td><select name='variablemethod' tabindex='".($tabindex++)."' onchange=\"m3_updateVariableMethod()\">";
                echo "<option value='js'".($variablemethod == 'js' ? ' selected' : '').">".$strTrackerTypeJS."</option>";
                echo "<option value='default'".($variablemethod == 'default' ? ' selected' : '').">".$strTrackerTypeDefault."</option>";
                echo "<option value='dom'".($variablemethod == 'dom' ? ' selected' : '').">".$strTrackerTypeDOM."</option>";
                echo "<option value='custom'".($variablemethod == 'custom' ? ' selected' : '').">".$strTrackerTypeCustom."</option>";
                echo "</select></td>"."\n";
                echo "</tr>"."\n";
                echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>"."\n";
                echo "<tr height='1'><td colspan='3' bgcolor='#888888'><img src='" . OX::assetPath() . "/images/break.gif' height='1' width='100%'></td></tr>"."\n";
                echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>"."\n";
                echo "</table>";

                echo "<table border='0' width='100%' cellpadding='0' cellspacing='0'>\n";
                    echo "<tr><td height='25' colspan='4' bgcolor='#FFFFFF'><b>".$strVariables."</b></td></tr>\n";
                    echo "<tr><td height='1' colspan='4' bgcolor='#888888'><img src='" . OX::assetPath() . "/images/break.gif' height='1' width='100%'></td></tr>\n";

        if ($variables)
        {
            $varCount = 0;
            if (isset($action['del']))
            {
                $key = array_keys($action['del']);
                $variables[$key[0]]['delete']= true;
            }

                    foreach ($variables as $k=>$v)
                    {
                        if (!isset($v['delete']))
                        {
                            $varCount++;
                            // variable area
                            echo "<tr><td height='25' colspan='4' bgcolor='#F6F6F6'>&nbsp;&nbsp;".$strTrackFollowingVars."</td></tr>\n";
                            echo "<tr><td colspan='4'><img src='" . OX::assetPath() . "/images/break-el.gif' width='100%' height='1'></td></tr>\n";
                            echo "<tr><td colspan='4' bgcolor='#F6F6F6'><br /></td></tr>\n";
                            echo "<tr height='35' bgcolor='#F6F6F6' valign='top'>\n";
                                echo "<td width='100'></td>\n";
                                echo "<td width='130'><img src='" . OX::assetPath() . "/images/icon-acl.gif' align='absmiddle'>&nbsp;Variable</td>\n";
                                echo "<td>\n";
                                    echo "<table border='0' width='100%' cellpadding='0' cellspacing='0'>\n";
                                        echo "<tr>\n";
                                            echo "<td>".$strVariableName."</td>\n";
                                            echo "<td><input class='flat' type='text' name='name{$k}' value=\"".htmlspecialchars($v['name'])."\"></td>\n";
                                        echo "</tr>\n";
                                        echo "<tr><td colspan='2'>&nbsp;</td></tr>\n";
                                        echo "<tr>\n";
                                            echo "<td width='200'>".$strVariableDescription."</td>\n";
                                            echo "<td><input class='flat' type='text' name='description".$k."' value=\"".htmlspecialchars($v['description'])."\"></td>\n";
                                        echo "</tr>\n";
                                        echo "<tr><td colspan='2'>&nbsp;</td></tr>\n";
                                        echo "<tr>\n";
                                            echo "<td>".$strVariableDataType."</td>\n";
                                            echo "<td><select name='datatype".$k."'>\n";
                                            echo "<option ".($v['datatype'] =='string'  ? 'selected ' : '')."value='string'>".$strString."</option>\n";
                                            echo "<option ".($v['datatype'] =='numeric' ? 'selected ' : '')."value='numeric'>".$strNumber."</option>\n";
                                            echo "<option ".($v['datatype'] =='date' ? 'selected ' : '')."value='date'>".$strDate."</option>\n";
                                            echo "</select></td>\n";
                                        echo "</tr>\n";
                                        echo "<tr><td colspan='2'>&nbsp;</td></tr>\n";
                                        echo "<tr>\n";
                                            echo "<td>".$strVariablePurpose."</td>\n";
                                            echo "<td><select name='purpose".$k."'>\n";
                                            echo "<option ".(!$v['purpose'] ? 'selected ' : '')."value=''>".$strGeneric."</option>\n";
                                            echo "<option ".($v['purpose'] == 'basket_value'  ? 'selected ' : '')."value='basket_value'>".$strBasketValue."</option>\n";
                                            echo "<option ".($v['purpose'] == 'num_items' ? 'selected ' : '')."value='num_items'>".$strNumItems."</option>\n";
                                            echo "<option ".($v['purpose'] == 'post_code' ? 'selected ' : '')."value='post_code'>".$strPostcode."</option>\n";
                                            echo "</select></td>\n";
                                        echo "</tr>\n";
                                        echo "<tr><td colspan='2'>&nbsp;</td></tr>\n";
                                        echo "<tr>\n";
                                            echo "<td>".$strVariableRejectEmpty."</td>\n";
                                            echo "<td>\n";
                                                $checked = ($v['reject_if_empty']) ? 'checked' : '';
                                                echo "<input type='checkbox' name='reject_if_empty".$k."' value='1' $checked>";
                                            echo "</td>\n";
                                        echo "</tr>\n";
                                        echo "<tr><td colspan='2'>&nbsp;</td></tr>\n";
                                        echo "<tr>\n";
                                            echo "<td>".$strVariableIsUnique."</td>\n";
                                            echo "<td>\n";
                                                $checked = ($v['is_unique']) ? 'checked' : '';
                                                $uniqueCheckboxId = 'uniqueCheckbox'.$k;

                                                $seconds_left = $v['unique_window'];
                                                $uniqueWindow['day'] = floor($seconds_left / (60*60*24));
                                                $seconds_left = $seconds_left % (60*60*24);
                                                $uniqueWindow['hour'] = floor($seconds_left / (60*60));
                                                $seconds_left = $seconds_left % (60*60);
                                                $uniqueWindow['minute'] = floor($seconds_left / (60));
                                                $seconds_left = $seconds_left % (60);
                                                $uniqueWindow['second'] = $seconds_left;

                                                echo "<table cellpadding='0' cellspacing='0'><tr><td align='left'>";
                                                echo "<input type='checkbox' id='$uniqueCheckboxId' onClick='m3_setRadioCheckbox(this, \"is_unique\")' name='is_unique".$k."' value='1' $checked>";

                                                echo '</td><td>';

                                                echo "<div id='uniqueWindow$k' style='visibility: hidden;'>";
                                                echo "&nbsp;&nbsp;&nbsp;&nbsp;$strUniqueWindow&nbsp;&nbsp;";
                                                echo "<input id='uniquewindowday$k' class='flat' type='text' size='3' name='uniquewindow{$k}[day]' value='".$uniqueWindow['day']."' onKeyUp=\"m3_formLimitUpdate($k);\"'> ".$strDays." &nbsp;&nbsp;";
                                                echo "<input id='uniquewindowhour$k' class='flat' type='text' size='3' name='uniquewindow{$k}[hour]' value='".$uniqueWindow['hour']."' onKeyUp=\"m3_formLimitUpdate($k);\"'> ".$strHours." &nbsp;&nbsp;";
                                                echo "<input id='uniquewindowminute$k' class='flat' type='text' size='3' name='uniquewindow{$k}[minute]' value='".$uniqueWindow['minute']."' onKeyUp=\"m3_formLimitUpdate($k);\"'> ".$strMinutes." &nbsp;&nbsp;";
                                                echo "<input id='uniquewindowsecond$k' class='flat' type='text' size='3' name='uniquewindow{$k}[second]' value='".$uniqueWindow['second']."' onBlur=\"m3_formLimitBlur($k);\" onKeyUp=\"m3_formLimitUpdate($k);\"'> ".$strSeconds;
                                                echo '</div>';

                                                echo '</td></tr></table>';

                                                $onLoadUniqueJs = '';
                                                if($checked) {
                                                    $onLoadUniqueJs = "\nm3_setRadioCheckbox(document.getElementById('$uniqueCheckboxId'), \"is_unique\");";
                                                }
                                                $onLoadUniqueJs .= "\nm3_formLimitUpdate($k);";

                                            echo "</td>\n";
                                        echo "</tr>\n";
                                        echo "<tr><td colspan='2'>&nbsp;</td></tr>\n";
                                        echo "<tr>\n";
                                            echo "<td>". 'Variable hidden to' ."</td>\n";
                                            echo "<td><select name='visibility".$k."' id='visibility".$k."' onchange='m3_updateVisibility()'>\n";
                                            echo "<option ".($v['hidden'] != 't' && !count($v['publisher_hidden']) ? 'selected ' : '')."value='none'>". 'No websites' ."</option>\n";
                                            echo "<option ".(count($v['publisher_visible']) || count($v['publisher_hidden']) ? 'selected ' : '')."value='some'>". 'Some websites' ."</option>\n";
                                            echo "<option ".($v['hidden'] == 't' && !count($v['publisher_visible'])  ? 'selected ' : '')."value='all'>". 'All websites' ."</option>\n";
                                            echo "</select></td>\n";
                                        echo "</tr>\n";
                                        echo "<tr class='customvisibility".$k."'><td colspan='2'>&nbsp;</td></tr>\n";
                                        echo "<tr class='customvisibility".$k."' valign='top'>\n";
                                            echo "<td>&nbsp;</td><td><table cellpadding='0' cellspacing='0' width='100%'><tr valign='top' align='left'>";
                                            echo "<td width='50%'><input name='p_default".$k."' type='radio' value='0' ".(count($v['publisher_visible']) || !count($v['publisher_hidden']) ? 'checked ' : '')."/> \n";
                                            echo "Hide:<br /><select name='p_hide".$k."[]' id='p_hide".$k."' style='width: 90%' onchange='m3_hideShowMove(this, 1)' size='5' multiple='multiple'>\n";
                                            if ($v['hidden'] == 't') {
                                                $diff = array_diff(array_keys($publishers), $v['publisher_visible']);
                                            } elseif (!count($v['publisher_hidden'])) {
                                                $diff = array_keys($publishers);
                                            } else {
                                                $diff = $v['publisher_hidden'];
                                            }
                                            foreach ($diff as $p) {
                                                if (isset($publishers[$p])) {
                                                    echo "<option value='".$p."'>".$publishers[$p]."</option>\n";
                                                }
                                            }
                                            echo "</select><br /><input type='button' value='&gt;&gt;&gt;' onclick='m3_hideShowMoveAll(".$k.", 1)' /></td>\n";
                                            echo "<td width='50%'><input name='p_default".$k."' type='radio' value='1' ".(count($v['publisher_hidden']) ? 'checked ' : '')."/> \n";
                                            echo "Show:<br /><select name='p_show".$k."[]' id='p_show".$k."' style='width: 90%' onchange='m3_hideShowMove(this, 0)' size='5' multiple='multiple'>\n";
                                            if ($v['hidden'] != 't') {
                                                if (!count($v['publisher_hidden'])) {
                                                    $diff = array();
                                                } else {
                                                    $diff = array_diff(array_keys($publishers), $v['publisher_hidden']);
                                                }
                                            } else {
                                                $diff = $v['publisher_visible'];
                                            }
                                            foreach ($diff as $p) {
                                                if (isset($publishers[$p])) {
                                                    echo "<option value='".$p."'>".$publishers[$p]."</option>\n";
                                                }
                                            }
                                            echo "</select><input type='button' value='&lt;&lt;&lt;' onclick='m3_hideShowMoveAll(".$k.", 0)' /></td>";
                                            echo "</td></tr></table></td>\n";
                                        echo "</tr>\n";
                                        echo "<tr class='jscode'><td colspan='2'>&nbsp;</td></tr>\n";
                                        echo "<tr class='jscode' valign='top'>\n";
                                            echo "<td>".$strVariableCode."</td>\n";
                                            echo "<td><table cellpadding='0' cellspacing='0'><tr valign='top'><td>variable&nbsp;=&nbsp;</td><td><textarea name='variablecode".$k."' rows='3' cols='40'>".htmlspecialchars(stripslashes($v['variablecode']))."</textarea></td></tr></table></td>\n";
                                        echo "</tr>\n";
                                    echo "</table>\n";
                                echo"</td>\n";
                                echo "<td align='right'><input type='image' name='action[del][".$k."]' src='" . OX::assetPath() . "/images/icon-recycle.gif' border='0' align='absmiddle' alt='Delete'>&nbsp;&nbsp;</td>";
                            echo "</tr>";
                            echo "<tr bgcolor='#F6F6F6'>\n";
                                echo "<td>&nbsp;</td>\n";
                                echo "<td>&nbsp;</td>\n";
                                echo "<td colspan='2'></td>\n";
                            echo "</tr>\n";
                            echo "<tr>";
                                echo "<td height='1' colspan='4' bgcolor='#888888'><img src='" . OX::assetPath() . "/images/break.gif' height='1' width='100%'></td>";
                            echo "</tr>";

                        }

                    }

                    echo "<tr>";
                        echo "<td colspan='4'><img src='" . OX::assetPath() . "/images/spacer.gif' width='1' height='10' /></td>";
                    echo "</tr>";

                    echo "<tr>";
                    if ($varCount < 10) {
                        echo "<td colspan='4' align='right'>";
                            echo "<img src='" . OX::assetPath() . "/images/icon-acl-add.gif' align='absmiddle'>&nbsp;&nbsp;".$strAddVariable."&nbsp;&nbsp;";
                            echo "<input type='image' name='action[new]' src='" . OX::assetPath() . "/images/".$phpAds_TextDirection."/go_blue.gif' border='0' align='absmiddle' alt='$strSave'>";
                        echo "</td>";
                    }
                    echo "</tr>";
                    echo "<tr>";
                        echo "<td colspan='4'><img src='" . OX::assetPath() . "/images/spacer.gif' width='1' height='10' /></td>\n";
                    echo "</tr>";
                    echo "<tr>";
                        echo "<td colspan='4'>";
                            echo "<input type='submit' name='action[save]' value='Save Changes' tabindex='15'>\n";
                        echo "</td>";
                    echo "</tr>";
                echo "</form>";


            echo "</table>";

        }
        else
        {
            echo "<tr><td height='25' colspan='4' bgcolor='#F6F6F6'>&nbsp;&nbsp;".$strNoVarsToTrack."</td></tr>\n";
            echo "<tr><td colspan='4'><img src='" . OX::assetPath() . "/images/break-el.gif' width='100%' height='1'></td></tr>\n";

                    echo "<tr>";
                        echo "<td colspan='4'><img src='" . OX::assetPath() . "/images/spacer.gif' width='1' height='10' /></td>";
                    echo "</tr>";

                    echo "<tr>";
                        echo "<td colspan='4' align='right'>";
                            echo "<img src='" . OX::assetPath() . "/images/icon-acl-add.gif' align='absmiddle'>&nbsp;&nbsp;".$strAddVariable."&nbsp;&nbsp;";
                            echo "<input type='image' name='action[new]' src='" . OX::assetPath() . "/images/".$phpAds_TextDirection."/go_blue.gif' border='0' align='absmiddle' alt='$strSave'>";
                        echo "</td>";
                    echo "</tr>";
                    echo "<tr>";
                        echo "<td colspan='4'><img src='" . OX::assetPath() . "/images/spacer.gif' width='1' height='10' /></td>\n";
                    echo "</tr>";
                    echo "<tr>";
                        echo "<td colspan='4'>";
                            echo "<input type='submit' name='action[save]' value='Save Changes' tabindex='15'>\n";
                        echo "</td>";
                    echo "</tr>";
                echo "</form>";


            echo "</table>";
        }

}
/*-------------------------------------------------------*/
/* Store preferences                                     */
/*-------------------------------------------------------*/

$session['prefs']['tracker-variables.php']['variables'] = $variables;
$session['prefs']['tracker-variables.php']['trackerid'] = $trackerid;


phpAds_SessionDataStore();

?>

<script language='JavaScript'>
<!--

    function m3_setRadioCheckbox(field, groupName)
    {
        if (document.forms && document.getElementsByTagName)
        {
            var fields = eval('field.form.getElementsByTagName("input");');

            for (i=0; i < fields.length; i++)
            {
                if (fields[i].getAttribute("type").toLowerCase() == "checkbox"
                    && fields[i].name.indexOf(groupName) != -1) {
                    var v = fields[i].name.substring(9);
                    if(fields[i].name != field.name) {
                        fields[i].checked = false;
                        m3_setWindowVisibility('uniqueWindow' + v, false);
                    } else {
                        m3_setWindowVisibility('uniqueWindow' + v, field.checked);
                    }
                }
            }
        }
    }

    function m3_setWindowVisibility(elementName, visibility) {
        if(visibility) {
            visible = 'visible';
        } else {
            visible = 'hidden';
        }
        element = document.getElementById(elementName);
        if(element) {
            element.style.visibility = visible;
        }
    }

    function m3_formLimitBlur(key)
    {
        uniquewindowday    = document.getElementById('uniquewindowday' + key);
        uniquewindowhour   = document.getElementById('uniquewindowhour' + key);
        uniquewindowminute = document.getElementById('uniquewindowminute' + key);
        uniquewindowsecond = document.getElementById('uniquewindowsecond' + key);

        if (uniquewindowday.value == '') uniquewindowday.value = '0';
        if (uniquewindowhour.value == '') uniquewindowhour.value = '0';
        if (uniquewindowminute.value == '') uniquewindowminute.value = '0';
        if (uniquewindowsecond.value == '') uniquewindowsecond.value = '0';

        m3_formLimitUpdate(key);
    }

    function m3_formLimitUpdate(key)
    {
        uniquewindowday    = document.getElementById('uniquewindowday' + key);
        uniquewindowhour   = document.getElementById('uniquewindowhour' + key);
        uniquewindowminute = document.getElementById('uniquewindowminute' + key);
        uniquewindowsecond = document.getElementById('uniquewindowsecond' + key);

        // Set -
        if (uniquewindowhour.value == '-' && uniquewindowday.value != '-') uniquewindowhour.value = '0';
        if (uniquewindowminute.value == '-' && uniquewindowhour.value != '-') uniquewindowminute.value = '0';
        if (uniquewindowsecond.value == '-' && uniquewindowminute.value != '-') uniquewindowsecond.value = '0';

        // Set 0
        if (uniquewindowday.value == '0') uniquewindowday.value = '-';
        if (uniquewindowday.value == '-' && uniquewindowhour.value == '0') uniquewindowhour.value = '-';
        if (uniquewindowhour.value == '-' && uniquewindowminute.value == '0') uniquewindowminute.value = '-';
        if (uniquewindowminute.value == '-' && uniquewindowsecond.value == '0') uniquewindowsecond.value = '-';
    }

    //m3_formLimitUpdate(document.clientform);

    function m3_updateVariableMethod()
    {
        var s = findObj('variablemethod');
        var display = s.selectedIndex == s.options.length - 1 ? '' : 'none'

        var trs = document.getElementsByTagName('TR');
        for (var i = 0; i < trs.length; i++) {
            if (trs[i].className == 'jscode') {
                trs[i].style.display = display;
            }
        }
    }

    m3_updateVariableMethod();

    function m3_updateVisibility()
    {
        var s = document.getElementsByTagName('SELECT');
        for (var i = 0; i < s.length; i++) {
            if (s[i].id.match(/^visibility/)) {
                var id = s[i].id.replace(/^[^0-9]+/, '');
                var display = s[i].selectedIndex == 1 ? '' : 'none';

                var trs = document.getElementsByTagName('TR');
                for (var j = 0; j < trs.length; j++) {
                    if (trs[j].className == 'customvisibility' + id) {
                        trs[j].style.display = display;
                    }
                }
            }
        }
    }

    m3_updateVisibility();

    function m3_hideShowMove(o, s)
    {
        var id = o.id.replace(/^[^0-9]+/, '');
        var p = document.getElementById((s ? 'p_show' : 'p_hide') + id);

        var sel = o.selectedIndex;

        if (sel >= 0) {
            p.appendChild(o.options[sel]);
            o.selectedIndex = -1;
            p.selectedIndex = -1;
            o.blur();
            p.blur();
        }
    }

    function m3_hideShowMoveAll(id, s)
    {
        var o = document.getElementById((s ? 'p_hide' : 'p_show') + id);
        var p = document.getElementById((s ? 'p_show' : 'p_hide') + id);

        for (var i = o.options.length - 1; i >= 0; i--) {
            p.appendChild(o.options[i]);
        }

        o.selectedIndex = -1;
        p.selectedIndex = -1;
        o.blur();
        p.blur();
    }

    function m3_hideShowSubmit()
    {
        var s = document.getElementsByTagName('SELECT');
        for (var i = 0; i < s.length; i++) {
            if (s[i].id.match(/^p_(show|hide)/)) {
                for (var j = 0; j < s[i].options.length; j++) {
                    var c = document.createElement('INPUT');
                    c.type = 'hidden';
                    c.name = s[i].name;
                    c.value = s[i].options[j].value;
                    s[i].parentNode.appendChild(c);
                }
            }
        }

        return true;
    }

    <?php if (isset($onLoadUniqueJs)) echo $onLoadUniqueJs; ?>

//-->
</script>

<?php

phpAds_PageFooter();

?>
