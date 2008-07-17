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
// | Authors: Jesper Veggerby <pear.nosey@veggerby.dk>                    |
// +----------------------------------------------------------------------+
//
// $Id$
//
// Numbers_Words class extension to spell numbers in Danish language.
//

/**
 * Class for translating numbers into Danish.
 *
 * @author Jesper Veggerby <pear.nosey@veggerby.dk>
 * @package Numbers_Words
 */

/**
 * Include needed files
 */
require_once("Numbers/Words.php");

/**
 * Class for translating numbers into Danish.
 *
 * @author Jesper Veggerby <pear.nosey@veggerby.dk>
 * @package Numbers_Words
 */
class Numbers_Words_dk extends Numbers_Words
{

    // {{{ properties

    /**
     * Locale name
     * @var string
     * @access public
     */
    var $locale      = 'dk';

    /**
     * Language name in English
     * @var string
     * @access public
     */
    var $lang        = 'Danish';

    /**
     * Native language name
     * @var string
     * @access public
     */
    var $lang_native = 'Dansk';

    /**
     * The word for the minus sign
     * @var string
     * @access private
     */
    var $_minus = 'minus'; // minus sign

    /**
     * The sufixes for exponents (singular and plural).
     * From: http://da.wikipedia.org/wiki/Navne_p%E5_store_tal
     * @var array
     * @access private
     */
    var $_exponent = array(
        0 => array(''),
        3 => array('tusind','tusinde'),
        6 => array('million','millioner'),
        9 => array('milliard','milliarder'),
       12 => array('billion','billioner'),
       15 => array('billiard','billiarder'),
       18 => array('trillion','trillioner'),
       21 => array('trilliard','trilliarder'),
       24 => array('quadrillion','quadrillioner'),
       30 => array('quintillion','quintillioner'),
       36 => array('sextillion','sextillioner'),
       42 => array('septillion','septillioner'),
       48 => array('octillion','octillioner'),
       54 => array('nonillion','nonillioner'),
       60 => array('decillion','decillioner'),
      120 => array('vigintillion','vigintillioner'),
      600 => array('centillion','centillioner')
        );

    /**
     * The array containing the digits (indexed by the digits themselves).
     * @var array
     * @access private
     */
    var $_digits = array(
        0 => 'nul', 'en', 'to', 'tre', 'fire',
        'fem', 'seks', 'syv', 'otte', 'ni'
    );

    /**
     * The word separator
     * @var string
     * @access private
     */
    var $_sep  = ' ';

    /**
     * The currency names (based on the below links,
     * informations from central bank websites and on encyclopedias)
     *
     * @var array
     * @link http://da.wikipedia.org/wiki/Valuta
     * @access private
     */
    var $_currency_names = array(
      'AUD' => array(array('australsk dollar', 'australske dollars'), array('cent')),
      'CAD' => array(array('canadisk dollar', 'canadisk dollars'), array('cent')),
      'CHF' => array(array('schweitzer franc'), array('rappen')),
      'CYP' => array(array('cypriotisk pund', 'cypriotiske pund'), array('cent')),
      'CZK' => array(array('tjekkisk koruna'), array('halerz')),
      'DKK' => array(array('krone', 'kroner'), array('øre')),
      'EUR' => array(array('euro'), array('euro-cent')),
      'GBP' => array(array('pund'), array('pence')),
      'HKD' => array(array('Hong Kong dollar', 'Hong Kong dollars'), array('cent')),
      'JPY' => array(array('yen'), array('sen')),
      'NOK' => array(array('norsk krone', 'norske kroner'), array('øre')),
      'PLN' => array(array('zloty', 'zlotys'), array('grosz')),
      'SEK' => array(array('svensk krone', 'svenske kroner'), array('øre')),
      'USD' => array(array('dollar', 'dollars'), array('cent'))
    );

    /**
     * The default currency name
     * @var string
     * @access public
     */
    var $def_currency = 'DKK'; // Danish krone

    // }}}
    // {{{ toWords()

