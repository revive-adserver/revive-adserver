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

$className = 'OX_postscript_testPlugin';


class OX_postscript_testPlugin
{

    function __construct()
    {

    }

    function execute($aParams=array())
    {
        return $this->defaultData();
    }

    function defaultData()
    {
        $oManager = new OX_Plugin_ComponentGroupManager();

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

        return true;
    }

}