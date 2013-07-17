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
 * A class for dealing with raised errors, so that they don't
 * show in the unit test interface. Should be used directly,
 * rather than as a mocked object, as using the mock object to
 * compare the errors doesn't work, due to the trackback data
 * stored in PEAR_Error objects.
 * 
 * Example of use:
 *      // Set the error handling class' handleErrors() method as
 *      // the error handler for PHP for this test.
 *      $oTestErrorHandler = new TestErrorHandler();
 *      PEAR::pushErrorHandling(PEAR_ERROR_CALLBACK, array(&$oTestErrorHandler, 'handleErrors'));
 *  
 *      (test something here)     
 * 
 *      $this->assertEqual(count($oTestErrorHandler->aErrors), 1);
 *      $this->assertEqual(
 *          $oTestErrorHandler->aErrors[0]->message,
 *          'Expected Error'
 *      );
 *      $oTestErrorHandler->reset();
 * 
 *      // Unset the error handler
 *      PEAR::popErrorHandling();
 * 
 */
class TestErrorHandler {

    /**
     * A class variable for storing PEAR errors.
     *
     * @var array
     */
    var $aErrors;

    /**
     * A method to "handle" errors. It simply stores the errors
     * in the class variable, so that they can be inspected later.
     *
     * @param PEAR_Error $oError A PEAR_Error object.
     * @return void
     */
    function handleErrors($oError)
    {
        $this->aErrors[] = $oError;
    }

    /**
     * A method to reset the class.
     *
     * @return void
     */
    function reset()
    {
        $this->aErrors = array();
    }

}

?>
