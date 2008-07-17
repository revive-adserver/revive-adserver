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
// Numbers_Words class extension to spell numbers in German language.
//

/**
 *
 * Class for translating numbers into German.
 * @author Piotr Klaban
 * @package Numbers_Words
 */

/**
 * Include needed files
 */
require_once("Numbers/Words.php");

/**
 * Class for translating numbers into German.
 *
 * @author Piotr Klaban
 * @package Numbers_Words
 */
class Numbers_Words_de extends Numbers_Words
{

    // {{{ properties
    
    /**
     * Locale name
     * @var string
     * @access public
     */
    var $locale      = 'de';

    /**
     * Language name in English
     * @var string
     * @access public
     */
    var $lang        = 'German';

    /**
     * Native language name
     * @var string
     * @access public
     */
    var $lang_native = 'Deutsch';
    
    /**
     * The word for the minus sign
     * @var string
     * @access private
     */
    var $_minus = 'Minus'; // minus sign

    /**
     * The sufixes for exponents (singular and plural)
     * Names partly based on:
     * http://german.about.com/library/blzahlenaud.htm
     * http://www3.osk.3web.ne.jp/~nagatani/common/zahlwort.htm
     * @var array
     * @access private
     */
    var $_exponent = array(
        0 => array(''),
        3 => array('tausend','tausend'),
        6 => array('Million','Millionen'),
        9 => array('Milliarde','Milliarden'),
       12 => array('Billion','Billionen'),
       15 => array('Billiarde','Billiarden'),
       18 => array('Trillion','Trillionen'),
       21 => array('Trilliarde','Trilliarden'),
       24 => array('Quadrillion','Quadrillionen'),
       27 => array('Quadrilliarde','Quadrilliarden'),
       30 => array('Quintillion','Quintillionen'),
       33 => array('Quintilliarde','Quintilliarden'),
       36 => array('Sextillion','Sextillionen'),
       39 => array('Sextilliarde','Sextilliarden'),
       42 => array('Septillion','Septillionen'),
       45 => array('Septilliarde','Septilliarden'),
       48 => array('Oktillion','Oktillionen'), // oder Octillionen
       51 => array('Oktilliarde','Oktilliarden'),
       54 => array('Nonillion','Nonillionen'),
       57 => array('Nonilliarde','Nonilliarden'),
       60 => array('Dezillion','Dezillionen'),
       63 => array('Dezilliarde','Dezilliarden'),
      120 => array('Vigintillion','Vigintillionen'),
      123 => array('Vigintilliarde','Vigintilliarden'),
      600 => array('Zentillion','Zentillionen'), // oder Centillion
      603 => array('Zentilliarde','Zentilliarden')
        );

    /**
     * The array containing the digits (indexed by the digits themselves).
     * @var array
     * @access private
     */
    var $_digits = array(
        0 => 'null', 'ein', 'zwei', 'drei', 'vier',
        'fünf', 'sechs', 'sieben', 'acht', 'neun'
    );

    /**
     * The word separator
     * @var string
     * @access private
     */
    var $_sep  = '';
    
    /**
     * The exponent word separator
     * @var string
     * @access private
     */
    var $_sep2 = ' ';

    // }}}
    // {{{ toWords()

    /**
     * Converts a number to its word representation
     * in German language.
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
     * @access private
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
        
        $ret .= $this->_sep . $this->_digits[$h] . $this->_sep . 'hundert';
      }

      if ($t != 1 && $d > 0) { // add digits only in <0>,<1,9> and <21,inf>
        if ($t > 0) {
          $ret .= $this->_digits[$d] . 'und';
        } else {
          $ret .= $this->_digits[$d];
          if ($d == 1)
            if ($power == 0) {
              $ret .= 's'; // fuer eins
            } else {
              if ($power != 3) {  // tausend ausnehmen
                $ret .= 'e'; // fuer eine
              }
            }
        }
      }

      // ten, twenty etc.
      switch ($t) {
      case 9:
      case 8:
      case 5:
          $ret .= $this->_sep . $this->_digits[$t] . 'zig';
          break;
    
      case 7:
          $ret .= $this->_sep . 'siebzig';
          break;
    
      case 6:
          $ret .= $this->_sep . 'sechzig';
          break;
    
      case 4:
          $ret .= $this->_sep . 'vierzig';
          break;
    
      case 3:
          $ret .= $this->_sep . 'dreißig';
          break;
    
      case 2:
          $ret .= $this->_sep . 'zwanzig';
          break;
    
      case 1:
          switch ($d) {
          case 0:
              $ret .= $this->_sep . 'zehn';
              break;
    
          case 1:
              $ret .= $this->_sep . 'elf';
              break;
    
          case 2:
              $ret .= $this->_sep . 'zwölf';
              break;
    
          case 3:
          case 4:
          case 5:
          case 8:
          case 9:
              $ret .= $this->_sep . $this->_digits[$d] . 'zehn';
              break;
    
          case 6:
              $ret .= $this->_sep . 'sechzehn';
              break;
    
          case 7:
              $ret .= $this->_sep . 'siebzehn';
              break;
          }
          break; 
      }
 
      if ($power > 0) {
        if (isset($this->_exponent[$power]))
          $lev = $this->_exponent[$power];
    
        if (!isset($lev) || !is_array($lev))
          return null;
     
        if ($power == 3)
          $ret .= $this->_sep . $lev[0];
        elseif ($d == 1 && ($t+$h) == 0)
          $ret .= $this->_sep2 . $lev[0] . $this->_sep2;
        else
          $ret .= $this->_sep2 . $lev[1] . $this->_sep2;
      }
    
      if ($powsuffix != '')
        $ret .= $this->_sep . $powsuffix;
    
      return $ret;
    }
    // }}}
}

?>
