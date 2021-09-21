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

require_once 'Config.php';

/**
 * A class to deal with DataObjects .links.ini files.
 */
class Openads_Links
{
    /**
     * A method to read and parse the .links.ini file.
     *
     * @param string $file_links The path to the .links.ini file.
     * @return array The linked tables array, i.e:
     *
     *  Array
     *  (
     *      [acls] => Array
     *          (
     *              [bannerid] => Array
     *                  (
     *                      [table] => banners
     *                      [field] => bannerid
     *                  )
     *
     *          )
     *  )
     *
     */
    public static function readLinksDotIni($file_links)
    {
        $links = new Config();
        $root = &$links->parseConfig($file_links, 'inifile');
        if (PEAR::isError($root)) {
            $links = [];
        } else {
            $links = $root->toArray();
            $links = $links['root'];
            foreach ($links as $table => $link_array) {
                foreach ($link_array as $fk => $fv) {
                    $tmp = explode(':', $fv);
                    $links[$table][$fk] = [
                        'table' => $tmp[0],
                        'field' => $tmp[1]
                    ];
                }
            }
        }

        return $links;
    }

    /**
     * A method to write a .links.ini file.
     *
     * @param string $file_links The path to the .links.ini file.
     * @param array  $link_array An array of all the links
     * @return mixed PEAR_Error on error or true if ok.
     *
     *  Array
     *  (
     *      [acls] => Array
     *          (
     *              [bannerid] => Array
     *                  (
     *                      [table] => banners
     *                      [field] => bannerid
     *                  )
     *
     *          )
     *
     *  )
     *
     * or
     *
     *  Array
     *  (
     *      [acls] => Array
     *          (
     *              [bannerid] => banners:bannerid
     *
     *          )
     *
     *  )
     *
     */
    public static function writeLinksDotIni($file_links, $link_array)
    {
        $links = new Config();
        $root = &$links->parseConfig($file_links, 'inifile');
        $root = $root->toArray();
        $root = $root['root'];

        foreach ($link_array as $table => $array) {
            foreach ($array as $k => $v) {
                if (is_array($v)) {
                    $array[$k] = "{$v['table']}:{$v['field']}";
                }
            }

            if (count($array)) {
                $root[$table] = $array;
            } else {
                unset($root[$table]);
            }
        }

        ksort($root);

        $links = new Config();
        $links->parseConfig($root, 'phparray');
        return $links->writeConfig($file_links, 'inifile');
    }
}
