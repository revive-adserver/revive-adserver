<?php

require_once(MAX_PATH . '/lib/OA/Upgrade/Migration.php');

class Migration_629 extends Migration
{
    public function __construct()
    {
        $this->aTaskList_constructive[] = 'beforeAddIndex__ad_zone_assoc__ad_zone_assoc_link_type';
        $this->aTaskList_constructive[] = 'afterAddIndex__ad_zone_assoc__ad_zone_assoc_link_type';
        $this->aTaskList_constructive[] = 'beforeAddIndex__banners__banners_storagetype_filename';
        $this->aTaskList_constructive[] = 'afterAddIndex__banners__banners_storagetype_filename';
    }



    public function beforeAddIndex__ad_zone_assoc__ad_zone_assoc_link_type()
    {
        return $this->beforeAddIndex('ad_zone_assoc', 'ad_zone_assoc_link_type');
    }

    public function afterAddIndex__ad_zone_assoc__ad_zone_assoc_link_type()
    {
        return $this->afterAddIndex('ad_zone_assoc', 'ad_zone_assoc_link_type');
    }

    public function beforeAddIndex__banners__banners_storagetype_filename()
    {
        return $this->beforeAddIndex('banners', 'banners_storagetype_filename');
    }

    public function afterAddIndex__banners__banners_storagetype_filename()
    {
        return $this->afterAddIndex('banners', 'banners_storagetype_filename');
    }
}
