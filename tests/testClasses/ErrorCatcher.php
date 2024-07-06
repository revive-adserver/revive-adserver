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

class SimpletestErrorCatcher
{
    public $oRunner;
    public $active = true;

    public function __construct($oRunner)
    {
        $this->oRunner = $oRunner;
        ob_start();
        register_shutdown_function([$this, 'shutdown']);
    }

    public function deactivate()
    {
        $this->active = false;
        ob_end_flush();
    }

    public function shutdown()
    {
        if ($this->active) {
            $buffer = ob_get_clean();
            if (strlen($buffer)) {
                echo $buffer;
                die(1);
            }
        }
    }
}
