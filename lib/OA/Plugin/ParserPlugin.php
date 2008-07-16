<?php
/*
+---------------------------------------------------------------------------+
| Openads v${RELEASE_MAJOR_MINOR}                                                              |
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
$Id: ParserPackage.php 22653 2008-07-15 08:13:50Z monique.szpak@openx.org $
*/



require_once MAX_PATH.'/lib/OA/Plugin/ParserBase.php';

/**
 * Parses an XML plugin install file
 *
 * @package OpenX Plugins
 * @author  Monique Szpak <monique.szpak@openx.org>
 */
class OX_ParserPlugin extends OX_ParserBase
{

    var $aContents = array();
    var $aExtensions = array();
    var $aComponents;
    var $aModules;

    function startHandler($xp, $element, $attribs)
    {
        parent::startHandler($xp, $element, $attribs);

        switch ($this->element)
        {
            case 'plugin-install-contents-group':
                $this->aData = array();
                foreach ($attribs AS $k => $v)
                {
                    $this->aData[strtolower($k)] = $v;
                }
                break;
            case 'plugin-install-register-extension':
                $this->aData = array();
                foreach ($attribs AS $k => $v)
                {
                    $this->aData[strtolower($k)] = $v;
                }
                break;
            case 'plugin-install-contents':
                $this->aContents = array();
                break;
            case 'plugin-install-register':
                $this->aExtensions = array();
                break;
        }
    }

    function endHandler($xp, $element)
    {

        switch ($this->element)
        {
            case 'plugin':
                $this->aInstall['contents']   = $this->aContents;
                $this->aInstall['extensions'] = $this->aExtensions;
                break;
            /*case 'plugin-install-register-extension':
                $this->aExtensions[$this->aData['type']][] = $this->aData['name'];
                break;*/
        }

        parent::endHandler($xp, $element);
    }

    function cdataHandler($xp, $data)
    {
        parent::cdataHandler($xp, $data);

        switch ($this->element)
        {
            case 'plugin-install-contents-group':
                $this->aContents[$data] = $this->aData;
                break;
            case 'plugin-install-register-extension':
                $this->aExtensions[$this->aData['type']][$data] = $this->aData['group'];
                //$this->aData['name'] = $data;
                break;
        }
    }

}

?>
