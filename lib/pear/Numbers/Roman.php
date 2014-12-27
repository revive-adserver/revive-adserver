<?php
//
// +----------------------------------------------------------------------+
// | PHP Version 4                                                        |
// +----------------------------------------------------------------------+
// | Copyright (c) 1997-2004 The PHP Group                                |
// +----------------------------------------------------------------------+
// | This source file is subject to version 2.02 of the PHP license,      |
// | that is bundled with this package in the file LICENSE, and is        |
// | available at through the world-wide-web at                           |
// | http://www.php.net/license/2_02.txt.                                 |
// | If you did not receive a copy of the PHP license and are unable to   |
// | obtain it through the world-wide-web, please send a note to          |
// | license@php.net so we can mail you a copy immediately.               |
// +----------------------------------------------------------------------+
// | Authors :  David Costa <gurugeek@php.net>                            |
// |            Sterling Hughes <sterling@php.net>                        |
// +----------------------------------------------------------------------+

// {{{ Numbers_Roman

/**
 * Provides utilities to convert roman numerals to
 * arabic numbers and convert arabic numbers to roman numerals.
 *
 * Supports lower case input and output and some furthers conversion
 * functions.
 *
 * @access public
 * @author David Costa <gurugeek@php.net>
 * @author Sterling Hughes <sterling@php.net>
 * @package Numbers_Roman
 */
class Numbers_Roman
{
    // {{{ toNumber()

    /**
     * Converts a roman numeral to a number
     *
     * @param  string  $roman The roman numeral to convert
     *                        lower cased numerals are converted into
     *                        uppercase
     * @return integer $num   The number corresponding to the
     *                        given roman numeral
     * @access public
     */
    function toNumber($roman)
    {
        $roman = strtoupper($roman);

        /*
         * Replacing the Numerals representing an integer higher then 4000
         * e.g. _X represent 10 000 _L  represent 50 000 etc
         * we first convert them into single characters
         */
        $roman = str_replace('_V', 'S', $roman);
        $roman = str_replace('_X', 'R', $roman);
        $roman = str_replace('_L', 'Q', $roman);
        $roman = str_replace('_C', 'P', $roman);
        $roman = str_replace('_D', 'O', $roman);
        $roman = str_replace('_M', 'N', $roman);

        $conv = array(
            array('letter' => 'I', 'number' => 1),
            array('letter' => 'V', 'number' => 5),
            array('letter' => 'X', 'number' => 10),
            array('letter' => 'L', 'number' => 50),
            array('letter' => 'C', 'number' => 100),
            array('letter' => 'D', 'number' => 500),
            array('letter' => 'M', 'number' => 1000),
            array('letter' => 'S', 'number' => 5000),
            array('letter' => 'R', 'number' => 10000),
            array('letter' => 'Q', 'number' => 50000),
            array('letter' => 'P', 'number' => 100000),
            array('letter' => 'O', 'number' => 500000),
            array('letter' => 'N', 'number' => 1000000),
            array('letter' => 0, 'number' => 0)
        );

        $arabic = 0;
        $state = 0;
        $sidx = 0;
        $len = strlen($roman) - 1;

        while ($len >= 0) {
            $i = 0;
            $sidx = $len;

            while ($conv[$i]['number'] > 0) {
                if (strtoupper($roman[$sidx]) == $conv[$i]['letter']) {
                    if ($state > $conv[$i]['number']) {
                        $arabic -= $conv[$i]['number'];
                    } else {
                        $arabic += $conv[$i]['number'];
                        $state = $conv[$i]['number'];
                    }
                }
                $i++;
            }
            $len--;
        }

        return $arabic;
    }

    // }}}
    // {{{ toRoman()

    /**
     * A backwards compatibility alias for toNumeral()
     *
     * @access private
     */
    function toRoman($num, $uppercase = true)
    {
        return $this->toNumeral($num, $uppercase);
    }

    // }}}
    // {{{ toNumeral()

