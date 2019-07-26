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
// | Authors:  Alan Knowles <alan@akbkhome.com>                           |
// +----------------------------------------------------------------------+
//
// The Html Tree Component of Flexy
// Designed to be used on it's own
//
// The concept:
// - it builds a big tokens[] array :
// - filters "Text with {placeholders}" into sprintf formated strings.
// - matches closers to openers eg. token[4]->close = &token[5];
// - it aliases the tokens into token[0] as children as a tree
// - locates the base of the file. (flexy:startchildren.
// returns a nice tree..


class HTML_Template_Flexy_Tree {

    /**
    * Options for Tree:
    * 'ignore'          =>   dont change {xxxX} into placeholders?
    * 'filename'        =>   filename of file being parsed. (for error messages.)
    * 'ignore_html'     =>   return <html> elements as strings.
    * 'ignore_php'      =>   DELETE/DESTROY any php code in the original template.
    */

    var $options = array(
        'ignore'        => false, // was flexyIgnore
        'filename'      => false,
        'ignore_html'   => false,
        'ignore_php'    => true,
    );


    /**
    * Array of all tokens (eg. nodes / text / tags etc. )
    * All nodes have ID's
    *
    * eg.
    *   <b>some text</b>
    *  [0] => Token_Tag::
    *         tagname = '<b>'
    *         children = array( &tag[1] );
              close  = &tag[2];
    *  [1] => Token_Text::'some test'
    *  [2] => Token_Tag::
    *         tagname = '</b>';
    *
    *
    *  under normal situations, the tree is built into node[0], the remaining nodes are referenced by alias.
    *  if caching is used (the nodes > 0 will not exist, and everything will just be a child of node 0.
    *
    *
    *
    * @var array
    * @access public
    */

    var $tokens     = array();
    var $strings    = array();






    /**
    * Run a Tokenizer and Store its results and return the tree.
    * It should build a DOM Tree of the HTML
    *
    * @param   string $data         data to parse.
    * @param    array $options      see options array.
    *
    * @access   public
    * @return   base token (really a dummy token, which contains the tree)
    * @static
    */

    function construct($data,$options=array())
    {

        // local caching!
        $md5 = md5($data);
        if (isset($GLOBALS[__CLASS__]['cache'][$md5])) {
            return $GLOBALS[__CLASS__]['cache'][$md5];
        }

        $t = new HTML_Template_Flexy_Tree;
        $t->options = $t->options + $options;
        require_once 'HTML/Template/Flexy/Token.php';
        $t->tokens = array(new HTML_Template_Flexy_Token);
        $t->tokens[0]->id =0;

        // process
        if (is_a($r = $t->tokenize($data),'PEAR_Error')) {
            return $r;
        }

        $t->matchClosers();
        $t->buildChildren(0);
        //new Gtk_VarDump($_HTML_TEMPLATE_FLEXY_TOKEN['tokens'][0]);

        $GLOBALS[__CLASS__]['cache'][$md5] = $t->returnStart();
        return $GLOBALS[__CLASS__]['cache'][$md5];

    }

    /**
    * The core tokenizing part - runs the tokenizer on the data,
    * and stores the results in $this->tokens[]
    *
    * @param   string               Data to tokenize
    *
    * @return   none | PEAR::Error
    * @access   public|private
    * @see      see also methods.....
    */


    function tokenize($data) {
        require_once 'HTML/Template/Flexy/Tokenizer.php';
        $tokenizer =  &HTML_Template_Flexy_Tokenizer::construct($data,$this->options);

        // initialize state - this trys to make sure that
        // you dont do to many elses etc.

        //echo "RUNNING TOKENIZER";
        // step one just tokenize it.
        $i=1;
        while ($t = $tokenizer->yylex()) {

            if ($t == HTML_TEMPLATE_FLEXY_TOKEN_ERROR) {
                return HTML_Template_Flexy::raiseError(
                    array(
                            "HTML_Template_Flexy_Tree::Syntax error in File: %s (Line %s)\n".
                            "Tokenizer Error: %s\n".
                            "Context:\n\n%s\n\n >>>>>> %s\n",
                        $this->options['filename'], $tokenizer->yyline ,
                        $tokenizer->error,
                        htmlspecialchars(substr($tokenizer->yy_buffer,0,$tokenizer->yy_buffer_end)),
                        htmlspecialchars(substr($tokenizer->yy_buffer,$tokenizer->yy_buffer_end,100))
                    )
                    ,HTML_TEMPLATE_FLEXY_ERROR_SYNTAX ,HTML_TEMPLATE_FLEXY_ERROR_DIE);
            }

            if ($t == HTML_TEMPLATE_FLEXY_TOKEN_NONE) {
                continue;
            }
            if ($t->token == 'Php') {
                continue;
            }
            $i++;
            $this->tokens[$i] = $tokenizer->value;
            $this->tokens[$i]->id = $i;



            //print_r($_HTML_TEMPLATE_FLEXY_TOKEN['tokens'][$i]);

        }
        //echo "BUILT TOKENS";
    }




