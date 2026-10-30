<?php

require_once MAX_PATH . '/lib/OA/Admin/UI/Field/AuditDaySpanField.php';

class Test_OA_Admin_UI_Audit_DaySpanField extends UnitTestCase
{
    public function testResetRestoresBothSelectedDates(): void
    {
        $field = new OA_Admin_UI_Audit_DaySpanField(
            'period',
            'specific',
            ['specific' => 'Specific dates'],
        );
        $field->setValueFromArray([
            'period_preset' => 'specific',
            'period_start' => '2025-01-03',
            'period_end' => '2025-02-04',
        ]);

        $hadPref = array_key_exists('pref', $GLOBALS);
        $previousPref = $GLOBALS['pref'] ?? null;
        $GLOBALS['pref']['ui_week_start_day'] = 0;

        ob_start();
        $field->display();
        $html = ob_get_clean();

        if ($hadPref) {
            $GLOBALS['pref'] = $previousPref;
        } else {
            unset($GLOBALS['pref']);
        }

        $this->assertPattern("/document\.getElementById\('period_start'\)\.value = '2025-01-03';/", $html);
        $this->assertPattern("/document\.getElementById\('period_end'\)\.value = '2025-02-04';/", $html);
    }
}
