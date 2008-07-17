<?php
/* vim: set expandtab tabstop=4 softtabstop=4 shiftwidth=4: */
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
// | Authors: Marcelo Subtil Marcal <jason@conectiva.com.br>, Mario H.C.T. <mariolinux@mitus.com.br>
// +----------------------------------------------------------------------+
//
// $Id$
//
// Numbers_Words class extension to spell numbers in Brazilian Portuguese language.
//


/**
 * Class for translating numbers into Brazilian Portuguese.
 *
 * @author Marcelo Subtil Marcal <jason@conectiva.com.br>
 * @package Numbers_Words
 */

/**
 * Include needed files
 */
require_once "Numbers/Words.php";

/**
 * Class for translating numbers into Brazilian Portuguese.
 *
 * @author Marcelo Subtil Marcal <jason@conectiva.com.br>
 * @package Numbers_Words
 */
class Numbers_Words_pt_BR extends Numbers_Words
{

    /**
     * Locale name
     * @var string
     * @access public
     */
    var $locale      = 'pt_BR';

    /**
     * Language name in English
     * @var string
     * @access public
     */
    var $lang        = 'Brazilian Portuguese';

    /**
     * Native language name
     * @var string
     * @access public
     */
    var $lang_native = 'Português Brasileiro';

    /**
     * The word for the minus sign
     * @var string
     * @access private
     */
    var $_minus = 'menos';

    /**
     * The word separator
     * @var string
     * @access private
     */
    var $_sep = ' ';

    /**
     * The array containing the digits (indexed by the digits themselves).
     * @var array
     * @access private
     */
    var $_unidade = array(
        '',
        'um',
        'dois',
        'três',
        'quatro',
        'cinco',
        'seis',
        'sete',
        'oito',
        'nove'
    );

    /**
     * The array containing numbers 10-19.
     * @var array
     * @access private
     */
    var $_dezena10 = array(
        'dez',
        'onze',
        'doze',
        'treze',
        'quatorze',
        'quinze',
        'dezesseis',
        'dezessete',
        'dezoito',
        'dezenove'
    );

    /**
     * The array containing numbers for 10,20,...,90.
     * @var array
     * @access private
     */
    var $_dezena = array(
        '',
        'dez',
        'vinte',
        'trinta',
        'quarenta',
        'cinquenta',
        'sessenta',
        'setenta',
        'oitenta',
        'noventa'
    );

    /**
     * The array containing numbers for hundrets.
     * @var array
     * @access private
     */
    var $_centena = array(
        '',
        'cem',
        'duzentos',
        'trezentos',
        'quatrocentos',
        'quinhentos',
        'seiscentos',
        'setecentos',
        'oitocentos',
        'novecentos'
    );

    /**
     * The sufixes for exponents (singular and plural)
     * @var array
     * @access private
     */
    var $_expoente = array(
        '',
        'mil',
        'milhão',
        'bilhão',
        'trilhão',
        'quatrilhão',
        'quintilhão',
        'sextilhão',
        'setilhão',
        'octilhão',
        'nonilhão',
        'decilhão',
        'undecilhão',
        'dodecilhão',
        'tredecilhão',
        'quatuordecilhão',
        'quindecilhão',
        'sedecilhão',
        'septendecilhão'
    );

    /**
     * The currency names (based on the below links,
     * informations from central bank websites and on encyclopedias)
     *
     * @var array
     * @link http://30-03-67.dreamstation.com/currency_alfa.htm World Currency Information
     * @link http://www.jhall.demon.co.uk/currency/by_abbrev.html World currencies
     * @link http://www.shoestring.co.kr/world/p.visa/change.htm Currency names in English
     * @access private
     */
    var $_currency_names = array(
        'BRL' => array(array('rea'), array('centavo')) );

    /**
     * The default currency name
     * @var string
     * @access public
     */
    var $def_currency = 'BRL'; // Real

    // {{{ toWords()

