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
// |          Andrey Demenev <demenev@on-line.jar.ru>                     |
// +----------------------------------------------------------------------+
//
// Numbers_Words class extension to spell numbers in Russian language.
//

/**
 * Class for translating numbers into Russian.
 *
 * @author Andrey Demenev
 * @package Numbers_Words
 */

/**
 * Include needed files
 */
require_once("Numbers/Words.php");

/**
 * Class for translating numbers into Russian.
 *
 * @author Andrey Demenev
 * @package Numbers_Words
 */
class Numbers_Words_ru extends Numbers_Words
{

    // {{{ properties

    /**
     * Locale name
     * @var string
     * @access public
     */
    var $locale      = 'ru';

    /**
     * Language name in English
     * @var string
     * @access public
     */
    var $lang        = 'Russian';

    /**
     * Native language name
     * @var string
     * @access public
     */
    var $lang_native = 'Русский';
    
    /**
     * The word for the minus sign
     * @var string
     * @access private
     */
    var $_minus = 'минус'; // minus sign
    
    /**
     * The sufixes for exponents (singular)
     * Names partly based on:
     * http://home.earthlink.net/~mrob/pub/math/largenum.html
     * http://mathforum.org/dr.math/faq/faq.large.numbers.html
     * http://www.mazes.com/AmericanNumberingSystem.html
     * @var array
     * @access private
     */
    var $_exponent = array(
        0 => '',
        6 => 'миллион',
        9 => 'миллиард',
       12 => 'триллион',
       15 => 'квадриллион',
       18 => 'квинтиллион',
       21 => 'секстиллион',
       24 => 'септиллион',
       27 => 'октиллион',
       30 => 'нониллион',
       33 => 'дециллион',
       36 => 'ундециллион',
       39 => 'дуодециллион',
       42 => 'тредециллион',
       45 => 'кватуордециллион',
       48 => 'квиндециллион',
       51 => 'сексдециллион',
       54 => 'септендециллион',
       57 => 'октодециллион',
       60 => 'новемдециллион',
       63 => 'вигинтиллион',
       66 => 'унвигинтиллион',
       69 => 'дуовигинтиллион',
       72 => 'тревигинтиллион',
       75 => 'кватуорвигинтиллион',
       78 => 'квинвигинтиллион',
       81 => 'сексвигинтиллион',
       84 => 'септенвигинтиллион',
       87 => 'октовигинтиллион',
       90 => 'новемвигинтиллион',
       93 => 'тригинтиллион',
       96 => 'унтригинтиллион',
       99 => 'дуотригинтиллион',
       102 => 'третригинтиллион',
       105 => 'кватортригинтиллион',
       108 => 'квинтригинтиллион',
       111 => 'секстригинтиллион',
       114 => 'септентригинтиллион',
       117 => 'октотригинтиллион',
       120 => 'новемтригинтиллион',
       123 => 'квадрагинтиллион',
       126 => 'унквадрагинтиллион',
       129 => 'дуоквадрагинтиллион',
       132 => 'треквадрагинтиллион',
       135 => 'кваторквадрагинтиллион',
       138 => 'квинквадрагинтиллион',
       141 => 'сексквадрагинтиллион',
       144 => 'септенквадрагинтиллион',
       147 => 'октоквадрагинтиллион',
       150 => 'новемквадрагинтиллион',
       153 => 'квинквагинтиллион',
       156 => 'унквинкагинтиллион',
       159 => 'дуоквинкагинтиллион',
       162 => 'треквинкагинтиллион',
       165 => 'кваторквинкагинтиллион',
       168 => 'квинквинкагинтиллион',
       171 => 'сексквинкагинтиллион',
       174 => 'септенквинкагинтиллион',
       177 => 'октоквинкагинтиллион',
       180 => 'новемквинкагинтиллион',
       183 => 'сексагинтиллион',
       186 => 'унсексагинтиллион',
       189 => 'дуосексагинтиллион',
       192 => 'тресексагинтиллион',
       195 => 'кваторсексагинтиллион',
       198 => 'квинсексагинтиллион',
       201 => 'секссексагинтиллион',
       204 => 'септенсексагинтиллион',
       207 => 'октосексагинтиллион',
       210 => 'новемсексагинтиллион',
       213 => 'септагинтиллион',
       216 => 'унсептагинтиллион',
       219 => 'дуосептагинтиллион',
       222 => 'тресептагинтиллион',
       225 => 'кваторсептагинтиллион',
       228 => 'квинсептагинтиллион',
       231 => 'секссептагинтиллион',
       234 => 'септенсептагинтиллион',
       237 => 'октосептагинтиллион',
       240 => 'новемсептагинтиллион',
       243 => 'октогинтиллион',
       246 => 'уноктогинтиллион',
       249 => 'дуооктогинтиллион',
       252 => 'треоктогинтиллион',
       255 => 'кватороктогинтиллион',
       258 => 'квиноктогинтиллион',
       261 => 'сексоктогинтиллион',
       264 => 'септоктогинтиллион',
       267 => 'октооктогинтиллион',
       270 => 'новемоктогинтиллион',
       273 => 'нонагинтиллион',
       276 => 'уннонагинтиллион',
       279 => 'дуононагинтиллион',
       282 => 'тренонагинтиллион',
       285 => 'кваторнонагинтиллион',
       288 => 'квиннонагинтиллион',
       291 => 'секснонагинтиллион',
       294 => 'септеннонагинтиллион',
       297 => 'октононагинтиллион',
       300 => 'новемнонагинтиллион',
       303 => 'центиллион'
        );

