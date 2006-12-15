<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
// +----------------------------------------------------------------------+
// | PHP Version 4                                                        |
// +----------------------------------------------------------------------+
// | Copyright (c) 1997-2002 The PHP Group                                |
// +----------------------------------------------------------------------+
// | This source file is subject to version 2.02 of the PHP license,      |
// | that is bundled with this package in the file LICENSE, and is        |
// | available at through the world-wide-web at                           |
// | http://www.php.net/license/2_02.txt.                                 |
// | If you did not receive a copy of the PHP license and are unable to   |
// | obtain it through the world-wide-web, please send a note to          |
// | license@php.net so we can mail you a copy immediately.               |
// +----------------------------------------------------------------------+
// | Authors: Alan Knowles <alan@akbkhome.com>                            |
// +----------------------------------------------------------------------+
//
// $Id$
//
//  Base Compiler Class
//  Standard 'Original Flavour' Flexy compiler

/*------------------------------------------------------------------------------------------
                                        NOTICE: 
                             THIS COMPILER IS DEPRECIATED 
                                USE THE FLEXY COMPILER 
     
                      The Flexy Compiler should be Compatible

------------------------------------------------------------------------------------------*/

require_once 'HTML/Template/Flexy/Tokenizer.php';
require_once 'HTML/Template/Flexy/Token.php';

// cache for po files..
$GLOBALS['_html_template_flexy_compiler_standard']['PO'] = array();


class HTML_Template_Flexy_Compiler_Standard extends HTML_Template_Flexy_Compiler 
{
    
    
    
