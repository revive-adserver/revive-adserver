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

/**
 * Event context object. Serves as a holder for the event data. Listeners of the
 * event may modify the context and caller will be able to get the results from it.
 *
 * @package    OpenXAdmin
 */
class OX_Admin_UI_Event_EventContext
{
    public $data;
    
    public function __construct($data = null)
    {
        $this->data = $data;
    }
}
