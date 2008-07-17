<?php

interface OA_Admin_UI_Decorator
{
    //var APPEND = 'append';
    //var PREPEND = 'prepend';
    
    /**
     * Renders decorator content
     *
     * @param unknown_type $content
     */
    public function render($content);
    
    /**
     * Renders deorator prepend text.
     * 
     * @return text that should be prepended to element when rendered, empty string if none
     */
    public function prepend();
    
    /**
     * Renders deorator append text.
     * @return text that should be appended to element when rendered, empty string if none
     */
    public function append();
}

?>
