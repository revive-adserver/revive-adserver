<?php


$className = 'postscript_install_vastInlineBannerTypeHtml';

require_once LIB_PATH . '/Extension/deliveryLog/Setup.php';

class postscript_install_vastInlineBannerTypeHtml
{

    /**
     * @return boolean True
     */
    function execute()
    {
        $oSettings  = new OA_Admin_Settings();
        $oSettings->settingChange('allowedBanners','video','1');
        $oSettings->writeConfigChange();
        return true;
    }
}

?>
