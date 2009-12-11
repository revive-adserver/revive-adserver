<?php

/**
 * A base class for views that render their content using a view script.
 */
class OX_UI_View_Helper_WithViewScript
{
    /**
     * Renders the provided view scripts with the provided model varialbles.
     * 
     * @param $scriptPath path to the script to render
     * @param $model view variables for the script
     * @return the results of view rendering
     */
    protected static function renderViewScript($scriptPath, $model = array())
    {
        $view = Zend_Registry::getInstance()->get("smartyView");
        return $view->partial($scriptPath, $model);
    }
}
