<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2007 Openads Limited                                   |
| For contact details, see: http://www.openads.org/                         |
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
require_once MAX_PATH . '/lib/max/Admin/Config.php';
require_once MAX_PATH . '/lib/max/language/Default.php';
require_once MAX_PATH . '/lib/max/language/Settings.php';
require_once MAX_PATH . '/lib/max/language/SettingsHelp.php';
if ($conf['openads']['installed']) {
    include_once MAX_PATH . '/www/admin/config.php';
}

// Load the required language files
Language_Default::load();
Language_Settings::load();
Language_SettingsHelp::load();

// Determine wether the config file is locked
$phpAds_config_locked = !MAX_Admin_Config::isConfigWritable();

/*-------------------------------------------------------*/
/* Build a menu with all settings                        */
/*-------------------------------------------------------*/

function phpAds_SettingsSelection($section)
{
    global $phpAds_TextDirection, $strHelp;
    global $tabindex;
    if(!isset($tabindex)) $tabindex = 1;

?>
<script language="JavaScript">
<!--
function settings_goto_section()
{
    s = document.settings_selection.section.selectedIndex;
    s = document.settings_selection.section.options[s].value;

    document.location = 'settings-' + s + '.php';
}

function phpAds_UsertypeChange(o)
{
    var v = 0;
    var base_name = o.name.replace(/_\d+$/, '');
    var l;

    for (var i = 1; i <= 8; i <<= 1) {
        if (o = findObj(base_name + '_' + i)) {
            v += o.checked ? i : 0

            if (l = findObj(base_name + '_label[' + i +']')) {
                l.disabled = !o.checked;
            }
            if (l = findObj(base_name + '_rank[' + i +']')) {
                l.disabled = !o.checked;
            }
        }
    }

    if (o = findObj(base_name))
        o.value = v;
}

// -->
</script>
<?php
    echo "<table border='0' width='100%' cellpadding='0' cellspacing='0'><tr>";

    $sections = array(
        'admin'         => array('name' => $GLOBALS['strAdministratorSettings'],    'perm' => phpAds_Admin),
        'banner'        => array('name' => $GLOBALS['strBannerSettings'],           'perm' => phpAds_Admin + phpAds_Agency),
        'db'            => array('name' => $GLOBALS['strDatabaseSettings'],         'perm' => phpAds_Admin),
        'debug'         => array('name' => $GLOBALS['strDebugSettings'],            'perm' => phpAds_Admin),
        'delivery'      => array('name' => $GLOBALS['strDeliverySettings'],         'perm' => phpAds_Admin),
        'general'       => array('name' => $GLOBALS['strGeneralSettings'],          'perm' => phpAds_Admin),
        'geotargeting'  => array('name' => $GLOBALS['strGeotargetingSettings'],     'perm' => phpAds_Admin),
        'defaults'      => array('name' => $GLOBALS['strInterfaceDefaults'],        'perm' => phpAds_Admin + phpAds_Agency + phpAds_Client + phpAds_Affiliate),
        'invocation'    => array('name' => $GLOBALS['strInvocationAndDelivery'],    'perm' => phpAds_Admin + phpAds_Agency),
        'stats'         => array('name' => $GLOBALS['strStatisticsSettings'],       'perm' => phpAds_Admin),
        'interface'     => array('name' => $GLOBALS['strGuiSettings'],              'perm' => phpAds_Admin + phpAds_Agency)
    );


    echo "<td><form name='settings_selection'><td height='35'><b>";
    echo $GLOBALS['strChooseSection'].":&nbsp;</b>";
    echo "<select name='section' onChange='settings_goto_section();' tabindex='".($tabindex++)."'>";
    foreach ($sections as $k => $v) {
        if (phpAds_isUser($v['perm'])) {
            echo "<option value='{$k}'".($section == $k ? ' selected' : '').">{$v['name']}</option>";
        }
    }
    echo "</select>&nbsp;<a href='javascript:void(0)' onClick='settings_goto_section();'>";
    echo "<img src='images/".$phpAds_TextDirection."/go_blue.gif' border='0'></a>";
    echo "</td></form>";
    echo "<td height='35' align='right'><b><a href=\"#\" onClick=\"javascript:toggleHelp(); return false;\">";
    echo "<img src='images/help-book.gif' width='15' height='15' border='0' align='absmiddle'>";
    echo "&nbsp;".$strHelp."</a></b></td></tr></table>";
    phpAds_ShowBreak();
}

/*-------------------------------------------------------*/
/* Return Settings Help HTML Code                        */
/*-------------------------------------------------------*/

