<?php // $Revision$

/************************************************************************/
/* phpAdsNew 2                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2000-2002 by the phpAdsNew developers                  */
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


include('lib-config.inc.php');

$phpAds_config_locked = !phpAds_isConfigWritable();

$phpAds_settings_sections = array(
	"1"			=> $strMainSettings,
	"1.1"		=> $strDatabaseSettings,
	"1.1.1"		=> $strDatabaseServer,
	"1.1.2"		=> $strDatabaseOptimalisations,
	"1.2"		=> $strInvocationAndDelivery,
	"1.2.1"		=> $strDeliverySettings,
	"1.2.2"		=> $strAllowedInvocationTypes,
	"1.2.3"		=> $strP3PSettings,
	"1.5"		=> $strHostAndGeo,
	"1.5.1"		=> $strRemoteHost,
	"1.5.2"		=> $strGeotargeting,
	"1.4"		=> $strStatisticsSettings,
	"1.4.1"		=> $strStatisticsFormat,
	"1.4.2"		=> $strGeotargeting,
	"1.4.3"		=> $strEmailWarnings,
	"1.4.4"		=> $strRemoteHosts,
	"1.4.5"		=> $strAutoCleanTables,
	"1.3"		=> $strBannerSettings,
	"1.3.1"		=> $strDefaultBanners,
	"1.3.2"		=> $strAllowedBannerTypes,
	"1.3.3"		=> $strTypeWebSettings,
	"1.3.4"		=> $strTypeHtmlSettings,
	"2"			=> $strAdminSettings,
	"2.1"		=> $strAdministratorSettings,
	"2.1.1"		=> $strLoginCredentials,
	"2.1.2"		=> $strBasicInformation,
	"2.1.3"		=> $strPreferences,
	"2.2"		=> $strGuiSettings,
	"2.2.1"		=> $strGeneralSettings,
	"2.2.2"		=> $strClientInterface,
	"2.3"		=> $strInterfaceDefaults,
	"2.3.1"		=> $strInventory,
	"2.3.2"		=> $strStatisticsDefaults,
	"2.3.3"		=> $strWeightDefaults
);

$phpAds_settings_cache = array();
$phpAds_settings_cache_on = false;
$phpAds_settings_show_submit = !$phpAds_config_locked;



/*********************************************************/
/* Start a settings section                              */
/*********************************************************/

function phpAds_SettingsSelection($section)
{
	global $phpAds_settings_sections, $tabindex;
	global $phpAds_TextDirection, $strHelp;
	
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
	echo "<option value='db'".($section == 'db' ? ' selected' : '').">".$phpAds_settings_sections["1.1"]."</option>";
	echo "<option value='invocation'".($section == 'invocation' ? ' selected' : '').">".$phpAds_settings_sections["1.2"]."</option>";
	echo "<option value='host'".($section == 'host' ? ' selected' : '').">".$phpAds_settings_sections["1.5"]."</option>";
	echo "<option value='stats'".($section == 'stats' ? ' selected' : '').">".$phpAds_settings_sections["1.4"]."</option>";
	echo "<option value='banner'".($section == 'banner' ? ' selected' : '').">".$phpAds_settings_sections["1.3"]."</option>";
	echo "<option value='admin'".($section == 'admin' ? ' selected' : '').">".$phpAds_settings_sections["2.1"]."</option>";
	echo "<option value='interface'".($section == 'interface' ? ' selected' : '').">".$phpAds_settings_sections["2.2"]."</option>";
	echo "<option value='defaults'".($section == 'defaults' ? ' selected' : '').">".$phpAds_settings_sections["2.3"]."</option>";
	
	echo "</select>&nbsp;<a href='javascript:void(0)' onClick='settings_goto_section();'>";
	echo "<img src='images/".$phpAds_TextDirection."/go_blue.gif' border='0'></a>";
    echo "</td></form>";
    
	echo "<td height='35' align='right'><b><a href=\"javascript:toggleHelp();\">";
	echo "<img src='images/help-book.gif' width='15' height='15' border='0' align='absmiddle'>";
	echo "&nbsp;".$strHelp."</a></b></td></tr></table>";
	
	phpAds_ShowBreak();
}



