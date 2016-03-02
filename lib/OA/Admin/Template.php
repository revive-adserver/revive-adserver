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

define('SMARTY_DIR', MAX_PATH . '/lib/smarty/');

require_once MAX_PATH . '/lib/smarty/Smarty.class.php';
require_once MAX_PATH . '/lib/smarty/plugins/modifier.escape.php';
require_once MAX_PATH . '/lib/OA/Dll.php';
require_once MAX_PATH . '/lib/pear/Date.php';
require_once MAX_PATH . '/lib/OX/Translation.php';
require_once MAX_PATH . '/lib/max/other/html.php';

/**
 * A UI templating class.
 *
 * @package    OpenXAdmin
 */
class OA_Admin_Template extends Smarty
{
    /**
     * @var string
     */
    var $templateName;

    /**
     * @var string
     */
    var $cacheId;

    /**
     * @var int
     */
    var $_tabIndex = 0;

    function __construct($templateName)
    {
        $this->init($templateName);
    }

    function init($templateName)
    {
        $this->template_dir = MAX_PATH . '/lib/templates/admin';
        $this->compile_dir  = MAX_PATH . '/var/templates_compiled';
        $this->cache_dir    = MAX_PATH . '/var/cache';

        $this->caching = 0;
        $this->cache_lifetime = 3600;

        $this->register_function('t', array('OA_Admin_Template',  '_function_t'));

        $this->register_function('tabindex', array('OA_Admin_Template',  '_function_tabindex'));

        $this->register_function('oa_icon', array('OA_Admin_Template',  '_function_oa_icon'));
        $this->register_function('oa_title_sort', array('OA_Admin_Template',  '_function_oa_title_sort'));

        $this->register_function('ox_column_title', array('OA_Admin_Template',  '_function_ox_column_title'));
        $this->register_function('ox_column_class', array('OA_Admin_Template',  '_function_ox_column_class'));
        $this->register_function('ox_campaign_type', array('OA_Admin_Template',  '_function_ox_campaign_type'));
        $this->register_function('ox_campaign_status', array('OA_Admin_Template',  '_function_ox_campaign_status'));
        $this->register_function('ox_campaign_icon', array('OA_Admin_Template',  '_function_ox_campaign_icon'));
        $this->register_function('ox_banner_size', array('OA_Admin_Template',  '_function_ox_banner_size'));
        $this->register_function('ox_banner_icon', array('OA_Admin_Template',  '_function_ox_banner_icon'));
        $this->register_function('ox_zone_size', array('OA_Admin_Template',  '_function_ox_zone_size'));
        $this->register_function('ox_zone_icon', array('OA_Admin_Template',  '_function_ox_zone_icon'));
        $this->register_function('ox_tracker_type', array('OA_Admin_Template',  '_function_ox_tracker_type'));
        $this->register_function('ox_entity_id', array('OA_Admin_Template',  '_function_ox_entity_id'));

        $this->register_function('boldSearchPhrase', array('OA_Admin_Template', '_function_boldSearchPhrase'));

        $this->register_function('oa_is_admin', array('OA_Admin_Template',  '_function_oa_is_admin'));
        $this->register_function('oa_is_manager', array('OA_Admin_Template',  '_function_oa_is_manager'));
        $this->register_function('oa_is_advertiser', array('OA_Admin_Template',  '_function_oa_is_advertiser'));
        $this->register_function('oa_is_trafficker', array('OA_Admin_Template',  '_function_oa_is_trafficker'));

        $this->register_function('phpAds_ShowBreak', array('OA_Admin_Template',  '_function_phpAds_ShowBreak'));
        $this->register_function('phpAds_DelConfirm', array('OA_Admin_Template',  '_function_phpAds_DelConfirm'));
        $this->register_function('MAX_zoneDelConfirm', array('OA_Admin_Template',  '_function_MAX_zoneDelConfirm'));

        $this->register_function('showStatusText', array('OA_Admin_Template',  '_function_showStatusText'));
        $this->register_function('showCampaignType', array('OA_Admin_Template',  '_function_showCampaignType'));

        $this->register_function('oa_form_input_attributes', array('OA_Admin_Template',  '_function_form_input_attributes'));
        $this->register_block('oa_edit', array('OA_Admin_Template',  '_block_edit'));
        $this->register_block('oa_form_element', array('OA_Admin_Template',  '_block_form_element'));

        $this->templateName = $templateName;

        $this->assign('phpAds_TextDirection',  $GLOBALS['phpAds_TextDirection']);
        $this->assign('phpAds_TextAlignLeft',  $GLOBALS['phpAds_TextAlignLeft']);
        $this->assign('phpAds_TextAlignRight', $GLOBALS['phpAds_TextAlignRight']);
        $this->assign('assetPath', OX::assetPath());
        $this->assign("adminWebPath", MAX::constructURL(MAX_URL_ADMIN, ''));
        $this->assign("oaTemplateDir", MAX_PATH.'/lib/templates/admin/');

        //for pluggable page elements
        //- plugins may need to refrence their JS in OXP page templates
        $this->assign("adminPluginWebPath", MAX::constructURL(MAX_URL_ADMIN, 'plugins'));

        //- plugins may need to inject their own
        //template based elements into normal templates
        $this->assign("pluginBaseDir", MAX_PATH.'/www/admin/plugins/');
        $this->assign("pluginTemplateDir", '/templates/');

        /**
         * CVE-2013-5954
         *
         * Register the helper method to allow the the required session token to
         * be placed into GET method calls for CRUD operations in templates. See
         * OA_Permission::checkSessionToken() method for details.
         */
        $this->register_function('rv_add_session_token', array('OA_Admin_Template', '_add_session_token'));

        // Also assign a template variable for other usages
        $this->assign("csrfToken", phpAds_SessionGetToken());
    }

