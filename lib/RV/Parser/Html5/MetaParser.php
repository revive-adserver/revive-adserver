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

namespace RV\Parser\Html5;

use RV\Parser\Html5ParserInterface;

class MetaParser implements Html5ParserInterface
{
    public function parseSize($html)
    {
        if (preg_match('#<meta\s+name="ad.size"\s+content="width=(\d+),\s*height=(\d+)"#i', $html, $m)) {
            return [(int) $m[1], (int) $m[2]];
        }

        return null;
    }
}