<?php
/*******************************************************************************
    phpSniff: HTTP_USER_AGENT Client Sniffer for PHP
	Copyright (C) 2001 Roger Raymond ~ epsilon7@users.sourceforge.net

	This library is free software; you can redistribute it and/or
    modify it under the terms of the GNU Lesser General Public
    License as published by the Free Software Foundation; either
    version 2.1 of the License, or (at your option) any later version.

    This library is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
    Lesser General Public License for more details.

    You should have received a copy of the GNU Lesser General Public
    License along with this library; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*******************************************************************************/

class phpSniff_core
{   // initialize some vars
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
	
	var $_feature_set = array(
		'html'		 =>	true,
		'images'	 =>	true,
		'frames' 	 =>	true,
		'tables'	 =>	true,
		'java'		 =>	true,
		'plugins'	 => true,
		'iframes'	 => false,
		'css2'		 =>	false,
		'css1'		 =>	false,
		'xml'		 =>	false,
		'dom'		 =>	false,
		'wml'		 =>	false,
		'hdml'		 =>	false
		);
	
	var $_quirks = array(
		'must_cache_forms'			=>	false,
		'avoid_popup_windows'		=>	false,
		'cache_ssl_downloads'		=>	false,
		'break_disposition_header'	=>	false,
		'empty_file_input_value'	=>	false,
		'scrollbar_in_way'			=>	false
		);

	var $_get_languages_ran_once = false;
	var $_browser_search_regex = '([a-z]+)([0-9]*)([0-9.]*)(up|dn|\+|\-)?';
	var $_language_search_regex = '([a-z-]{2,})';
	
    /**
     *  init
     *  this method starts the madness
     **/
    function init ()
    {   
        //  collect the ip
        	$this->_get_ip();
        //  run the cookie check routine first
        //  [note: method only runs if allowed]
        	$this->_test_cookies();
		//  rip the user agent to pieces
        	$this->_get_browser_info();
        //	gecko build
			$this->_get_gecko();
		//  look for other languages
        	$this->_get_languages();
		//  establish the operating platform
        	$this->_get_os_info();
		//  determine javascript version
        	$this->_get_javascript();
		//	determine current feature set
			$this->_get_features();
		//	point out any quirks
			$this->_get_quirks();
	}

    /**
     *  property
     *  @param $p property to return . optional (null returns entire array)
     *  @return array/string entire array or value of property
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
	 *	get_property
	 *	alias for property
	 **/
	function get_property ($p)
	{	return $this->property($p);
	}

    /**
     *  is
     *  @param $s string search phrase format = l:lang;b:browser
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
	 *	browser_is
	 *	@param $s string search phrase for browser
	 *  @return bool true on success
     *  ex: $client->browser_is('OP5Up');
	 **/
	function browser_is ($s)
	{	preg_match('/'.$this->_browser_search_regex.'/i',$s,$match);
		if($match) return $this->_perform_browser_search($match);
	}
	
	/**
	 *	language_is
	 *	@param $s string search phrase for language
	 *  @return bool true on success
     *  ex: $client->language_is('en-US');
	 **/
	function language_is ($s)
	{	preg_match('/'.$this->_language_search_regex.'/i',$s,$match);
		if($match) return $this->_perform_language_search($match);
	}
	
	/**
	 *	has_feature
	 *	@param $s string feature we're checking on
	 *  @return bool true on success
     *  ex: $client->has_feature('html');
	 **/
	function has_feature ($s)
	{	return $this->_feature_set[$s];
	}
	
	/**
	 *	has_quirk
	 *	@param $s string quirk we're looking for
	 *  @return bool true on success
     *  ex: $client->has_quirk('avoid_popup_windows');
	 **/
	function has_quirk ($s)
	{	return $this->_quirks[$s];
	}

