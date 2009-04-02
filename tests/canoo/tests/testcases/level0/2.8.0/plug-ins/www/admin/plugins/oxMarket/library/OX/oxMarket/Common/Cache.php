<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2009 OpenX Limited                                     |
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
$Id: Cache.php 34116 2009-03-23 10:41:43Z lukasz.wikierski $
*/

require_once MAX_PATH . '/lib/OA/Cache.php';

/**
 * A extension to OA_Cache class that allows to define cache life time
 * and alternative cacheDir
 *
 */
class OX_oxMarket_Common_Cache extends OA_Cache
{

    /**
     * Class constructor
     *
     * @param string $id
     * @param string $group
     * @param int $lifeTime
     * @param string $cacheDir
     * @return OA_Cache
     */
    function __construct($id, $group, $lifeTime = null, $cacheDir = null)
    {
        if (!isset($cacheDir)) {
            $cacheDir = MAX_PATH . '/var/cache/';
        }
        $this->oCache = &new Cache_Lite(array(
            'cacheDir'                      => $cacheDir,
            'lifeTime'                      => $lifeTime,
            'readControlType'               => 'md5',
            'automaticSerialization'        => true
        ));

        $this->id    = $id;
        $this->group = $group;
    }

}

?>