<?php

/*---------------------------------------------------------------------------+
| Openads v${RELEASE_MAJOR_MINOR}                                                              |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2007 Openads Limited                                   |
| For contact details, see: http://www.openads.org/                         |
|                                                                           |
| Copyright (c) 2000-2003 the phpAdsNew developers                          |
| For contact details, see: http://www.phpadsnew.com/                       |
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
$Id:$
*/

/**
 * A class that deals with configuration settings for this group of components
 *
 */
class oxFile_processSettings
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
        if (isset($GLOBALS['oxFile_cachePath'])) {
            $storeSettings['cachePath'] = $GLOBALS['_MAX']['CONF']['oxFile']['cachePath'];
            $GLOBALS['_MAX']['CONF']['oxFile']['cachePath'] = $GLOBALS['oxFile_cachePath'];
        }
        
        // Use file plugin getStatus function to validate
        $oPlgOxFile = &OX_Component::factory('deliveryCacheStore', 'oxFile', 'oxFile');
        $result = $oPlgOxFile->getStatus();
        if ($result !== true) {
            $aErrorMessage[0] = $result;
            $result = false;
        }

        // Restore config values 
        foreach ($storeSettings as $key => $value) {
            $GLOBALS['_MAX']['CONF']['oxFile'][$key] = $value;
        }
        
        return $result;
    }
}


?>