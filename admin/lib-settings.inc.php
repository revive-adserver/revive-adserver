<?php // $Revision$

/************************************************************************/
/* phpAdsNew 2                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2000-2003 by the phpAdsNew developers                  */
/* For more information visit: http://www.phpadsnew.com                 */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/



// Include required files
if (!defined('phpAds_installing'))
{
	include ("config.php");
	
	// Load settings language strings
	@include (phpAds_path.'/language/english/settings.lang.php');
	if ($phpAds_config['language'] != 'english' && file_exists(phpAds_path.'/language/'.$phpAds_config['language'].'/settings.lang.php'))
		@include (phpAds_path.'/language/'.$phpAds_config['language'].'/settings.lang.php');
}


// Load settings help language strings in desired language, if present
@include (phpAds_path.'/language/english/settings-help.lang.php');
if ($phpAds_config['language'] != 'english' && file_exists(phpAds_path.'/language/'.$phpAds_config['language'].'/settings-help.lang.php'))
	@include (phpAds_path.'/language/'.$phpAds_config['language'].'/settings-help.lang.php');


// Include required files
include('lib-config.inc.php');


// Determine wether the config file is locked
$phpAds_config_locked = !phpAds_isConfigWritable();



/*********************************************************/
/* Build a menu with all settings                        */
/*********************************************************/

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
// -->
</script>

<?php
	echo "<table border='0' width='100%' cellpadding='0' cellspacing='0'>";
    echo "<tr><form name='settings_selection'><td height='35'><b>";
    echo $GLOBALS['strChooseSection'].":&nbsp;</b>"; 
    
	echo "<select name='section' onChange='settings_goto_section();' tabindex='".($tabindex++)."'>";
	echo "<option value='db'".($section == 'db' ? ' selected' : '').">".$GLOBALS['strDatabaseSettings']."</option>";
	echo "<option value='invocation'".($section == 'invocation' ? ' selected' : '').">".$GLOBALS['strInvocationAndDelivery']."</option>";
	echo "<option value='host'".($section == 'host' ? ' selected' : '').">".$GLOBALS['strHostAndGeo']."</option>";
	echo "<option value='stats'".($section == 'stats' ? ' selected' : '').">".$GLOBALS['strStatisticsSettings']."</option>";
	echo "<option value='banner'".($section == 'banner' ? ' selected' : '').">".$GLOBALS['strBannerSettings']."</option>";
	echo "<option value='admin'".($section == 'admin' ? ' selected' : '').">".$GLOBALS['strAdministratorSettings']."</option>";
	echo "<option value='interface'".($section == 'interface' ? ' selected' : '').">".$GLOBALS['strGuiSettings']."</option>";
	echo "<option value='defaults'".($section == 'defaults' ? ' selected' : '').">".$GLOBALS['strInterfaceDefaults']."</option>";
	
	echo "</select>&nbsp;<a href='javascript:void(0)' onClick='settings_goto_section();'>";
	echo "<img src='images/".$phpAds_TextDirection."/go_blue.gif' border='0'></a>";
    echo "</td></form>";
    
	echo "<td height='35' align='right'><b><a href=\"#\" onClick=\"javascript:toggleHelp(); return false;\">";
	echo "<img src='images/help-book.gif' width='15' height='15' border='0' align='absmiddle'>";
	echo "&nbsp;".$strHelp."</a></b></td></tr></table>";
	
	phpAds_ShowBreak();
}



/*********************************************************/
/* Return Settings Help HTML Code                        */
/*********************************************************/

function phpAds_SettingsHelp($name)
{
	if (!isset($GLOBALS['phpAds_hlp_'.$name]))
		$GLOBALS['phpAds_hlp_'.$name] = '';
	
	$string = $GLOBALS['phpAds_hlp_'.$name];
	$string = ereg_replace ("[\n\r\t]", " ", $string);
	$string = ereg_replace ("[ ]+", " ", $string);
	$string = str_replace("'", "\\'", $string);
	$string = trim ($string);
	
	return "helpArray['$name'] = '".$string."';\n";
}



