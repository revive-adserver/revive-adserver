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
// | Authors: Piotr Klaban <makler@man.torun.pl>                          |
// +----------------------------------------------------------------------+
//
// $Id$
//
// Numbers_Words class extension to spell numbers in American English language.
//

/**
 * Class for translating numbers into American English.
 *
 * @author Piotr Klaban
 * @package Numbers_Words
 */

/**
 * Include needed files
 */
require_once("Numbers/Words.php");

/**
 * Class for translating numbers into American English.
 *
 * @author Piotr Klaban
 * @package Numbers_Words
 */
class Numbers_Words_en_US extends Numbers_Words
{

    // {{{ properties
    
    /**
     * Locale name
     * @var string
     * @access public
     */
    var $locale      = 'en_US';

    /**
     * Language name in English
     * @var string
     * @access public
     */
    var $lang        = 'American English';

    /**
     * Native language name
     * @var string
     * @access public
     */
    var $lang_native = 'American English';
    
    /**
     * The word for the minus sign
     * @var string
     * @access private
     */
    var $_minus = 'minus'; // minus sign
    
    /**
     * The sufixes for exponents (singular and plural)
     * Names partly based on:
     * http://home.earthlink.net/~mrob/pub/math/largenum.html
     * http://mathforum.org/dr.math/faq/faq.large.numbers.html
     * http://www.mazes.com/AmericanNumberingSystem.html
     * @var array
     * @access private
     */
    var $_exponent = array(
        0 => array(''),
        3 => array('thousand'),
        6 => array('million'),
        9 => array('billion'),
       12 => array('trillion'),
       15 => array('quadrillion'),
       18 => array('quintillion'),
       21 => array('sextillion'),
       24 => array('septillion'),
       27 => array('octillion'),
       30 => array('nonillion'),
       33 => array('decillion'),
       36 => array('undecillion'),
       39 => array('duodecillion'),
       42 => array('tredecillion'),
       45 => array('quattuordecillion'),
       48 => array('quindecillion'),
       51 => array('sexdecillion'),
       54 => array('septendecillion'),
       57 => array('octodecillion'),
       60 => array('novemdecillion'),
       63 => array('vigintillion'),
       66 => array('unvigintillion'),
       69 => array('duovigintillion'),
       72 => array('trevigintillion'),
       75 => array('quattuorvigintillion'),
       78 => array('quinvigintillion'),
       81 => array('sexvigintillion'),
       84 => array('septenvigintillion'),
       87 => array('octovigintillion'),
       90 => array('novemvigintillion'),
       93 => array('trigintillion'),
       96 => array('untrigintillion'),
       99 => array('duotrigintillion'),
       // 100 => array('googol') - not latin name
       // 10^googol = 1 googolplex
      102 => array('trestrigintillion'),
      105 => array('quattuortrigintillion'),
      108 => array('quintrigintillion'),
      111 => array('sextrigintillion'),
      114 => array('septentrigintillion'),
      117 => array('octotrigintillion'),
      120 => array('novemtrigintillion'),
      123 => array('quadragintillion'),
      126 => array('unquadragintillion'),
      129 => array('duoquadragintillion'),
      132 => array('trequadragintillion'),
      135 => array('quattuorquadragintillion'),
      138 => array('quinquadragintillion'),
      141 => array('sexquadragintillion'),
      144 => array('septenquadragintillion'),
      147 => array('octoquadragintillion'),
      150 => array('novemquadragintillion'),
      153 => array('quinquagintillion'),
      156 => array('unquinquagintillion'),
      159 => array('duoquinquagintillion'),
      162 => array('trequinquagintillion'),
      165 => array('quattuorquinquagintillion'),
      168 => array('quinquinquagintillion'),
      171 => array('sexquinquagintillion'),
      174 => array('septenquinquagintillion'),
      177 => array('octoquinquagintillion'),
      180 => array('novemquinquagintillion'),
      183 => array('sexagintillion'),
      186 => array('unsexagintillion'),
      189 => array('duosexagintillion'),
      192 => array('tresexagintillion'),
      195 => array('quattuorsexagintillion'),
      198 => array('quinsexagintillion'),
      201 => array('sexsexagintillion'),
      204 => array('septensexagintillion'),
      207 => array('octosexagintillion'),
      210 => array('novemsexagintillion'),
      213 => array('septuagintillion'),
      216 => array('unseptuagintillion'),
      219 => array('duoseptuagintillion'),
      222 => array('treseptuagintillion'),
      225 => array('quattuorseptuagintillion'),
      228 => array('quinseptuagintillion'),
      231 => array('sexseptuagintillion'),
      234 => array('septenseptuagintillion'),
      237 => array('octoseptuagintillion'),
      240 => array('novemseptuagintillion'),
      243 => array('octogintillion'),
      246 => array('unoctogintillion'),
      249 => array('duooctogintillion'),
      252 => array('treoctogintillion'),
      255 => array('quattuoroctogintillion'),
      258 => array('quinoctogintillion'),
      261 => array('sexoctogintillion'),
      264 => array('septoctogintillion'),
      267 => array('octooctogintillion'),
      270 => array('novemoctogintillion'),
      273 => array('nonagintillion'),
      276 => array('unnonagintillion'),
      279 => array('duononagintillion'),
      282 => array('trenonagintillion'),
      285 => array('quattuornonagintillion'),
      288 => array('quinnonagintillion'),
      291 => array('sexnonagintillion'),
      294 => array('septennonagintillion'),
      297 => array('octononagintillion'),
      300 => array('novemnonagintillion'),
      303 => array('centillion'),
      309 => array('duocentillion'),
      312 => array('trecentillion'),
      366 => array('primo-vigesimo-centillion'),
      402 => array('trestrigintacentillion'),
      603 => array('ducentillion'),
      624 => array('septenducentillion'),
     // bug on a earthlink page: 903 => array('trecentillion'),
     2421 => array('sexoctingentillion'),
     3003 => array('millillion'),
     3000003 => array('milli-millillion')
        );

