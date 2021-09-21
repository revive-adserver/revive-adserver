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

class OA_Admin_Section_Type_Filter
{
    public $oCurrentSection;

    public function __construct($oCurrentSection)
    {
        $this->oCurrentSection = $oCurrentSection;
    }


    public function accept($oSection)
    {
        $currentId = $this->oCurrentSection->getId();

        //if section is affixed show it only if it's active
        if ($oSection->isAffixed() || $oSection->isExclusive()) {
            return $oSection->getId() == $currentId;
        }

        //filter out other sections if current is exclusive
        return !$this->oCurrentSection->isExclusive();
    }
}
