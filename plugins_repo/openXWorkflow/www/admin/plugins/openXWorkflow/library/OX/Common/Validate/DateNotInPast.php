<?php

require_once 'Zend/Validate/Abstract.php';
require_once 'Zend/Date.php';

class OX_Common_Validate_DateNotInPast extends Zend_Validate_Abstract
{

    const INVALID_DATE_IN_PAST = 'invalidDate';

    protected $_messageTemplates = array(
        self::INVALID_DATE_IN_PAST => 'Selected date is before today\'s date. Select a later date.'
    );

    protected $dateFormat;
    
    public function __construct($dateFormat)
    {
        $this->dateFormat = $dateFormat;
    }
    
    function isValid($value, $aContext = null)
    {
        $this->_setValue($value);
        
        $oStartDate = OX_Common_DateUtils::setTimeToBeginningOfTheDay(new Zend_Date($value, $this->dateFormat));
        $now = OX_Common_DateUtils::setTimeToBeginningOfTheDay(Zend_Date::now());
        if ($oStartDate->isEarlier($now)) {
            $this->_error(self::INVALID_DATE_IN_PAST);
            return false;
        }

        return true;
    }
}
?>
