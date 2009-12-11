<?php

require_once (LIB_PATH . '/simpletest/unit_tester.php');
require_once (LIB_PATH . '/simpletest/reporter.php');

class OX_StripHttpUrlProtocol extends UnitTestCase
{
    private $urls = array ('localhost', '192.168.0.12', 'localhost:123', 
            'localhost:*', 'test.com/path/res.php', 
            'test.com/path/?param=3&p4=3');


    public function testHttpStripping()
    {
        $this->checkStrippedUrls($this->urls, 'http://');
    }


    public function testHttpsStripping()
    {
        $this->checkStrippedUrls($this->urls, 'https://');
    }


    public function testNoStripping()
    {
        $this->checkUnchangedUrls($this->urls, '');
    }

    
    public function testNoFtpStripping()
    {
        $this->checkUnchangedUrls($this->urls, 'ftp://');
    }

    
    public function testLeadingSpaceStripping()
    {
        $this->checkStrippedUrls($this->urls, '  http://');
    }

    
    public function testTrailingSpaceStripping()
    {
        $this->checkStrippedUrls($this->urls, 'http://', '   ');
    }

    
    public function checkStrippedUrls($urls, $prefix, $suffix = '')
    {
        foreach ($urls as $url) {
            $this->checkStrippedUrl($url, $prefix, $suffix);
        }
    }


    public function checkStrippedUrl($url, $prefix, $suffix = '')
    {
        $filter = new OX_Common_Filter_StripHttpUrlProtocol();
        $this->assertEqual($url, $filter->filter($prefix . $url . $suffix));
    }


    public function checkUnchangedUrls($urls, $prefix, $suffix = '')
    {
        foreach ($urls as $url) {
            $this->checkUnchangedUrl($url, $prefix, $suffix);
        }
    }


    public function checkUnchangedUrl($url, $prefix, $suffix = '')
    {
        $filter = new OX_Common_Filter_StripHttpUrlProtocol();
        $this->assertEqual($prefix . $url . $suffix, $filter->filter($prefix . $url . $suffix));
    }
}
