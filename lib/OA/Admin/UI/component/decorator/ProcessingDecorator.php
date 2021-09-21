<?php

/*
+---------------------------------------------------------------------------+
| Revive Adserver                                                           |
| http://www.revive-adserver.com                                            |
|                                                                           |
| Copyright: See the COPYRIGHT.txt file.                                    |
| License: GPLv2 or later, see the LICENSE.txt file.                        |
+---------------------------------------------------------------------------+
*/

require_once MAX_PATH . '/lib/OA/Admin/UI/component/decorator/AbstractDecorator.php';


class OA_Admin_UI_ProcessingDecorator extends OA_Admin_UI_AbstractDecorator
{
    /**
     * Callback to invoke
     * @var callback
     */
    private $_callback;

    /**
     * Callback to invoke
     * @var callback
     */
    private $_regexp;

    
    /**
     * HTML tag name to process
     * @var string
     */
    private $_tagName;
    
    
    /**
     * An array of attributes to add on the processed content
     *
     * @var an array of key=>value pairs
     */
    private $_aAddAttributes;
    

    /**
     * Callback invocation counter. Reset before render starts.
     *
     * @var int
     */
    private $_numCall = 0;

    /**
     * Create a processing decorator.
     * Recognizes the following parameters in $aParameters array:
     * - tag (string) - a tag name to look for in the content
     * - callback (callback) - a callback to invoke when matching tag found in the content
     * - addAttributes (array) - an array of key => value attributes to add to matching tag
     *
     * Please note that if callback is specified, addAttributes is ignored as given
     * callback takes precedence over a built in one.
     *
     * @param array $aParameters
     */
    public function __construct($aParameters)
    {
        $this->_tagName = $aParameters['tag'];
        $this->_aAddAttributes = $aParameters['addAttributes']
            ? $aParameters['addAttributes'] : [];
            
        $this->_regexp = $aParameters['regexp'];
        $this->_callback = $aParameters['callback'];
        
        if (empty($this->_tagName) && empty($this->_regexp)) {
            return PEAR::raiseError('Either tag to process or regexp to match 
                must be given for OA_Admin_UI_ProcessingDecorator');
        }
    }
    
    
    /**
     * Processes content with a given function callback or creates its own callback
     * using parameters given at decorator's creation (tag, addAttributes)
     *
     * @param unknown_type $content
     * @return unknown
     */
    public function render($content)
    {
        $this->_numCall = 0; //reset callback counter
        return preg_replace_callback(
            $this->getPattern(),
            $this->getCallback(),
            $content
        );
    }


    /**
     * Get regular expresion pattern associated with this decorator. If none was
     * given creates a default using tagName
     *
     * @return string regexp to match against content
     */
    private function getPattern()
    {
        //use given regexp, if none create a default one
        if (empty($this->_regexp)) {
            $this->_regexp = "/(\<" . $this->_tagName . ")/";
        }
        
        return $this->_regexp;
    }
    
    
    /**
     * Get callback associated with this decorator. If none given register default one
     * and return.
     *
     * @return unknown
     */
    private function getCallback()
    {
        //use given callback, if none use default one
        if (empty($this->_callback)) {
            $this->_callback = function ($aMatches) {
                return $this->defaultCallback($aMatches);
            };
        }
        
        return $this->_callback;
    }
    
    
    /**
     * A default callback method that will be called when no callback was specified.
     * It takes a given matched element and adds given attributes.
     */
    public function defaultCallback($aMatches)
    {
        $this->_numCall++;
        $attributes = $this->getAttributesString($this->_numCall);
        
        return $aMatches[0] . " " . $attributes;
    }
    
    
    private function getAttributesString($numCall)
    {
        foreach ($this->_aAddAttributes as $name => $value) {
            $value = preg_replace("/\{numCall\}/", $numCall, $value);
            $value = addslashes($value);
            $attributes .= ' ' . $name . '="' . $value . '"';
        }
        
        return $attributes;
    }
}
