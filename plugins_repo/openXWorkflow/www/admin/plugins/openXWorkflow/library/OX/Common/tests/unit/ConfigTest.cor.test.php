<?php

require_once(LIB_PATH . '/simpletest/unit_tester.php');
require_once(LIB_PATH . '/simpletest/reporter.php');


class OX_Common_ConfigTest extends UnitTestCase
{
    public function setUp()
    {
        $this->nonExistFile =  dirname(__FILE__) . '/nonexistent.config.php';
        $this->file = dirname(__FILE__) . '/test-config.php';
    }

    public function testFilename()
    {
        //  test that an exception is thrown when the file does not exist
        try {
            OX_Common_Config::instance(null, $this->nonExistFile);
            $this->fail('Exception not encountered');
        } catch (Exception $e) {
            if ($e->getMessage() == 'The specified config file does not exist.') {
                $this->pass();
            } else {
                $this->fail('Exception message and expected message does not match');
            }
        }

        $oConfig = & OX_Common_Config::instance(null, $this->file);
        $this->assertIsA($oConfig, 'OX_Common_Config');
    }
    

    public function testGetSection()
    {
        $oConfig = & OX_Common_Config::instance(null, $this->file);
        $oDatabase = $oConfig->getSection('database');
        $this->assertIsA($oDatabase, 'Zend_Config');

        $aDatabase = $oDatabase->toArray();
        $this->assertTrue(is_array($aDatabase));
        $this->assertEqual($aDatabase['type'], 'mysql');

        $oFailure = $oConfig->getSection('failure');
        $this->assertFalse($oFailure);
    }
}
?>
