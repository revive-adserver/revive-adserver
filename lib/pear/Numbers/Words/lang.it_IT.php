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
// | Authors: Filippo Beltramini, Davide Caironi                          |
// +----------------------------------------------------------------------+
//
// Numbers_Words class extension to spell numbers in Italian.
//

/**
 * Class for translating numbers into Italian.
 *
 * @author Filippo Beltramini <phil@esight.it>
 * @author Davide Caironi     <cairo@esight.it>
 * @package Numbers_Words
 */

/**
 * Include needed files
 */
require_once("Numbers/Words.php");

/**
 * Class for translating numbers into Italian.
 * It supports up to quadrilions
 *
 * @author Filippo Beltramini <phil@esight.it>
 * @author Davide Caironi     <cairo@esight.it>
 * @package Numbers_Words
 */
class Numbers_Words_it_IT extends Numbers_Words
{
    // {{{ properties

    /**
     * Locale name
     * @var string
     * @access public
     */
    var $locale      = 'it_IT';
    
    /**
     * Language name in English
     * @var string
     * @access public
     */
    var $lang        = 'Italian';
    
    /**
     * Native language name
     * @var string
     * @access public
     */
    var $lang_native = 'Italiano';

    /**
     * The word for the minus sign
     * @var string
     * @access private
     */
    var $_minus = 'meno ';

    /**
     * The sufixes for exponents (singular and plural)
     * @var array
     * @access private
     */
    var $_exponent = array(
        0 => array('',''),
        3 => array('mille','mila'),
        6 => array('milione','miloni'),
       12 => array('miliardo','miliardi'),
       18 => array('trillone','trilloni'),
       24 => array('quadrilione','quadrilioni'),
        );
    /**
     * The array containing the digits (indexed by the digits themselves).
     * @var array
     * @access private
     */
     var $_digits = array(
      0 => 'zero', 'uno', 'due', 'tre', 'quattro',
       'cinque', 'sei', 'sette', 'otto', 'nove'
    );
    
    /**
     * The word separator
     * @var string
     * @access private
     */
    var $_sep = '';
    // }}}
    // {{{ toWords()
    /**
     * Converts a number to its word representation
     * in italiano.
     *
     * @param  integer $num   An integer between -infinity and infinity inclusive :)
     *                        that should be converted to a words representation
     * @param  integer $power The power of ten for the rest of the number to the right.
     *                        For example toWords(12,3) should give "doce mil".
     *                        Optional, defaults to 0.
     * @return string  The corresponding word representation
     *
     * @access private
     * @author Filippo Beltramini
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
            return(' '.$this->_digits[0].' ');
            $current_power = strlen($num);
        }
        else {
            $current_power = strlen($num);
        }

        // See if we need "thousands"
        $thousands = floor($num / 1000);
        if ($thousands == 1) {
            $ret .= $this->_sep . 'mille' . $this->_sep;
        }
        elseif ($thousands > 1) {
            $ret .= $this->toWords($thousands, 3) . $this->_sep;//. 'mil' . $this->_sep;
        }

        // values for digits, tens and hundreds
        $h = floor(($num / 100) % 10);
        $t = floor(($num / 10) % 10);
        $d = floor($num % 10);

        // centinaia: duecento, trecento, etc...
        switch ($h)
        {
            case 1:
                if (($d == 0) and ($t == 0)) { // is it's '100' use 'cien'
                    $ret .= $this->_sep . 'cento';
                }
                else {
                    $ret .= $this->_sep . 'cento';
                }
                break;
            case 2:
            case 3:
            case 4:
            case 6:
            case 8:
                $ret .= $this->_sep . $this->_digits[$h] . 'cento';
                break;
            case 5:
                $ret .= $this->_sep . 'cinquecento';
                break;
            case 7:
                $ret .= $this->_sep . 'settecento';
                break;
            case 9:
                $ret .= $this->_sep . 'novecento';
                break;
        }

        // decine: venti trenta, etc...
        switch ($t)
        {
            case 9:
                $ret .= $this->_sep . 'novanta';
                break;

            case 8:
                $ret .= $this->_sep . 'ottanta';
                break;

            case 7:
                $ret .= $this->_sep . 'settanta';
                break;

            case 6:
                $ret .= $this->_sep . 'sessanta';
                break;

            case 5:
                $ret .= $this->_sep . 'cinquanta';
                break;

            case 4:
                $ret .= $this->_sep . 'quaranta';
                break;

            case 3:
                $ret .= $this->_sep . 'trenta';
                break;

            case 2:
                if ($d == 0) {
                    $ret .= $this->_sep . 'venti';
                }
                else {
                    if (($power > 0) and ($d == 1)) {
                        $ret .= $this->_sep . 'ventuno';
                    }
                    else {
                        $ret .= $this->_sep . 'venti' . $this->_digits[$d];
                    }
                }
                break;

            case 1:
                switch ($d)
                {
                    case 0:
                        $ret .= $this->_sep . 'dieci';
                        break;

                    case 1:
                        $ret .= $this->_sep . 'undici';
                        break;

                    case 2:
                        $ret .= $this->_sep . 'dodici';
                        break;

                    case 3:
                        $ret .= $this->_sep . 'tredici';
                        break;

                    case 4:
                        $ret .= $this->_sep . 'quattordici';
                        break;

                    case 5:
                        $ret .= $this->_sep . 'quindici';
                        break;

                    case 6:
                         $ret .= $this->_sep . 'sedici';
                        break;
                        
                    case 7:
                         $ret .= $this->_sep . 'diciassette';
                        break;
                        
                    case 8:
                        $ret .= $this->_sep . 'diciotto';
                        break;
                        
                    case 9:
                     $ret .= $this->_sep . 'diciannove';
                        break;
                    }
            break;
        }

        // add digits only if it is a multiple of 10 and not 1x or 2x
        if (($t != 1) and ($t != 2) and ($d > 0))
        {
            if($t != 0) // don't add 'e' for numbers below 10
            {
                // use 'un' instead of 'uno' when there is a suffix ('mila', 'milloni', etc...)
                if(($power > 0) and ($d == 1)) {
                    $ret .= $this->_sep.' e un';
                }
                else {
                    $ret .= $this->_sep.''.$this->_digits[$d];
                }
            }
            else {
                if(($power > 0) and ($d == 1)) {
                    $ret .= $this->_sep.'un ';
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