/*********************************************************/
/* Start a settings section                              */
/*********************************************************/

function phpAds_settings_start_section($section)
{
	global $phpAds_settings_sections;
	
	if (!ereg("^([0-9]+\.)*([0-9]+)$", $section, $matches))
		die();
	
	$icon = defined('phpAds_installing') ? 'setup' : 'settings';
	$title = $phpAds_settings_sections[$section];

	echo "\t<br><br>\n\n";

?> 
	
<table border='0' width='100%' cellpadding='0' cellspacing='0'>
  <tr> 
    <td height='25' colspan='3'><img src="<?php echo "images/icon-".$icon.".gif"; ?>" width="16" height="16" align="absmiddle">&nbsp;<b> 
      <?php echo $title?>
      </b></td>
  </tr>
  <tr height='1'> 
    <td bgcolor='#888888' width='30'><img src='images/break.gif' height='1' width='30'></td>
    <td bgcolor='#888888' width='200'><img src='images/break.gif' height='1' width='200'></td>
    <td bgcolor='#888888' width='100%'><img src='images/break.gif' height='1' width='1'></td>
  </tr>
  <tr> 
    <td height='10' colspan='3'><img src="images/spacer.gif" width="30" height="1"></td>
  </tr>
  <?php

	if (isset($GLOBALS['errormessage'][$matches[2]]))
	{
?>
  <tr> 
    <td width='30'>&nbsp;</td>
    <td height='10' colspan='2'> 
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td width="16" valign='top'><img src='images/error.gif' width='16' height='16'>&nbsp;&nbsp;</td>
          <td valign='top'><font color='#AA0000'><b> 
            <?php
		while (list(, $v) = each($GLOBALS['errormessage'][$matches[2]]))
			echo $v."<br>\n";

?>
            </b></font></td>
        </tr>
      </table>
    </td>
  </tr>
  <tr> 
    <td height='10' width="30">&nbsp;</td>
    <td height='10' width="200"><img src="images/spacer.gif" width="200" height="1"></td>
    <td height='10' width="100%">&nbsp;</td>
  </tr>
  <tr> 
    <td height="14" width="30"><img src='images/spacer.gif' height='1' width='100%'></td>
    <td height="14" width="200"><img src='images/break-l.gif' height='1' width='200' vspace='6'></td>
    <td height="14" width="100%">&nbsp;</td>
  </tr>
  <?php
	}
}



/*********************************************************/
/* Add a settings text field                             */
/*********************************************************/

function phpAds_settings_text($name, $text, $size = 25, $type = 'text', $rows = 5, $parent = '', $value = '')
{
	global $phpAds_config, $phpAds_settings_information;
	
	$extra = ' onFocus="setHelp('."'$name'".')" onBlur="setHelp('."'$name'".')"';

	if ($size == 35)
		$extra .= " style='width:350px;'";
	
	if (!defined('phpAds_installing') &&
		isset($phpAds_settings_information[$name]) &&
		!$phpAds_settings_information[$name]['sql'])
	{
		if ($GLOBALS['phpAds_config_locked'])
		{
			$padlock = '<img src="images/padlock-closed.gif">';
			$locked = true;
		}
		else
		{
			$padlock = '&nbsp;';
			$locked = false;
		}
	}
	else
	{
		$GLOBALS['phpAds_settings_show_submit'] = true;
		
		$padlock = '&nbsp;';
		$locked = false;
	}
	
	if (!empty($parent) || $locked)
		$extra .= !$locked && $phpAds_config[$parent] ? '' : ' disabled';
	
	if (empty($value))
	{
		if (isset($GLOBALS[$name]))
			$value = stripslashes($GLOBALS[$name]);
		else
			$value = isset($phpAds_config[$name]) ? $phpAds_config[$name] : '';
	}
?>
  <tr onMouseOver="setHelp('<?php echo "$name";?>')"> 
    <td width='30'><?php echo $padlock;?></td>
    <td width='200' valign='top'> 
      <?php echo $text; ?>
    </td>
    <td width="100%" valign='top'> 
      <?php
	if ($type == 'textarea')
		echo "<textarea class='flat' name='$name' size='$size' rows='$rows'$extra>".htmlspecialchars($value)."</textarea>";
	elseif ($type == 'password')
		echo "<input class='flat' type='password' name='$name' value='$value' size='$size'$extra>";
	else
		echo "<input class='flat' type='text' name='$name' size='$size'$extra value=\"".htmlspecialchars($value)."\">";
?>
    </td>
  </tr>
  <?php
}



