<?php

class OX_Common_Comparator_CreativeSizeOptionComparatorTest
    extends UnitTestCase  
{
    public function testEqual()
    {
        $this->checkEqual('  10 x10 ');
        $this->checkEqual('10x10');
        $this->checkEqual('10 x 10');
        $this->checkEqual('10 x 10', '10x10');
        $this->checkEqual('10 x 10', '010x0010');
    }
    
    public function testNotEqual()
    {
        $this->checkGreater('10x10', '9x10');
        $this->checkGreater('10x10', '9 x 100');
        $this->checkGreater('9x100', '9 x 10');
        $this->checkGreater('9x100', '9 x 010');
    }
    
    
    private function checkEqual($labelA, $labelB = null)
    {
        if (!isset($labelB)) {
            $labelB = $labelA;
        }
        
        $comparator = new OX_Common_Comparator_CreativeSizeOptionComparator();
        $this->assertEqual($comparator->compare($labelA, $labelB), 0);
        $this->assertEqual($comparator->compare($labelB, $labelA), 0);
    }

    
    private function checkGreater($labelA, $labelB = null)
    {
        $comparator = new OX_Common_Comparator_CreativeSizeOptionComparator();
        $this->assertTrue($comparator->compare($labelA, $labelB) > 0);
        $this->assertTrue($comparator->compare($labelB, $labelA) < 0);
    }
}