/*********************************************************/
/* Build and display the settings user interface         */
/*********************************************************/

function phpAds_ShowSettings ($data, $errors = array())
{
	global $phpAds_config, $HTTP_SERVER_VARS;
	global $tabindex;
	
	// Initialize tabindex (if not already done)
	if(!isset($tabindex)) $tabindex = 1;
	
	// Determine if config file is writable
	$phpAds_config_locked = !phpAds_isConfigWritable();
	
	// Show header
	if (!defined('phpAds_installing'))
	{
		$image = $phpAds_config_locked ? 'closed' : 'open';
		
		echo "<form name='settingsform' method='post' action='".$HTTP_SERVER_VARS['PHP_SELF']."' onSubmit='return phpAds_formCheck(this);'>";
		echo "<br><div class='errormessage'><img class='errormessage' src='images/padlock-".$image.".gif' width='16' height='16' border='0' align='absmiddle'>";
		echo $phpAds_config_locked ? $GLOBALS['strEditConfigNotPossible'] : $GLOBALS['strEditConfigPossible'];
		echo "</div>";
	}
	
	$dependbuffer = "function phpAds_refreshEnabled () {\n";
	$checkbuffer  = '';
	$helpbuffer   = '';
	
	
	$i = 0;
	
	while (list(,$section) = each ($data))
	{
		if (!isset($section['visible']) || $section['visible'])
		{
			if (isset($errors[$i]))
				phpAds_ShowSettings_StartSection($section['text'], $errors[$i]);
			else
				phpAds_ShowSettings_StartSection($section['text']);
			
			
			while (list(,$item) = each ($section['items']))
			{
				if (!isset($item['visible']) || $item['visible'])
				{
					$item['enabled'] = phpAds_ShowSettings_Locked($item);
					
					
					if (!$item['enabled'])
						$dependbuffer .= phpAds_ShowSettings_CheckDependancies ($data, $item);
					
					
					if (count($errors))
					{
						// Page is the result of an error message, get values from the input
						if (isset($item['name']) && isset($GLOBALS[$item['name']]))
							$value = $GLOBALS[$item['name']];
						else
							$value = '';
					}
					else
					{
						// Get the values from the config file
						if (isset($item['name']) && isset($phpAds_config[$item['name']]))
							$value = $phpAds_config[$item['name']];
						else
							$value = '';
					}
					
					
					switch ($item['type'])
					{
						case 'break': 	  phpAds_ShowSettings_Break($item); break;
						case 'checkbox':  phpAds_ShowSettings_Checkbox($item, $value); break;
						case 'text':	  phpAds_ShowSettings_Text($item, $value); break;
						case 'textarea':  phpAds_ShowSettings_Textarea($item, $value); break;
						case 'password':  phpAds_ShowSettings_Password($item, $value); break;
						case 'select':    phpAds_ShowSettings_Select($item, $value); break;
					}
					
					if (isset($item['check']) || isset($item['req']))
					{
						if (!isset($item['check'])) $item['check'] = '';
						if (!isset($item['req'])) $item['req'] = false;
						
						$checkbuffer .= "phpAds_formSetRequirements('".$item['name']."', '".addslashes($item['text'])."', ".($item['req'] ? 'true' : 'false').", '".$item['check']."');\n";
						
						if (isset($item['unique']))
							$checkbuffer .= "phpAds_formSetUnique('".$item['name']."', '|".addslashes(implode('|', $item['unique']))."|');\n";
					}
					
					if (isset($item['name']))
						$helpbuffer .= phpAds_SettingsHelp($item['name']);
				}
			}
			
			phpAds_ShowSettings_EndSection();
		}
		
		$i++;
	}
	
	if (!defined('phpAds_installing'))
		echo '<br><br><input type="submit" value="'.$GLOBALS['strSaveChanges'].'"></form>';
	
	
	echo "<script language='JavaScript'>\n<!--\n\n";
	echo $dependbuffer."}\n\nphpAds_refreshEnabled();\n\n";
	echo $checkbuffer."\n";
	echo "var helpArray = new Array();\n\n";
	echo $helpbuffer."\n";
	echo "//-->\n</script>";
}



