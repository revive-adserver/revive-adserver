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
    public function validate(&$aErrorMessage)
    {
        // Store current values from config
        // overwrite it by tested ones
        $storeSettings = [];
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
