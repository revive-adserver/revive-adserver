<?php

require_once(MAX_PATH . '/lib/OA/Upgrade/Migration.php');

class Migration_999300 extends Migration
{
    public function __construct()
    {
        //$this->__construct();

        $this->aTaskList_constructive[] = 'beforeRenameField__astro__auto_renamed_field';
        $this->aTaskList_constructive[] = 'afterRenameField__astro__auto_renamed_field';

        $this->aObjectMap['astro']['auto_renamed_field'] = ['fromTable' => 'astro', 'fromField' => 'auto_field'];
    }



    public function beforeRenameField__astro__auto_renamed_field()
    {
        return $this->beforeRenameField('astro', 'auto_renamed_field');
    }

    public function afterRenameField__astro__auto_renamed_field()
    {
        return $this->afterRenameField('astro', 'auto_renamed_field');
    }
}
