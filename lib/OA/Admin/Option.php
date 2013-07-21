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

// Required files
require_once MAX_PATH . '/lib/OA/Admin/Settings.php';
require_once MAX_PATH . '/lib/OA/Admin/Template.php';
require_once MAX_PATH . '/lib/max/language/Loader.php';
require_once(MAX_PATH.'/lib/OA/Cache.php');

/**
 * A class to deal with the display of settings and preferences
 *
 * @package    OpenXAdmin
 * @author     Miguel Correa <miguel.correa@openx.org>
 */
class OA_Admin_Option
{
    /**
     * @var object OA_Admin_Template container
     */
    var $oTpl;

    /**
     * Either "account-settings" or "account-preferences" depending on the
     * type of options that are being displayed.
     *
     * @var string
     */
    var $_optionType;

    /**
     * The constructor method.
     *
     * Requires, includes and loads the the required files.
     *
     * @param string $optionType One of "settings", "preferences" or "user", depending
     *                           on if the options are to be displayed in the Settings,
     *                           Account Preferences or User Preferences section.
     */
    function OA_Admin_Option($optionType)
    {
        // Load the required language files
        Language_Loader::load('default');
        Language_Loader::load('settings');
        Language_Loader::load('settings-help');

        // Set the supplied Settings or Preferences information
        $this->_optionType = 'account-' . $optionType;

        // Setup template object
        $this->oTpl = new OA_Admin_Template('option.html');
    }

    /**
     * Write Javascripts functions needed on selection() method
     *
     * @access private
     */
    function _writeJavascriptFunctions()
    {
        echo "<script language='JavaScript'>\n<!--\n\n";
        echo"function options_goto_section()\n";
        echo"{\n";
        echo"    s = document.settings_selection.section.selectedIndex;\n";
        echo"    s = document.settings_selection.section.options[s].value;\n\n";

        //echo"    document.location = '".$this->_optionType."-' + s + '.php';\n";
        echo"    document.location = s;\n";
        echo"}\n\n";

        echo"function phpAds_UsertypeChange(o)\n";
        echo"{\n";
        echo"    var v = 0;\n";
        echo"    var base_name = o.name.replace(/_\d+$/, '');\n";
        echo"    var l;\n\n";

        echo"    for (var i = 1; i <= 8; i <<= 1) {\n";

        echo"        if (o = findObj(base_name + '_' + i)) {\n";
        echo"            v += o.checked ? i : 0\n\n";

        echo"            if (l = findObj(base_name + '_label[' + i +']')) {\n";
        echo"                l.disabled = !o.checked;\n";
        echo"            }\n";
        echo"            if (l = findObj(base_name + '_rank[' + i +']')) {\n";
        echo"                l.disabled = !o.checked;\n";
        echo"            }\n";
        echo"        }\n";
        echo"    }\n\n";

        echo"    if (o = findObj(base_name))\n";
        echo"        o.value = v;\n";
        echo"}\n\n";

        echo "// -->\n</script>";
    }