/*********************************************************/
/* Settings GUI Functions Wrappers                       */
/*********************************************************/

function phpAds_ShowSettings_CheckDependancies ($data, $item)
{
	global $phpAds_config;
	
	if (isset($item['depends']))
	{
		$depends    = split ('[ ]+', $item['depends']);
		$javascript = "\tenabled = (";
		$result     = true;
		
		while (list (,$word) = each ($depends))
		{
			if (ereg('[\&\|]{1,2}', $word))
			{
				// Operator
				$javascript .= " ".$word." ";
			}
			else
			{
				// Assignment
				eregi ("^(\(?)([a-z0-9_-]+)([\=\!\<\>]{1,2})([\"\'a-z0-9_-]+)(\)?)$", $word, $regs);
				
				$type 		 = phpAds_ShowSettings_GetType ($data, $regs[2]);
				$javascript .= $regs[1]."document.settingsform.".$regs[2].".";
				
				switch ($type)
				{
					case 'checkbox':	$javascript .= 'checked'; break;
					case 'select':		$javascript .= 'selectedIndex'; break;
					default:			$javascript .= 'value'; break;
				}
				
				$javascript .= " ".$regs[3]." ".$regs[4].$regs[5];
			}
		}
		
		$javascript .= ");\n";
		$javascript .= "\tdocument.settingsform.".$item['name'].".disabled = !enabled;\n";
		$javascript .= "\tobj = findObj('cell_".$item['name']."'); if (enabled) { obj.className = 'cellenabled'; } else { obj.className =  'celldisabled'; }\n";
		$javascript .= "\t\n";
		
		return ($javascript);
	}
	
	return ('');
}

function phpAds_ShowSettings_GetType ($data, $name)
{
	while (list(,$section) = each ($data))
	{
		while (list(,$item) = each ($section['items']))
		{
			if (isset($item['name']) && $item['name'] == $name)
				return ($item['type']);
		}
	}
	
	return false;
}

function phpAds_ShowSettings_StartSection($name, $error = array())
{
	$icon = defined('phpAds_installing') ? 'setup' : 'settings';
	
	echo "\t<br><br>\n\n";
	echo "<table border='0' width='100%' cellpadding='0' cellspacing='0'><tr>";
    echo "<td height='25' colspan='4'><img src='images/icon-".$icon.".gif' width='16' height='16' align='absmiddle'>&nbsp;";
	echo "<b>".$name."</b></td></tr>";
	
	echo "<tr height='1'>"; 
    echo "<td bgcolor='#888888' width='30'><img src='images/break.gif' height='1' width='30'></td>";
    echo "<td bgcolor='#888888' width='200'><img src='images/break.gif' height='1' width='200'></td>";
    echo "<td bgcolor='#888888' width='100%'><img src='images/break.gif' height='1' width='1'></td>";
    echo "<td bgcolor='#888888' width='30'><img src='images/break.gif' height='1' width='30'></td>";
	echo "</tr><tr><td height='10' colspan='4'><img src='images/spacer.gif' width='30' height='1'></td></tr>";
	
	if (count($error))
	{
		echo "<tr><td width='30'>&nbsp;</td><td height='10' colspan='2'>";
		echo "<table width='100%' border='0' cellspacing='0' cellpadding='0'><tr>";
        echo "<td width='22' valign='top'><img src='images/error.gif' width='16' height='16'>&nbsp;&nbsp;</td>";
        echo "<td valign='top'><font color='#AA0000'><b>";
		
		while (list(, $v) = each($error))
			echo $v."<br>";
		
		echo "</b></font></td></tr></table></td></tr>";
		echo "<tr><td height='10' width='30'>&nbsp;</td>";
		echo "<td height='10' width='200'><img src='images/spacer.gif' width='200' height='1'></td>";
		echo "<td height='10' width='100%'>&nbsp;</td><td height='10' width='30'>&nbsp;</td></tr>";
		
		echo "<tr><td height='14' width='30'><img src='images/spacer.gif' height='1' width='100%'></td>";
    	echo "<td height='14' width='200'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td>";
		echo "<td height='14' width='100%'>&nbsp;</td><td height='14' width='30'><img src='images/spacer.gif' height='1' width='100%'></tr>";
	}
}