    /**
     * CVE-2013-5954
     *
     * Helper method to allow the the required session token to be placed
     * into GET method calls for CRUD operations in templates. See
     * OA_Permission::checkSessionToken() method for details.
     */
    static public function _add_session_token()
    {
        return 'token=' . urlencode(phpAds_SessionGetToken());
    }

    /**
     * A method to set a cache id for the current page
     *
     * @param mixed $cacheId Either a string or an array of parameters
     */
    function setCacheId($cacheId = null)
    {
        if (is_null($cacheId)) {
            $this->cacheId = null;
            $this->caching = 0;
        } else {
            if (is_array($cacheId)) {
                $cacheId = join('^@^', $cacheId);
            }
            $this->cacheId = md5($cacheId);
            $this->caching = 1;
        }
    }

    /**
     * A method to set the cached version of the template to be used until
     * a certain date/time
     *
     * @param Date $oDate
     */
    function setCacheExpireAt($oDate)
    {
        $timeStamp = strftime($oDate->format('%Y-%m-%d %H:%M:%S'));
        $this->cache_lifetime = $timeStamp - time();
        $this->caching = 2;
    }

    /**
     * A method to set the cached vertsion of the template to expire after
     * a time span
     *
     * @param Date_Span $oSpan
     */
    function setCacheLifetime($oSpan)
    {
        $this->cache_lifetime = $oSpan->toSeconds();
        $this->caching = 2;
    }

    function is_cached($tpl_file = null, $cache_id = null, $compile_id = null)
    {
        return parent::is_cached($this->templateName, $this->cacheId);
    }


    function display($resource_name = null, $cache_id = null, $compile_id = null)
    {
        parent::display($this->templateName, $this->cacheId);
    }


    function toString()
    {
        return parent::fetch($this->templateName, $this->cacheId, null, false);
    }


