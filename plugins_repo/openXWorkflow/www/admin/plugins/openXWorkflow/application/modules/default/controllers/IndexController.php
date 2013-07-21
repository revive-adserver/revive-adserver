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

class IndexController 
    extends OX_UI_Controller_Index
{
    public function indexAction()
    {
         $this->forward("index", "zone", "workflow");
    }
} 
