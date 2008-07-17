<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
| For contact details, see: http://www.openx.org/                           |
|                                                                           |
| This program is free software; you can redistribute it and/or modify      |
| it under the terms of the GNU General Public License as published by      |
| the Free Software Foundation; either version 2 of the License, or         |
| (at your option) any later version.                                       |
|                                                                           |
| This program is distributed in the hope that it will be useful,           |
| but WITHOUT ANY WARRANTY; without even the implied warranty of            |
| MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             |
| GNU General Public License for more details.                              |
|                                                                           |
| You should have received a copy of the GNU General Public License         |
| along with this program; if not, write to the Free Software               |
| Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA |
+---------------------------------------------------------------------------+
$Id$
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
    function readLinksDotIni($file_links)
    {
        $links =& new Config();
        $root =& $links->parseConfig($file_links, 'inifile');
        if (PEAR::isError($root)) {
            $links = array();
        } else {
            $links = $root->toArray();
            $links = $links['root'];
            foreach ($links as $table => $link_array) {
                foreach ($link_array as $fk => $fv) {
                    $tmp = explode(':', $fv);
                    $links[$table][$fk] = array(
                        'table' => $tmp[0],
                        'field' => $tmp[1]
                    );
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
    function writeLinksDotIni($file_links, $link_array)
    {
        $links =& new Config();
        $root =& $links->parseConfig($file_links, 'inifile');
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

        $links =& new Config();
        $links->parseConfig($root, 'phparray');
        return $links->writeConfig($file_links, 'inifile');
    }

}

?>