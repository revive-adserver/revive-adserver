<?php

require_once(LIB_PATH . '/simpletest/unit_tester.php');
require_once(LIB_PATH . '/simpletest/reporter.php');


class OX_UI_Form_Element_Utils_Test extends UnitTestCase
{
    public function testRemoveClassEmpty()
    {
        $this->checkRemoveClass('', '', '');
        $this->checkRemoveClass('abc', '', 'abc');
        $this->checkRemoveClass('', 'abc', '');
    }
    
    public function testRemoveClassNonEmpty()
    {
        $this->checkRemoveClass('a b c d', 'a', 'b c d');
        $this->checkRemoveClass('a b c d', 'b', 'a c d');
        $this->checkRemoveClass('a b c d', 'd', 'a b c');
    }
    
    public function testRemoveClassSubstring()
    {
        $this->checkRemoveClass('donthide hide neverhide', 'hide', 'donthide neverhide');
    }
    
    private function checkRemoveClass($originalClass, $classToRemove, $expectedClass)
    {
        $this->assertEqual(OX_UI_Form_Element_Utils::removeClass($originalClass, $classToRemove), 
            $expectedClass);
    }
}
?>