    function _function_t($aParams, &$smarty)
    {
        $oTrans = new OX_Translation();

        if (!empty($aParams['str'])) {
            if (!empty($aParams['values'])) {
                $aValues = explode('|', $aParams['values']);
            } else {
                $aValues = array();
            }
            $t = $oTrans->translate($aParams['str'], $aValues);
        } elseif (!empty($aParams['key'])) {
            $t = $oTrans->translate($aParams['key']);
        }

        if (isset($t)) {
            if (empty($aParams['escape'])) {
                return $t;
            }

            return smarty_modifier_escape($t, $aParams['escape']);
        }

        // If nothing found in global scope, return the value unchanged
        if (!empty($aParams['str'])) {
            return $aParams['str'];
        }
        if (!empty($aParams['key'])) {
            return $aParams['key'];
        }

        $smarty->trigger_error("t: missing 'str' or 'key' parameters: ".$aParams['str']);
    }


    function _function_showCampaignType($aParams, &$smarty)
    {
        $priority = $aParams['priority'];
        return OX_Util_Utils::getCampaignTypeName($priority);
    }


    function _function_showStatusText($aParams, &$smarty)
    {
        global $strCampaignStatusRunning, $strCampaignStatusPaused, $strCampaignStatusAwaiting,
               $strCampaignStatusExpired, $strCampaignStatusApproval, $strCampaignStatusRejected,
               $strCampaignStatusPending;

        if (isset($aParams['status'])) {
              switch ($aParams['status']) {
                    case OA_ENTITY_STATUS_PENDING:
                        $class = 'pending';
                        $text  = $strCampaignStatusPending;
                        break;
                    case OA_ENTITY_STATUS_RUNNING:
                        $class = 'started';
                        $text  = $strCampaignStatusRunning;
                        break;
                    case OA_ENTITY_STATUS_PAUSED:
                        $class = 'paused';
                        $text  = $strCampaignStatusPaused;
                        break;
                    case OA_ENTITY_STATUS_AWAITING:
                        $class = 'awaiting';
                        $text  = $strCampaignStatusAwaiting;
                        break;
                    case OA_ENTITY_STATUS_EXPIRED:
                        $class = 'finished';
                        $text  = $strCampaignStatusExpired;
                        break;
                    case OA_ENTITY_STATUS_APPROVAL:
                        $class = 'accepted';
                        $text  = $strCampaignStatusApproval;
                        break;
                    case OA_ENTITY_STATUS_REJECTED:
                        $class = 'rejected';
                        $text  = $strCampaignStatusRejected;
                        break;
                }
                $oTrans = new OX_Translation();
                $text = $oTrans->translate($text);

                if ($status == OA_ENTITY_STATUS_APPROVAL) {
                    $text = "<a href='campaign-edit.php?clientid=".$aParams['clientid']."&campaignid=".$aParams['campaignid']."'>" .
                            $text . "</a>";
                }
                return '<span class="'.$class.'">' . $text . '</span>';
        }

        $smarty->trigger_error("showStatusText: missing 'status' parameter");
    }

    function _function_tabindex($aParams, &$smarty)
    {
        return ' tabindex="'.++$smarty->_tabIndex.'"';
    }

    function _function_oa_icon($aParams, &$smarty)
    {
        if (!empty($aParams['banner']) && is_array($aParams['banner'])) {
            $type   = 'banner';
            $banner = $aParams['banner'];

            $campaign_active = isset($aParams['campaign']['status']) ? $aParams['campaign']['status'] == OA_ENTITY_STATUS_RUNNING : true;
            $active          = $banner['status'] == OA_ENTITY_STATUS_RUNNING && $campaign_active;

            switch ($banner['type'])
            {
                case 'html': $flavour = '-html'; break;
                case 'txt':  $flavour = '-text'; break;
                case 'url':  $flavour = '-url'; break;
                default:     $flavour = '-stored'; break;
            }
        } elseif (!empty($aParams['campaign']) && is_array($aParams['campaign'])) {
            $type     = 'campaign';
            $campaign = $aParams['campaign'];

            $active = $campaign['status'] == OA_ENTITY_STATUS_RUNNING;
            $flavour = '';
        } elseif (!empty($aParams['advertiser']) && is_array($aParams['advertiser'])) {
            $type     = 'advertiser';
            $campaign = $aParams['advertiser'];

            $active = true;
            $flavour = '';
        }

        if (!empty($type)) {
            return OX::assetPath('images/icon-'.$type.$flavour.($active ? '' : '-d').'.gif');
        }

        $smarty->trigger_error("t: missing parameter(s)");
    }

