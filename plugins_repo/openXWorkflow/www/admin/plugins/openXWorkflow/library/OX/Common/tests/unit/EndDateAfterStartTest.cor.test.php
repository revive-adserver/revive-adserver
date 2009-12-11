<?php

require_once(LIB_PATH . '/simpletest/unit_tester.php');
require_once(LIB_PATH . '/simpletest/reporter.php');

class OX_EndDateAfterStartTest extends UnitTestCase
{
    public function testDateAfterStart()
    {
        $aContext = array('startDate' => '2008-01-01');
        $endDate = '2008-05-05';
        $endDate2 = '2007-05-05';
        $endDate3 = '2008-01-01';


        $oValidate = new OX_Common_Validate_EndDateAfterStart('yyyy-MM-dd');

        // end date is after start
        $this->assertTrue($oValidate->isValid($endDate, $aContext));

        // end date is before start
        $this->assertFalse($oValidate->isValid($endDate2, $aContext));

        // end date is same as start
        $this->assertTrue($oValidate->isValid($endDate3, $aContext));
    }
}
?>
