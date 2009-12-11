<?php

/**
 * Displays an exception stack trace, useful on custom error screens.
 */
class OX_UI_View_Helper_ExceptionStacktrace extends OX_UI_View_Helper_WithViewScript
{
    public static function exceptionStacktrace(Exception $exception)
    {
        $model = array(
            'exception' => $exception,
            'productionMode' => OX_Common_Config::isProductionMode()
        );
        if ($exception instanceof OX_Common_Exception)
        {
            $model['details'] = $exception->getDetails(); 
        }
        
        return parent::renderViewScript("exception-stacktrace.html", $model);
    }
}
