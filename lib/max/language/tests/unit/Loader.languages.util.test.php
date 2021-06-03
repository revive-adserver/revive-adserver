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

require_once(MAX_PATH . '/lib/max/language/Loader.php');

class MAX_Language_LoaderTest extends UnitTestCase
{
    function testLoad()
    {
        $PRODUCT_NAME = $PRODUCT_DOCSURL = 'FOO';

        //prepare expected value
        include MAX_PATH . '/lib/max/language/en/default.lang.php';
        $aExpected['en']['default']['strHome'] = $GLOBALS['strHome'];
        include MAX_PATH . '/lib/max/language/pl/default.lang.php';
        $aExpected['pl']['default']['strHome'] = $GLOBALS['strHome'];
        include MAX_PATH . '/lib/max/language/ru/default.lang.php';
        $aExpected['ru']['default']['strHome'] = $GLOBALS['strHome'];
        
        include MAX_PATH . '/lib/max/language/ko/settings.lang.php';
        $aExpected['ko']['settings']['strInstall'] = $GLOBALS['strInstall'];
        include MAX_PATH . '/lib/max/language/en/settings.lang.php';
        $aExpected['en']['settings']['strInstall'] = $GLOBALS['strInstall'];
        include MAX_PATH . '/lib/max/language/de/settings.lang.php';
        $aExpected['de']['settings']['strInstall'] = $GLOBALS['strInstall'];
        include MAX_PATH . '/lib/max/language/pl/settings.lang.php';
        $aExpected['pl']['settings']['strInstall'] = $GLOBALS['strInstall'];
        
        unset($GLOBALS['strHome']);
        unset($GLOBALS['strInstall']);
        
        // Try to load file that not exist 
        Language_Loader::load('notexist');
        $this->assertFalse(isset($GLOBALS['strHome']));
        
        // Test default load when empty $GLOBALS['_MAX']['CONF'] and  $GLOBALS['_MAX']['PREF']
        Language_Loader::load();       
        $this->assertEqual($aExpected['en']['default']['strHome'], $GLOBALS['strHome']);
        
        // Test load language file by user pref settings 
        $GLOBALS['_MAX']['PREF']['language'] = 'pl';
        Language_Loader::load();
        $this->assertEqual($aExpected['pl']['default']['strHome'], $GLOBALS['strHome']);

        // Test load language file by parameter (overwriting user pref settings)
        Language_Loader::load('default','ru');
        $this->assertEqual($aExpected['ru']['default']['strHome'], $GLOBALS['strHome']);
        
        // Test load 'en' again (detect problems with switching languages back)
        Language_Loader::load('default','en');
        $this->assertEqual($aExpected['en']['default']['strHome'], $GLOBALS['strHome']);
        
        // Test load language file by config settings when user language file not exist
        unset($GLOBALS['strHome']);
        unset($GLOBALS['strInstall']); 
        $GLOBALS['_MAX']['PREF']['language'] = 'xyz';
        $GLOBALS['_MAX']['CONF']['max']['language'] = 'ko';
        Language_Loader::load('settings');
        $this->assertEqual($aExpected['ko']['settings']['strInstall'], $GLOBALS['strInstall']);
        
        // Test that language is loaded based on user preferences
        unset($GLOBALS['strInstall']);
        $GLOBALS['_MAX']['PREF']['language'] = 'de';
        $GLOBALS['_MAX']['CONF']['max']['language'] = 'polish';
        Language_Loader::load('settings');
        $this->assertEqual($aExpected['de']['settings']['strInstall'], $GLOBALS['strInstall']);
        
        // Test that language is loaded based on config file and laguage name is long (like in 2.4)  
        unset($GLOBALS['strInstall']);
        unset($GLOBALS['_MAX']['PREF']['language']);
        $GLOBALS['_MAX']['CONF']['max']['language'] = 'polish';
        Language_Loader::load('settings');
        $this->assertEqual($aExpected['pl']['settings']['strInstall'], $GLOBALS['strInstall']);
        
        // Test load language by PREF setting, CONF should be ignored
        $GLOBALS['_MAX']['PREF']['language'] = 'de';
        Language_Loader::load('settings');
        $this->assertEqual($aExpected['de']['settings']['strInstall'], $GLOBALS['strInstall']);
        // Test load language by parameter, PREF and CONF setting should be ignored
        Language_Loader::load('settings','en');
        $this->assertEqual($aExpected['en']['settings']['strInstall'], $GLOBALS['strInstall']);
    }
}
?>