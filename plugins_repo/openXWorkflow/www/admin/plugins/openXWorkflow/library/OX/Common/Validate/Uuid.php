<?php

class OX_Common_Validate_Uuid extends Zend_Validate_Abstract
{
    const INVALID_URL = 'invalidUuid';
    

    public function __construct()
    {
        $this->_messageTemplates = array (
            self::INVALID_URL => 'Please provide a correct UUID, e.g. ' . uuid_create()); 
    }
            
            
    public function isValid($uuid)
    {
        $valid = uuid_is_valid($uuid);
        if (!$valid) {
            $this->_error();
        }
        
        return $valid;
    }
}