    function _function_oa_title_sort($aParams, &$smarty)
    {
        if (!empty($aParams['str'])) {
            if (!empty($aParams['item'])) {
                $str  = $this->_function_t($aParams, $smarty);
                $item = $aParams['item'];

                $order = !empty($aParams['order']) ? $aParams['order'] : 'down';
                $url   = !empty($aParams['url'])     ? $aParams['url']     : '#';
                $url   .= strpos($url, '?') !== false ? '&' : '?';

                $buffer = '<a href="'.htmlspecialchars($url.'listorder='.$item).'">'.$str.'</a>';

                $listorder = $smarty->get_template_vars('listorder');
                $orderdirection = $smarty->get_template_vars('orderdirection');

                if (empty($listorder) && !empty($aParams['default']) && $aParams['default']) {
                    $listorder = $item;
                }

                if (empty($orderdirection)) {
                    $orderdirection = $order;
                }

                if ($listorder == $item) {
                    $order = $orderdirection == 'down' ? 'up' : 'down';
                    $caret = $orderdirection == 'down' ? 'ds'  : 'u';

                    $buffer .= ' <a href="'.htmlspecialchars($url.'orderdirection='.$order).'">';
                    $buffer .= '<img src="' . OX::assetPath() . '/images/caret-'.$caret.'.gif" border="0" alt="" title="">';
                    $buffer .= '</a>';
                }

                return $buffer;
            } else {
                $smarty->trigger_error("t: missing 'item' parameter");
            }
        } else {
            $smarty->trigger_error("t: missing 'str'parameter");
        }
    }


    function _function_ox_column_title($aParams, &$smarty)
    {
        if (!empty($aParams['str'])) {
            if (!empty($aParams['item'])) {
                $str  = $this->_function_t($aParams, $smarty);
                $item = $aParams['item'];

                $url  = !empty($aParams['url']) ? $aParams['url'] : '#';
                $url .= strpos($url, '?') !== false ? '&' : '?';
                $url .= 'listorder=' . $item;

                $listorder = $smarty->get_template_vars('listorder');
                if (empty($listorder) && !empty($aParams['default']) && $aParams['default']) {
                    $listorder = $item;
                }

                if ($listorder == $item) {
                    $orderdirection = $smarty->get_template_vars('orderdirection');
                    if (empty($orderdirection)) {
                        $orderdirection = !empty($aParams['order']) ? $aParams['order'] : 'down';
                    }

                    $url .= '&orderdirection=' . ($orderdirection == 'down' ? 'up' : 'down');
                }

                $buffer = '<a href="' . htmlspecialchars($url) . '">' . $str . '</a>';

                return $buffer;
            } else {
                $smarty->trigger_error("t: missing 'item' parameter");
            }
        } else {
            $smarty->trigger_error("t: missing 'str'parameter");
        }
    }

    function _function_ox_column_class($aParams, &$smarty)
    {
        if (!empty($aParams['item'])) {
            $item = $aParams['item'];

            $listorder = $smarty->get_template_vars('listorder');
            if (empty($listorder) && !empty($aParams['default']) && $aParams['default']) {
                $listorder = $item;
            }


            if ($listorder == $item) {
                $orderdirection = $smarty->get_template_vars('orderdirection');
                if (empty($orderdirection)) {
                    $orderdirection = !empty($aParams['order']) ? $aParams['order'] : 'down';
                }

                if ($orderdirection == 'down') {
                    return ' sortDown';
                }

                return ' sortUp';
            }

            return '';
        } else {
            $smarty->trigger_error("t: missing 'item' parameter");
        }
    }