    /**
    * The compile method.
    * 
    * @params   object HTML_Template_Flexy
    * @params   string|false string to compile of false to use a file.
    * @return   string   filename of template
    * @access   public
    */
    function compile(&$flexy,$string=false) 
    {
        // read the entire file into one variable
        
        // note this should be moved to new HTML_Template_Flexy_Token
        // and that can then manage all the tokens in one place..
        global $_HTML_TEMPLATE_FLEXY_COMPILER;
        
        $gettextStrings = &$_HTML_TEMPLATE_FLEXY_COMPILER['gettextStrings'];
        $gettextStrings = array(); // reset it.
        
        if (@$this->options['debug']) {
            echo "compiling template $flexy->currentTemplate<BR>";
            
        }
         
        // reset the elements.
        $flexy->_elements = array();
        
        // replace this with a singleton??
        
        $GLOBALS['_HTML_TEMPLATE_FLEXY']['currentOptions'] = $this->options;
        $GLOBALS['_HTML_TEMPLATE_FLEXY']['elements'] = array();
        $GLOBALS['_HTML_TEMPLATE_FLEXY']['filename'] = $flexy->currentTemplate;
        $GLOBALS['_HTML_TEMPLATE_FLEXY']['prefixOutput']  = '';
        $GLOBALS['_HTML_TEMPLATE_FLEXY']['compiledTemplate']  = $flexy->compiledTemplate;
        
        if (is_array($this->options['Translation2'])) {
            require_once 'Translation2.php';
            $this->options['Translation2'] = new Translation2(
                $this->options['Translation2']['driver'],
                @$this->options['Translation2']['options']
            );
        }
        
        
        if (is_a($this->options['Translation2'],'Translation2')) {
            $this->options['Translation2']->setLang($this->options['locale']);
            // fixme - needs to be more specific to which template to use..
            foreach ($this->options['templateDir'] as $tt) {
                $n = basename($flexy->currentTemplate);
                if (substr($flexy->currentTemplate,0,strlen($tt)) == $tt) {
                    $n = substr($flexy->currentTemplate,strlen($tt)+1);
                }
                //echo $n;
            }
            $this->options['Translation2']->setPageID($n);
        } else {
            setlocale(LC_ALL, $this->options['locale']);
        }
        
        
        
        
        
        
        
        $data = $string;
        $res = false;
        if ($string === false) {
            $data = file_get_contents($flexy->currentTemplate);
        }
         
            // PRE PROCESS {_(.....)} translation markers.
        $got_gettext_markup = false;
        
        
        
        if (strpos($data,'{_(') !== false) {
            $matches = array();
            $lmatches = explode ('{_(', $data);
            array_shift($lmatches);
            // shift the first..
            foreach ($lmatches as $k) {
                if (false === strpos($k,')_}')) {
                    continue;
                }
                $x = explode(')_}',$k);
                $matches[] = $x[0];
            }
        
        
           //echo '<PRE>';print_r($matches);
            // we may need to do some house cleaning here...
            $gettextStrings = $matches;
            $got_gettext_markup = true;
            
            
            // replace them now..  
            // ** leaving in the tag (which should be ignored by the parser..
            // we then get rid of the tags during the toString method in this class.
            foreach($matches as $v) {
                $data = str_replace('{_('.$v.')_}', '{_('.$this->translateString($v).')_}',$data);
            }
            
        }
            
        if (isset($_HTML_TEMPLATE_FLEXY_COMPILER['cache'][md5($data)])) {
            $res = $_HTML_TEMPLATE_FLEXY_COMPILER['cache'][md5($data)];
        } else {
        
             
            $tokenizer = new HTML_Template_Flexy_Tokenizer($data);
            $tokenizer->fileName = $flexy->currentTemplate;
            
            
            //$tokenizer->debug=1;
            $tokenizer->options['ignore_html'] = $this->options['nonHTML'];
            $tokenizer->options['ignore_php']  = !$this->options['allowPHP'];
            
            $res = HTML_Template_Flexy_Token::buildTokens($tokenizer);
         
            $_HTML_TEMPLATE_FLEXY_COMPILER['cache'][md5($data)] = $res;
            
        }
        
        if (is_a($res,'PEAR_Error')) {
            return $res;
        }   
        // turn tokens into Template..
        
        $data = $res->compile($this);
        
        if (is_a($data,'PEAR_Error')) {
            return $data;
        }
        
        $data = $GLOBALS['_HTML_TEMPLATE_FLEXY']['prefixOutput'] . $data;
        
        if (   @$this->options['debug']) {
            echo "<B>Result: </B><PRE>".htmlspecialchars($data)."</PRE><BR>";
            
        }

        if ($this->options['nonHTML']) {
           $data =  str_replace("?>\n","?>\n\n",$data);
        }
        
         
        
        
        // at this point we are into writing stuff...
        if ($this->options['compileToString']) {
            $flexy->elements =  $GLOBALS['_HTML_TEMPLATE_FLEXY']['elements'];
            return $data;
        }
        
        
        
        
        // error checking?
        $file  = $flexy->compiledTemplate;
        if (isset($flexy->options['output.block'])) {
            list($file,$part) = explode('#',$file  );
        }
        
        if( ($cfp = fopen( $file , 'w' )) ) {
            if (@$this->options['debug']) {
                echo "<B>Writing: </B>".htmlspecialchars($data)."<BR>";
                
            }
            fwrite($cfp,$data);
            fclose($cfp);
            
            chmod($file,0775);
            // make the timestamp of the two items match.
            clearstatcache();
            touch($file, filemtime($flexy->currentTemplate));
            if ($file != $flexy->compiledTemplate) {
                chmod($flexy->compiledTemplate,0775);
                // make the timestamp of the two items match.
                clearstatcache();
                touch($flexy->compiledTemplate, filemtime($flexy->currentTemplate));
            }
             
            
        } else {
            return HTML_Template_Flexy::raiseError('HTML_Template_Flexy::failed to write to '.$flexy->compiledTemplate,
                HTML_TEMPLATE_FLEXY_ERROR_FILE ,HTML_TEMPLATE_FLEXY_ERROR_RETURN);
        }
        // gettext strings
        if (file_exists($flexy->getTextStringsFile)) {
            unlink($flexy->getTextStringsFile);
        }
        
        if($gettextStrings && ($cfp = fopen( $flexy->getTextStringsFile, 'w') ) ) {
            
            fwrite($cfp,serialize(array_unique($gettextStrings)));
            fclose($cfp);
        }
        
        // elements
        if (file_exists($flexy->elementsFile)) {
            unlink($flexy->elementsFile);
        }
        
        if( $GLOBALS['_HTML_TEMPLATE_FLEXY']['elements'] &&
            ($cfp = fopen( $flexy->elementsFile, 'w') ) ) {
            fwrite($cfp,serialize( $GLOBALS['_HTML_TEMPLATE_FLEXY']['elements']));
            fclose($cfp);
            // now clear it.
        
        }
        
        return true;
    }
    
