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
/* FC/BC compatibility with php5 */
if ( (substr(phpversion(),0,1) < 5) && !function_exists('clone')) {
    eval('function clone($t) { return $t; }');
}

/**
* Compiler That deals with standard HTML Tag output.
* Since it's pretty complex it has it's own class.
* I guess this class should deal with the main namespace
* and the parent (standard compiler can redirect other namespaces to other classes.
*
* one instance of these exists for each namespace.
*/

class HTML_Template_Flexy_Compiler_Flexy_Tag {


    /**
    * Parent Compiler for
    *
    * @var  object  HTML_Template_Flexy_Compiler
    *
    * @access public
    */
    var $compiler;

    /**
    *
    * Factory method to create Tag Handlers
    *
    * $type = namespace eg. <flexy:toJavascript loads Flexy.php
    * the default is this... (eg. Tag)
    *
    *
    * @param   string    Namespace handler for element.
    * @param   object   HTML_Template_Flexy_Compiler
    *
    *
    * @return    object    tag compiler
    * @access   public
    */

    function &factory($type,&$compiler) {
        if (!$type) {
            $type = 'Tag';
        }

        $class = 'HTML_Template_Flexy_Compiler_Flexy_' . $type;
        if (class_exists($class)) {
            $ret = new $class;
            $ret->compiler = &$compiler;
            return $ret;
        }

        $filename = 'HTML/Template/Flexy/Compiler/Flexy/' . ucfirst(strtolower($type)) . '.php';
        if (!HTML_Template_Flexy_Compiler_Flexy_Tag::fileExistsInPath($filename)) {
            return HTML_Template_Flexy_Compiler_Flexy_Tag::factory('Tag',$compiler);
        }
        // if we dont have a handler - just use the basic handler.
        if (!file_exists(dirname(__FILE__) . '/'. ucfirst(strtolower($type)) . '.php')) {
            $type = 'Tag';
        }

        include_once 'HTML/Template/Flexy/Compiler/Flexy/' . ucfirst(strtolower($type)) . '.php';

        $class = 'HTML_Template_Flexy_Compiler_Flexy_' . $type;
        if (!class_exists($class)) {
            return false;
        }
        return HTML_Template_Flexy_Compiler_Flexy_Tag::factory($type,$compiler);
    }
    /**
    *
    * Check that a file exists in the "include_path"
    *
    * @param   string    Filename
    *
    * @return    boolean  true if it is in there.
    * @access   public
    */
    function fileExistsInPath($filename) {
        if (isset($GLOBALS['_'.__CLASS__]['cache'][$filename])) {
            return $GLOBALS['_'.__CLASS__]['cache'][$filename];
        }
        $bits = explode(PATH_SEPARATOR,ini_get('include_path'));
        foreach($bits as $b) {
            if (file_exists("$b/$filename")) {
                return $GLOBALS['_'.__CLASS__]['cache'][$filename] = true;
            }
        }
        return $GLOBALS['_'.__CLASS__]['cache'][$filename] = false;
    }



    /**
    * The current element to parse..
    *
    * @var object
    * @access public
    */
    var $element;

    /**
    * Flag to indicate has attribute flexy:foreach (so you cant mix it with flexy:if!)
    *
    * @var boolean
    * @access public
    */
    var $hasForeach = false;

