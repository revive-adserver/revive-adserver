<?php

require_once(MAX_PATH . '/lib/OA/Upgrade/Migration.php');

class Migration_004 extends Migration
{
    public function Migration_004()
    {
        //$this->__construct();

        $this->aTaskList_constructive[] = 'beforeAddField__ext_ap_video_vpaid__pn_pos';
        $this->aTaskList_constructive[] = 'afterAddField__ext_ap_video_vpaid__pn_pos';
        $this->aTaskList_constructive[] = 'beforeAddField__ext_ap_video_vpaid__pn_url';
        $this->aTaskList_constructive[] = 'afterAddField__ext_ap_video_vpaid__pn_url';
        $this->aTaskList_constructive[] = 'beforeAddField__ext_ap_video_vpaid__ig_pos';
        $this->aTaskList_constructive[] = 'afterAddField__ext_ap_video_vpaid__ig_pos';
        $this->aTaskList_constructive[] = 'beforeAddField__ext_ap_video_vpaid__ig_url';
        $this->aTaskList_constructive[] = 'afterAddField__ext_ap_video_vpaid__ig_url';


        $this->aObjectMap['ext_ap_video_vpaid']['pn_pos'] = ['fromTable' => 'ext_ap_video_vpaid', 'fromField' => 'pn_pos'];
        $this->aObjectMap['ext_ap_video_vpaid']['pn_url'] = ['fromTable' => 'ext_ap_video_vpaid', 'fromField' => 'pn_url'];
        $this->aObjectMap['ext_ap_video_vpaid']['ig_pos'] = ['fromTable' => 'ext_ap_video_vpaid', 'fromField' => 'ig_pos'];
        $this->aObjectMap['ext_ap_video_vpaid']['ig_url'] = ['fromTable' => 'ext_ap_video_vpaid', 'fromField' => 'ig_url'];
    }



    public function beforeAddField__ext_ap_video_vpaid__pn_pos()
    {
        return $this->beforeAddField('ext_ap_video_vpaid', 'pn_pos');
    }

    public function afterAddField__ext_ap_video_vpaid__pn_pos()
    {
        return $this->afterAddField('ext_ap_video_vpaid', 'pn_pos');
    }

    public function beforeAddField__ext_ap_video_vpaid__pn_url()
    {
        return $this->beforeAddField('ext_ap_video_vpaid', 'pn_url');
    }

    public function afterAddField__ext_ap_video_vpaid__pn_url()
    {
        return $this->afterAddField('ext_ap_video_vpaid', 'pn_url');
    }

    public function beforeAddField__ext_ap_video_vpaid__ig_pos()
    {
        return $this->beforeAddField('ext_ap_video_vpaid', 'ig_pos');
    }

    public function afterAddField__ext_ap_video_vpaid__ig_pos()
    {
        return $this->afterAddField('ext_ap_video_vpaid', 'ig_pos');
    }

    public function beforeAddField__ext_ap_video_vpaid__ig_url()
    {
        return $this->beforeAddField('ext_ap_video_vpaid', 'ig_url');
    }

    public function afterAddField__ext_ap_video_vpaid__ig_url()
    {
        return $this->migrateUrl() && $this->afterAddField('ext_ap_video_vpaid', 'ig_url');
    }

    public function migrateUrl()
    {
        $tblBanners = $this->_getQuotedTableName('banners');
        $this->oDBH->exec("UPDATE {$tblBanners} SET url = imageurl WHERE ext_bannertype = 'bannerTypeHtml:apVideo:Network'");
        $this->oDBH->exec("UPDATE {$tblBanners} SET imageurl = '' WHERE ext_bannertype = 'bannerTypeHtml:apVideo:Network'");
        return true;
    }
}
