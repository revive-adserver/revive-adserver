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
// | Authors: Erkki Saarniit <erkki@center.ee>                            |
// +----------------------------------------------------------------------+
//
// $Id$
//
// Numbers_Words class extension to spell numbers in Estonian language.
//

/**
 * Class for translating numbers into Estonian.
 *
 * @author Erkki Saarniit
 * @package Numbers_Words
 */

/**
 * Include needed files
 */
require_once("Numbers/Words.php");

/**
 * Class for translating numbers into Estonian.
 *
 * @author Erkki Saarniit
 * @package Numbers_Words
 */
class Numbers_Words_ee extends Numbers_Words
{

    // {{{ properties
    
    /**
     * Locale name
     * @var string
     * @access public
     */
    var $locale      = 'ee';

    /**
     * Language name in English
     * @var string
     * @access public
     */
    var $lang        = 'Estonian';

    /**
     * Native language name
     * @var string
     * @access public
     */
    var $lang_native = 'eesti keel';
    
    /**
     * The word for the minus sign
     * @var string
     * @access private
     */
    var $_minus = 'miinus'; // minus sign
    
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
        3 => array('tuhat'),
        6 => array('miljon'),
        9 => array('miljard'),
       12 => array('triljon'),
       15 => array('kvadriljon'),
       18 => array('kvintiljon'),
       21 => array('sekstiljon'),
       24 => array('septiljon'),
       27 => array('oktiljon'),
       30 => array('noniljon'),
       33 => array('dekiljon'),
       36 => array('undekiljon'),
       39 => array('duodekiljon'),
       42 => array('tredekiljon'),
       45 => array('kvattuordekiljon'),
       48 => array('kvindekiljon'),
       51 => array('seksdekiljon'),
       54 => array('septendekiljon'),
       57 => array('oktodekiljon'),
       60 => array('novemdekiljon'),
       63 => array('vigintiljon'),
       66 => array('unvigintiljon'),
       69 => array('duovigintiljon'),
       72 => array('trevigintiljon'),
       75 => array('kvattuorvigintiljon'),
       78 => array('kvinvigintiljon'),
       81 => array('seksvigintiljon'),
       84 => array('septenvigintiljon'),
       87 => array('oktovigintiljon'),
       90 => array('novemvigintiljon'),
       93 => array('trigintiljon'),
       96 => array('untrigintiljon'),
       99 => array('duotrigintiljon'),
      102 => array('trestrigintiljon'),
      105 => array('kvattuortrigintiljon'),
      108 => array('kvintrigintiljon'),
      111 => array('sekstrigintiljon'),
      114 => array('septentrigintiljon'),
      117 => array('oktotrigintiljon'),
      120 => array('novemtrigintiljon'),
      123 => array('kvadragintiljon'),
      126 => array('unkvadragintiljon'),
      129 => array('duokvadragintiljon'),
      132 => array('trekvadragintiljon'),
      135 => array('kvattuorkvadragintiljon'),
      138 => array('kvinkvadragintiljon'),
      141 => array('sekskvadragintiljon'),
      144 => array('septenkvadragintiljon'),
      147 => array('oktokvadragintiljon'),
      150 => array('novemkvadragintiljon'),
      153 => array('kvinkvagintiljon'),
      156 => array('unkvinkvagintiljon'),
      159 => array('duokvinkvagintiljon'),
      162 => array('trekvinkvagintiljon'),
      165 => array('kvattuorkvinkvagintiljon'),
      168 => array('kvinkvinkvagintiljon'),
      171 => array('sekskvinkvagintiljon'),
      174 => array('septenkvinkvagintiljon'),
      177 => array('oktokvinkvagintiljon'),
      180 => array('novemkvinkvagintiljon'),
      183 => array('seksagintiljon'),
      186 => array('unseksagintiljon'),
      189 => array('duoseksagintiljon'),
      192 => array('treseksagintiljon'),
      195 => array('kvattuorseksagintiljon'),
      198 => array('kvinseksagintiljon'),
      201 => array('seksseksagintiljon'),
      204 => array('septenseksagintiljon'),
      207 => array('oktoseksagintiljon'),
      210 => array('novemseksagintiljon'),
      213 => array('septuagintiljon'),
      216 => array('unseptuagintiljon'),
      219 => array('duoseptuagintiljon'),
      222 => array('treseptuagintiljon'),
      225 => array('kvattuorseptuagintiljon'),
      228 => array('kvinseptuagintiljon'),
      231 => array('seksseptuagintiljon'),
      234 => array('septenseptuagintiljon'),
      237 => array('oktoseptuagintiljon'),
      240 => array('novemseptuagintiljon'),
      243 => array('oktogintiljon'),
      246 => array('unoktogintiljon'),
      249 => array('duooktogintiljon'),
      252 => array('treoktogintiljon'),
      255 => array('kvattuoroktogintiljon'),
      258 => array('kvinoktogintiljon'),
      261 => array('seksoktogintiljon'),
      264 => array('septoktogintiljon'),
      267 => array('oktooktogintiljon'),
      270 => array('novemoktogintiljon'),
      273 => array('nonagintiljon'),
      276 => array('unnonagintiljon'),
      279 => array('duononagintiljon'),
      282 => array('trenonagintiljon'),
      285 => array('kvattuornonagintiljon'),
      288 => array('kvinnonagintiljon'),
      291 => array('seksnonagintiljon'),
      294 => array('septennonagintiljon'),
      297 => array('oktononagintiljon'),
      300 => array('novemnonagintiljon'),
      303 => array('kentiljon'),
      309 => array('duokentiljon'),
      312 => array('trekentiljon'),
      366 => array('primo-vigesimo-kentiljon'),
      402 => array('trestrigintakentiljon'),
      603 => array('dukentiljon'),
      624 => array('septendukentiljon'),
     2421 => array('seksoktingentiljon'),
     3003 => array('milliljon'),
  3000003 => array('milli-milliljon')
        );

    /**
     * The array containing the digits (indexed by the digits themselves).
     * @var array
     * @access private
     */
    var $_digits = array(
        0 => 'null', 'üks', 'kaks', 'kolm', 'neli',
        'viis', 'kuus', 'seitse', 'kaheksa', 'üheksa'
    );

    /**
     * The word separator
     * @var string
     * @access private
     */
    var $_sep = ' ';

    // }}}
    // {{{ toWords()

    /**
     * Converts a number to its word representation
     * in Estonian language
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
     * @since  PHP 4.2.3
     */
    function toWords($num, $power = 0, $powsuffix = '') {
      $ret = '';        
      
      if (substr($num, 0, 1) == '-') {
        $ret = $this->_sep . $this->_minus;
        $num = substr($num, 1);
      }
        
      $num = trim($num);
      $num = preg_replace('/^0+/','',$num);
        
      if (strlen($num) > 3) {
          $maxp = strlen($num)-1;
          $curp = $maxp;
          for ($p = $maxp; $p > 0; --$p) { // power
            if (isset($this->_exponent[$p])) {
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
        $ret .= $this->_sep . $this->_digits[$h] . 'sada';

      }

      switch ($t) {
      case 9:
      case 8:
      case 7:
      case 6:
      case 5:
      case 4:
      case 3:
      case 2:
          $ret .= $this->_sep . $this->_digits[$t] . 'kümmend';
          break;
    
      case 1:
          switch ($d) {
          case 0:
              $ret .= $this->_sep . 'kümme';
              break;
    
          case 1:
          case 2:
          case 3:
          case 4:
          case 5:
          case 6:
          case 7:
          case 8:
          case 9:
              $ret .= $this->_sep . $this->_digits[$d] . 'teist';
              break;
          }
          break; 
      }
      if ($t != 1 && $d > 0) {
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
        $ret .= $this->_sep . $lev[0].($num != 1 && $power!= 3 ? 'it' : '');
      }
      if ($powsuffix != '')
        $ret .= $this->_sep . $powsuffix;
    
      return $ret;
    }
    // }}}
}

?>
