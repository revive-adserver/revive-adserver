<?php

/**
 * A decorator that renders custom OX-specific field set. The default one cannot render
 * render tags inside <legend> and this is what we need.
 */
class OX_UI_Form_Decorator_SectionFieldset extends Zend_Form_Decorator_Fieldset
{
    public function render($content)
    {
        $result = htmlspecialchars($this->getLegend());
        $hasLegend = strlen($result) > 0;
        
        if ($hasLegend) {
            $result = OX_UI_Form_Decorator_Utils::wrap($result, array (
                    'tag' => 'span', 
                    'class' => 'header'));
            $result = OX_UI_Form_Decorator_Utils::wrap($result, array (
                    'tag' => 'legend'));
        }
        
        $result .= OX_UI_Form_Decorator_Utils::wrap($content, array (
                'tag' => 'ol'));
        
        $fieldsetTag = array ('tag' => 'fieldset');
        
        $element = $this->getElement();
        $cssClass = $element->getAttrib('class');
        if (!$hasLegend)
        {
            $cssClass = OX_UI_Form_Element_Utils::addClass($cssClass, 'noLegend');
        }
        if ($cssClass) {
            $fieldsetTag['class'] = $cssClass;
        }
        $id = $element->getAttrib('id');
        if ($id) {
            $fieldsetTag['id'] = $id;
        }
        
        $result = OX_UI_Form_Decorator_Utils::wrap($result, $fieldsetTag);
        
        return $result;
    }
}