    /**
     * Converts a number to its roman numeral representation
     *
     * @param  integer $num         An integer between 0 and 3999
     *                              inclusive that should be converted
     *                              to a roman numeral integers higher than
     *                              3999 are supported from version 0.1.2
     *           Note:
     *           For an accurate result the integer shouldn't be higher
     *           than 5 999 999. Higher integers are still converted but
     *           they do not reflect an historically correct Roman Numeral.
     *
     * @param  bool    $uppercase   Uppercase output: default true
     *
     * @param  bool    $html        Enable html overscore required for
     *                              integers over 3999. default true
     * @return string  $roman The corresponding roman numeral
     *
     * @access public
     */
    function toNumeral($num, $uppercase = true, $html = true)
    {
        $conv = array(10 => array('X', 'C', 'M'),
        5 => array('V', 'L', 'D'),
        1 => array('I', 'X', 'C'));
        $roman = '';

        if ($num < 0) {
            return '';
        }

        $num = (int) $num;

        $digit = (int) ($num / 1000);
        $num -= $digit * 1000;
        while ($digit > 0) {
            $roman .= 'M';
            $digit--;
        }

        for ($i = 2; $i >= 0; $i--) {
            $power = pow(10, $i);
            $digit = (int) ($num / $power);
            $num -= $digit * $power;

            if (($digit == 9) || ($digit == 4)) {
                $roman .= $conv[1][$i] . $conv[$digit+1][$i];
            } else {
                if ($digit >= 5) {
                    $roman .= $conv[5][$i];
                    $digit -= 5;
                }

                while ($digit > 0) {
                    $roman .= $conv[1][$i];
                    $digit--;
                }
            }
        }

        /*
         * Preparing the conversion of big integers over 3999.
         * One of the systems used by the Romans  to represent 4000 and
         * bigger numbers was to add an overscore on the numerals.
         * Because of the non ansi equivalent if the html output option
         * is true we will return the overline in the html code if false
         * we will return a _ to represent the overscore to convert from
         * numeral to arabic we will always expect the _ as a
         * representation of the html overscore.
         */
        if ($html == true) {
            $over = '<span style="text-decoration:overline;">';
            $overe = '</span>';
        } elseif ($html == false) {
            $over = '_';
            $overe = '';
        }

        /*
         * Replacing the previously produced multiple MM with the
         * relevant numeral e.g. for 1 000 000 the roman numeral is _M
         * (overscore on the M) for 900 000 is _C_M (overscore on both
         * the C and the M) We initially set the replace to AFS which
         * will be later replaced with the M.
         *
         * 500 000 is   _D (overscore D) in Roman Numeral
         * 400 000 is _C_D (overscore on both C and D) in Roman Numeral
         * 100 000 is   _C (overscore C) in Roman Numeral
         *  90 000 is _X_C (overscore on both X and C) in Roman Numeral
         *  50 000 is   _L (overscore L) in Roman Numeral
         *  40 000 is _X_L (overscore on both X and L) in Roman Numeral
         *  10 000 is   _X (overscore X) in Roman Numeral
         *   5 000 is   _V (overscore V) in Roman Numeral
         *   4 000 is M _V (overscore on the V only) in Roman Numeral
         *
         * For an accurate result the integer shouldn't be higher then
         * 5 999 999. Higher integers are still converted but they do not
         * reflect an historically correct Roman Numeral.
         */
        $roman = str_replace(str_repeat('M', 1000),
                             $over.'AFS'.$overe, $roman);
        $roman = str_replace(str_repeat('M', 900),
                             $over.'C'.$overe.$over.'AFS'.$overe, $roman);
        $roman = str_replace(str_repeat('M', 500),
                             $over.'D'.$overe, $roman);
        $roman = str_replace(str_repeat('M', 400),
                             $over.'C'.$overe.$over.'D'.$overe, $roman);
        $roman = str_replace(str_repeat('M', 100),
                             $over.'C'.$overe, $roman);
        $roman = str_replace(str_repeat('M', 90),
                             $over.'X'.$overe.$over.'C'.$overe, $roman);
        $roman = str_replace(str_repeat('M', 50),
                             $over.'L'.$overe, $roman);
        $roman = str_replace(str_repeat('M', 40),
                             $over.'X'.$overe.$over.'L'.$overe, $roman);
        $roman = str_replace(str_repeat('M', 10),
                             $over.'X'.$overe, $roman);
        $roman = str_replace(str_repeat('M', 5),
                             $over.'V'.$overe, $roman);
        $roman = str_replace(str_repeat('M', 4),
                             'M'.$over.'V'.$overe, $roman);

        /*
         * Replacing AFS with M used in both 1 000 000
         * and 900 000
         */
        $roman = str_replace('AFS', 'M', $roman);

        /*
         * Checking for lowercase output
         */
        if ($uppercase == false) {
            $roman = strtolower($roman);
        }

        return $roman;
    }

    // }}}

}

// }}}

/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * End:
 */

?>
