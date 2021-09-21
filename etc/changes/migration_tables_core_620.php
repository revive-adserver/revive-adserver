<?php

require_once(MAX_PATH . '/lib/OA/Upgrade/Migration.php');

class Migration_620 extends Migration
{
    public function __construct()
    {
        $this->aTaskList_constructive[] = 'beforeAddField__banners__iframe_friendly';
        $this->aTaskList_constructive[] = 'afterAddField__banners__iframe_friendly';

        $this->aObjectMap['banners']['iframe_friendly'] = ['fromTable' => 'banners', 'fromField' => 'iframe_friendly'];
    }

    public function beforeAddField__banners__iframe_friendly()
    {
        return $this->beforeAddField('banners', 'iframe_friendly');
    }

    public function afterAddField__banners__iframe_friendly()
    {
        return $this->afterAddField('banners', 'iframe_friendly') && $this->unfriendlyText();
    }

    public function unfriendlyText()
    {
        $prefix = $this->getPrefix();

        $oDbh = OA_DB::singleton();
        return $oDbh->exec("UPDATE {$prefix}banners SET iframe_friendly = 0 WHERE storagetype = 'txt'");
    }
}
