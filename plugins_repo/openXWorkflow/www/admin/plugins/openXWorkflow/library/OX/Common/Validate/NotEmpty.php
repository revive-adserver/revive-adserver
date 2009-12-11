<?php

/**
 * Fixes the behaviour of Zend_Validate_NotEmpty with respect to numeric values. The
 * default validator would treat a string '0' as empty, which is not desireble in many
 * (most?) situations.
 */
class OX_Common_Validate_NotEmpty extends Zend_Validate_NotEmpty
{
    /**
     * Defined by Zend_Validate_Interface
     *
     * Returns true if and only if $value is not an empty value.
     *
     * @param  string $value
     * @return boolean
     */
    public function isValid($value)
    {
        $valueString = (string) $value;

        $this->_setValue($valueString);

        if (empty($value) && !is_numeric($value)) {
            $this->_error();
            return false;
        }

        return true;
    }
}
