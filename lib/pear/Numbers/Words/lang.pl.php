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
// Numbers_Words class extension to spell numbers in Polish.
//

/**
 * Class for translating numbers into Polish.
 *
 * @author Piotr Klaban
 * @package Numbers_Words
 */

/**
 * Include needed files
 */
require_once("Numbers/Words.php");

/**
 * Class for translating numbers into Polish.
 *
 * @author Piotr Klaban
 * @package Numbers_Words
 */
class Numbers_Words_pl extends Numbers_Words
{

    // {{{ properties
    
    /**
     * Locale name
     * @var string
     * @access public
     */
    var $locale      = 'pl';

    /**
     * Language name in English
     * @var string
     * @access public
     */
    var $lang        = 'Polish';

    /**
     * Native language name
     * @var string
     * @access public
     */
    var $lang_native = 'polski';

    /**
     * The word for the minus sign
     * @var string
     * @access private
     */
    var $_minus = 'minus'; // minus sign
    
    /**
     * The sufixes for exponents (singular and plural)
     * Names based on:
     * mathematical tables, my memory, and also:
     * http://ux1.math.us.edu.pl/~szyjewski/FAQ/liczby/iony.htm
     * @var array
     * @access private
     */
    var $_exponent = array(
       // potêga dziesi±tki => liczba pojedyncza, podwójna, mnoga
        0 => array('','',''),
        3 => array('tysi±c','tysi±ce','tysiêcy'),
        6 => array('milion','miliony','milionów'),
        9 => array('miliard','miliardy','miliardów'),
       12 => array('bilion','biliony','bilionów'),
       15 => array('biliard','biliardy','biliardów'),
       18 => array('trylion','tryliony','trylionów'),
       21 => array('tryliard','tryliardy','tryliardów'),
       24 => array('kwadrylion','kwadryliony','kwadrylionów'),
       27 => array('kwadryliard','kwadryliardy','kwadryliardów'),
       30 => array('kwintylion','kwintyliony','kwintylionów'),
       33 => array('kwintyliiard','kwintyliardy','kwintyliardów'),
       36 => array('sekstylion','sekstyliony','sekstylionów'),
       39 => array('sekstyliard','sekstyliardy','sekstyliardów'),
       42 => array('septylion','septyliony','septylionów'),
       45 => array('septyliard','septyliardy','septyliardów'),
       48 => array('oktylion','oktyliony','oktylionów'),
       51 => array('oktyliard','oktyliardy','oktyliardów'),
       54 => array('nonylion','nonyliony','nonylionów'),
       57 => array('nonyliard','nonyliardy','nonyliardów'),
       60 => array('decylion','decyliony','decylionów'),
       63 => array('decyliard','decyliardy','decyliardów'),
      100 => array('centylion','centyliony','centylionów'),
      103 => array('centyliard','centyliardy','centyliardów'),
      120 => array('wicylion','wicylion','wicylion'),
      123 => array('wicyliard','wicyliardy','wicyliardów'),
      180 => array('trycylion','trycylion','trycylion'),
      183 => array('trycyliard','trycyliardy','trycyliardów'),
      240 => array('kwadragilion','kwadragilion','kwadragilion'),
      243 => array('kwadragiliard','kwadragiliardy','kwadragiliardów'),
      300 => array('kwinkwagilion','kwinkwagilion','kwinkwagilion'),
      303 => array('kwinkwagiliard','kwinkwagiliardy','kwinkwagiliardów'),
      360 => array('seskwilion','seskwilion','seskwilion'),
      363 => array('seskwiliard','seskwiliardy','seskwiliardów'),
      420 => array('septagilion','septagilion','septagilion'),
      423 => array('septagiliard','septagiliardy','septagiliardów'),
      480 => array('oktogilion','oktogilion','oktogilion'),
      483 => array('oktogiliard','oktogiliardy','oktogiliardów'),
      540 => array('nonagilion','nonagilion','nonagilion'),
      543 => array('nonagiliard','nonagiliardy','nonagiliardów'),
      600 => array('centylion','centyliony','centylionów'),
      603 => array('centyliard','centyliardy','centyliardów'),
  6000018 => array('milinilitrylion','milinilitryliony','milinilitrylionów')
        );