    /**
    * toString - display tag, attributes, postfix and any code in attributes.
    * Note first thing it does is call any parseTag Method that exists..
    *
    *
    * @see parent::toString()
    */
    function toString($element)
    {

        global $_HTML_TEMPLATE_FLEXY_TOKEN;
        global $_HTML_TEMPLATE_FLEXY;

        // store the element in a variable
        $this->element = $element;
       // echo "toString: Line {$this->element->line} &lt;{$this->element->tag}&gt;\n";

        // if the FLEXYSTARTCHILDREN flag was set, only do children
        // normally set in BODY tag.
        // this will probably be superseeded by the Class compiler.

        if (isset($element->ucAttributes['FLEXY:STARTCHILDREN'])) {

            return $element->compileChildren($this->compiler);
        }
        // look for flexy:ignore..
        $flexyignore = $this->parseAttributeIgnore();

        // rewriting should be done with a tag.../flag.

        $this->reWriteURL("HREF");
        $this->reWriteURL("SRC");

        // handle elements
        if (($ret =$this->_parseTags()) !== false) {
            return $ret;
        }
        // these add to the close tag..

        $ret  = $this->parseAttributeForeach();
        $ret .= $this->parseAttributeIf();

        // spit ou the tag and attributes.

        if ($element->oTag{0} == '?') {
            $ret .= '<?php echo "<"; ?>';
        } else {
            $ret .= "<";
        }
        $ret .= $element->oTag;
        //echo '<PRE>'.print_r($element->attributes,true);
        foreach ($element->attributes as $k=>$v) {
            // if it's a flexy tag ignore it.


            if (strtoupper($k) == 'FLEXY:RAW') {
                if (!is_array($v) || !isset($v[1]) || !is_object($v[1])) {
                    return HTML_Template_Flexy::raiseError(
                        'flexy:raw only accepts a variable or method call as an argument, eg.'.
                        ' flexy:raw="{somevalue}" you provided something else.' .
                        " Error on Line {$this->element->line} &lt;{$this->element->tag}&gt;",
                         null,   HTML_TEMPLATE_FLEXY_ERROR_DIE);
                }
                $add = $v[1]->compile($this->compiler);
                if (is_a($add,'PEAR_Error')) {
                    return $add;
                }
                $ret .= ' ' . $add;
                continue;

            }

            if (strtoupper(substr($k,0,6)) == 'FLEXY:') {
                continue;
            }
            // true == an attribute without a ="xxx"
            if ($v === true) {
                $ret .= " $k";
                continue;
            }

            // if it's a string just dump it.
            if (is_string($v)) {
                $v = str_replace(array('{_(',')_}'),array('',''),$v);
                $ret .=  " {$k}={$v}";
                continue;
            }

            // normally the value is an array of string, however
            // if it is an object - then it's a conditional key.
            // eg.  if (something) echo ' SELECTED';
            // the object is responsible for adding it's space..

            if (is_object($v)) {
                $add = $v->compile($this->compiler);
                if (is_a($add,'PEAR_Error')) {
                    return $add;
                }

                $ret .= $add;
                continue;
            }

            // otherwise its a key="sometext{andsomevars}"

            $ret .=  " {$k}=";

            foreach($v as $item) {

                if (is_string($item)) {
                    // skip translation strings in tags.
                    $item = str_replace(array('{_(',')_}'),array('',''),$item);
                    $ret .= $item;
                    continue;
                }
                $add = $item->compile($this->compiler);
                if (is_a($add,'PEAR_Error')) {
                    return $add;
                }
                $ret .= $add;
            }
        }
        $ret .= ">";

        // post stuff this is probably in the wrong place...

        if ($element->postfix) {
            foreach ($element->postfix as $e) {
                $add = $e->compile($this->compiler);
                if (is_a($add,'PEAR_Error')) {
                    return $add;
                }
                $ret .= $add;
            }
        } else if ($this->element->postfix) { // if postfixed by self..
            foreach ($this->element->postfix as $e) {
                $add = $e->compile($this->compiler);
                if (is_a($add,'PEAR_Error')) {
                    return $add;
                }

                $ret .= $add;
            }
        }
        // dump contents of script raw - to prevent gettext additions..
        //  print_r($element);
        if ($element->tag == 'SCRIPT') {
            foreach($element->children as $c) {
                //print_R($c);
                if (!$c) {
                    continue;
                }
                if ($c->token == 'Text') {
                    $ret .= $c->value;
                    continue;
                }
                // techically we shouldnt have anything else inside of script tags.
                // as the tokeinzer is supposted to ignore it..
            }
        } else {
            $add = $element->compileChildren($this->compiler);
            if (is_a($add,'PEAR_Error')) {
                return $add;
            }
            $ret .= $add;
        }



        // output the closing tag.

        if ($element->close) {
            $add = $element->close->compile($this->compiler);
            if (is_a($add,'PEAR_Error')) {
                return $add;
            }
            $ret .= $add;
        }

        // reset flexyignore

        $_HTML_TEMPLATE_FLEXY_TOKEN['flexyIgnore'] = $flexyignore;

        if (isset($_HTML_TEMPLATE_FLEXY['currentOptions']['output.block']) &&
            ($_HTML_TEMPLATE_FLEXY['currentOptions']['output.block'] == $element->getAttribute('ID'))) {

           // echo $_HTML_TEMPLATE_FLEXY['compiledTemplate'];

            $fh = fopen($_HTML_TEMPLATE_FLEXY['compiledTemplate'],'w');
            fwrite($fh,$ret);
            fclose($fh);

        }



        return $ret;
    }
    /**
    * Reads an flexy:foreach attribute -
    *
    *
    * @return   string to add to output.
    * @access   public
    */

