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

define('SMARTY_DIR', MAX_PATH . '/lib/smarty/');

require_once MAX_PATH . '/lib/smarty/Smarty.class.php';
require_once MAX_PATH . '/lib/OA/Dll.php';
require_once MAX_PATH . '/lib/pear/Date.php';
require_once MAX_PATH . '/lib/OA/Translation.php';

/**
 * A UI templating class.
 *
 * @package    OpenXAdmin
 * @author     Matteo Beccati <matteo.beccati@openx.org>
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

    function OA_Admin_Template($templateName)
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
        
        $this->register_function('boldSearchPhrase', array('OA_Admin_Template', '_function_boldSearchPhrase'));

        $this->register_function('oa_is_admin', array('OA_Admin_Template',  '_function_oa_is_admin'));
        $this->register_function('oa_is_manager', array('OA_Admin_Template',  '_function_oa_is_manager'));
        $this->register_function('oa_is_advertiser', array('OA_Admin_Template',  '_function_oa_is_advertiser'));
        $this->register_function('oa_is_trafficker', array('OA_Admin_Template',  '_function_oa_is_trafficker'));


        $this->register_function('oac_captcha', array('OA_Admin_Template',  '_function_oac_captcha'));

        $this->register_function('phpAds_ShowBreak', array('OA_Admin_Template',  '_function_phpAds_ShowBreak'));
        $this->register_function('phpAds_DelConfirm', array('OA_Admin_Template',  '_function_phpAds_DelConfirm'));

        $this->register_function('showStatusText', array('OA_Admin_Template',  '_function_showStatusText'));

        $this->register_function('oa_form_input_attributes', array('OA_Admin_Template',  '_function_form_input_attributes'));
        $this->register_block('oa_edit', array('OA_Admin_Template',  '_block_edit'));
        $this->register_block('oa_form_element', array('OA_Admin_Template',  '_block_form_element'));

        $this->templateName = $templateName;

        $this->assign('phpAds_TextDirection',  $GLOBALS['phpAds_TextDirection']);
        $this->assign('phpAds_TextAlignLeft',  $GLOBALS['phpAds_TextAlignLeft']);
        $this->assign('phpAds_TextAlignRight', $GLOBALS['phpAds_TextAlignRight']);
        $this->assign('assetPath', MAX::assetPath());
        $this->assign("adminWebPath", MAX::constructURL(MAX_URL_ADMIN, ''));
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

    function is_cached()
    {
        return parent::is_cached($this->templateName, $this->cacheId);
    }

    function display()
    {
        parent::display($this->templateName, $this->cacheId);
    }

    function _function_t($aParams, &$smarty)
    {
        $oTrans = new OA_Translation();

        if (!empty($aParams['str'])) {
			if (!empty($aParams['values'])) {
                $aValues = explode('|', $aParams['values']);
            } else {
                $aValues = array();
            }
            return $oTrans->translate($aParams['str'], $aValues);
        } else 
        if (!empty($aParams['key'])) {
            return $oTrans->translate($aParams['key']);
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

    function _function_showStatusText($aParams, &$smarty)
    {
        global $strCampaignStatusRunning, $strCampaignStatusPaused, $strCampaignStatusAwaiting,
               $strCampaignStatusExpired, $strCampaignStatusApproval, $strCampaignStatusRejected;

        $status = $aParams['status'];
        $an_status = $aParams['an_status'];

        if (isset($status)) {
                switch ($status) {
                	case OA_ENTITY_STATUS_PENDING:
                	    if ($an_status == OA_ENTITY_ADNETWORKS_STATUS_APPROVAL) {
                    	    $class = 'awaiting';
                    	    $text  = $strCampaignStatusApproval;
                	    }

                	    if ($an_status == OA_ENTITY_ADNETWORKS_STATUS_REJECTED) {
                    	    $class = 'rejected';
                    	    $text  = $strCampaignStatusRejected;
                	    }
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
                $oTrans = new OA_Translation();
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
            return MAX::assetPath('images/icon-'.$type.$flavour.($active ? '' : '-d').'.gif');
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
                    $buffer .= '<img src="' . MAX::assetPath() . '/images/caret-'.$caret.'.gif" border="0" alt="" title="">';
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
                    return  substr($text, 0, $strPos) . 
                            "<b class='sr'>" . substr($text, $strPos, $strLen) . "</b>" . 
                            substr($text, $strPos+$strLen);
                    }
            }
            return $aParams['text'];
        }
    }

    function _function_oac_captcha()
    {
        require_once MAX_PATH . '/lib/OA/Central/Common.php';

        return OA_Central_Common::getCaptchaUrl();
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
            if (empty($attributes['class'])) {
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

    function _function_phpAds_ShowBreak()
    {
        ob_start();
        phpAds_ShowBreak();
        return ob_get_clean();
    }
}

?>
