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
// $Id: EndTag.php,v 1.2 2003/12/10 02:36:26 alan_k Exp $
//
 
/**
* The closing HTML Tag = eg. /Table or /Body etc.
*
* @abstract 
* This just extends the generic HTML tag 
*
*/

require_once 'HTML/Template/Flexy/Token/Tag.php';


class HTML_Template_Flexy_Token_EndTag extends HTML_Template_Flexy_Token_Tag { }

  