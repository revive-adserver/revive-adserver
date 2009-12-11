<?php

/**
 * A class that deals with configuration settings for this group of components
 *
 */
class openXWorkflow_processPreferences
{

    /**
     * Method that is called on settings form submission
     * Error messages are appended to the 0 index of the array
     *
     * @return boolean
     */
    function validate(&$aErrorMessage)
    {
        if (isset($GLOBALS['demopref_Admin']))
        {
            if (!$GLOBALS['demopref_Admin'])
            {
               $myErrorCondition = true;
               $strMyErrorMessage = 'Error';
            }
        }
        // test
        /*$myErrorCondition = true;
        $strMyErrorMessage = 'Error';*/
        if ($myErrorCondition)
        {
            $aErrorMessage[0][] = $strMyErrorMessage;
            return false;
        }
        return true;
    }
}


?>