    /**
    * Flag indicating compiler is inside {_( .... )_} block, and should not
    * add to the gettextstrings array.
    *
    * @var boolean 
    * @access public
    */
    var $inGetTextBlock = false;
    
    /**
    * This is the base toString Method, it relays into toString{TokenName}
    *
    * @param    object    HTML_Template_Flexy_Token_*
    * 
    * @return   string     string to build a template
    * @access   public 
    * @see      toString*
    */
  

    function toString($element) 
    {
        static $len = 26; // strlen('HTML_Template_Flexy_Token_');
        if ($this->options['debug']) {
            $x = $element;
            unset($x->children);
            echo htmlspecialchars(print_r($x,true))."<BR>\n";
        }
        if ($element->token == 'GetTextStart') {
            $this->inGetTextBlock = true;
            return '';
        }
        if ($element->token == 'GetTextEnd') {
            $this->inGetTextBlock = false;
            return '';
        }
        
            
        $class = get_class($element);
        if (strlen($class) >= $len) {
            $type = substr($class,$len);
            return $this->{'toString'.$type}($element);
        }
        
        $ret = $element->value;
        $add = $element->compileChildren($this);
        if (is_a($add,'PEAR_Error')) {
            return $add;
        }
        $ret .= $add;
        
        if ($element->close) {
            $add = $element->close->compile($this);
            if (is_a($add,'PEAR_Error')) {
                return $add;
            }
            $ret .= $add;
        }
        
        return $ret;
    }


    /**
    *   HTML_Template_Flexy_Token_Else toString 
    *
    * @param    object    HTML_Template_Flexy_Token_Else
    * 
    * @return   string     string to build a template
    * @access   public 
    * @see      toString*
    */
  

    function toStringElse($element) 
     {
        // pushpull states to make sure we are in an area.. - should really check to see 
        // if the state it is pulling is a if...
        if ($element->pullState() === false) {
            return $this->appendHTML(
                "<font color=\"red\">Unmatched {else:} on line: {$element->line}</font>"
                );
        }
        $element->pushState();
        return $this->appendPhp("} else {");
    }
    
    /**
    *   HTML_Template_Flexy_Token_End toString 
    *
    * @param    object    HTML_Template_Flexy_Token_Else
    * 
    * @return   string     string to build a template
    * @access   public 
    * @see      toString*
    */
  
    function toStringEnd($element) 
    {
        // pushpull states to make sure we are in an area.. - should really check to see 
        // if the state it is pulling is a if...
        if ($element->pullState() === false) {
            return $this->appendHTML(
                "<font color=\"red\">Unmatched {end:} on line: {$element->line}</font>"
                );
        }
         
        return $this->appendPhp("}");
    }

    /**
    *   HTML_Template_Flexy_Token_EndTag toString 
    *
    * @param    object    HTML_Template_Flexy_Token_EndTag
    * 
    * @return   string     string to build a template
    * @access   public 
    * @see      toString*
    */
  


    function toStringEndTag($element) 
    {
        return $this->toStringTag($element);
    }
        
    
    
    /**
    *   HTML_Template_Flexy_Token_Foreach toString 
    *
    * @param    object    HTML_Template_Flexy_Token_Foreach 
    * 
    * @return   string     string to build a template
    * @access   public 
    * @see      toString*
    */
  
    
    function toStringForeach($element) 
    {
    
        $loopon = $element->toVar($element->loopOn);
        if (is_a($loopon,'PEAR_Error')) {
            return $loopon;
        }
        
        $ret = 'if ($this->options[\'strict\'] || ('.
            'is_array('. $loopon. ')  || ' .
            'is_object(' . $loopon  . '))) ' .
            'foreach(' . $loopon  . " ";
            
        $ret .= "as \${$element->key}";
        
        if ($element->value) {
            $ret .=  " => \${$element->value}";
        }
        $ret .= ") {";
        
        $element->pushState();
        $element->pushVar($element->key);
        $element->pushVar($element->value);
        return $this->appendPhp($ret);
    }
    /**
    *   HTML_Template_Flexy_Token_If toString 
    *
    * @param    object    HTML_Template_Flexy_Token_If
    * 
    * @return   string     string to build a template
    * @access   public 
    * @see      toString*
    */
  
    function toStringIf($element) 
    {
        
        $var = $element->toVar($element->condition);
        if (is_a($var,'PEAR_Error')) {
            return $var;
        }
        
        $ret = "if (".$element->isNegative . $var .")  {";
        $element->pushState();
        return $this->appendPhp($ret);
    }

