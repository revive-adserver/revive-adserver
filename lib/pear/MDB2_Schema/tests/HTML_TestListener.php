<?php

class HTML_TestListener extends PHPUnit_TestListener {
    function addError(&$test, &$t) {
        $this->_errors += 1;
        echo("<div class=\"error\"> Error $this->_errors in ".$test->getName()." : $t</div>");
    }

    function addFailure(&$test, &$t) {
        $this->_fails += 1;
        if ($this->_fails == 1) {
            echo("\n<div class=\"failure\">");
        }
        echo("Failure $this->_fails : $t<br>\n");
    }

    function endTest(&$test) {
        if ($this->_fails == 0 && $this->_errors == 0) {
            echo(' Test passed');
        } else {
            echo("There were $this->_fails failures for ".$test->getName()."</br>\n");
            echo("There were $this->_errors errors for ".$test->getName()."</div>\n");
        }
        echo('</div>');
    }

    function startTest(&$test) {
        $this->_fails = 0;
        $this->_errors = 0;
        echo("\n<div class=\"testcase\">".get_class($test).' : Starting '.$test->getName().' ...');
    }
}

?>