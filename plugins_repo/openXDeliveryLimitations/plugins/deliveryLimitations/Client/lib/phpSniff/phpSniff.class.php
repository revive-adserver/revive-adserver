<?php
/**
*  PHP Client Sniffer (phpsniff)
*
*  This library is free software; you can redistribute it and/or
*  modify it under the terms of the GNU Lesser General Public
*  License as published by the Free Software Foundation; either
*  version 2.1 of the License, or (at your option) any later version.
*  
*  This library is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
*  Lesser General Public License for more details.
*  
*  You should have received a copy of the GNU Lesser General Public
*  License along with this library; if not, write to the Free Software
*  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*
*  @author Roger Raymond <epsilon7@users.sourceforge.net>
*  @version $Id$
*  @copyright Copyright &copy; 2002-2004 Roger Raymond
*  @package phpSniff
*  @license http://opensource.org/licenses/lgpl-license.php GNU Lesser General Public License
*  @filesource
*/
/**
*  PHP Sniffer Class
*
*  Used to determine the browser and other associated properies
*  using nothing other than the HTTP_USER_AGENT value supplied by a
*  user's web browser.
*
*  @package phpSniff
*  @access public
*  @author Roger Raymond <epsilon7@users.sourceforge.net>
*/
class phpSniff
{   

    /**
     * @access private
     * @var string
     */
    var $_version = '2.1.4';
    
    /**
     *  $_temp_file_path
     *      default : /tmp/
     *      desc    : directory writable by the server to store cookie check files.
     *              : trailing slash is needed. only used if you use the check cookie routine
     *
     *  @access public
     *  @var string
     */
    var $_temp_file_path        = '/tmp/'; // with trailing slash
    
    /**
     *  $_check_cookies
     *      default : null
     *      desc    : Allow for the script to redirect the browser in order
     *              : to check for cookies.   In order for this to work, this
     *              : class must be instantiated before any headers are sent.
     *
     *  @access public
     *  @var string
     */
    var $_check_cookies         = NULL;
    
    /**
     *  $_default_language
     *      default : en-us
     *      desc    : language to report as if no languages are found
     *  @access public
     *  @var string
     */
    var $_default_language      = 'en-us';
    
    /**
     *  default : null
     *  Allow for browser to Masquerade as another. (ie: Opera identifies as MSIE 5.0)
     *
     *  @access public
     *  @var string
     */
    var $_allow_masquerading    = NULL;
    
    /**
     *  @access private
     *  @var string
     */
    var $_php_version           = '';
    
    
    /**
     *  2D Array of browsers we wish to search for in key => value pairs.
     *  <pre>
     *  key   = browser to search for [as in HTTP_USER_AGENT]
     *  value = value to return as 'browser' property
     *  </pre>
     *
     *  @access public
     *  @var array
     */
    var $_browsers = array(
        'microsoft internet explorer' => 'IE',
        'msie'                        => 'IE',
        'netscape6'                   => 'NS',
        'netscape'                    => 'NS',
        'galeon'                      => 'GA',
        'phoenix'                     => 'PX',
        'mozilla firebird'            => 'FB',
        'firebird'                    => 'FB',
        'firefox'                     => 'FX',
        'chimera'                     => 'CH',
        'camino'                      => 'CA',
        'epiphany'                    => 'EP',
        'safari'                      => 'SF',
        'k-meleon'                    => 'KM',
        'mozilla'                     => 'MZ',
        'opera'                       => 'OP',
        'konqueror'                   => 'KQ',
        'icab'                        => 'IC',
        'lynx'                        => 'LX',
        'links'                       => 'LI',                    
        'ncsa mosaic'                 => 'MO',
        'amaya'                       => 'AM',
        'omniweb'                     => 'OW',
        'hotjava'                      => 'HJ',
        'browsex'                     => 'BX',
        'amigavoyager'                => 'AV',
        'amiga-aweb'                  => 'AW',
        'ibrowse'                     => 'IB',
        'chrome'                      => 'GC',
        );