function phpAds_ShowSettings_EndSection()
{
	echo "<tr><td height='10' colspan='4'>&nbsp;</td></tr>";
  	echo "<tr height='1'><td colspan='4' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
	echo "</table><br><br>";
}

function phpAds_ShowSettings_Break($item)
{
	if (!isset($item['size']) || $item['size'] == '' || $item['size'] == 'small')
	{
	  	echo "<tr><td width='30'><img src='images/spacer.gif' height='1' width='100%'></td>";
	    echo "<td width='200'><img src='images/break-l.gif' height='1' width='200' vspace='10'></td>";
	    echo "<td width='100%'>&nbsp;</td><td width='30'><img src='images/spacer.gif' height='1' width='100%'></tr>";
	}
	elseif ($item['size'] == 'large')
	{
	  	echo "<tr><td width='30'><img src='images/spacer.gif' height='1' width='100%'></td>";
	    echo "<td width='100%' colspan='3'><img src='images/break-l.gif' height='1' width='100%' vspace='10'></td></tr>";
	}
	elseif ($item['size'] == 'full')
	{
		echo "<tr><td width='100%' colspan='4'><img src='images/break.gif' height='1' width='100%' vspace='16'></td></tr>";
	}
	elseif ($item['size'] == 'empty')
	{
		echo "<tr><td width='30'><img src='images/spacer.gif' height='1' width='100%'></td>";
	    echo "<td width='200'><img src='images/spacer.gif' height='1' width='200' vspace='10'></td>";
	    echo "<td width='100%'>&nbsp;</td><td width='30'><img src='images/spacer.gif' height='1' width='100%'></tr>";
	}
}

function phpAds_ShowSettings_Checkbox($item, $value)
{
	global $phpAds_config, $tabindex;
	
	echo "<tr onMouseOver=\"setHelp('".$item['name']."')\"><td width='30'>&nbsp;</td>";
    echo "<td id='cell_".$item['name']."' class='".($item['enabled'] ? 'celldisabled' : 'cellenabled')."' colspan='2' width='100%'>";
	
	if (isset($item['indent']) && $item['indent'])
		echo "<img src='images/indent.gif'>";
	
	echo "<input type='checkbox' name='".$item['name']."' value='true'".($value == true ? ' checked' : '').($item['enabled'] ? ' disabled' : '');
	echo " onClick=\"phpAds_refreshEnabled();\" onFocus=\"setHelp('".$item['name']."')\" tabindex='".($tabindex++)."'>".$item['text'];
	
	echo "</td><td width='30'>".phpAds_ShowSettings_PadLock($item)."</td></tr>";
}

function phpAds_ShowSettings_Text($item, $value)
{
	global $phpAds_config, $tabindex;
	
	if (!isset($item['size'])) $item['size'] = 25;
	
 	echo "<tr onMouseOver=\"setHelp('".$item['name']."')\"><td width='30'>&nbsp;</td>";
    echo "<td id='cell_".$item['name']."' class='".($item['enabled'] ? 'celldisabled' : 'cellenabled')."' width='200' valign='top'>".$item['text']."</td>";
    echo "<td width='100%' valign='top'>";
	
	echo "<input onBlur='phpAds_refreshEnabled(); phpAds_formUpdate(this);' class='flat' type='text' name='".$item['name']."'".($item['enabled'] ? ' disabled' : '')." ";
	echo "size='".$item['size']."' value=\"".htmlspecialchars($value)."\" onFocus=\"setHelp('".$item['name']."')\" tabindex='".($tabindex++)."'>";
	
	echo "</td><td width='30'>".phpAds_ShowSettings_PadLock($item)."</td></tr>";
}

