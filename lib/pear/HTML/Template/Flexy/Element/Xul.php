<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
// +----------------------------------------------------------------------+
// | PHP Version 4                                                        |
// +----------------------------------------------------------------------+
// | Copyright (c) 1997, 1998, 1999, 2000, 2001 The PHP Group             |
// +----------------------------------------------------------------------+
// | This source file is subject to version 2.0 of the PHP license,       |
// | that is bundled with this package in the file LICENSE, and is        |
// | available at through the world-wide-web at                           |
// | http://www.php.net/license/2_02.txt.                                 |
// | If you did not receive a copy of the PHP license and are unable to   |
// | obtain it through the world-wide-web, please send a note to          |
// | license@php.net so we can mail you a copy immediately.               |
// +----------------------------------------------------------------------+
// | Author: Alan Knowles <alan@akbkhome.com>                             |
// +----------------------------------------------------------------------+
//
// $Id: Xul.php,v 1.4 2004/08/17 03:50:27 alan_k Exp $

/**
 * Extension HTML Element builder and render to provide features for Xul
 *
 * All methods are static, and expect the first argument to be a HTML_Template_Flexy_Element
 *
 * @author      Alan Knowles <alan@akbkhome.com>
 */
class HTML_Template_Flexy_Element_Xul {

    
    /**
     * Utility function to set values for common tag types.
     * @param    HTML_Template_Flexy_Element   $element  override settings from another element.
     * @param    mixed   $value  value to use.
     * @access   public
     */
     
    function setValue(&$element,$value) {
        // store the value in all situations
        $element->value = $value;
        $tag = $element->tag;
        if (strpos($tag,':') !==  false) {
            $bits = explode(':',$tag);
            $tag = $bits[1];
        }
        switch ($tag) {
            case 'menulist':
                
                if (!is_array($value)) {
                    $value = array($value);
                }
                
                // is the first childa  menupopup
                if (!isset($element->children[0])) {
                    $element->children[0] = HTML_Template_Flexy_Element('menupopup');
                }
                if (!is_a($element->children[0],'HTML_Template_Flexy_Element')) {
                    // oh sh*t big problem!
                    return HTML_Template_Flexy::raiseError(
                        __CLASS__ . '::setValue expected a menupopup as the child of a menuitem?', 
                        HTML_TEMPLATE_FLEXY_ERROR_SYNTAX,
                        HTML_TEMPLATE_FLEXY_ERROR_DIE);
                }
                 
                
                // its setting the default value..
                // if the children havent been built we dont really care?
                // it will be done at the merge stage anyway..
                
                foreach(array_keys($element->children[0]->children) as $i) {
                    $child = &$element->children[0]->children[$i];
                    
                    if (is_string($child)) {
                        continue;
                    }
                     
                    
                    // standard option value...
                    //echo "testing {$child->attributes['value']} against ". print_r($value,true)."\n";
                    // does the value exist and match..
                    
                    if (isset($child->attributes['value']) 
                        && in_array((string) $child->attributes['value'], $value)) 
                    {
                       // echo "MATCH!\n";
                        $child->attributes['selected'] = 'true';
                        continue;
                    }
                    
                    // otherwise..
                    $child->attributes['selected'] = 'false';
                    
                }
                 
                return;
             
        }
            
        
    
    
    }
    /**
     * Utility function equivilant to HTML_Select - loadArray ** For xul:menulist.
     * but using 
     * key=>value maps 
     * <option value="key">Value</option>
     * Key=key (eg. both the same) maps to
     *  
     * 
     *
     * @param    HTML_Element   $from  override settings from another element.
     * @param    HTML_Element   $noValue  ignore the key part of the array
     * @access   public
     */
     
    function setOptions(&$element, $array,$noValue=false) {
        if (!is_array($array)) {
            $element->children = array();
            return;
        }
        
        
        $tag = '';
        $namespace = '';
        if (false !== strpos($element->tag, ':')) {
            
            $bits = explode(':',$element->tag);
            $namespace = $bits[0] . ':';
            $tag = strtolower($bits[1]);
            
        }
        if (!isset($element->children[0])) {
            $element->children[0] = new  HTML_Template_Flexy_Element('menupopup');
        }
        if (!is_a($element->children[0],'HTML_Template_Flexy_Element')) {
            // oh sh*t big problem!
            return HTML_Template_Flexy::raiseError(
                __CLASS__ . '::setValue expected a menupopup as the child of a menuitem?', 
                HTML_TEMPLATE_FLEXY_ERROR_SYNTAX,
                HTML_TEMPLATE_FLEXY_ERROR_DIE);
        }
        foreach($array as $k=>$v) {
            
            $atts=array();
            if (($k !== $v) && !$noValue) {
                $atts = array('value'=>$k);
            } else {
                $atts = array('value'=>$v);
            }
            $atts['label'] = htmlspecialchars($v);
            $atts['/'] = true;
            $add = new HTML_Template_Flexy_Element($namespace . 'menuitem',$atts);
            $element->children[0]->children[] = $add;
        }
       
    }
   
     
    
    
    
} // end class HTML_Template_Flexy_Element
