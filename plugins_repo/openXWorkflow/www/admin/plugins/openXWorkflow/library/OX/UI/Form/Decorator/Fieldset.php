<?php

/**
 * Copied from Zend_Form_Decorator_Fieldset to prevent appending an arbitrary prefix
 * to fieldset html ids.
 */
class OX_UI_Form_Decorator_Fieldset extends Zend_Form_Decorator_Fieldset
{
    /**
     * Copied from Zend_Form_Decorator_Fieldset, except for the line marked with
     * // CHANGE.
     */
    public function render($content)
    {
        $element = $this->getElement();
        $view    = $element->getView();
        if (null === $view) {
            return $content;
        }

        $legend        = $this->getLegend();
        $attribs       = $this->getOptions();
        $name          = $element->getFullyQualifiedName();

        $id = $element->getId();
        if (!empty($id)) {
            $attribs['id'] = $id; // CHANGE: removed 'fieldset-' prefix
        }

        if (null !== $legend) {
            if (null !== ($translator = $element->getTranslator())) {
                $legend = $translator->translate($legend);
            }

            $attribs['legend'] = $legend;
        }

        foreach (array_keys($attribs) as $attrib) {
            $testAttrib = strtolower($attrib);
            if (in_array($testAttrib, $this->stripAttribs)) {
                unset($attribs[$attrib]);
            }
        }

        return $view->fieldset($name, $content, $attribs);
    }
}
