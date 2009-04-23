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
$Id: postscript_install_Client.php 28622 2008-11-07 10:51:08Z monique.szpak $
*/

$className = 'postscript_install_Client';

/**
 * Migrates the old [logging][sniff] conf setting
 *
 * @package    Plugin
 * @subpackage openxDeliveryLimitations
 */
class postscript_install_Client
{

    /**
     *
     * @return boolean True
     */
    function execute()
    {
        if (isset($GLOBALS['_MAX']['CONF']['logging']['sniff']))
        {
            $value = $GLOBALS['_MAX']['CONF']['logging']['sniff'];
            unset($GLOBALS['_MAX']['CONF']['logging']['sniff']);

            $oSettings  = new OA_Admin_Settings();
            $oSettings->settingChange('Client','sniff',$value);
            $oSettings->writeConfigChange();
        }
        return true;
    }
}

?>