function phpAds_SettingsHelp($name)
{
    if (!isset($GLOBALS['phpAds_hlp_'.$name])) {
        $GLOBALS['phpAds_hlp_'.$name] = '';
    }
    $string = $GLOBALS['phpAds_hlp_'.$name];
    $string = ereg_replace ("[\n\r\t]", " ", $string);
    $string = ereg_replace ("[ ]+", " ", $string);
    $string = str_replace("'", "\\'", $string);
    $string = trim ($string);
    return "helpArray['$name'] = '".$string."';\n";
}

/*-------------------------------------------------------*/
/* Build and display the settings user interface         */
/*-------------------------------------------------------*/

function phpAds_ShowSettings($data, $errors = array(), $disableSubmit=0, $imgPath="")
{
    $conf = $GLOBALS['_MAX']['CONF'];
    $pref = $GLOBALS['_MAX']['PREF'];
    global $tabindex;
    // Initialize tabindex (if not already done)
    if (!isset($tabindex)) {
        $tabindex = 1;
    }
    // Determine if config file is writable
    $configLocked = !MAX_Admin_Config::isConfigWritable();
    // Show header
    if ($conf['openads']['installed']) {
       echo "<form id='settingsform' name='settingsform' ENCTYPE='multipart/form-data' method='post' action='".$_SERVER['PHP_SELF']."' onSubmit='return max_formValidate(this);'>\n";
        // Show config locked alert
        if (phpAds_isUser(phpAds_Admin)) {
            $image = $configLocked ? 'closed' : 'open';
            echo "<br /><div class='errormessage'><img class='errormessage' src='images/padlock-".$image.".gif' width='16' height='16' border='0' align='absmiddle'>\n";
            echo $configLocked ? $GLOBALS['strEditConfigNotPossible'] : $GLOBALS['strEditConfigPossible'];
            echo "</div>\n";
        }
    }
    $dependbuffer   = "function phpAds_refreshEnabled() {\n";
    $checkbuffer    = '';
    $usertypebuffer = '';
    $helpbuffer     = '';
    $i = 0;
    while (list(,$section) = each ($data)) {
        if (!isset($section['visible']) || $section['visible']) {
            if (isset($errors[$i])) {
                phpAds_ShowSettings_StartSection($section['text'], $errors[$i], $disableSubmit, $imgPath);
            } else {
                phpAds_ShowSettings_StartSection($section['text'], NULL ,$disableSubmit, $imgPath);
            }
            while (list(,$item) = each ($section['items'])) {
                if (!isset($item['visible']) || $item['visible']) {
                    if (!$item['enabled']) {
                        $item['enabled'] = showSettingsLocked($item);
                        $dependbuffer .= phpAds_ShowSettings_CheckDependancies($data, $item);
                    }
                    if (count($errors)) {
                        // Page is the result of an error message, get values from the input
                        $value = '';
                        if (isset($item['name']) && isset($GLOBALS[$item['name']])) {
                            $value = $GLOBALS[$item['name']];
                            if ($errors[0] != MAX_ERROR_YOU_HAVE_NO_TRACKERS && $errors[0] != MAX_ERROR_YOU_HAVE_NO_CAMPAIGNS) {
                                if (isset($GLOBALS[$item['name'].'_defVal'])) {
                                    $value = $GLOBALS[$item['name'].'_defVal'];
                                }
                            }
                        }
                    } else {
                        // Get the values from the config file
                        $value = '';
                        if (isset($item['name'])) {
                            // Split into config sections
                            $confixExploded = explode('_', $item['name']);
                            $configLevel = isset($confixExploded[0]) ? $confixExploded[0] : null;
                            $configItem = isset($confixExploded[1]) ? $confixExploded[1] : null;
                            if (isset($GLOBALS[$item['name'].'_defVal'])) {
                                // Load value from globals if set
                                $value = $GLOBALS[$item['name'].'_defVal'];
                            } elseif (isset($conf[$configLevel][$configItem])) {
                                // Load the configuration .ini file value
                                $value = $conf[$configLevel][$configItem];
                            } elseif (isset($conf[$item['name']][0])) {
                                // Configuration .ini file item is stored as an array,
                                // re-constitute into a comma separated list
                                $value = implode(', ', $conf[$item['name']]);
                            } elseif (isset($pref[$item['name']])) {
                                // Load the preference value
                                $value = $pref[$item['name']];
                            } elseif (isset($item['value'])) {
                                $value = $item['value'];
                            }
                        }
                    }
                    switch ($item['type']) {
                        case 'plaintext': phpAds_ShowSettings_PlainText($item); break;
                        case 'break':     phpAds_ShowSettings_Break($item, $imgPath); break;
                        case 'checkbox':  phpAds_ShowSettings_Checkbox($item, $value); break;
                        case 'text':      phpAds_ShowSettings_Text($item, $value); break;
                        case 'url':       phpAds_ShowSettings_Url($item, $value); break;
                        case 'urln':      phpAds_ShowSettings_Url($item, $value, 'n'); break;
                        case 'urls':      phpAds_ShowSettings_Url($item, $value, 's'); break;
                        case 'textarea':  phpAds_ShowSettings_Textarea($item, $value); break;
                        case 'password':  phpAds_ShowSettings_Password($item, $value); break;
                        case 'select':    phpAds_ShowSettings_Select($item, $value, $disableSubmit); break;
                        case 'usertype_textboxes':
                            phpAds_ShowSettings_UsertypeTextboxes($item, $value);
                            break;
                        case 'usertype_checkboxes':
                            phpAds_ShowSettings_UsertypeCheckboxes($item, $value);
                            $usertypebuffer .= "phpAds_UsertypeChange(findObj('".$item['name']."'));\n";
                            break;
                    }
                    if (isset($item['check']) || isset($item['req'])) {
                        if (!isset($item['check'])) {
                            $item['check'] = '';
                        }
                        if (!isset($item['req'])) {
                            $item['req'] = false;
                        }
                        $checkbuffer .= "max_formSetRequirements('".$item['name']."', '".addslashes($item['text'])."', ".($item['req'] ? 'true' : 'false').", '".$item['check']."');\n";
                        if (isset($item['unique'])) {
                            $checkbuffer .= "max_formSetUnique('".$item['name']."', '|".addslashes(implode('|', $item['unique']))."|');\n";
                        }
                    }
                    if (isset($item['name'])) {
                        $helpbuffer .= phpAds_SettingsHelp($item['name']);
                    }
                }
            }
            phpAds_ShowSettings_EndSection();
        }
        $i++;
    }
    if ($conf['openads']['installed']) {
        if ($disableSubmit == 0)
            echo '<br /><br /><input type="submit" name="submitsettings" value="'.$GLOBALS['strSaveChanges'].'"></form>';
        else {
            echo ' <input type="submit" name="submitCreateTemplate"';
            if ($errors[0] == MAX_ERROR_YOU_HAVE_NO_TRACKERS || $errors[0] == MAX_ERROR_YOU_HAVE_NO_CAMPAIGNS)
                echo ' disabled ';
            echo' value="Create CSV Template"> <br /><br />';

            $max_file_size = _display_to_bytes(ini_get('upload_max_filesize'));
            $max_post_size = _display_to_bytes(ini_get('post_max_size'));
            if (($max_post_size > 0) && ($max_post_size < $max_file_size)) {
                $max_file_size = $max_post_size;
            }
            echo " <input type='hidden' name='MAX_FILE_SIZE' value='{$max_file_size}' />";
            echo' <input type="hidden" name="start_upload" value="0" />';
            echo ' <input type="hidden" name="field_changed" value="none" />';
            echo' Choose a file to upload: (Max size: '. _bytes_to_display($max_file_size) . ') <input name="uploadedfile" type="file" /><br />';
            echo' <input type="submit" name="uploadFile" onClick=\'setUploadConversionValues();\'';
            if ($errors[0] == MAX_ERROR_YOU_HAVE_NO_TRACKERS || $errors[0] == MAX_ERROR_YOU_HAVE_NO_CAMPAIGNS)
                echo ' disabled ';
            echo ' value="Upload File" />';
        }

    }
    echo "<script language='JavaScript'>\n<!--\n\n";
    echo "    function setUploadConversionValues() {
                  document.settingsform.start_upload.value = 1;
                  document.settingsform.submit();
              }";
    echo "//-->\n</script>";

    echo "<script language='JavaScript'>\n<!--\n\n";
    echo $dependbuffer."}\n\nphpAds_refreshEnabled();\n\n";
    echo $checkbuffer."\n";
    echo $usertypebuffer."\n";
    echo "var helpArray = new Array();\n\n";
    echo $helpbuffer."\n";
    echo "//-->\n</script>";
}