    function _function_ox_banner_size($aParams, &$smarty)
    {
        global $phpAds_IAB;
        require_once MAX_PATH . '/www/admin/lib-size.inc.php';

        if (isset($aParams['width']) && isset($aParams['height'])) {
            $width = $aParams['width'];
            $height = $aParams['height'];

            if ($width == -1) $width = '*';
            if ($height == -1) $height = '*';

            return phpAds_getBannerSize($width, $height);
        } else {
            $smarty->trigger_error("t: missing 'width' or 'height' parameter");
        }
    }

    function _function_ox_banner_icon($aParams, &$smarty)
    {
        if (isset($aParams['type'])) {
            if (isset($aParams['active'])) {
                $active = $aParams['active'];
                $type = $aParams['type'];

                if ($active) {
                    switch($type) {
                        case 'html':    return 'iconBannerHtml';
                        case 'txt':     return 'iconBannerText';
                        case 'url':     return 'iconBannerExternal';
                        default:        return 'iconBanner';
                    }
                }

                switch($type) {
                    case 'html':    return 'iconBannerHtmlDisabled';
                    case 'txt':     return 'iconBannerTextDisabled';
                    case 'url':     return 'iconBannerExternalDisabled';
                    default:        return 'iconBannerDisabled';
                }
            } else {
                $smarty->trigger_error("t: missing 'active' parameter");
            }
        } else {
            $smarty->trigger_error("t: missing 'type' parameter");
        }
    }

    function _function_ox_zone_size($aParams, &$smarty)
    {
        global $phpAds_IAB;
        require_once MAX_PATH . '/www/admin/lib-size.inc.php';

        if (isset($aParams['width']) && isset($aParams['height'])) {
            if (isset($aParams['delivery'])) {
                $width = $aParams['width'];
                $height = $aParams['height'];
                $delivery = $aParams['delivery'];
                $translation = new OX_Translation ();

                if ($delivery == phpAds_ZoneText) {
                    return $translation->translate('Custom') . " (" . $translation->translate('TextAdZone') . ")";
                } else if ($delivery == OX_ZoneVideoInstream) {
                    return $translation->translate('Custom') . " (" . $translation->translate('ZoneVideoInstream') . ")";
                } else if ($delivery == OX_ZoneVideoOverlay) {
                    return $translation->translate('Custom') . " (" . $translation->translate('ZoneVideoOverlay') . ")";
                } else {
                    if ($width == -1) $width = '*';
                    if ($height == -1) $height = '*';

                    return phpAds_getBannerSize($width, $height);
                }
            } else {
                $smarty->trigger_error("t: missing 'delivery' parameter");
            }
        } else {
            $smarty->trigger_error("t: missing 'width' or 'height' parameter");
        }
    }

    function _function_ox_zone_icon($aParams, &$smarty)
    {
        if (isset($aParams['delivery'])) {
            if (isset($aParams['active'])) {
                $active = $aParams['active'];
                $delivery = $aParams['delivery'];

                if (isset($aParams['warning']) && $aParams['warning']) {
                    return 'iconZoneWarning';
                }

                if ($active) {
                    switch($delivery) {
                        case phpAds_ZoneInterstitial:   return 'iconZoneFloating';
                        case phpAds_ZoneText:           return 'iconZoneText';
                        case MAX_ZoneEmail:             return 'iconZoneEmail';
                        case OX_ZoneVideoInstream:      return 'iconZoneVideoInstream';
                        case OX_ZoneVideoOverlay:       return 'iconZoneVideoOverlay';
                        default:                        return 'iconZone';
                    }
                }

                switch($delivery) {
                    case phpAds_ZoneInterstitial:   return 'iconZoneFloatingDisabled';
                    case phpAds_ZoneText:           return 'iconZoneTextDisabled';
                    case MAX_ZoneEmail:             return 'iconZoneEmailDisabled';
                    case OX_ZoneVideoInstream:      return 'iconZoneVideoInstreamDisabled';
                    case OX_ZoneVideoOverlay:       return 'iconZoneVideoOverlayDisabled';
                    default:                        return 'iconZoneDisabled';
                }
            } else {
                $smarty->trigger_error("t: missing 'active' parameter");
            }
        } else {
            $smarty->trigger_error("t: missing 'delivery' parameter");
        }
    }