    function getSettingsPreferences($section)
    {
        /**
         *  @todo After have a way to know if a user is in the admin role, manager role, publisher role
         *        or advertiser role we'll create a personalized "Choose section" listBox
         *        check strMainSettings
         */
        if ($this->_optionType == 'account-settings') {
            $aSections = array(
                'banner-delivery' => array('name' => $GLOBALS['strBannerDelivery'],         'perm' => OA_ACCOUNT_ADMIN),
                'banner-logging'  => array('name' => $GLOBALS['strBannerLogging'],          'perm' => OA_ACCOUNT_ADMIN),
                'banner-storage'  => array('name' => $GLOBALS['strBannerStorage'],          'perm' => OA_ACCOUNT_ADMIN),
                'tracking'        => array('name' => $GLOBALS['strConversionTracking'],     'perm' => OA_ACCOUNT_ADMIN),
                'database'        => array('name' => $GLOBALS['strDatabaseSettings'],       'perm' => OA_ACCOUNT_ADMIN),
                'debug'           => array('name' => $GLOBALS['strDebug'],                  'perm' => OA_ACCOUNT_ADMIN),
                'email'           => array('name' => $GLOBALS['strEmailSettings'],          'perm' => OA_ACCOUNT_ADMIN),
                'geotargeting'    => array('name' => $GLOBALS['strGeotargetingSettings'],   'perm' => OA_ACCOUNT_ADMIN),
                'maintenance'     => array('name' => $GLOBALS['strMaintenanceSettings'],    'perm' => OA_ACCOUNT_ADMIN),
                'update'          => array('name' => $GLOBALS['strUpdateSettings'],         'perm' => OA_ACCOUNT_ADMIN),
                'user-interface'  => array('name' => $GLOBALS['strGuiSettings'],            'perm' => OA_ACCOUNT_ADMIN),
                'plugins'         => array('name' => $GLOBALS['strPluginSettings'],         'perm' => OA_ACCOUNT_ADMIN),
            );
        }
        elseif ($this->_optionType == 'account-preferences') {
            $aSections = array();
            $aSections['banner'] =
                array(
                    'name' => $GLOBALS['strBannerPreferences'],
                    'value' => $this->_optionType.'-banner.php',
                    'perm' => array(OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER, OA_ACCOUNT_ADVERTISER, OA_ACCOUNT_TRAFFICKER)
                );
            $aSections['campaign'] =
                array(
                    'name' => $GLOBALS['strCampaignPreferences'],
                    'value' => $this->_optionType.'-campaign.php',
                    'perm' => array(OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER)
                );
            $aSections['campaign-email-reports'] =
                array(
                    'name' => $GLOBALS['strCampaignEmailReportsPreferences'],
                    'value' => $this->_optionType.'-campaign-email-reports.php',
                    'perm' => array(OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER, OA_ACCOUNT_ADVERTISER, OA_ACCOUNT_TRAFFICKER)
                );
            if ($aConf['logging']['trackerImpressions']) {
                $aSections['tracker'] =
                    array(
                        'name' => $GLOBALS['strTrackerPreferences'],
                        'value' => $this->_optionType.'-tracker.php',
                        'perm' => array(OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER)
                    );
            }
            $aSections['timezone'] =
                array(
                    'name' => $GLOBALS['strTimezonePreferences'],
                    'value' => $this->_optionType.'-timezone.php',
                    'perm' => array(OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER, OA_ACCOUNT_ADVERTISER, OA_ACCOUNT_TRAFFICKER)
                );
            $aSections['user-interface'] =
                array(
                    'name' => $GLOBALS['strUserInterfacePreferences'],
                    'value' => $this->_optionType.'-user-interface.php',
                    'perm' => array(OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER, OA_ACCOUNT_ADVERTISER, OA_ACCOUNT_TRAFFICKER)
                );
            $this->_mergePluginOptions($aSections);
        }
        elseif ($this->_optionType == 'account-user') {
            $aSections = array();
            $aSections['name-language'] =
                array(
                    'name' => $GLOBALS['strNameLanguage'],
                    'perm' => array(OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER, OA_ACCOUNT_ADVERTISER, OA_ACCOUNT_TRAFFICKER)
                );
            $aSections['email'] =
                array(
                    'name' => $GLOBALS['strChangeEmail'],
                    'perm' => array(OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER, OA_ACCOUNT_ADVERTISER, OA_ACCOUNT_TRAFFICKER)
                );
            $aSections['password'] =
                array(
                    'name' => $GLOBALS['strChangePassword'],
                    'perm' => array(OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER, OA_ACCOUNT_ADVERTISER, OA_ACCOUNT_TRAFFICKER)
                );
        }/*
        elseif ($this->_optionType == 'account-user') {
            $aSections = array();
            $aSections['name-language'] =
                array(
                    'name' => $GLOBALS['strNameLanguage'],
                    'perm' => array(OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER, OA_ACCOUNT_ADVERTISER, OA_ACCOUNT_TRAFFICKER)
                );
            $aSections['email'] =
                array(
                    'name' => $GLOBALS['strChangeEmail'],
                    'perm' => array(OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER, OA_ACCOUNT_ADVERTISER, OA_ACCOUNT_TRAFFICKER)
                );
            $aSections['password'] =
                array(
                    'name' => $GLOBALS['strChangePassword'],
                    'perm' => array(OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER, OA_ACCOUNT_ADVERTISER, OA_ACCOUNT_TRAFFICKER)
                );
        }*/

        foreach ($aSections as $k => $v) {
            if (OA_Permission::isAccount($v['perm'])) {
                $aResult[$k]['name'] = (isset($v['text']) ? $v['text'] : $v['name']);
                $aResult[$k]['link'] = ($this->_optionType == 'account-preferences' ? $v['value'] : $this->_optionType.'-'.$k.'.php');
                addLeftMenuSubItem($k, $aResult[$k]['name'], $aResult[$k]['link']);
            }
        }
        setCurrentLeftMenuSubItem($section);

        return $aResult;
    }