/*-------------------------------------------------------*/
/* Settings GUI Functions Wrappers                       */
/*-------------------------------------------------------*/

function phpAds_ShowSettings_CheckDependancies($data, $item)
{
    $formName = empty($GLOBALS['settings_formName'])?'settingsform' :$GLOBALS['settings_formName'];
    if (isset($item['depends'])) {
        $depends    = split('[ ]+', $item['depends']);
        $javascript = "\tenabled = (";
        $result     = true;
        while (list(,$word) = each($depends)) {
            if (ereg('[\&\|]{1,2}', $word)) {
                // Operator
                $javascript .= " ".$word." ";
            } else {
                // Assignment
                eregi ("^(\(?)([a-z0-9_-]+)([\=\!\<\>]{1,2})([\"\'a-z0-9_-]+)(\)?)$", $word, $regs);
                $type          = phpAds_ShowSettings_GetType($data, $regs[2]);
                $javascript .= $regs[1]."document.".$formName.".".$regs[2].".";
                switch ($type){
                    case 'checkbox':    $javascript .= 'checked'; break;
                    case 'select':        $javascript .= 'selectedIndex'; break;
                    default:            $javascript .= 'value'; break;
                }
                $javascript .= " ".$regs[3]." ".$regs[4].$regs[5];
            }
        }
        $javascript .= ");\n";
        $javascript .= "\tdocument.".$formName.".".$item['name'].".disabled = !enabled;\n";
        $javascript .= "\tobj = findObj('cell_".$item['name']."'); if (enabled) { obj.className = 'cellenabled'; } else { obj.className =  'celldisabled'; }\n";
        $javascript .= "\t\n";
        return ($javascript);
    }
    return ('');
}

