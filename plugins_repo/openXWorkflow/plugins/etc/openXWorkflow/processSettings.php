<?php

/**
 * A class that deals with configuration settings for this group of components
 *
 */
class openXWorkflow_processSettings
{

    /**
     * Method that is called on settings form submission
     * Error messages are appended to the 0 index of the array
     *
     * @return boolean
     */
    function validate(&$aErrorMessage)
    {
        if (isset($GLOBALS['demoUserInterface_message1']))
        {
            if (!$GLOBALS['demoUserInterface_message1'])
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