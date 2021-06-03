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
// | Authors:  Alan Knowles <alan@akbkhome>                               |
// +----------------------------------------------------------------------+
//
//  This is the master Token file for The New Token driver Engine.
//  All the Token output, and building routines are in here.
//
//  Note overriden methods are not documented unless they differ majorly from
//  The parent.
//
$GLOBALS['_HTML_TEMPLATE_FLEXY_TOKEN']['base'] = 0;
$GLOBALS['_HTML_TEMPLATE_FLEXY_TOKEN']['state'] = 0;
$GLOBALS['_HTML_TEMPLATE_FLEXY_TOKEN']['statevars'] = array();
$GLOBALS['_HTML_TEMPLATE_FLEXY_TOKEN']['activeForm'] = '';
$GLOBALS['_HTML_TEMPLATE_FLEXY_TOKEN']['tokens'] = array();
$GLOBALS['_HTML_TEMPLATE_FLEXY_TOKEN']['gettextStrings'] = array();
$GLOBALS['_HTML_TEMPLATE_FLEXY_TOKEN']['activeFormId'] = 0;
$GLOBALS['_HTML_TEMPLATE_FLEXY_TOKEN']['flexyIgnore'] = false;
/**
* Base Class for all Tokens.
*
* @abstract Provides the static Create Method, and default toString() methods
*
*/

class HTML_Template_Flexy_Token {

    /**
    * the token type (Depreciated when we have classes for all tokens
    *
    * @var string
    * @access public
    */
    var $token;
    /**
    * the default value (normally a string)
    *
    * @var string
    * @access public
    */
    var $value;
    /**
    * the line the token is from
    *
    * @var int
    * @access public
    */
    var $line;
    /**
    * the character Position
    *
    * @var int
    * @access public
    */
    var $charPos;


    /**
    * factory a Token
    *
    * Standard factory method.. - with object vars.
    * ?? rename me to factory?
    * @param   string      Token type
    * @param   mixed       Initialization settings for token
    * @param   int   line that the token is defined.
    *
    *
    * @return   object    Created Object
    * @access   public
    */

    public static function factory($token,$value,$line,$charPos=0) {
        // try not to reload the same class to often
        static $loaded = array();


        $c = 'HTML_Template_Flexy_Token_'.$token;

        if (!class_exists($c) && !isset($loaded[$token])) {
            // make sure parse errors are picked up - no  @ here..
            if (file_exists(dirname(__FILE__)."/Token/{$token}.php")) {
                require_once 'HTML/Template/Flexy/Token/'.$token.'.php';
            }
            $loaded[$token] = true;
        }

        $t = new HTML_Template_Flexy_Token;

        if (class_exists($c)) {
            $t = new $c;
        }
        $t->token = $token;
        $t->charPos = $charPos;

        if ($t->setValue($value) === false) {
            // kick back error conditions..
            return false;
        }
        $t->line = $line;

        return $t;
    }

    /**
    * Standard Value iterpretor
    *
    * @param   mixed    value recieved from factory method

    * @return   none
    * @access   public
    */

    function setValue($value) {
        $this->value = $value;
    }


    /**
    * compile to String (vistor method) replaces toString
    *
    * @return   string   HTML
    * @access   public
    */

    function compile(&$compiler) {
        return $compiler->toString($this);
    }


    /**
    * compile children (visitor approach).
    *
    * @return   string   HTML
    * @access   public
    */
    function compileChildren( &$compiler) {

        if (!$this->children) {
            return '';
        }
        if ($this->ignoreChildren) {
            return;
        }
        $ret = '';
        //echo "output $this->id";
        //new Gtk_VarDump($this);
        foreach ($this->children as $child) {
            if (!$child) {
                continue;
            }
            $add = $child->compile($compiler);
            if (is_a($add,'PEAR_Error')) {
                return $add;
            }
            $ret .= $add;
        }
        return $ret;
    }




    /* ======================================================= */
    /* Token Managmenet = parse and store all the tokens in
     * an associative array and tree.
     */