/*********************************************************/
/* Add a settings select field                           */
/*********************************************************/

function phpAds_settings_select($name, $text, $options, $parent = '', $value = '')
{
	global $phpAds_config, $phpAds_settings_information;
	
	$extra = ' onFocus="setHelp('."'$name'".')" onBlur="setHelp('."'$name'".')"';
	
	if (!defined('phpAds_installing') &&
		isset($phpAds_settings_information[$name]) &&
		!$phpAds_settings_information[$name]['sql'])
	{
		if ($GLOBALS['phpAds_config_locked'])
		{
			$padlock = '<img src="images/padlock-closed.gif">';
			$locked = true;
		}
		else
		{
			$padlock = '&nbsp;';
			$locked = false;
		}
	}
	else
	{
		$GLOBALS['phpAds_settings_show_submit'] = true;
		
		$padlock = '&nbsp;';
		$locked = false;
	}
	
	if (!empty($parent) || $locked)
		$extra .= !$locked && $phpAds_config[$parent] ? '' : ' disabled';
	
	if (empty($value))
	{
		if (isset($GLOBALS[$name]))
			$value = stripslashes($GLOBALS[$name]);
		else
			$value = isset($phpAds_config[$name]) ? $phpAds_config[$name] : '';
	}
	
	$options = unserialize($options);
	if (!is_array($options) || !count($options))
		return;
?>
  <tr onMouseOver="setHelp('<?php echo "$name";?>')"> 
    <td width='30'><?php echo $padlock;?></td>
    <td width='200'> 
      <?php echo $text; ?>
    </td>
    <td width="100%"> 
      <?php
		echo "<select name='$name'$extra>";
		while (list($k, $v) = each($options))
		{
			echo "<option value=\"".htmlspecialchars($k)."\"".
				($k == $value ? " selected" : "").">".
				$v."</option>";
		}
		echo "</select>\n";
?>
    </td>
  </tr>
  <?php
}



/*********************************************************/
/* Add a settings break                                  */
/*********************************************************/

function phpAds_settings_break($size = '')
{
	if ($size == '' || $size == 'small')
	{
	?>
	  <tr> 
	    <td width="30"><img src='images/spacer.gif' height='1' width='100%'></td>
	    <td width="200"><img src='images/break-l.gif' height='1' width='200' vspace='10'></td>
	    <td width="100%">&nbsp;</td>
	  </tr>
	  <?php
	}
	elseif ($size == 'large')
	{
	?>
	  <tr> 
	    <td width="30"><img src='images/spacer.gif' height='1' width='100%'></td>
	    <td width="100%" colspan='2'><img src='images/break-l.gif' height='1' width='100%' vspace='10'></td>
	  </tr>
	  <?php
	}
	elseif ($size == 'full')
	{
	?>
	  <tr> 
	    <td width="100%" colspan='3'><img src='images/break.gif' height='1' width='100%' vspace='16'></td>
	  </tr>
	  <?php
	}
	elseif ($size == 'empty')
	{
	?>
	  <tr> 
	    <td width="30"><img src='images/spacer.gif' height='1' width='100%'></td>
	    <td width="200"><img src='images/spacer.gif' height='1' width='200' vspace='10'></td>
	    <td width="100%">&nbsp;</td>
	  </tr>
	  <?php
	}
}



/*********************************************************/
/* Add a settings checkbox                               */
/*********************************************************/

