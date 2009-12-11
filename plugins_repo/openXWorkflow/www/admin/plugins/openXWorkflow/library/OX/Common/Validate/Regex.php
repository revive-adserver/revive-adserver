<?php

/**
 * A validator that extends Zend_Validate_Regex with a functionality that allows to
 * make the validator fail if the regexp is matched.
 */
class OX_Common_Validate_Regex extends Zend_Validate_Regex
{
    const NOT_MATCH_MESSAGE = "'%value%' does not match against pattern '%pattern%'";
    const MATCH_MESSAGE = "'%value%' should not match against pattern '%pattern%'";
    
    private $failIfMatch;


    public function __construct($pattern, $failIfMatch = false)
    {
        parent::__construct($pattern);
        $this->setFailIfMatch($failIfMatch);
    }


    public function setFailIfMatch($failIfMatch)
    {
        $this->failIfMatch = $failIfMatch;
        $this->_messageTemplates[self::NOT_MATCH] = $failIfMatch ? self::MATCH_MESSAGE : self::NOT_MATCH_MESSAGE;
    }


    public function getFailIfMatch()
    {
        return $this->failIfMatch;
    }


    public function isValid($value)
    {
        // We have to copy the implementation from the super class because there is no
        // way to unregister an error (which we'd need to do if $this->failIfMatch = true).
        $valueString = (string) $value;

        $this->_setValue($valueString);

        $status = @preg_match($this->_pattern, $valueString);
        if (false === $status) {
            /**
             * @see Zend_Validate_Exception
             */
            require_once 'Zend/Validate/Exception.php';
            throw new Zend_Validate_Exception("Internal error matching pattern '$this->_pattern' against value '$valueString'");
        }
        if (($this->failIfMatch && $status > 0) || (!$this->failIfMatch && $status == 0)) {
            $this->_error();
            return false;
        }
        return true;
    }
}
