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
            $option .= "<textarea class='flat' name='what' rows='3' cols='50' style='width:350px;' tabindex='".($maxInvocation->tabindex++)."'>".(isset($maxInvocation->what) ? stripslashes($maxInvocation->what) : '')."</textarea></td></tr>";

            if (OA_Permission::isAccount(OA_ACCOUNT_ADMIN)) {
                $option .= "<tr bgcolor='#F6F6F6'><td height='10' colspan='3'>&nbsp;</td></tr>";
                $option .= "<tr height='1'><td colspan='3' bgcolor='#888888'><img src='" . MAX::assetPath() . "/images/break.gif' height='1' width='100%'></td></tr>";
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
        $option .= "<tr height='1'><td colspan='3' bgcolor='#888888'><img src='" . MAX::assetPath() . "/images/break.gif' height='1' width='100%'></td></tr>";
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
        $option .= "<tr><td width='30'><img src='" . MAX::assetPath() . "/images/spacer.gif' height='5' width='100%'></td></tr>";
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

        $target = (!empty($maxInvocation->target)) ? $maxInvocation->target : '';
        $option = '';
        $option .= "<tr><td width='30'>&nbsp;</td>
            <td width='200'>".$GLOBALS['strInvocationTarget']."</td><td width='370'>
            <select name='target' tabindex='".($maxInvocation->tabindex++)."'>
                <option value=''>Default</option>
                <option value='_blank'" . ($target == '_blank' ? " selected='selected'" : '') . ">New window</option>
                <option value='_top'" . ($target == '_top' ? " selected='selected'" : '') . ">Same window</option>
            </select>
            <tr><td width='30'><img src='" . MAX::assetPath() . "/images/spacer.gif' height='5' width='100%'></td></tr>";

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
        $option .= "<input class='flat' type='text' name='source' size='' value='".(isset($maxInvocation->source) ? $maxInvocation->source : '')."' style='width:175px;' tabindex='".($maxInvocation->tabindex++)."'></td></tr>";
        $option .= "<tr><td width='30'><img src='" . MAX::assetPath() . "/images/spacer.gif' height='5' width='100%'></td></tr>";
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
        $option .= "<tr><td width='30'><img src='" . MAX::assetPath() . "/images/spacer.gif' height='5' width='100%'></td></tr>";
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
        $option .= "<input class='flat' type='text' name='refresh' size='' value='".(isset($maxInvocation->refresh) ? $maxInvocation->refresh : '')."' style='width:175px;' tabindex='".($maxInvocation->tabindex++)."'> ".$GLOBALS['strAbbrSeconds']."</td></tr>";
        $option .= "<tr><td width='30'><img src='" . MAX::assetPath() . "/images/spacer.gif' height='5' width='100%'></td></tr>";
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
        if (!$maxInvocation->zone_invocation) {
            $option .= "<tr><td width='30'>&nbsp;</td>";
            $option .= "<td width='200'>".$GLOBALS['strFrameSize']."</td><td width='370'>";
            $option .= $GLOBALS['strWidth'].": <input class='flat' type='text' name='width' size='3' value='".(isset($maxInvocation->width) ? $maxInvocation->width : '')."' tabindex='".($maxInvocation->tabindex++)."'>&nbsp;&nbsp;&nbsp;";
            $option .= $GLOBALS['strHeight'].": <input class='flat' type='text' name='height' size='3' value='".(isset($maxInvocation->height) ? $maxInvocation->height : '')."' tabindex='".($maxInvocation->tabindex++)."'>";
            $option .= "</td></tr>";
            $option .= "<tr><td width='30'><img src='" . MAX::assetPath() . "/images/spacer.gif' height='5' width='100%'></td></tr>";
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
            $option .= "<tr><td width='30'><img src='" . MAX::assetPath() . "/images/spacer.gif' height='5' width='100%'></td></tr>";
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
        $option .= "<tr><td width='30'><img src='" . MAX::assetPath() . "/images/spacer.gif' height='5' width='100%'></td></tr>";
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
        $option .= "<tr><td width='30'><img src='" . MAX::assetPath() . "/images/spacer.gif' height='5' width='100%'></td></tr>";
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
        $option .= "<td width='200'>". 'Include code to track Google AdSense clicks' ."</td>";
        $option .= "<td width='370'><input type='radio' name='iframetracking' value='1'".(!isset($maxInvocation->iframetracking) || $maxInvocation->iframetracking == 1 ? ' checked' : '')." tabindex='".($maxInvocation->tabindex++)."'>&nbsp;".$GLOBALS['strYes']."<br />";
        $option .= "<input type='radio' name='iframetracking' value='0'".(isset($maxInvocation->iframetracking) && $maxInvocation->iframetracking == 0 ? ' checked' : '')." tabindex='".($maxInvocation->tabindex++)."'>&nbsp;".$GLOBALS['strNo']."</td>";
        $option .= "</tr>";
        $option .= "<tr><td width='30'><img src='" . MAX::assetPath() . "/images/spacer.gif' height='5' width='100%'></td></tr>";
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
        $option .= "<tr><td width='30'><img src='" . MAX::assetPath() . "/images/spacer.gif' height='5' width='100%'></td></tr>";
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
        $option .= "<tr><td width='30'><img src='" . MAX::assetPath() . "/images/spacer.gif' height='5' width='100%'></td></tr>";
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
        $option .= "<tr><td width='30'><img src='" . MAX::assetPath() . "/images/spacer.gif' height='5' width='100%'></td></tr>";
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
        $option .= "<td width='200'>".MAX_Plugin_Translation::translate('Pop-up type', 'invocationTags')."</td>";
        $option .= "<td width='370'><input type='radio' name='popunder' value='0'".
             (!isset($maxInvocation->popunder) || $maxInvocation->popunder != '1' ? ' checked' : '')." tabindex='".($maxInvocation->tabindex++)."'>&nbsp;".
             "<img src='" . MAX::assetPath() . "/images/icon-popup-over.gif' align='absmiddle'>&nbsp;".MAX_Plugin_Translation::translate('Pop-up', 'invocationTags')."<br />";
        $option .= "<input type='radio' name='popunder' value='1'".
             (isset($maxInvocation->popunder) && $maxInvocation->popunder == '1' ? ' checked' : '')." tabindex='".($maxInvocation->tabindex++)."'>&nbsp;".
             "<img src='" . MAX::assetPath() . "/images/icon-popup-under.gif' align='absmiddle'>&nbsp;".MAX_Plugin_Translation::translate('Pop-under', 'invocationTags')."</td>";
        $option .= "</tr>";
        $option .= "<tr><td width='30'><img src='" . MAX::assetPath() . "/images/spacer.gif' height='5' width='100%'></td></tr>";
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
        $option .= "<td width='200'>".MAX_Plugin_Translation::translate('Instance when the pop-up is created', 'invocationTags')."</td>";
        $option .= "<td width='370'><input type='radio' name='delay_type' value='none'".
             (!isset($maxInvocation->delay_type) || ($maxInvocation->delay_type != 'exit' && $maxInvocation->delay_type != 'seconds') ? ' checked' : '')." tabindex='".($maxInvocation->tabindex++)."'>&nbsp;".MAX_Plugin_Translation::translate('Immediately', 'invocationTags')."<br />";
        $option .= "<input type='radio' name='delay_type' value='exit'".
             (isset($maxInvocation->delay_type) && $maxInvocation->delay_type == 'exit' ? ' checked' : '')." tabindex='".($maxInvocation->tabindex++)."'>&nbsp;".MAX_Plugin_Translation::translate('When the page is closed', 'invocationTags')."<br />";
        $option .= "<input type='radio' name='delay_type' value='seconds'".
             (isset($maxInvocation->delay_type) && $maxInvocation->delay_type == 'seconds' ? ' checked' : '')." tabindex='".($maxInvocation->tabindex++)."'>&nbsp;".MAX_Plugin_Translation::translate('After', 'invocationTags')."&nbsp;".
             "<input class='flat' type='text' name='delay' size='' value='".(isset($maxInvocation->delay) ? $maxInvocation->delay : '-')."' style='width:50px;' tabindex='".($tabindex++)."'> ".$GLOBALS['strAbbrSeconds']."</td>";
        $option .= "</tr>";
        $option .= "<tr><td width='30'><img src='" . MAX::assetPath() . "/images/spacer.gif' height='5' width='100%'></td></tr>";
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
        $option .= "<td width='200'>".MAX_Plugin_Translation::translate('Initial position (top)', 'invocationTags')."</td><td width='370'>";
        $option .= "<input class='flat' type='text' name='top' size='' value='".(isset($maxInvocation->top) ? $maxInvocation->top : '-')."' style='width:50px;' tabindex='".($maxInvocation->tabindex++)."'> ".$GLOBALS['strAbbrPixels']."</td></tr>";
        $option .= "<tr><td width='30'>&nbsp;</td>";
        $option .= "<td width='200'>".MAX_Plugin_Translation::translate('Initial position (left)', 'invocationTags')."</td><td width='370'>";
        $option .= "<input class='flat' type='text' name='left' size='' value='".(isset($maxInvocation->left) ? $maxInvocation->left : '-')."' style='width:50px;' tabindex='".($maxInvocation->tabindex++)."'> ".$GLOBALS['strAbbrPixels']."</td></tr>";
        $option .= "<tr><td width='30'><img src='" . MAX::assetPath() . "/images/spacer.gif' height='5' width='100%'></td></tr>";
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
        $option .= "<td width='200'>".MAX_Plugin_Translation::translate('Automatically close after', 'invocationTags')."</td><td width='370'>";
        $option .= "<input class='flat' type='text' name='timeout' size='' value='".(isset($maxInvocation->timeout) ? $maxInvocation->timeout : '-')."' style='width:50px;' tabindex='".($maxInvocation->tabindex++)."'> ".$GLOBALS['strAbbrSeconds']."</td></tr>";
        $option .= "<tr><td width='30'><img src='" . MAX::assetPath() . "/images/spacer.gif' height='5' width='100%'></td></tr>";
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
        $option .= "<tr><td width='30'>&nbsp;</td><td width='200' valign='top'>".MAX_Plugin_Translation::translate('Window options', 'invocationTags')."</td><td width='370'>";
        $option .= "<table cellpadding='0' cellspacing='0' border='0'>";
        $option .= "<tr><td>".MAX_Plugin_Translation::translate('Toolbars', 'invocationTags')."</td><td>&nbsp;&nbsp;&nbsp;</td><td>";
        $option .= "<input type='radio' name='toolbars' value='1'".(isset($maxInvocation->toolbars) && $maxInvocation->toolbars != 0 ? ' checked' : '')." tabindex='".($maxInvocation->tabindex++)."'>&nbsp;".$GLOBALS['strYes']."<br />";
        $option .= "</td><td>&nbsp;&nbsp;&nbsp;</td><td>";
        $option .= "<input type='radio' name='toolbars' value='0'".(!isset($maxInvocation->toolbars) || $maxInvocation->toolbars == 0 ? ' checked' : '')." tabindex='".($maxInvocation->tabindex++)."'>&nbsp;".$GLOBALS['strNo']."";
        $option .= "</td></tr><tr><td colspan='5'><img src='" . MAX::assetPath() . "/images/spacer.gif' height='3' width='200' vspace='2'></td></tr>";
        $option .= "<tr><td>".MAX_Plugin_Translation::translate('Location', 'invocationTags')."</td><td>&nbsp;&nbsp;&nbsp;</td><td>";
        $option .= "<input type='radio' name='location' value='1'".(isset($maxInvocation->location) && $maxInvocation->location != 0 ? ' checked' : '')." tabindex='".($maxInvocation->tabindex++)."'>&nbsp;".$GLOBALS['strYes']."<br />";
        $option .= "</td><td>&nbsp;&nbsp;&nbsp;</td><td>";
        $option .= "<input type='radio' name='location' value='0'".(!isset($maxInvocation->location) || $maxInvocation->location == 0 ? ' checked' : '')." tabindex='".($maxInvocation->tabindex++)."'>&nbsp;".$GLOBALS['strNo']."";
        $option .= "</td></tr><tr><td colspan='5'><img src='" . MAX::assetPath() . "/images/spacer.gif' height='3' width='200' vspace='2'></td></tr>";
        $option .= "<tr><td>".MAX_Plugin_Translation::translate('Menubar', 'invocationTags')."</td><td>&nbsp;&nbsp;&nbsp;</td><td>";
        $option .= "<input type='radio' name='menubar' value='1'".(isset($maxInvocation->menubar) && $maxInvocation->menubar != 0 ? ' checked' : '')." tabindex='".($maxInvocation->tabindex++)."'>&nbsp;".$GLOBALS['strYes']."<br />";
        $option .= "</td><td>&nbsp;&nbsp;&nbsp;</td><td>";
        $option .= "<input type='radio' name='menubar' value='0'".(!isset($maxInvocation->menubar) || $maxInvocation->menubar == 0 ? ' checked' : '')." tabindex='".($maxInvocation->tabindex++)."'>&nbsp;".$GLOBALS['strNo']."";
        $option .= "</td></tr><tr><td colspan='5'><img src='" . MAX::assetPath() . "/images/spacer.gif' height='3' width='200' vspace='2'></td></tr>";
        $option .= "<tr><td>".MAX_Plugin_Translation::translate('Status', 'invocationTags')."</td><td>&nbsp;&nbsp;&nbsp;</td><td>";
        $option .= "<input type='radio' name='status' value='1'".(isset($maxInvocation->status) && $maxInvocation->status != 0 ? ' checked' : '')." tabindex='".($maxInvocation->tabindex++)."'>&nbsp;".$GLOBALS['strYes']."<br />";
        $option .= "</td><td>&nbsp;&nbsp;&nbsp;</td><td>";
        $option .= "<input type='radio' name='status' value='0'".(!isset($maxInvocation->status) || $maxInvocation->status == 0 ? ' checked' : '')." tabindex='".($maxInvocation->tabindex++)."'>&nbsp;".$GLOBALS['strNo']."";
        $option .= "</td></tr><tr><td colspan='5'><img src='" . MAX::assetPath() . "/images/spacer.gif' height='3' width='200' vspace='2'></td></tr>";
        $option .= "<tr><td>".MAX_Plugin_Translation::translate('Resizable', 'invocationTags')."</td><td>&nbsp;&nbsp;&nbsp;</td><td>";
        $option .= "<input type='radio' name='resizable' value='1'".(isset($maxInvocation->resizable) && $maxInvocation->resizable != 0 ? ' checked' : '')." tabindex='".($maxInvocation->tabindex++)."'>&nbsp;".$GLOBALS['strYes']."<br />";
        $option .= "</td><td>&nbsp;&nbsp;&nbsp;</td><td>";
        $option .= "<input type='radio' name='resizable' value='0'".(!isset($maxInvocation->resizable) || $maxInvocation->resizable == 0 ? ' checked' : '')." tabindex='".($maxInvocation->tabindex++)."'>&nbsp;".$GLOBALS['strNo']."";
        $option .= "</td></tr><tr><td colspan='5'><img src='" . MAX::assetPath() . "/images/spacer.gif' height='3' width='200' vspace='2'></td></tr>";
        $option .= "<tr><td>".MAX_Plugin_Translation::translate('Scrollbars', 'invocationTags')."</td><td>&nbsp;&nbsp;&nbsp;</td><td>";
        $option .= "<input type='radio' name='scrollbars' value='1'".(isset($maxInvocation->scrollbars) && $maxInvocation->scrollbars != 0 ? ' checked' : '')." tabindex='".($maxInvocation->tabindex++)."'>&nbsp;".$GLOBALS['strYes']."<br />";
        $option .= "</td><td>&nbsp;&nbsp;&nbsp;</td><td>";
        $option .= "<input type='radio' name='scrollbars' value='0'".(!isset($maxInvocation->scrollbars) || $maxInvocation->scrollbars == 0 ? ' checked' : '')." tabindex='".($maxInvocation->tabindex++)."'>&nbsp;".$GLOBALS['strNo']."";
        $option .= "</td></tr>";
        $option .= "</table>";
        $option .= "</td></tr><tr><td width='30'><img src='" . MAX::assetPath() . "/images/spacer.gif' height='5' width='100%'></td></tr>";
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
        $option .= "<td width='200'>".MAX_Plugin_Translation::translate('Use HTTPS to contact XML-RPC Server', 'invocationTags')."</td>";
        $option .= "<td width='370'><input type='radio' name='xmlrpcproto' value='1'".(isset($maxInvocation->xmlrpcproto) && $maxInvocation->xmlrpcproto != 0 ? ' checked' : '')." tabindex='".($maxInvocation->tabindex++)."'>&nbsp;".$GLOBALS['strYes']."<br />";
        $option .= "<input type='radio' name='xmlrpcproto' value='0'".(!isset($maxInvocation->xmlrpcproto) || $maxInvocation->xmlrpcproto == 0 ? ' checked' : '')." tabindex='".($maxInvocation->tabindex++)."'>&nbsp;".$GLOBALS['strNo']."</td>";
        $option .= "</tr>";
        $option .= "<tr><td width='30'><img src='" . MAX::assetPath() . "/images/spacer.gif' height='5' width='100%'></td></tr>";
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
        $option .= "<td width='200'>".MAX_Plugin_Translation::translate('XML-RPC Timeout (Seconds)', 'invocationTags')."</td><td width='370'>";
        $option .= "<input class='flat' type='text' name='xmlrpctimeout' size='' value='".(isset($maxInvocation->xmlrpctimeout) ? $maxInvocation->xmlrpctimeout : '')."' style='width:175px;' tabindex='".($maxInvocation->tabindex++)."'></td></tr>";
        $option .= "<tr><td width='30'><img src='" . MAX::assetPath() . "/images/spacer.gif' height='5' width='100%'></td></tr>";
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
        $option .= "<td width='200'>".MAX_Plugin_Translation::translate('Host Language', 'invocationTags')."</td><td width='370'>";
        $option .= "<select name='hostlanguage' tabindex='".($tabindex++)."'>";
        $option .= "<option value='php'".($maxInvocation->hostlanguage == 'php' ? ' selected' : '').">PHP</option>";
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

        $outputAdServers = &MAX_Plugin::getPlugins('3rdPartyServers');
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
        $option .= "<tr><td width='30'><img src='" . MAX::assetPath() . "/images/spacer.gif' height='5' width='100%'></td></tr>";
        return $option;
    }

    function cacheBuster()
    {
        $maxInvocation =& $this->maxInvocation;
        $cachebuster = (is_null($this->maxInvocation->cachebuster)) ? 1 : $this->maxInvocation->cachebuster;

        $option = '';
        $option .= "
        <tr>
            <td width='30'>&nbsp;</td>
            <td width='200'>{$GLOBALS['strCacheBuster']}</td>
            <td width='370'><input type='radio' name='cachebuster' value='1'".($cachebuster == 1 ? " checked='checked'" : '')." tabindex='".($maxInvocation->tabindex++)."'>&nbsp;{$GLOBALS['strYes']}<br />
            <input type='radio' name='cachebuster' value='0'".($cachebuster == 0 ? " checked='checked'" : '')." tabindex='".($maxInvocation->tabindex++)."'>&nbsp;{$GLOBALS['strNo']}</td>
        </tr>
        <tr>
            <td width='30'><img src='" . MAX::assetPath() . "/images/spacer.gif' height='5' width='100%'></td></tr>
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
        $comments = (isset($maxInvocation->comments)) ? $maxInvocation->comments : 1;

        $option = '';
        $option .= "<tr><td width='30'>&nbsp;</td>";
        $option .= "<td width='200'>".$GLOBALS['strInvocationComments']."</td>";
        $option .= "<td width='370'><input type='radio' name='comments' value='1'".($comments == 1 ? " checked='checked'" : '')." tabindex='".($maxInvocation->tabindex++)."'>&nbsp;".$GLOBALS['strYes']."<br />";
        $option .= "<input type='radio' name='comments' value='0'".($comments == 0 ? " checked='checked'" : '')." tabindex='".($maxInvocation->tabindex++)."'>&nbsp;".$GLOBALS['strNo']."</td>";
        $option .= "</tr>";
        $option .= "<tr><td width='30'><img src='" . MAX::assetPath() . "/images/spacer.gif' height='5' width='100%'></td></tr>";
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
        $option .= "<tr><td width='30'><img src='" . MAX::assetPath() . "/images/spacer.gif' height='5' width='100%'></td></tr>";
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