    /**
    * Match the opening and closing tags eg. </B> is the closer of <B>
    *
    * aliases the ->close to the tokens[{closeid}] element
    *
    * @return   none
    * @access   public
    */

    function matchClosers()
    {
        $res = &$this->tokens;
        $total = count($this->tokens);
        // connect open  and close tags.

        // this is done by having a stack for each of the tag types..
        // then removing it when it finds the closing one
        // eg.
        //  <a href=""><img src=""></a>
        //  ends up with a stack for <a>'s and a stack for <img>'s
        //
        //
        //


        for($i=1;$i<$total;$i++) {
            //echo "Checking TAG $i\n";
            if (!isset($res[$i]->tag)) {
                continue;
            }
            $tag = strtoupper($res[$i]->tag);
            if ($tag[0] != '/') { // it's not a close tag..


                if (!isset($stack[$tag])) {
                    $npos = $stack[$tag]['pos'] = 0;
                } else {
                    $npos = ++$stack[$tag]['pos'];
                }
                $stack[$tag][$npos] = $i;
                continue;
            }

            //echo "GOT END TAG: {$res[$i]->tag}\n";
            $tag = substr($tag,1);
            if (!isset($stack[$tag]['pos'])) {
                continue; // unmatched
            }

            $npos = $stack[$tag]['pos'];
            if (!isset($stack[$tag][$npos])) {
                // stack is empty!!!
                continue;
            }
            // alias closer to opener..
            $this->tokens[$stack[$tag][$npos]]->close = &$this->tokens[$i];
            $stack[$tag]['pos']--;
            // take it off the stack so no one else uses it!!!
            unset($stack[$tag][$npos]);
            if ($stack[$tag]['pos'] < 0) {
                // too many closes - just ignore it..
                $stack[$tag]['pos'] = 0;
            }
            continue;

            // new entry on stack..



        }

        // create a dummy close for the end
        $i = $total;
        $this->tokens[$i] = new HTML_Template_Flexy_Token;
        $this->tokens[$i]->id = $total;
        $this->tokens[0]->close = &$this->tokens[$i];

        // now is it possible to connect children...
        // now we need to GLOBALIZE!! -

    }

   /**
    * Build the child array for each element.
    * RECURSIVE FUNCTION!!!!
    *
    * does not move tokens, just aliases the child nodes into the token array.
    *
    * @param   int  id of node to add children to.
    *
    * @access   public
    */
    function buildChildren($id)
    {


        $base = &$this->tokens[$id];
        $base->children = array();
        $start = $base->id +1;
        $end = $base->close->id;

        for ($i=$start; $i<$end; $i++) {
            //echo "{$base->id}:{$base->tag} ADDING {$i}{$_HTML_TEMPLATE_FLEXY_TOKEN['tokens'][$i]->tag}<BR>";
            //if ($base->id == 1176) {
            //    echo "<PRE>";print_r($_HTML_TEMPLATE_FLEXY_TOKEN['tokens'][$i]);
            // }
            $base->children[] = &$this->tokens[$i];
            if (isset($this->tokens[$i]->close)) {

                // if the close id is greater than my id - ignore it! -
                if ($this->tokens[$i]->close->id > $end) {
                    continue;
                }
                $this->buildChildren($i);
                $i = $this->tokens[$i]->close->id;
            }
        }
    }


    /**
    * Locates Flexy:startchildren etc. if it is used.
    * and returns the base of the tree. (eg. otherwise token[0].
    *
    * @return  HTML_Template_Flexy_Token (base of tree.)
    * @access   public
    */

    function returnStart() {

        foreach(array_keys($this->tokens) as $i) {
            switch(true) {
                case isset($this->tokens[$i]->ucAttributes['FLEXYSTART']):
                case isset($this->tokens[$i]->ucAttributes['FLEXY:START']):
                    $this->tokens[$i]->removeAttribute('FLEXY:START');
                    $this->tokens[$i]->removeAttribute('FLEXYSTART');
                    return $this->tokens[$i];
                case isset($this->tokens[$i]->ucAttributes['FLEXYSTARTCHILDREN']):
                case isset($this->tokens[$i]->ucAttributes['FLEXY:STARTCHILDREN']):
                    $this->tokens[0]->children = $this->tokens[$i]->children;
                    return $this->tokens[0];
            }
        }
        return $this->tokens[0];


    }

}