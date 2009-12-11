<?php

/**
 * Compares value of element with value of another element in the form
 */
class OX_Common_Validate_Compare 
    extends Zend_Validate_Abstract
{

    const NOT_EQUAL = 'valuesNotEqual';
    protected $_messageTemplates = array(
        self::NOT_EQUAL => 'Values are not equal'
    );

    protected $compareToElementName;
    protected $operator;
    
    
    /**
     * Currently ony 'eq' operator is supported
     *
     * @param unknown_type $leftElementName
     * @param unknown_type $rightElemntName
     * @param unknown_type $operator
     */
    public function __construct($compareToElementName, $operator = 'eq')
    {
        if ($operator  != 'eq') {
            throw new Zend_Exception('Invalid operator specified. Currently only "eq" operator is supported');
        }
        
        $this->compareToElementName = $compareToElementName;
        $this->operator = $operator;
    }
    
    
    function isValid($value, $aContext = null)
    {
        $this->_setValue($value);

        if (is_array($aContext)) {
            if (!empty($aContext[$this->compareToElementName])) {
                $compareToValue = $aContext[$this->compareToElementName];
                
                if ("eq" == $this->operator) {
                    if ($value == $compareToValue) {
                        return true;
                    }
                    else {
                        $this->_error(self::NOT_EQUAL);                
                    }
                }
                
            } 
            else if (empty($aContext[$this->compareToElementName])) {
                return true;
            }
        }
        
        return false;
    }
}
?>