   /**
    *  get Modifier Wrapper 
    *
    * converts :h, :u, :r , .....
    * @param    object    HTML_Template_Flexy_Token_Method|Var
    * 
    * @return   array prefix,suffix
    * @access   public 
    * @see      toString*
    */

    function getModifierWrapper($element) 
    {
        $prefix = 'echo ';
        
        $suffix = '';
        $modifier = strlen(trim($element->modifier)) ? $element->modifier : ' ';
        
        switch ($modifier{0}) {
            case 'h':
                break;
            case 'u':
                $prefix = 'echo urlencode(';
                $suffix = ')';
                break;
            case 'r':
                $prefix = 'echo \'<pre>\'; echo htmlspecialchars(print_r(';
                $suffix = ',true)); echo \'</pre>\';';
                break;                
            case 'n': 
                // blank or value..
                $numberformat = @$GLOBALS['_HTML_TEMPLATE_FLEXY']['currentOptions']['numberFormat'];
                $prefix = 'echo number_format(';
                $suffix = $GLOBALS['_HTML_TEMPLATE_FLEXY']['currentOptions']['numberFormat'] . ')';
                break;
            case 'b': // nl2br + htmlspecialchars
                $prefix = 'echo nl2br(htmlspecialchars(';
                
                // add language ?
                $suffix = '))';
                break;
            case ' ':
                $prefix = 'echo htmlspecialchars(';
                // add language ?
                $suffix = ')';
                break;
            default:
               $prefix = 'echo $this->plugin("'.trim($element->modifier) .'",';
               $suffix = ')'; 
            
            
        }
        
        return array($prefix,$suffix);
    }



  /**
    *   HTML_Template_Flexy_Token_Var toString 
    *
    * @param    object    HTML_Template_Flexy_Token_Method
    * 
    * @return   string     string to build a template
    * @access   public 
    * @see      toString*
    */
  
    function toStringVar($element) 
    {
        // ignore modifier at present!!
        
        $var = $element->toVar($element->value);
        if (is_a($var,'PEAR_Error')) {
            return $var;
        }
        list($prefix,$suffix) = $this->getModifierWrapper($element);
        return $this->appendPhp( $prefix . $var . $suffix .';');
    }
   /**
    *   HTML_Template_Flexy_Token_Method toString 
    *
    * @param    object    HTML_Template_Flexy_Token_Method
    * 
    * @return   string     string to build a template
    * @access   public 
    * @see      toString*
    */
  
    function toStringMethod($element) 
    {

              
        // set up the modifier at present!!
        list($prefix,$suffix) = $this->getModifierWrapper($element);
        
        // add the '!' to if
        
        if ($element->isConditional) {
            $prefix = 'if ('.$element->isNegative;
            $element->pushState();
            $suffix = ')';
        }  
        
        
        // check that method exists..
        // if (method_exists($object,'method');
        $bits = explode('.',$element->method);
        $method = array_pop($bits);
        
        $object = implode('.',$bits);
        
        $var = $element->toVar($object);
        if (is_a($var,'PEAR_Error')) {
            return $var;
        }
        
        if (($object == 'GLOBALS') && 
            $GLOBALS['_HTML_TEMPLATE_FLEXY']['currentOptions']['globalfunctions']) {
            // we should check if they something weird like: GLOBALS.xxxx[sdf](....)
            $var = $method;
        } else {
            $prefix = 'if ($this->options[\'strict\'] || (isset('.$var.
                ') && method_exists('.$var .",'{$method}'))) " . $prefix;
            $var = $element->toVar($element->method);
        }
        

        if (is_a($var,'PEAR_Error')) {
            return $var;
        }
        
        $ret  =  $prefix;
        $ret .=  $var . "(";
        $s =0;
         
       
         
        foreach($element->args as $a) {
             
            if ($s) {
                $ret .= ",";
            }
            $s =1;
            if ($a{0} == '#') {
                $ret .= '"'. addslashes(substr($a,1,-1)) . '"';
                continue;
            }
            
            $var = $element->toVar($a);
            if (is_a($var,'PEAR_Error')) {
                return $var;
            }
            $ret .= $var;
            
        }
        $ret .= ")" . $suffix;
        
        if ($element->isConditional) {
            $ret .= ' { ';
        } else {
            $ret .= ";";
        }
        
        
        
        return $this->appendPhp($ret); 
        
         

   }
   /**
    *   HTML_Template_Flexy_Token_Processing toString 
    *
    * @param    object    HTML_Template_Flexy_Token_Processing 
    * 
    * @return   string     string to build a template
    * @access   public 
    * @see      toString*
    */


