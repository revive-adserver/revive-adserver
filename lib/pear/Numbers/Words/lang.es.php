<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
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
// | Authors: Xavier Noguer                                               |
// +----------------------------------------------------------------------+
//
// Numbers_Words class extension to spell numbers in Spanish (Castellano).
//

/**
 * Class for translating numbers into Spanish (Castellano).
 *
 * @author Xavier Noguer
 * @package Numbers_Words
 */

/**
 * Include needed files
 */
require_once("Numbers/Words.php");

/**
 * Class for translating numbers into Spanish (Castellano).
 * It supports up to decallones (10^6).
 * It doesn't support spanish tonic accents (acentos).
 *
 * @author Xavier Noguer
 * @package Numbers_Words
 */
class Numbers_Words_es extends Numbers_Words
{
    // {{{ properties

    /**
     * Locale name
     * @var string
     * @access public
     */
    var $locale      = 'es';
    
    /**
     * Language name in English
     * @var string
     * @access public
     */
    var $lang        = 'Spanish';
    
    /**
     * Native language name
     * @var string
     * @access public
     */
    var $lang_native = 'Español';

    /**
     * The word for the minus sign
     * @var string
     * @access private
     */
    var $_minus = 'menos';

    /**
     * The sufixes for exponents (singular and plural)
     * @var array
     * @access private
     */
    var $_exponent = array(
        0 => array('',''),
        3 => array('mil','mil'),
        6 => array('millón','millones'),
       12 => array('billón','billones'),
       18 => array('trilón','trillones'),
       24 => array('cuatrillón','cuatrillones'),
       30 => array('quintillón','quintillones'),
       36 => array('sextillón','sextillones'),
       42 => array('septillón','septillones'),
       48 => array('octallón','octallones'),
       54 => array('nonallón','nonallones'),
       60 => array('decallón','decallones'),
        );
    /**
     * The array containing the digits (indexed by the digits themselves).
     * @var array
     * @access private
     */
    var $_digits = array(
        0 => 'cero', 'uno', 'dos', 'tres', 'cuatro',
        'cinco', 'seis', 'siete', 'ocho', 'nueve'
        );
    /**
     * The word separator
     * @var string
     * @access private
     */
    var $_sep = ' ';
    // }}}
    // {{{ toWords()
    /**
     * Converts a number to its word representation
     * in Spanish (Castellano).
     *
     * @param  integer $num   An integer between -infinity and infinity inclusive :)
     *                        that should be converted to a words representation
     * @param  integer $power The power of ten for the rest of the number to the right.
     *                        For example toWords(12,3) should give "doce mil".
     *                        Optional, defaults to 0.
     * @return string  The corresponding word representation
     *
     * @access private
     * @author Xavier Noguer
     * @since  PHP 4.2.3
     */
    function toWords($num, $power = 0)
    {
        // The return string;
        $ret = '';

        // add a the word for the minus sign if necessary
        if (substr($num, 0, 1) == '-')
        {
            $ret = $this->_sep . $this->_minus;
            $num = substr($num, 1);
        }


        // strip excessive zero signs
        $num = preg_replace('/^0+/','',$num);

        if (strlen($num) > 6)
        {
            $current_power = 6;
            // check for highest power
            if (isset($this->_exponent[$power]))
            {
                // convert the number above the first 6 digits
                // with it's corresponding $power.
                $snum = substr($num, 0, -6);
                $snum = preg_replace('/^0+/','',$snum);
                if ($snum !== '') {
                    $ret .= $this->toWords($snum, $power + 6);
                }
            }
            $num = substr($num, -6);
            if ($num == 0) {
                return $ret;
            }
        }
        elseif ($num == 0 || $num == '') {
            return(' '.$this->_digits[0]);
            $current_power = strlen($num);
        }
        else {
            $current_power = strlen($num);
        }

        // See if we need "thousands"
        $thousands = floor($num / 1000);
        if ($thousands == 1) {
            $ret .= $this->_sep . 'mil';
        }
        elseif ($thousands > 1) {
            $ret .= $this->toWords($thousands, 3);
        }

        // values for digits, tens and hundreds
        $h = floor(($num / 100) % 10);
        $t = floor(($num / 10) % 10);
        $d = floor($num % 10);

        // cientos: doscientos, trescientos, etc...
        switch ($h)
        {
            case 1:
                if (($d == 0) and ($t == 0)) { // is it's '100' use 'cien'
                    $ret .= $this->_sep . 'cien';
                }
                else {
                    $ret .= $this->_sep . 'ciento';
                }
                break;
            case 2:
            case 3:
            case 4:
            case 6:
            case 8:
                $ret .= $this->_sep . $this->_digits[$h] . 'cientos';
                break;
            case 5:
                $ret .= $this->_sep . 'quinientos';
                break;
            case 7:
                $ret .= $this->_sep . 'setecientos';
                break;
            case 9:
                $ret .= $this->_sep . 'novecientos';
                break;
        }

        // decenas: veinte, treinta, etc...
        switch ($t)
        {
            case 9:
                $ret .= $this->_sep . 'noventa';
                break;

            case 8:
                $ret .= $this->_sep . 'ochenta';
                break;

            case 7:
                $ret .= $this->_sep . 'setenta';
                break;

            case 6:
                $ret .= $this->_sep . 'sesenta';
                break;

            case 5:
                $ret .= $this->_sep . 'cincuenta';
                break;

            case 4:
                $ret .= $this->_sep . 'cuarenta';
                break;

            case 3:
                $ret .= $this->_sep . 'treinta';
                break;

            case 2:
                if ($d == 0) {
                    $ret .= $this->_sep . 'veinte';
                }
                else {
                    if (($power > 0) and ($d == 1)) {
                        $ret .= $this->_sep . 'veintiún';
                    }
                    else {
                        $ret .= $this->_sep . 'veinti' . $this->_digits[$d];
                    }
                }
                break;

            case 1:
                switch ($d)
                {
                    case 0:
                        $ret .= $this->_sep . 'diez';
                        break;

                    case 1:
                        $ret .= $this->_sep . 'once';
                        break;

                    case 2:
                        $ret .= $this->_sep . 'doce';
                        break;

                    case 3:
                        $ret .= $this->_sep . 'trece';
                        break;

                    case 4:
                        $ret .= $this->_sep . 'catorce';
                        break;

                    case 5:
                        $ret .= $this->_sep . 'quince';
                        break;

                    case 6:
                    case 7:
                    case 9:
                    case 8:
                        $ret .= $this->_sep . 'dieci' . $this->_digits[$d];
                        break;
                }
            break;
        }

        // add digits only if it is a multiple of 10 and not 1x or 2x
        if (($t != 1) and ($t != 2) and ($d > 0))
        {
            if($t != 0) // don't add 'y' for numbers below 10
            {
                // use 'un' instead of 'uno' when there is a suffix ('mil', 'millones', etc...)
                if(($power > 0) and ($d == 1)) {
                    $ret .= $this->_sep.' y un';
                }
                else {
                    $ret .= $this->_sep.'y '.$this->_digits[$d];
                }
            }
            else {
                if(($power > 0) and ($d == 1)) {
                    $ret .= $this->_sep.'un';
                }
                else {
                    $ret .= $this->_sep.$this->_digits[$d];
                }
            }
        }

        if ($power > 0)
        {
            if (isset($this->_exponent[$power])) {
                $lev = $this->_exponent[$power];
            }

            if (!isset($lev) || !is_array($lev)) {
                return null;
            }

            // if it's only one use the singular suffix
            if (($d == 1) and ($t == 0) and ($h == 0)) {
                $suffix = $lev[0];
            }
            else {
                $suffix = $lev[1];
            }
            if ($num != 0)  {
                $ret .= $this->_sep . $suffix;
            }
        }

        return $ret;
    }
    // }}}
}
?>