function phpAds_settings_checkbox($name, $indent, $text, $depends = '', $parent = '', $value = '')
{
	global $phpAds_config, $phpAds_settings_information;
	
	$extra = ' onFocus="setHelp('."'$name'".')" onBlur="setHelp('."'$name'".')"';
	$onClick = '';
	
	if (!defined('phpAds_installing') &&
		isset($phpAds_settings_information[$name]) &&
		!$phpAds_settings_information[$name]['sql'])
	{
		if ($GLOBALS['phpAds_config_locked'])
		{
			$padlock = '<img src="images/padlock-closed.gif">';
			$locked = true;
		}
		else
		{
			$padlock = '&nbsp;';
			$locked = false;
		}
	}
	else
	{
		$GLOBALS['phpAds_settings_show_submit'] = true;
		
		$padlock = '&nbsp;';
		$locked = false;
	}
	
	
	if (!empty($parent))
	{
		if (is_array($parent))
		{
			$parentcheck = true;
			
			while(list(, $v) = each($parent))
				$parentcheck = $parentcheck && $phpAds_config[$v];
		}
		else
			$parentcheck = $phpAds_config[$parent];
	}
	
	if (isset($parentcheck) || $locked)
		$extra .= !$locked && $parentcheck ? '' : ' disabled';
	
	if (empty($value))
	{
		if (isset($GLOBALS[$name]))
			$value = stripslashes($GLOBALS[$name]);
		else
			$value = $phpAds_config[$name] ? 't' : 'f';
	}
	
	if (!$locked)
	{
		$onClick .= "this.form.$name.value = this.checked ? 't' : 'f'";
		
		$depends = unserialize($depends);
		
		if (is_array($depends))
		{
			while(list(, $v) = each($depends))
			{
				if ($GLOBALS['phpAds_config_locked'] &&
					isset($phpAds_settings_information[$v]) &&
					!$phpAds_settings_information[$v]['sql'])
					continue;
				
				$onClick .= "; this.form.$v.disabled = this.checked ? false : true";
				$onClick .= "; if (this.form.$v.type == 'hidden') this.form.${v}_chkbx.disabled = this.checked ? false : true";
			}
		}
	}
	
	echo "<tr onMouseOver=\"setHelp('".$name."')\">";
    echo "<td width='30'>".$padlock."</td>";
    echo "<td colspan='2' width='100%'>";
	
	if ($indent)
		echo "<img src='images/indent.gif'>";
	
	echo "<input type='checkbox' name='${name}_chkbx'".($value == 't' ? ' checked' : '')." onClick=\"$onClick\"$extra>";
	echo $text;
	
	if (!$locked)
		echo "<input type='hidden' name='$name' value='$value'>";
    
	echo "</td></tr>";
}



/*********************************************************/
/* End a settings section                                */
/*********************************************************/

