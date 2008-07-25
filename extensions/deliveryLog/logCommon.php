<?php

require_once MAX_PATH . '/lib/OX/Plugin/Component.php';

abstract class Plugins_DeliveryLog_LogCommon extends OX_Component
{
    abstract function getDependencies();

    /**
     * Can carry on any additional post-installs actions
     * (for example install postgres specific stored procedures)
     *
     * @return boolean  True on success otherwise false
     */
    public function postInstall()
    {
        return true;
    }
    
    abstract function getBucketName();
}

?>