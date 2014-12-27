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
// |          Robin Ericsson <robin.ericsson@profecta.se>                 |
// +----------------------------------------------------------------------+
//
// Numbers_Words class extension to spell numbers in Swedish language.
//

/**
 *
 * Class for translating numbers into Swedish.
 * @author Robin Ericsson
 * @package Numbers_Words
 */

/**
 * Include needed files
 */
require_once("Numbers/Words.php");

/**
 * Class for translating numbers into Swedish.
 *
 * @author Robin Ericsson
 * @package Numbers_Words
 */
class Numbers_Words_sv extends Numbers_Words
{

    // {{{ properties
    
    /**
     * Locale name
     * @var string
     * @access public
     */
    var $locale      = 'sv';

    /**
     * Language name in English
     * @var string
     * @access public
     */
    var $lang        = 'Swedish';

    /**
     * Native language name
     * @var string
     * @access public
     */
    var $lang_native = 'Svenska';
    
    /**
     * The word for the minus sign
     * @var string
     * @access private
     */
    var $_minus = 'Minus'; // minus sign

    /**
     * The sufixes for exponents (singular and plural)
     * @var array
     * @access private
     */
    var $_exponent = array(
        0 => array(''),
        3 => array('tusen', 'tusen'),
        6 => array('miljon','miljoner'),
        9 => array('miljard','miljarder'),
       12 => array('biljon','biljoner'),
       15 => array('biljard','biljarder'),
       18 => array('triljon','triljoner'),
       21 => array('triljard','triljarder'),
       24 => array('kvadriljon','kvadriljoner'),
       27 => array('kvadriljard','kvadriljarder'),
       30 => array('kvintiljon','kvintiljoner'),
       33 => array('kvintiljard','kvintiljarder'),
       36 => array('sextiljon','sextiljoner'),
       39 => array('sextiljard','sextiljarder'),
       42 => array('septiljon','septiljoner'),
       45 => array('septiljard','septiljarder'),
       48 => array('oktiljon','oktiljoner'),
       51 => array('oktiljard','oktiljarder'),
       54 => array('noniljon','noniljoner'),
       57 => array('noniljard','noniljarder'),
       60 => array('dekiljon','dekiljoner'),
       63 => array('dekiljard','dekiljarder'),
      120 => array('vigintiljon','vigintiljoner'),
      123 => array('vigintiljard','vigintiljarder'),
      600 => array('centiljon','centiljoner'), 
      603 => array('centiljard','centiljarder')
        );

    /**
     * The array containing the digits (indexed by the digits themselves).
     * @var array
     * @access private
     */
    var $_digits = array(
        0 => 'noll', 'ett', 'två', 'tre', 'fyra',
        'fem', 'sex', 'sju', 'åtta', 'nio'
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
     * in Swedish language.
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
     * @author Robin Ericsson <lobbin@localhost.nu>
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
        $ret .= $this->_sep . $this->_digits[$h] . $this->_sep . 'hundra';
      }

      // ten, twenty etc.
      switch ($t) {
      case 5:
      case 6:
      case 7:
          $ret .= $this->_sep . $this->_digits[$t] . 'tio';
          break;
    
      case 9:
          $ret .= $this->_sep . 'nittio';
          break;
    
      case 8:
          $ret .= $this->_sep . 'åttio';
          break;
    
      case 4:
          $ret .= $this->_sep . 'fyrtio';
          break;
    
      case 3:
          $ret .= $this->_sep . 'trettio';
          break;
    
      case 2:
          $ret .= $this->_sep . 'tjugo';
          break;
    
      case 1:
          switch ($d) {
          case 0:
              $ret .= $this->_sep . 'tio';
              break;
    
          case 1:
              $ret .= $this->_sep . 'elva';
              break;
    
          case 2:
              $ret .= $this->_sep . 'tolv';
              break;
    
          case 3:
              $ret .= $this->_sep . 'tretton';
              break;
    
          case 4:
              $ret .= $this->_sep . 'fjorton';
              break;
              
          case 5:
          case 6:
              $ret .= $this->_sep . $this->_digits[$d] . 'ton';
              break;
    
          case 7:
              $ret .= $this->_sep . 'sjutton';
              break;
    
          case 8:
              $ret .= $this->_sep . 'arton';
              break;
          case 9:
              $ret .= $this->_sep . 'nitton';
          }
          break; 
      }

      if ($t != 1 && $d > 0) { // add digits only in <0>,<1,9> and <21,inf>
        // add minus sign between [2-9] and digit
        $ret .= $this->_sep . $this->_digits[$d];
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
