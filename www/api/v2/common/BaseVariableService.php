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
 * @package    OpenX
 */

require_once MAX_PATH . '/www/api/v2/xmlrpc/VariableServiceImpl.php';

class BaseVariableService
{
    protected $oVariableServiceImpl;

    function __construct()
    {
        $this->oVariableServiceImpl = new VariableServiceImpl();
    }
}

?>
