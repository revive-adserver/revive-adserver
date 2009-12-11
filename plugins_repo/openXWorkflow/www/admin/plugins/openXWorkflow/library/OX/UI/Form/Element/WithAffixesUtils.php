<?php

/**
 * Some utility methods helpful for implementing OX_UI_Form_Element_WithAffixes.
 * Utils in this class assume that the provided element extends Zend_Element.
 */
final class OX_UI_Form_Element_WithAffixesUtils
{
    public static function addAllDecorators(OX_UI_Form_Element_WithAffixes $element)
    {
        $element->addDecorator('ViewHelper');
        $elementInvisible = OX_UI_Form_Element_Utils::isClassSetInElement($element, 'invisible');
        if (strlen($element->getPrefix()) > 0) {
            $element->addDecorator(array (
                        'PrefixCustomLabel' => 'CustomLabel'), array (
                        'labelText' => $element->getPrefix(), 
                        'class' => 'affix prefix' . ($elementInvisible ? ' invisible' : '')));
        }
        
        $element->addDecorator('Label');
        if (strlen($element->getSuffix()) > 0) {
            $element->addDecorator(array (
                        'SuffixCustomLabel' => 'CustomLabel'), array (
                        'labelText' => $element->getSuffix(), 
                        'class' => 'affix suffix' . ($elementInvisible ? ' invisible' : ''), 
                        'placement' => 'APPEND'));
        }
    }
}