function phpAds_ShowSettings_GetType ($data, $name)
{
    while (list(,$section) = each ($data)) {
        while (list(,$item) = each ($section['items'])) {
            if (isset($item['name']) && $item['name'] == $name) {
                return ($item['type']);
            }
        }
    }
    return false;
}

function phpAds_ShowSettings_StartSection($name, $error = array(), $disableSubmit=0, $imgPath="")
{
    $conf = $GLOBALS['_MAX']['CONF'];
    $icon = (!$conf['openads']['installed']) ? 'setup' : 'settings';
    echo "\t<br /><br />\n\n";
    echo "<table border='0' width='100%' cellpadding='0' cellspacing='0'><tr>\n";
    if($disableSubmit == 0)
        echo "<input type='hidden' name='submitok' value='true'>\n";
    else
        echo "<input type='hidden' name='submitDisabled' value='true'>\n";
    echo "<td height='25' colspan='4'><img src='".$imgPath."images/icon-".$icon.".gif' width='16' height='16' align='absmiddle'>&nbsp;";
    echo "<b>".$name."</b></td></tr>\n";
    echo "<tr height='1'>\n";
    echo "<td bgcolor='#888888' width='30'><img src='".$imgPath."images/break.gif' height='1' width='30'></td>\n";
    echo "<td bgcolor='#888888' width='250'><img src='".$imgPath."images/break.gif' height='1' width='250'></td>\n";
    echo "<td bgcolor='#888888' width='100%'><img src='".$imgPath."images/break.gif' height='1' width='1'></td>\n";
    echo "<td bgcolor='#888888' width='30'><img src='".$imgPath."images/break.gif' height='1' width='30'></td>\n";
    echo "</tr><tr><td height='10' colspan='4'><img src='".$imgPath."images/spacer.gif' width='30' height='1'></td></tr>\n";
    if (count($error)) {
        echo "<tr><td width='30'>&nbsp;</td><td height='10' colspan='2'>";
        echo "<table width='100%' border='0' cellspacing='0' cellpadding='0'><tr>";
        echo "<td width='22' valign='top'><img src='".$imgPath."images/error.gif' width='16' height='16'>&nbsp;&nbsp;</td>";
        echo "<td valign='top'><font color='#AA0000'><b>";
        if (is_array($error)) {
            while (list(, $v) = each($error)) {
                echo $v."<br />";
            }
        } else {
            echo $error;
        }
        echo "</b></font></td></tr></table></td></tr>";
        echo "<tr><td height='10' width='30'>&nbsp;</td>";
        echo "<td height='10' width='200'><img src='".$imgPath."images/spacer.gif' width='200' height='1'></td>";
        echo "<td height='10' width='100%'>&nbsp;</td><td height='10' width='30'>&nbsp;</td></tr>";
        echo "<tr><td height='14' width='30'><img src='".$imgPath."images/spacer.gif' height='1' width='100%'></td>";
        echo "<td height='14' width='200'><img src='".$imgPath."images/break-l.gif' height='1' width='200' vspace='6'></td>";
        echo "<td height='14' width='100%'>&nbsp;</td><td height='14' width='30'><img src='".$imgPath."images/spacer.gif' height='1' width='100%'></tr>";
    }
}

function phpAds_ShowSettings_EndSection()
{
    echo "<tr><td height='10' colspan='4'>&nbsp;</td></tr>\n";
    echo "<tr height='1'><td colspan='4' bgcolor='#888888'><img src='images/break.gif' height='1'></td></tr>\n";
    echo "</table>\n<br /><br />\n";
}

