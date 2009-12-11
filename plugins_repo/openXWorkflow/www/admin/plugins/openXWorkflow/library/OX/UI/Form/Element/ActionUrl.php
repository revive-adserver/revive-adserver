<?php

/**
 * An action url that can be rendered in forms.
 */
class OX_UI_Form_Element_ActionUrl extends OX_UI_Form_Element_Xhtml
{
    /** Action */
    protected $action;
    
    /** Controller */
    protected $controller = null;
    
    /** Module */
    protected $module = null;
    
    /** Parameters */
    protected $params = null;

    protected $_width;
    
    
    public function loadDefaultDecorators()
    {
        $this->setAttrib('noForAttribute', true);
        
        parent::loadDefaultDecorators();
        $this->addDecorator('Label');
        $this->addDecorator('ActionUrl', 
            array('action' => $this->action, 
                'controller' => $this->controller, 
                'module' => $this->module, 
                'params' => $this->params));
    }
    
    
    public function isValid($value, $context = null)
    {
        return true;
    }
    
    
    public function setWidth($width)
    {
        $this->_width = $width;
    }


    public function getWidth()
    {
        return $this->_width;
    }
}
