<?php

require_once(LIB_PATH . '/simpletest/unit_tester.php');
require_once(LIB_PATH . '/simpletest/reporter.php');


class OX_UI_Form_Element_DateTest extends UnitTestCase
{
    public function testZendToUiDatepickerFormat()
    {
        $this->checkNothingConverted('nothing to convert');
        $this->checkNothingConverted('EEEE-dd-d');
        $this->check('MMMM d, yyyy', 'MM d, yy');
        $this->check('MMM d, yyyy', 'M d, yy');
        $this->check('M/d/yy', 'm/d/y');
        $this->check('d MMMM yyyy', 'd MM yy');
        $this->check('dd/MM/yyyy', 'dd/mm/yy');
        $this->check('yyyy-MM-dd', 'yy-mm-dd');
        $this->check('yy-MM-dd', 'y-mm-dd');
    }
    
    private function checkNothingConverted($zendDateFormat)
    {
        $this->check($zendDateFormat, $zendDateFormat);
    }
    
    private function check($zendDateFormat, $expectedDatepickerFormat)
    {
        $actualDatepickerFormat = OX_UI_Form_Element_Date::toUiDatepickerFormat($zendDateFormat);
        $this->assertEqual($expectedDatepickerFormat, $actualDatepickerFormat);
    }
}
?>
