<?php

/**
 * OX-specific div container.
 */
class OX_UI_Form_Element_Div extends Zend_Form_Element_Xhtml
{
    public $helper = 'formDiv';
    protected $class = "typeDiv";
    
    protected $readOnlyValue;
    protected $url;


    public function setReadOnlyValue($value)
    {
        $this->readOnlyValue = $value;
    }


    public function setUrl($url)
    {
        $this->url = $url;
    }


    public function setWidth($width)
    {
        $this->addClass($width);
    }


    public function addClass($value)
    {
        $this->class = OX_UI_Form_Element_Utils::addClass($this->class, $value);
    }


    /**
     * <b>Appends</b> a value to the class attribute if the value does not exist there
     * yet. This is a bit of a hack: it's easiest to call this method setClass because
     * ZF will then handle setting the variables for us.
     */
    public function setClass($value)
    {
        $this->addClass($value);
    }


    public function getValue()
    {
        if ($this->readOnlyValue) {
            return $this->readOnlyValue;
        }
        else {
            return parent::getValue();
        }
    }
}