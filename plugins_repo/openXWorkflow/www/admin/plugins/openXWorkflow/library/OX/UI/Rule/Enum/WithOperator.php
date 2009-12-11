<?php

/**
 * Base class for rules that take values from a predefined list and has positive or negative
 * operator.
 */
abstract class OX_UI_Rule_Enum_WithOperator extends OX_UI_Rule_Enum
{
    const NOT_RELEVANT_VALUE = 'nr';
    const POSITIVE_VALUE = 'in';
    const NEGATIVE_VALUE = 'ex';
    
    const NOT_RELEVANT_VALUE_LABEL = 'all';
    const POSITIVE_MULTI_LABEL = 'is any of';
    const POSITIVE_SINGLE_LABEL = 'is';
    const NEGATIVE_MULTI_LABEL = 'is not any of';
    const NEGATIVE_SINGLE_LABEL = 'is not';
    
    /**
     * Whether to show 'all' option in the operator combo box. Also, if the 'all'
     * option is shown, the list of values is loaded in a lazy fashion.
     */
    protected $hasNotRelevantOperatorValue = true;
    
    private static $optionsHandlerModule;
    private static $optionsHandlerController;
    private static $optionsHandlerAction = 'options';


    public function __construct($hasNotRelevantOperatorValue = true)
    {
        $this->hasNotRelevantOperatorValue = $hasNotRelevantOperatorValue;
    }


    public static function setOptionsHandler($module, $controller)
    {
        self::$optionsHandlerController = $controller;
        self::$optionsHandlerModule = $module;
    }


    abstract public function isPositive();


    abstract public function populateRulePositive($positive);


    /**
     * Adds the operator-specific rule elements.
     */
    public function addRuleElementsWithLine(OX_UI_Form $form, 
            array $lineOptions = array())
    {
        $multiOptions = array ();
        if ($this->hasNotRelevantOperatorValue()) {
            $multiOptions[self::NOT_RELEVANT_VALUE] = $this->getNotRelevantValueLabel();
        }
        $multiOptions[self::POSITIVE_VALUE] = $this->isMultiSelect() ? self::POSITIVE_MULTI_LABEL : self::POSITIVE_SINGLE_LABEL;
        $multiOptions[self::NEGATIVE_VALUE] = $this->isMultiSelect() ? self::NEGATIVE_MULTI_LABEL : self::NEGATIVE_SINGLE_LABEL;
        
        $opElementOptions = array ('class' => 'ruleOp', 
                'width' => OX_UI_Form_Element_Widths::MEDIUM_SMALL, 
                'multiOptions' => $multiOptions);
        $form->addElementWithLine('select', $this->getOperatorName(), $this->getLineName(), $opElementOptions, $lineOptions);
        
        // Add options element only if we're in eager loading mode
        if ($this->isOptionLazyLoadingAllowed()) {
            $form->addElementWithLine('progress', $this->getHtmlId('Loading'), $this->getLineName(), array (
                    'li_class' => 'hide', 
                    'class' => ''));
        }
        else {
            parent::addRuleElementsWithLine($form, $lineOptions);
        }
    }


    protected function isOptionLazyLoadingAllowed()
    {
        return $this->hasNotRelevantOperatorValue && $this->isEmpty() && !isset($_REQUEST[$this->type]);
    }


    public function renderRuleExpression()
    {
        $stringValues = $this->getStringValues();
        return '<em>' . $this->label . '</em> ' . $this->renderOperatorText(count($stringValues)) . ' ' . join($stringValues, ', ');
    }


    protected function renderOperatorText($count)
    {
        if ($this->isPositive()) {
            if ($this->isMultiSelect() && $count > 1) {
                return self::POSITIVE_MULTI_LABEL;
            }
            else {
                return self::POSITIVE_SINGLE_LABEL;
            }
        }
        else {
            if ($this->isMultiSelect() && $count > 1) {
                return self::NEGATIVE_MULTI_LABEL;
            }
            else {
                return self::NEGATIVE_SINGLE_LABEL;
            }
        }
    }


    protected function hasNotRelevantOperatorValue()
    {
        return $this->hasNotRelevantOperatorValue;
    }


    public function addRuleSpecificElementsWithLine(OX_UI_Form $form, 
            array $lineOptions = array())
    {
        parent::addRuleElementsWithLine($form, $lineOptions);
    }


