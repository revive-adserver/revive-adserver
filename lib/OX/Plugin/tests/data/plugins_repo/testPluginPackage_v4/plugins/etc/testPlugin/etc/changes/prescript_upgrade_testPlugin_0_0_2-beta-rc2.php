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

$className = 'prescript_upgrade_testPlugin_0_0_2_beta_rc2';


class prescript_upgrade_testPlugin_0_0_2_beta_rc2
{

    function __construct()
    {

    }

    function execute($aParams=array())
    {
        $oManager = new OX_Plugin_ComponentGroupManager();
        $oManager->_logMessage('testPluginPackage 0.0.3 : '. get_class($this));
        return true;
    }
}