    /**
     *  $_javascript_versions
     *      desc    : 2D Array of javascript version supported by which browser
     *              : in key => value pairs.
     *              : key   = javascript version
     *              : value = search parameter for browsers that support the
     *              :         javascript version listed in the key (comma delimited)
     *              :         note: the search parameters rely on the values
     *              :               set in the $_browsers array
     *  @access public
     *  @var array
     */
    var $_javascript_versions = array(
        '1.5'   =>  'NS5+,MZ,PX,FB,FX,GA,CH,CA,SF,KQ3+,KM,EP', // browsers that support JavaScript 1.5
        '1.4'   =>  '',
        '1.3'   =>  'NS4.05+,OP5+,IE5+',
        '1.2'   =>  'NS4+,IE4+',
        '1.1'   =>  'NS3+,OP,KQ',
        '1.0'   =>  'NS2+,IE3+',
        '0'     =>    'LI,LX,HJ'    
        );
    
    /**
     *  $_browser_features
     *      desc    : 2D Array of browser features supported by which browser
     *              : in key => value pairs.
     *              : key   = feature
     *              : value = search parameter for browsers that support the
     *              :         feature listed in the key (comma delimited)
     *              :         note: the search parameters rely on the values
     *              :               set in the $_browsers array
     *  @access public
     *  @var string
     */    
    var $_browser_features = array(
        /**
         *    the following are true by default
         *    (see phpSniff.core.php $_feature_set array)
         *    browsers listed here will be set to false
         **/
        'html'        =>    '',
        'images'    =>    'LI,LX',
        'frames'     =>    'LX',
        'tables'    =>    '',
        'java'        =>    'OP3,LI,LX,NS1,MO,IE1,IE2',
        'plugins'    =>    'IE1,IE2,LI,LX',
        /**  
         *    the following are false by default
         *    (see phpSniff.core.php $_feature_set array)
         *    browsers listed here will be set to true
         **/
        'css2'        =>    'NS5+,IE5+,MZ,PX,FB,FX,CH,CA,SF,GA,KQ3+,OP7+,KM,EP',
        'css1'        =>    'NS4+,IE4+,MZ,PX,FB,FX,CH,CA,SF,GA,KQ,OP7+,KM,EP',
        'iframes'    =>    'LI,IE3+,NS5+,MZ,PX,FB,FX,CH,CA,SF,GA,KQ,OP7+,KM,EP',
        'xml'        =>    'IE5+,NS5+,MZ,PX,FB,FX,CH,CA,SF,GA,KQ,OP7+,KM,EP',
        'dom'        =>    'IE5+,NS5+,MZ,PX,FB,FX,CH,CA,SF,GA,KQ,OP7+,KM,EP',
        'hdml'        =>    '',
        'wml'        =>    ''
        );
    
    /**
     *
     *  $_browser_quirks
     *      desc    : 2D Array of browser quirks present in which browser
     *              : in key => value pairs.
     *              : key   = quirk
     *              : value = search parameter for browsers that feature the
     *              :         quirk listed in the key (comma delimited)
     *              :         note: the search parameters rely on the values
     *              :               set in the $_browsers array
     *  @access public
     *  @var string
     */    
    var $_browser_quirks = array(
        'must_cache_forms'            =>    'NS,MZ,FB,PX,FX',
        'avoid_popup_windows'        =>    'IE3,LI,LX',
        'cache_ssl_downloads'        =>    'IE',
        'break_disposition_header'    =>    'IE5.5',
        'empty_file_input_value'    =>    'KQ',
        'scrollbar_in_way'            =>    'IE6'
        );

    /**
     *  @access private
     *  @var array
     */
    var $_browser_info = array(
        'ua'         => '',
        'browser'    => 'Unknown',
        'version'    => 0,
        'maj_ver'    => 0,
        'min_ver'    => 0,
        'letter_ver' => '',
        'javascript' => '0.0',
        'platform'   => 'Unknown',
        'os'         => 'Unknown',
        'ip'         => 'Unknown',
        'cookies'    => 'Unknown', // remains for backwards compatability
        'ss_cookies' => 'Unknown',
        'st_cookies' => 'Unknown',
        'language'   => '',
        'long_name'  => '',
        'gecko'      => '',
        'gecko_ver'  => ''
        );
    
