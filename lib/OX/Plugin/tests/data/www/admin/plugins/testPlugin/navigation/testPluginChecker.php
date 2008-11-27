<?php
require_once(MAX_PATH . '/lib/OA/Admin/Menu/IChecker.php');

class Plugins_Admin_TestPlugin_TestPluginChecker 
    implements OA_Admin_Menu_IChecker
{
    public function check($oSection) 
    {
        return true;
    }
}

?>