    /**
     * Build a menu with all settings or preferences
     *
     * @param string $section The drop down section name.
     */
    function selection($section)
    {
        global $phpAds_TextDirection, $strHelp;
        global $tabindex;
        $aConf = $GLOBALS['_MAX']['CONF'];

        if (!isset($tabindex)) {
            $tabindex = 1;
        }

        $this->_writeJavascriptFunctions();

        echo "<table border='0' width='100%' cellpadding='0' cellspacing='0'><tr>";
        $aSections = $this->getSettingsPreferences($section);
        echo "<td><form name='settings_selection'><td height='35'><b>";
        echo $GLOBALS['strChooseSection'].":&nbsp;</b>";
        echo "<select name='section' onChange='options_goto_section();' tabindex='".($tabindex++)."'>";
        foreach ($aSections as $k => $v) {
            echo "<option value='{$v['link']}'".($section == $k ? ' selected' : '').">{$v['name']}</option>";
        }
        echo "</select>&nbsp;<a href='#' onClick='options_goto_section();'>";
        echo "<img src='" . OX::assetPath() . "/images/".$phpAds_TextDirection."/go_blue.gif' border='0'></a>";
        echo "</td></form></tr></table>";
        phpAds_ShowBreak();
    }


    function _mergePluginOptions(&$aSections)
    {

        $oCache = new OA_Cache('Plugins', 'PrefOptions');
        $oCache->setFileNameProtection(false);
        $aPrefOptions = $oCache->load(true);
        if (!empty($aPrefOptions)) {
            $aSections = array_merge($aSections, $aPrefOptions);
        }
    }


    /**
     * Build and display the settings or preferences user interface
     *
     * @param array $aData A multi-dimensional array outlining what to
     *                     display for a setting or preference page.
     *                     See pages for examples of layout.
     * @param array   $aErrors An array of error messages to display to
     *                         within the form.
     * @param integer $disableSubmit
     * @param string  $imgPath
     */
    function show($aData, $aErrors = array(), $disableSubmit = 0, $imgPath = "")
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        $aPref = $GLOBALS['_MAX']['PREF_EXTRA'];

        // Initialize tabindex (if not already done)
        global $tabindex;
        if (!isset($tabindex)) {
            $tabindex = 1;
        }

        // Determine if config file is writable
        $configLocked = !OA_Admin_Settings::isConfigWritable();
        $image = $configLocked ? 'closed' : 'open';

        $dependbuffer   = "function phpAds_refreshEnabled() {\n";
        $checkbuffer    = '';
        $usertypebuffer = '';
        $helpbuffer     = '';