    /**
    * Run a Tokenizer and Store its results
    * It should build a DOM Tree of the HTML
    *
    * @param   object    Tokenizer to run.. - Theoretically other Tokenizers could be done for email,rtf etc.
    *
    * @access   public
    * @return   base token (really a dummy token, which contains the tree)
    * @static
    */

    public static function buildTokens($tokenizer)
    {

        global $_HTML_TEMPLATE_FLEXY_TOKEN;

        // first record is a filler - to stick all the children on !
        // reset my globals..
        $_HTML_TEMPLATE_FLEXY_TOKEN['base'] = 0;

        $_HTML_TEMPLATE_FLEXY_TOKEN['statevars'] = array();
        $_HTML_TEMPLATE_FLEXY_TOKEN['state'] = 0;

        $_HTML_TEMPLATE_FLEXY_TOKEN['flexyIgnore'] = false;
        if (@$GLOBALS['_HTML_TEMPLATE_FLEXY']['currentOptions']['flexyIgnore']) {
            $_HTML_TEMPLATE_FLEXY_TOKEN['flexyIgnore'] = true;
        }
        $_HTML_TEMPLATE_FLEXY_TOKEN['activeFormId'] = 0;
        $_HTML_TEMPLATE_FLEXY_TOKEN['activeForm'] = '';

        $_HTML_TEMPLATE_FLEXY_TOKEN['tokens'] = array(new HTML_Template_Flexy_Token);
        $_HTML_TEMPLATE_FLEXY_TOKEN['tokens'][0]->id =0;
        $_HTML_TEMPLATE_FLEXY_TOKEN['gettextStrings'] = array();
        $i=1;


        // initialize state - this trys to make sure that
        // you dont do to many elses etc.

        //echo "RUNNING TOKENIZER";
        // step one just tokenize it.
        while ($t = $tokenizer->yylex()) {

            if ($t == HTML_TEMPLATE_FLEXY_TOKEN_ERROR) {
                //echo "ERROR";

                //print_r($tokenizer);
                $err = "<PRE>" . $tokenizer->error . "\n" .
                    htmlspecialchars(substr($tokenizer->yy_buffer,0,$tokenizer->yy_buffer_end)) .
                    "<font color='red'>". htmlspecialchars(substr($tokenizer->yy_buffer,$tokenizer->yy_buffer_end,100)) .
                    ".......</font></PRE>";

                return HTML_Template_Flexy::raiseError('HTML_Template_Flexy::Syntax error in ".
                    "Template line:'. $tokenizer->yyline .
                    $err
                   , HTML_TEMPLATE_FLEXY_ERROR_SYNTAX ,HTML_TEMPLATE_FLEXY_ERROR_RETURN);
            }
            if ($t == HTML_TEMPLATE_FLEXY_TOKEN_NONE) {
                continue;
            }
            if ( $tokenizer->value->token == 'Php' ) {
                if (!$GLOBALS['_HTML_TEMPLATE_FLEXY']['currentOptions']['allowPHP']) {
                    return HTML_Template_Flexy::raiseError('PHP code found in script (Token)',
                        HTML_TEMPLATE_FLEXY_ERROR_SYNTAX,HTML_TEMPLATE_FLEXY_ERROR_RETURN
                    );
                }

                if ($GLOBALS['_HTML_TEMPLATE_FLEXY']['currentOptions']['allowPHP'] === 'delete') {
                    continue;
                }

            }
            $i++;
            $_HTML_TEMPLATE_FLEXY_TOKEN['tokens'][$i] = $tokenizer->value;
            $_HTML_TEMPLATE_FLEXY_TOKEN['tokens'][$i]->id = $i;

            // this whole children thing needs rethinking
            // - I think the body of the page should be wrapped: ..
            //  ?php if (!$this->bodyOnly) { .. <HTML> .... <BODY....>  ?php } ?
            //
            // old values alias to new ones..
            if (isset($_HTML_TEMPLATE_FLEXY_TOKEN['tokens'][$i]->ucAttributes['FLEXYSTART'])) {
                unset($_HTML_TEMPLATE_FLEXY_TOKEN['tokens'][$i]->ucAttributes['FLEXYSTART']);
                $_HTML_TEMPLATE_FLEXY_TOKEN['tokens'][$i]->ucAttributes['FLEXY:START'] = true;
            }

            if (isset($_HTML_TEMPLATE_FLEXY_TOKEN['tokens'][$i]->ucAttributes['FLEXYSTARTCHILDREN'])) {
                unset($_HTML_TEMPLATE_FLEXY_TOKEN['tokens'][$i]->ucAttributes['FLEXYSTARTCHILDREN']);
                $_HTML_TEMPLATE_FLEXY_TOKEN['tokens'][$i]->ucAttributes['FLEXY:STARTCHILDREN'] = true;
            }

            if (isset($_HTML_TEMPLATE_FLEXY_TOKEN['tokens'][$i]->ucAttributes['FLEXY:START'])) {
                $_HTML_TEMPLATE_FLEXY_TOKEN['base'] = $i;
                unset($_HTML_TEMPLATE_FLEXY_TOKEN['tokens'][$i]->ucAttributes['FLEXY:START']);
            }

            if (isset($_HTML_TEMPLATE_FLEXY_TOKEN['tokens'][$i]->ucAttributes['FLEXY:STARTCHILDREN'])) {
                $_HTML_TEMPLATE_FLEXY_TOKEN['base'] = $i;
            }


            //print_r($_HTML_TEMPLATE_FLEXY_TOKEN['tokens'][$i]);

        }
        //echo "BUILT TOKENS";

        $res = &$_HTML_TEMPLATE_FLEXY_TOKEN['tokens'];

        // DEBUG DUMPTING : foreach($res as $k) {  $k->dump(); }


        $stack = array();
        $total = $i +1;

        // merge strings and entities - blanking out empty text.


        for($i=1;$i<$total;$i++) {
            if (!isset($res[$i]) || !is_a($res[$i],'HTML_Template_Flexy_Token_Text')) {
                continue;
            }
            $first = $i;
            $i++;
            while ($i<$total && is_a($res[$i],'HTML_Template_Flexy_Token_Text')) {
                if (isset($res[$i])) {
                    $res[$first]->value .= $res[$i]->value;
                    $res[$i]->value = '';
                }
                $i++;
            }
        }
        // connect open  and close tags.

        // this is done by having a stack for each of the tag types..
        // then removing it when it finds the closing one
        // eg.
        //  <a href=""><img src=""></a>
        //  ends up with a stack for <a>'s and a stack for <img>'s
        //
        //
        //
        //echo '<PRE>' . htmlspecialchars(print_R($res,true));//exit;
        //echo '<PRE>';
        for($i=1;$i<$total;$i++) {

            if (empty($res[$i]->tag)) {
                continue;
            }
            //echo "Checking TAG $i {$res[$i]->tag}\n";
            if ($res[$i]->tag[0] == '/') { // it's a close tag..
                //echo "GOT END TAG: {$res[$i]->tag}\n";
                $tag = strtoupper(substr($res[$i]->tag,1));
                if (!count($stack)) {
                    continue;
                }
                $ssc = count($stack) - 1;
                /* go up the stack trying to find a match */
                for($s = $ssc; $s > -1; $s--) {
                    if (!isset($stack[$s])) {
                        echo "MISSED STACK? $s<BR><PRE>";print_r($stack);exit;
                    }
                    if (!isset($_HTML_TEMPLATE_FLEXY_TOKEN['tokens'][$stack[$s]])) {
                        echo "STACKED BAD OFFSET : {$stack[$s]}<BR><PRE>";print_r($stack);exit;
                    }
                    $tok =  &$_HTML_TEMPLATE_FLEXY_TOKEN['tokens'][$stack[$s]];
                    if (strtoupper($tok->tag) == $tag) {
                        // got the matching closer..
                        // echo "MATCH: {$i}:{$tok->tag}({$tok->line}) to  {$stack[$s]}:$tag<BR>";
                        $tok->close = &$_HTML_TEMPLATE_FLEXY_TOKEN['tokens'][$i];

                        array_splice($stack,$s);
                        //print_R($stack);

                        break;
                    }
                }
                continue;
            }
            $stack[] = $i;
            // tag with no closer (or unmatched in stack..)
        }


        // create a dummy close for the end
        $i = $total;
        $_HTML_TEMPLATE_FLEXY_TOKEN['tokens'][$i] = new HTML_Template_Flexy_Token;
        $_HTML_TEMPLATE_FLEXY_TOKEN['tokens'][$i]->id = $total;
        $_HTML_TEMPLATE_FLEXY_TOKEN['tokens'][0]->close = &$_HTML_TEMPLATE_FLEXY_TOKEN['tokens'][$total];

        // now is it possible to connect children...
        // now we need to GLOBALIZE!! -


        $_HTML_TEMPLATE_FLEXY_TOKEN['tokens'] = $res;

        HTML_Template_Flexy_Token::buildChildren(0);
        //new Gtk_VarDump($_HTML_TEMPLATE_FLEXY_TOKEN['tokens'][0]);
        //echo '<PRE>';print_R($_HTML_TEMPLATE_FLEXY_TOKEN['tokens'][$_HTML_TEMPLATE_FLEXY_TOKEN['base']]  );
        return $_HTML_TEMPLATE_FLEXY_TOKEN['tokens'][$_HTML_TEMPLATE_FLEXY_TOKEN['base']];
    }
    /**
    * Matching closing tag for a Token
    *
    * @var object|none  optional closing tag
    * @access public
    */


