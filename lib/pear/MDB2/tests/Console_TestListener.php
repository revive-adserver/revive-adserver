<?php
class Console_TestListener extends PHPUnit_TestListener {
    function addError(&$test, &$t) {
        $this->_errors += 1;
        echo(" Error $this->_errors in ".$test->getName()." : $t\n");
    }

    function addFailure(&$test, &$t) {
        $this->_fails += 1;
        if ($this->_fails == 1) {
            echo("\n");
        }
        echo("Failure $this->_fails : $t\n");
    }

    function endTest(&$test) {
        if ($this->_fails == 0 && $this->_errors == 0) {
            echo(' Test passed');
        } else {
            echo("There were $this->_fails failures for ".$test->getName()."\n");
            echo("There were $this->_errors errors for ".$test->getName()."\n");
        }
        echo("\n");
    }

    function startTest(&$test) {
        $this->_fails = 0;
        $this->_errors = 0;
        echo(get_class($test).' : Starting '.$test->getName().' ...');
    }
}
?>