    function parseAttributeIgnore()
    {

        global $_HTML_TEMPLATE_FLEXY_TOKEN;

        $flexyignore = $_HTML_TEMPLATE_FLEXY_TOKEN['flexyIgnore'];

        if ($this->element->getAttribute('FLEXY:IGNORE') !== false) {
            $_HTML_TEMPLATE_FLEXY_TOKEN['flexyIgnore'] = true;
            $this->element->clearAttribute('FLEXY:IGNORE');
        }
        return $flexyignore;

    }

    /**
    * Reads an flexy:foreach attribute -
    *
    *
    * @return   string to add to output.
    * @access   public
    */

    function parseAttributeForeach()
    {
        global  $_HTML_TEMPLATE_FLEXY;
        $foreach = $this->element->getAttribute('FLEXY:FOREACH');
        if ($foreach === false) {
            return '';
        }
        //var_dump($foreach);

        $this->element->hasForeach = true;
        // create a foreach element to wrap this with.

        $foreachObj =  $this->element->factory('Foreach',
                explode(',',$foreach),
                $this->element->line);
        // failed = probably not enough variables..


        if ($foreachObj === false) {

            return HTML_Template_Flexy::raiseError(
                "Missing Arguments: An flexy:foreach attribute was foundon Line {$this->element->line}
                in tag &lt;{$this->element->tag} flexy:foreach=&quot;$foreach&quot; .....&gt;<BR>
                the syntax is  &lt;sometag flexy:foreach=&quot;onarray,withvariable[,withanothervar] &gt;<BR>",
                 null,  HTML_TEMPLATE_FLEXY_ERROR_DIE);
        }



        // does it have a closetag?
        if (!$this->element->close) {

            if ($this->element->getAttribute('/') === false) {


                return HTML_Template_Flexy::raiseError(
                    "A flexy:foreach attribute was found in &lt;{$this->element->tag} tag without a corresponding &lt;/{$this->element->tag}
                        tag on {$_HTML_TEMPLATE_FLEXY['filename']}:{$this->element->line} ",
                     null, HTML_TEMPLATE_FLEXY_ERROR_DIE);
            }
            // it's an xhtml tag!
            $this->element->postfix = array($this->element->factory("End", '', $this->element->line));
        } else {
            $this->element->close->postfix = array($this->element->factory("End", '', $this->element->line));
        }

        $this->element->clearAttribute('FLEXY:FOREACH');
        return $foreachObj->compile($this->compiler);
    }
    /**
    * Reads an flexy:if attribute -
    *
    *
    * @return   string to add to output.
    * @access   public
    */

