<?php

class OX_Common_StringUtilsTest
    extends UnitTestCase  
{
    function testUnderscore()
    {
        $this->assertEqual("os_version", 
            OX_Common_StringUtils::underscore('osVersion'));
    }
    
    function testCamelCase()
    {
        $this->assertEqual("OsVersion", 
            OX_Common_StringUtils::camelCase('os_version'));
    }
    
    function testNullOrValueNull()
    {
        $this->assertNull(OX_Common_StringUtils::nullOrValue(null));
        $this->assertNull(OX_Common_StringUtils::nullOrValue(''));
        $this->assertNull(OX_Common_StringUtils::nullOrValue(5));
    }
    
    function testNullOrValueNotNull()
    {
        $this->assertEqual('test', OX_Common_StringUtils::nullOrValue('test'));
    }
    
    function testEndsWith()
    {
        $this->assertTrue(OX_Common_StringUtils::endsWith("abcde", "de"));
        $this->assertTrue(OX_Common_StringUtils::endsWith("abcde", "abcde"));
        $this->assertFalse(OX_Common_StringUtils::endsWith("abcdefa", "de"));
        $this->assertFalse(OX_Common_StringUtils::endsWith("abcde", "0abcde"));
        $this->assertFalse(OX_Common_StringUtils::endsWith("abcde", "abcde0"));
    }
    
    function testStartsWith()
    {
        $this->assertTrue(OX_Common_StringUtils::startsWith("abcde", "ab"));
        $this->assertTrue(OX_Common_StringUtils::startsWith("abcde", "abcde"));
        $this->assertFalse(OX_Common_StringUtils::startsWith("abcdefa", "de"));
        $this->assertFalse(OX_Common_StringUtils::startsWith("abcde", "abcde0"));
        $this->assertFalse(OX_Common_StringUtils::startsWith("abcde", "0abcde0"));
    }
}
