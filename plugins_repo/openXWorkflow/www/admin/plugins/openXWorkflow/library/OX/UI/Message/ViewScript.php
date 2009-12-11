<?php

/**
 * A view based class confirmation/error message containers.
 */
class OX_UI_Message_ViewScript extends OX_UI_Message_Abstract
{
    private $viewScript;
    
    private $model;


    public function __construct(array $options = array())
    {
        parent::__construct($options);
    }


    /**
     * Returns this message rendering as string.
     */
    public function render()
    {
        $partial = new Zend_View_Helper_Partial();
        $partial->setView(Zend_Registry::getInstance()->get("smartyView"));
        return $partial->partial($this->viewScript, $this->model);
    }


    public function setViewScript($viewScript)
    {
        $this->viewScript = $viewScript;
    }


    public function setModel($model)
    {
        $this->model = $model;
    }
}
