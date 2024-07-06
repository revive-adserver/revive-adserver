<?php

$className = 'OA_UpgradePostscript_apVideo_1_4_4_rc2';

require_once MAX_PATH . '/lib/OA/DB.php';
require_once MAX_PATH . '/lib/OA/Upgrade/Migration.php';

class OA_UpgradePostscript_apVideo_1_4_4_rc2 extends Migration
{
    public function execute()
    {
        $this->oDBH = OA_DB::singleton();

        $tblBanners = $this->_getQuotedTableName('banners');
        $this->oDBH->exec("UPDATE {$tblBanners} SET bannertext = url WHERE ext_bannertype = 'bannerTypeHtml:apVideo:Network'");
        $this->oDBH->exec("UPDATE {$tblBanners} SET url = '' WHERE ext_bannertype = 'bannerTypeHtml:apVideo:Network'");

        return true;
    }
}
