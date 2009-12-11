<?php

class OX_Common_DateUtils
{
    /**
     * UTC time zone.
     * 
     * @var DateTimeZone
     */
    public static $UTC;
	
	
	const DAY_IN_MILLIS = 86400000; //24 * 3600 * 1000 
    const DAY_IN_SECONDS = 86400; //24 * 3600 
    
    /**
     * @return Zend_Date
     */
    public static function setTimeToBeginningOfTheDay(Zend_Date $date)
    {
        $date->setHour(0);
        return self::setTimeToBeginningOfTheHour($date);
    }
    
    /**
     * @return Zend_Date
     */
    public static function setTimeToEndOfTheDay(Zend_Date $date)
    {
        $date->setHour(23);
        return self::setTimeToEndOfTheHour($date);
    }
    
    /**
     * @return Zend_Date
     */
    public static function setTimeToBeginningOfTheHour(Zend_Date $date)
    {
        $date->setMinute(0);
        $date->setSecond(0);
        return $date;
    }
    
    /**
     * @return Zend_Date
     */
    public static function setTimeToEndOfTheHour(Zend_Date $date)
    {
        $date->setMinute(59);
        $date->setSecond(59);
        return $date;
    }
}

OX_Common_DateUtils::$UTC = new DateTimeZone('UTC');