    /**
     *  @access private
     *  @var array
     */
    var $_feature_set = array(
        'html'         =>    true,
        'images'     =>    true,
        'frames'      =>    true,
        'tables'     =>    true,
        'java'         =>    true,
        'plugins'     => true,
        'iframes'     => false,
        'css2'         =>    false,
        'css1'         =>    false,
        'xml'         =>    false,
        'dom'         =>    false,
        'wml'         =>    false,
        'hdml'         =>    false
        );
    
    /**
     *  @access private
     *  @var array
     */
    var $_quirks = array(
        'must_cache_forms'            =>    false,
        'avoid_popup_windows'        =>    false,
        'cache_ssl_downloads'        =>    false,
        'break_disposition_header'    =>    false,
        'empty_file_input_value'    =>    false,
        'scrollbar_in_way'            =>    false
        );

    /**
     *  @access private
     *  @var boolean
     */
    var $_get_languages_ran_once = false;
    /**
     *  @access private
     *  @var string
     */
    var $_browser_search_regex = '([a-z]+)([0-9]*)([0-9.]*)(up|dn|\+|\-)?';
    /**
     *  @access private
     *  @var string
     */
    var $_language_search_regex = '([a-z-]{2,})';
    /**
     *  @access private
     *  @var string
     */
    var $_browser_regex;

    /**
     *  Performs some basic initialization and returns and object
     *  @param string User Agent to parse
     *  @param mixed array of settings
     *          [check_cookies, default_language, allow_masqeurading]
     *
     *  @return object phpSniff object
     */
    
    function phpSniff($UA='',$settings = true)
    {   //  populate the HTTP_USER_AGENT string
        //  20020425 :: rraymond
        //      routine for easier configuration of the client at runtime
        if(is_array($settings)) {
            $run = true;
            extract($settings);
            $this->_check_cookies = $check_cookies;
            $this->_default_language = $default_language;
            $this->_allow_masquerading = $allow_masquerading;
        } else {
            // for backwards compatibility with 2.0.x series
            $run = (bool) $settings;
        }
        
        // if the user agent is empty, see if it exists somewhere
        if(empty($UA)) {
            if(isset($HTTP_SERVER_VARS['HTTP_USER_AGENT'])) {
                $UA = $HTTP_SERVER_VARS['HTTP_USER_AGENT'];
            } elseif(isset($_SERVER['HTTP_USER_AGENT'])) {
                $UA = $_SERVER['HTTP_USER_AGENT'];
            } else {
                // try to use the getenv function as a last resort
                $UA = getenv('HTTP_USER_AGENT');
            }
        }
        
        // if it's still empty, just return false as there is nothing to do
        if(empty($UA)) return false;
        
        $this->_set_browser('ua',$UA);
        if($run) $this->init();
    }

    function init ()
    {   
        //  collect the ip
            $this->_get_ip();
        //  run the cookie check routine first
        //  [note: method only runs if allowed]
            $this->_test_cookies();
        //  rip the user agent to pieces
            $this->_get_browser_info();
        //    gecko build
            $this->_get_gecko();
        //  look for other languages
            $this->_get_languages();
        //  establish the operating platform
            $this->_get_os_info();
        //  determine javascript version
            $this->_get_javascript();
        //    determine current feature set
            $this->_get_features();
        //    point out any quirks
            $this->_get_quirks();
    }

    /**
     *  turn the cookie check routine on or off
     *  @param bool true or false    
     */
    function check_cookies($yn)
    {
        $this->_check_cookies = (bool) $yn;
    }
    
    /**
     *  allow browser masquerading
     *  @param bool true or false    
     */
    function allow_masquerading($yn)
    {
        $this->_allow_masquerading = (bool) $yn;
    }
    
