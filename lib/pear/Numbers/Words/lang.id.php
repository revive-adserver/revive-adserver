<?php
/* vim: set expandtab tabstop=4 softtabstop=4 shiftwidth=4: */
//
// +----------------------------------------------------------------------+
// | PHP version 4.0                                                      |
// +----------------------------------------------------------------------+
// | Copyright (c) 1997-2001 The PHP Group                                |
// +----------------------------------------------------------------------+
// | This source file is subject to version 3.0 of the PHP license,       |
// | that is bundled with this package in the file LICENSE, and is        |
// | available at through the world-wide-web at                           |
// | http://www.php.net/license/3_0.txt.                                  |
// | If you did not receive a copy of the PHP license and are unable to   |
// | obtain it through the world-wide-web, please send a note to          |
// | license@php.net so we can mail you a copy immediately.               |
// +----------------------------------------------------------------------+
// | Authors: Ernas M. Jamil <ernasm@samba.co.id>, Arif Rifai Dwiyanto    |
// +----------------------------------------------------------------------+
//
// $Id$
//
// Numbers_Words class extension to spell numbers in Indonesian language.
//

require_once("PEAR.php");
require_once("Numbers/Words.php");

/**
* Class for translating numbers into Indonesian.
*
* @author Ernas M. Jamil, Arif Rifai Dwiyanto
*/
class Numbers_Words_id extends Numbers_Words
{

    // {{{ properties
    
    /**
    * Locale name
    * @var string
    */
    var $locale      = 'id';

    /**
    * Language name in English
    * @var string
    */
    var $lang        = 'Indonesia Language';

    /**
    * Native language name
    * @var string
    */
    var $lang_native = 'Bahasa Indonesia';
    
    /**
    * The word for the minus sign
    * @var string
    */
    var $_minus = 'minus'; // minus sign

    /**
    * The sufixes for exponents (singular and plural)
    * Names partly based on:
    * http://www.users.dircon.co.uk/~shaunf/shaun/numbers/millions.htm
    * @var array
    */
    var $_exponent = array(
        0 => array(''),
        3 => array('ribu'),
        6 => array('juta'),
        9 => array('milyar'),
       12 => array('trilyun'),
       24 => array('quadrillion'),
       30 => array('quintillion'),
       36 => array('sextillion'),
       42 => array('septillion'),
       48 => array('octillion'),
       54 => array('nonillion'),
       60 => array('decillion'),
       66 => array('undecillion'),
       72 => array('duodecillion'),
       78 => array('tredecillion'),
       84 => array('quattuordecillion'),
       90 => array('quindecillion'),
       96 => array('sexdecillion'),
      102 => array('septendecillion'),
      108 => array('octodecillion'),
      114 => array('novemdecillion'),
      120 => array('vigintillion'),
      192 => array('duotrigintillion'),
      600 => array('centillion')
        );

    /**
    * The array containing the digits (indexed by the digits themselves).
    * @var array
    */
    var $_digits = array(
        0 => 'nol', 'satu', 'dua', 'tiga', 'empat',
        'lima', 'enam', 'tujuh', 'delapan', 'sembilan'
    );

    /**
    * The word separator
    * @var string
    */
    var $_sep = ' ';

    // }}}
    // {{{ toWords()

    /**
     * Converts a number to its word representation
     * in Indonesian language
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
     * @author Ernas M. Jamil
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
        
      if (strlen($num) > 4) {
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
    
      $h = $t = $d = $th = 0;
      
      switch(strlen($num)) {
        case 4:
          $th = (int)substr($num,-4,1);

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

      if ($th) {
        if ($th==1)
            $ret .= $this->_sep . 'seribu';
        else
            $ret .= $this->_sep . $this->_digits[$th] . $this->_sep . 'ribu';
      }

      if ($h) {
        if ($h==1)
            $ret .= $this->_sep . 'seratus';
        else
            $ret .= $this->_sep . $this->_digits[$h] . $this->_sep . 'ratus';
        
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
      case 8:
      case 7:
      case 6:
      case 5:
      case 4:
      case 3:
      case 2:
          $ret .= $this->_sep . $this->_digits[$t] . ' puluh';
          break;
    
      case 1:
          switch ($d) {
          case 0:
              $ret .= $this->_sep . 'sepuluh';
              break;
    
          case 1:
              $ret .= $this->_sep . 'sebelas';
              break;
    
          case 2:
          case 3:
          case 4:
          case 5:
          case 6:
          case 7:
          case 8:
          case 9:
              $ret .= $this->_sep . $this->_digits[$d] . ' belas';
              break;
          }
          break; 
      }

      if ($t != 1 && $d > 0) { // add digits only in <0>,<1,9> and <21,inf>
        // add minus sign between [2-9] and digit
        if ($t > 1) {
          $ret .= ' ' . $this->_digits[$d];
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
}

?>
