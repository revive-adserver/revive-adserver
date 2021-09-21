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
 * @package    OpenX
 */

/**
 *  Base class for all classes with error handling
 *
 */
class OA_BaseObjectWithErrors
{
    /**
     * Error Message
     *
     * @access private
     * @var string $_errorMessage
     */
    public $_errorMessage;

    /**
     * Constructor
     *
     */
    public function BaseObjectWithErrors()
    {
        $this->clearErrors();
    }

    /**
     * Clear Errors
     *
     */
    public function clearErrors()
    {
        $this->_errorMessage = "";
    }

    /**
     * Get Last added Error
     *
     */
    public function getLastError()
    {
        return $this->_errorMessage;
    }

    /**
     * Added error message
     *
     * @param string $errorMessage
     */
    public function raiseError($errorMessage)
    {
        $this->_errorMessage = $errorMessage;
    }
}