    function toStringProcessing($element) 
    {
        // if it's XML then quote it..
        if (strtoupper(substr($element->value,2,3)) == 'XML') { 
            return $this->appendPhp("echo '" . str_replace("'","\\"."'", $element->value) . "';");
        }
        // otherwise it's PHP code - so echo it..
        return $element->value;
    }
    
    /**
    *   HTML_Template_Flexy_Token_Text toString 
    *
    * @param    object    HTML_Template_Flexy_Token_Text
    * 
    * @return   string     string to build a template
    * @access   public 
    * @see      toString*
    */



    function toStringText($element) 
    {
        
        // first get rid of stuff thats not translated etc.
        // empty strings => output.
        // comments -> just output
        // our special tags -> output..
        
        if (!strlen(trim($element->value) )) {
            return $this->appendHtml($element->value);
        }
        // dont add comments to translation lists.
         
        if (substr($element->value,0,4) == '<!--') {
            return $this->appendHtml($element->value);
        }
        // ignore anything wrapped with {_( .... )_}
        if ($this->inGetTextBlock) {
            return $this->appendHtml($element->value);
        }
        
        // argTokens is built before the tag matching (it combined
        // flexy tags into %s, into the string,
        // and made a list of tokens in argTokens.
        
        if (!count($element->argTokens) && !$element->isWord()) {
            return $this->appendHtml($element->value);
        }
        
        // grab the white space at start and end (and keep it!
        
        $value = ltrim($element->value);
        $front = substr($element->value,0,-strlen($value));
        $value = rtrim($element->value);
        $rear  = substr($element->value,strlen($value));
        $value = trim($element->value);
        
        
        // convert to escaped chars.. (limited..)
        //$value = strtr($value,$cleanArray);
        
        $this->addStringToGettext($value);
        $value = $this->translateString($value);
        // its a simple word!
        if (!count($element->argTokens)) {
            return $this->appendHtml($front . $value . $rear);
        }
        
        
        // there are subtokens..
        // print_r($element->argTokens );
        $args = array();
        // these should only be text or vars..
        
        foreach($element->argTokens as $i=>$token) {
            $args[] = $token->compile($this);
        }
        
        // we break up the translated string, and put the compiled tags 
        // in between the values here.
        
        $bits = explode('%s',$value);
        $ret  = $front;
        
        foreach($bits as $i=>$v) {
            $ret .= $v . @$args[$i];
        }
        
        return  $ret . $rear;
        
    }
    /**
    * addStringToGettext 
    *
    * Adds a string to the gettext array. 
    * 
    * @param   mixed        preferably.. string to store
    *
    * @return   none
    * @access   public
    */
    
    function addStringToGettext($string) 
    {
    
        
        
        
        if (!is_string($string)) {
            return;
        }
        
        if (!preg_match('/[a-z]+/i', $string)) {
            return;
        }
        $string = trim($string);
        
        if (substr($string,0,4) == '<!--') {
            return;
        }
        
        $GLOBALS['_HTML_TEMPLATE_FLEXY_COMPILER']['gettextStrings'][] = $string;
    }
    
    
    /**
    * translateString - a gettextWrapper
    *
    * tries to do gettext or falls back on File_Gettext
    * This has !!!NO!!! error handling - if it fails you just get english.. 
    * no questions asked!!!
    * 
    * @param   string       string to translate
    *
    * @return   string      translated string..
    * @access   public
    */
  
