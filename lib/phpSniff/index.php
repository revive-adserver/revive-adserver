<?php
error_reporting(E_ALL);
/*******************************************************************************
	$Id$
    
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

require_once('phpSniff.class.php');
require_once('phpTimer.class.php');

//echo '<pre>';
//print_r($_COOKIE);
//echo '</pre>';

// initialize some vars
$GET_VARS = isset($_GET) ? $_GET : $HTTP_GET_VARS;
$POST_VARS = isset($_POST) ? $_GET : $HTTP_POST_VARS;
if(!isset($GET_VARS['UA'])) $GET_VARS['UA'] = '';
if(!isset($GET_VARS['cc'])) $GET_VARS['cc'] = '';
if(!isset($GET_VARS['dl'])) $GET_VARS['dl'] = '';
if(!isset($GET_VARS['am'])) $GET_VARS['am'] = '';

$timer =& new phpTimer();
$timer->start('main');
$timer->start('client1');
$sniffer_settings = array('check_cookies'=>$GET_VARS['cc'],
                          'default_language'=>$GET_VARS['dl'],
                          'allow_masquerading'=>$GET_VARS['am']);
$client =& new phpSniff($GET_VARS['UA'],$sniffer_settings);

$timer->stop('client1');

$c1_bg = '#cccccc';
$c2_bg = '#ffffff';
$c3_bg = '#000000';

function makeSelectOption ($link,$text)
{   global $client;
    $o  = "<option value=\"$link\"";
    $o .= $client->property('ua') == strtolower($link) ? ' selected' : '';
    $o .= ">$text</option>";
    print $o;
}

function example ($search,$output)
{   global $c2_bg, $c1_bg, $client;
    ?>
    <tr>
        <td bgcolor="<?php print $c1_bg; ?>"><?php print $search; ?></td>
        <td width="100%" bgcolor="<?php print $c2_bg; ?>"><?php print $output ? 'true' : 'false'; ?></td>
    </tr>
    <?php
}

function is ($search)
{	global $client;
	example($search,$client->is($search));
}
function language_is ($search)
{   global $client;
	example($search,$client->language_is($search));
}

function browser_is ($search)
{   global $client;
	example($search,$client->browser_is($search));
}

function has_feature ($feature)
{   global $client;
	example($feature,$client->has_feature($feature));
}

function has_quirk ($quirk)
{   global $client;
	example($quirk,$client->has_quirk($quirk));
}

?>
<html>
<head>
<title>phpSniff <?php print $client->_version; ?> on SourceForge</title>
<style type="text/css">
INPUT, SELECT {
    background-color: #c8c8c8;
    font-family: monospace;
    font-size: 10px;
}
BODY {
    background-color: #ffffff;
    font-family: sans-serif;
    font-size: 10px;
}
TD {
    font-family: sans-serif;
    font-size: 10px;
}
</style>
</head>
<body marginwidth="0" marginheight="0" topmargin="0" leftmargin="0">
<?php
//  fix for cgi versions of php ~ 6/28/2001 ~ RR
$script_path = getenv('PATH_INFO') ? getenv('PATH_INFO') : getenv('SCRIPT_NAME');
?>
<form name="user_agent_string" method="get" action="<?php print $script_path; ?>">
<p><a href="http://sourceforge.net/project/showfiles.php?group_id=26044">Download</a> |
<a href="http://sourceforge.net/projects/phpsniff/">SourceForge Project Page</a> |
<a href="index.phps">Index Source Code</a> |
<a href="phpSniff.core.phps">phpSniff.core Source Code</a> |
<a href="phpSniff.class.phps">phpSniff.class Source Code</a> |
<a href="CHANGES">CHANGE LOG</a>
</p>
<table border="0" cellpadding="3" cellspacing="0" bgcolor="<?php print $c3_bg; ?>" width="100%">
<tr>
<td align="left" valign="top" width="100%">
    <font color="#ffffff"><b>CURRENT BROWSER INFORMATION</b></font><br>
    <font color="#ffffff" size="-1">
    <?php printf('phpSniff version : %s - php version : %s</font>',$client->_version, PHP_VERSION); ?>
    </font>
</td>
<td align="right" valign="top" width="100%">
    <font color="#ffffff">
    <select name="UA">
    <?php
    makeSelectOption('','Your current browser');
    include('user_agent.inc');
    while(list(,$v) = each($user_agent))
    {   makeSelectOption($v,$v);
    }
    ?>
    </select><br>
    <input type="checkbox" name="cc" <?php if($client->_check_cookies) print 'checked'; ?> > Check For Cookies
    <input type="checkbox" name="am" <?php if($client->_allow_masquerading) print 'checked'; ?> > Allow Masquerading
    <input type="text" name="dl" size="7" value="<?php print $client->_default_language; ?>"> Default Language
    <input type="submit" name="submit" value="submit">
    </font>
</td>
</tr>
</table>

<table border="0" cellpadding="0" cellspacing="0" width="100%" bgcolor="<?php print $c3_bg; ?>"><tr>
<td align="right" valign="top">
    <table border="0" cellpadding="3" cellspacing="1" width="100%">
        <tr><td colspan="2" nowrap><font color="#ffcc00">Current Configuration</font></td></tr>
        <tr>
            <td colspan="2"bgcolor="<?php print $c1_bg; ?>"><b>regex used to search HTTP_USER_AGENT string</b><br>
            preg_match_all(&quot;<?php print $client->_browser_regex; ?>&quot;);</td>
        </tr>
        <tr>
            <td bgcolor="<?php print $c1_bg; ?>">$_check_cookies</td>
            <td width="100%" bgcolor="<?php print $c2_bg; ?>"><?php print $client->_check_cookies ? 'true' : 'false'; ?></td>
        </tr>
        <tr>
            <td bgcolor="<?php print $c1_bg; ?>">$_default_language</td>
            <td width="100%" bgcolor="<?php print $c2_bg; ?>"><?php print $client->_default_language; ?></td>
        </tr>
        <tr>
            <td bgcolor="<?php print $c1_bg; ?>">$_allow_masquerading</td>
            <td width="100%" bgcolor="<?php print $c2_bg; ?>"><?php print $client->_allow_masquerading ? 'true' : 'false'; ?></td>
        </tr>

        <tr><td colspan="2" nowrap><font color="#ffcc00">$client-&gt;property(<i>property_name</i>);</font></td></tr>
        <tr>
            <td bgcolor="<?php print $c1_bg; ?>"><b>property_name</b></td>
            <td width="100%" bgcolor="<?php print $c2_bg; ?>"><b>return value</b></td>
        </tr>
        <tr>
            <td bgcolor="<?php print $c1_bg; ?>">ua</td>
            <td width="100%" bgcolor="<?php print $c2_bg; ?>"><?php print $client->get_property('ua');?></td>
        </tr>
        <tr>
            <td bgcolor="<?php print $c1_bg; ?>">browser</td>
            <td width="100%" bgcolor="<?php print $c2_bg; ?>"><?php print $client->property('browser'); ?></td>
        </tr>
		<tr>
            <td bgcolor="<?php print $c1_bg; ?>">long_name</td>
            <td width="100%" bgcolor="<?php print $c2_bg; ?>"><?php print $client->property('long_name');?></td>
        </tr>
        <tr>
            <td bgcolor="<?php print $c1_bg; ?>">version</td>
            <td width="100%" bgcolor="<?php print $c2_bg; ?>"><?php print $client->property('version');?></td>
        </tr>
        <tr>
            <td bgcolor="<?php print $c1_bg; ?>">maj_ver</td>
            <td width="100%" bgcolor="<?php print $c2_bg; ?>"><?php print $client->property('maj_ver');?></td>
        </tr>
        <tr>
            <td bgcolor="<?php print $c1_bg; ?>">min_ver</td>
            <td width="100%" bgcolor="<?php print $c2_bg; ?>"><?php print $client->property('min_ver');?></td>
        </tr>
        <tr>
            <td bgcolor="<?php print $c1_bg; ?>">letter_ver</td>
            <td width="100%" bgcolor="<?php print $c2_bg; ?>"><?php print $client->property('letter_ver');?></td>
        </tr>
        <tr>
            <td bgcolor="<?php print $c1_bg; ?>">javascript</td>
            <td width="100%" bgcolor="<?php print $c2_bg; ?>"><?php print $client->property('javascript');?></td>
        </tr>
        <tr>
            <td bgcolor="<?php print $c1_bg; ?>">platform</td>
            <td width="100%" bgcolor="<?php print $c2_bg; ?>"><?php print $client->property('platform');?></td>
        </tr>
        <tr>
            <td bgcolor="<?php print $c1_bg; ?>">os</td>
            <td width="100%" bgcolor="<?php print $c2_bg; ?>"><?php print $client->property('os');?></td>
        </tr>
        <tr>
            <td bgcolor="<?php print $c1_bg; ?>">session cookies</td>
            <td width="100%" bgcolor="<?php print $c2_bg; ?>"><?php print ($ssc=$client->property('ss_cookies'))=='Unknown'?$ssc:($ssc?'true':'false');?></td>
            
        </tr>
        <tr>
            <td bgcolor="<?php print $c1_bg; ?>">stored cookies</td>
            <td width="100%" bgcolor="<?php print $c2_bg; ?>"><?php print ($stc=$client->property('st_cookies'))=='Unknown'?$stc:($stc?'true':'false');?></td>
        </tr>
        <tr>
            <td bgcolor="<?php print $c1_bg; ?>">ip</td>
            <td width="100%" bgcolor="<?php print $c2_bg; ?>"><?php print $client->property('ip');?></td>
        </tr>
        <tr>
            <td bgcolor="<?php print $c1_bg; ?>">language</td>
            <td width="100%" bgcolor="<?php print $c2_bg; ?>"><?php print $client->property('language');?></td>
        </tr>
		<tr>
            <td bgcolor="<?php print $c1_bg; ?>">gecko</td>
            <td width="100%" bgcolor="<?php print $c2_bg; ?>"><?php print $client->property('gecko');?></td>
        </tr>
        <tr>
            <td bgcolor="<?php print $c1_bg; ?>">gecko_ver</td>
            <td width="100%" bgcolor="<?php print $c2_bg; ?>"><?php print $client->property('gecko_ver');?></td>
        </tr>		
    </table>
</td>
<td align="left" valign="top">
    <table border="0" cellpadding="3" cellspacing="1" width="100%">
    <tr><td colspan="2" nowrap><font color="#ffcc00">&nbsp;</font></td></tr>
    <tr>
       	<td bgcolor="<?php print $c1_bg; ?>" nowrap><b>search_phrase</b></td>
       	<td width="100%" bgcolor="<?php print $c2_bg; ?>" nowrap><b>return boolean</b></td>
    </tr>
	
    <!-- feature search -->
	<tr>
        <td bgcolor="<?php print $c3_bg; ?>" colspan="2" nowrap><font color="#ffcc00">$client->has_feature(<i>feature</i>)</font></td>
    </tr>
	<?php
		has_feature('html');
		has_feature('images');
		has_feature('frames');
		has_feature('tables');
		has_feature('java');
		has_feature('plugins');
		has_feature('css2');
		has_feature('css1');
		has_feature('iframes');
		has_feature('xml');
		has_feature('dom');
		has_feature('hdml');
		has_feature('wml');
    ?>
	<!-- quirks -->
    <tr>
        <td bgcolor="<?php print $c3_bg; ?>" colspan="2" nowrap><font color="#ffcc00">$client->has_quirk(<i>quirk</i>)</font></td>
    </tr>
    <?php
		has_quirk('must_cache_forms');
		has_quirk('avoid_popup_windows');
		has_quirk('cache_ssl_downloads');
		has_quirk('break_disposition_header');
		has_quirk('empty_file_input_value');
		has_quirk('scrollbar_in_way');
    ?>
	<!-- browser_is search -->
    <tr>
       	<td bgcolor="<?php print $c3_bg; ?>" colspan="2" nowrap><font color="#ffcc00">$client->browser_is(<i>browser</i>)</font></td>
    </tr>
    <?php
       	browser_is('aol');
       	browser_is('ie6+');
       	browser_is('mz1.3+');
        browser_is('ns7+');
        browser_is('op6+');
    ?>
	<!-- language_is search -->
    <tr>
       	<td bgcolor="<?php print $c3_bg; ?>" colspan="2" nowrap><font color="#ffcc00">$client->language_is(<i>language</i>)</font></td>
    </tr>
    <?php
       	language_is('en');
       	language_is('en-us');
       	language_is('fr-ca');
    	?>
    <!-- old style search -->
	<tr>
       	<td bgcolor="<?php print $c3_bg; ?>" colspan="2" nowrap><font color="#ffcc00">$client->is(<i>search</i>)</font></td>
    </tr>
    <?php
		is('b:ns7-');
		is('l:en-us');
    ?>
	</table>
</td></tr></table>
</form>
<p>
<?php
$timer->stop('main');
printf("<pre>\n".
       "client instantiation time : %s\n" .
       "page execution time       : %s\n" .
       "</pre>" ,
       $timer->get_current('client1'),
       $timer->get_current('main'));
?>
</p>
<?php
print ('<p align="left"><font size="-2">_______________________________<br>');
print ('Copyleft 2001-2003 Simian Synapse, LLC.<br></font></p>');
?>
<p align="center">
<A href="http://sourceforge.net"><IMG 
src="http://sourceforge.net/sflogo.php?group_id=26044" 
width="88" height="31" border="0" alt="SourceForge Logo"></A>
</p>
</body>
</html>