		function _function_ox_campaign_type($aParams, &$smarty)
		{
			if (isset($aParams['type'])) {
				$type = $aParams['type'];
				$translation = new OX_Translation ();

                if ($type == OX_CAMPAIGN_TYPE_OVERRIDE) {
					return "<span class='campaign-type campaign-override'>" . $translation->translate('Override') . "</span>";
                } elseif ($type == OX_CAMPAIGN_TYPE_CONTRACT_NORMAL) {
					return "<span class='campaign-type campaign-contract'>" . $translation->translate('Contract') . "</span>";
				} elseif ($type == OX_CAMPAIGN_TYPE_REMNANT || $type == OX_CAMPAIGN_TYPE_ECPM){
					return "<span class='campaign-type campaign-remnant'>" . $translation->translate('Remnant') . "</span>";
                }
                return "<span class='campaign-type campaign-contract'>".$type. "</span>";
			} else {
				$smarty->trigger_error("t: missing 'type' parameter");
			}
		}

    function _function_ox_campaign_status($aParams, &$smarty)
    {
        if (isset($aParams['status'])) {
            $status = $aParams['status'];
            $translation = new OX_Translation ();

            switch ($status) {
                case OA_ENTITY_STATUS_PENDING:
                    $class = 'sts-pending';
                    $text  = $translation->translate('CampaignStatusPending');
                    break;
                case OA_ENTITY_STATUS_RUNNING:
                    $class = 'sts-accepted';
                    $text  = $translation->translate('CampaignStatusRunning');
                    break;
                case OA_ENTITY_STATUS_PAUSED:
                    $class = 'sts-paused';
                    $text  = $translation->translate('CampaignStatusPaused');
                    break;
                case OA_ENTITY_STATUS_AWAITING:
                    $class = 'sts-not-started';
                    $text  = $translation->translate('CampaignStatusAwaiting');
                    break;
                case OA_ENTITY_STATUS_EXPIRED:
                    $class = 'sts-finished';
                    $text  = $translation->translate('CampaignStatusExpired');
                    break;
                case OA_ENTITY_STATUS_INACTIVE:
                    $class = 'sts-inactive';
                    $text  = $translation->translate('CampaignStatusInactive');
                    break;
                case OA_ENTITY_STATUS_APPROVAL:
                    $class = 'sts-awaiting';
                    $text  = $translation->translate('CampaignStatusApproval');
                    break;
                case OA_ENTITY_STATUS_REJECTED:
                    $class = 'sts-rejected';
                    $text  = $translation->translate('CampaignStatusRejected');
                    break;
            }
            $oTrans = new OX_Translation();
            $text = $oTrans->translate($text);

            if ($status == OA_ENTITY_STATUS_APPROVAL) {
                $text = "<a href='campaign-edit.php?clientid=".$aParams['clientid']."&campaignid=".$aParams['campaignid']."'>" . $text . "</a>";
            }

            return "<span class='" . $class . "'>" . $text . "</span>";
        }

        $smarty->trigger_error("showStatusText: missing 'status' parameter");
    }

