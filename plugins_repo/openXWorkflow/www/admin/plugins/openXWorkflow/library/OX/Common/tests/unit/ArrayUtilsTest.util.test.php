<?php

class OX_Common_ArrayUtilsTest extends UnitTestCase
{
    function testAddIfNotNull()
    {
        $expected = array ('k1' => 'v1');
        
        $actual = array ();
        OX_Common_ArrayUtils::addIfNotNull($actual, 'k2', null);
        OX_Common_ArrayUtils::addIfNotNull($actual, 'k1', 'v1');
        
        $this->assertEqual($expected, $actual);
    }
    
    
    function testSort()
    {
        $a1 = array ("a" => 1, "b" => 3, "c" => 2);
        $a2 = array ("a" => 2, "b" => 1, "c" => 3);
        $a3 = array ("a" => 3, "b" => 2, "c" => 1);
        
        $this->checkSort(array ($a1, $a2, $a3), "a", array ($a1, $a2, 
                $a3));
        $this->checkSort(array ($a1, $a2, $a3), "b", array ($a2, $a3, 
                $a1));
        $this->checkSort(array ($a1, $a2, $a3), "c", array ($a3, $a1, 
                $a2));
    }
    
    
    function checkSort($input, $prop, $expected)
    {
        OX_Common_ArrayUtils::sortByProperty($input, $prop);
        $this->assertEqual($expected, $input);
    }
    
    
    function testSortString()
    {
        $a1 = array ("a" => "qa", "b" => "yoS", "c" => "B");
        $a2 = array ("a" => "qB", "b" => "yoP", "c" => "C");
        $a3 = array ("a" => "qc", "b" => "yor", "c" => "a");
        
        $this->checkSortString(array ($a1, $a2, $a3), "a", array ($a1, $a2, 
                $a3));
        $this->checkSortString(array ($a1, $a2, $a3), "b", array ($a2, $a3, 
                $a1));
        $this->checkSortString(array ($a1, $a2, $a3), "c", array ($a3, $a1, 
                $a2));
    }
    
    
    function checkSortString($input, $prop, $expected)
    {
        OX_Common_ArrayUtils::sortByProperty($input, $prop, 'strcasecmp');
        $this->assertEqual($expected, $input);
    }
    
    
    function testBiject()
    {
        $o1 = array ("id" => "5", "name" => "A");
        $o2 = array ("id" => "4", "name" => "B");
        $o3 = array ("id" => "6", "name" => "C");
        $o4 = array ("id" => "7", "name" => "D");
        $o5 = array ("id" => "1", "name" => "E");
        $this->checkBiject(array ("4" => "B", "6" => "C", "7" => "D"), array (
                $o3, $o2, $o4));
        $this->checkBiject(array ("5" => "A", "4" => "B", "6" => "C", "7" => "D", "1" => "E"), 
            array ($o3, $o2, $o4, $o5, $o1));
    }
    
    
    public function checkBiject($expected, $input)
    {
        $result = OX_Common_ArrayUtils::biject($input, "id", "name");
        $this->assertEqual($expected, $result);
    }
    
    
    public function testSort_()
    {
        $arr = array("ORANGE", "dedal", "APPLE", "banana");
        usort($arr, 'strcasecmp');
        //var_dump($arr);
        $this->assertEqual(array("APPLE", "banana", "dedal", "ORANGE"), $arr);
    }
}

?>