    /**
     *  _perform_browser_search
     *  @param $data string what we're searching for
     *  @return bool true on success
     *  @private
     **/
    function _perform_browser_search ($data)
    {   $search = array();
		$search['phrase'] 		= isset($data[0]) ? $data[0] : '';
		$search['name']   		= isset($data[1]) ? strtolower($data[1]) : '';
		$search['maj_ver']   	= isset($data[2]) ? $data[2] : '';
		$search['min_ver']   	= isset($data[3]) ? $data[3] : '';
		$search['direction']	= isset($data[4]) ? strtolower($data[4]) : '';
		
        $looking_for = $search['maj_ver'].$search['min_ver'];
        if($search['name'] == 'aol' || $search['name'] == 'webtv')
        {   return stristr($this->_browser_info['ua'],$search['name']);
        }
        elseif($this->_browser_info['browser'] == $search['name'])
        {   $majv = $search['maj_ver'] ? $this->_browser_info['maj_ver'] : '';
            $minv = $search['min_ver'] ? $this->_browser_info['min_ver'] : '';
            $what_we_are = $majv.$minv;
            if(($search['direction'] == 'up' || $search['direction'] == '+') 
               && ($what_we_are >= $looking_for))
            {   return true;
            }
			elseif(($search['direction'] == 'dn' || $search['direction'] == '-')
                   && ($what_we_are <= $looking_for))
			{	return true;
			}
            elseif($what_we_are == $looking_for)
            {   return true;
            }
        }
		return false;
    }

    function _perform_language_search ($data)
    {   // if we've not grabbed the languages, then do so.
        $this->_get_languages();
        return stristr($this->_browser_info['language'],$data[1]);
    }

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

    function _get_browser_info ()
    {   $this->_build_regex();
        if(preg_match_all($this->_browser_regex,$this->_browser_info['ua'],$results))
        {   // get the position of the last browser found
            $count = count($results[0])-1;
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

    function _get_ip ()
    {   if(getenv('HTTP_CLIENT_IP'))
        {   $ip = getenv('HTTP_CLIENT_IP');
        }
        else
        {   $ip = getenv('REMOTE_ADDR');
        }
        $this->_set_browser('ip',$ip);
    }

    function _build_regex ()
    {   $browsers = '';
        while(list($k,) = each($this->_browsers))
        {   if(!empty($browsers)) $browsers .= "|";
            $browsers .= $k;
        }
        $version_string = "[\/\sa-z(]*([0-9]+)([\.0-9a-z]+)?";
        $this->_browser_regex = "/($browsers)$version_string/i";
    }

    function _get_short_name ($long_name)
    {   return $this->_browsers[strtolower($long_name)];
    }

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
                fclose($fp);
                setcookie('phpSniff_session','ss',0,'/');
                setcookie('phpSniff_stored','st',time()+3600*24*365,'/');
                $QS=getenv('QUERY_STRING');
                $script_path=getenv('PATH_INFO')?getenv('PATH_INFO'):getenv('SCRIPT_NAME');
                if(is_integer($pos=strpos(strrev($script_path),"php.xedni/"))&&!$pos) {
                    $script_path=strrev(substr(strrev($script_path),9));
                }
                $location='http://'.getenv('SERVER_NAME').$script_path.($QS==''?'':'?'.$QS);
                header("Location: $location");
                exit;
            }
            else
            {   unlink($this->_temp_file_path.$this->property('ip'));
                fclose($fp);
                $this->_set_browser('ss_cookies',isset($cookies['phpSniff_session'])?'true':'false');
                $this->_set_browser('st_cookies',isset($cookies['phpSniff_stored'])?'true':'false');
                // delete the old cookies
                setcookie('phpSniff_session','',0,'/');
                setcookie('phpSniff_stored','',0,'/');
                
            }
        }
    }

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
	
	function _get_features ()
	{	while(list($feature,$browser) = each($this->_browser_features))
		{	$browser = explode(',',$browser);
			while(list(,$search) = each($browser))
			{	if($this->browser_is($search))
				{	$this->_set_feature($feature);
					break;
				}
			}
		}
	}
	
	function _get_quirks ()
	{	while(list($quirk,$browser) = each($this->_browser_quirks))
		{	$browser = explode(',',$browser);
			while(list(,$search) = each($browser))
			{	if($this->browser_is($search))
				{	$this->_set_quirk($quirk);
					break;
				}
			}
		}		
	}
	
    function _get_gecko ()
	{	if(preg_match('/gecko\/([0-9]+)/i',$this->property('ua'),$match))
		{	$this->_set_browser('gecko',$match[1]);
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
	
	function _set_browser ($k,$v)
    {   $this->_browser_info[strtolower($k)] = strtolower($v);
    }
	
	function _set_feature ($k)
    {   $this->_feature_set[strtolower($k)] = !$this->_feature_set[strtolower($k)];
    }
	
	function _set_quirk ($k)
    {   $this->_quirks[strtolower($k)] = true;
    }
}
?>