        // Iterate over the array of elements to display
        $count = count($aData);
        for ($i = 0; $i < $count; $i++) {
            // Get the section of elements to display
            $aSection = $aData[$i];
            // Are there any items in the section that can be displayed?
            $showBreak = false;
            $showSection = false;
            foreach ($aSection['items'] as $itemKey => $aItem) {
            	// The item has been set to be displayed - however, if this is
            	// a preference section, it may not end up being shown, so test for this
            	if ($this->_optionType == 'account-preferences') {
            		// Don't test break items
            		if ($aItem['type'] != 'break') {
            			// What is the state of the preference item?
            			$result = $this->_hideOrDisablePreference($aPref[$aItem['name']]['account_type']);
            			if ($result == '' || $result == 'disable') {
            				// The preference item is to be shown, so display the section
            				$showSection = true;
            				break;
            			}
            		}
            	} else {
            		// The item is not for a preference section, so display the section
            		$showSection = true;
            		break;
            	}
            }
            // Where there any items in the section that will be displayed?
            if ($showSection == false) {
            	// No, go to the next section
            	continue;
            }
            // This section has been set to be displayed, so show its contents!
            if (isset($aErrors[$i])) {
            	// Show the section header with the section error
            	$this->_showStartSection($aSection['text'], $aErrors[$i], $disableSubmit, $imgPath);
            	$showBreak = true;
            } else {
            	// Show the section header
            	$this->_showStartSection($aSection['text'], NULL, $disableSubmit, $imgPath);
            }

            $sectionHasRequiredField = false;
            foreach ($aSection['items'] as $aItem) {
            	// Test to see if the item is a preference item, and if it needs to be hidden from the account in use
            	if ($this->_optionType == 'account-preferences' || $this->_optionType == 'account-user') {
            		$result = $this->_hideOrDisablePreference($aPref[$aItem['name']]['account_type']);
            		if ($result == 'hide') {
            			$aItem['visible'] = false;
            		}
            	}
            	// Only display visible items
            	if (!isset($aItem['visible']) || $aItem['visible']) {
            		// Test to see if the item is a settings item, and if it needs to be disabled
            		if ($this->_optionType == 'account-settings') {
            			if (!$aItem['disabled']) {
            				$aItem['disabled'] = $this->_disabledValue($aItem);
            				if (!$aItem['disabled']) {
            				    $showBreak = true;
            				}
            			}
            		}
            		// Test to see if the item is a preference item, and if it needs to be disabled from the account in use
            		if ($this->_optionType == 'account-preferences' || $this->_optionType == 'account-user') {
            			$result = $this->_hideOrDisablePreference($aPref[$aItem['name']]['account_type']);
            			if ($result == 'disable') {
            				$aItem['disabled'] = true;
            				$showBreak = false;
            			}
            		}
            		// Update the JavaScript used to enable/disabled option items
            		if (($this->_optionType == 'account-preferences' || $this->_optionType == 'account-preferences-user') && $aItem['type'] == 'statscolumns') {
            			// The statscolumns data type needs to have some conversion work done to match
            			// the more simple data structure used by other option items
            			foreach ($aItem['rows'] as $aSubItem) {
            				// Create two fake items for the label and rank
            				$aLabelItem = array(
            				    'name'    => $aSubItem['name'] . '_label',
            				    'depends' => $aSubItem['name'] . '==true'
            				);
                            $aRankItem = array(
                                'name'    => $aSubItem['name'] . '_rank',
                                'depends' => $aSubItem['name'] . '==true',
                                'check'   => 'wholeNumber'
                            );
                            $checkbuffer .= "max_formSetRequirements('".$aSubItem['name'] . '_rank'."', '".addslashes($aSubItem['text'])."', false, 'wholeNumber');\n";
                            // Add the fake item dependencies
                            $dependbuffer .= $this->_showCheckDependancies($aData, $aLabelItem);
                            $dependbuffer .= $this->_showCheckDependancies($aData, $aRankItem);
            			}
            		} else if (!$aItem['disabled']) {
            			$dependbuffer .= $this->_showCheckDependancies($aData, $aItem);
            		}
            		// Display the option item
            		if (count($aErrors)) {
            			// Page is the result of an error message, get values from the input,
            			// not from the settings configuration file or preferences in the database
            			$value = '';
            			if (isset($aItem['name'])) {
            			    MAX_commonRegisterGlobalsArray(array($aItem['name']));
            			    if (isset($GLOBALS[$aItem['name']])) {
                				$value = stripslashes($GLOBALS[$aItem['name']]);
                				if ($aErrors[0] != MAX_ERROR_YOU_HAVE_NO_TRACKERS && $aErrors[0] != MAX_ERROR_YOU_HAVE_NO_CAMPAIGNS) {
                					if (isset($GLOBALS[$aItem['name'].'_defVal'])) {
                						$value = $GLOBALS[$aItem['name'].'_defVal'];
                					}
            					}
            				}
            			}
            			if ($aItem[type] != 'break') {
            			    $showBreak = true;
            			}
            		} else {
            			// The page had no error, so, get the value for the item from an appropriate source
            			unset($value);
            			if (isset($aItem['name'])) {
            				// Try to load the item value from the globals array
            				if (isset($GLOBALS[$aItem['name'].'_defVal'])) {
            					$value = $GLOBALS[$aItem['name'].'_defVal'];
            				}
            				// If that did not work, and the item is a setting, try to load the
            				// item value from the settings configuration file
            				if (is_null($value) && $this->_optionType == 'account-settings') {
            					$aNameExploded = explode('_', $aItem['name']);
            					$aSettingSection = isset($aNameExploded[0]) ? $aNameExploded[0] : null;
            					$aSettingKey     = isset($aNameExploded[1]) ? $aNameExploded[1] : null;
            					if (isset($aConf[$aSettingSection][$aSettingKey])) {
            						// Load the configuration .php file value
            						$value = $aConf[$aSettingSection][$aSettingKey];
            					} elseif (isset($aConf[$aItem['name']][0])) {
            						// The value in the settings configuration file is an array,
            						// so re-constitute into a comma separated list
            						$value = implode(', ', $aConf[$aItem['name']]);
            					}
            				}
            				// toggle the checkbox if a local db socket is being used
                            if ($aSettingSection == 'database' && $aItem['name'] == 'database_localsocket') {
                                $value = ($aConf[$aSettingSection]['protocol'] == 'unix') ? true : false;
                            }
                            // toggle the checkbox if checkForUpdates (sync section) is disabled
                            if ($aSettingSection == 'ui' && $aItem['name'] == 'ui_dashboardEnabled') {
                                if(isset($aConf['sync']['checkForUpdates']) && $aConf['sync']['checkForUpdates']==true) {
                                    $value = $aConf[$aSettingSection][$aSettingKey];
                                } else {
                                    $value = false;
                                }
                            }
            				// If that did not work, and the item is a preference, try to load the
            				// item value from the preferences values in the database
            				if (is_null($value) && $this->_optionType == 'account-preferences') {
            					// Deal with statistics column values separately
            					if ($aItem['type'] == 'statscolumns') {
            						foreach ($aItem['rows'] as $key => $aRow) {
            							if (isset($aPref[$aRow['name']]['value'])) {
            								$value[$aRow['name']]['base'] = $aPref[$aRow['name']]['value'];
            							}
            							if (isset($aPref[$aRow['name'] . '_label']['value'])) {
            								$value[$aRow['name']]['label'] = $aPref[$aRow['name'] . '_label']['value'];
            							}
            							if (isset($aPref[$aRow['name'] . '_rank']['value'])) {
            								$value[$aRow['name']]['rank'] = $aPref[$aRow['name'] . '_rank']['value'];
            							}
            						}
            					} else {
            						if (isset($aPref[$aItem['name']]['value'])) {
            							$value = $aPref[$aItem['name']]['value'];
            						}
            					}
            				}
            				// If that did not work, try to load the value from the $aItem array itself
            				if (is_null($value)) {
            					if (isset($aItem['value'])) {
            						$value = $aItem['value'];
            					}
            				}
            				// If that did not work, set to an empty string
            				if (is_null($value)) {
            					$value = '';
            				}
            			}
            			if (!empty($value) && isset($aItem['preg_split']) && isset($aItem['merge'])) {
            			    $aValues = preg_split($aItem['preg_split'], $value);
                            $value = implode($aItem['merge'], $aValues);
            			}

            			if ($aItem[type] != 'break') {
            			    $showBreak = true;
            			}
            		}
            		// Display the item!
            		switch ($aItem['type']) {
            			case 'plaintext':
            				$this->_showPlainText($aItem);
            				break;
            			case 'break':
            				if ($showBreak) {
            					$this->_showBreak($aItem, $imgPath);
            					$showBreak = false;
            				}
            				break;
            			case 'checkbox':
            				$this->_showCheckbox($aItem, $value);
            				break;
            		    case 'text':
            		    	$this->_showText($aItem, $value);
            		    	break;
            		    case 'url':
            		    	$this->_showUrl($aItem, $value);
            		    	break;
            		    case 'urln':
            		    	$this->_showUrl($aItem, $value, 'n');
                            break;
                        case 'urls':
                            $this->_showUrl($aItem, $value, 's');
                            break;
                        case 'textarea':
                            $this->_showTextarea($aItem, $value);
                            break;
                        case 'password':
                            $this->_showPassword($aItem, $value);
                            break;
                        case 'select':
                            $this->_showSelect($aItem, $value, $disableSubmit);
                            break;
                        case 'statscolumns':
                            $this->_showStatsColumns($aItem, $value);
                            break;
                        case 'hiddenfield':
                            $this->_showHiddenField($aItem, $value);
                            break;
                        case 'hiddencheckbox':
                            $this->_showHiddenCheckbox($aItem, $value);
                            break;
                    }
                    // ???
                    if (isset($aItem['req'])) {
                    	$sectionHasRequiredField = true;
                    }
                    if (isset($aItem['check']) || isset($aItem['req'])) {
                        if (!isset($aItem['check'])) {
                            $aItem['check'] = '';
                        }
                        if (!isset($aItem['req'])) {
                            $aItem['req'] = false;
                        }
                        $checkbuffer .= "max_formSetRequirements('".$aItem['name']."', '".addslashes($aItem['text'])."', ".($aItem['req'] ? 'true' : 'false').", '".$aItem['check']."');\n";
                        if (isset($aItem['unique'])) {
                            $checkbuffer .= "max_formSetUnique('".$aItem['name']."', '|".addslashes(implode('|', $aItem['unique']))."|');\n";
                        }
                    }
                    if (isset($aItem['name'])) {
                        $helpbuffer .= $this->_help($aItem['name']);
                    }
                }
            }
            $this->_showEndSection($sectionHasRequiredField);
        }
        $this->_showHiddenField(array('name' => 'token', 'value' => phpAds_SessionGetToken()), '');