    /**
     *  set the default browser language
     *  @param string valid language (ex: en-us)    
     */
    function default_language($language)
    {
        $this->_default_language = $language;
    }
    
    /**
     *  property
     *  @param string property to return . optional (null returns entire array)
     *  @return mixed array/string entire array or value of property
     **/
    function property ($p=null)
    {   if($p==null)
        {   return $this->_browser_info;
        }
        else
        {   return $this->_browser_info[strtolower($p)];
        }
    }
    
    /**
     *  get_property is an alias for property
     *  @param string property to return . optional (null returns entire array)
     *  @return mixed array/string entire array or value of property
     **/
    function get_property ($p)
    {    return $this->property($p);
    }

    /**
     *  is
     *  @param string search phrase format = l:lang;b:browser
     *  @return bool true on success
     *  ex: $client->is('b:OP5Up');
     **/
    function is ($s)
    {   // perform language search
        if(preg_match('/l:'.$this->_language_search_regex.'/i',$s,$match))
        {   if($match) return $this->_perform_language_search($match);
        }
        // perform browser search
        elseif(preg_match('/b:'.$this->_browser_search_regex.'/i',$s,$match))
        {   if($match) return $this->_perform_browser_search($match);
        }
        return false;
    }
    
    /**
     *    browser_is
     *    @param string search phrase for browser
     *  @return bool true on success
     *  ex: $client->browser_is('OP5Up');
     **/
    function browser_is ($s)
    {    preg_match('/'.$this->_browser_search_regex.'/i',$s,$match);
        if($match) return $this->_perform_browser_search($match);
    }
    
    /**
     *    language_is
     *    @param string search phrase for language
     *  @return bool true on success
     *  ex: $client->language_is('en-US');
     **/
    function language_is ($s)
    {    preg_match('/'.$this->_language_search_regex.'/i',$s,$match);
        if($match) return $this->_perform_language_search($match);
    }
    
    /**
     *    checks to see if the browser supports any of the following features:
     *  <ul>
     *      <li>html
     *      <li>images
     *      <li>frames
     *      <li>tables
     *      <li>plugins
     *      <li>iframes
     *      <li>css2
     *      <li>css1
     *      <li>xml
     *      <li>dom
     *      <li>wml
     *      <li>hdml
     *  </ul>
     *  <code>ex: $client->has_feature('html');</code>
     *    @param string feature we're checking on
     *  @return bool true on success
     
     **/
    function has_feature ($s)
    {    return $this->_feature_set[$s];
    }
    
    /**
     *    checks to see if the browser has any of the following quirks:
     *  <ul>
     *      <li>must_cache_forms
     *      <li>avoid_popup_windows
     *      <li>cache_ssl_downloads
     *      <li>break_disposition_header
     *      <li>empty_file_input_value
     *      <li>scrollbar_in_way
     *  </ul>
     *  <code>ex: $client->has_quirk('avoid_popup_windows');</code>
     *    @param string quirk we're looking for
     *  @return bool true on success
     **/
    function has_quirk ($s)
    {    return $this->_quirks[$s];
    }

    /**
     *  _perform_browser_search
     *  @param string what we're searching for
     *  @return bool true on success
     *  @access private
     **/
    function _perform_browser_search ($data)
    {   $search = array();
        $search['phrase']         = isset($data[0]) ? $data[0] : '';
        $search['name']           = isset($data[1]) ? strtolower($data[1]) : '';
        $search['maj_ver']       = isset($data[2]) ? $data[2] : '';
        $search['min_ver']       = isset($data[3]) ? $data[3] : '';
        $search['direction']    = isset($data[4]) ? strtolower($data[4]) : '';
        
        $looking_for = $search['maj_ver'].$search['min_ver'];
        if($search['name'] == 'aol' || $search['name'] == 'webtv') {   
            return stristr($this->_browser_info['ua'],$search['name']);
        } elseif($this->_browser_info['browser'] == $search['name'] || $search['name'] == 'gecko') {   
            if(strtolower($search['name']) == 'gecko') {
                $what_we_are =& $this->_browser_info['gecko_ver'];
            } else {
                $majv = $search['maj_ver'] ? $this->_browser_info['maj_ver'] : '';
                $minv = $search['min_ver'] ? $this->_browser_info['min_ver'] : '';
                $what_we_are = $majv.$minv;
            }
            if(($search['direction'] == 'up' || $search['direction'] == '+')
               && ($what_we_are >= $looking_for))
            {   return true;
            }
            elseif(($search['direction'] == 'dn' || $search['direction'] == '-')
                   && ($what_we_are <= $looking_for))
            {    return true;
            }
            elseif($what_we_are == $looking_for)
            {   return true;
            }
        }
        return false;
    }

