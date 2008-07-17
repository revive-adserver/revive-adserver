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

require_once(MAX_PATH . '/lib/max/language/Loader.php');

class MAX_Language_LoaderTest extends UnitTestCase
{
    function testLoad()
    {
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
        $this->assertNull($GLOBALS['strHome']);
        
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