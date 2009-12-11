<?php

require_once(LIB_PATH . '/simpletest/unit_tester.php');
require_once(LIB_PATH . '/simpletest/reporter.php');

class OX_DateNotInPastTest extends UnitTestCase
{
    public function testDateNotInPast()
    {
        $date = '2001-01-01';
        $date2 = Zend_Date::now()->addDay(2)->toString('yyyy-MM-dd');

        $oValidate = new OX_Common_Validate_DateNotInPast('yyyy-MM-dd');

        $this->assertFalse($oValidate->isValid($date));
        $this->assertTrue($oValidate->isValid($date2));
    }
}
?>
