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

require_once MAX_PATH . '/lib/OA/Admin/Menu/IChecker.php';

abstract class Plugins_admin_apVideoUI_CachingChecker implements OA_Admin_Menu_IChecker
{
    protected static $cache;

    final public function check($oSection)
    {
        $key = $this->getCacheKey($oSection);

        $cacheKey = "{$oSection->id}-{$key}";

        if (!isset(static::$cache[$cacheKey])) {
            static::$cache[$cacheKey] = $this->_check($oSection, $key);
        }

        return static::$cache[$cacheKey];
    }

    abstract protected function getCacheKey($oSection): string;

    abstract protected function _check($oSection, $key): bool;
}