    /**
     *  @access private
     */
    function _perform_language_search ($data)
    {   // if we've not grabbed the languages, then do so.
        $this->_get_languages();
        return stristr($this->_browser_info['language'],$data[1]);
    }

    /**
     *  @access private
     */
    function _get_languages ()
    {   // capture available languages and insert into container
        if(!$this->_get_languages_ran_once)
        {   if($languages = getenv('HTTP_ACCEPT_LANGUAGE'))
            {   $languages = preg_replace('/(;q=[0-9]+.[0-9]+)/i','',$languages);
            }
            else
            {   $languages = $this->_default_language;
            }
            $this->_set_browser('language',$languages);
            $this->_get_languages_ran_once = true;
        }
    }

    /**
     *  @access private
     */
    function _get_os_info ()
    {   // regexes to use
        $regex_windows  = '/([^dar]win[dows]*)[\s]?([0-9a-z]*)[\w\s]?([a-z0-9.]*)/i';
        $regex_mac      = '/(68[k0]{1,3})|(ppc mac os x)|([p\S]{1,5}pc)|(darwin)/i';
        $regex_os2      = '/os\/2|ibm-webexplorer/i';
        $regex_sunos    = '/(sun|i86)[os\s]*([0-9]*)/i';
        $regex_irix     = '/(irix)[\s]*([0-9]*)/i';
        $regex_hpux     = '/(hp-ux)[\s]*([0-9]*)/i';
        $regex_aix      = '/aix([0-9]*)/i';
        $regex_dec      = '/dec|osfl|alphaserver|ultrix|alphastation/i';
        $regex_vms      = '/vax|openvms/i';
        $regex_sco      = '/sco|unix_sv/i';
        $regex_linux    = '/x11|inux/i';
        $regex_bsd      = '/(free)?(bsd)/i';
        $regex_amiga    = '/amiga[os]?/i';

        // look for Windows Box
        if(preg_match_all($regex_windows,$this->_browser_info['ua'],$match))
        {   /** Windows has some of the most ridiculous HTTP_USER_AGENT strings */
            //$match[1][count($match[0])-1];
            $v  = $match[2][count($match[0])-1];
            $v2 = $match[3][count($match[0])-1];
            // Establish NT 5.1 as Windows XP
                if(stristr($v,'NT') && $v2 == 5.1) $v = 'xp';
            // Establish NT 6.1 as7
                elseif(stristr($v,'NT') && $v2 == 6.1) $v = 'w7';
            // Establish NT 5.0 and Windows 2000 as win2k
                elseif($v == '2000') $v = '2k';
                elseif(stristr($v,'NT') && $v2 == 5.0) $v = '2k';
            // Establish 9x 4.90 as Windows 98
                elseif(stristr($v,'9x') && $v2 == 4.9) $v = '98';
            // See if we're running windows 3.1
                elseif($v.$v2 == '16bit') $v = '31';
            // otherwise display as is (31,95,98,NT,ME,XP)
                else $v .= $v2;
            // update browser info container array
            if(empty($v)) $v = 'win';
            $this->_set_browser('os',strtolower($v));
            $this->_set_browser('platform','win');
        }
        //  look for amiga OS
        elseif(preg_match($regex_amiga,$this->_browser_info['ua'],$match))
        {   $this->_set_browser('platform','amiga');
            if(stristr($this->_browser_info['ua'],'morphos')) {
                // checking for MorphOS
                $this->_set_browser('os','morphos');
            } elseif(stristr($this->_browser_info['ua'],'mc680x0')) {
                // checking for MC680x0
                $this->_set_browser('os','mc680x0');
            } elseif(stristr($this->_browser_info['ua'],'ppc')) {
                // checking for PPC
                $this->_set_browser('os','ppc');
            } elseif(preg_match('/(AmigaOS [\.1-9]?)/i',$this->_browser_info['ua'],$match)) {
                // checking for AmigaOS version string
                $this->_set_browser('os',$match[1]);
            }
        }
        // look for OS2
        elseif( preg_match($regex_os2,$this->_browser_info['ua']))
        {   $this->_set_browser('os','os2');
            $this->_set_browser('platform','os2');
        }
        // look for mac
        // sets: platform = mac ; os = 68k or ppc
        elseif( preg_match($regex_mac,$this->_browser_info['ua'],$match) )
        {   $this->_set_browser('platform','mac');
            $os = !empty($match[1]) ? '68k' : '';
            $os = !empty($match[2]) ? 'osx' : $os;
            $os = !empty($match[3]) ? 'ppc' : $os;
            $os = !empty($match[4]) ? 'osx' : $os;
            $this->_set_browser('os',$os);
        }
        //  look for *nix boxes
        //  sunos sets: platform = *nix ; os = sun|sun4|sun5|suni86
        elseif(preg_match($regex_sunos,$this->_browser_info['ua'],$match))
        {   $this->_set_browser('platform','*nix');
            if(!stristr('sun',$match[1])) $match[1] = 'sun'.$match[1];
            $this->_set_browser('os',$match[1].$match[2]);
        }
        //  irix sets: platform = *nix ; os = irix|irix5|irix6|...
        elseif(preg_match($regex_irix,$this->_browser_info['ua'],$match))
        {   $this->_set_browser('platform','*nix');
            $this->_set_browser('os',$match[1].$match[2]);
        }
        //  hp-ux sets: platform = *nix ; os = hpux9|hpux10|...
        elseif(preg_match($regex_hpux,$this->_browser_info['ua'],$match))
        {   $this->_set_browser('platform','*nix');
            $match[1] = str_replace('-','',$match[1]);
            $match[2] = (int) $match[2];
            $this->_set_browser('os',$match[1].$match[2]);
        }
        //  aix sets: platform = *nix ; os = aix|aix1|aix2|aix3|...
        elseif(preg_match($regex_aix,$this->_browser_info['ua'],$match))
        {   $this->_set_browser('platform','*nix');
            $this->_set_browser('os','aix'.$match[1]);
        }
        //  dec sets: platform = *nix ; os = dec
        elseif(preg_match($regex_dec,$this->_browser_info['ua'],$match))
        {   $this->_set_browser('platform','*nix');
            $this->_set_browser('os','dec');
        }
        //  vms sets: platform = *nix ; os = vms
        elseif(preg_match($regex_vms,$this->_browser_info['ua'],$match))
        {   $this->_set_browser('platform','*nix');
            $this->_set_browser('os','vms');
        }
        //  sco sets: platform = *nix ; os = sco
        elseif(preg_match($regex_sco,$this->_browser_info['ua'],$match))
        {   $this->_set_browser('platform','*nix');
            $this->_set_browser('os','sco');
        }
        //  unixware sets: platform = *nix ; os = unixware
        elseif(stristr($this->_browser_info['ua'],'unix_system_v'))
        {   $this->_set_browser('platform','*nix');
            $this->_set_browser('os','unixware');
        }
        //  mpras sets: platform = *nix ; os = mpras
        elseif(stristr($this->_browser_info['ua'],'ncr'))
        {   $this->_set_browser('platform','*nix');
            $this->_set_browser('os','mpras');
        }
        //  reliant sets: platform = *nix ; os = reliant
        elseif(stristr($this->_browser_info['ua'],'reliantunix'))
        {   $this->_set_browser('platform','*nix');
            $this->_set_browser('os','reliant');
        }
        //  sinix sets: platform = *nix ; os = sinix
        elseif(stristr($this->_browser_info['ua'],'sinix'))
        {   $this->_set_browser('platform','*nix');
            $this->_set_browser('os','sinix');
        }
        //  bsd sets: platform = *nix ; os = bsd|freebsd
        elseif(preg_match($regex_bsd,$this->_browser_info['ua'],$match))
        {   $this->_set_browser('platform','*nix');
            $this->_set_browser('os',$match[1].$match[2]);
        }
        //  last one to look for
        //  linux sets: platform = *nix ; os = linux
        elseif(preg_match($regex_linux,$this->_browser_info['ua'],$match))
        {   $this->_set_browser('platform','*nix');
            $this->_set_browser('os','linux');
        }
    }

