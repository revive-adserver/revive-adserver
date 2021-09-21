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

    public function __construct($id, $depends = [])
    {
        $this->id = $id;
        $this->depends = $depends;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getDependencies()
    {
        return $this->depends;
    }
}