    var $close;

    /**
    * array of children to each object.
    *
    * @var array
    * @access public|private
    */


    var $children = array();

    /**
    * Build the child array for each element.
    * RECURSIVE FUNCTION!!!!
    * @param   int  id of node to add children to.
    *
    * @access   public
    * @static
    */
    public static function buildChildren($id)
    {
        global $_HTML_TEMPLATE_FLEXY_TOKEN;

        $base = &$_HTML_TEMPLATE_FLEXY_TOKEN['tokens'][$id];
        $base->children = array();
        $start = $base->id +1;
        $end = $base->close->id;

        for ($i=$start; $i<$end; $i++) {
            //echo "{$base->id}:{$base->tag} ADDING {$i}{$_HTML_TEMPLATE_FLEXY_TOKEN['tokens'][$i]->tag}<BR>";
            //if ($base->id == 1176) {
            //    echo "<PRE>";print_r($_HTML_TEMPLATE_FLEXY_TOKEN['tokens'][$i]);
            // }

            $base->children[] = &$_HTML_TEMPLATE_FLEXY_TOKEN['tokens'][$i];

            if (isset($_HTML_TEMPLATE_FLEXY_TOKEN['tokens'][$i]) &&
                is_object($_HTML_TEMPLATE_FLEXY_TOKEN['tokens'][$i]->close)) {

                // if the close id is greater than my id - ignore it! -
                if ($_HTML_TEMPLATE_FLEXY_TOKEN['tokens'][$i]->close->id > $end) {
                    continue;
                }
                HTML_Template_Flexy_Token::buildChildren($i);
                $i = $_HTML_TEMPLATE_FLEXY_TOKEN['tokens'][$i]->close->id;
            }
        }
    }



