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

require_once MAX_PATH . '/lib/OA/Admin/UI.php';

class OA_Admin_UI_Search extends OA_Admin_UI
{
    public function __construct()
    {
        $this->oTpl = new OA_Admin_Template('layout/search.html');
    }

    public function showSearchHeader($keyword)
    {
        $this->oTpl->assign('keyword', $keyword);

        $this->showHeader(0);
    }
}