    /**
     * The array containing the digits (indexed by the digits themselves).
     * @var array
     * @access private
     */
    var $_digits = array(
        0 => 'zero', 'one', 'two', 'three', 'four',
        'five', 'six', 'seven', 'eight', 'nine'
    );

    /**
     * The word separator
     * @var string
     * @access private
     */
    var $_sep = ' ';

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
      'ALL' => array(array('lek'), array('qindarka')),
      'AUD' => array(array('Australian dollar'), array('cent')),
      'BAM' => array(array('convertible marka'), array('fenig')),
      'BGN' => array(array('lev'), array('stotinka')),
      'BRL' => array(array('real'), array('centavos')),
      'BYR' => array(array('Belarussian rouble'), array('kopiejka')),
      'CAD' => array(array('Canadian dollar'), array('cent')),
      'CHF' => array(array('Swiss franc'), array('rapp')),
      'CYP' => array(array('Cypriot pound'), array('cent')),
      'CZK' => array(array('Czech koruna'), array('halerz')),
      'DKK' => array(array('Danish krone'), array('ore')),
      'EEK' => array(array('kroon'), array('senti')),
      'EUR' => array(array('euro'), array('euro-cent')),
      'GBP' => array(array('pound', 'pounds'), array('pence')),
      'HKD' => array(array('Hong Kong dollar'), array('cent')),
      'HRK' => array(array('Croatian kuna'), array('lipa')),
      'HUF' => array(array('forint'), array('filler')),
      'ILS' => array(array('new sheqel','new sheqels'), array('agora','agorot')),
      'ISK' => array(array('Icelandic króna'), array('aurar')),
      'JPY' => array(array('yen'), array('sen')),
      'LTL' => array(array('litas'), array('cent')),
      'LVL' => array(array('lat'), array('sentim')),
      'MKD' => array(array('Macedonian dinar'), array('deni')),
      'MTL' => array(array('Maltese lira'), array('centym')),
      'NOK' => array(array('Norwegian krone'), array('oere')),
      'PLN' => array(array('zloty', 'zlotys'), array('grosz')),
      'ROL' => array(array('Romanian leu'), array('bani')),
      'RUB' => array(array('Russian Federation rouble'), array('kopiejka')),
      'SEK' => array(array('Swedish krona'), array('oere')),
      'SIT' => array(array('Tolar'), array('stotinia')),
      'SKK' => array(array('Slovak koruna'), array()),
      'TRL' => array(array('lira'), array('kuruþ')),
      'UAH' => array(array('hryvna'), array('cent')),
      'USD' => array(array('dollar'), array('cent')),
      'YUM' => array(array('dinars'), array('para')),
      'ZAR' => array(array('rand'), array('cent'))
    );

    /**
     * The default currency name
     * @var string
     * @access public
     */
    var $def_currency = 'USD'; // Polish zloty

    // }}}
    // {{{ toWords()

    /**
     * Converts a number to its word representation
     * in American English language
     *
     * @param  integer $num   An integer between -infinity and infinity inclusive :)
     *                        that need to be converted to words
     * @param  integer $power The power of ten for the rest of the number to the right.
     *                        Optional, defaults to 0.
     * @param  integer $powsuffix The power name to be added to the end of the return string.
     *                        Used internally. Optional, defaults to ''.
     *
     * @return string  The corresponding word representation
     *
     * @access public
     * @author Piotr Klaban <makler@man.torun.pl>
     * @since  PHP 4.2.3
     */
    function toWords($num, $power = 0, $powsuffix = '') {
      $ret = '';        
      
      // add a minus sign
      if (substr($num, 0, 1) == '-') {
        $ret = $this->_sep . $this->_minus;
        $num = substr($num, 1);
      }
        
      // strip excessive zero signs and spaces
      $num = trim($num);
      $num = preg_replace('/^0+/','',$num);
        
      if (strlen($num) > 3) {
          $maxp = strlen($num)-1;
          $curp = $maxp;
          for ($p = $maxp; $p > 0; --$p) { // power
            
            // check for highest power
            if (isset($this->_exponent[$p])) {
              // send substr from $curp to $p
              $snum = substr($num, $maxp - $curp, $curp - $p + 1);
              $snum = preg_replace('/^0+/','',$snum);
              if ($snum !== '') {
                  $cursuffix = $this->_exponent[$power][count($this->_exponent[$power])-1];
                  if ($powsuffix != '')
                    $cursuffix .= $this->_sep . $powsuffix;
                  $ret .= $this->toWords($snum, $p, $cursuffix);
              }
              $curp = $p - 1;
              continue;
            }
          }
          $num = substr($num, $maxp - $curp, $curp - $p + 1);
          if ($num == 0) {
              return $ret;
          }
      } elseif ($num == 0 || $num == '') {
        return $this->_sep . $this->_digits[0];
      }
    
      $h = $t = $d = 0;
      
      switch(strlen($num)) {
        case 3:
          $h = (int)substr($num,-3,1);

        case 2:
          $t = (int)substr($num,-2,1);

        case 1:
          $d = (int)substr($num,-1,1);
          break;

        case 0:
          return;
          break;
      }
    
      if ($h) {
        $ret .= $this->_sep . $this->_digits[$h] . $this->_sep . 'hundred';

        // in English only - add ' and' for [1-9]01..[1-9]99
        // (also for 1001..1099, 10001..10099 but it is harder)
        // for now it is switched off, maybe some language purists
        // can force me to enable it, or to remove it completely
        // if (($t + $d) > 0)
        //   $ret .= $this->_sep . 'and';
      }

      // ten, twenty etc.
      switch ($t) {
      case 9:
      case 7:
      case 6:
          $ret .= $this->_sep . $this->_digits[$t] . 'ty';
          break;
    
      case 8:
          $ret .= $this->_sep . 'eighty';
          break;
    
      case 5:
          $ret .= $this->_sep . 'fifty';
          break;
    
      case 4:
          $ret .= $this->_sep . 'forty';
          break;
    
      case 3:
          $ret .= $this->_sep . 'thirty';
          break;
    
      case 2:
          $ret .= $this->_sep . 'twenty';
          break;
    
      case 1:
          switch ($d) {
          case 0:
              $ret .= $this->_sep . 'ten';
              break;
    
          case 1:
              $ret .= $this->_sep . 'eleven';
              break;
    
          case 2:
              $ret .= $this->_sep . 'twelve';
              break;
    
          case 3:
              $ret .= $this->_sep . 'thirteen';
              break;
    
          case 4:
          case 6:
          case 7:
          case 9:
              $ret .= $this->_sep . $this->_digits[$d] . 'teen';
              break;
    
          case 5:
              $ret .= $this->_sep . 'fifteen';
              break;
    
          case 8:
              $ret .= $this->_sep . 'eighteen';
              break;
          }
          break; 
      }

      if ($t != 1 && $d > 0) { // add digits only in <0>,<1,9> and <21,inf>
        // add minus sign between [2-9] and digit
        if ($t > 1) {
          $ret .= '-' . $this->_digits[$d];
        } else {
          $ret .= $this->_sep . $this->_digits[$d];
        }
      }
  
      if ($power > 0) {
        if (isset($this->_exponent[$power]))
          $lev = $this->_exponent[$power];
    
        if (!isset($lev) || !is_array($lev))
          return null;
     
        $ret .= $this->_sep . $lev[0];
      }
    
      if ($powsuffix != '')
        $ret .= $this->_sep . $powsuffix;
    
      return $ret;
    }
    // }}}
    // {{{ toCurrency()

    /**
     * Converts a currency value to its word representation
     * (with monetary units) in English language
     *
     * @param  integer $int_curr An international currency symbol
     *                 as defined by the ISO 4217 standard (three characters)
     * @param  integer $decimal A money total amount without fraction part (e.g. amount of dollars)
     * @param  integer $fraction Fractional part of the money amount (e.g. amount of cents)
     *                 Optional. Defaults to false.
     *
     * @return string  The corresponding word representation for the currency
     *
     * @access public
     * @author Piotr Klaban <makler@man.torun.pl>
     * @since  Numbers_Words 0.4
     */
    function toCurrencyWords($int_curr, $decimal, $fraction = false) {
        $int_curr = strtoupper($int_curr);
        if (!isset($this->_currency_names[$int_curr])) {
            $int_curr = $this->def_currency;
        }
        $curr_names = $this->_currency_names[$int_curr];
        $ret  = trim($this->toWords($decimal));
        $lev  = ($decimal == 1) ? 0 : 1;
        if ($lev > 0) {
            if (count($curr_names[0]) > 1) {
                $ret .= $this->_sep . $curr_names[0][$lev];
            } else {
                $ret .= $this->_sep . $curr_names[0][0] . 's';
            }
        } else {
            $ret .= $this->_sep . $curr_names[0][0];
        }
      
        if ($fraction !== false) {
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
