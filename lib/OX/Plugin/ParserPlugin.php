<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2009 OpenX Limited                                     |
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

require_once LIB_PATH.'/Plugin/ParserBase.php';

/**
 * Parses an XML plugin install file
 *
 * @package OpenXPlugin
 * @author  Monique Szpak <monique.szpak@openx.org>
 */
class OX_ParserPlugin extends OX_ParserBase
{

    var $aContents = array();

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
            case 'plugin-install-contents':
                $this->aContents = array();
                break;
        }
    }

    function endHandler($xp, $element)
    {

        switch ($this->element)
        {
            case 'plugin':
                $this->aInstall['contents']   = $this->aContents;
                break;
        }

        parent::endHandler($xp, $element);
    }

    function cdataHandler($xp, $data)
    {
        parent::cdataHandler($xp, $data);

        switch ($this->element)
        {
            case 'plugin-name':
                $this->aAllFiles[] = array('name'=>$data.'.xml', 'path'=>OX_PLUGIN_PLUGINPATH);
                break;
            case 'plugin-install-contents-group':
                $this->aContents[$data] = $this->aData;
                break;
        }
    }

}

?>