function phpAds_ShowSettings_PlainText($item)
{
    echo "<tr ><td>&nbsp;</td>\n";
    if ($item['font'] == 'bold') {
        echo "<td><b>".$item['text']."<b/></td></tr>\n";
    } else {
        echo "<td>".$item['text']."</td></tr>\n";
    }
}

function phpAds_ShowSettings_Break($item, $imgPath='')
{
    if (!isset($item['size']) || $item['size'] == '' || $item['size'] == 'small') {
        echo "<tr><td><img src='".$imgPath."images/spacer.gif' height='1' width='100%'></td>\n";
        echo "<td><img src='".$imgPath."images/break-l.gif' height='1' width='250' vspace='10'></td>\n";
        echo "<td>&nbsp;</td><td><img src='".$imgPath."images/spacer.gif' height='1' width='100%'></tr>\n";
    } else if ($item['size'] == 'large') {
        echo "<tr><td><img src='".$imgPath."images/spacer.gif' height='1' width='100%'></td>\n";
        echo "<td colspan='3'><img src='".$imgPath."images/break-l.gif' height='1' width='100%' vspace='10'></td></tr>\n";
    } else if ($item['size'] == 'full') {
        echo "<tr><td colspan='4'><img src='".$imgPath."images/break.gif' height='1' width='100%' vspace='16'></td></tr>\n";
    } else if ($item['size'] == 'empty') {
        echo "<tr><td><img src='".$imgPath."images/spacer.gif' height='1' width='100%'></td>\n";
        echo "<td><img src='".$imgPath."images/spacer.gif' height='1' width='250' vspace='10'></td>\n";
        echo "<td>&nbsp;</td><td><img src='".$imgPath."images/spacer.gif' height='1' width='100%'></tr>\n";
    }
}

function phpAds_ShowSettings_Checkbox($item, $value)
{
    global $tabindex;
    echo "<tr onMouseOver=\"setHelp('".$item['name']."')\"><td>&nbsp;</td>\n";
    echo "<td id='cell_".$item['name']."' class='".($item['enabled'] ? 'celldisabled' : 'cellenabled')."' colspan='2' width='100%'>\n";
    if (isset($item['indent']) && $item['indent']) {
        echo "<img src='images/indent.gif'>\n";
    }

    // make sure that 'f' for enums is also considered
    $value = !empty($value) && (bool)strcasecmp($value, 'f');

    echo "<input type='checkbox' name='".$item['name']."' id='".$item['name']."' value='true'".($value == true ? ' checked' : '').($item['enabled'] ? ' disabled' : '');
    echo " onClick=\"phpAds_refreshEnabled();\" onFocus=\"setHelp('".$item['name']."')\" tabindex='".($tabindex++)."'>".$item['text'];
    $sDocPath = '';
    $iAnchor = 0;

    if ($item['text'] == $GLOBALS['strAdminShareCommunityData']) {
        $sDocPath = 'http://docs.openads.org/openads-2.3-guide/community-statistics.html';
    }

    if (!empty($sDocPath)) {
        $sDocLink = $sDocPath;
        echo '&nbsp;<a href="' . $sDocLink . '" class="inlineHelp__" ' .
                "onclick=\"openWindow('$sDocLink','','status=yes,menubar=yes,scrollbars=yes,resizable=yes,width=700,height=500'); return false;\"".
                '">&nbsp;<span>What\'s this?</span></a>';
    }
    echo "</td><td>".phpAds_ShowSettings_PadLock($item)."</td></tr>\n";
}

function phpAds_ShowSettings_Text($item, $value)
{
    global $tabindex;
    if (!isset($item['size'])) {
        $item['size'] = 25;
    }
    echo "<tr onMouseOver=\"setHelp('".$item['name']."')\"><td>&nbsp;</td>\n";
    echo "<td id='cell_".$item['name']."' class='".($item['enabled'] ? 'celldisabled' : 'cellenabled')."' valign='top'>".$item['text']."</td>\n";
    echo "<td width='100%' valign='top'>";
    echo "<input onBlur='phpAds_refreshEnabled(); max_formValidateElement(this);' class='flat' type='text' name='".$item['name']."' id='".$item['name']."'".($item['enabled'] ? ' disabled' : '')." ";
    echo "size='".$item['size']."' maxlength='".$item['maxlength']."' value=\"".htmlspecialchars($value)."\" onFocus=\"setHelp('".$item['name']."')\" tabindex='".($tabindex++)."'>";
    echo "</td><td>".phpAds_ShowSettings_PadLock($item)."</td></tr>\n";
}

