<?php

require_once(MAX_PATH . '/lib/OA/Upgrade/Migration.php');

class Migration_002 extends Migration
{
    public function Migration_002()
    {
        //$this->__construct();

        $this->aTaskList_constructive[] = 'beforeAddField__ext_ap_video_vpaid__swf_pos';
        $this->aTaskList_constructive[] = 'afterAddField__ext_ap_video_vpaid__swf_pos';
        $this->aTaskList_constructive[] = 'beforeAddField__ext_ap_video_vpaid__swf_url';
        $this->aTaskList_constructive[] = 'afterAddField__ext_ap_video_vpaid__swf_url';


        $this->aObjectMap['ext_ap_video_vpaid']['swf_pos'] = ['fromTable' => 'ext_ap_video_vpaid', 'fromField' => 'swf_pos'];
        $this->aObjectMap['ext_ap_video_vpaid']['swf_url'] = ['fromTable' => 'ext_ap_video_vpaid', 'fromField' => 'swf_url'];
    }



    public function beforeAddField__ext_ap_video_vpaid__swf_pos()
    {
        return $this->beforeAddField('ext_ap_video_vpaid', 'swf_pos');
    }

    public function afterAddField__ext_ap_video_vpaid__swf_pos()
    {
        return $this->afterAddField('ext_ap_video_vpaid', 'swf_pos');
    }

    public function beforeAddField__ext_ap_video_vpaid__swf_url()
    {
        return $this->beforeAddField('ext_ap_video_vpaid', 'swf_url');
    }

    public function afterAddField__ext_ap_video_vpaid__swf_url()
    {
        return $this->afterAddField('ext_ap_video_vpaid', 'swf_url');
    }
}
