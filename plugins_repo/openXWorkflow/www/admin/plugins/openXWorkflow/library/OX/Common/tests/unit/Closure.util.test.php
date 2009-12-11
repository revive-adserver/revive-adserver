<?php

class OX_Common_ClosureTest
    extends UnitTestCase  
{
    public function testA()
    {
        $closure = OX_Common_Closure::createClosure(array (
                'OX_Common_ClosureTest', 'create'), array ('A'));
        $this->assertEqual("ABC", call_user_func_array($closure, array('B', 'C')));
    }
    
    
    public static function create($a, $b, $c)
    {
        return $a . $b . $c;
    }
}

?>