    function _function_ox_campaign_icon($aParams, &$smarty)
    {
        if (isset($aParams['status'])) {
            if ($aParams['status'] == OA_ENTITY_STATUS_RUNNING) {
                return 'iconCampaign';
            }

            return 'iconCampaignDisabled';
        } else {
            $smarty->trigger_error("t: missing 'status' parameter");
        }
    }

    function _function_ox_tracker_type($aParams, &$smarty)
    {
        if (isset($aParams['type'])) {
            $type = $aParams['type'];
			$type = $GLOBALS['_MAX']['CONN_TYPES'][$type];

			// Warning: $type contains the id of translation string... remove 'str' to be able to pass it on to OX_Translation
			$type = substr($type, 3);

            $translation = new OX_Translation ();
			return $translation->translate($type);
        } else {
            $smarty->trigger_error("t: missing 'type' parameter");
        }
    }

    /**
     * Smarty function to bold searched phrase in tekst
     * use: {boldSearchPhrase text="some text" search="search phrase"}
     *
     * @param array $aParams - $aParams['text'] - text to modify, $aParams['search'] - search phrase to bold
     * @param object &$smarty
     * @return string
     */
    function _function_boldSearchPhrase($aParams, &$smarty)
    {
        if (!empty($aParams['text'])) {
            if (!empty($aParams['search'])) {
                $searchPhrase = $aParams['search'];
                $text = $aParams['text'];
                $strPos = stripos($text,$searchPhrase);
                if ($strPos !== false ) {
                    $strLen = strlen($searchPhrase);
                    return  htmlspecialchars(substr($text, 0, $strPos)) .
                            "<b class='sr'>" . htmlspecialchars(substr($text, $strPos, $strLen)) . "</b>" .
                            htmlspecialchars(substr($text, $strPos+$strLen));
                    }
            }
            return htmlspecialchars($aParams['text']);
        }
    }

    function _block_edit($aParams, $content, &$smarty, &$repeat)
    {
        static $break = false;

        if (!$repeat) {
            $aParams['content'] = $content;
            if (isset($aParams['params']) && is_array($aParams)) {
                $aParams += $aParams['params'];
            }
            if (!isset($aParams['break'])) {
                $aParams['break'] = $break;
            }

            $smarty->assign('_e', $aParams);
            $result = $smarty->fetch('edit-table/main.html');
            $smarty->clear_assign('_e');

            $break = $aParams['type'] != 'section';

            return $result;
        }
    }


   function _block_form_element($aParams, $content, &$smarty, &$repeat)
    {
        static $break = false;

        if ($repeat && $aParams['elem']['type'] == 'header') {
            $break = false; //do not display breaks for first element in section
        }
        if (!$repeat) {
            $aParams['content'] = $content;
            if (isset($aParams['elem']) && is_array($aParams)) {
                $aParams += $aParams['elem'];
            }
            if (!isset($aParams['break'])) {
                $aParams['break'] = $break;
            }

            //if macro invoked with parent parameter do not add break
            if(isset($aParams['parent'])) {
                $aParams['break'] = false;
            }

            //put some context for form elements (set parent)
            if (is_array($smarty->_tag_stack) && count($smarty->_tag_stack) > 0) {
                if (isset($smarty->_tag_stack[0][1]['elem']['type'])) {
                    $aParams['parent_tag'] = $smarty->_tag_stack[0][1]['elem']['type'];
                }
            }

            //store old _e if recursion happens
            $old_e = $smarty->get_template_vars('_e');
            $smarty->assign('_e', $aParams);
            $result = $smarty->fetch(MAX_PATH . '/lib/templates/admin/form/elements.html');
            $smarty->clear_assign('_e');

            //restore old _e (if any)
            if (isset($old_e)) {
                $smarty->assign('_e', $old_e);
            }

            //decorate result with decorators content
            if (!empty($aParams['decorators']['list'])) {
                foreach ($aParams['decorators']['list'] as $decorator) {
                    $result = $decorator->render($result);
                }
            }

            $break = ($aParams['type'] != 'header');

            return $result;
        }
    }


