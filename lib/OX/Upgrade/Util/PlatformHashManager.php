<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                             |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                            |
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
$Id: PlatformHashManager.php 43664 2009-09-23 12:28:50Z lukasz.wikierski $
*/

/**
 * class responsible for getting platform hash before upgrade happens 
 *                               or generate one if it's fresh install
 * 
 * @package    OpenXUpgrade
 * @author     Lukasz Wikierski <lukasz.wikierski@openx.org>
 */
class OX_Upgrade_Util_PlatformHashManager
{
    /**
     * Special value of platformHash if we know that is upgrade process and can't retrive old platform hash
     * @var string
     */
    public static $UNKNOWN_PLATFORM_HASH = 'OXP_upgrade-unknown_platform_hash';
    
    /**
     * @var string generated Platform Hash by getPlatformHash method
     */
    private static $generatedPlatformHash; 
    
    
    /**
     * @var string founded Platform Hash used to cache response result
     */
    private static $foundPlatformHash;
    
    /**
     * Try to get platform hash.
     * If it's upgrade it try to read database (searches old config/preference tables)
     *  If this fails it returns 'OXP_upgrade-unknown_platform_hash'
     * If it's fresh install then it checks if there is already generated 
     * platformHash by previous call of this method, or use suggested one, or generate new one.
     * New platform hash is stored as already generated.  
     *
     * @param string $suggestedPlatformHash
     * @param boolean $forceCheck should check be done once again (or we can use cached results) 
     * @return string platform Hash
     */
    public function getPlatformHash($suggestedPlatformHash = null, $forceCheck = false)
    {
        if (!$forceCheck && isset(self::$foundPlatformHash)) {
            return self::$foundPlatformHash;
        }
        // is it upgrade?
        $oUpgrader = new OA_Upgrade();
        if (!$oUpgrader->isFreshInstall()) {
            // YES:
            // prepare database connection data
            $oUpgrader->canUpgradeOrInstall(); 
            $oUpgrader->initDatabaseConnection();
            // try read platform hash from database (3 possible locations)
            $platformHash = $this->readPlatformHashFromDatabase();
            // if can't find platformHash - set 'OXP_upgrade-unknown_platform_hash'
            $platformHash = ($platformHash) ? $platformHash : self::$UNKNOWN_PLATFORM_HASH; 
        } else {
            // NO:
            // is already set generatedPlatformHash
            if (isset(self::$generatedPlatformHash)) {
                $platformHash = self::$generatedPlatformHash; 
            } else {
                // use sugested or generate new one (and remember)
                if (isset($suggestedPlatformHash)) {
                    $platformHash = $suggestedPlatformHash;
                } else {
                    $platformHash = OA_Dal_ApplicationVariables::generatePlatformHash();
                }
                // remember genereted platform hash
                self::$generatedPlatformHash = $platformHash;
            }
        }
        self::$foundPlatformHash = $platformHash;
        return $platformHash;
    }
    

    /**
     * It's helper method that is querying database for platform hash
     * It's seraches application_variables, preference and config tables
     * 
     * @return string|bool platformHash or false if couldn't finde platformhash
     */
    protected function readPlatformHashFromDatabase()
    {
        $oDbh = OA_DB::singleton();
        if (isset($oDbh) && !PEAR::isError($oDbh))
        {
            $prefix  = $GLOBALS['_MAX']['CONF']['table']['prefix'];
            $tblAppVar = $oDbh->quoteIdentifier($prefix.'application_variable', true);
            $tblPref   = $oDbh->quoteIdentifier($prefix.'preference', true);
            $tblConfig = $oDbh->quoteIdentifier($prefix.'config', true);
            // try to get platform_hash (application_variable) then
            // try to get instance_id (prefence table) then
            // try to get instance_id (config table (oldest))
            $querys = array (
                0 => "SELECT value
                      FROM {$tblAppVar}
                      WHERE name = 'platform_hash'",
                1 => "SELECT instance_id
                      FROM {$tblPref}
                      WHERE agencyid = 0",
                2 => "SELECT instance_id
                      FROM {$tblConfig}"
            );
            foreach ($querys as $query) {
                PEAR::pushErrorHandling(null);            
                $platformHash = $oDbh->queryOne($query);
                PEAR::popErrorHandling();
                if (!PEAR::isError($platformHash) && !empty($platformHash))
                {
                   return $platformHash;
                }
            }
        }
        return false;
    }
}