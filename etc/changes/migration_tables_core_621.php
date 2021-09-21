<?php

require_once(MAX_PATH . '/lib/OA/Upgrade/Migration.php');

class Migration_621 extends Migration
{
    public function __construct()
    {
        $this->aTaskList_constructive[] = 'beforeAlterField__banners__htmltemplate';
        $this->aTaskList_constructive[] = 'afterAlterField__banners__htmltemplate';
        $this->aTaskList_constructive[] = 'beforeAlterField__banners__htmlcache';
        $this->aTaskList_constructive[] = 'afterAlterField__banners__htmlcache';
    }



    public function beforeAlterField__banners__htmltemplate()
    {
        return $this->beforeAlterField('banners', 'htmltemplate');
    }

    public function afterAlterField__banners__htmltemplate()
    {
        return $this->afterAlterField('banners', 'htmltemplate');
    }

    public function beforeAlterField__banners__htmlcache()
    {
        return $this->beforeAlterField('banners', 'htmlcache');
    }

    public function afterAlterField__banners__htmlcache()
    {
        return $this->afterAlterField('banners', 'htmlcache');
    }
}
