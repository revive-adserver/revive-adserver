<?php

require_once(LIB_PATH . '/simpletest/unit_tester.php');
require_once(LIB_PATH . '/simpletest/reporter.php');

class OX_UrlValidatorTest extends UnitTestCase
{
    
    public function testLocalUrl()
    {
        // protocol required, wildcards not allowed
        $this->checkValidRequireProtocol('https://localhost');
        $this->checkValidRequireProtocol('http://localhost');
        // protocol not allowed, wildcards allowed
        $this->checkValidNoProtocolAllowWildcards('localhost');
        $this->checkValidNoProtocolAllowWildcards('localhost.*');
    }
    
    public function testLocalUrlWithPort()
    {
        // protocol required, wildcards not allowed
        $this->checkValidRequireProtocol('http://localhost:14345');
        $this->checkInValidRequireProtocol('http://localhost:143453');
        $this->checkInValidRequireProtocol('https://localhost:*');
        // protocol not allowed, wildcards allowed
        $this->checkValidNoProtocolAllowWildcards('localhost:*');
        $this->checkValidNoProtocolAllowWildcards('localhost:14345');
        $this->checkInValidNoProtocolAllowWildcards('localhost:143453');
    }
    
    public function testDomainName()
    {
        // protocol not allowed, wildcards allowed
        $this->checkValidRequireProtocol('http://test.com');
        $this->checkValidRequireProtocol('http://TEST.COM');
        $this->checkValidRequireProtocol('http://www.test.com');
        $this->checkValidRequireProtocol('http://a.blog.com:45');
        $this->checkValidRequireProtocol('http://a20.blog34.com:45');
        $this->checkInValidRequireProtocol('http://*test.com');
        $this->checkInValidRequireProtocol('http://*.test.com');
        $this->checkInValidRequireProtocol('http://blog.*.com');
        $this->checkInValidRequireProtocol('http://blog.*.com:45');
        // protocol not allowed, wildcards allowed
        $this->checkValidNoProtocolAllowWildcards('test.com');
        $this->checkValidNoProtocolAllowWildcards('TEST.COM');
        $this->checkValidNoProtocolAllowWildcards('www.test.com');
        $this->checkValidNoProtocolAllowWildcards('*test.com');
        $this->checkValidNoProtocolAllowWildcards('*.test.com');
        $this->checkValidNoProtocolAllowWildcards('blog.*.com');
        $this->checkValidNoProtocolAllowWildcards('blog.*.com:45');
        $this->checkValidNoProtocolAllowWildcards('a.blog.com:45');
        $this->checkValidNoProtocolAllowWildcards('a20.blog34.com:45');
    }

    public function testUrlWithDash()
    {
        // protocol not allowed, wildcards allowed
        $this->checkValidRequireProtocol('http://test-test.com');
        $this->checkValidRequireProtocol('http://a-.test-test.com');
        // protocol not allowed, wildcards allowed
        $this->checkValidNoProtocolAllowWildcards('test-test.com');
        $this->checkValidNoProtocolAllowWildcards('a-.test-test.com');
    }
    
    public function testPath()
    {
        // protocol not allowed, wildcards allowed
        $this->checkValidRequireProtocol('http://test.com/blog');
        $this->checkValidRequireProtocol('http://test.com/blog/content/post/');
        $this->checkValidRequireProtocol('http://test.com/blog/post/');
        $this->checkInValidRequireProtocol('http://test.com/blog/*/post/');
        // protocol not allowed, wildcards allowed
        $this->checkValidNoProtocolAllowWildcards('test.com/blog');
        $this->checkValidNoProtocolAllowWildcards('test.com/blog/content/post/');
        $this->checkValidNoProtocolAllowWildcards('test.com/blog/*/post/');
    }
    
    public function testParameters()
    {
        // protocol not allowed, wildcards allowed
        $this->checkValidRequireProtocol('http://test.com/?');
        $this->checkValidRequireProtocol('http://test.com/?param=x');
        $this->checkValidRequireProtocol('http://test.com/?param=x&param=%20');
        $this->checkValidRequireProtocol('http://test.com/test;session=23rsdf%30');
        $this->checkValidRequireProtocol('http://test.com/test?userid=&param=z');
        $this->checkInValidRequireProtocol('http://test.com/test?userid=*&param=z');
        // protocol not allowed, wildcards allowed
        $this->checkValidNoProtocolAllowWildcards('test.com/?');
        $this->checkValidNoProtocolAllowWildcards('test.com/?param=x');
        $this->checkValidNoProtocolAllowWildcards('test.com/?param=x&param=%20');
        $this->checkValidNoProtocolAllowWildcards('test.com/test;session=23rsdf%30');
        $this->checkValidNoProtocolAllowWildcards('test.com/test?userid=*&param=z');
        
    }
    
    public function testSpacesInside()
    {
        // protocol not allowed, wildcards allowed
        $this->checkInValidRequireProtocol('http://test.c om');
        $this->checkInValidRequireProtocol('http:// test.com');
        $this->checkInValidRequireProtocol('http://test.com ');
        $this->checkInValidRequireProtocol('http://test.com/param=x &test=z');
        // protocol not allowed, wildcards allowed
        $this->checkInValidNoProtocolAllowWildcards('test.c om');
        $this->checkInValidNoProtocolAllowWildcards(' test.com');
        $this->checkInValidNoProtocolAllowWildcards('test.com ');
        $this->checkInValidNoProtocolAllowWildcards('test.com/param=x &test=z');
    }
    
    public function testIP()
    {
        // protocol not allowed, wildcards allowed
        $this->checkValidRequireProtocol('http://192.149.34.12');
        
        // This is also valid
        $this->checkValidRequireProtocol('http://192.149');
        
        // protocol not allowed, wildcards allowed
        $this->checkValidNoProtocolAllowWildcards('192.149.34.12');
        
        // This is also valid
        $this->checkValidNoProtocolAllowWildcards('192.149');
    }
    
    public function checkValidRequireProtocol($url)
    {
        $validator = new OX_Common_Validate_Url();
        $this->assertTrue($validator->isValid($url));
    }
    
    public function checkInValidRequireProtocol($url)
    {
        $validator = new OX_Common_Validate_Url();
        $this->assertFalse($validator->isValid($url));
    }
    
    public function checkValidNoProtocolAllowWildcards($url)
    {
        $validator = new OX_Common_Validate_Url(false, true);
        $this->assertTrue($validator->isValid($url));
    }
    
    public function checkInValidNoProtocolAllowWildcards($url)
    {
        $validator = new OX_Common_Validate_Url(false, true);
        $this->assertFalse($validator->isValid($url));
    }
}
