<?php

require_once 'Zend/Validate/Abstract.php';
require_once 'Zend/Date.php';

/**
 * Accepts end dates (excluding time) that are equal or lated to a start date
 * extracted from the specified context variable.
 */
class OX_Common_Validate_EndDateAfterStart extends Zend_Validate_Abstract
{

    const INVALID_END_DATE_BEFORE_START = 'invalidEndDate';
    protected $_messageTemplates = array(
        self::INVALID_END_DATE_BEFORE_START => 'End date is before the selected start date. Select a later end date.'
    );

    protected $startDateElementName;
    protected $dateFormat;
    
    public function __construct($dateFormat, $startDateElementName = 'startDate')
    {
        $this->dateFormat = $dateFormat;
        $this->startDateElementName = $startDateElementName;
    }
    
    function isValid($value, $aContext = null)
    {
        $this->_setValue($value);

        if (is_array($aContext)) {
            if (!empty($aContext[$this->startDateElementName])) {
                $oEndDate = OX_Common_DateUtils::setTimeToEndOfTheDay(new Zend_Date($value, $this->dateFormat));
                $oStartDate = OX_Common_DateUtils::setTimeToBeginningOfTheDay(new Zend_Date($aContext[$this->startDateElementName], $this->dateFormat));
                if ($oStartDate->isEarlier($oEndDate)) {
                    return true;
                }
            } else if (empty($aContext[$this->startDateElementName])) {
                return true;
            }
        }

        $this->_error(self::INVALID_END_DATE_BEFORE_START);
        return false;
    }
}
?>