    /**
     *  @access private
     */
    function _get_browser_info ()
    {   $this->_build_regex();
        if(preg_match_all($this->_browser_regex,$this->_browser_info['ua'],$results))
        {   // get the position of the last browser found
            $count = count($results[0])-1;
            
            //special case for Chrome (UA=mozilla/5.0 (windows; u; windows nt 5.1; en-us) applewebkit/532.5 (khtml, like gecko) chrome/4.0.249.89 safari/532.5)
            if($results[1][$count]=='safari' && $results[1][$count-1]=='chrome') {
                $count--;
            }
            // if we're allowing masquerading, revert to the next to last browser found
            // if possible, otherwise stay put
            if($this->_allow_masquerading && $count > 0) $count--;
            // insert findings into the container
            $this->_set_browser('browser',$this->_get_short_name($results[1][$count]));
            $this->_set_browser('long_name',$results[1][$count]);
            $this->_set_browser('maj_ver',$results[2][$count]);
            // parse the minor version string and look for alpha chars
            preg_match('/([.\0-9]+)?([\.a-z0-9]+)?/i',$results[3][$count],$match);
            if(isset($match[1])) {
                $this->_set_browser('min_ver',$match[1]);
            } else {
                $this->_set_browser('min_ver','.0');
            }
            if(isset($match[2])) $this->_set_browser('letter_ver',$match[2]);
            // insert findings into container
            $this->_set_browser('version',$this->_browser_info['maj_ver'].$this->property('min_ver'));
        }
    }

