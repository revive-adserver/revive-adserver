<?php

/**
 * OX-specific multi-checkbox, wrapped with an extra grouping div.
 */
class OX_UI_Form_Element_MultiCheckbox extends Zend_Form_Element_MultiCheckbox implements 
        OX_UI_Form_Element_WithInlineScript
{
    private $height;
    
    private $containerClass;
    
    private $customJsMulticheckboxOptions;
    
    protected $_width;
    
    /**
     * Do not autoregister the validator.
     */
    protected $_registerInArrayValidator = false;
    
    protected $_validationEnabledCallback;
    
    /**
     * Parent will be checked if all children are checked, otherwise unchecked.
     */
    const SYNCHRONIZE_WITH_CHILDREN = 'synchronizeParentWithChildren';
    
    /**
     * Children will be checked if parent is checked, otherwise unchecked.
     */
    const SYNCHRONIZE_WITH_PARENT = 'synchronizeChildrenWithParent';
    
    /**
     * Children will be cleared if parent gets checked. Unmodified otherwise. 
     */
    const CLEAR_IF_PARENT_CHECKED = 'clearChildrenIfParentChecked';
    
    /**
     * Parent will be cleared if any child gets checked. Unmodified otherwise.
     */
    const CLEAR_IF_ANY_CHILD_CHECKED = 'clearParentIfAnyChildChecked';
    
    /**
     * In case of hierarchical multicheckboxes, determines how the parent checkbox should 
     * be updated when their children checkboxes change state. Possible values 
     * (see constants): SYNCHRONIZE_WITH_CHILDREN or CLEAR_IF_ANY_CHILD_CHECKED. 
     */
    private $parentUpdating = self::SYNCHRONIZE_WITH_CHILDREN;
    
    /**
     * In case of hierarchical multicheckboxes, determines how the children checkboxes 
     * should be updated when their parent checkbox changes state. Possible values 
     * (see constants): SYNCHRONIZE_WITH_PARENT or CLEAR_IF_ANY_CHILD_CHECKED. 
     */
    private $childUpdating = self::SYNCHRONIZE_WITH_PARENT;


    public function init()
    {
        parent::init();
        $this->setSeparator('');
        $this->setAttrib('noForAttribute', true);
        if (!$this->getAttrib('id')) {
            $this->setAttrib('id', $this->getName());
        }
        $this->setContainerClass(OX_UI_Form_Element_Widths::getWidthClass($this));
    }


    public function render(Zend_View_Interface $view = null)
    {
        // We defer adding the extra decorator until the render phase
        // so that we get the most current values of attributes rendered (class, 
        // width, height etc.)
        $options = array (
                'tag' => 'div', 
                'class' => 'multiCheckbox ' . ' ' . $this->height . ' ' . $this->containerClass);
        if ($this->getAttrib('id')) {
            $options['id'] = $this->getAttrib('id');
        }
        $this->addDecorator(array ('WrapperDivTag' => 'HtmlTag'), $options);
        
        OX_UI_View_Helper_InlineScriptOnce::inline($this->getInlineScript());
        return parent::render($view);
    }


    public function getInlineScript()
    {
        $selector = ($this->getAttrib('id') ? '#' . $this->getAttrib('id') : '.multiCheckbox');
        $options = '{ updateChildren: $.multicheckbox.' . $this->childUpdating . ', updateParent: $.multicheckbox.' . $this->parentUpdating . ' }';
        return '$("' . $selector . '").multicheckboxes(' . $options . ');';
    }


    public function setHeight($height)
    {
        $this->height = $height;
    }


    public function setContainerClass($class)
    {
        $this->containerClass = OX_UI_Form_Element_Utils::addClass($this->containerClass, $class);
    }


    public function setChildUpdating($childUpdating)
    {
        if ($childUpdating != self::CLEAR_IF_PARENT_CHECKED && $childUpdating != self::SYNCHRONIZE_WITH_PARENT) {
            throw new Exception('childUpdating must be:' . self::CLEAR_IF_PARENT_CHECKED . ' or ' . self::SYNCHRONIZE_WITH_PARENT);
        }
        $this->childUpdating = $childUpdating;
    }


    public function setParentUpdating($parentUpdating)
    {
        if ($parentUpdating != self::CLEAR_IF_ANY_CHILD_CHECKED && $parentUpdating != self::SYNCHRONIZE_WITH_CHILDREN) {
            throw new Exception('parentUpdating must be:' . self::CLEAR_IF_ANY_CHILD_CHECKED . ' or ' . self::SYNCHRONIZE_WITH_CHILDREN);
        }
        $this->parentUpdating = $parentUpdating;
    }


    public function setWidth($width)
    {
        $this->_width = $width;
    }


    public function getWidth()
    {
        return $this->_width;
    }


    /**
     * <b>Appends</b> a value to the class attribute if the value does not exist there 
     * yet. This is a bit of a hack: it's easiest to call this method setClass because 
     * ZF will then handle setting the variables for us.
     */
    public function setClass($value)
    {
        $this->class = OX_UI_Form_Element_Utils::addClass($this->class, $value);
    }


    public function getValidationEnabledCallback()
    {
        return $this->_validationEnabledCallback;
    }


    public function setValidationEnabledCallback(array $callback)
    {
        $this->_validationEnabledCallback = $callback;
    }


    /**
     * Overridden to support conditional validation.
     */
    public function isValid($value, $context = null)
    {
        if (count($this->_validationEnabledCallback) == 2 && call_user_func($this->_validationEnabledCallback, $value, $context) === false) {
            return true;
        }
        else {
            return parent::isValid($value, $context);
        }
    }
}