    function _function_form_input_attributes($aParams, $smarty)
    {
        $elem = $aParams['elem'];
        $parent = $aParams['parent'];
        $attributes = &$elem['attributes'];

        //default id to name if not set
        if (empty($attributes['id'])) {
            $attributes['id'] = $attributes['name'];
        }

        //if frozen disable //TODO append 'frozen' class here or to form??
        if ($elem['frozen'] == true) {
            $attributes['disabled'] = 'disabled';
            $attributes['class'] .= ' frozen';
        }

        //set default type to text if not given
        if (empty($elem['type'])) {
            $elem['type'] = 'text';
        }

        //default class to 'large' for different inputs (apart from submits, buttons, selects, checkboxes)
        if ($elem['type'] == 'text' || $elem['type'] == 'password') {
            if (empty($attributes['class'])) {
                 if (!empty($parent)) {  //if parent is set it means it is in group
                    $attributes['class'] = 'x-small'; //mulitelement lines needs smaller elements
                 }
                 else {
                     $attributes['class'] = 'large'; //first level elems get big
                 }
            }
        }

        if ($elem['type'] == 'select') {
            if (empty($attributes['class'])) {
                 if (!empty($parent)) {  //if parent is set it means it is in group
                    $attributes['class'] = 'small'; //mulitelement lines needs smaller elements
                 }
                 else {
                     $attributes['class'] = 'medium'; //first level elems get big
                 }
            }
        }

        //custom textarea styles
        if ($elem['type'] == 'textarea') {
            if (!$this->_hasSizeClass($attributes['class'])) {
                $attributes['class'] = 'large';
            }

            $attributes['class'].=" small-h"; //set height
            $attributes['wrap']="off";
            $attributes['dir']="ltr";
        }

        $attrString = "";
        foreach ($attributes as $attribute => $value) {
            $attrString .= "$attribute=\"".smarty_modifier_escape($value)."\" ";
        }

        return $attrString;
    }

    function _hasSizeClass($className)
    {
        if (empty($className)) {
            return false;
        }
        //this is simplified - we should check for spaces and line start/end
        //but is it worth the performance penalty?
        $result = preg_match('/x-large|large|medium|small|x-small/', $className) == 0
            ? false : true;

        return $result;
    }


    function _function_ox_entity_id($aParams, &$smarty) {
        if ($GLOBALS['_MAX']['PREF']['ui_show_entity_id'] == true) {
            $id = $aParams['id'];
            return '<small title="' .
                $this->_function_t(array('str' => $aParams['type']), $smarty) . ' ' .
                $this->_function_t(array('str' => 'ID'), $smarty) . ': ' . $id . '">[' . $id . ']</small>';
        } else {
            return '';
        }
    }

    function _function_oa_is_admin($aParams, $smarty) {
        return OA_Permission::isAccount(OA_ACCOUNT_ADMIN);
    }

    function _function_oa_is_manager($aParams, $smarty) {
        return OA_Permission::isAccount(OA_ACCOUNT_MANAGER);
    }

    function _function_oa_is_advertiser($aParams, $smarty) {
        return OA_Permission::isAccount(OA_ACCOUNT_ADVERTISER);
    }

    function _function_oa_is_trafficker($aParams, $smarty) {
        return OA_Permission::isAccount(OA_ACCOUNT_TRAFFICKER);
    }

    // OLD FUNCTIONS

    function _function_phpAds_DelConfirm($aParams, &$smarty)
    {
        return phpAds_DelConfirm($this->_function_t($aParams, $smarty));
    }

    function _function_MAX_zoneDelConfirm($aParams, &$smarty)
    {
        return MAX_zoneDelConfirm($aParams['zoneid']);
    }

    function _function_phpAds_ShowBreak()
    {
        ob_start();
        phpAds_ShowBreak();
        return ob_get_clean();
    }
}

?>