        if (OA_INSTALLATION_STATUS == OA_INSTALLATION_STATUS_INSTALLED)
        {
            if ($disableSubmit != 0) {
                $max_file_size = $this->_display_to_bytes(ini_get('upload_max_filesize'));
                $max_post_size = $this->_display_to_bytes(ini_get('post_max_size'));
                if (($max_post_size > 0) && ($max_post_size < $max_file_size)) {
                    $max_file_size = $max_post_size;
                }
                $this->oTpl->assign('max_file_size',    $max_file_size);
                $this->oTpl->assign('max_post_size',    $max_post_size);
            }
        }

        $this->oTpl->assign('this',             $this);
        $this->oTpl->assign('aOption',          $this->aOption);
        $this->oTpl->assign('configLocked',     $configLocked);
        $this->oTpl->assign('image',            $image);
        $this->oTpl->assign('formUrl',          $_SERVER['SCRIPT_NAME']);
        $this->oTpl->assign('checkbuffer',      $checkbuffer);
        $this->oTpl->assign('dependbuffer',     $dependbuffer);
        $this->oTpl->assign('disableSubmit',    $disableSubmit);
        $this->oTpl->assign('usertypebuffer',   $usertypebuffer);
        $this->oTpl->assign('tabindex',         $tabindex);
        $this->oTpl->assign('section',          $aSettingSection);
        $this->oTpl->assign('optionType',       $this->_optionType);
        $this->oTpl->assign('adminUser',        OA_Permission::isAccount(OA_ACCOUNT_ADMIN));
        $this->oTpl->assign('oxInstalled',      OA_INSTALLATION_STATUS == OA_INSTALLATION_STATUS_INSTALLED);