    /**
     *  @access private
     */
    function _get_ip ()
    {   if(getenv('HTTP_CLIENT_IP'))
        {   $ip = getenv('HTTP_CLIENT_IP');
        }
        else
        {   $ip = getenv('REMOTE_ADDR');
        }
        $this->_set_browser('ip',$ip);
    }

    /**
     *  @access private
     */
    function _build_regex ()
    {   $browsers = '';
        while(list($k,) = each($this->_browsers))
        {   if(!empty($browsers)) $browsers .= "|";
            $browsers .= $k;
        }
        $version_string = "[\/\sa-z(]*([0-9]+)([\.0-9a-z]+)?";
        $this->_browser_regex = "/($browsers)$version_string/i";
    }

    /**
     *  @access private
     */
    function _get_short_name ($long_name)
    {   return $this->_browsers[strtolower($long_name)];
    }

    /**
     *  @access private
     */
    // medianes :: new test cookie routine
    function _test_cookies()
    {   global $HTTP_COOKIE_VARS;
        $cookies = array();
        if(isset($_COOKIE)) {
            $cookies = $_COOKIE;
        } elseif(isset($HTTP_COOKIE_VARS)) {
            $cookies = $HTTP_COOKIE_VARS;
        }
        if($this->_check_cookies)
        {   $fp = @fopen($this->_temp_file_path.$this->property('ip'),'r');
            if(!$fp)
            {   $fp = @fopen($this->_temp_file_path.$this->property('ip'),'a');
                // make sure we have a valid file pointer
                if($fp) {
                    fclose($fp);
                    setcookie('phpSniff_session','ss',0,'/');
                    setcookie('phpSniff_stored','st',time()+3600*24*365,'/');
                    $QS=getenv('QUERY_STRING');
                    $script_path=getenv('PATH_INFO')?getenv('PATH_INFO'):getenv('SCRIPT_NAME');
                    if(is_integer($pos=strpos(strrev($script_path),"php.xedni/"))&&!$pos) {
                        $script_path=strrev(substr(strrev($script_path),9));
                    }
                }
                $location='http://'.getenv('SERVER_NAME').$script_path.($QS==''?'':'?'.$QS);
                header("Location: $location");
                exit;
            } elseif($fp) {   
                // we only want to proceed if we have a file pointer
                unlink($this->_temp_file_path.$this->property('ip'));
                fclose($fp);
                $this->_set_browser('ss_cookies',isset($cookies['phpSniff_session'])?'true':'false');
                $this->_set_browser('st_cookies',isset($cookies['phpSniff_stored'])?'true':'false');
                // delete the old cookies
                setcookie('phpSniff_session','',0,'/');
                setcookie('phpSniff_stored','',0,'/');
            }
        }
    }

