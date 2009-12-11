<?php

/**
 * An OX-specific form line. Rather than creating instances of this class, use
 * OX_UI_Form::addFormLine().
 */
class OX_UI_Form_Element_Line extends Zend_Form_Element_Xhtml
{
    /** Elements in this line */
    protected $elements = array ();
    
    /** Margin description type for this element. Values: 'info', 'confirm', 'warning', 'error'. */
    protected $descriptionType = 'info';
    
    protected $descriptionClass = null;
    protected $descriptionId = null;
    protected $descriptionOnFocus = false;
    
    protected $prefix;
    
    protected $suffix;
    
    public $helper = 'formLine';
    

    public function render(Zend_View_Interface $view = null)
    {
        $this->loadDecorators();
        return parent::render($view);
    }
    
    
    private function loadDecorators()
    {
        $this->addDecorator('LineElements');
        // Can't have LineErrors as a name here because it ends in "Errors" and removing
        // the "Errors" decorator would remove that one as well (see Element::getDecorator() 
        /// for the reason).
        $this->addDecorator('LineErrorList');
        $this->addDecorator('LineFieldset');
        
        if (!empty($this->_description)) {
            $this->addDecorator("ViewScript", array (
                    'viewScript' => 'message.html', 
                    'placement' => 'append', 
                    'message' => $this->_description, 
                    'messageType' => $this->descriptionType, 
                    'messageClass' => $this->descriptionClass 
                        . ($this->descriptionOnFocus ? ' messageOnFocus' : ''), 
                    'messageId' => $this->descriptionId));
        }
        
        // This is a bit of a hack. Ideally, it is the DisplayGroup that should
        // take care of wrapping its children in ol/li, but there is no way to do
        // that for the time being using ZF mechanisms. The main list tag is rendered
        // by the OX_UI_Form_Decorator_SectionFieldset class.
        $liOptions = array (
                'tag' => 'li');
        $liId = $this->getAttrib('id');
        if ($liId) {
            $liOptions['id'] = $liId;
        }
        $liClass = $this->getAttrib('class');
        if ($liClass) {
            $liOptions['class'] = $liClass;
        }
        $this->addDecorator(array ('LiTag' => 'HtmlTag'), $liOptions);
    }
    

    public function refresh()
    {
        $this->clearDecorators();
        $this->loadDefaultDecorators();
    }


    public function addElements($elements)
    {
        foreach ($elements as $element) {
            $this->elements[] = $element;
            $element->setAttrib('line', $this);
        }
    }


    public function getElements()
    {
        return $this->elements;
    }


    /**
     * Fixes a bug in ZF: http://framework.zend.com/issues/browse/ZF-3656
     */
    public function getDecorator($name)
    {
        if (!isset($this->_decorators[$name])) {
            $decorators = array_keys($this->_decorators);
            $len = strlen($name);
            foreach ($decorators as $decorator) {
                if (strlen($decorator) >= $len && 0 === substr_compare($decorator, $name, -$len, $len, true)) {
                    return $this->_decorators[$decorator];
                }
            }
            return false;
        }
        
        return $this->_decorators[$name];
    }


    public function setDescriptionType($type)
    {
        $this->descriptionType = $type;
    }


    public function setDescriptionClass($class)
    {
        $this->descriptionClass = $class;
    }


    public function setDescriptionId($id)
    {
        $this->descriptionId = $id;
    }

    
    public function setDescriptionOnFocus($isOnFocus)
    {
        $this->descriptionOnFocus = $isOnFocus;
    }
    
    
    public function getPrefix()
    {
        return $this->prefix;
    }


    public function setPrefix($prefix)
    {
        $this->prefix = $prefix;
    }


    public function getSuffix()
    {
        return $this->suffix;
    }


    public function setSuffix($suffix)
    {
        $this->suffix = $suffix;
    }
    
    
    public function getOrder()
    {
        return null;
    }
}
