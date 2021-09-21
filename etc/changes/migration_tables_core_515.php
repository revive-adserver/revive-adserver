<?php

/*
+---------------------------------------------------------------------------+
| Revive Adserver                                                           |
| http://www.revive-adserver.com                                            |
|                                                                           |
| Copyright: See the COPYRIGHT.txt file.                                    |
| License: GPLv2 or later, see the LICENSE.txt file.                        |
+---------------------------------------------------------------------------+
*/

require_once(MAX_PATH . '/lib/OA/Upgrade/Migration.php');

class Migration_515 extends Migration
{
    public function __construct()
    {
        $this->aTaskList_constructive[] = 'beforeAlterField__preference__gui_invocation_3rdparty_default';
        $this->aTaskList_constructive[] = 'afterAlterField__preference__gui_invocation_3rdparty_default';
    }

    public function beforeAlterField__preference__gui_invocation_3rdparty_default()
    {
        return $this->beforeAlterField('preference', 'gui_invocation_3rdparty_default');
    }

    public function afterAlterField__preference__gui_invocation_3rdparty_default()
    {
        return $this->afterAlterField('preference', 'gui_invocation_3rdparty_default');
    }
}