function phpAds_settings_end_section()
{
?>
  <tr> 
    <td height='10' colspan='3'>&nbsp;</td>
  </tr>
  <tr height='1'> 
    <td colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td>
  </tr>
</table>
	
	<br><br>
<?php
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
/* Settings GUI Functions Wrappers                       */
/*********************************************************/

function phpAds_StartSettings()
{
	global $phpAds_settings_help_cache;
	global $phpAds_settings_cache_on;
	
	// Turn on caching
	if (!$phpAds_settings_cache_on)
		$phpAds_settings_cache_on = true;
		
	$phpAds_settings_help_cache = "<script language=\"JavaScript\">\n".
		"<!--\n".
		"\n\tvar helpArray = new Array();\n\n";
}



function phpAds_EndSettings()
{
	global $phpAds_settings_help_cache;
	
	$phpAds_settings_help_cache .= "//-->\n".
		"</script>\n";
}



function phpAds_AddSettings($type, $name, $args = '')
{
	global $phpAds_settings_information;
	global $phpAds_settings_cache;
	global $phpAds_settings_help_cache;
	global $phpAds_config_locked;
	global $phpAds_settings_show_submit;
		
	// If $args is empty, set it to empty array
	if (empty($args))
		$args = array();
	elseif (!is_array($args))
		$args = array($args);
		
	while (list($k, $v) = each($args))
	{
		if (is_array($v))
			$v = serialize($v);
		
		$args[$k] = str_replace("'", "\\'", $v);
	}
	
	if (substr($type, strlen($type) - 1, 1) == '+')
	{
		$type = substr($type, 0, strlen($type) - 1);
		$indent = true;
	}
	else
		$indent = false;
	
	
	switch ($type)
	{
		case 'text':
		case 'select':
		case 'colorpicker':
			$phpAds_settings_help_cache .= phpAds_SettingsHelp($name);
			$phpAds_settings_cache[] =
				"phpAds_settings_".$type."('$name', '".
				join("', '", $args).
				"')";
			break;
		case 'checkbox':
			$phpAds_settings_help_cache .= phpAds_SettingsHelp($name);
			$phpAds_settings_cache[] =
				"phpAds_settings_".$type."('$name', ".($indent ? 'true' : 'false').", '".
				join("', '", $args).
				"')";
			break;
		case 'break':
		case 'start_section':
			$phpAds_settings_cache[] =
				"phpAds_settings_".$type."('$name')";
			break;
		case 'end_section':
			$phpAds_settings_cache[] =
				"phpAds_settings_".$type."()";
			break;
		default:
			return '';
	}
	
	return;	
}

function phpAds_FlushSettings()
{
	global $phpAds_settings_cache, $phpAds_settings_cache_on;
	global $phpAds_settings_help_cache;
	global $phpAds_config_locked;
	global $phpAds_settings_show_submit;
	global $strEditConfigNotPossible, $strEditConfigPossible;
	
	if (!$phpAds_settings_cache_on)
		return;
	
	$phpAds_settings_cache_on = false;
	
	if (!defined('phpAds_installing'))
	{
		$image = $phpAds_config_locked ? 'closed' : 'open';
		
		echo "<br>";
		echo "<table border='0' width='100%' cellpadding='0' cellspacing='0'>";
		echo "<tr><td valign='top'><img src='images/padlock-$image.gif' width='16' height='16' border='0' align='absmiddle'>&nbsp;&nbsp;</td><td>";
		echo $phpAds_config_locked ? $strEditConfigNotPossible : $strEditConfigPossible;
		echo "</td></tr></table><br>";
		phpAds_ShowBreak();
	}
	
	if (!empty($phpAds_settings_help_cache))
		echo $phpAds_settings_help_cache;
		
	if (count($phpAds_settings_cache))
		eval(join("; ", $phpAds_settings_cache).";");
	
	if (!defined('phpAds_installing') && $phpAds_settings_show_submit)
		echo '<input type="submit" value="'.$GLOBALS['strSaveChanges'].'">';
}



function phpAds_ShowSettings ($data, $errors = array())
{
	global $phpAds_config, $HTTP_SERVER_VARS;
	
	// Determine if config file is writable
	$phpAds_config_locked = !phpAds_isConfigWritable();
	
	// Show header
	if (!defined('phpAds_installing'))
	{
		$image = $phpAds_config_locked ? 'closed' : 'open';
		
		echo "<form name='settingsform' method='post' action='".$HTTP_SERVER_VARS['PHP_SELF']."' onSubmit='return phpAds_formCheck(this);'>";
		echo "<br><table border='0' width='100%' cellpadding='0' cellspacing='0'>";
		echo "<tr><td valign='top'><img src='images/padlock-".$image.".gif' width='16' height='16' border='0' align='absmiddle'>&nbsp;&nbsp;</td><td>";
		echo $phpAds_config_locked ? $GLOBALS['strEditConfigNotPossible'] : $GLOBALS['strEditConfigPossible'];
		echo "</td></tr></table><br>";
		phpAds_ShowBreak();
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
					
					
					if (isset($item['name']) && isset($phpAds_config[$item['name']]))
						$value = $phpAds_config[$item['name']];
					else
						$value = '';
					
					
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
        echo "<td width='16' valign='top'><img src='images/error.gif' width='16' height='16'>&nbsp;&nbsp;</td>";
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