<?php

require_once (LIB_PATH . '/simpletest/unit_tester.php');
require_once (LIB_PATH . '/simpletest/reporter.php');

class OX_IfChanged extends UnitTestCase
{
    private $ifChangedValidator;
    private $innerValidator;
    private $innerValidatorCopy;
    
    public function setUp()
    {
        $this->innerValidator = new Zend_Validate_LessThan(10);
        $this->innerValidatorCopy = new Zend_Validate_LessThan(10);
    }
    
    public function testNullNull()
    {
        $this->checkCurrentEqualToChecked(null);
    }
    
    public function testNullNotNull()
    {
        $this->checkCurrentNotEqualToChecked(null, 5);
        $this->checkCurrentNotEqualToChecked(null, 11);
    }
    
    public function testNotNullNull()
    {
        $this->checkCurrentNotEqualToChecked(5, null);
        $this->checkCurrentNotEqualToChecked(11, null);
    }
    
    public function testNotNullNotNull()
    {
        $this->checkCurrentNotEqualToChecked(5, 12);
        $this->checkCurrentNotEqualToChecked(12, 5);
        $this->checkCurrentEqualToChecked(5);
        $this->checkCurrentEqualToChecked(12);
    }
    
    private function checkCurrentNotEqualToChecked($currentValue, $checkedValue)
    {
        $this->setUpIfChangedValidator($currentValue);
        $this->assertEqual($this->ifChangedValidator->isValid($checkedValue), $this->innerValidatorCopy->isValid($checkedValue));
    }
    
    private function checkCurrentEqualToChecked($value)
    {
        $this->setUpIfChangedValidator($value);
        $this->assertEqual(true, $this->ifChangedValidator->isValid($value));
    }
    
    private function setUpIfChangedValidator($currentValue)
    {
        $this->ifChangedValidator = new OX_Common_Validate_IfChanged($this->innerValidator, $currentValue);
    }
}
?>