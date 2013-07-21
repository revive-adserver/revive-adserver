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

/**
 * Plugins_InvocationTagsOptions contains all standard options.
 *
 * @package    OpenXPlugin
 * @subpackage InvocationTags
 * @author     Radek Maciaszek <radek@m3.net>
 */
class Plugins_InvocationTagsOptions
{
    var $maxInvocation;

    var $defaultValues = array();
    function Plugins_InvocationTagsOptions()
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        $this->defaultValues = array(
            'target'            => '',
            'source'            => '',
            'withtext'          => 0,
            'refresh'           => '',
            'transparent'       => 0,
            'ilayer'            => 0,
            'iframetracking'    => 0,
            'block'             => 0,
            'blockcampaign'     => 0,
            'raw'               => 0,
            'popunder'          => 1,
            'delay'             => '-',
            'absolute'          => array('top' => '-', 'left' => '-'),
            'timeout'           => '-',
            'windowoptions'     => array('toolbars' => 0, 'location' => 0, 'menubar' => 0, 'status' => 0, 'resizable' => 0, 'scrollbars' => 0),
            'xmlrpcproto'       => 0,
            'xmlrpctimeout'     => '',
            'hostlanguage'      => '',
            'thirdPartyServer'  => $conf['delivery']['clicktracking'],
            'cachebuster'       => 1,
            'comments'          => 1,
            'charset'           => '',
        );
    }
    
    /**
     * Return name of plugin
     *
     * @return string    A string describing the class.
     */
    function setInvocation(&$invocation) {
        $this->maxInvocation = &$invocation;
    }


    /**
     * Generate the HTML option
     *
     * @return string    A string containing html for option
     */
    function spacer()
    {
        $mi = &$this->maxInvocation;

        $option = "<tr".($mi->zone_invocation ? '' : " bgcolor='#F6F6F6'")."><td height='10' colspan='3'>&nbsp;</td></tr>";
        return $option;
    }

    /**
     * Generate the HTML option
     *
     * @return string    A string containing html for option
     */
    function what()
    {
        $maxInvocation = &$this->maxInvocation;

        $option = '';
        if (!$maxInvocation->zone_invocation && $maxInvocation->codetype != 'adviewnocookies') {
            $option .= "<tr bgcolor='#F6F6F6'><td width='30'>&nbsp;</td>";
            $option .= "<td width='200' valign='top'>".$GLOBALS['strInvocationWhat']."</td><td width='370'>";
            $option .= "<textarea class='flat' name='what' rows='3' cols='50' style='width:350px;' tabindex='".($maxInvocation->tabindex++)."'>".(isset($maxInvocation->what) ? htmlspecialchars(stripslashes($maxInvocation->what),ENT_QUOTES) : '')."</textarea></td></tr>";

            if (OA_Permission::isAccount(OA_ACCOUNT_ADMIN)) {
                $option .= "<tr bgcolor='#F6F6F6'><td height='10' colspan='3'>&nbsp;</td></tr>";
                $option .= "<tr height='1'><td colspan='3' bgcolor='#888888'><img src='" . OX::assetPath(). "/images/break.gif' height='1' width='100%'></td></tr>";
                $option .= "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";
            }
        }

        return $option;
    }

    /**
     * Generate the HTML option
     *
     * @return string    A string containing html for option
     */
    function campaignid()
    {
        $conf = $GLOBALS['_MAX']['CONF'];

        $mi = &$this->maxInvocation;
        if ($mi->zone_invocation || OA_Permission::isAccount(OA_ACCOUNT_ADMIN)) {
            return null;
        }

        $option = '';
        // Display available campaigns...
        $option .= "<tr bgcolor='#F6F6F6'><td width='30'>&nbsp;</td>\n";
        $option .= "<td width='200'>".$GLOBALS['strInvocationCampaignID']."</td><td width='370'>\n";
        $option .= "<select name='campaignid' style='width:350px;' tabindex='".($mi->tabindex++)."'>\n";
        $option .= "<option value='0'>-</option>\n";
        if (OA_Permission::isAccount(OA_ACCOUNT_ADMIN)) {
            $query = "SELECT campaignid,campaignname".
                " FROM ".$conf['table']['prefix'].$conf['table']['campaigns'];
        } elseif (OA_Permission::isAccount(OA_ACCOUNT_MANAGER)) {
            $query = "SELECT m.campaignid AS campaignid".
                ",m.campaignname AS campaignname".
                " FROM ".$conf['table']['prefix'].$conf['table']['campaigns']." AS m".
                ",".$conf['table']['prefix'].$conf['table']['clients']." AS c".
                " WHERE m.clientid=c.clientid".
                " AND c.agencyid=".OA_Permission::getAgencyId();
        }
        $oDbh = OA_DB::singleton();
        $aResult = $oDbh->queryAll($query);
        if (PEAR::isError($aResult))
        {
            $option .= "<option value='0'>'.$aResult->getUserInfo().'</option>\n";
        }
        else
        {
            foreach ($aResult AS $k => $row)
            {
                $option .= "<option value='".$row['campaignid']."'".($mi->campaignid == $row['campaignid'] ? ' selected' : '').">";
                $option .= phpAds_buildName ($row['campaignid'], $row['campaignname']);
                $option .= "</option>\n";
            }
        }
        $option .= "</select>\n";
        $option .= "</td></tr>";
        $option .= "<tr bgcolor='#F6F6F6'><td height='10' colspan='3'>&nbsp;</td></tr>";
        $option .= "<tr height='1'><td colspan='3' bgcolor='#888888'><img src='" . OX::assetPath(). "/images/break.gif' height='1' width='100%'></td></tr>";
        $option .= "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";
        return $option;
    }

    /**
     * Generate the HTML option
     *
     * @return string    A string containing html for option
     */
    function bannerid()
    {
        global $codetype;
        $maxInvocation = &$this->maxInvocation;

        $option = '';
        $option .= "<tr><td width='30'>&nbsp;</td>";
        $option .= "<td width='200'>".$GLOBALS['strInvocationBannerID']."</td><td width='370'>";
        if ($codetype == 'adviewnocookies') {
            $option .= "<input onBlur='max_formValidateElement(this);' class='flat' type='text' name='bannerid' value='".(isset($maxInvocation->bannerid) ? $maxInvocation->bannerid : '')."' style='width: 175px;' tabindex='".($maxInvocation->tabindex++)."'></td></tr>";
        } else {
            $option .= "<input class='flat' type='text' name='bannerid' size='' value='".(isset($maxInvocation->bannerid) ? $maxInvocation->bannerid : '')."' style='width:175px;' tabindex='".($maxInvocation->tabindex++)."'></td></tr>";
        }
        $option .= "<tr><td width='30'><img src='" . OX::assetPath(). "/images/spacer.gif' height='5' width='100%'></td></tr>";
        return $option;
    }

    /**
     * Generate the HTML option
     *
     * @return string    A string containing html for option
     */
    function target()
    {
        $maxInvocation = &$this->maxInvocation;

        $target = (!empty($maxInvocation->target)) ? $maxInvocation->target : $this->defaultValues['target'];
        $option = '';
        $option .= "<tr><td width='30'>&nbsp;</td>
            <td width='200'>".$GLOBALS['strInvocationTarget']."</td><td width='370'>
            <select name='target' tabindex='".($maxInvocation->tabindex++)."'>
                <option value=''>Default</option>
                <option value='_blank'" . ($target == '_blank' ? " selected='selected'" : '') . ">New window</option>
                <option value='_top'" . ($target == '_top' ? " selected='selected'" : '') . ">Same window</option>
            </select>
            <tr><td width='30'><img src='" . OX::assetPath(). "/images/spacer.gif' height='5' width='100%'></td></tr>";

        return $option;
    }

    /**
     * Generate the HTML option
     *
     * @return string    A string containing html for option
     */
    function source()
    {
        $maxInvocation = &$this->maxInvocation;

        $option = '';
        $option .= "<tr><td width='30'>&nbsp;</td>";
        $option .= "<td width='200'>".$GLOBALS['strInvocationSource']."</td><td width='370'>";
        $option .= "<input class='flat' type='text' name='source' size='' value='".(isset($maxInvocation->source) ? htmlspecialchars(stripslashes($maxInvocation->source),ENT_QUOTES) : $this->defaultValues['source'])."' style='width:175px;' tabindex='".($maxInvocation->tabindex++)."'></td></tr>";
        $option .= "<tr><td width='30'><img src='" . OX::assetPath(). "/images/spacer.gif' height='5' width='100%'></td></tr>";
        return $option;
    }

    /**
     * Generate the HTML option
     *
     * @return string    A string containing html for option
     */
    function withtext()
    {
        $maxInvocation = &$this->maxInvocation;

        $option = '';
        $option .= "<tr><td width='30'>&nbsp;</td>";
        $option .= "<td width='200'>".$GLOBALS['strInvocationWithText']."</td>";
        $option .= "<td width='370'><input type='radio' name='withtext' value='1'".(isset($maxInvocation->withtext) && $maxInvocation->withtext != 0 ? ' checked' : '')." tabindex='".($maxInvocation->tabindex++)."'>&nbsp;".$GLOBALS['strYes']."<br />";
        $option .= "<input type='radio' name='withtext' value='0'".(!isset($maxInvocation->withtext) || $maxInvocation->withtext == 0 ? ' checked' : '')." tabindex='".($maxInvocation->tabindex++)."'>&nbsp;".$GLOBALS['strNo']."</td>";
        $option .= "</tr>";
        $option .= "<tr><td width='30'><img src='" . OX::assetPath(). "/images/spacer.gif' height='5' width='100%'></td></tr>";
        return $option;
    }

    /**
     * Generate the HTML option
     *
     * @return string    A string containing html for option
     */
    function refresh()
    {
        $maxInvocation = &$this->maxInvocation;

        $option = '';
        $option .= "<tr><td width='30'>&nbsp;</td>";
        $option .= "<td width='200'>".$GLOBALS['strIFrameRefreshAfter']."</td><td width='370'>";
        $option .= "<input class='flat' type='text' name='refresh' size='' value='".(isset($maxInvocation->refresh) ? $maxInvocation->refresh : $this->defaultValues['refresh'])."' style='width:175px;' tabindex='".($maxInvocation->tabindex++)."'> ".$GLOBALS['strAbbrSeconds']."</td></tr>";
        $option .= "<tr><td width='30'><img src='" . OX::assetPath(). "/images/spacer.gif' height='5' width='100%'></td></tr>";
        return $option;
    }

    /**
     * Generate the HTML option
     *
     * @return string    A string containing html for option
     */
    function size()
    {
        $maxInvocation = &$this->maxInvocation;

        $option = '';
        if (!$maxInvocation->zone_invocation || ($maxInvocation->width == -1 || $maxInvocation->height == -1)) {
            $option .= "<tr><td width='30'>&nbsp;</td>";
            $option .= "<td width='200'>".$GLOBALS['strFrameSize']."</td><td width='370'>";
            $option .= $GLOBALS['strWidth'].": <input class='flat' type='text' name='frame_width' size='3' value='".((isset($maxInvocation->frame_width) && $maxInvocation->frame_width > 0) ? $maxInvocation->frame_width : '')."' tabindex='".($maxInvocation->tabindex++)."'>&nbsp;&nbsp;&nbsp;";
            $option .= $GLOBALS['strHeight'].": <input class='flat' type='text' name='frame_height' size='3' value='".((isset($maxInvocation->frame_height) &&  $maxInvocation->frame_height > 0) ? $maxInvocation->frame_height : '')."' tabindex='".($maxInvocation->tabindex++)."'>";
            $option .= "</td></tr>";
            $option .= "<tr><td width='30'><img src='" . OX::assetPath(). "/images/spacer.gif' height='5' width='100%'></td></tr>";
        }
        return $option;
    }

    /**
     * Generate the HTML option
     *
     * @return string    A string containing html for option
     */
    function resize()
    {
        $maxInvocation = &$this->maxInvocation;

        $option = '';
        if ($maxInvocation->server_same) {
            $option .= "<tr><td width='30'>&nbsp;</td>";
            $option .= "<td width='200'>".$GLOBALS['strIframeResizeToBanner']."</td>";
            $option .= "<td width='370'><input type='radio' name='resize' value='1'".(isset($maxInvocation->resize) && $maxInvocation->resize == 1 ? ' checked' : '')." tabindex='".($maxInvocation->tabindex++)."'>&nbsp;".$GLOBALS['strYes']."<br />";
            $option .= "<input type='radio' name='resize' value='0'".(!isset($maxInvocation->resize) || $maxInvocation->resize == 0 ? ' checked' : '')." tabindex='".($maxInvocation->tabindex++)."'>&nbsp;".$GLOBALS['strNo']."</td>";
            $option .= "</tr>";
            $option .= "<tr><td width='30'><img src='" . OX::assetPath(). "/images/spacer.gif' height='5' width='100%'></td></tr>";
        } else {
            $option .= "<input type='hidden' name='resize' value='0'>";
        }
        return $option;
    }

    /**
     * Generate the HTML option
     *
     * @return string    A string containing html for option
     */
    function transparent()
    {
        $maxInvocation = &$this->maxInvocation;

        $option = '';
        $option .= "<tr><td width='30'>&nbsp;</td>";
        $option .= "<td width='200'>".$GLOBALS['strIframeMakeTransparent']."</td>";
        $option .= "<td width='370'><input type='radio' name='transparent' value='1'".(isset($maxInvocation->transparent) && $maxInvocation->transparent == 1 ? ' checked' : '')." tabindex='".($maxInvocation->tabindex++)."'>&nbsp;".$GLOBALS['strYes']."<br />";
        $option .= "<input type='radio' name='transparent' value='0'".(!isset($maxInvocation->transparent) || $maxInvocation->transparent == 0 ? ' checked' : '')." tabindex='".($maxInvocation->tabindex++)."'>&nbsp;".$GLOBALS['strNo']."</td>";
        $option .= "</tr>";
        $option .= "<tr><td width='30'><img src='" . OX::assetPath(). "/images/spacer.gif' height='5' width='100%'></td></tr>";
        return $option;
    }

    /**
     * Generate the HTML option
     *
     * @return string    A string containing html for option
     */
    function ilayer()
    {
        $maxInvocation = &$this->maxInvocation;

        $option = '';
        $option .= "<tr><td width='30'>&nbsp;</td>";
        $option .= "<td width='200'>".$GLOBALS['strIframeIncludeNetscape4']."</td>";
        $option .= "<td width='370'><input type='radio' name='ilayer' value='1'".(isset($maxInvocation->ilayer) && $maxInvocation->ilayer == 1 ? ' checked' : '')." tabindex='".($maxInvocation->tabindex++)."'>&nbsp;".$GLOBALS['strYes']."<br />";
        $option .= "<input type='radio' name='ilayer' value='0'".(!isset($maxInvocation->ilayer) || $maxInvocation->ilayer == 0 ? ' checked' : '')." tabindex='".($maxInvocation->tabindex++)."'>&nbsp;".$GLOBALS['strNo']."</td>";
        $option .= "</tr>";
        $option .= "<tr><td width='30'><img src='" . OX::assetPath(). "/images/spacer.gif' height='5' width='100%'></td></tr>";
        return $option;
    }

    /**
     * Generate the HTML option
     *
     * @return string    A string containing html for option
     */
    function iframetracking()
    {
        $maxInvocation = &$this->maxInvocation;

        $option = '';
        $option .= "<tr><td width='30'>&nbsp;</td>";
        $option .= "<td width='200'>". $GLOBALS['strIframeGoogleClickTracking'] ."</td>";
        $option .= "<td width='370'><input type='radio' name='iframetracking' value='1'".(!isset($maxInvocation->iframetracking) || $maxInvocation->iframetracking == 1 ? ' checked' : '')." tabindex='".($maxInvocation->tabindex++)."'>&nbsp;".$GLOBALS['strYes']."<br />";
        $option .= "<input type='radio' name='iframetracking' value='0'".(isset($maxInvocation->iframetracking) && $maxInvocation->iframetracking == 0 ? ' checked' : '')." tabindex='".($maxInvocation->tabindex++)."'>&nbsp;".$GLOBALS['strNo']."</td>";
        $option .= "</tr>";
        $option .= "<tr><td width='30'><img src='" . OX::assetPath(). "/images/spacer.gif' height='5' width='100%'></td></tr>";
        return $option;
    }

    /**
     * Generate the HTML option
     *
     * @return string    A string containing html for option
     */
    function block()
    {
        $maxInvocation = &$this->maxInvocation;

        $option = '';
        $option .= "<tr><td width='30'>&nbsp;</td>";
        $option .= "<td width='200'>".$GLOBALS['strInvocationDontShowAgain']."</td>";
        $option .= "<td width='370'><input type='radio' name='block' value='1'".(isset($maxInvocation->block) && $maxInvocation->block != 0 ? ' checked' : '')." tabindex='".($maxInvocation->tabindex++)."'>&nbsp;".$GLOBALS['strYes']."<br />";
        $option .= "<input type='radio' name='block' value='0'".(!isset($maxInvocation->block) || $maxInvocation->block == 0 ? ' checked' : '')." tabindex='".($maxInvocation->tabindex++)."'>&nbsp;".$GLOBALS['strNo']."</td>";
        $option .= "</tr>";
        $option .= "<tr><td width='30'><img src='" . OX::assetPath(). "/images/spacer.gif' height='5' width='100%'></td></tr>";
        return $option;
    }

    /**
     * Generate the HTML option
     *
     * @return string    A string containing html for option
     */
    function blockcampaign()
    {
        $maxInvocation = &$this->maxInvocation;

        $option = '';
        $option .= "<tr><td width='30'>&nbsp;</td>";
        $option .= "<td width='200'>".$GLOBALS['strInvocationDontShowAgainCampaign']."</td>";
        $option .= "<td width='370'><input type='radio' name='blockcampaign' value='1'".(isset($maxInvocation->blockcampaign) && $maxInvocation->blockcampaign != 0 ? ' checked' : '')." tabindex='".($maxInvocation->tabindex++)."'>&nbsp;".$GLOBALS['strYes']."<br />";
        $option .= "<input type='radio' name='blockcampaign' value='0'".(!isset($maxInvocation->blockcampaign) || $maxInvocation->blockcampaign == 0 ? ' checked' : '')." tabindex='".($maxInvocation->tabindex++)."'>&nbsp;".$GLOBALS['strNo']."</td>";
        $option .= "</tr>";
        $option .= "<tr><td width='30'><img src='" . OX::assetPath(). "/images/spacer.gif' height='5' width='100%'></td></tr>";
        return $option;
    }

    /**
     * Generate the HTML option
     *
     * @return string    A string containing html for option
     */
    function raw()
    {
        $maxInvocation = &$this->maxInvocation;

        $option = '';
        $option .= "<tr><td width='30'>&nbsp;</td>";
        $option .= "<td width='200'>".$GLOBALS['strInvocationTemplate']."</td>";
        $option .= "<td width='370'><input type='radio' name='raw' value='1'".(isset($maxInvocation->raw) && $maxInvocation->raw != 0 ? ' checked' : '')." tabindex='".($maxInvocation->tabindex++)."'>&nbsp;".$GLOBALS['strYes']."<br />";
        $option .= "<input type='radio' name='raw' value='0'".(!isset($maxInvocation->raw) || $maxInvocation->raw == 0 ? ' checked' : '')." tabindex='".($maxInvocation->tabindex++)."'>&nbsp;".$GLOBALS['strNo']."</td>";
        $option .= "</tr>";
        $option .= "<tr><td width='30'><img src='" . OX::assetPath(). "/images/spacer.gif' height='5' width='100%'></td></tr>";
        return $option;
    }

    /**
     * Generate the HTML option
     *
     * @return string    A string containing html for option
     */
    function popunder()
    {
        $maxInvocation = &$this->maxInvocation;

        $option = '';
        $option .= "<tr><td width='30'>&nbsp;</td>";
        $option .= "<td width='200'>".$GLOBALS['strPopUpStyle']."</td>";
        $option .= "<td width='370'><input type='radio' name='popunder' value='0'".
             (!isset($maxInvocation->popunder) || $maxInvocation->popunder != '1' ? ' checked' : '')." tabindex='".($maxInvocation->tabindex++)."'>&nbsp;".
             "<img src='" . OX::assetPath(). "/images/icon-popup-over.gif' align='absmiddle'>&nbsp;".$GLOBALS['strPopUpStylePopUp']."<br />";
        $option .= "<input type='radio' name='popunder' value='1'".
             (isset($maxInvocation->popunder) && $maxInvocation->popunder == '1' ? ' checked' : '')." tabindex='".($maxInvocation->tabindex++)."'>&nbsp;".
             "<img src='" . OX::assetPath(). "/images/icon-popup-under.gif' align='absmiddle'>&nbsp;".$GLOBALS['strPopUpStylePopUnder']."</td>";
        $option .= "</tr>";
        $option .= "<tr><td width='30'><img src='" . OX::assetPath(). "/images/spacer.gif' height='5' width='100%'></td></tr>";
        return $option;
    }

    /**
     * Generate the HTML option
     *
     * @return string    A string containing html for option
     */
    function delay()
    {
        global $tabindex;
        $maxInvocation = &$this->maxInvocation;

        $option = '';
        $option .= "<tr><td width='30'>&nbsp;</td>";
        $option .= "<td width='200'>".$GLOBALS['strPopUpCreateInstance']."</td>";
        $option .= "<td width='370'><input type='radio' name='delay_type' value='none'".
             (!isset($maxInvocation->delay_type) || ($maxInvocation->delay_type != 'exit' && $maxInvocation->delay_type != 'seconds') ? ' checked' : '')." tabindex='".($maxInvocation->tabindex++)."'>&nbsp;".$GLOBALS['strPopUpImmediately']."<br />";
        $option .= "<input type='radio' name='delay_type' value='exit'".
             (isset($maxInvocation->delay_type) && $maxInvocation->delay_type == 'exit' ? ' checked' : '')." tabindex='".($maxInvocation->tabindex++)."'>&nbsp;".$GLOBALS['strPopUpOnClose']."<br />";
        $option .= "<input type='radio' name='delay_type' value='seconds'".
             (isset($maxInvocation->delay_type) && $maxInvocation->delay_type == 'seconds' ? ' checked' : '')." tabindex='".($maxInvocation->tabindex++)."'>&nbsp;".$GLOBALS['strPopUpAfterSec']."&nbsp;".
             "<input class='flat' type='text' name='delay' size='' value='".(isset($maxInvocation->delay) ? $maxInvocation->delay : $this->defaultValues['delay'])."' style='width:50px;' tabindex='".($tabindex++)."'> ".$GLOBALS['strAbbrSeconds']."</td>";
        $option .= "</tr>";
        $option .= "<tr><td width='30'><img src='" . OX::assetPath(). "/images/spacer.gif' height='5' width='100%'></td></tr>";
        return $option;
    }

    /**
     * Generate the HTML option
     *
     * @return string    A string containing html for option
     */
    function absolute()
    {
        $maxInvocation = &$this->maxInvocation;

        $option = '';
        $option .= "<tr><td width='30'>&nbsp;</td>";
        $option .= "<td width='200'>".$GLOBALS['strPopUpTop']."</td><td width='370'>";
        $option .= "<input class='flat' type='text' name='top' size='' value='".(isset($maxInvocation->top) ? $maxInvocation->top : $this->defaultValues['absolute']['top'])."' style='width:50px;' tabindex='".($maxInvocation->tabindex++)."'> ".$GLOBALS['strAbbrPixels']."</td></tr>";
        $option .= "<tr><td width='30'>&nbsp;</td>";
        $option .= "<td width='200'>".$GLOBALS['strPopUpLeft']."</td><td width='370'>";
        $option .= "<input class='flat' type='text' name='left' size='' value='".(isset($maxInvocation->left) ? $maxInvocation->left : $this->defaultValues['absolute']['left'])."' style='width:50px;' tabindex='".($maxInvocation->tabindex++)."'> ".$GLOBALS['strAbbrPixels']."</td></tr>";
        $option .= "<tr><td width='30'><img src='" . OX::assetPath(). "/images/spacer.gif' height='5' width='100%'></td></tr>";
        return $option;
    }

    /**
     * Generate the HTML option
     *
     * @return string    A string containing html for option
     */
    function timeout()
    {
        $maxInvocation = &$this->maxInvocation;

        $option = '';
        $option .= "<tr><td width='30'>&nbsp;</td>";
        $option .= "<td width='200'>".$GLOBALS['strAutoCloseAfter']."</td><td width='370'>";
        $option .= "<input class='flat' type='text' name='timeout' size='' value='".(isset($maxInvocation->timeout) ? $maxInvocation->timeout : $this->defaultValues['timeout'])."' style='width:50px;' tabindex='".($maxInvocation->tabindex++)."'> ".$GLOBALS['strAbbrSeconds']."</td></tr>";
        $option .= "<tr><td width='30'><img src='" . OX::assetPath(). "/images/spacer.gif' height='5' width='100%'></td></tr>";
        return $option;
    }

    /**
     * Generate the HTML option
     *
     * @return string    A string containing html for option
     */
    function windowoptions()
    {
        $maxInvocation = &$this->maxInvocation;

        $option = '';
        $option .= "<tr><td width='30'>&nbsp;</td><td width='200' valign='top'>".$GLOBALS['strWindowOptions']."</td><td width='370'>";
        $option .= "<table cellpadding='0' cellspacing='0' border='0'>";
        $option .= "<tr><td>".$GLOBALS['strShowToolbars']."</td><td>&nbsp;&nbsp;&nbsp;</td><td>";
        $option .= "<input type='radio' name='toolbars' value='1'".(isset($maxInvocation->toolbars) && $maxInvocation->toolbars != 0 ? ' checked' : '')." tabindex='".($maxInvocation->tabindex++)."'>&nbsp;".$GLOBALS['strYes']."<br />";
        $option .= "</td><td>&nbsp;&nbsp;&nbsp;</td><td>";
        $option .= "<input type='radio' name='toolbars' value='0'".(!isset($maxInvocation->toolbars) || $maxInvocation->toolbars == 0 ? ' checked' : '')." tabindex='".($maxInvocation->tabindex++)."'>&nbsp;".$GLOBALS['strNo']."";
        $option .= "</td></tr><tr><td colspan='5'><img src='" . OX::assetPath(). "/images/spacer.gif' height='3' width='200' vspace='2'></td></tr>";
        $option .= "<tr><td>".$GLOBALS['strShowLocation']."</td><td>&nbsp;&nbsp;&nbsp;</td><td>";
        $option .= "<input type='radio' name='location' value='1'".(isset($maxInvocation->location) && $maxInvocation->location != 0 ? ' checked' : '')." tabindex='".($maxInvocation->tabindex++)."'>&nbsp;".$GLOBALS['strYes']."<br />";
        $option .= "</td><td>&nbsp;&nbsp;&nbsp;</td><td>";
        $option .= "<input type='radio' name='location' value='0'".(!isset($maxInvocation->location) || $maxInvocation->location == 0 ? ' checked' : '')." tabindex='".($maxInvocation->tabindex++)."'>&nbsp;".$GLOBALS['strNo']."";
        $option .= "</td></tr><tr><td colspan='5'><img src='" . OX::assetPath(). "/images/spacer.gif' height='3' width='200' vspace='2'></td></tr>";
        $option .= "<tr><td>".$GLOBALS['strShowMenubar']."</td><td>&nbsp;&nbsp;&nbsp;</td><td>";
        $option .= "<input type='radio' name='menubar' value='1'".(isset($maxInvocation->menubar) && $maxInvocation->menubar != 0 ? ' checked' : '')." tabindex='".($maxInvocation->tabindex++)."'>&nbsp;".$GLOBALS['strYes']."<br />";
        $option .= "</td><td>&nbsp;&nbsp;&nbsp;</td><td>";
        $option .= "<input type='radio' name='menubar' value='0'".(!isset($maxInvocation->menubar) || $maxInvocation->menubar == 0 ? ' checked' : '')." tabindex='".($maxInvocation->tabindex++)."'>&nbsp;".$GLOBALS['strNo']."";
        $option .= "</td></tr><tr><td colspan='5'><img src='" . OX::assetPath(). "/images/spacer.gif' height='3' width='200' vspace='2'></td></tr>";
        $option .= "<tr><td>".$GLOBALS['strShowStatus']."</td><td>&nbsp;&nbsp;&nbsp;</td><td>";
        $option .= "<input type='radio' name='status' value='1'".(isset($maxInvocation->status) && $maxInvocation->status != 0 ? ' checked' : '')." tabindex='".($maxInvocation->tabindex++)."'>&nbsp;".$GLOBALS['strYes']."<br />";
        $option .= "</td><td>&nbsp;&nbsp;&nbsp;</td><td>";
        $option .= "<input type='radio' name='status' value='0'".(!isset($maxInvocation->status) || $maxInvocation->status == 0 ? ' checked' : '')." tabindex='".($maxInvocation->tabindex++)."'>&nbsp;".$GLOBALS['strNo']."";
        $option .= "</td></tr><tr><td colspan='5'><img src='" . OX::assetPath(). "/images/spacer.gif' height='3' width='200' vspace='2'></td></tr>";
        $option .= "<tr><td>".$GLOBALS['strWindowResizable']."</td><td>&nbsp;&nbsp;&nbsp;</td><td>";
        $option .= "<input type='radio' name='resizable' value='1'".(isset($maxInvocation->resizable) && $maxInvocation->resizable != 0 ? ' checked' : '')." tabindex='".($maxInvocation->tabindex++)."'>&nbsp;".$GLOBALS['strYes']."<br />";
        $option .= "</td><td>&nbsp;&nbsp;&nbsp;</td><td>";
        $option .= "<input type='radio' name='resizable' value='0'".(!isset($maxInvocation->resizable) || $maxInvocation->resizable == 0 ? ' checked' : '')." tabindex='".($maxInvocation->tabindex++)."'>&nbsp;".$GLOBALS['strNo']."";
        $option .= "</td></tr><tr><td colspan='5'><img src='" . OX::assetPath(). "/images/spacer.gif' height='3' width='200' vspace='2'></td></tr>";
        $option .= "<tr><td>".$GLOBALS['strShowScrollbars']."</td><td>&nbsp;&nbsp;&nbsp;</td><td>";
        $option .= "<input type='radio' name='scrollbars' value='1'".(isset($maxInvocation->scrollbars) && $maxInvocation->scrollbars != 0 ? ' checked' : '')." tabindex='".($maxInvocation->tabindex++)."'>&nbsp;".$GLOBALS['strYes']."<br />";
        $option .= "</td><td>&nbsp;&nbsp;&nbsp;</td><td>";
        $option .= "<input type='radio' name='scrollbars' value='0'".(!isset($maxInvocation->scrollbars) || $maxInvocation->scrollbars == 0 ? ' checked' : '')." tabindex='".($maxInvocation->tabindex++)."'>&nbsp;".$GLOBALS['strNo']."";
        $option .= "</td></tr>";
        $option .= "</table>";
        $option .= "</td></tr><tr><td width='30'><img src='" . OX::assetPath(). "/images/spacer.gif' height='5' width='100%'></td></tr>";
        return $option;
    }

    /**
     * Generate the HTML option
     *
     * @return string    A string containing html for option
     */
    function xmlrpcproto()
    {
        $maxInvocation = &$this->maxInvocation;

        $option = '';
        $option .= "<tr><td width='30'>&nbsp;</td>";
        $option .= "<td width='200'>".$GLOBALS['strXmlRpcProtocol']."</td>";
        $option .= "<td width='370'><input type='radio' name='xmlrpcproto' value='1'".(isset($maxInvocation->xmlrpcproto) && $maxInvocation->xmlrpcproto != 0 ? ' checked' : '')." tabindex='".($maxInvocation->tabindex++)."'>&nbsp;".$GLOBALS['strYes']."<br />";
        $option .= "<input type='radio' name='xmlrpcproto' value='0'".(!isset($maxInvocation->xmlrpcproto) || $maxInvocation->xmlrpcproto == 0 ? ' checked' : '')." tabindex='".($maxInvocation->tabindex++)."'>&nbsp;".$GLOBALS['strNo']."</td>";
        $option .= "</tr>";
        $option .= "<tr><td width='30'><img src='" . OX::assetPath(). "/images/spacer.gif' height='5' width='100%'></td></tr>";
        return $option;
    }

    /**
     * Generate the HTML option
     *
     * @return string    A string containing html for option
     */
    function xmlrpctimeout()
    {
        $maxInvocation = &$this->maxInvocation;

        $option = '';
        $option .= "<tr><td width='30'>&nbsp;</td>";
        $option .= "<td width='200'>".$GLOBALS['strXmlRpcTimeout']."</td><td width='370'>";
        $option .= "<input class='flat' type='text' name='xmlrpctimeout' size='' value='".(isset($maxInvocation->xmlrpctimeout) ? $maxInvocation->xmlrpctimeout : $this->defaultValues['xmlrpctimeout'])."' style='width:175px;' tabindex='".($maxInvocation->tabindex++)."'></td></tr>";
        $option .= "<tr><td width='30'><img src='" . OX::assetPath(). "/images/spacer.gif' height='5' width='100%'></td></tr>";
        return $option;
    }

    /**
     * Generate the HTML option
     *
     * @return string    A string containing html for option
     */
    function hostlanguage()
    {
        global $tabindex;
        $maxInvocation = &$this->maxInvocation;

        $option = '';
        $option .= "<tr><td width='30'>&nbsp;</td>";
        $option .= "<td width='200'>".$GLOBALS['strXmlRpcLanguage']."</td><td width='370'>";
        $option .= "<select name='hostlanguage' tabindex='".($tabindex++)."'>";
        $option .= "<option value='php'".($maxInvocation->hostlanguage == 'php' ? ' selected' : $this->defaultValues['hostlanguage']).">PHP</option>";
        $option .= "</select>";
        $option .= "</td></tr>";
        return $option;
    }

    /**
     * Generate the HTML option for output adserver selection
     *
     * @return string    A string containing html for option
     */
    function thirdPartyServer()
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        $pref = $GLOBALS['_MAX']['PREF'];
        $selectedOutputAdServer = (is_null($this->maxInvocation->thirdpartytrack)) ? $conf['delivery']['clicktracking'] : $this->maxInvocation->thirdpartytrack;
        $maxInvocation =& $this->maxInvocation;

        $option = '';
        $option .= "
        <tr>
            <td width='30'>&nbsp;</td>
            <td width='200'>{$GLOBALS['str3rdPartyTrack']}</td>
            <td width='370'>
        ";

        // Add selection box for output adservers
        $option .= "<select name='thirdpartytrack' tabindex='" . ($maxInvocation->tabindex++) . "'>";
        $option .= "<option value='0'>{$GLOBALS['strNo']}</option>";
        $option .= "<option value='generic' ".($maxInvocation->thirdpartytrack == 'generic' ? " selected='selected'" : '').">{$GLOBALS['strGenericOutputAdServer']}</option>";

        $outputAdServers = &OX_Component::getComponents('3rdPartyServers');
        $availableOutputAdServerNames = array();
        foreach ($outputAdServers as $pluginKey => $outputAdServer) {
            if (!empty($outputAdServer->hasOutputMacros)) {
                $availableOutputAdServers[$pluginKey] = $outputAdServer;
                $availableOutputAdServerNames[$pluginKey] = $outputAdServer->getName();
            }
        }
        asort($availableOutputAdServerNames);
        foreach ($availableOutputAdServerNames as $pluginKey => $outputAdServerName) {
            $option .= "<option value='{$pluginKey}'".($maxInvocation->thirdpartytrack == $pluginKey ? ' selected="selected"' : '').">" . $outputAdServerName . "</option>";
        }
        $option .= "</select>";
        $option .= "</tr>";
        $option .= "<tr><td width='30'><img src='" . OX::assetPath(). "/images/spacer.gif' height='5' width='100%'></td></tr>";
        return $option;
    }

    function cacheBuster()
    {
        $maxInvocation =& $this->maxInvocation;
        $cachebuster = (is_null($this->maxInvocation->cachebuster)) ? $this->defaultValues['cacheBuster'] : $this->maxInvocation->cachebuster;

        $option = '';
        $option .= "
        <tr>
            <td width='30'>&nbsp;</td>
            <td width='200'>{$GLOBALS['strCacheBuster']}</td>
            <td width='370'><input type='radio' name='cachebuster' value='1'".($cachebuster == 1 ? " checked='checked'" : '')." tabindex='".($maxInvocation->tabindex++)."'>&nbsp;{$GLOBALS['strYes']}<br />
            <input type='radio' name='cachebuster' value='0'".($cachebuster == 0 ? " checked='checked'" : '')." tabindex='".($maxInvocation->tabindex++)."'>&nbsp;{$GLOBALS['strNo']}</td>
        </tr>
        <tr>
            <td width='30'><img src='" . OX::assetPath(). "/images/spacer.gif' height='5' width='100%'></td></tr>
        ";
        return $option;
    }

    /**
     * Generate the HTML option for comments inclusion
     *
     * @return string    A string containing html for option
     */
    function comments()
    {
        $maxInvocation = &$this->maxInvocation;
        $comments = (isset($maxInvocation->comments)) ? $maxInvocation->comments : $this->defaultValues['comments'];

        $option = '';
        $option .= "<tr><td width='30'>&nbsp;</td>";
        $option .= "<td width='200'>".$GLOBALS['strInvocationComments']."</td>";
        $option .= "<td width='370'><input type='radio' name='comments' value='1'".($comments == 1 ? " checked='checked'" : '')." tabindex='".($maxInvocation->tabindex++)."'>&nbsp;".$GLOBALS['strYes']."<br />";
        $option .= "<input type='radio' name='comments' value='0'".($comments == 0 ? " checked='checked'" : '')." tabindex='".($maxInvocation->tabindex++)."'>&nbsp;".$GLOBALS['strNo']."</td>";
        $option .= "</tr>";
        $option .= "<tr><td width='30'><img src='" . OX::assetPath(). "/images/spacer.gif' height='5' width='100%'></td></tr>";
        return $option;
    }

    /**
     * Generate the HTML option for charset inclusion
     *
     * @return string    A string containing html for option
     */
    function charset()
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        $pref = $GLOBALS['_MAX']['PREF'];

        $maxInvocation =& $this->maxInvocation;

        $option = "
        <tr>
            <td width='30'>&nbsp;</td>
            <td width='200'>{$GLOBALS['strCharset']}</td>
            <td width='370'>
        ";

        // Add selection box for output adservers
        $option .= "<select name='charset' tabindex='" . ($maxInvocation->tabindex++) . "'>";
        $option .= "<option value='' ". ((empty($maxInvocation->charset) && empty($maxInvocation->canDetectCharset)) ? ' selected="selected"' : '') .">{$GLOBALS['strNone']}</option>";

        if ($maxInvocation->canDetectCharset) {
            $option .= "<option value=''".(empty($maxInvocation->charset) ? ' selected="selected"' : '').">{$GLOBALS['strAutoDetect']}</option>";
        }

        $availableCharsets = $this->_getAvailableCharsets();

        asort($availableCharsets);
        foreach ($availableCharsets as $charsetCode => $charsetName) {
            $option .= "<option value='{$charsetCode}'".($maxInvocation->charset == $charsetCode ? ' selected="selected"' : '').">" . $charsetName . "</option>\n";
        }
        $option .= "</select>";
        $option .= "</tr>";
        $option .= "<tr><td width='30'><img src='" . OX::assetPath(). "/images/spacer.gif' height='5' width='100%'></td></tr>";
        return $option;
    }

    function _getAvailableCharsets()
    {
        if (function_exists('iconv') || function_exists('mb_convert_encoding')) {
            return array(
                'ISO-8859-6'    => 'Arabic (ISO-8859-6)',
                'Windows-1256'  => 'Arabic (Windows-1256)',
                'ISO-8859-4'    => 'Baltic (ISO-8859-4)',
                'Windows-1257'  => 'Baltic (Windows-1257)',
                'ISO-8859-2'    => 'Central European (ISO-8859-2)',
                'Windows-1250'  => 'Central European (Windows-1250)',
                'GB18030'       => 'Chinese Simplified (GB18030)',
                'GB2312'        => 'Chinese Simplified (GB2312)',
                'HZ'            => 'Chinese Simplified (HZ)',
                'Big5'          => 'Chinese Traditional (Big5)',
                'KOI8-R'        => 'Cyrillic (KOI8-R)',
                'ISO-8859-5'    => 'Cyrillic (ISO-8859-5)',
                'Windows-1251'  => 'Cyrillic (Windows-1251)',
                'ISO-8859-13'   => 'Estonian (ISO-8859-13)',
                'ISO-8859-7'    => 'Greek (ISO-8859-7)',
                'Windows-1253'  => 'Greek (Windows-1253)',
                'ISO-8859-8-l'  => 'Hebrew (ISO Logical: ISO-8859-8-l)',
                'ISO-8859-8'    => 'Hebrew (ISO:Visual: ISO-8859-8)',
                'Windows-1255'  => 'Hebrew (Windows-1255)',
                'EUC-JP'        => 'Japanese (EUC-JP)',
                'Shift-JIS'     => 'Japanese (Shift-JIS)',
                'EUC-KR'        => 'Korean (EUC-KR)',
                'ISO-8859-15'   => 'Latin 9 (ISO-8859-15)',
                'TIS-620'       => 'Thai (TIS-620)',
                'ISO-8859-9'    => 'Turkish (ISO-8859-9)',
                'Windows-1254'  => 'Turkish (Windows-1254)',
                'UTF-8'         => 'Unicode (UTF-8)',
                'Windows-1258'  => 'Vietnamese (Windows-1258)',
                'ISO-8859-1'    => 'Western European (ISO-8859-1)',
                'Windows-1252'  => 'Western European (Windows-1252)'
            );
        } else if (function_exists('utf8_encode')) { // No? try utf8_encode/decode
            return array(
                'UTF-8'         => 'Unicode (UTF-8)',
                'ISO-8859-1'    => 'Western European (ISO-8859-1)',
            );
        }
    }
}

?>