    function parseAttributeIf()
    {
        // dont use the together, if is depreciated..
        $if = $this->element->getAttribute('FLEXY:IF');

        if ($if === false) {
            return '';
        }

        if (isset($this->element->hasForeach)) {
            return HTML_Template_Flexy::raiseError(
                "You may not use FOREACH and IF tags in the same tag on Line {$this->element->line} &lt;{$this->element->tag}&gt;",
                 null, HTML_TEMPLATE_FLEXY_ERROR_DIE);
        }

        // allow if="!somevar"
        $ifnegative = '';

        if ($if{0} == '!') {
            $ifnegative = '!';
            $if = substr($if,1);
        }
        // if="xxxxx"
        // if="xxxx.xxxx()" - should create a method prefixed with 'if:'
        // these checks should really be in the if/method class..!!!



        if (!preg_match('/^[_A-Z][A-Z0-9_]*(\[[0-9]+\])?((\[|%5B)[A-Z0-9_]+(\]|%5D))*'.
                '(\.[_A-Z][A-Z0-9_]*((\[|%5B)[A-Z0-9_]+(\]|%5D))*)*(\\([^)]*\))?$/i',$if)) {
            return HTML_Template_Flexy::raiseError(
                "IF tags only accept simple object.variable or object.method() values on
                    Line {$this->element->line} &lt;{$this->element->tag}&gt;
                    {$if}",
                 null, HTML_TEMPLATE_FLEXY_ERROR_DIE);
        }

        if (substr($if,-1) == ')') {
            // grab args..
            $args = substr($if,strpos($if,'(')+1,-1);
            // simple explode ...

            $args = strlen(trim($args)) ? explode(',',$args) : array();
            //print_R($args);

            // this is nasty... - we need to check for quotes = eg. # at beg. & end..
            $args_clean = array();
            for ($i=0; $i<count($args); $i++) {
                if ($args[$i]{0} != '#') {
                    $args_clean[] = $args[$i];
                    continue;
                }
                // single # - so , must be inside..
                if ((strlen($args[$i]) > 1) && ($args[$i]{strlen($args[$i])-1}=='#')) {
                    $args_clean[] = $args[$i];
                    continue;
                }

                $args[$i] .=',' . $args[$i+1];
                // remove args+1..
                array_splice($args,$i+1,1);
                $i--;
                // reparse..
            }



            $ifObj =  $this->element->factory('Method',
                    array('if:'.$ifnegative.substr($if,0,strpos($if,'(')), $args_clean),
                    $this->element->line);
        } else {
            $ifObj =  $this->element->factory('If', $ifnegative.$if, $this->element->line);
        }

        // does it have a closetag? - you must have one - so you will have to hack in <span flexy:if=..><img></span> on tags
        // that do not have close tags - it's done this way to try and avoid mistakes.


        if (!$this->element->close) {
            //echo "<PRE>";print_R($this->element);

            if ($this->element->getAttribute('/') !== false) {
                $this->element->postfix = array($this->element->factory("End",'', $this->element->line));
            } else {

                return HTML_Template_Flexy::raiseError(
                    "An flexy:if attribute was found in &lt;{$this->element->name} tag without a corresponding &lt;/{$this->element->name}
                        tag on Line {$this->element->line} &lt;{$this->element->tag}&gt;",
                     null, HTML_TEMPLATE_FLEXY_ERROR_DIE);
                }
        } else {

            $this->element->close->postfix = array($this->element->factory("End",'', $this->element->line));
        }
        $this->element->clearAttribute('FLEXY:IF');
        return $ifObj->compile($this->compiler);
    }

     /**
    * Reads Tags - and relays to parseTagXXXXXXX
    *
    *
    * @return   string | false = html output or ignore (just output the tag)
    * @access   private
    */


    function _parseTags()
    {
        global $_HTML_TEMPLATE_FLEXY_TOKEN;
        // doesnt really need strtolower etc. as php functions are not case sensitive!


        /* always render script correctly */
        if (0 == strcasecmp($this->element->tag,"script")) {
            return $this->parseTagScript();
        }

        if ($this->element->getAttribute('FLEXY:DYNAMIC')) {
            return $this->compiler->appendPhp(
                $this->getElementPhp( $this->element->getAttribute('ID') )
            );

        }

        if ($this->element->getAttribute('FLEXY:IGNOREONLY') !== false) {
            return false;
        }
        if ($_HTML_TEMPLATE_FLEXY_TOKEN['flexyIgnore']) {
            return false;
        }
        $tag = $this->element->tag;
        if (strpos($tag,':') !== false) {
            $bits = explode(':',$tag);
            $tag = $bits[1];
        }

        $method = 'parseTag'.$tag;
        if (!method_exists($this,$method)) {
            return false;
        }

        if (($this->element->getAttribute('NAME') === false) &&
            ($this->element->getAttribute('ID') === false) ) {
            return false;
        }
        // do any of the attributes use flexy data...
        //foreach ($this->element->attributes as $k=>$v) {
        //    if (is_array($v)) {
        //        return false;
        //   }
        //}

        //echo "call $method" . serialize($this->element->attributes). "\n";

        return $this->$method();
            // allow the parse methods to return output.

    }




    /**
    * produces the code for dynamic elements
    *
    * @return   string | false = html output or ignore (just output the tag)
    * @access   public
    */

