<?php

/**
 * Renders form lines.
 */
class OX_UI_Form_Decorator_LineElements extends Zend_Form_Decorator_Abstract
{
    
    public function render($content)
    {
        $element = $this->getElement();
        if ($element instanceof OX_UI_Form_Decorator_LineElements) {
            return $content;
        }
        
        if (! method_exists($element, 'getElements')) {
            return $content;
        }
        
        $elements = $element->getElements();
        $view = $element->getView();
        
        // ViewScript helper for rendering hint balloons
        $balloonDecorator = new Zend_Form_Decorator_ViewScript();
        $balloonDecorator->setViewScript('balloon-hint.html');
        $balloonDecorator->setElement($element);
        
        // Concatenate the outputs of all line's elements.
        $content = "";
        
        foreach ($elements as $lineElement) {
            $lineElement->setAttrib('line', null);
            
            // Get balloon hint and remove before rendering
            // so that it does not get rendered as an html attribute
            $hint = $lineElement->getAttrib('hint');
            $lineElement->setAttrib('hint', null);
            
            // Get li element options and remove them from attrs before rendering
            $liOptions = array_merge($this->getLiOptions($lineElement), array ('tag' => 'li'));
            $renderedElement = $lineElement->render($view);
            $errors = $lineElement->getMessages();
            if (count($errors) > 0) {
                OX_UI_Form_Element_Utils::addClassInOptions($liOptions, 'error');
            }
            $renderedElement = OX_UI_Form_Decorator_Utils::wrap($renderedElement, $liOptions);
            $content .= $renderedElement;
            
            // Render hint if needed
            if ($hint) {
                $balloonDecorator->setOption('message', $hint);
                $content .= '<li>' . $balloonDecorator->render('') . '</li>';
            }
        }
        
        $content = '<ol>' . $content . '</ol>';
        
        return $content;
    }
    
    private function getLiOptions(&$lineElement)
    {
        $result = array();
        $attribs = $lineElement->getAttribs();
        foreach($attribs as $key => $value)
        {
            if (strpos($key, 'li_') === 0)
            {
                $result[substr($key, 3)] = $value;
                $lineElement->setAttrib($key, null);
            }
        }
        return $result;
    }
}
