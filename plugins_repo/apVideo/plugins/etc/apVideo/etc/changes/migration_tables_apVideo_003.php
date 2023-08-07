<?php

require_once(MAX_PATH . '/lib/OA/Upgrade/Migration.php');

class Migration_003 extends Migration
{
    public function Migration_003()
    {
        //$this->__construct();

        $this->aTaskList_constructive[] = 'beforeAddTable__ext_ap_video';
        $this->aTaskList_constructive[] = 'afterAddTable__ext_ap_video';
    }



    public function beforeAddTable__ext_ap_video()
    {
        return $this->beforeAddTable('ext_ap_video');
    }

    public function afterAddTable__ext_ap_video()
    {
        return $this->afterAddTable('ext_ap_video');
    }
}
