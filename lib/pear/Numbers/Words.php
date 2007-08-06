<?php
//
// +----------------------------------------------------------------------+
// | PHP version 4                                                        |
// +----------------------------------------------------------------------+
// | Copyright (c) 1997-2003 The PHP Group                                |
// +----------------------------------------------------------------------+
// | This source file is subject to version 3.0 of the PHP license,       |
// | that is bundled with this package in the file LICENSE, and is        |
// | available at through the world-wide-web at                           |
// | http://www.php.net/license/3_0.txt.                                  |
// | If you did not receive a copy of the PHP license and are unable to   |
// | obtain it through the world-wide-web, please send a note to          |
// | license@php.net so we can mail you a copy immediately.               |
// +----------------------------------------------------------------------+
// | Authors: Piotr Klaban <makler@man.torun.pl>                          |
// +----------------------------------------------------------------------+
//
// $Id$
//

/**
 * The Numbers_Words class provides method to convert arabic numerals to
 * words (also with currency name).
 *
 * @author Piotr Klaban <makler@man.torun.pl>
 * @package Numbers_Words
 */

// {{{ Numbers_Words

/**
 * The Numbers_Words class provides method to convert arabic numerals to words.
 *
 * @access public
 * @author Piotr Klaban <makler@man.torun.pl>
 * @since  PHP 4.2.3
 * @package Numbers_Words
 */
class Numbers_Words
{
    // {{{ toWords()

    /**
     * Converts a number to its word representation
     *
     * @param  integer $num   An integer between -infinity and infinity inclusive :)
     *                        that should be converted to a words representation
     *
     * @param  string  $locale Language name abbreviation. Optional. Defaults to en_US.
     *
     * @return string  The corresponding word representation
     *
     * @access public
     * @author Piotr Klaban <makler@man.torun.pl>
     * @since  PHP 4.2.3
     */
    function toWords($num, $locale = 'en_US') {

        include_once("Numbers/Words/lang.${locale}.php");

        $classname = "Numbers_Words_${locale}";

        if (!class_exists($classname)) {
            return Numbers_Words::raiseError("Unable to include the Numbers/Words/lang.${locale}.php file");
        }

	$methods = get_class_methods($classname);

        if (!in_array('toWords', $methods) && !in_array('towords', $methods)) {
            return Numbers_Words::raiseError("Unable to find toWords method in '$classname' class");
        }

        @$obj =& new $classname;

        return trim($obj->toWords($num));
    }
    // }}}
    // {{{ toCurrency()
    /**
     * Converts a currency value to word representation (1.02 => one dollar two cents)
     * If the number has not any fraction part, the "cents" number is omitted. 
     *
     * @param  float   $num   A float/integer/string number representing currency value
     *
     * @param  string  $locale Language name abbreviation. Optional. Defaults to en_US.
     *
     * @param  string  $int_curr International currency symbol
     *                 as defined by the ISO 4217 standard (three characters).
     *                 E.g. 'EUR', 'USD', 'PLN'. Optional.
     *                 Defaults to $def_currency defined in the language class.
     *
     * @return string  The corresponding word representation
     *
     * @access public
     * @author Piotr Klaban <makler@man.torun.pl>
     * @since  PHP 4.2.3
     */
    function toCurrency($num, $locale = 'en_US', $int_curr = '') {
	$ret = $num;

        @include_once("Numbers/Words/lang.${locale}.php");

        $classname = "Numbers_Words_${locale}";

        if (!class_exists($classname)) {
            return Numbers_Words::raiseError("Unable to include the Numbers/Words/lang.${locale}.php file");
        }

	$methods = get_class_methods($classname);

        if (!in_array('toCurrencyWords', $methods) && !in_array('tocurrencywords', $methods)) {
            return Numbers_Words::raiseError("Unable to find toCurrencyWords method in '$classname' class");
        }

        @$obj =& new $classname;

	if (strpos($num, '.') === false)
	{
	  $ret      = trim($obj->toCurrencyWords($int_curr, $num));
	} else {
	    $currency = explode('.', $num, 2);
	    /* add leading zero */
	    if (strlen($currency[1]) == 1) {
	        $currency[1] .= '0';
	    }
            $ret      = trim($obj->toCurrencyWords($int_curr, $currency[0], $currency[1]));
	}
	return $ret;
    }
    // }}}
    // {{{ raiseError()
   /**
    * Trigger a PEAR error
    *
    * To improve performances, the PEAR.php file is included dynamically.
    *
    * @param string error message
    */
    function raiseError($msg)
    {
        include_once('PEAR.php');
        return PEAR::raiseError($msg);
    }
    // }}}
}

// }}}
?>
