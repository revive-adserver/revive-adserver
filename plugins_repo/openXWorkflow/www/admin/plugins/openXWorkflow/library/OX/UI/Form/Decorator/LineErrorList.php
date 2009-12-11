<?php

/**
 * Renders errors for all line's elements.
 */
class OX_UI_Form_Decorator_LineErrorList extends Zend_Form_Decorator_Abstract
{


    public function render($content)
    {
        $element = $this->getElement();
        if ($element instanceof OX_UI_Form_Decorator_LineElements) {
            return $content;
        }
        
        if (!method_exists($element, 'getElements')) {
            return $content;
        }
        
        $elements = $element->getElements();
        
        // Concatenate the outputs of all line's elements.
        // Wrap all messages in an <ol> and each line element in <li>.
        $result = "";
        $errorCount = 0;
        
        foreach ($elements as $lineElement) {
            $errors = array_merge($lineElement->getMessages());
            foreach ($errors as $error) {
                if (!empty($error)) { //add error text wrapper only if message is not empty
                    $result .= '<li><label for="' . $lineElement->getName() . '">' . htmlspecialchars($error) . '</label></li>';
                }
                $errorCount++;
            }
        }
        
        if ($errorCount == 0) {
            return $content;
        }
        
        $result = OX_UI_Form_Decorator_Utils::wrap($result, array (
                'tag' => 'ul', 
                'class' => 'error' . ($errorCount > 1 ? ' multiple' : '')));
        
        return $content . $result;
    }
}
