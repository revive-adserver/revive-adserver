<?php

/**
 * Renders a horizontal divider.
 */
class OX_UI_Form_Element_Divider extends Zend_Form_Element_Xhtml
{
    protected $_rule = true;
    
    protected $_compact = false;


    public function init()
    {
        parent::init();
        $this->setAttrib('li_class', 'divider' . ($this->_rule ? '' : ' no-rule') . ($this->_compact ? ' compact' : ''));
    }


    public function render(Zend_View_Interface $view = null)
    {
        return '<hr />';
    }


    public function setRule($rule)
    {
        $this->_rule = $rule;
    }


    public function setCompact($compact)
    {
        $this->_compact = $compact;
    }
}
