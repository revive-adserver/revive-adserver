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
 * A class to deal with uploaded creatives
 *
 */
class OA_Creative
{
    public $contentType;
    public $width;
    public $height;
    public $content;
    public $name;

    /**
     * Class constructor
     *
     * @param string $creativeName
     * @param string $fileName
     * @return OA_Creative
     */
    public function __construct($contentType, $width = 0, $height = 0, $content = '')
    {
        $this->contentType = $contentType;
        $this->width = $contentType;
        $this->height = $contentType;
        $this->content = $contentType;
    }
}
