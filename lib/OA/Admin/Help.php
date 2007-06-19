<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2007 Openads Limited                                   |
| For contact details, see: http://www.openads.org/                         |
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
$Id: Config.php 7436 2007-06-11 14:20:35Z david.keen@openads.org $
*/

/**
 * Defines type of link building
 * #@+
 */
define('OA_HELP_LINK_BUILD_USING_LINK',      1);
define('OA_HELP_LINK_BUILD_USING_ID',        2);
$GLOBALS['OA_HELP_LINK_BUILD_TYPE'] = OA_HELP_LINK_BUILD_USING_LINK;
/**#@-*/
/**
 * Class for generating links to the documentation
 *
 * @author     Marek Bedkowski <marek@bedkowski.pl>
 * 
 */
class OA_Admin_Help
{
    /**
     * This function prepares link to a selected page in the doc
     * 
     * Based on settings in $GLOBALS['aHelpPages'] this function can generate a full
     * URL to a Manual Pages.
     * 
     * There are 3 params - 2nd should be clear but 3rd one lets you decide if
     * display should be based on some variable - just pass it and if config has been
     * made, applicable link will be displayed
     * 
     * @return mixed (string/PEAR_Error) string is a URL poiting to docs
     * 
     * @param string $sDocumentationPath - dot separated list of elements to point to (strucutre mirros documentation structure on docs.openads.org)
     * @param mixed $anchor - anchor can be int/string key for a given anchor that a given element can point to
     * @param string $aVarRotate - lets you decide if url should be generated depending on some external var
     * 
     * @author Marek Bedkowski <marek@bedkowski.pl>
     * 
     */
    function getDocPageUrl($sDocumentationPath, $anchor = -1, $aVarRotate = null)
    {
        $aPath = preg_split( '/(?<!\\\\)\./', $sDocumentationPath );
        $iPathSize = count($aPath);
        $aSelectedElement = $GLOBALS['aHelpPages'];
        $sLink = '';
        $iPathElementsFound = 0;
        while(!is_null($sPathElem = array_shift($aPath))) {
            if (!empty($aSelectedElement['elements'][ $sPathElem ])) {
                $aSelectedElement = $aSelectedElement['elements'][ $sPathElem ];
                $iPathElementsFound++;
            }
        }

        // prevent unfinished paths to splip through
        if ($iPathElementsFound == $iPathSize) {
            switch ($GLOBALS['OA_HELP_LINK_BUILD_TYPE']){
                case OA_HELP_LINK_BUILD_USING_ID:
        	        $sLink = $aSelectedElement['itemId'].'/'.$aSelectedElement['id'].'/';
        	        break;  	
                case OA_HELP_LINK_BUILD_USING_LINK: // fallthrough  	
                default:
                    $sLink = $aSelectedElement['link'];
                    break;        	
            }

            if (!is_null($aVarRotate)) {
               while(list($sVarName, $sVarValue) = each($aVarRotate)) { 
                    if (!empty($aSelectedElement['rotate']['_' . $sVarName]) && isset($aSelectedElement['rotate']['_' . $sVarName][$sVarValue])) {
                        $anchor = $aSelectedElement['rotate']['_' . $sVarName][$sVarValue];
                    }
                }
            }

            if ($anchor != -1 && !empty($aSelectedElement['anchors'][$anchor])) {
                $sLink .= '#';
                if (is_numeric($anchor)) {
                    $sLink .= 'docs_' . $anchor;
                }
                else {
                    $sLink .= $anchor;
                }
            }
        }

        if (empty($sLink)) {
        	$sLink = 'index.html';
        }

        $sDocsRoot = rtrim(OA_DOCUMENTATION_BASE_URL, '/');

        $sLink = $sDocsRoot . '/' .  $sLink;

        return $sLink;
    }

    /**
     * This method gets link to main Help button based on navID
     * 
     *  
     * @param string $sNavId - id of navigation element in form {num}[.{num}[.{num}]]
     * @return string - link to doc
     * 
     * This function uses {@see OA_Admin_Help::getDocPageUrl} internally to properly format a link
     * based on settings in global navi2doc array
     * 
     * @author Marek Bedkowski <marek@bedkowski.pl>
     * 
     */
    function getDocLinkFromPhpAdsNavId($sNavId)
    {
        // Prepare navi2help mapping
        if (phpAds_isUser(phpAds_Admin))
            $navi2help	= $GLOBALS['navi2help']['admin'];
        elseif (phpAds_isUser(phpAds_Client))
            $navi2help  = $GLOBALS['navi2help']['client'];
        elseif (phpAds_isUser(phpAds_Affiliate))
            $navi2help  = $GLOBALS['navi2help']['affiliate'];
        elseif (phpAds_isUser(phpAds_Agency))
            $navi2help  = $GLOBALS['navi2help']['agency'];
        else
            $navi2help  = array();
	
        if (!empty($navi2help[ $sNavId ])) {
            $aElem = $navi2help[ $sNavId ];
            $sFile = basename($_SERVER['REQUEST_URI']);
            if (!empty($aElem['use_file']) && !empty($aElem['use_file'][$sFile]))
                $aElem = $aElem['use_file'][$sFile];

            $sLink = OA_Admin_Help::getDocPageUrl( $aElem[0], empty( $aElem[1] ) ? -1 : $aElem[1] );

        }
        else {
            $sDocsRoot = rtrim(OA_DOCUMENTATION_BASE_URL, '/');
            $sLink = $sDocsRoot . '/index.html';
        }

        return $sLink;
    }

}

?>