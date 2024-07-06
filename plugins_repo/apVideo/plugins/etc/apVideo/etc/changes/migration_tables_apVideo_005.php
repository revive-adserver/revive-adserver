<?php

require_once(MAX_PATH . '/lib/OA/Upgrade/Migration.php');

class Migration_005 extends Migration
{
    public function __construct()
    {
        $this->aTaskList_constructive[] = 'beforeAddField__ext_ap_video__impression_trackers';
        $this->aTaskList_constructive[] = 'afterAddField__ext_ap_video__impression_trackers';


        $this->aObjectMap['ext_ap_video']['impression_trackers'] = ['fromTable' => 'ext_ap_video', 'fromField' => 'impression_trackers'];
    }



    public function beforeAddField__ext_ap_video__impression_trackers()
    {
        return $this->beforeAddField('ext_ap_video', 'impression_trackers');
    }

    public function afterAddField__ext_ap_video__impression_trackers()
    {
        return $this->afterAddField('ext_ap_video', 'impression_trackers');
    }
}
