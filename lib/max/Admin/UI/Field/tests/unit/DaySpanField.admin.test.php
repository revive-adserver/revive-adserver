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

require_once MAX_PATH . '/lib/max/Admin/UI/FieldFactory.php';
require_once MAX_PATH . '/lib/OA/Admin/UI/Field/AuditDaySpanField.php';
require_once MAX_PATH . '/lib/max/other/lib-userlog.inc.php';

class DaySpanFieldTest extends UnitTestCase
{
    private $preferences;

    public function setUp()
    {
        Language_Loader::load();
        Language_Loader::load('userlog');
        $this->preferences = $GLOBALS['pref'] ?? null;
        $GLOBALS['pref'] = ['ui_week_start_day' => 0];
    }

    public function tearDown()
    {
        if (null === $this->preferences) {
            unset($GLOBALS['pref']);
        } else {
            $GLOBALS['pref'] = $this->preferences;
        }
    }

    public function testDisplayPreservesNormalPreset()
    {
        $field = (new FieldFactory())->newField('date-month');
        $field->_name = 'period';
        $field->setValue('last_month');

        $html = $this->renderField($field);

        $this->assertTrue(str_contains($html, "<option value='last_month' selected='selected'>"));
        $this->assertPresetIsScriptData($html, 'last_month');
    }

    public function testDisplayTreatsSavedPresetAsScriptData()
    {
        foreach ($this->getPayloads() as $preset) {
            $field = (new FieldFactory())->newField('date-month');
            $field->_name = 'period';
            $field->_fieldSelectionValue = $preset;

            $this->assertPresetIsScriptData($this->renderField($field), $preset);
        }
    }

    public function testAuditDisplayPreservesNormalPreset()
    {
        $field = new OA_Admin_UI_Audit_DaySpanField('period', 'last_month');
        $field->_fieldSelectionValue = 'all_events';

        $html = $this->renderField($field);

        $this->assertTrue(str_contains($html, "<option value='all_events' selected='selected'>"));
        $this->assertPresetIsScriptData($html, 'all_events');
    }

    public function testAuditDisplayTreatsSavedPresetAsScriptData()
    {
        foreach ($this->getPayloads() as $preset) {
            $field = new OA_Admin_UI_Audit_DaySpanField('period', 'last_month');
            $field->_fieldSelectionValue = $preset;

            $this->assertPresetIsScriptData($this->renderField($field), $preset);
        }
    }

    private function getPayloads(): array
    {
        return [
            "';}document.documentElement.dataset.triageReport='XSS';function dummy(){var x='",
            '</script><script>document.documentElement.dataset.triageReport="XSS"</script>',
            "quotes'\" & backslash\\ newline\n",
        ];
    }

    private function renderField(Admin_UI_DaySpanField $field): string
    {
        $field->_tabIndex = 1;
        ob_start();
        try {
            $field->display();
            return ob_get_contents();
        } finally {
            ob_end_clean();
        }
    }

    private function assertPresetIsScriptData(string $html, string $preset): void
    {
        $matched = preg_match("/document\\.getElementById\\('period_preset'\\)\\.value = ([^\\r\\n]+);/", $html, $matches);
        $this->assertEqual($matched, 1);
        if ($matched) {
            $decoded = json_decode($matches[1], true);
            $this->assertEqual(json_last_error(), JSON_ERROR_NONE);
            $this->assertIdentical($decoded, $preset);
        }
        $this->assertEqual(substr_count($html, '<script'), 1);
        $this->assertEqual(substr_count($html, '</script>'), 1);
    }
}
