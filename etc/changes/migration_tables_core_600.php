<?php

require_once(MAX_PATH . '/lib/OA/Upgrade/Migration.php');

class Migration_600 extends Migration
{
    public function __construct()
    {
        //$this->__construct();

        $this->aTaskList_constructive[] = 'beforeAddField__banners__ext_bannertype';
        $this->aTaskList_constructive[] = 'afterAddField__banners__ext_bannertype';


        $this->aObjectMap['banners']['ext_bannertype'] = ['fromTable' => 'banners', 'fromField' => 'ext_bannertype'];
    }



    public function beforeAddField__banners__ext_bannertype()
    {
        return $this->beforeAddField('banners', 'ext_bannertype');
    }

    public function afterAddField__banners__ext_bannertype()
    {
        return $this->afterAddField('banners', 'ext_bannertype');
    }

    public function beforeRemoveTable__plugins_channel_delivery_assoc()
    {
        return $this->beforeRemoveTable('plugins_channel_delivery_assoc');
    }

    public function afterRemoveTable__plugins_channel_delivery_assoc()
    {
        return $this->afterRemoveTable('plugins_channel_delivery_assoc');
    }

    public function beforeRemoveTable__plugins_channel_delivery_domains()
    {
        return $this->beforeRemoveTable('plugins_channel_delivery_domains');
    }

    public function afterRemoveTable__plugins_channel_delivery_domains()
    {
        return $this->afterRemoveTable('plugins_channel_delivery_domains');
    }

    public function beforeRemoveTable__plugins_channel_delivery_rules()
    {
        return $this->beforeRemoveTable('plugins_channel_delivery_rules');
    }

    public function afterRemoveTable__plugins_channel_delivery_rules()
    {
        return $this->afterRemoveTable('plugins_channel_delivery_rules');
    }
}
