<?php

$className = 'prescript_tables_testplugin_002';

class prescript_tables_testplugin_002
{

    function prescript_tables_testplugin_002()
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