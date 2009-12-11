<?php

/**
 * A decorator that renders form line <fieldsets>. We need a dedicated decorator here
 * because we need do add a custom class when the line contains erroneous elements inside.
 */
class OX_UI_Form_Decorator_LineFieldset extends Zend_Form_Decorator_Fieldset
{


    public function render($content)
    {
        $line = $this->getElement();
        if ($line instanceof OX_UI_Form_Decorator_LineElements) {
            return $content;
        }
        
        // Error rendering
        $elements = $line->getElements();
        $hasErrors = false;
        $hasLabel = false;
        foreach ($elements as $element) {
            if (count($element->getMessages()) > 0) {
                $hasErrors = true;
            }
            
            if (strlen($element->getLabel()) > 0 && !($element instanceof Zend_Form_Element_Button)) {
                $hasLabel = true;
            }
        }
        
        // Line fieldset
        $fieldsetOptions = array (
                'tag' => 'fieldset');
        if ($hasErrors) {
            self::appendString($fieldsetOptions, 'class', ' error');
        }
        if (!$hasLabel) {
            self::appendString($fieldsetOptions, 'class', ' noTitle');
        }
        
        // Line prefix/suffix
        if ($line->getSuffix()) {
            $content = $content . OX_UI_Form_Decorator_Utils::wrap($line->getSuffix(), array (
                    'tag' => 'div', 
                    'class' => 'lineSuffix'));
        }
        if ($line->getPrefix()) {
            $content = OX_UI_Form_Decorator_Utils::wrap($line->getPrefix(), array (
                    'tag' => 'div', 
                    'class' => 'linePrefix')) . $content;
        }
        
        return OX_UI_Form_Decorator_Utils::wrap($content, $fieldsetOptions);
    }
    
    private static function appendString(&$a, $key, $string)
    {
        if (isset($a[$key]))
        {
            $a[$key] .= $string;
        }
        else 
        {
            $a[$key] = $string;
        }
    }
}