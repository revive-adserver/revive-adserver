<?php

require_once(MAX_PATH . '/lib/OA/Upgrade/Migration.php');

class Migration_006 extends Migration
{
    public function __construct()
    {
        $this->aTaskList_destructive[] = 'beforeRemoveTable__ext_ap_video_vpaid';
        $this->aTaskList_destructive[] = 'afterRemoveTable__ext_ap_video_vpaid';
    }



    public function beforeRemoveTable__ext_ap_video_vpaid()
    {
        return $this->beforeRemoveTable('ext_ap_video_vpaid');
    }

    public function afterRemoveTable__ext_ap_video_vpaid()
    {
        return $this->afterRemoveTable('ext_ap_video_vpaid');
    }
}
