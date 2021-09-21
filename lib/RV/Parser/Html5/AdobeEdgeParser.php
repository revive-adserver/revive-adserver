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

class AdobeEdgeParser implements Html5ParserInterface
{
    public function parseSize($html)
    {
        if (preg_match('#AdobeEdge.loadComposition\([^{]+\{.*width:\s*"(\d+)px".*height:\s*"(\d+)px"#s', $html, $m)) {
            return [(int) $m[1], (int) $m[2]];
        }

        return null;
    }
}
