<?php

require_once LIB_PATH.'/Plugin/Component.php';

class Plugins_Admin_demoUserInterface_demoUserInterface extends OX_Component
{

    function afterLogin()
    {
        global $userLoggedIn;
        $userLoggedIn = true;
        return true;
    }

}

?>