    function translateString($string)
    {
         
        
        
        if (is_a($this->options['Translation2'],'Translation2')) {
            $result = $this->options['Translation2']->get($string);
            if (!empty($result)) {
                return $result;
            }
            return $string;
        }
        
        // note this stuff may have been broken by removing the \n replacement code 
        // since i dont have a test for it... it may remain broken..
        // use Translation2 - it has gettext backend support
        // and should sort out the mess that \n etc. entail.
        
        
        $prefix = basename($GLOBALS['_HTML_TEMPLATE_FLEXY']['filename']).':';
        if (@$this->options['debug']) {
            echo __CLASS__.":TRANSLATING $string<BR>";
        }
        if (function_exists('gettext') && !$this->options['textdomain']) {
            if (@$this->options['debug']) {
                echo __CLASS__.":USING GETTEXT?<BR>";
            }
            $t = gettext($string);
            if ($t != $string) {
                return $t;
            }
            $tt = gettext($prefix.$string);
            if ($tt != $prefix.$string) {
                return $tt;
            }
            // give up it's not translated anywhere...
            return $t;
             
        }
        if (!$this->options['textdomain'] || !$this->options['textdomainDir']) {
            // text domain is not set..
            if (@$this->options['debug']) {
                echo __CLASS__.":MISSING textdomain settings<BR>";
            }
            return $string;
        }
        $pofile = $this->options['textdomainDir'] . 
                '/' . $this->options['locale'] . 
                '/LC_MESSAGES/' . $this->options['textdomain'] . '.po';
        
        
        // did we try to load it already..
        if (@$GLOBALS['_'.__CLASS__]['PO'][$pofile] === false) {
            if (@$this->options['debug']) {
                echo __CLASS__.":LOAD failed (Cached):<BR>";
            }
            return $string;
        }
        if (!@$GLOBALS['_'.__CLASS__]['PO'][$pofile]) {
            // default - cant load it..
            $GLOBALS['_'.__CLASS__]['PO'][$pofile] = false;
            if (!file_exists($pofile)) {
                 if (@$this->options['debug']) {
                echo __CLASS__.":LOAD failed: {$pofile}<BR>";
            }
                return $string;
            }
            
            if (!@include_once 'File/Gettext.php') {
                if (@$this->options['debug']) {
                    echo __CLASS__.":LOAD no File_gettext:<BR>";
                }
                return $string;
            }
            
            $GLOBALS['_'.__CLASS__]['PO'][$pofile] = File_Gettext::factory('PO',$pofile);
            $GLOBALS['_'.__CLASS__]['PO'][$pofile]->load();
            //echo '<PRE>'.htmlspecialchars(print_r($GLOBALS['_'.__CLASS__]['PO'][$pofile]->strings,true));
            
        }
        $po = &$GLOBALS['_'.__CLASS__]['PO'][$pofile];
        // we should have it loaded now...
        // this is odd - data is a bit messed up with CR's
        $string = str_replace('\n',"\n",$string);
        
        if (isset($po->strings[$prefix.$string])) {
            return $po->strings[$prefix.$string];
        }
        
        if (!isset($po->strings[$string])) {
            if (@$this->options['debug']) {
                    echo __CLASS__.":no match:<BR>";
            }
            return $string;
        }
        if (@$this->options['debug']) {
            echo __CLASS__.":MATCHED: {$po->strings[$string]}<BR>";
        }
        
        // finally we have a match!!!
        return $po->strings[$string];
        
    } 
     /**
    *   HTML_Template_Flexy_Token_Tag toString 
    *
    * @param    object    HTML_Template_Flexy_Token_Tag
    * 
    * @return   string     string to build a template
    * @access   public 
    * @see      toString*
    */
  
    function toStringTag($element) {
        if (strpos($element->tag,':') === false) {
            $namespace = 'Tag';
        } else {
            $bits =  explode(':',$element->tag);
            $namespace = $bits[0];
        }
        if ($namespace{0} == '/') {
            $namespace = substr($namespace,1);
        }
        if (empty($this->tagHandlers[$namespace])) {
            
            require_once 'HTML/Template/Flexy/Compiler/Standard/Tag.php';
            $this->tagHandlers[$namespace] = &HTML_Template_Flexy_Compiler_Standard_Tag::factory($namespace,$this);
            if (!$this->tagHandlers[$namespace] ) {
                return HTML_Template_Flexy::raiseError('HTML_Template_Flexy::failed to create Namespace Handler '.$namespace . 
                    ' in file ' . $GLOBALS['_HTML_TEMPLATE_FLEXY']['filename'],
                    HTML_TEMPLATE_FLEXY_ERROR_SYNTAX ,HTML_TEMPLATE_FLEXY_ERROR_RETURN);
            }
                
        }
        return $this->tagHandlers[$namespace]->toString($element);
        
        
    }
    

}
