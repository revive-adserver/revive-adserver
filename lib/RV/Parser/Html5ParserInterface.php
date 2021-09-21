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

namespace RV\Parser;

interface Html5ParserInterface
{
    /**
     * Returns width and height as array, or null if none found.
     *
     * @param string $html
     *
     * @return array|null
     */
    public function parseSize($html);
}
