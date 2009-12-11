<?php

class OX_Common_DateRange_Test extends UnitTestCase
{
    public function test7Days()
    {
        $this->checkMoreDaysRange(OX_Common_DateRange::DATE_RANGE_LAST_7_DAYS, 7);
    }
    
    public function test30Days()
    {
        $this->checkMoreDaysRange(OX_Common_DateRange::DATE_RANGE_LAST_30_DAYS, 30);
    }
    
    public function testToday()
    {
        $this->checkOneDayRange(OX_Common_DateRange::DATE_RANGE_TODAY);
    }
    
    public function testYesterday()
    {
        $this->checkOneDayRange(OX_Common_DateRange::DATE_RANGE_YESTERDAY);
    }
    
    private function checkMoreDaysRange($rangeId, $expectedDaysDifference)
    {
        $range = new OX_Common_DateRange();
        $range->setRange($rangeId);
        $actualStartDate = $range->getStartDate();
        $actualEndDate = $range->getEndDate();
        
        $this->checkDaysDifference($actualStartDate, $actualEndDate, $expectedDaysDifference);
    }
    
    private function checkOneDayRange($rangeId)
    {
        $range = new OX_Common_DateRange();
        $range->setRange($rangeId);
        $actualStartDate = OX_Common_DateUtils::setTimeToBeginningOfTheDay($range->getStartDate());
        $actualEndDate = OX_Common_DateUtils::setTimeToBeginningOfTheDay($range->getEndDate());
        
        $this->assertEqual($actualStartDate, $actualEndDate);
    }
    
    private function checkDaysDifference(Zend_Date $start, $end, 
            $expectedDaysDifference)
    {
        $this->assertNotNull($start);
        $this->assertNotNull($end);
        
        $diff = new Zend_Date($end);
        $diff->sub($start);
        $diff->setTimeZone('UTC');
        $this->assertEqual($diff->get('d'), $expectedDaysDifference);
    }
}
?>