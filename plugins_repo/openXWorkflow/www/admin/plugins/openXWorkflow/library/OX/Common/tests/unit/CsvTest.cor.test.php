<?php

require_once(LIB_PATH . '/simpletest/unit_tester.php');
require_once(LIB_PATH . '/simpletest/reporter.php');

class CsvTest extends UnitTestCase
{
    public function testEmpty()
    {
        $this->check(array(), '');
    }
    
    public function testOneElement()
    {
        $this->check(array('test'), '"test"');
    }
    
    public function testMoreElements()
    {
        $this->check(array('test1', 'test2', 'test3'), '"test1";"test2";"test3"');
    }
    
    public function testCommas()
    {
        $this->check(array('12.54', '12,43'), '"12.54";"12,43"');
    }
    
    public function testQuotes()
    {
        $this->check(array('test "test"', 'quote "quote" quote'), '"test ""test""";"quote ""quote"" quote"');
    }
    
    
    public function check($data, $expectedLine)
    {
        $this->assertEqual($expectedLine . "\n", OX_Common_Csv::formatCsvLine($data, ';'));
    }
}
