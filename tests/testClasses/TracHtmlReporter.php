<?php

/*
+---------------------------------------------------------------------------+
| Revive Adserver                                                           |
| http://www.revive-adserver.com                                            |
|                                                                           |
| Copyright: See the COPYRIGHT.txt file.                                    |
| License: GPLv2 or later, see the LICENSE.txt file.                        |
+---------------------------------------------------------------------------+
*/

/**
 * Adds a link to remote trac svn repository so we could quickly check
 * who did last change if test is broken
 *
 * @author     Radek Maciaszek <radek.maciaszek@openx.org>
 */
class TracHtmlReporter extends HtmlReporter
{
    function TracHtmlReporter($character_set = 'ISO-8859-1')
    {
        $this->HtmlReporter($character_set);
    }

    /**
     *    Paints the top of the web page setting the
     *    title to the name of the starting test.
     *    @param string $test_name      Name class of test.
     *    @param string $secondary_name Optional secondary test title info.
     *    @access public
     */
    function paintHeader($test_name, $secondary_name = null) {
        $this->sendNoCacheHeaders();
        print "<html>\n<head>\n<title>$test_name</title>\n";
        print "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=" .
                $this->_character_set . "\">\n";
        print "<style type=\"text/css\">\n";
        print $this->_getCss() . "\n";
        print "</style>\n";
        print "</head>\n<body>\n";
        print "<h1>\n";
        if (!is_null($secondary_name)) {
            if (!empty($GLOBALS['_MAX']['CONF']['test']['urlToTracSvnBrowser'])) {
                print "<a href='".$GLOBALS['_MAX']['CONF']['test']['urlToTracSvnBrowser'];
                if (!empty($_GET['folder'])) {
                    print $_GET['folder'] . '/tests/unit';
                }
                if (!empty($_GET['file'])) {
                    print '/' . $_GET['file'];
                }
                print "'>";
                print "<img src='images/tutorial.png' border='0'/></a> ";
            }
        }
        print "$test_name</h1>";
        print "<h2>$secondary_name</h2>\n";
        flush();
    }

    /**
     *    Paints a PHP error or exception.
     *    @param string $message        Message is ignored.
     *    @access public
     *    @abstract
     */
    function paintException($message) {
        $this->_exceptions++;

        print "<span class=\"fail\">Exception</span>: ";
        $breadcrumb = $this->getTestList();
        array_shift($breadcrumb);
        print implode(" -&gt; ", $breadcrumb);
        print " -&gt; <strong>" . $this->_htmlEntities($message) . "</strong>";

        if (!empty($GLOBALS['_MAX']['CONF']['test']['urlToTracSvnBrowser'])) {
            $pattern = "/in \[(.*)\] line \[(.*)\]/";
            preg_match($pattern, $message, $matches = array());
            if (!empty($matches)) {
                print " <a href='".$GLOBALS['_MAX']['CONF']['test']['urlToTracSvnBrowser'];
                $path = substr($matches[1], strlen(MAX_PATH)) . '#L' . $matches[2];
                if (strpos($path, '/') === 0) {
                    $path = substr($path, 1);
                }
                print $path . "'>";
                print "<img src='images/tutorial.png' border='0'/></a>";
            }
        }
        print "<br />\n";
    }

    /**
     *    Paints the test failure with a breadcrumbs
     *    trail of the nesting test suites below the
     *    top level test.
     *    @param string $message    Failure message displayed in
     *                              the context of the other tests.
     *    @access public
     */
    function paintFail($message) {
        $this->_fails++;
        print "<span class=\"fail\">Fail</span>: ";
        $breadcrumb = $this->getTestList();
        array_shift($breadcrumb);
        print implode(" -&gt; ", $breadcrumb);
        print " -&gt; " . $this->_htmlEntities($message);

        if (!empty($GLOBALS['_MAX']['CONF']['test']['urlToTracSvnBrowser'])) {
            $pattern = "/\[(.*)\] with error/";
            preg_match($pattern, $message, $matches = array());
            if (!empty($matches)) {
                print " <a href='".$GLOBALS['_MAX']['CONF']['test']['urlToTracSvnBrowser'];
                $path = substr($matches[1], strlen(MAX_PATH));
                if (strpos($path, '/') === 0) {
                    $path = substr($path, 1);
                }
                print $path . "'>";
                print "<img src='images/tutorial.png' border='0'/></a>";
            }
        }

        print "<br />\n";
    }
}

?>