    /**
     * Converts a number to its word representation
     * in Brazilian Portuguese language
     *
     * @param  integer $num   An integer between -infinity and infinity inclusive :)
     *                        that need to be converted to words
     *
     * @return string  The corresponding word representation
     *
     * @access public
     * @author Marcelo Subtil Marcal <jason@conectiva.com.br>
     * @since  PHP 4.2.3
     */
    function toWords($num) {

        $ret = '';

        $num = trim($num);

        if (substr($num, 0, 1) == '-') {
            $ret = $this->_sep . $this->_minus;
            $num = substr($num, 1);
        }

        // strip excessive zero signs and spaces
        $num = trim($num);
        $num = preg_replace('/^0+/','',$num);

        while (strlen($num) % 3 != 0) {
            $num = "0" . $num;
        }

        $num = ereg_replace("(...)", "\\1.", $num);
        $num = ereg_replace("\.$", "", $num);

        $inteiro = explode(".", $num);

        for ($i = 0; $i < count($inteiro); $i++) {
            $ret .= (($inteiro[$i] > 100) && ($inteiro[$i] < 200)) ? "cento" : $this->_centena[$inteiro[$i][0]];
            $ret .= ($inteiro[$i][0] && ($inteiro[$i][1] || $inteiro[$i][2])) ? " e " : "";
            $ret .= ($inteiro[$i][1] < 2) ? "" : $this->_dezena[$inteiro[$i][1]];
            $ret .= (($inteiro[$i][1] > 1) && ($inteiro[$i][2])) ? " e " : "";
            $ret .= ($inteiro > 0) ? ( ($inteiro[$i][1] == 1) ? $this->_dezena10[$inteiro[$i][2]] : $this->_unidade[$inteiro[$i][2]] ) : "";
            $ret .= $inteiro[$i] > 0 ? " " . ($inteiro[$i] > 1 ? str_replace("ão", "ões", $this->_expoente[count($inteiro)-1-$i]) : $this->_expoente[count($inteiro)-1-$i]) : "";

            if ($ret && (isset($inteiro[$i+1]))) {
                if ($inteiro[$i+1] != "000") {
                    $ret .= ($i+1) == (count($inteiro)-1) ? " e " : ", ";
                }
            }

        }

        return $ret ? " $ret" : " zero";

    }

    // }}}
    // {{{ toCurrencyWords()

    /**
     * Converts a currency value to its word representation
     * (with monetary units) in Portuguese language
     *
     * @param  integer $int_curr An international currency symbol
     *                 as defined by the ISO 4217 standard (three characters)
     * @param  integer $decimal A money total amount without fraction part (e.g. amount of dollars)
     * @param  integer $fraction Fractional part of the money amount (e.g.  amount of cents)
     *                 Optional. Defaults to false. 
     *
     * @return string  The corresponding word representation for the currency
     *
     * @access public
     * @author Mario H.C.T. <mariolinux@mitus.com.br>
     * @since  Numbers_Words 0.10.1
     */
    function toCurrencyWords($int_curr, $decimal, $fraction = false) {
        $int_curr = strtoupper($int_curr);
        if (!isset($this->_currency_name[$int_curr])){
            $int_curr = $this->def_currency;
        }
        $curr_names = $this->_currency_names[$int_curr];
        $ret  = trim($this->toWords($decimal));
        $lev  = ($decimal == 1) ? 0 : 1;
        if ($lev > 0) {
            if (count($curr_names[0]) > 1) {
                $ret .= $this->_sep . $curr_names[0][$lev];
            } else {
                if ($int_curr == "BRL")
                    $ret .= $this->_sep . $curr_names[0][0] . 'is';
                else
                    $ret .= $this->_sep . $curr_names[0][0] . 's';
            }
        } else {
            if ($int_curr == "BRL")
                $ret .= $this->_sep . $curr_names[0][0] . 'l';
            else
                $ret .= $this->_sep . $curr_names[0][0];
        }
                  
        if ($fraction !== false) {
            if ($int_curr == "BRL")
                $ret .= $this->_sep . 'e';
               
            $ret .= $this->_sep . trim($this->toWords($fraction));
            $lev  = ($fraction == 1) ? 0 : 1;
            if ($lev > 0) {
                if (count($curr_names[1]) > 1) {
                    $ret .= $this->_sep . $curr_names[1][$lev];
                } else {
                    $ret .= $this->_sep . $curr_names[1][0] . 's';
                }
            } else {
                $ret .= $this->_sep . $curr_names[1][0];
            }
       }

       return $ret;
    }
    // }}}
}

?>
