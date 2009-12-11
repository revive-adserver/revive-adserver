<?php

/**
 * A decorator that renders action urls for forms.
 */
class OX_UI_Form_Decorator_ActionUrl extends Zend_Form_Decorator_Abstract
{

    public function render($content)
    {
        $element = $this->getElement();
        $view = $element->getView();
        if (null === $view) {
            return $content;
        }

        $id = $element->getAttrib('id');
        $idMarkup = '';
        if ($id) {
            $idMarkup = ' id="' . htmlspecialchars($id) . '"'; 
        }
        
        $class = $element->getAttrib('class');
        $classMarkup = '';
        if ($class) {
            $classMarkup = ' class="' . htmlspecialchars($class) . '"'; 
        }
        
        $link = '<a href="' . OX_UI_View_Helper_ActionUrl::actionUrl(
            $element->action, $element->controller, 
            $element->module, $element->params) . '"' . $idMarkup . $classMarkup . '>' . 
                $content . '</a>';

        $width = null;
        if (method_exists($element, 'getWidth')) {
            $width = $element->getWidth();
        }
        return $width ? OX_UI_Form_Decorator_Utils::wrap($link, 
            array('tag' => 'div', 'class' => OX_UI_Form_Element_Widths::getWidthClass($element))) : $link;
    }
}