function phpAds_ShowSettings_Url($item, $value, $type = '')
{
    global $tabindex;
    if (!isset($item['size'])) {
        $item['size'] = 25;
    }
     echo "<tr onMouseOver=\"setHelp('".$item['name']."')\"><td>&nbsp;</td>\n";
    echo "<td id='cell_".$item['name']."' class='".($item['enabled'] ? 'celldisabled' : 'cellenabled')."' valign='top'>".$item['text']."</td>\n";
    echo "<td width='100%' valign='top'><table><tr><td width='60' align='right' nowrap>";
    if ($type == 'n') {
        echo 'http://';
    } elseif ($type == 's') {
        echo 'https://';
    } else {
        echo 'http(s)://';
    }
    echo "</td><td><input onBlur='phpAds_refreshEnabled(); max_formValidateElement(this);' class='flat' type='text' name='".$item['name']."' id='".$item['name']."'".($item['enabled'] ? ' disabled' : '')." ";
    echo "size='".$item['size']."' value=\"".htmlspecialchars($value)."\" onFocus=\"setHelp('".$item['name']."')\" tabindex='".($tabindex++)."'>";
    echo "</td></tr></table></td><td>".phpAds_ShowSettings_PadLock($item)."</td></tr>\n";
}

function phpAds_ShowSettings_Textarea($item, $value)
{
    global $tabindex;
    if (!isset($item['rows'])) {
        $item['rows'] = 5;
    }
     echo "<tr onMouseOver=\"setHelp('".$item['name']."')\"><td>&nbsp;</td>\n";
    echo "<td id='cell_".$item['name']."' class='".($item['enabled'] ? 'celldisabled' : 'cellenabled')."' valign='top'>".$item['text']."</td>";
    echo "<td width='100%' valign='top'>\n";
    echo "<textarea onBlur='phpAds_refreshEnabled(); max_formValidateElement(this);' class='flat' name='".$item['name']."' id='".$item['name']."' rows='".$item['rows']."'".($item['enabled'] ? ' disabled' : '')." ";
    echo "style='width: 350px;' onFocus=\"setHelp('".$item['name']."')\" tabindex='".($tabindex++)."'>".htmlspecialchars($value)."</textarea>";
    echo "</td><td>".phpAds_ShowSettings_PadLock($item)."</td></tr>\n";
}

function phpAds_ShowSettings_Password($item, $value)
{
    global $tabindex;
    if (!isset($item['size'])) {
        $item['size'] = 25;
    }

    //  if config file is not writeable do not display password
    $hidePassword = false;
    $writeable = MAX_Admin_Config::isConfigWritable();
    if ($item['name'] == 'database_password' && !$writeable) {
        $value = 'password';
        $hidePassword = true;
    }

    // Hide value
    //$value = str_repeat('*', strlen($value));
    echo "<tr onMouseOver=\"setHelp('".$item['name']."')\"><td>&nbsp;</td>\n";
    echo "<td id='cell_".$item['name']."' class='".($item['enabled'] ? 'celldisabled' : 'cellenabled')."' valign='top'>".$item['text']."</td>\n";
    echo "<td width='100%' valign='top'>\n";
    if ($hidePassword) {
        echo "<!-- password is set to password for security reasons -->";
    }
    echo "<input onBlur='phpAds_refreshEnabled(); max_formValidateElement(this);' class='flat' type='password' name='".$item['name']."' id='".$item['name']."'".($item['enabled'] ? ' disabled' : '')." ";
    echo "value='".$value."' size='".$item['size']."' onFocus=\"setHelp('".$item['name']."')\" tabindex='".($tabindex++)."'>";
    echo "</td><td>".phpAds_ShowSettings_PadLock($item)."</td></tr>\n";
}

function phpAds_ShowSettings_Select($item, $value, $showSubmitButton=0)
{
    global $tabindex;
    if (isset($item['items'])) {
        echo "<tr onMouseOver=\"setHelp('".$item['name']."')\"><td>&nbsp;</td>\n";
        echo "<td id='cell_".$item['name']."' class='".($item['enabled'] ? 'celldisabled' : 'cellenabled')."'>".$item['text']."</td>\n";
        echo "<td width='100%'>\n";
        echo "<select name='".$item['name']."' id='".$item['name']."'";
        if(isset($item['reload']) && $item['reload'] == 'yes') {
            echo " onChange=\"this.form.field_changed.value=name;this.form.submit();phpAds_refreshEnabled();\"";
        } else {
            echo " onChange=\"phpAds_refreshEnabled();";
            if (isset($item['onchange'])) {
                echo $item['onchange'];
            }
            echo "\"";
        }
        echo ($item['enabled'] ? ' disabled' : '')." onFocus=\"setHelp('".$item['name']."')\" tabindex='".($tabindex++)."'>\n";
        while (list($k, $v) = each($item['items'])) {
            echo "<option value=\"".htmlspecialchars($k)."\"".
                ($k == $value ? " selected='selected'" : "").">".
                $v."</option>";
        }
        echo "</select>";
        if($showSubmitButton == 1) {
            echo '&nbsp;<a href="javascript:void(0)" onClick="document.forms[\'settingsform\'].submit();"><img src="images/ltr/go_blue.gif" border="0"></a>';
        }
        echo "</td><td>".phpAds_ShowSettings_PadLock($item)."</td></tr>\n";
    }
}

