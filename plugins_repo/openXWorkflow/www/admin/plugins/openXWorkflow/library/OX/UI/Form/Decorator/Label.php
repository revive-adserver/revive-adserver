<?php

/**
 * A decorator that renders custom OX-specific form element labels. It inserts both
 * the main label, as well as the "hint" label below the field.
 */
class OX_UI_Form_Decorator_Label extends Zend_Form_Decorator_Label
{
    public function render($content)
    {
        $element = $this->getElement();
        $view = $element->getView();
        if (null === $view) {
            return $content;
        }
        
        // Prepare main label
        $mainLabel = $this->getLabel();
        if (!empty($mainLabel)) {
            // Ideally, we'd use the built-in view helper to render the label,
            // but there is no way to disable content escaping there, and we need to
            // render tags inside the <label> tag.
            $required = $element->isRequired();
            if ($required) {
                $mainLabel .= "<span class='required'>*</span>";
            }
            
            // Check if the element wants to have the 'for' attribute generated in the label.
            // Some elements will not have one form element corresponding to that form
            // attribute and if we still generate, the page will not validate.
            $includeFor = !$element->getAttrib('noForAttribute');
            $mainLabel = self::makeLabel($mainLabel, 'title', $element, $includeFor);
        }
        
        // Prepare hint label
        $hintLabel = $element->getAttrib('title');
        if (!empty($hintLabel)) {
            $hintLabel = self::makeLabel($hintLabel, 'hint', $element);
        }
        
        return $mainLabel . $content . $hintLabel;
    }


    private static function makeLabel($content, $class, $element, $includeFor = true)
    {
        $result = OX_UI_Form_Decorator_Utils::wrap($content, array (
                'tag' => 'span', 
                'class' => $class));
        $labelOptions = array ('tag' => 'label');
        if ($includeFor) {
            $labelOptions['for'] = $element->getName();
        }
        
        return OX_UI_Form_Decorator_Utils::wrap($result, $labelOptions);
    }
}