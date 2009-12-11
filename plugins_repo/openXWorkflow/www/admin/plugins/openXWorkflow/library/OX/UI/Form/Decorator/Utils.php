<?php

/**
 * A number of common utility methods used in OX decorators.
 */
class OX_UI_Form_Decorator_Utils
{

    /**
     * Wraps content with the provided decorator.
     */
    public static function wrap($content, array $options)
    {
        $decorator = new Zend_Form_Decorator_HtmlTag();
        $decorator->setOptions($options);
        return $decorator->render($content);
    }
}