    protected function customInlineScript(OX_UI_Form $form)
    {
        $optionsHandlerUrl = OX_UI_View_Helper_ActionUrl::actionUrl(self::$optionsHandlerAction, 
            self::$optionsHandlerController, self::$optionsHandlerModule, array (
                'type' => $this->type));
        
        $lazyLoadingScript = '$("#' . $this->getOperatorName() . '").ruleOperator("' . 
            $optionsHandlerUrl . '", ' . $this->afterOptionsLoadedFunction() . ');';
        
        $eagerLoadingScript = '$("#' . $this->getOperatorName() . '").ruleOperator(); ' . 
            OX_Common_ObjectUtils::getDefault($this->afterOptionsLoadedScript(), '');
        
        return ($this->isOptionLazyLoadingAllowed() ? $lazyLoadingScript : $eagerLoadingScript);
    }


    private function afterOptionsLoadedFunction()
    {
        // Script provided by the element
        $script = $this->afterOptionsLoadedScript();
        
        // Script rendered by the element from the parent class
        // We'll need some hack here: we're rendering the element in response to AJAX 
        // requests, so the element is not added to the form when the master page renders.
        // For this reason, we'll need to render the element here as well to some dummy
        // form, just to retrieve the script it would generate. To speed things up,
        // we'll render the element with an empty options list.
        $dummyForm = new OX_UI_Form();
        $this->addEnumOptionsElementWithLine($dummyForm, array (), array ());
        $element = $dummyForm->getElement($this->type);
        if ($element instanceof OX_UI_Form_Element_WithInlineScript) {
            $elementScript = $element->getInlineScript();
            if (!empty($elementScript)) {
                $script .= ' ' . $elementScript;
            }
        }
        
        if (isset($script)) {
            return 'function() { ' . $script . ' }';
        }
        else {
            return 'null';
        }
    }


    protected function afterOptionsLoadedScript()
    {
        return null;
    }


    public function populateForm(OX_UI_Form $form)
    {
        if ($this->isEmpty()) {
            $form->populate(array (
                    $this->getOperatorName() => self::NOT_RELEVANT_VALUE));
        }
        else {
            $form->populate(array (
                    $this->getOperatorName() => $this->isPositive() ? self::POSITIVE_VALUE : self::NEGATIVE_VALUE, 
                    $this->type => $this->getEnumValues()));
        }
    }


    public function populateRule(OX_UI_Form $form)
    {
        if ($this->isClear($form)) {
            $this->clearRule();
        }
        else {
            $this->populateRulePositive($this->getPositiveValue($form));
            
            // We're guaranteed to get the value from the form here as we insert the
            // appropriate form elements if the request contains values for this rule
            parent::populateRule($form);
        }
    }


    public function beforeRender(OX_UI_Form $form)
    {
        parent::beforeRender($form);
        
        // Make operator and values selection consistent. This is correct only
        // with the assumption that an empty list means empty rule. In some cases
        // this may not hold (e.g. if empty values means 'set to any value', while
        // empty rule means 'not set at all').
        if ($this->isClear($form))
        {
            $element = $form->getElement($this->type);
            // Due to lazy loading, the element may not be present in the form
            if ($element) {
                if ($element instanceof OX_UI_Form_Element_MultiCheckbox) {
                    $element->setContainerClass('hide');
                } else {
                    OX_UI_Form_Element_Utils::addClassInElementOptions($element, 'hide');
                }
            }
            $form->populate(array (
                    $this->getOperatorName() => self::NOT_RELEVANT_VALUE,
                    $this->type => null));
        }
    }


    protected function getPositiveValue(OX_UI_Form $form)
    {
        return $form->getValue($this->getOperatorName()) == self::POSITIVE_VALUE;
    }


    private function isClear(OX_UI_Form $form)
    {
        $values = $form->getValue($this->type);
        return $form->getValue($this->getOperatorName()) == self::NOT_RELEVANT_VALUE || empty($values);
    }


    protected function getOperatorName()
    {
        return $this->getHtmlId('Op');
    }
    
    
    protected function getNotRelevantValueLabel()
    {
        return self::NOT_RELEVANT_VALUE_LABEL;
    }
}