        $this->oTpl->display();
    }

    /**
     * A private method to test preferences, and determine if the preference
     * should be displayed or not, based on the current account type in use.
     *
     * @access private
     * @param string $preferenceType The preference type. One of the defined values
     *                               OA_ACCOUNT_MANAGER, OA_ACCOUNT_ADVERTISER or
     *                               OA_ACCOUNT_TRAFFICKER. (That is, the possible
     *                               types of restricted preferences.)
     * @return string One of:
     *                  - "disable" if the preference value should be displayed, but
     *                     not be abled to be modified by the current acting account
     *                  - "hide" if the preference value should not be shown at all
     *                     to the current acting account
     *                  - An empty string, otherwise.
     */
    function _hideOrDisablePreference($preferenceType)
    {
        $noRestriction = '';
        if (is_null($preferenceType) || $preferenceType == '') {
            // The preference type is not restricted in any way
            return $noRestriction;
        }
        // Get the type of account currently in use
        $accountType = OA_Permission::getAccountType();
        if ($accountType == OA_ACCOUNT_ADMIN) {
            // The admin account can see all preferences
            return $noRestriction;
        }
        if ($accountType == OA_ACCOUNT_MANAGER) {
            // The manager account can only not see admin preferences
            if ($preferenceType == OA_ACCOUNT_ADMIN) {
                return 'disable';
            }
            return $noRestriction;
        }
        // Is the preference type restricted to admin?
        if ($preferenceType == OA_ACCOUNT_ADMIN) {
            return 'disable';
        }
        // Is the preference type restricted to managers?
        if ($preferenceType == OA_ACCOUNT_MANAGER) {
            return 'disable';
        }
        if ($accountType == OA_ACCOUNT_ADVERTISER) {
            // Is the preference type restricted to traffickers?
            if ($preferenceType == OA_ACCOUNT_TRAFFICKER) {
                return 'hide';
            }
        }
        if ($accountType == OA_ACCOUNT_TRAFFICKER) {
            // Is the preference type restricted to advertisers?
            if ($preferenceType == OA_ACCOUNT_ADVERTISER) {
                return 'hide';
            }
        }
        return $noRestriction;
    }

    /**
     * A private method to generate the help string for an option item.
     *
     * @access private
     * @param string $name The name of the option item.
     * @return string The help string for the option item.
     */
    function _help($name)
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

    /**
     * Enter description here...
     *
     * @param unknown_type $aData
     * @param unknown_type $aItem
     * @return unknown
     */
    function _showCheckDependancies($aData, $aItem)
    {
        $formName = empty($GLOBALS['settings_formName']) ? 'settingsform' : $GLOBALS['settings_formName'];
        if (isset($aItem['depends'])) {
            $depends    = split('[ ]+', $aItem['depends']);
            $javascript = "\tenabled = (";
            $result     = true;
            foreach ($depends as $word) {
                if (ereg('[\&\|]{1,2}', $word)) {
                    // Operator
                    $javascript .= " ".$word." ";
                } else {
                    // Assignment
                    eregi ("^(\(?)([a-z0-9_-]+)([\=\!\<\>]{1,2})([\"\'a-z0-9_-]+)(\)?)$", $word, $regs);
                    $type          = $this->_showGetType($aData, $regs[2]);
                    $javascript .= $regs[1]."document.".$formName.".".$regs[2].".";
                    switch ($type){
                        case 'checkbox':    $javascript .= 'checked'; break;
                        case 'select':      $javascript .= 'selectedIndex'; break;
                        default:            $javascript .= 'value'; break;
                    }
                    $javascript .= " ".$regs[3]." ".$regs[4].$regs[5];
                    $javascript .= " && ".$regs[1]."document.".$formName.".".$regs[2].".disabled ". $regs[3]. " false";
                }
            }
            $javascript .= ");\n";
            $javascript .= "\tdocument.".$formName.".".$aItem['name'].".disabled = !enabled;\n";
            $javascript .= "\tobj = findObj('cell_".$aItem['name']."'); if (enabled) { obj.className = 'cellenabled'; } else { obj.className =  'celldisabled'; }\n";
            $javascript .= "\t\n";
            return ($javascript);
        }
        return ('');
    }

    function _showGetType ($aData, $name)
    {
        foreach ($aData as $section) {
            foreach ($section['items'] as $aItem) {
                if (isset($aItem['name']) && $aItem['name'] == $name) {
                    return ($aItem['type']);
                }
                // Deal with statscolumns fields
                if (isset($aItem['rows']) && is_array($aItem['rows'])) {
                    foreach ($aItem['rows'] as $aRow) {
                        if (isset($aRow['name']) && $aRow['name'] == $name) {
                            return 'checkbox';
                        }
                    }
                }
            }
        }
        return false;
    }

    function _showStartSection($name, $error = array(), $disableSubmit=0, $imgPath="")
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        $icon = (OA_INSTALLATION_STATUS != OA_INSTALLATION_STATUS_INSTALLED) ? 'setup' : 'settings';

        $aItem['name'] = $name;
        $aItem['error'] = $error;
        $aItem['icon'] = $icon;
        $aItem['disabledSubmit'] = $disableSubmit;
        $aItem['imgPath'] = $imgPath;
        $this->aOption[] = array('startsection.html' => $aItem);
    }

    function _showEndSection($sectionHasRequiredField = false)
    {
        $this->aOption[] = array('endsection.html' => array('hasRequiredField' => $sectionHasRequiredField));
    }

    function _showPlainText($aItem)
    {
        $this->aOption[] = array('plaintext.html' => $aItem);
    }

    function _showBreak($aItem, $imgPath='')
    {
        $aItem['imgPath'] = $imgPath;

        $this->aOption[] = array('break.html' => $aItem);
    }

    function _showCheckbox($aItem, $value)
    {
        global $tabindex;

        $aItem['tabindex'] = $tabindex++;

        // Make sure that 'f' for enums is also considered
        $value = !empty($value) && (bool)strcasecmp($value, 'f');
        $aItem['value'] = $value;

        $this->aOption[] = array('checkbox.html' => $aItem);
    }

    function _showHiddenCheckbox($aItem, $value)
    {
        global $tabindex;

        $aItem['tabindex'] = $tabindex++;

        // Make sure that 'f' for enums is also considered
        $value = !empty($value) && (bool)strcasecmp($value, 'f');
        $aItem['value'] = $value;

        $this->aOption[] = array('hiddencheckbox.html' => $aItem);
    }

    function _showHiddenField($aItem, $value)
    {
        global $tabindex;

        $aItem['tabindex'] = $tabindex++;
        $this->aOption[] = array('hiddencheckbox.html' => $aItem);
    }

    function _showText($aItem, $value)
    {
        global $tabindex;

        $aItem['tabindex'] = $tabindex++;
        if (isset($aItem['decode']) && $aItem['decode'])
        {
            $aItem['value'] = htmlspecialchars_decode($value);
        }
        else
        {
            $aItem['value'] = htmlspecialchars($value);
        }
        $aItem['value'] = $value;

        if (!isset($aItem['size'])) {
            $aItem['size'] = 25;
        }

        $this->aOption[] = array('text.html' => $aItem);
    }

    function _showUrl($aItem, $value, $type = '')
    {
        global $tabindex;

        $aItem['tabindex'] = $tabindex++;
        $aItem['value'] = htmlspecialchars($value);
        $aItem['type'] = $type;

        if (!isset($aItem['size'])) {
            $aItem['size'] = 25;
        }

        $this->aOption[] = array('url.html' => $aItem);
    }

    function _showTextarea($aItem, $value)
    {
        global $tabindex;

        $aItem['tabindex'] = $tabindex++;
        $aItem['value'] = htmlspecialchars($value);

        if (!isset($aItem['rows'])) {
            $aItem['rows'] = 5;
        }

        $this->aOption[] = array('textarea.html' => $aItem);
    }

    function _showPassword($aItem, $value)
    {
        global $tabindex;
        if (!isset($aItem['size'])) {
            $aItem['size'] = 25;
        }
        //  if config file is not writeable do not display password
        $hidePassword = false;
        $writeable = OA_Admin_Settings::isConfigWritable();
        if ($aItem['name'] == 'database_password' && !$writeable) {
            $value = 'password';
            $hidePassword = true;
        }
        $aItem['value'] = $value;
        $aItem['hidePassword'] = $hidePassword;
        $aItem['tabindex'] = $tabindex++;
        $this->aOption[] = array('password.html' => $aItem);
    }

    function _showSelect($aItem, $value, $showSubmitButton=0)
    {
        global $tabindex;
        $aItem['tabindex'] = $tabindex++;
        $aItem['value'] = $value;
        $aItem['showSubmitButton'] = $showSubmitButton;
        foreach ($aItem['items'] as $k => $v) {
            $k = htmlspecialchars($k);
            $aItem['items'][$k] = $v;
        }
        $this->aOption[] = array('select.html' => $aItem);
    }

    /**
     * A private method to set the required options for column-based output
     * of option items.
     *
     * @access private
     * @param array $aItem The column option to display.
     * @param array $aValue An array of the column values.
     */
    function _showStatsColumns($aItem, $aValue)
    {
    	// Get all of the preference types that exist
    	$aPreferenceTypes = array();
    	$doPreferences = OA_Dal::factoryDO('preferences');
    	$doPreferences->find();
    	if ($doPreferences->getRowCount() >= 1) {
    		while ($doPreferences->fetch()) {
    			$aPreference = $doPreferences->toArray();
    			$aPreferenceTypes[$aPreference['preference_name']] = array(
    			    'preference_id' => $aPreference['preference_id'],
    			    'account_type'  => $aPreference['account_type']
    			);
    		}
    	}
		// Get the type of the current accout
		$currentAccountType = OA_Permission::getAccountType();

        global $tabindex;
        $aItem['tabindex'] = $tabindex++;
        foreach ($aItem['rows'] as $key => $aRow) {
            if (isset($aValue[$aRow['name']]['base'])) {
                $aItem['rows'][$key]['value'] = $aValue[$aRow['name']]['base'];
            }
            if (isset($aValue[$aRow['name']]['label'])) {
                $aItem['rows'][$key]['label_value'] = $aValue[$aRow['name']]['label'];
            }
            if (isset($aValue[$aRow['name']]['rank'])) {
                $aItem['rows'][$key]['rank_value'] = $aValue[$aRow['name']]['rank'];
            }

            // Has the current account got access to edit this preference?
        	$access = OA_Preferences::hasAccess($currentAccountType, $aPreferenceTypes[$aRow['name']]['account_type']);
        	if ($access == false) {
        		$aItem['rows'][$key]['disabled'] = true;
        	}
        }
        $this->aOption[] = array('statscolumns.html' => $aItem);
        // Update the global tab index for the number of stats column rows added
        $rows = count($aItem['rows']);
        $tabindex += $rows * 3; // Not an exact increment of the tab index, but close enough!
    }

    function _assignAccountsIds()
    {
        $this->oTpl->assign('OA_ACCOUNT_ADMIN_ID',      OA_ACCOUNT_ADMIN_ID);
        $this->oTpl->assign('OA_ACCOUNT_MANAGER_ID',    OA_ACCOUNT_MANAGER_ID);
        $this->oTpl->assign('OA_ACCOUNT_ADVERTISER_ID', OA_ACCOUNT_ADVERTISER_ID);
        $this->oTpl->assign('OA_ACCOUNT_TRAFFICKER_ID', OA_ACCOUNT_TRAFFICKER_ID);
    }

    /**
     * A private method to determine if the padlock image should be displayed next to
     * an option item or not, nased on the  and return appropriate HTML output.
     *
     * @param array $aItem The option item array.
     * @return unknown
     */
    function _showPadLock($aItem)
    {
        if ($aItem['disabled']) {
            return '<img src="' . OX::assetPath() . '/images/padlock-closed.gif">';
        } else {
            return '&nbsp;';
        }
    }

    /**
     * A private method to determine if a setting configuration file option item should be
     * disabled or not, based on the state of settings configuration file (i.e. if the file
     * be written to, or not).
     *
     * @access private
     * @param array $aItem An array of the option item.
     * @return boolean True if the option should be disabled, false otherwise.
     */
    function _disabledValue($aItem)
    {
        if ($this->_optionType == 'account-settings') {
            $aConf = $GLOBALS['_MAX']['CONF'];
            if ((OA_INSTALLATION_STATUS == OA_INSTALLATION_STATUS_INSTALLED) && isset($aItem['name']))
            {
                $aNameExploded = explode('_', $aItem['name']);
                $aSettingSection = isset($aNameExploded[0]) ? $aNameExploded[0] : null;
                $aSettingKey     = isset($aNameExploded[1]) ? $aNameExploded[1] : null;
                if (isset($aConf[$aSettingSection][$aSettingKey]) && (!OA_Admin_Settings::isConfigWritable())) {
                    return true;
                }
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

    /**
     * Returns the constrant name of a PEAR_LOG_* integer value.
     *
     * @param int $priority     A PEAR_LOG_* integer constant value.
     * @return string|mixed     The constrant name of $priority if value match to PEAR log levels otherwise returns given value without changes.
     */
    function pearLogPriorityToConstrantName($priority){
        $levels = array(
            PEAR_LOG_EMERG   => 'PEAR_LOG_EMERG',
            PEAR_LOG_ALERT   => 'PEAR_LOG_ALERT',
            PEAR_LOG_CRIT    => 'PEAR_LOG_CRIT',
            PEAR_LOG_ERR     => 'PEAR_LOG_ERR',
            PEAR_LOG_WARNING => 'PEAR_LOG_WARNING',
            PEAR_LOG_NOTICE  => 'PEAR_LOG_NOTICE',
            PEAR_LOG_INFO    => 'PEAR_LOG_INFO',
            PEAR_LOG_DEBUG   => 'PEAR_LOG_DEBUG'
        );

        if (array_key_exists($priority, $levels)) {
            return $levels[$priority];
        } else {
            return $priority;
        }
    }

}

?>