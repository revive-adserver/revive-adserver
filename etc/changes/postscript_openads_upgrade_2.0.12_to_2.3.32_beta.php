<?php

require_once MAX_PATH . '/lib/OA/Dal/Maintenance/Statistics/Factory.php';

class OA_UpgradePostscript
{

    function OA_UpgradePostscript()
    {

    }

    function execute()
    {
        return MAX_Maintenance_Priority::run();
    }

}

?>