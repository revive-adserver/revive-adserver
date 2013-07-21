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

require_once 'Zend/Exception.php';

class OX_Common_Exception extends Zend_Exception
{
    private $details;
    
    public function __construct($message, $code = 0, $details)
    {
        parent::__construct($message, $code);
        $this->details = $details;
    }
    
    public function getDetails()
    {
        return $this->details;
    }
}