    /**
     * The array containing the teens' :) names
     * @var array
     * @access private
     */
    var $_teens = array(
        11=>'одиннадцать',
        12=>'двенадцать',
        13=>'тринадцать',
        14=>'четырнадцать',
        15=>'пятнадцать',
        16=>'шестнадцать',
        17=>'семнадцать',
        18=>'восемнадцать',
        19=>'девятнадцать'
        );

    /**
     * The array containing the tens' names
     * @var array
     * @access private
     */
    var $_tens = array(
        2=>'двадцать',
        3=>'тридцать',
        4=>'сорок',
        5=>'пятьдесят',
        6=>'шестьдесят',
        7=>'семьдесят',
        8=>'восемьдесят',
        9=>'девяносто'
        );

    /**
     * The array containing the hundreds' names
     * @var array
     * @access private
     */
    var $_hundreds = array(
        1=>'сто',
        2=>'двести',
        3=>'триста',
        4=>'четыреста',
        5=>'пятьсот',
        6=>'шестьсот',
        7=>'семьсот',
        8=>'восемьсот',
        9=>'девятьсот'
        );

    /**
     * The array containing the digits 
     * for neutral, male and female
     * @var array
     * @access private
     */
    var $_digits = array(
        array('ноль', 'одно', 'два', 'три', 'четыре','пять', 'шесть', 'семь', 'восемь', 'девять'),
        array('ноль', 'один', 'два', 'три', 'четыре','пять', 'шесть', 'семь', 'восемь', 'девять'),
        array('ноль', 'одна', 'две', 'три', 'четыре','пять', 'шесть', 'семь', 'восемь', 'девять')
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
     * @link http://www.jhall.demon.co.uk/currency/by_abbrev.html World currencies
     * @link http://www.rusimpex.ru/Content/Reference/Refinfo/valuta.htm Foreign currencies names
     * @link http://www.cofe.ru/Finance/money.asp Currencies names
     * @access private
     */
    var $_currency_names = array(
      'ALL' => array(
                array(1,'лек','лека','леков'), 
                array(2,'киндарка','киндарки','киндарок')
               ),
      'AUD' => array(
                array(1,'австралийский доллар','австралийских доллара','австралийских долларов'),
                array(1,'цент','цента','центов')
               ),
      'BGN' => array(
                array(1,'лев','лева','левов'), 
                array(2,'стотинка','стотинки','стотинок')
               ),
      'BRL' => array(
                array(1,'бразильский реал','бразильских реала','бразильских реалов'), 
                array(1,'сентаво','сентаво','сентаво')
               ),
      'BYR' => array(
                array(1,'белорусский рубль','белорусских рубля','белорусских рублей'), 
                array(2,'копейка','копейки','копеек')
               ),
      'CAD' => array(
                array(1,'канадский доллар','канадских доллара','канадских долларов'),
                array(1,'цент','цента','центов')
               ),
      'CHF' => array(
                array(1,'швейцарский франк','швейцарских франка','швейцарских франков'),
                array(1,'сантим','сантима','сантимов')
               ),
      'CYP' => array(
                array(1,'кипрский фунт','кипрских фунта','кипрских фунтов'),
                array(1,'цент','цента','центов')
               ),
      'CZK' => array(
                array(2,'чешская крона','чешских кроны','чешских крон'),
                array(1,'галирж','галиржа','галиржей')
               ),
      'DKK' => array(
                array(2,'датская крона','датских кроны','датских крон'),
                array(1,'эре','эре','эре')
               ),
      'EEK' => array(
                array(2,'эстонская крона','эстонских кроны','эстонских крон'),
                array(1,'сенти','сенти','сенти')
               ),
      'EUR' => array(
                array(1,'евро','евро','евро'),
                array(1,'евроцент','евроцента','евроцентов')
               ),
      'CYP' => array(
                array(1,'фунт стерлингов','фунта стерлингов','фунтов стерлингов'),
                array(1,'пенс','пенса','пенсов')
               ),
      'CAD' => array(
                array(1,'гонконгский доллар','гонконгских доллара','гонконгских долларов'),
                array(1,'цент','цента','центов')
               ),
      'HRK' => array(
                array(2,'хорватская куна','хорватских куны','хорватских кун'),
                array(2,'липа','липы','лип')
               ),
      'HUF' => array(
                array(1,'венгерский форинт','венгерских форинта','венгерских форинтов'),
                array(1,'филлер','филлера','филлеров')
               ),
      'ISK' => array(
                array(2,'исландская крона','исландских кроны','исландских крон'),
                array(1,'эре','эре','эре')
               ),
      'JPY' => array(
                array(2,'иена','иены','иен'),
                array(2,'сена','сены','сен')
               ),
      'LTL' => array(
                array(1,'лит','лита','литов'),
                array(1,'цент','цента','центов')
               ),
      'LVL' => array(
                array(1,'лат','лата','латов'),
                array(1,'сентим','сентима','сентимов')
               ),
      'MKD' => array(
                array(1,'македонский динар','македонских динара','македонских динаров'),
                array(1,'дени','дени','дени')
               ),
      'MTL' => array(
                array(2,'мальтийская лира','мальтийских лиры','мальтийских лир'),
                array(1,'сентим','сентима','сентимов')
               ),
      'NOK' => array(
                array(2,'норвежская крона','норвежских кроны','норвежских крон'),
                array(0,'эре','эре','эре')
               ),
      'PLN' => array(
                array(1,'злотый','злотых','злотых'),
                array(1,'грош','гроша','грошей')
               ),
      'ROL' => array(
                array(1,'румынский лей','румынских лей','румынских лей'),
                array(1,'бани','бани','бани')
               ),
       // both RUR and RUR are used, I use RUB for shorter form
      'RUB' => array(
                array(1,'рубль','рубля','рублей'),
                array(2,'копейка','копейки','копеек')
               ),
      'RUR' => array(
                array(1,'российский рубль','российских рубля','российских рублей'),
                array(2,'копейка','копейки','копеек')
               ),
      'SEK' => array(
                array(2,'шведская крона','шведских кроны','шведских крон'),
                array(1,'эре','эре','эре')
               ),
      'SIT' => array(
                array(1,'словенский толар','словенских толара','словенских толаров'),
                array(2,'стотина','стотины','стотин')
               ),
      'SKK' => array(
                array(2,'словацкая крона','словацких кроны','словацких крон'),
                array(0,'','','')
               ),
      'TRL' => array(
                array(2,'турецкая лира','турецких лиры','турецких лир'),
                array(1,'пиастр','пиастра','пиастров')
               ),
      'UAH' => array(
                array(2,'гривна','гривны','гривен'),
                array(1,'цент','цента','центов')
               ),
      'USD' => array(
                array(1,'доллар США','доллара США','долларов США'),
                array(1,'цент','цента','центов')
               ),
      'YUM' => array(
                array(1,'югославский динар','югославских динара','югославских динаров'),
                array(1,'пара','пара','пара')
               ),
      'ZAR' => array(
                array(1,'ранд','ранда','рандов'),
                array(1,'цент','цента','центов')
               )
    );

    /**
     * The default currency name
     * @var string
     * @access public
     */
    var $def_currency = 'RUB'; // Russian rouble

    // }}}
    // {{{ toWords()

    /**
     * Converts a number to its word representation
     * in Russian language
     *
     * @param  integer $num   An integer between -infinity and infinity inclusive :)
     *                        that need to be converted to words
     * @param  integer $gender Gender of string, 0=neutral, 1=male, 2=female.
     *                         Optional, defaults to 1.
     *
     * @return string  The corresponding word representation
     *
     * @access private
     * @author Andrey Demenev <demenev@on-line.jar.ru>
     */
    function toWords($num, $gender = 1) 
    {
        return $this->_toWordsWithCase($num, $dummy, $gender);
    }

    /**
     * Converts a number to its word representation
     * in Russian language and determines the case of string.
     *
     * @param  integer $num   An integer between -infinity and infinity inclusive :)
     *                        that need to be converted to words
     * @param  integer $case A variable passed by reference which is set to case
     *                       of the word associated with the number
     * @param  integer $gender Gender of string, 0=neutral, 1=male, 2=female.
     *                         Optional, defaults to 1.
     *
     * @return string  The corresponding word representation
     *
     * @access private
     * @author Andrey Demenev <demenev@on-line.jar.ru>
     */
    function _toWordsWithCase($num, &$case, $gender = 1)
    {
      $ret = '';
      $case = 3;
      
      $num = trim($num);
      
      $sign = "";
      if (substr($num, 0, 1) == '-') {
        $sign = $this->_minus . $this->_sep;
        $num = substr($num, 1);
      }

      while (strlen($num) % 3) $num = '0' . $num;
      if ($num == 0 || $num == '') {
        $ret .= $this->_digits[$gender][0];
      }
      
      else {
        $power = 0;
        while ($power < strlen($num)) {
            if (!$power) {
                $groupgender = $gender;
            } elseif ($power == 3) {
                $groupgender = 2;
            } else {
                $groupgender = 1;
            }
            $group = $this->_groupToWords(substr($num,-$power-3,3),$groupgender,$_case);
            if (!$power) {
                $case = $_case;
            }
            if ($power == 3) {
                if ($_case == 1) {
                    $group .= $this->_sep . 'тысяча';
                } elseif ($_case == 2) {
                    $group .= $this->_sep . 'тысячи';
                } else {
                    $group .= $this->_sep . 'тысяч';
                }
            } elseif ($group && $power>3 && isset($this->_exponent[$power])) {
                $group .= $this->_sep . $this->_exponent[$power];
                if ($_case == 2) {
                    $group .= 'а';
                } elseif ($_case == 3) {
                    $group .= 'ов';
                }
            }
            if ($group) {
                $ret = $group . $this->_sep . $ret;
            }
            $power+=3;
        }
      }

      return $sign . $ret;
    }

    // }}}
    // {{{ _groupToWords()

    /**
     * Converts a group of 3 digits to its word representation
     * in Russian language.
     *
     * @param  integer $num   An integer between -infinity and infinity inclusive :)
     *                        that need to be converted to words
     * @param  integer $gender Gender of string, 0=neutral, 1=male, 2=female.
     * @param  integer $case A variable passed by reference which is set to case
     *                       of the word associated with the number
     *
     * @return string  The corresponding word representation
     *
     * @access private
     * @author Andrey Demenev <demenev@on-line.jar.ru>
     */
    function _groupToWords($num, $gender, &$case)
    {
      $ret = '';        
      $case = 3;
      if ((int)$num == 0) {
          $ret = '';
      } elseif ($num < 10) {
          $ret = $this->_digits[$gender][(int)$num];
          if ($num == 1) $case = 1;
          elseif ($num < 5) $case = 2;
          else $case = 3;
      } else {
          $num = str_pad($num,3,'0',STR_PAD_LEFT);
          $hundreds = (int)$num{0};
          if ($hundreds) {
              $ret = $this->_hundreds[$hundreds];
              if (substr($num,1) != '00') {
                  $ret .= $this->_sep;
              }
              $case = 3;
          }
          $tens=(int)$num{1};
          $ones=(int)$num{2};
          if ($tens || $ones) {
              if ($tens == 1 && $ones == 0) $ret .= 'десять';
              elseif ($tens < 2) $ret .= $this->_teens[$ones+10];
              else {
                  $ret .= $this->_tens[(int)$tens];
                  if ($ones > 0) {
                      $ret .= $this->_sep
                          .$this->_digits[$gender][$ones];
                      if ($ones == 1) {
                          $case = 1;
                      } elseif ($ones < 5) {
                          $case = 2;
                      } else {
                          $case = 3;
                      }
                  }
              }
          }
      }
      return $ret;
    }
    // }}}
    // {{{ toCurrencyWords()

    /**
     * Converts a currency value to its word representation
     * (with monetary units) in Russian language
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
     * @author Andrey Demenev <demenev@on-line.jar.ru>
     */
    function toCurrencyWords($int_curr, $decimal, $fraction = false)
    {
        $int_curr = strtoupper($int_curr);
        if (!isset($this->_currency_names[$int_curr])) {
            $int_curr = $this->def_currency;
        }
        $curr_names = $this->_currency_names[$int_curr];
        $ret = trim($this->_toWordsWithCase($decimal, $case, $curr_names[0][0]));
        $ret .= $this->_sep . $curr_names[0][$case];

        if ($fraction !== false) {
            $ret .= $this->_sep . trim($this->_toWordsWithCase($fraction, $case, $curr_names[1][0]));
            $ret .= $this->_sep . $curr_names[1][$case];
        }
        return $ret;
    }
    // }}}

}

?>
