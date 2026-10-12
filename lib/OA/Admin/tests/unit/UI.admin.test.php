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

class Test_OA_Admin_UI extends UnitTestCase
{
    private array $savedPreferences;
    private array $savedConfig;

    public function setUp()
    {
        $this->savedPreferences = $GLOBALS['_MAX']['PREF'] ?? [];
        $this->savedConfig = $GLOBALS['_MAX']['CONF'];
    }

    public function tearDown()
    {
        $GLOBALS['_MAX']['PREF'] = $this->savedPreferences;
        $GLOBALS['_MAX']['CONF'] = $this->savedConfig;
    }

    public function testCalendarLanguageFallsBackToConfiguration()
    {
        $GLOBALS['_MAX']['PREF'] = [];
        $GLOBALS['_MAX']['CONF']['max']['language'] = 'es';

        $this->assertEqual(
            ['assets/js/jscalendar/lang/calendar-es.js'],
            $this->getCalendarTranslationFiles(),
        );

        $GLOBALS['_MAX']['PREF']['language'] = '';
        $this->assertEqual(
            ['assets/js/jscalendar/lang/calendar-es.js'],
            $this->getCalendarTranslationFiles(),
        );
    }

    public function testCalendarLanguagePrefersUserPreference()
    {
        $GLOBALS['_MAX']['PREF']['language'] = 'it';
        $GLOBALS['_MAX']['CONF']['max']['language'] = 'es';

        $this->assertEqual(
            ['assets/js/jscalendar/lang/calendar-it.js'],
            $this->getCalendarTranslationFiles(),
        );
    }

    public function testCalendarLanguageMapsLegacyConfiguration()
    {
        $GLOBALS['_MAX']['PREF'] = [];
        $GLOBALS['_MAX']['CONF']['max']['language'] = 'polish';

        $this->assertEqual(
            ['assets/js/jscalendar/lang/calendar-pl.js'],
            $this->getCalendarTranslationFiles(),
        );

        // Preferences can inherit the legacy value from the configuration.
        $GLOBALS['_MAX']['PREF']['language'] = 'polish';
        $this->assertEqual(
            ['assets/js/jscalendar/lang/calendar-pl.js'],
            $this->getCalendarTranslationFiles(),
        );
    }

    private function getCalendarTranslationFiles(): array
    {
        $ui = (new ReflectionClass(OA_Admin_UI::class))->newInstanceWithoutConstructor();
        (new ReflectionMethod(OA_Admin_UI::class, 'addJsCalendarTranslation'))->invoke($ui);

        return $ui->otherJSFiles;
    }
}
