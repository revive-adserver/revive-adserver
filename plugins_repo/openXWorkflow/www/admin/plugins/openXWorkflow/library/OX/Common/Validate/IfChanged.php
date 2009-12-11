<?php

require_once 'Zend/Validate/Abstract.php';

/**
 * A validator that delegates validity checks to the specified validator only if
 * the value passed for validation is different from the current value provided 
 * when creating the validator. If both values are equal, the delegate validator
 * is not used and isValid returns true.
 * 
 * This validator is useful when a value should be validated only if the user
 * has changed its value. If the value is invalid but has not been changed, this validator
 * will not raise errors.
 */
class OX_Common_Validate_IfChanged extends Zend_Validate_Abstract
{
    private $currentValue;
    
    /**
     * @var Zend_Validate_Interface
     */
    private $validator;
    
    public function __construct(Zend_Validate_Interface $validator, $currentValue)
    {
        $this->currentValue = $currentValue;
        $this->validator = $validator;
    }
    
    function isValid($value, $aContext = null)
    {
        if ($value == $this->currentValue)
        {
            return true;
        }
        else 
        {
            $isValid = $this->validator->isValid($value, $aContext);
            if ($isValid === false)
            {
                $this->_setValue($value);
                $this->_error = array_slice($this->validator->getErrors(), 0);
                $this->_messages = array_slice($this->validator->getMessages(), 0);
            }
            return $isValid;
        }
    }
}
?>
