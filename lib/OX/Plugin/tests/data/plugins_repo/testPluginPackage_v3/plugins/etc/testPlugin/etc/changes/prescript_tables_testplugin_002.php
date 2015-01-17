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

    function __construct()
    {

    }

    function execute_constructive($aParams=array())
    {
        $oManager = new OX_Plugin_ComponentGroupManager();
        $oManager->_logMessage('testPluginPackage 0.0.3 : '. get_class($this).' execute constructive');
        return true;
    }

    function execute_destructive($aParams=array())
    {
        $oManager = new OX_Plugin_ComponentGroupManager();
        $oManager->_logMessage('testPluginPackage 0.0.3 : '. get_class($this).' execute destructive');
        return true;
    }}

?>