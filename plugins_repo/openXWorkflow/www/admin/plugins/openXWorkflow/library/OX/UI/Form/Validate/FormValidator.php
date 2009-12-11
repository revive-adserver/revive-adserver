<?php


interface OX_UI_Form_Validate_FormValidator
{
    /**
     * Returns true if and only if $data meets the validation requirements
     *
     * If $data fails validation, then this method returns false, and
     * getMessages() will return an array of messages associated with elements in error 
     * that explain why the validation failed.
     * Also getFormMessage will contain a global validation failure message.
     *
     * @param  array $value
     * @return boolean
     * @throws Zend_Valid_Exception If validation of $data is impossible
     */
    public function isValid($data);
    

    /**
     * Returns an array of element level messages that explain why the most recent isValid()
     * call returned false. The array keys are elementNames, values are arrays
     * which keys are validation failure message identifiers,
     * and the values are the corresponding human-readable message strings.
     *
     * If isValid() was never called or if the most recent isValid() call
     * returned true, then this method returns an empty array.
     *
     * @return array
     */
    public function getElementMessages();
    
    
    /**
     * Returns an single element array with message that explains why the most recent isValid()
     * call returned false. The array key is validation failure message identifier,
     * and the array value is the corresponding human-readable message strings.
     *
     * If isValid() was never called or if the most recent isValid() call
     * returned true, then this method returns an empty array.
     *
     * @return array
     */
    public function getFormMessage();
}
