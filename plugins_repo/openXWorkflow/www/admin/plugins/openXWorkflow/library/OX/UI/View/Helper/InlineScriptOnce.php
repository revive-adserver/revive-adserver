<?php

/**
 * Inlines a script only once per request.
 */
class OX_UI_View_Helper_InlineScriptOnce extends Zend_View_Helper_InlineScript
{
    /**
     * Inlines the provided script only once per request.
     *
     * Returns InlineScript helper object; optionally, allows specifying a
     * script or script file to include.
     *
     * @param  string $mode Script or file
     * @param  string $spec Script/url
     * @param  string $placement Append, prepend, or set
     * @param  array $attrs Array of script attributes
     * @param  string $type Script type and/or array of script attributes
     * @return OX_UI_View_Helper_InlineScriptOnce
     */
    public function inlineScriptOnce($mode = Zend_View_Helper_HeadScript::FILE, $spec = null, $placement = 'APPEND',
            array $attrs = array(),
            $type = 'text/javascript')
    {
        if (! $spec) {
            return $this;
        }

        $registry = Zend_Registry::getInstance();
        $scriptKey = 'inline-script' . $spec;
        if (! $registry->isRegistered($scriptKey)) {
            $registry->set($scriptKey, true);
            return $this->inlineScript($mode, $spec, $placement, $attrs, $type);
        } else {
            return $this;
        }
    }
    
    /**
     * A convenience method for inserting inline scripts once per request.
     * Important: this method by default wraps the content in jQuery's:
     * $(document).ready(function() { <content> });
     * 
     * @param text of script to be inserted
     * @param onreadyWrapper enables jQuery onready wrapper on the provided script text
     * @return the helper that was used to inline the script
     */
    public static function inline($scriptText, $onreadyWrapper = true)
    {
        $helper = new OX_UI_View_Helper_InlineScriptOnce();
        $text = '';
        if ($onreadyWrapper) {
            $text .= '$(document).ready(function() {';
        }
        $text .= $scriptText;
        if ($onreadyWrapper) {
            $text .= '});';
        }
        $helper->inlineScriptOnce(Zend_View_Helper_HeadScript::SCRIPT, $text);
        return $helper;
    }
}
