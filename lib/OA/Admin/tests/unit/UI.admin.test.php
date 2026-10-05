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

require_once MAX_PATH . '/lib/OA/Admin/UI.php';

class Test_OA_Admin_UI_CalendarTranslation extends UnitTestCase
{
    private $originalPreferenceLanguage;
    private $hadPreferenceLanguage;
    private $originalConfigLanguage;
    private $hadConfigLanguage;

    public function setUp()
    {
        $this->hadPreferenceLanguage = isset($GLOBALS['_MAX']['PREF']['language']);
        $this->originalPreferenceLanguage = $GLOBALS['_MAX']['PREF']['language'] ?? null;
        $this->hadConfigLanguage = isset($GLOBALS['_MAX']['CONF']['max']['language']);
        $this->originalConfigLanguage = $GLOBALS['_MAX']['CONF']['max']['language'] ?? null;
    }

    public function tearDown()
    {
        if ($this->hadPreferenceLanguage) {
            $GLOBALS['_MAX']['PREF']['language'] = $this->originalPreferenceLanguage;
        } else {
            unset($GLOBALS['_MAX']['PREF']['language']);
        }
        if ($this->hadConfigLanguage) {
            $GLOBALS['_MAX']['CONF']['max']['language'] = $this->originalConfigLanguage;
        } else {
            unset($GLOBALS['_MAX']['CONF']['max']['language']);
        }
    }

    public function testCalendarTranslationUsesPreferencesAvailableAtHeaderTime()
    {
        $ui = (new ReflectionClass(OA_Admin_UI::class))->newInstanceWithoutConstructor();
        $method = new ReflectionMethod(OA_Admin_UI::class, 'addJsCalendarTranslation');
        $method->setAccessible(true);

        $GLOBALS['_MAX']['CONF']['max']['language'] = 'en';
        unset($GLOBALS['_MAX']['PREF']['language']);
        $method->invoke($ui);
        $this->assertEqual($ui->otherJSFiles, []);

        $GLOBALS['_MAX']['PREF']['language'] = 'es';
        $method->invoke($ui);
        $this->assertEqual($ui->otherJSFiles, ['assets/js/jscalendar/lang/calendar-es.js']);
    }

    public function testCalendarTranslationFallsBackToConfiguredLanguage()
    {
        $ui = (new ReflectionClass(OA_Admin_UI::class))->newInstanceWithoutConstructor();
        $method = new ReflectionMethod(OA_Admin_UI::class, 'addJsCalendarTranslation');
        $method->setAccessible(true);

        unset($GLOBALS['_MAX']['PREF']['language']);
        $GLOBALS['_MAX']['CONF']['max']['language'] = 'fr';
        $method->invoke($ui);
        $method->invoke($ui);
        $this->assertEqual($ui->otherJSFiles, ['assets/js/jscalendar/lang/calendar-fr.js']);
    }
}
