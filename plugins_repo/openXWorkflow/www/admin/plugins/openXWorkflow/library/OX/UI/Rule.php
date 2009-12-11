<?php

/**
 * Manages bid rule form elements: inserts the bid rule components to the provided form, 
 * populates the rule elements from the provided bid rule data object, populates the bid 
 * rule data object from the form. Concrete subclasses of this class represent specific
 * bid rules.
 */
abstract class OX_UI_Rule
{
    /**
     * Type identifier for the bid rule element, overridden in the concrete subclasses.
     */
    public $type;
    
    /**
     * Screen label for the bid rule element, overridden in the concrete subclasses.
     */
    public $label;


    /**
     * Adds the rule-specific elements to the provided form. Concrete subclasses should
     * implement this method to add the specific bid rule element.
     * 
     * @param $form the form the elements should be added to
     * @param $rule|null the rule instance for which the elements are to be built
     * @param $lineOptions form line options that must be passed to the bid rule line
     */
    abstract public function addRuleElementsWithLine(OX_UI_Form $form, 
            array $lineOptions = array());


    /**
     * Renders rule human-readable form expression. HTML markup (e.g. <b></b>) is allowed and 
     * will not be escaped. Make sure the values are properly escaped.
     */
    public function renderRuleExpression()
    {
        return $this->label . ': not implemented';
    }


    public abstract function getRuleInstanceParams();


    /**
     * Override this method to return rule-specific JavaScript to be inlined at
     * the bottom of the page. 
     */
    protected function customInlineScript(OX_UI_Form $form)
    {
        // Remove form parameter?
        return null;
    }


    /**
     * Override this method to provide a label hint; 
     */
    protected function getLabelHint()
    {
        return null;
    }


    /**
     * Override this method to return rule-specific form line options. 
     */
    public function customLineOptions(OX_UI_Form $form)
    {
        // Remove form parameter?
        return null;
    }


    /**
     * Override this method to provide default values for the rule form element. 
     */
    protected function populateFormDefaults(OX_UI_Form $form)
    {
    }


    /**
     * Adds a complete bid rule line to the provided form. Apart from the bid rule specific
     * elements, this method adds a consistent label to all bid rule lines.
     * 
     * @param $form the form the elements should be added to
     * @param $lineOptions form line options that must be passed to the bid rule line
     */
    public final function addRuleWithLine(OX_UI_Form $form, 
            array $lineOptions = array())
    {
        $lineOptions['id'] = $this->getLineName();
        
        // Add custom javascript
        $customInlineScript = $this->customInlineScript($form);
        if ($customInlineScript) {
            OX_UI_View_Helper_InlineScriptOnce::inline($customInlineScript);
        }
        
        $labelOptions = array ('labelText' => $this->label, 
                'width' => OX_UI_Form_Element_Widths::MEDIUM_LARGE);
        if ($this->getLabelHint()) {
            $labelOptions['hint'] = $this->getLabelHint();
        }
        $form->addElementWithLine('label', $this->getHtmlId('Label'), $this->getLineName(), $labelOptions, $lineOptions);
        $this->addRuleElementsWithLine($form, $lineOptions);
        
        // Populate defaults
        $this->populateFormDefaults($form);
        
        // Register render listener
        $form->addListener(new FormRenderListener($this));
        
        return $this->getLineName();
    }


    public function getHtmlId($suffix = '')
    {
        return $this->type . $suffix;
    }


    /**
     * Builds the line name for this bid rule element. All subclasses must use this method
     * to construct the line name when adding their elements to the form.
     */
    public final function getLineName()
    {
        return $this->getHtmlId('Line');
    }


    /**
     * Populates the form form element from the provided bid rule. Populates only the 
     * part implemented by the concrete subclass.
     * 
     * @param $form the form to populate
     */
    abstract public function populateForm(OX_UI_Form $form);


    /**
     * Populates the rule from the provided form. Populates only the part implemented
     * by the concrete subclass.
     * 
     * @param $form the form to use the data from
     * @param $oRule the rule to populate
     */
    abstract public function populateRule(OX_UI_Form $form);


    abstract public function clearRule();


    abstract public function isEmpty();

    
    public function beforeRender(OX_UI_Form $form)
    {
    }


    public function addRule(OX_UI_Form $form)
    {
        $this->populateRule($form);
    }


    public function removeRule()
    {
        $this->clearRule();
    }

}

class FormRenderListener extends OX_UI_Form_Listener_Default
{
    /**
     * @var OX_UI_Rule
     */
    private $rule;


    public function __construct(OX_UI_Rule $rule)
    {
        $this->rule = $rule;
    }


    public function beforeRender(OX_UI_Form $form)
    {
        $this->rule->beforeRender($form);
        
        // Add custom line options if any. Line options may depend on the form state
        // so we defer setting until we have to render the form.
        $lineOptions = array ();
        $customLineOptions = $this->rule->customLineOptions($form);
        if (isset($customLineOptions)) {
            foreach ($customLineOptions as $key => $value) {
                $lineOptions[$key] = $value;
            }
        }
        
        if (!empty($lineOptions)) {
            $line = $form->getElement($this->rule->getLineName());
            $line->setOptions($lineOptions);
        }
    }
}