function phpAds_ShowSettings_Textarea($item, $value)
{
	global $phpAds_config, $tabindex;
	
	if (!isset($item['rows'])) $item['rows'] = 5;
	
 	echo "<tr onMouseOver=\"setHelp('".$item['name']."')\"><td width='30'>&nbsp;</td>";
    echo "<td id='cell_".$item['name']."' class='".($item['enabled'] ? 'celldisabled' : 'cellenabled')."' width='200' valign='top'>".$item['text']."</td>";
    echo "<td width='100%' valign='top'>";
	
	echo "<textarea onBlur='phpAds_refreshEnabled(); phpAds_formUpdate(this);' class='flat' name='".$item['name']."' rows='".$item['rows']."'".($item['enabled'] ? ' disabled' : '')." ";
	echo "style='width: 350px;' onFocus=\"setHelp('".$item['name']."')\" tabindex='".($tabindex++)."'>".htmlspecialchars($value)."</textarea>";
	
	echo "</td><td width='30'>".phpAds_ShowSettings_PadLock($item)."</td></tr>";
}

function phpAds_ShowSettings_Password($item, $value)
{
	global $phpAds_config, $tabindex;
	
	if (!isset($item['size'])) $item['size'] = 25;
	
	// Hide value
	$value = str_repeat('*', strlen($value));
	
 	echo "<tr onMouseOver=\"setHelp('".$item['name']."')\"><td width='30'>&nbsp;</td>";
    echo "<td id='cell_".$item['name']."' class='".($item['enabled'] ? 'celldisabled' : 'cellenabled')."' width='200' valign='top'>".$item['text']."</td>";
    echo "<td width='100%' valign='top'>";
	
	echo "<input onBlur='phpAds_refreshEnabled(); phpAds_formUpdate(this);' class='flat' type='password' name='".$item['name']."'".($item['enabled'] ? ' disabled' : '')." ";
	echo "value='".$value."' size='".$item['size']."' onFocus=\"setHelp('".$item['name']."')\" tabindex='".($tabindex++)."'>";
	
	echo "</td><td width='30'>".phpAds_ShowSettings_PadLock($item)."</td></tr>";
}

function phpAds_ShowSettings_Select($item, $value)
{
	global $phpAds_config, $tabindex;
	
	if (isset($item['items']))
	{
		echo "<tr onMouseOver=\"setHelp('".$item['name']."')\"><td width='30'>&nbsp;</td>";
    	echo "<td id='cell_".$item['name']."' class='".($item['enabled'] ? 'celldisabled' : 'cellenabled')."' width='200'>".$item['text']."</td>";
    	echo "<td width='100%'>";
		
		echo "<select name='".$item['name']."' onChange=\"phpAds_refreshEnabled();\"";
		echo ($item['enabled'] ? ' disabled' : '')." onFocus=\"setHelp('".$item['name']."')\" tabindex='".($tabindex++)."'>";
		
		while (list($k, $v) = each($item['items']))
		{
			echo "<option value=\"".htmlspecialchars($k)."\"".
				($k == $value ? " selected" : "").">".
				$v."</option>";
		}
		
		echo "</select>";
		echo "</td><td width='30'>".phpAds_ShowSettings_PadLock($item)."</td></tr>";
	}
}

function phpAds_ShowSettings_PadLock($item)
{
	if (phpAds_ShowSettings_Locked($item))
		return '<img src="images/padlock-closed.gif">';
	else
		return '&nbsp;';
}

function phpAds_ShowSettings_Locked($item)
{
	global $phpAds_settings_information, $phpAds_config_locked;
	
	if (!defined('phpAds_installing') &&
		isset($item['name']) &&
		isset($phpAds_settings_information[$item['name']]) &&
		$phpAds_settings_information[$item['name']]['sql'] != true &&
		$phpAds_config_locked == true)
	{
		return true;
	}
	else
	{
		return false;
	}
}

?>