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

/**
* Class that represents a text string node.
*/

class HTML_Template_Flexy_Token_Text extends HTML_Template_Flexy_Token {


    /**
    * Simple check to see if this piece of text is a word
    * so that gettext and the merging tricks dont try
    * - merge white space with a flexy tag
    * - gettext doesnt translate &nbsp; etc.
    *
    * @return   boolean  true if this is a word
    * @access   public
    */
    function isWord() {
        if (!strlen(trim($this->value))) {
            return false;
        }
        if (preg_match('/^\&[a-z0-9]+;$/i',trim($this->value))) {
            return false;
        }
        return  preg_match('/[a-z]/i',$this->value);
    }

}