    function getElementPhp($id,$mergeWithName=false,$varsOnly = false) {

        global $_HTML_TEMPLATE_FLEXY;
        static $tmpId=0;



        if (!$id) {

            return HTML_Template_Flexy::raiseError(
                "Error:{$_HTML_TEMPLATE_FLEXY['filename']} on Line {$this->element->line} &lt;{$this->element->tag}&gt;: " .
                " Dynamic tags require an ID value",
                null, HTML_TEMPLATE_FLEXY_ERROR_DIE);
        }

        // dont mix and match..
        if (($this->element->getAttribute('FLEXY:IF') !== false) ||
            ($this->element->getAttribute('FLEXY:FOREACH') !== false) )
        {
            return HTML_Template_Flexy::raiseError(
                "Error:{$_HTML_TEMPLATE_FLEXY['filename']} on Line {$this->element->line} &lt;{$this->element->tag}&gt;: " .
                " You can not mix flexy:if= or flexy:foreach= with dynamic form elements  " .
                " (turn off tag to element code with flexyIgnore=0, use flexy:ignore=&quot;yes&quot; in the tag" .
                " or put the conditional outside in a span tag",
                null, HTML_TEMPLATE_FLEXY_ERROR_DIE);
        }

        if ((strtolower($this->element->getAttribute('type')) == 'checkbox' ) &&
                (substr($this->element->getAttribute('name'),-2) == '[]')) {
            if ($this->element->getAttribute('id') === false) {
                $id = 'tmpId'. (++$tmpId);
                $this->element->attributes['id'] = $id;
                $this->element->ucAttributes['ID'] = $id;
            }
            $mergeWithName =  true;
        }





        if (isset($_HTML_TEMPLATE_FLEXY['elements'][$id])) {
           // echo "<PRE>";print_r($this);print_r($_HTML_TEMPLATE_FLEXY['elements']);echo "</PRE>";
            return HTML_Template_Flexy::raiseError(
                "Error:{$_HTML_TEMPLATE_FLEXY['filename']} on Line {$this->element->line} in Tag &lt;{$this->element->tag}&gt;:<BR> " .
                 "The Dynamic tag Name '$id' has already been used previously by  tag &lt;{$_HTML_TEMPLATE_FLEXY['elements'][$id]->tag}&gt;",
                 null,HTML_TEMPLATE_FLEXY_ERROR_DIE);
        }

        $ret = '';
        $unset = '';

        //echo '<PRE>';print_r($this->element);echo '</PRE>';
        if (isset($this->element->ucAttributes['FLEXY:USE'])) {
            $ar = $this->element->ucAttributes['FLEXY:USE'];
            $str = '';

            for($i =1; $i < count($ar) -1; $i++) {
                switch(true) {
                    case is_a($ar[$i], 'HTML_Template_Flexy_Token_Var'):
                        $str .= '. ' . $ar[$i]->toVar($ar[$i]->value). ' ';
                        break;
                    case is_string($ar[$i]):
                        $str .= '. ' . $ar[0] . $ar[$i] . $ar[0];
                        break;
                    default:
                        return HTML_Template_Flexy::raiseError(
                            "unsupported type found in attribute, use flexy:ignore to prevent parsing or remove it. " .
                                print_r($this->element,true),
                            null,HTML_TEMPLATE_FLEXY_ERROR_DIE);
                }
            }
            $str = trim(ltrim($str,'.'));
            $_HTML_TEMPLATE_FLEXY['elements'][$id] = $this->toElement($this->element);

            return  $ret .
                '
                if (!isset($this->elements['.$str.'])) {
                    echo "ELEMENT MISSING $str";
                }
                echo $this->elements['.$str.']->toHtml();' .$unset;
        }



        if ($this->elementUsesDynamic($this->element)) {
            $used = array();
            foreach ($this->element->attributes as $attribute => $attributeValue) {
                if (!is_array($attributeValue)) {
                    continue;
                }
                if (strtoupper(substr($attribute,0,6)) == 'FLEXY:') {
                    continue;
                }
                unset($this->element->attributes[$attribute]);
                // generate code to put data into value..
                $output_avar = '$this->elements[\''.$id.'\']->attributes[\''.$attribute.'\']';
                $used[] = "'{$attribute}'";
                $ret .= "\nif (!isset({$output_avar})) {\n";
                // get the " or ' that encapsulates the element.
                $wrapper = array_shift($attributeValue);
                array_pop($attributeValue);
                $ret .= "    {$output_avar} = '';\n";
                //echo '<PRE>';print_r($attributeValue);echo '</PRE>';
                foreach($attributeValue as $item) {

                    if (is_string($item)) {
                        $ret .= "    {$output_avar} .= {$wrapper}{$item}{$wrapper};\n";
                        continue;
                    }
                    if (!is_object($item) || !is_a($item, 'HTML_Template_Flexy_Token_Var')) {
                        return HTML_Template_Flexy::raiseError(
                            "unsupported type found in attribute, use flexy:ignore to prevent parsing or remove it. " .
                                print_r($this->element,true),
                            null,HTML_TEMPLATE_FLEXY_ERROR_DIE);
                    }

                    $var = $item->toVar($item->value);
                    if (is_a($var, 'PEAR_Error')) {
                        return $var;
                    }
                    list($prefix,$suffix) = $this->compiler->getModifierWrapper($item);
                    $prefix =  substr($prefix,4);

                    $ret .= "    {$output_avar} .= {$prefix}{$var}{$suffix};\n";
                }

                $ret .= "}\n";
            }
            $ret .= "\$_attributes_used = array(".implode(',',$used).");\n";
            $unset = "\n".'if (isset($_attributes_used)) {  foreach($_attributes_used as $_a) {'."\n".
                     '    unset($this->elements[\''. $id .'\']->attributes[$_a]);'."\n" .
                     "}}\n";


        }




        // this is for a case where you can use a sprintf as the name, and overlay it with a variable element..
        $_HTML_TEMPLATE_FLEXY['elements'][$id] = $this->toElement($this->element);



        if ($varsOnly) { // used by form tag.
            return array($ret,$unset);
        }

        if ($var = $this->element->getAttribute('FLEXY:NAMEUSES')) {

            $var = 'sprintf(\''.$id .'\','.$this->element->toVar($var) .')';
            return  $ret .
                'if (!isset($this->elements['.$var.'])) $this->elements['.$var.']= $this->elements[\''.$id.'\'];
                $this->elements['.$var.'] = $this->mergeElement($this->elements[\''.$id.'\'],$this->elements['.$var.']);
                $this->elements['.$var.']->attributes[\'name\'] = '.$var. ';
                echo $this->elements['.$var.']->toHtml();' .$unset;
        }


        if ($mergeWithName) {
            $name = $this->element->getAttribute('NAME');
            return  $ret .
                '$element = $this->elements[\''.$id.'\'];
                $element = $this->mergeElement($element,$this->elements[\''.$name.'\']);
                echo  $element->toHtml();' . $unset;

        }
        return $ret . 'echo $this->elements[\''.$id.'\']->toHtml();'. $unset;

    }

    /**
    * Reads an Script tag - check if PHP is allowed.
    *
    * @return   false|PEAR_Error
    * @access   public
    */
    function parseTagScript() {


        $lang = $this->element->getAttribute('LANGUAGE');
        if (!$lang) {
            return false;
        }
        $lang = strtoupper($lang);
        $allow = $GLOBALS['_HTML_TEMPLATE_FLEXY']['currentOptions']['allowPHP'];

        if ($allow === true) {

            return false;
        }

        if ($lang == "PHP") {
            if ($allow == 'delete') {
                return '';
            }
            return HTML_Template_Flexy::raiseError('PHP code found in script (script)',
                HTML_TEMPLATE_FLEXY_ERROR_SYNTAX,HTML_TEMPLATE_FLEXY_ERROR_RETURN
            );
        }
        return false;

    }
    /**
    * Reads an Input tag - build a element object for it
    *
    *
    * @return   string | false = html output or ignore (just output the tag)
    * @access   public
    */


    function parseTagInput()
    {
        global $_HTML_TEMPLATE_FLEXY;

        if (in_array(strtoupper($this->element->getAttribute('TYPE')), array('SUBMIT','BUTTON','INPUT','')))  {
            $this->compiler->addStringToGettext($this->element->getAttribute('VALUE'));
        }
        // form elements : format:
        //value - fill out as PHP CODE

        // as a general rule, this uses name, rather than ID except on
        // radio
        $mergeWithName = false;
        $id = $this->element->getAttribute('NAME');


        if (isset($this->element->ucAttributes['FLEXY:RAW'])) {
            return HTML_Template_Flexy::raiseError(
                    "Error:{$_HTML_TEMPLATE_FLEXY['filename']} on Line {$this->element->line} ".
                    "in Tag &lt;{$this->element->tag}&gt;:<BR>".
                    "Flexy:raw can only be used with flexy:ignore, to prevent conversion of html ".
                    "elements to flexy elements",
                    null, HTML_TEMPLATE_FLEXY_ERROR_DIE
            );
        }
        // checkboxes need more work.. - at the momemnt assume one with the same value...
        if (in_array(strtoupper($this->element->getAttribute('TYPE')), array('RADIO'))) {

            if (!isset($_HTML_TEMPLATE_FLEXY['elements'][$id])) {
                // register it..  - so we dont overwrite it...
                $_HTML_TEMPLATE_FLEXY['elements'][$id] = false;
            } else if ($_HTML_TEMPLATE_FLEXY['elements'][$id] != false) {


                return HTML_Template_Flexy::raiseError(
                    "Error:{$_HTML_TEMPLATE_FLEXY['filename']} on Line {$this->element->line} ".
                    "in Tag &lt;{$this->element->tag}&gt;:<BR>".
                    "The Dynamic tag Name '$id' has already been used previously by ".
                    "tag &lt;{$_HTML_TEMPLATE_FLEXY['elements'][$id]->tag}&gt;",
                     null, HTML_TEMPLATE_FLEXY_ERROR_DIE
                );
            }

            $id = $this->element->getAttribute('ID');
            if (!$id) {
                return HTML_Template_Flexy::raiseError("Error on Line {$this->element->line} &lt;{$this->element->tag}&gt;:
                 Radio Input's require an ID attribute (eg &lt;input type='radio' id='1' name='xxxx' value='yyy'&gt;..",
                 null, HTML_TEMPLATE_FLEXY_ERROR_DIE);
            }
            $mergeWithName = true;

        }
        if (!$id) {
            return false;
        }
        return $this->compiler->appendPhp($this->getElementPhp( $id,$mergeWithName));

    }

    /**
    * Deal with a TextArea tag - build a element object for it
    *
    * @return   string | false = html output or ignore (just output the tag)
    * @access   public
    */

    function parseTagTextArea()
    {

        return $this->compiler->appendPhp(
            $this->getElementPhp( $this->element->getAttribute('NAME')));



    }
    /**
    * Deal with Selects - build a element object for it (unless flexyignore is set)
    *
    *
    * @return   string | false = html output or ignore (just output the tag)
    * @access   public
    */

    function parseTagSelect()
    {
        return $this->compiler->appendPhp(
            $this->getElementPhp( $this->element->getAttribute('NAME')));
    }




     /**
    * Reads an Form tag - and set up the element object header etc.
    *
    * @return   string | false = html output or ignore (just output the tag)
    * @access   public
    */

    function parseTagForm()
    {
        global $_HTML_TEMPLATE_FLEXY;
        $copy = clone($this->element);
        $copy->children = array();
        $id = $this->element->getAttribute('NAME');
        // dont make forms dynamic if they dont have a name..
        if (!$id) {
            return false;
        }

        // this adds the element to the elements array.
        $old = clone($this->element);
        $this->element = $copy;
        list($prefix,$suffix) = $this->getElementPhp($id,false,true);
        $this->element= $old;


        return
            $this->compiler->appendPhp($prefix .'echo $this->elements[\''.$id.'\']->toHtmlnoClose();'.$suffix) .
            $this->element->compileChildren($this->compiler) .
            $this->compiler->appendHtml( "</{$copy->oTag}>");

    }





    /**
    * reWriteURL - can using the config option 'url_rewrite'
    *  format "from:to,from:to"
    * only handle left rewrite.
    * so
    *  "/images:/myroot/images"
    * would change
    *   /images/xyz.gif to /myroot/images/xyz.gif
    *   /images/stylesheet/imagestyles.css to  /myroot/images/stylesheet/imagestyles.css
    *   note /imagestyles did not get altered.
    * will only work on strings (forget about doing /images/{someimage}
    *
    *
    * @param    string attribute to rewrite
    * @return   none
    * @access   public
    */
    function reWriteURL($which)
    {
        global  $_HTML_TEMPLATE_FLEXY;


        if (!is_string($original = $this->element->getAttribute($which))) {
            return;
        }

        if ($original == '') {
            return;
        }

        if (empty($_HTML_TEMPLATE_FLEXY['currentOptions']['url_rewrite'])) {
            return;
        }

        $bits = explode(",",$_HTML_TEMPLATE_FLEXY['currentOptions']['url_rewrite']);
        $new = $original;

        foreach ($bits as $bit) {
            if (!strlen(trim($bit))) {
                continue;
            }
            $parts = explode (':', $bit);
            if (!isset($parts[1])) {
                return HTML_Template_Flexy::raiseError('HTML_Template_Flexy: url_rewrite syntax incorrect'.
                    print_r(array($bits,$bits),true),null,HTML_TEMPLATE_FLEXY_ERROR_DIE);
            }
            $new = preg_replace('#^'.$parts[0].'#',$parts[1], $new);
        }


        if ($original == $new) {
            return;
        }
        $this->element->ucAttributes[$which] = '"'. $new . '"';
    }

    /**
    * Convert flexy tokens to HTML_Template_Flexy_Elements.
    *
    * @param    object token to convert into a element.
    * @return   object HTML_Template_Flexy_Element
    * @access   public
    */
    function toElement($element) {
        require_once 'HTML/Template/Flexy/Element.php';
        $ret = new HTML_Template_Flexy_Element;

        if (strtolower(get_class($element)) != 'html_template_flexy_token_tag') {
            $this->compiler->addStringToGettext($element->value);
            return $element->value;
        }


        $ret->tag = strtolower($element->tag);

        $ats = $element->getAttributes();

        if (isset($element->attributes['flexy:xhtml'])) {
            $ats['flexy:xhtml'] = true;
        }

        foreach(array_keys($ats)  as $a) {
            $ret->attributes[$a] = $this->unHtmlEntities($ats[$a]);
        }
        //print_r($ats);
        if (!$element->children) {
            return $ret;
        }

        // children - normally to deal with <element>

        //print_r($this->children);
        foreach(array_keys($element->children) as $i) {
            // not quite sure why this happens - but it does.
            if (!is_object($element->children[$i])) {
                continue;
            }
            $ret->children[] = $this->toElement($element->children[$i]);
        }
        return $ret;
    }

      /**
    * do the reverse of htmlspecialchars on an attribute..
    *
    * copied from get-html-translation-table man page
    *
    * @param   mixed       from attribute values
    *
    * @return   string          return
    * @access   public
    * @see      see also methods.....
    */

    function unHtmlEntities ($in)
    {
        if (!is_string($in)) {
            return $in;
        }
        $trans_tbl = get_html_translation_table (HTML_ENTITIES);
        $trans_tbl = array_flip ($trans_tbl);
        $ret = strtr ($in, $trans_tbl);
        return preg_replace('/&#(\d+);/me', "chr('\\1')",$ret);
    }


     /**
    * Deal with XUL MenuItems
    *
    * @return   string | false = html output or ignore (just output the tag)
    * @access   public
    */

    function parseTagMenuList()
    {

        // does it contain any flexy tags??
        if ($this->elementUsesDynamic($this->element)) {
            return false;
        }

        return $this->compiler->appendPhp(
            $this->getElementPhp( $this->element->getAttribute('ID')));
    }
     /**
    * Recursively search for any flexy:if flexy:foreach or {xxxx} tags inside tags..
    *
    * @param    HTML_Template_Flexy_Token   element to check.
    * @return   boolean true if it finds a  dynamic tag.
    * @access   public
    */


    function elementUsesDynamic($e) {
        if (is_a($e,'HTML_Template_Flexy_Token_Var')) {
            return true;
        }
        if (is_a($e,'HTML_Template_Flexy_Token_Foreach')) {
            return true;
        }
        if (is_a($e,'HTML_Template_Flexy_Token_If')) {
            return true;
        }
        if (is_a($e,'HTML_Template_Flexy_Token_Method')) {
            return true;
        }
        if (!is_a($e,'HTML_Template_Flexy_Token_Tag')) {
            return false;
        }
        if  ($e->getAttribute('FLEXY:IF')  !== false) {
            return true;
        }
        if  ($e->getAttribute('FLEXY:FOREACH')  !== false) {
            return true;
        }
        foreach($e->attributes as $k=>$v) {
            if (is_array($v) || is_object($v)) {
                return true;
            }
        }
        foreach($e->children as $c) {
            if ($this->elementUsesDynamic($c)) {
                return true;
            }
        }
        return false;



    }



}


