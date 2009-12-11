<?php

/**
 * Renders a loading and confirmation indicators.
 */
class OX_UI_Form_Element_Progress extends Zend_Form_Element_Xhtml
{
    const ICON_LOADING = 'iconLoading';
    const ICON_CONFIRM = 'iconConfirm';
    
    protected $_text = 'Loading...';
    
    protected $_icon = self::ICON_LOADING;
    
    protected $_class = 'hide';
    
    protected $_id = '';


    public function render(Zend_View_Interface $view = null)
    {
        $result = '<span id="' . $this->getName() . '" ';
        $result .= 'class="inlineIcon ' . $this->_icon . ' ' . $this->_class . '">';
        $result .= $this->_text;
        $result .= '</span>';
        return $result;
    }


    public function setText($text)
    {
        $this->_text = $text;
    }


    public function setIcon($icon)
    {
        $this->_icon = $icon;
    }


    public function setClass($class)
    {
        $this->_class = $class;
    }


    public function setId($id)
    {
        $this->_id = $id;
    }
}