function phpAds_ShowSettings_UsertypeCheckboxes($item, $value)
{
    global $tabindex;

    if (isset($item['show_headers']) && $item['show_headers']) {
        echo "<tr><td>&nbsp;</td><td>&nbsp;</td><td width='100%'>";
        echo "<table border='0' cellpadding='2' cellspacing='0'><tr align='center'>\n";
        if (phpAds_isUser(phpAds_Admin)) {
            echo "<td width='100'><b>".$GLOBALS["strAdmin"]."</b></td>";
        }
        echo "<td width='100'><b>".$GLOBALS["strAgency"]."</b></td>";
        echo "<td width='100'><b>".$GLOBALS["strClient"]."</b></td>";
        echo "<td width='100'><b>".$GLOBALS["strAffiliate"]."</b></td>";
        echo "</tr></table>";
        echo "</td></tr>";

    }

    $value = $value ? (int)$value : 0;

    echo "<tr onMouseOver=\"setHelp('".$item['name']."')\"><td>&nbsp;</td>\n";
    echo "<td id='cell_".$item['name']."' class='".($item['enabled'] ? 'celldisabled' : 'cellenabled')."'>".$item['text']."</td>\n";
    echo "<td width='100%'>\n";
    echo "<input type='hidden' name='".$item['name']."' id='".$item['name']."' value='".htmlspecialchars($value)."'>\n";

    echo "<table border='0' cellpadding='2' cellspacing='0'><tr align='center'>\n";

    if (phpAds_isUser(phpAds_Admin)) {
        echo "<td width='100'><input type='checkbox' name='".$item['name']."_".phpAds_Admin."' value='true'";
        echo ($value & phpAds_Admin ? ' checked' : '').($item['enabled'] ? ' disabled' : '');
        echo " onClick=\"phpAds_UsertypeChange(this)\" onFocus=\"setHelp('".$item['name']."')\" tabindex='".($tabindex++)."'></td>";
    }
    if (phpAds_isUser(phpAds_Admin) || phpAds_isUser(phpAds_Agency)) {
        echo "<td width='100'><input type='checkbox' name='".$item['name']."_".phpAds_Agency."' value='true'";
        echo ($value & phpAds_Agency ? ' checked' : '').($item['enabled'] ? ' disabled' : '');
        echo " onClick=\"phpAds_UsertypeChange(this)\" onFocus=\"setHelp('".$item['name']."')\" tabindex='".($tabindex++)."'></td>";
    }
    if (phpAds_isUser(phpAds_Admin) || phpAds_isUser(phpAds_Agency) || phpAds_isUser(phpAds_Client)) {
        echo "<td width='100'><input type='checkbox' name='".$item['name']."_".phpAds_Client."' value='true'";
        echo ($value & phpAds_Client ? ' checked' : '').($item['enabled'] ? ' disabled' : '');
        echo " onClick=\"phpAds_UsertypeChange(this)\" onFocus=\"setHelp('".$item['name']."')\" tabindex='".($tabindex++)."'></td>";
    }
    if (phpAds_isUser(phpAds_Admin) || phpAds_isUser(phpAds_Agency) || phpAds_isUser(phpAds_Affiliate)) {
        echo "<td width='100'><input type='checkbox' name='".$item['name']."_".phpAds_Affiliate."' value='true'";
        echo ($value & phpAds_Affiliate ? ' checked' : '').($item['enabled'] ? ' disabled' : '');
        echo " onClick=\"phpAds_UsertypeChange(this)\" onFocus=\"setHelp('".$item['name']."')\" tabindex='".($tabindex++)."'></td>";
    }

    echo "</tr></table>\n";


    echo "</td><td>".phpAds_ShowSettings_PadLock($item)."</td></tr>\n";
}

