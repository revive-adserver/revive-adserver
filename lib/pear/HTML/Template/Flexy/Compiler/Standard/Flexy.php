<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
// +----------------------------------------------------------------------+
// | PHP Version 4                                                        |
// +----------------------------------------------------------------------+
// | Copyright (c) 1997-2003 The PHP Group                                |
// +----------------------------------------------------------------------+
// | This source file is subject to version 2.02 of the PHP license,      |
// | that is bundled with this package in the file LICENSE, and is        |
// | available at through the world-wide-web at                           |
// | http://www.php.net/license/2_02.txt.                                 |
// | If you did not receive a copy of the PHP license and are unable to   |
// | obtain it through the world-wide-web, please send a note to          |
// | license@php.net so we can mail you a copy immediately.               |
// +----------------------------------------------------------------------+
// | Authors:  Alan Knowles <alan@akkbhome.com>                           |
// +----------------------------------------------------------------------+
//
// $Id$
//
//  Handler code for the <flexy: namespace
//

/**
* the <flexy:XXXX namespace
* 
* 
* at present it handles
*       <flexy:toJavascript flexy:prefix="Javascript_prefix"  javscriptName="PHPvar" .....>
*       <flexy:include src="xxx.htm">
*
*
*
* @version    $Id$
*/

class HTML_Template_Flexy_Compiler_Standard_Flexy  {

        
    /**
    * Parent Compiler for 
    *
    * @var  object  HTML_Template_Flexy_Compiler  
    * 
    * @access public
    */
    var $compiler;

   
    /**
    * The current element to parse..
    *
    * @var object
    * @access public
    */    
    var $element;
    
    
    
    
    
    /**
    * toString - display tag, attributes, postfix and any code in attributes.
    * Relays into namspace::method to get results..
    *
    * 
    * @see parent::toString()
    */
    function toString($element) 
    {
        
        list($namespace,$method) = explode(':',$element->oTag);
        if (!strlen($method)) {
            return '';
        }
        // things we dont handle...
        if (!method_exists($this,$method.'ToString')) {
            return '';
        }
        return $this->{$method.'ToString'}($element);
        
    }
   /**
    * toJavascript handler
    * <flexy:toJavascript flexy:prefix="some_prefix_"  javascriptval="php.val" ....>
    * 
    * @see parent::toString()
    */
    
    function toJavascriptToString($element) 
    {
        $ret = $this->compiler->appendPhp( "require_once 'HTML/Javascript/Convert.php';");
        $ret .= $this->compiler->appendHTML("\n<script type='text/javascript'>\n");
        $prefix = ''. $element->getAttribute('FLEXY:PREFIX');
        
        
        foreach ($element->attributes as $k=>$v) {
            // skip directives..
            if (strpos($k,':')) {
                continue;
            }
            if ($k == '/') {
                continue;
            }
            $v = substr($v,1,-1);
            $ret .= $this->compiler->appendPhp(
                '$__tmp = HTML_Javascript_Convert::convertVar('.$element->toVar($v) .',\''.$prefix . $k.'\',true);'.
                'echo (is_a($__tmp,"PEAR_Error")) ? ("<pre>".print_r($__tmp,true)."</pre>") : $__tmp;');
            $ret .= $this->compiler->appendHTML("\n");
        }
        $ret .= $this->compiler->appendHTML("</script>");
        return $ret;
    }
    /**
    * include handler
    * <flexy:include src="test.html">
    * 
    * @see parent::toString()
    */
    function includeToString($element) 
    {
        // this is disabled by default...
        // we ignore modifier pre/suffix
    
    
    
       
        $arg = $element->getAttribute('SRC');
        if (!$arg) {
            return $this->compiler->appendHTML("<B>Flexy:Include without a src=filename</B>");
        }
        // ideally it would be nice to embed the results of one template into another.
        // however that would involve some complex test which would have to stat
        // the child templates anyway..
        // compile the child template....
        // output... include $this->options['compiled_templates'] . $arg . $this->options['locale'] . '.php'
        return $this->compiler->appendPHP( "\n".
                "\$x = new HTML_Template_Flexy(\$this->options);\n".
                "\$x->compile('{$arg}');\n".
                "\$x->outputObject(\$t);\n"
            );
    
    }
    
    /**
    * Convert flexy tokens to HTML_Template_Flexy_Elements.
    *
    * @param    object token to convert into a element.
    * @return   object HTML_Template_Flexy_Element
    * @access   public
    */
    function toElement($element) 
    {
       return '';
    }
        
    
    /**
    * Handler for User defined functions in templates..
    * <flexy:function name="xxxxx">.... </flexy:block>  // equivilant to function xxxxx() { 
    * <flexy:function call="{xxxxx}">.... </flexy:block>  // equivilant to function {$xxxxx}() { 
    * <flexy:function call="xxxxx">.... </flexy:block>  // equivilant to function {$xxxxx}() { 
    * 
    * This will not handle nested blocks initially!! (and may cause even more problems with 
    * if /foreach stuff..!!
    *
    * @param    object token to convert into a element.
    * @access   public
    */
  
    
    function functionToString($element) 
    {
        
        if ($arg = $element->getAttribute('NAME')) {
            // this is a really kludgy way of doing this!!!
            // hopefully the new Template Package will have a sweeter method..
            $GLOBALS['_HTML_TEMPLATE_FLEXY']['prefixOutput']  .= 
                $this->compiler->appendPHP( 
                    "\nfunction _html_template_flexy_compiler_standard_flexy_{$arg}(\$t,\$this) {\n").
                $element->compileChildren($this->compiler) .
                $this->compiler->appendPHP( "\n}\n");
                
                return '';
        }
        if (!isset($element->ucAttributes['CALL'])) {
            
            return HTML_Template_Flexy::raiseError(
                ' tag flexy:function needs an argument call or name'.
                " Error on Line {$element->line} &lt;{$element->tag}&gt;",
                         null,   HTML_TEMPLATE_FLEXY_ERROR_DIE);
        }
        // call is a  stirng : nice and simple..
        if (is_string($element->ucAttributes['CALL'])) {
            $arg = $element->getAttribute('CALL');
            return $this->compiler->appendPHP( 
                    "if (function_exists('_html_template_flexy_compiler_standard_flexy_'.{$arg})) " .
                    " _html_template_flexy_compiler_standard_flexy_{$arg}(\$t,\$this);");
        }
        
        // we make a big assumption here.. - it should really be error checked..
        // that the {xxx} element is item 1 in the list... 
        $e=$element->ucAttributes['CALL'][1];
        $add = $e->toVar($e->value);
        if (is_a($add,'PEAR_Error')) {
            return $add;
        } 
        return $this->compiler->appendPHP(
            "if (function_exists('_html_template_flexy_compiler_standard_flexy_'.{$add})) ".
            "call_user_func_array('_html_template_flexy_compiler_standard_flexy_'.{$add},array(\$t,\$this));");
        
        
        
    }

}

 