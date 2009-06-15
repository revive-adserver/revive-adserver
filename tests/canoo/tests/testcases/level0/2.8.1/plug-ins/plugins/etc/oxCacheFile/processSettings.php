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
$Id: processSettings.php 30820 2009-01-13 19:02:17Z andrew.hill $
*/

/**
 * A class that deals with configuration settings for this group of components
 *
 */
class oxCacheFile_processSettings
{

    /**
     * Method that is called on settings form submission
     * Error messages are appended to the 0 index of the array
     *
     * @return boolean
     */
    function validate(&$aErrorMessage)
    {
        // Store current values from config
        // overwrite it by tested ones
        $storeSettings = array();
        if (isset($GLOBALS['oxCacheFile_cachePath'])) {
            $storeSettings['cachePath'] = $GLOBALS['_MAX']['CONF']['oxCacheFile']['cachePath'];
            $GLOBALS['_MAX']['CONF']['oxCacheFile']['cachePath'] = $GLOBALS['oxCacheFile_cachePath'];
        }

        // Use file plugin getStatus function to validate
        $oPlgoxCacheFile = &OX_Component::factory('deliveryCacheStore', 'oxCacheFile', 'oxCacheFile');
        $result = $oPlgoxCacheFile->getStatus();
        if ($result !== true) {
            $aErrorMessage[0] = $result;
            $result = false;
        }

        // Restore config values
        foreach ($storeSettings as $key => $value) {
            $GLOBALS['_MAX']['CONF']['oxCacheFile'][$key] = $value;
        }

        return $result;
    }
}


?>