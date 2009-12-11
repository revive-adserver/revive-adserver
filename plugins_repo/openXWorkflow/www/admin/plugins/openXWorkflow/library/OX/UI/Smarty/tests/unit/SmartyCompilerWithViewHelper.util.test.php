<?php
require_once LIB_PATH . '/Smarty/Smarty.class.php';

class OX_UI_Smarty_SmartyCompilerWithViewHelperTest extends UnitTestCase
{


    public function setUp()
    {
        $this->compiler = new OX_UI_Smarty_SmartyCompilerWithViewHelper();
    }


    public function testParameterlessHelper()
    {
        $this->check('{parameterless}', 'parameterless');
    }


    public function testHelperWithScalarParameters()
    {
        $this->check("{withParam p1=a p2=3}", 'withParam', array (
                'p1' => 'a', 'p2' => 3));
    }

    public function testHelperWithArrayParameters()
    {
        $this->check("{withArray p1=a p1=3}", 'withArray', array (
                'p1' => array('a', 3)));
    }

    public function testHelperWithAssociativeParameters()
    {
        $this->check("{withArray p1.a=a p1.b=3}", 'withArray', array (
                'p1' => array('a' => 'a', 'b' => 3)));
    }
    
    public function testHelperWithAssociativeArrayParameters()
    {
        $this->check("{withArray p1.a=a p1.a=3}", 'withArray', array (
                'p1' => array('a' => array('a', 3))));
    }

    public function testParametersWithSpaces()
    {
        $this->check("{withSpaces p1='a b' p2=3}", 'withSpaces', array (
                'p1' => 'a b', 'p2' => 3));
    }


    private function check($smartyTemplate, $expectedHelperName, 
            $expectedParameters = array())
    {
        $output = '';
        $this->compiler->_compile_file('test', $smartyTemplate, $output);
        
        echo "<pre>$output</pre>";
        
        $matches = array();
        preg_match('/callViewHelper\(\'(\w+)\',(.*)\);/', $output, $matches);
        $this->assertTrue(count($matches) == 3);

        eval('$actualParameters = ' . $matches[2] . ';');

        $this->assertEqual($matches[1], $expectedHelperName);
        $this->assertEqual($actualParameters, $expectedParameters);
    }
}