    /**
     *  @access private
     */
    function _get_javascript()
    {   $set=false;
        // see if we have any matches
        while(list($version,$browser) = each($this->_javascript_versions))
        {   $browser = explode(',',$browser);
            while(list(,$search) = each($browser))
            {   if($this->is('b:'.$search))
                {   $this->_set_browser('javascript',$version);
                    $set = true;
                    break;
                }
            }
        if($set) break;
        }
    }
    
    /**
     *  @access private
     */
    function _get_features ()
    {    while(list($feature,$browser) = each($this->_browser_features))
        {    $browser = explode(',',$browser);
            while(list(,$search) = each($browser))
            {    if($this->browser_is($search))
                {    $this->_set_feature($feature);
                    break;
                }
            }
        }
    }
    
    /**
     *  @access private
     */
    function _get_quirks ()
    {    while(list($quirk,$browser) = each($this->_browser_quirks))
        {    $browser = explode(',',$browser);
            while(list(,$search) = each($browser))
            {    if($this->browser_is($search))
                {    $this->_set_quirk($quirk);
                    break;
                }
            }
        }        
    }
    
    /**
     *  @access private
     */
    function _get_gecko ()
    {    if(preg_match('/gecko\/([0-9]+)/i',$this->property('ua'),$match))
        {    $this->_set_browser('gecko',$match[1]);
            if (preg_match('/rv[: ]?([0-9a-z.+]+)/i',$this->property('ua'),$mozv)) {   
                // mozilla release
                $this->_set_browser('gecko_ver',$mozv[1]);
            } elseif (preg_match('/(m[0-9]+)/i',$this->property('ua'),$mozv)) {   
                // mozilla milestone version
                $this->_set_browser('gecko_ver',$mozv[1]);
            }
            // if this is a mozilla browser, get the rv: information
            if($this->browser_is($this->_get_short_name('mozilla'))) {
                if(preg_match('/([0-9]+)([\.0-9]+)([a-z0-9+]?)/i',$mozv[1],$match)) {
                    $this->_set_browser('version',$mozv[1]);
                    $this->_set_browser('maj_ver',$match[1]);
                    $this->_set_browser('min_ver',$match[2]);
                    $this->_set_browser('letter_ver',$match[3]);
                }
            }
        } elseif($this->is('b:'.$this->_get_short_name('mozilla'))) {
            // this is probably a netscape browser or compatible
            $this->_set_browser('long_name','netscape');
            $this->_set_browser('browser',$this->_get_short_name('netscape'));
        }
    }
    
    /**
     *  @access private
     */
    function _set_browser ($k,$v)
    {   $this->_browser_info[strtolower($k)] = strtolower($v);
    }
    
    /**
     *  @access private
     */
    function _set_feature ($k)
    {   $this->_feature_set[strtolower($k)] = !$this->_feature_set[strtolower($k)];
    }
    
    /**
     *  @access private
     */
    function _set_quirk ($k)
    {   $this->_quirks[strtolower($k)] = true;
    }
}
?>