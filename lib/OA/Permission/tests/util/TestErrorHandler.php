<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2009 OpenX Limited                                     |
| For contact details, see: http://www.openx.org/                           |
|                                                                           |
| This program is free software; you can redistribute it and/or modify      |
| it under the terms of the GNU General Public License as published by      |
| the Free Software Foundation; either version 2 of the License, or         |
| (at your option) any later version.                                       |
|                                                                           |
| This program is distributed in the hope that it will be useful,           |
| but WITHOUT ANY WARRANTY; without even the implied warranty of            |
| MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             |
| GNU General Public License for more details.                              |
|                                                                           |
| You should have received a copy of the GNU General Public License         |
| along with this program; if not, write to the Free Software               |
| Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA |
+---------------------------------------------------------------------------+
$Id$
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
