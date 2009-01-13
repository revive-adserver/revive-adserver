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

$className = 'OX_postscript_install_testPlugin';


class OX_postscript_install_testPlugin
{

    function OX_postscript_install_testPlugin()
    {

    }

    function execute($aParams=array())
    {
        return $this->defaultData();
    }

    function defaultData()
    {
        $oManager = new OX_Plugin_ComponentGroupManager();
        if (!array_key_exists('testPlugin', $GLOBALS['_MAX']['CONF']['pluginGroupComponents']))
        {
            $oManager->disableComponentGroup('testPlugin');
        }
        $this->oManager->enableComponentGroup('testPlugin');

        $oTestPluginTable = OA_Dal::factoryDO('testplugin_table');
        if (!$oTestPluginTable)
        {
            OA::debug('Failed to instantiate DataObject for testplugin_table');
            return false;
        }

        $oTestPluginTable->myplugin_desc = 'Hello World';
        $aSettings[0]['data'] = $oTestPluginTable->insert();
        $aSettings[0]['section'] = 'myPlugin';
        $aSettings[0]['key'] = 'english';

        $oTestPluginTable->myplugin_desc = 'Hola Mundo';
        $aSettings[1]['data'] = $oTestPluginTable->insert();
        $aSettings[1]['section'] = 'myPlugin';
        $aSettings[1]['key'] = 'spanish';

        $oTestPluginTable->myplugin_desc = 'Look Simon, you\'re just making it up now';
        $aSettings[2]['data'] = $oTestPluginTable->insert();
        $aSettings[2]['section'] = 'myPlugin';
        $aSettings[2]['key'] = 'russian';

        $oManager->_registerSettings($aSettings);

        $oManager->disableComponentGroup('testPlugin');

        return true;
    }

}