    /**
    * Flag to ignore children - Used to block output for select/text area etc.
    * may not be required as I moved the Tag parsing into the toString ph
    *
    * @var boolean ingore children
    * @access public
    */


    var $ignoreChildren = false;




    /* ======================================================== */
    /* variable STATE management
    *
    * raw variables are assumed to be $this->, unless defined by foreach..
    * it also monitors syntax - eg. end without an if/foreach etc.
    */


    /**
    * tell the generator you are entering a block
    *
    * @access   public
    */
    function pushState()
    {
        global $_HTML_TEMPLATE_FLEXY_TOKEN;

        $_HTML_TEMPLATE_FLEXY_TOKEN['state']++;
        $s = $_HTML_TEMPLATE_FLEXY_TOKEN['state'];

        $_HTML_TEMPLATE_FLEXY_TOKEN['statevars'][$s] = array(); // initialize statevars
    }
    /**
    * tell the generator you are entering a block
    *
    * @return  boolean  parse error - out of bounds
    * @access   public
    */
    function pullState()
    {
        global $_HTML_TEMPLATE_FLEXY_TOKEN;

        $s = $_HTML_TEMPLATE_FLEXY_TOKEN['state'];
        $_HTML_TEMPLATE_FLEXY_TOKEN['statevars'][$s] = array(); // initialize statevars
        $_HTML_TEMPLATE_FLEXY_TOKEN['state']--;
        if ($s<0) {
            return false;
        }
        return true;
    }
     /**
    * get the real variable name formated x.y.z => $this->x->y->z
    * if  a variable is in the stack it return $x->y->z
    *
    * @return  string PHP variable
    * @access   public
    */

