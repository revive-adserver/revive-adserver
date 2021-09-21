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
 * An object used to decide whether a section meets the criteria defined by checker
 */
interface OA_Admin_Menu_IChecker
{
    /**
     * Returns true if the given section meets the criteria defined in the checker.
     * Eg. may be used to decide whether the section could be shown depending on
     * the account type, permissions, or request values.
     *
     * @param OA_Admin_Menu_Section $oSection
     */
    public function check($oSection);
}
