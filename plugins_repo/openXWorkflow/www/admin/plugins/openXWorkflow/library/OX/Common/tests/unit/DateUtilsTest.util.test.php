<?php

class OX_Common_DateUtilsTest extends UnitTestCase
{
    public function testSetTimeToBeginningOfTheDay()
    {
        $date = OX_Common_DateUtils::setTimeToBeginningOfTheDay(Zend_Date::now());
        $this->assertEqual(0, $date->get(Zend_Date::HOUR));
        $this->assertBeginningOfHour($date);
    }
    
    public function testSetTimeToEndOfTheDay()
    {
        $date = OX_Common_DateUtils::setTimeToEndOfTheDay(Zend_Date::now());
        $this->assertEqual(23, $date->get(Zend_Date::HOUR));
        $this->assertEndOfHour($date);
    }
    
    public function testSetTimeToBeginningOfTheHour()
    {
        $date = OX_Common_DateUtils::setTimeToBeginningOfTheHour(Zend_Date::now());
        $this->assertBeginningOfHour($date);
    }
    
    public function testSetTimeToEndOfTheHour()
    {
        $date = OX_Common_DateUtils::setTimeToEndOfTheHour(Zend_Date::now());
        $this->assertEndOfHour($date);
    }
    
    private function assertBeginningOfHour(Zend_Date $date)
    {
        $this->assertEqual(0, $date->get(Zend_Date::MINUTE));
        $this->assertEqual(0, $date->get(Zend_Date::SECOND));
    }
    
    private function assertEndOfHour(Zend_Date $date)
    {
        $this->assertEqual(59, $date->get(Zend_Date::MINUTE));
        $this->assertEqual(59, $date->get(Zend_Date::SECOND));
    }
}
