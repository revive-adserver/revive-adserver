<?php

/**
 * 
 */
final class OX_UI_Form_Validate_ValidationEnabledCallbackWrapper
{
    private $wrappedValidationEnabledCallback;
    
    /**
     * @var OX_UI_Form_Validate_ValidationEnabledController
     */
    private $validationEnabledController;


    public function __construct($wrappedValidationEnabledCallback, 
            OX_UI_Form_Validate_ValidationEnabledController $validationEnabledController)
    {
        $this->wrappedValidationEnabledCallback = $wrappedValidationEnabledCallback;
        $this->validationEnabledController = $validationEnabledController;
    }


    public function isValidationEnabled($value, $context)
    {
        return $this->validationEnabledController->isValidationEnabled($value, $context) && 
            (count($this->wrappedValidationEnabledCallback) != 2 || 
                call_user_func($this->wrappedValidationEnabledCallback, $value, $context));
    }
    
    
    public static function wrapValidationEnabledCallback(Zend_Form_Element $element,
        OX_UI_Form_Validate_ValidationEnabledController $controller)
    {
        if ($element instanceof OX_UI_Form_Element_Line) {
            $elements = $element->getElements();
            foreach ($elements as $element) {
                self::wrapValidationEnabledCallback($element, $controller);
            }
        }
        else {
            if (method_exists($element, 'getValidationEnabledCallback') && 
                    method_exists($element, 'setValidationEnabledCallback')) {
                $callbackToWrap = $element->getValidationEnabledCallback();
                $element->setValidationEnabledCallback(array (
                        new OX_UI_Form_Validate_ValidationEnabledCallbackWrapper($callbackToWrap, $controller), 
                        'isValidationEnabled'));
            }
        }
    }
    
}