function phpAds_ShowSettings_UsertypeTextboxes($item, $value)
{
    global $tabindex;

    if (isset($item['show_headers']) && $item['show_headers']) {
        echo "<tr><td>&nbsp;</td><td>&nbsp;</td><td width='100%'>";
        echo "<table border='0' cellpadding='2' cellspacing='0'><tr align='center'>\n";
        if (phpAds_isUser(phpAds_Admin)) {
            echo "<td width='100'><b>".$GLOBALS["strAdmin"]."</b></td>";
        }
        echo "<td width='100'><b>".$GLOBALS["strAgency"]."</b></td>";
        echo "<td width='100'><b>".$GLOBALS["strClient"]."</b></td>";
        echo "<td width='100'><b>".$GLOBALS["strAffiliate"]."</b></td>";
        echo "</tr></table>";
        echo "</td></tr>";

    }

    $value = unserialize($value);

    echo "<tr onMouseOver=\"setHelp('".$item['name']."')\"><td>&nbsp;</td>\n";
    echo "<td id='cell_".$item['name']."' class='".($item['enabled'] ? 'celldisabled' : 'cellenabled')."'>".$item['text']."</td>\n";
    echo "<td width='100%'>\n";

    echo "<table border='0' cellpadding='2' cellspacing='0'><tr align='center'>\n";

    if (phpAds_isUser(phpAds_Admin)) {
        echo "<td width='100'><input type='text' size='10' name='".$item['name']."[".phpAds_Admin."]'";
        echo " value='".(isset($value[phpAds_Admin]) ? htmlspecialchars($value[phpAds_Admin]) : '')."'";
        echo " onFocus=\"setHelp('".$item['name']."')\" tabindex='".($tabindex++)."'></td>";
    }
    if (phpAds_isUser(phpAds_Admin) || phpAds_isUser(phpAds_Agency)) {
        echo "<td width='100'><input type='text' size='10' name='".$item['name']."[".phpAds_Agency."]'";
        echo " value='".(isset($value[phpAds_Agency]) ? htmlspecialchars($value[phpAds_Agency]) : '')."'";
        echo " onFocus=\"setHelp('".$item['name']."')\" tabindex='".($tabindex++)."'></td>";
    }
    if (phpAds_isUser(phpAds_Admin) || phpAds_isUser(phpAds_Agency) || phpAds_isUser(phpAds_Client)) {
        echo "<td width='100'><input type='text' size='10' name='".$item['name']."[".phpAds_Client."]'";
        echo " value='".(isset($value[phpAds_Client]) ? htmlspecialchars($value[phpAds_Client]) : '')."'";
        echo " onFocus=\"setHelp('".$item['name']."')\" tabindex='".($tabindex++)."'></td>";
    }
    if (phpAds_isUser(phpAds_Admin) || phpAds_isUser(phpAds_Agency) || phpAds_isUser(phpAds_Affiliate)) {
        echo "<td width='100'><input type='text' size='10' name='".$item['name']."[".phpAds_Affiliate."]'";
        echo " value='".(isset($value[phpAds_Affiliate]) ? htmlspecialchars($value[phpAds_Affiliate]) : '')."'";
        echo " onFocus=\"setHelp('".$item['name']."')\" tabindex='".($tabindex++)."'></td>";
    }

    echo "</tr></table>\n";


    echo "</td><td>".phpAds_ShowSettings_PadLock($item)."</td></tr>\n";
}

function phpAds_ShowSettings_PadLock($item)
{
    if (showSettingsLocked($item) || $item['enabled']==true) {
        return '<img src="images/padlock-closed.gif">';
    } else {
        return '&nbsp;';
    }
}

function showSettingsLocked($item)
{
    $conf = $GLOBALS['_MAX']['CONF'];
    if ($conf['openads']['installed'] && isset($item['name'])) {
        // Split into config sections
        $confixExploded = explode('_', $item['name']);
        $configLevel = isset($confixExploded[0]) ? $confixExploded[0] : null;
        $configItem = isset($confixExploded[1]) ? $confixExploded[1] : null;
        //list($configLevel, $configItem) = explode('_', $item['name']);
        if (isset($conf[$configLevel][$configItem]) && (!MAX_Admin_Config::isConfigWritable())) {
            return true;
        }
    }
    return false;
}

function _display_to_bytes($val) {
   $val = trim($val);
   $last = strtolower($val{strlen($val)-1});
   switch($last) {
       // The 'G' modifier is available since PHP 5.1.0
       case 'g':
           $val *= 1024;
       case 'm':
           $val *= 1024;
       case 'k':
           $val *= 1024;
   }
   return $val;
}

function _bytes_to_display($val) {
    $val=(float)$val;
    if ($val < 1024) {
        return number_format($val, 0)."b";
    } elseif ($val < 1048576) {
        return number_format($val/1024, 1)."KB";
    } elseif ($val >= 1048576) {
        return number_format($val/1048576, 1)."MB";
    } else {
        return false;
    }
}

?>
