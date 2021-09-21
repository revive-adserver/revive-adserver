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

/*
function phpAds_cacheDelete ($name='')
{
    // DO NOT ALLOW CACHE DELETION AS IT WOULD CAUSE IT TO BE STALE!
    return;
    if ($name != '') {
        $filename = 'cache-'.md5($name).'.php';
        if (file_exists(phpAds_path.'/cache/'.$filename)) {
            @unlink (phpAds_path.'/cache/'.$filename);
            return true;
        } else {
            return false;
        }
    } else {
        $cachedir = @opendir(phpAds_path.'/cache/');
        while (false !== ($filename = @readdir($cachedir))) {
            if (preg_match('#^cache-[0-9A-F]{32}.php$#i', $filename)) {
                @unlink (phpAds_path.'/cache/'.$filename);
            }
        }
        @closedir($cachedir);
        return true;
    }
}
*/

function phpAds_cacheInfo()
{
    $result = [];

    $cachedir = @opendir(phpAds_path . '/cache/');

    while (false !== ($filename = @readdir($cachedir))) {
        if (preg_match('#^cache-[0-9A-F]{32}.php$#i', $filename)) {
            $cache_complete = false;
            $cache_contents = '';
            $cache_name = '';

            @include(phpAds_path . '/cache/' . $filename);

            if ($cache_complete == true) {
                $result[$cache_name] = strlen(serialize($cache_contents));
            }
        }
    }

    @closedir($cachedir);

    return ($result);
}
