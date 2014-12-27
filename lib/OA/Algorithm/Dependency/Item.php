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

class OA_Algorithm_Dependency_Item
{
    protected $id;
    protected $depends;

    function __construct($id, $depends = array())
    {
        $this->id = $id;
        $this->depends = $depends;
    }

    function getId()
    {
        return $this->id;
    }

    function getDependencies()
    {
        return $this->depends;
    }
}

?>