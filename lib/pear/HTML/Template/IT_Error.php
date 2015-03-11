<?php
//
// +----------------------------------------------------------------------+
// | Copyright (c) 1997-2005 Ulf Wendel, Pierre-Alain Joye                |
// +----------------------------------------------------------------------+
// | This source file is subject to the New BSD license, That is bundled  |
// | with this package in the file LICENSE, and is available through      |
// | the world-wide-web at                                                |
// | http://www.opensource.org/licenses/bsd-license.php                   |
// | If you did not receive a copy of the new BSD license and are unable  |
// | to obtain it through the world-wide-web, please send a note to       |
// | pajoye@php.net so we can mail you a copy immediately.                |
// +----------------------------------------------------------------------+
// | Author: Ulf Wendel <ulf.wendel@phpdoc.de>                            |
// |         Pierre-Alain Joye <pajoye@php.net>                           |
// +----------------------------------------------------------------------+

require_once "PEAR.php";

/**
* IT[X] Error class
*
* @package HTML_Template_IT
*/
class IT_Error extends PEAR_Error {


  /**
  * Prefix of all error messages.
  *
  * @var  string
  */
  var $error_message_prefix = "IntegratedTemplate Error: ";

  /**
  * Creates an cache error object.
  *
  * @param  string  error message
  * @param  string  file where the error occurred
  * @param  string  linenumber where the error occurred
  */
  function __construct($msg, $file = __FILE__, $line = __LINE__) {

    parent::__construct(sprintf("%s [%s on line %d].", $msg, $file, $line));

  } // end func IT_Error

} // end class IT_Error
?>
