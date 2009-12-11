<?php
require_once 'OX/UI/View/Helper/ActionUrl.php';

/**
 * Represents a page action or shortcut.
 */
class OX_UI_Menu_Shortcut
{
    /** Human-readable label of the shortcut */
    private $label;
    
    /** Icon for this action */
    private $icon;
    
    /** Module, controller, action and optional params for the shortcut */
    private $module;
    private $controller;
    private $action;
    private $params;

    public function __construct($label, $icon, $action, $controller = null, $module = null, array $params = null)
    {
        $this->label = $label;
        $this->icon = $icon;
        $this->module = $module;
        $this->controller = $controller;
        $this->action = $action;
        $this->params = $params;
    }

    public function getAction()
    {
        return $this->action;
    }

    public function getController()
    {
        return $this->controller;
    }

    public function getIcon()
    {
        return $this->icon;
    }

    public function getLabel()
    {
        return $this->label;
    }

    public function getModule()
    {
        return $this->module;
    }

    public function getParams()
    {
        return $this->params;
    }

    public function getActionUrl()
    {
        return OX_UI_View_Helper_ActionUrl::actionUrl($this->action, 
            $this->controller, $this->module, 
            $this->params);
    }
}
