<?php

/**
 * Creates a read-only area for content to be copied and pasted somewhere else by the
 * users. On Internet Explorer 
 */
class OX_UI_Form_Fragment_CopyTextarea extends OX_UI_Form_Fragment_Default
{
    private $name;
    private $value;
    private $displayGroupName;
    private $displayGroupOptions;


    /**
     * Creates a CopyTextarea fragment.
     * 
     * @param $options options to set for this copy textarea. For each key in the option 
     * array, a corresponding setter method will be called with the value provided as 
     * an argument, e.g. for the key 'name', setName(value) will be called. For the 
     * description of specific options, see setter method documentation.
     */
    public function __construct(array $options = array())
    {
        $this->displayGroupOptions = array();
        OX_Common_ObjectUtils::setOptions($this, $options);
        if (empty($this->displayGroupName))
        {
            $this->displayGroupName = 'TextareaGroup';
        }
        if (empty($this->displayGroupOptions['legend']))
        {
            $this->displayGroupOptions['legend'] = 'Copy text area';
        }
    }


    public function build(OX_UI_Form $form, array $values)
    {
        $form->addElementWithLine('textarea', $this->name('Textarea'), $this->name('TextareaLine'), array (
                'value' => $this->value, 
                'class' => 'copyTextarea', 
                'readonly' => 'readonly', 
                'width' => OX_UI_Form_Element_Widths::EXTRA_LARGE, 
                'height' => OX_UI_Form_Element_Heights::EXTRA_LARGE), array (
                'id' => $this->name('TextareaLine')));
        $form->addElementWithLine('content', $this->name('Links'), $this->name('TextareaLine'), array (
                'content' => '', 
                'li_class' => 'copyTextareaLinks'));
        $form->addDisplayGroup(array ($this->name('TextareaLine')), $this->name($this->displayGroupName), 
            $this->displayGroupOptions);
        
        OX_UI_View_Helper_InlineScriptOnce::inline('$("#' . $this->name('TextareaLine') . '").formCopyTextarea();');
    }


    private function name($suffix = '')
    {
        return $this->name . $suffix;
    }

    
    public function getName()
    {
        return $this->name;
    }


    public function getValue()
    {
        return $this->value;
    }

    
    /**
     * Sets a name for this fragment. If you need to have more than one instance of this
     * fragment on one form, you need to give them different names. Otherwise, you don't
     * need to set the name at all.
     */
    public function setName($name)
    {
        $this->name = $name;
    }


    public function setValue($value)
    {
        $this->value = $value;
    }


    public function setDisplayGroupOptions($displayGroupOptions)
    {
        $this->displayGroupOptions = $displayGroupOptions;
    }


    public function setDisplayGroupName($displayGroupName)
    {
        $this->displayGroupName = $displayGroupName;
    }


    public function getDisplayGroupOptions()
    {
        return $this->displayGroupOptions;
    }


    public function getDisplayGroupName()
    {
        return $this->displayGroupName;
    }
}