    /**
     * The array containing the digits (indexed by the digits themselves).
     * @var array
     * @access private
     */
    var $_digits = array(
        0 => 'zero', 'jeden', 'dwa', 'trzy', 'cztery',
        'piêæ', 'sze¶æ', 'siedem', 'osiem', 'dziewiêæ'
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
     * @link http://www.xe.com/iso4217.htm Currency codes
     * @link http://www.republika.pl/geographia/peuropy.htm Europe review
     * @link http://pieniadz.hoga.pl/waluty_objasnienia.asp Currency service
     * @access private
     */
    var $_currency_names = array(
      'ALL' => array(array('lek','leki','leków'), array('quindarka','quindarki','quindarek')),
      'AUD' => array(array('dolar australijski', 'dolary australijskie', 'dolarów australijskich'), array('cent', 'centy', 'centów')),
      'BAM' => array(array('marka','marki','marek'), array('fenig','fenigi','fenigów')),
      'BGN' => array(array('lew','lewy','lew'), array('stotinka','stotinki','stotinek')),
      'BRL' => array(array('real','reale','realów'), array('centavos','centavos','centavos')),
      'BYR' => array(array('rubel','ruble','rubli'), array('kopiejka','kopiejki','kopiejek')),
      'CAD' => array(array('dolar kanadyjski', 'dolary kanadyjskie', 'dolarów kanadyjskich'), array('cent', 'centy', 'centów')),
      'CHF' => array(array('frank szwajcarski','franki szwajcarskie','franków szwajcarskich'), array('rapp','rappy','rappów')),
      'CYP' => array(array('funt cypryjski','funty cypryjskie','funtów cypryjskich'), array('cent', 'centy', 'centów')),
      'CZK' => array(array('korona czeska','korony czeskie','koron czeskich'), array('halerz','halerze','halerzy')),
      'DKK' => array(array('korona duñska','korony duñskie','koron duñskich'), array('ore','ore','ore')),
      'EEK' => array(array('korona estoñska','korony estoñskie','koron estoñskich'), array('senti','senti','senti')),
      'EUR' => array(array('euro', 'euro', 'euro'), array('eurocent', 'eurocenty', 'eurocentów')),
      'GBP' => array(array('funt szterling','funty szterlingi','funtów szterlingów'), array('pens','pensy','pensów')),
      'HKD' => array(array('dolar Hongkongu','dolary Hongkongu','dolarów Hongkongu'), array('cent', 'centy', 'centów')),
      'HRK' => array(array('kuna','kuny','kun'), array('lipa','lipy','lip')),
      'HUF' => array(array('forint','forinty','forintów'), array('filler','fillery','fillerów')),
      'ILS' => array(array('nowy szekel','nowe szekele','nowych szekeli'), array('agora','agory','agorot')),
      'ISK' => array(array('korona islandzka','korony islandzkie','koron islandzkich'), array('aurar','aurar','aurar')),
      'JPY' => array(array('jen','jeny','jenów'), array('sen','seny','senów')),
      'LTL' => array(array('lit','lity','litów'), array('cent', 'centy', 'centów')),
      'LVL' => array(array('³at','³aty','³atów'), array('sentim','sentimy','sentimów')),
      'MKD' => array(array('denar','denary','denarów'), array('deni','deni','deni')),
      'MTL' => array(array('lira maltañska','liry maltañskie','lir maltañskich'), array('centym','centymy','centymów')),
      'NOK' => array(array('korona norweska','korony norweskie','koron norweskich'), array('oere','oere','oere')),
      'PLN' => array(array('z³oty', 'z³ote', 'z³otych'), array('grosz', 'grosze', 'groszy')),
      'ROL' => array(array('lej','leje','lei'), array('bani','bani','bani')),
      'RUB' => array(array('rubel','ruble','rubli'), array('kopiejka','kopiejki','kopiejek')),
      'SEK' => array(array('korona szwedzka','korony szwedzkie','koron szweckich'), array('oere','oere','oere')),
      'SIT' => array(array('tolar','tolary','tolarów'), array('stotinia','stotinie','stotini')),
      'SKK' => array(array('korona s³owacka','korony s³owackie','koron s³owackich'), array('halerz','halerze','halerzy')),
      'TRL' => array(array('lira turecka','liry tureckie','lir tureckich'), array('kurusza','kurysze','kuruszy')),
      'UAH' => array(array('hrywna','hrywna','hrywna'), array('cent', 'centy', 'centów')),
      'USD' => array(array('dolar','dolary','dolarów'), array('cent', 'centy', 'centów')),
      'YUM' => array(array('dinar','dinary','dinarów'), array('para','para','para')),
      'ZAR' => array(array('rand','randy','randów'), array('cent', 'centy', 'centów'))
    );

    /**
     * The default currency name
     * @var string
     * @access public
     */
    var $def_currency = 'PLN'; // Polish zloty

    // }}}
    // {{{ toWords()

    /**
     * Converts a number to its word representation
     * in Polish language
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

      switch ($h) {
      case 9:
          $ret .= $this->_sep . 'dziewiêæset';
          break;

      case 8:
          $ret .= $this->_sep . 'osiemset';
          break;

      case 7:
          $ret .= $this->_sep . 'siedemset';
          break;

      case 6:
          $ret .= $this->_sep . 'sze¶æset';
          break;

      case 5:
          $ret .= $this->_sep . 'piêæset';
          break;

      case 4:
          $ret .= $this->_sep . 'czterysta';
          break;

      case 3:
          $ret .= $this->_sep . 'trzysta';
          break;

      case 2:
          $ret .= $this->_sep . 'dwie¶cie';
          break;

      case 1:
          $ret .= $this->_sep . 'sto';
          break;
      }

      switch ($t) {
      case 9:
      case 8:
      case 7:
      case 6:
      case 5:
          $ret .= $this->_sep . $this->_digits[$t] . 'dziesi±t';
          break;

      case 4:
          $ret .= $this->_sep . 'czterdzie¶ci';
          break;

      case 3:
          $ret .= $this->_sep . 'trzydzie¶ci';
          break;

      case 2:
          $ret .= $this->_sep . 'dwadzie¶cia';
          break;

      case 1:
          switch ($d) {
          case 0:
              $ret .= $this->_sep . 'dziesiêæ';
              break;

          case 1:
              $ret .= $this->_sep . 'jedena¶cie';
              break;

          case 2:
          case 3:
          case 7:
          case 8:
              $ret .= $this->_sep . $this->_digits[$d] . 'na¶cie';
              break;

          case 4:
              $ret .= $this->_sep . 'czterna¶cie';
              break;

          case 5:
              $ret .= $this->_sep . 'piêtna¶cie';
              break;

          case 6:
              $ret .= $this->_sep . 'szesna¶cie';
              break;

          case 9:
              $ret .= $this->_sep . 'dziewiêtna¶cie';
              break;
          }
          break; 
      }

      if ($t != 1 && $d > 0)
        $ret .= $this->_sep . $this->_digits[$d];
  
      if ($t == 1)
        $d = 0;

      if (( $h + $t ) > 0 && $d == 1)
        $d = 0;

      if ($power > 0) {
        if (isset($this->_exponent[$power]))
          $lev = $this->_exponent[$power];

        if (!isset($lev) || !is_array($lev))
          return null;
 
        switch ($d) {
          case 1:
            $suf = $lev[0];
            break;
          case 2:
          case 3:
          case 4:
            $suf = $lev[1];
            break;
          case 0:
          case 5:
          case 6:
          case 7:
          case 8:
          case 9:
            $suf = $lev[2];
            break;
        }
        $ret .= $this->_sep . $suf;
      }
  
      if ($powsuffix != '')
        $ret .= $this->_sep . $powsuffix;

      return $ret;
    }
    // }}}
    // {{{ toCurrency()

    /**
     * Converts a currency value to its word representation
     * (with monetary units) in Polish language
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
        $lev  = $this->_get_numlevel($decimal);
        $ret .= $this->_sep . $curr_names[0][$lev];
      
        if ($fraction !== false) {
            $ret .= $this->_sep . trim($this->toWords($fraction));
            $lev  = $this->_get_numlevel($fraction);    
            $ret .= $this->_sep . $curr_names[1][$lev];
        }
        return $ret;
    }
    // }}}
    // {{{ _get_numlevel()
    
    /**
     * Returns grammatical "level" of the number - this is necessary
     * for choosing the right suffix for exponents and currency names.
     *
     * @param  integer $num   An integer between -infinity and infinity inclusive
     *                        that need to be converted to words
     *
     * @return integer  The grammatical "level" of the number.
     *
     * @access private
     * @author Piotr Klaban <makler@man.torun.pl>
     * @since  Numbers_Words 0.4
     */
    function _get_numlevel($num) {
        $num = (int)substr($num,-3);
        $h = $t = $d = $lev = 0;
        
        switch(strlen($num)) {
            case 3:
                $h = (int)substr($num,-3,1);

            case 2:
                $t = (int)substr($num,-2,1);

            case 1:
                $d = (int)substr($num,-1,1);
                break;

            case 0:
                return $lev;
                break;
        }
        if ($t == 1)
            $d = 0;

        if (( $h + $t ) > 0 && $d == 1)
            $d = 0;

        switch ($d) {
            case 1:
                $lev = 0;
                break;
            case 2:
            case 3:
            case 4:
                $lev = 1;
                break;
            default:
                $lev = 2;
        }
        return $lev;
    }
    // }}}
}

?>
