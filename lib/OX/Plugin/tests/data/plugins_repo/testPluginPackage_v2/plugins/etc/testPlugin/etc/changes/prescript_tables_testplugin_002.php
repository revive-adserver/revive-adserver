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

$className = 'prescript_tables_testplugin_002';

class prescript_tables_testplugin_002
{
    public function __construct() {}

    public function execute_constructive($aParams = [])
    {
        $oManager = new OX_Plugin_ComponentGroupManager();
        $oManager->_logMessage('testPluginPackage 0.0.2 : ' . get_class($this) . ' execute constructive');
        return true;
    }

    public function execute_destructive($aParams = [])
    {
        $oManager = new OX_Plugin_ComponentGroupManager();
        $oManager->_logMessage('testPluginPackage 0.0.2 : ' . get_class($this) . ' execute destructive');
        return true;
    }
}