    /**
     * Converts a number to its word representation
     * in Danish language
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
     * @author Jesper Veggerby <pear.nosey@veggerby.dk>
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
      	if ($h == 1) {
	        $ret .= $this->_sep . 'et' . $this->_sep . 'hundrede';
      	} else {
        	$ret .= $this->_sep . $this->_digits[$h] . $this->_sep . 'hundrede';
        }

		  //if (($t + $d) > 0)
			//  $ret .= $this->_sep . 'og';
      } elseif ((isset($maxp)) && ($maxp > 3)) {
      	// add 'og' in the case where there are preceding thousands but not hundreds or tens,
      	// so fx. 80001 becomes 'firs tusinde og en' instead of 'firs tusinde en'
		$ret .= $this->_sep . 'og';
      }


	  if ($t != 1 && $d > 0) {
        $ret .= $this->_sep . (($d == 1 & $power == 3 && $t == 0 && $h == 0) ? "et" : $this->_digits[$d]) . ($t > 1 ? $this->_sep . "og" : "");
      }

      // ten, twenty etc.
      switch ($t) {
      case 9:
          $ret .= $this->_sep . 'halvfems';
          break;

      case 8:
          $ret .= $this->_sep . 'firs';
          break;

      case 7:
          $ret .= $this->_sep . 'halvfjerds';
          break;

      case 6:
          $ret .= $this->_sep . 'tres';
          break;

      case 5:
          $ret .= $this->_sep . 'halvtreds';
          break;

      case 4:
          $ret .= $this->_sep . 'fyrre';
          break;

      case 3:
          $ret .= $this->_sep . 'tredive';
          break;

      case 2:
          $ret .= $this->_sep . 'tyve';
          break;

      case 1:
          switch ($d) {
          case 0:
              $ret .= $this->_sep . 'ti';
              break;

          case 1:
              $ret .= $this->_sep . 'elleve';
              break;

          case 2:
              $ret .= $this->_sep . 'tolv';
              break;

          case 3:
              $ret .= $this->_sep . 'tretten';
              break;

          case 4:
              $ret .= $this->_sep . 'fjorten';
              break;

          case 5:
              $ret .= $this->_sep . 'femten';
              break;

          case 6:
              $ret .= $this->_sep . 'seksten';
              break;

          case 7:
              $ret .= $this->_sep . 'sytten';
              break;

          case 8:
              $ret .= $this->_sep . 'atten';
              break;

          case 9:
              $ret .= $this->_sep . 'nitten';
              break;

          }
          break;
      }

      if ($power > 0) {
        if (isset($this->_exponent[$power]))
          $lev = $this->_exponent[$power];

        if (!isset($lev) || !is_array($lev))
          return null;

        if ($d == 1 && ($t+$h) == 0) {
          $ret .= $this->_sep . $lev[0];
        } else {
          $ret .= $this->_sep . $lev[1];
        }
      }

      if ($powsuffix != '')
        $ret .= $this->_sep . $powsuffix;

      return $ret;
    }
    // }}}
    // {{{ toCurrency()

    /**
     * Converts a currency value to its word representation
     * (with monetary units) in danish language
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
     * @author Jesper Veggerby <pear.nosey@veggerby.dk>
     * @since  Numbers_Words 0.4
     */
    function toCurrencyWords($int_curr, $decimal, $fraction = false) {
        $int_curr = strtoupper($int_curr);
        if (!isset($this->_currency_names[$int_curr])) {
            $int_curr = $this->def_currency;
        }
        $curr_names = $this->_currency_names[$int_curr];

        if (($decimal != "") and ($decimal != 0)) {
			$ret  = trim($this->toWords($decimal));
			$lev  = ($decimal == 1) ? 0 : 1;
			if ($lev > 0) {
				if (count($curr_names[0]) > 1) {
					$ret .= $this->_sep . $curr_names[0][$lev];
				} else {
					$ret .= $this->_sep . $curr_names[0][0];
				}
			} else {
				$ret .= $this->_sep . $curr_names[0][0];
			}

			if (($fraction !== false)  and ($fraction != 0)) {
				$ret .= $this->_sep . "og";
			}
		}

        if (($fraction !== false) and ($fraction != 0)) {
            $ret .= $this->_sep . trim($this->toWords($fraction));
            $lev  = ($fraction == 1) ? 0 : 1;
            if ($lev > 0) {
                if (count($curr_names[1]) > 1) {
                    $ret .= $this->_sep . $curr_names[1][$lev];
                } else {
                    $ret .= $this->_sep . $curr_names[1][0];
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