    function toVar($s) {
        // wrap [] with quotes.
        $s = str_replace('[',"['",$s);
        $s = str_replace('%5b',"['",$s);
        $s = str_replace('%5B',"['",$s);
        $s = str_replace(']',"']",$s);
        $s = str_replace('%5d',"']",$s);
        $s = str_replace('%5D',"']",$s);
        // strip the quotes if it's only numbers..
        $s = preg_replace("/'([-]?[0-9]+)'/", "\\1",$s);

        $parts = explode(".",$s);


        $ret =  $this->findVar($parts[0]);
        if (is_a($ret,'PEAR_Error')) {
            return $ret;
        }

        array_shift($parts);

        if (!count($parts)) {
            return $ret;
        }
        foreach($parts as $p) {
            $ret .= "->{$p}";
        }
        return $ret;
    }
    /**
    * do the stack lookup on the variable
    * this relates to flexy
    * t relates to the object being parsed.
    *
    * @return  string PHP variable
    * @access   public
    */

    function findVar($string)
    {
        global $_HTML_TEMPLATE_FLEXY_TOKEN;

        if (!$string || $string == 't') {
            return '$t';
        }
        if ($string == 'this') {
            return '$this';
        }
        // accept global access on some string
        if (@$GLOBALS['_HTML_TEMPLATE_FLEXY']['currentOptions']['globals'] &&
            preg_match('/^(_POST|_GET|_REQUEST|_SESSION|_COOKIE|GLOBALS)\[/',$string)) {
            return '$'.$string;
        }
        if (!@$GLOBALS['_HTML_TEMPLATE_FLEXY']['currentOptions']['privates'] &&
                ($string[0] == '_')) {
                return HTML_Template_Flexy::raiseError('HTML_Template_Flexy::Attempt to access private variable:'.
                    " on line {$this->line} of {$GLOBALS['_HTML_TEMPLATE_FLEXY']['filename']}".
                    ", Use options[privates] to allow this."
                   , HTML_TEMPLATE_FLEXY_ERROR_SYNTAX ,HTML_TEMPLATE_FLEXY_ERROR_RETURN);
        }

        $lookup = $string;
        if ($p = strpos($string,'[')) {
            $lookup = substr($string,0,$p);
        }


        for ($s = $_HTML_TEMPLATE_FLEXY_TOKEN['state']; $s > 0; $s--) {
            if (in_array($lookup , $_HTML_TEMPLATE_FLEXY_TOKEN['statevars'][$s])) {
                return '$'.$string;
            }
        }
        return '$t->'.$string;
    }
    /**
    * add a variable to the stack.
    *
    * @param  string PHP variable
    * @access   public
    */

    function pushVar($string)
    {
        global $_HTML_TEMPLATE_FLEXY_TOKEN;
        $s = $_HTML_TEMPLATE_FLEXY_TOKEN['state'];
        $_HTML_TEMPLATE_FLEXY_TOKEN['statevars'][$s][] = $string;
    }

     /**
    * dump to text ATM
    *
    *
    * @access   public
    */

    function dump() {
        echo "{$this->token}/" . (isset($this->tag) ? "<{$this->tag}>" : '') . ": {$this->value}\n";
    }




}


