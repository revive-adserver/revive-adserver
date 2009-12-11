<?php

/**
 * Validates a greater than or equal condition regardless of value type. Apply an 
 * additional validator to check the type of the value.
 */
class OX_Common_Validate_GreaterThanOrEqual extends Zend_Validate_GreaterThan
{
    const NOT_GREATER_OR_EQUAL = 'notGreaterThanOrEqual';
    
    /**
     * @var array
     */
    protected $_messageTemplates = array (
            self::NOT_GREATER_OR_EQUAL => "Provide a value greater than or equal to '%min%'");
    
    /**
     * @var array
     */
    protected $_messageVariables = array ('min' => '_min');
    
    /**
     * Defined by Zend_Validate_Interface
     *
     * Returns true if and only if $value is greater than min option
     *
     * @param  mixed $value
     * @return boolean
     */
    public function isValid($value)
    {
        $this->_setValue($value);
        
        if ($this->_min > $value) {
            $this->_error();
            return false;
        }
        return true;
    }

}
