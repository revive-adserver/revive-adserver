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
$Id: DB.php 19839 2008-05-05 12:29:50Z matteo.beccati@openx.org $
*/


/**
 * A class for managing configuration options
 *
 * @package    OpenXConfig
 * @author     Alexander J Tarachanowicz II <aj.tarachanowicz@openx.org>
 */

class OX_Common_Config extends Zend_Config_Ini
{
    private static $instance;
    
    private static $defaultConfigFile;

    /**
     * Caches values of Zend_Locale::getTranslationList() calls within the same request.
     * 
     * @var array(localeVariable => array(values))
     */
    private static $translationLists = array();

    public function __construct($file, $section, $options)
    {
        parent::__construct($file, $section, $options);
    }


    /**
     * @return OX_Common_Config
     */
    public static function instance($section = null, $file = null, $option = null, $forceReload = false)
    {
        $key = md5($file . $section . $option);
        if (!isset(self::$instance[$key]) || $forceReload) {
            if (is_null($file)) {
                $file = self::$defaultConfigFile; //get default
                if(is_null($file)) {
                    $file = VAR_PATH.'/config.php'; //falback to hardcoded one
                }
            }
            if (file_exists($file)) {
                $class = __CLASS__;
                self::$instance[$key] = new $class($file, $section, $option);
            }
            else {
                throw new Exception('The specified config file does not exist.');
            }
        }
        return self::$instance[$key];
    }
    
    
    public static function setDefaultConfigFile($fileName)
    {
        self::$defaultConfigFile = $fileName;
    }


    public function getSection($sectionId)
    {
        if (isset($this->$sectionId)) {
            return $this->$sectionId;
        }
        return false;
    }


    public static function isProductionMode()
    {
        return OX_Common_Config::instance('application')->get('production');
    }


    public static function isCombineAssets()
    {
        return OX_Common_Config::instance('ui')->get('combineAssets');
    }

    public static function isDebugTranslations()
    {
        return OX_Common_Config::instance('ui')->get('debugTranslations');
    }

    public static function useSessionClustering()
    {
        return OX_Common_Config::instance('application')->get('sessionClustering');
    }


    public static function getApplicationVersion()
    {
        return OX_Common_Config::instance('application')->get('version');
    }
    
    


    public static function getUiDateFormat($variant = 'medium')
    {
        return self::getLocaleTranslation('Date', $variant);
    }


    public static function getUiTimeFormat($variant = 'medium')
    {
        return self::getLocaleTranslation('Time', $variant);
    }

    public static function getDecimalSeparator()
    {
        return self::getLocaleTranslation('symbols', 'decimal');
    }

    private static function getLocaleTranslation($variable, $variant)
    {
        $formats = null;
        if (isset(self::$translationLists[$variable]))
        {
            $formats = self::$translationLists[$variable];
        }
        else 
        {
            $formats = Zend_Locale::getTranslationList($variable);
            self::$translationLists[$variable] = $formats;
        }
        return isset($formats[$variant]) ? $formats[$variant] : $formats['medium'];
    }


    public static function initLocale()
    {
        $locale = new Zend_Locale(self::instance('ui')->get('locale'));
        Zend_Locale::setDefault($locale->toString());
        Zend_Registry::set('Zend_Locale', $locale->toString());
        
        Zend_Locale::setCache(Zend_Cache::factory('Core',
                             'File',
                             array(
                                'lifetime' => null,
                                'cache_id_prefix' => 'loc'
                             ),
                             array(
                                'cache_dir' => CACHE_PATH 
                             )));
    }


    public function __clone()
    {
        trigger_error('Clone is not allowed.', E_USER_ERROR);
    }
}