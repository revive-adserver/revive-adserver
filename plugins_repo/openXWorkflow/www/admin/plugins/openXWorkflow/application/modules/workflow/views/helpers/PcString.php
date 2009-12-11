<?php

/**
 * A PC string replacement helper. Uses OX_Common_Translate as a backend
 */
class Workflow_View_Helper_PcString extends OX_UI_View_Helper_WithViewScript
{
    /**
     * Helper method for string translations. Supports substitions in the value.
     * Provide an array of $KEY => value replecements. Method will replace all
     * occurences of '$KEY' string with value.
     * 
     * Please not that interpolation is also performed on default value.
     *
     * @param string $pageId a name of the page string comes from 
     * @param string $stringId identifier of the string  for the page
     * @param string $defaultValue a value that should be returned if no PC string is found;
     * @param array array of replacement strings to be inserted into retrieved value
     */
    public static function pcString($pageId, $stringId, $defaultValue, $stringReplacements = null)
    {
        $value = OX_Workflow_PC_PCStringManager::getInstance()->getPCString($pageId, $stringId);
        
        $value = $value === null ? $defaultValue : $value;
        
        if (!empty($stringReplacements)) {
            $value  = str_replace(array_keys($stringReplacements), 
                array_values($stringReplacements), $value);
        }
        
        return $value;
    }
}

