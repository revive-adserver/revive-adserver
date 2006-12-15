<?php
/*
+---------------------------------------------------------------------------+
| Max Media Manager v0.3                                                    |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2006 m3 Media Services Limited                         |
| For contact details, see: http://www.m3.net/                              |
|                                                                           |
| Copyright (c) 2000-2003 the phpAdsNew developers                          |
| For contact details, see: http://www.phpadsnew.com/                       |
|                                                                           |
| This program is free software; you can redistribute it and/or modify      |
| it under the terms of the GNU General Public License as published by      |
| the Free Software Foundation; either version 2 of the License, or         |
| (at your option) any later version.                                       |
|                                                                           |
| This program is distributed in the hope that it will be useful,           |
| but WITHOUT ANY WARRANTY; without even the implied warranty of            |
| MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             |
| GNU General Public License for more details.                              |
|                                                                           |
| You should have received a copy of the GNU General Public License         |
| along with this program; if not, write to the Free Software               |
| Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA |
+---------------------------------------------------------------------------+
$Id: lib-banner.inc.php 5698 2006-10-12 16:16:22Z chris@m3.net $
*/

require_once MAX_PATH . '/lib/max/other/common.php';

function phpAds_getBannerCache($banner)
{
    $conf = $GLOBALS['_MAX']['CONF'];
    $pref = $GLOBALS['_MAX']['PREF'];
    $buffer = $banner['htmltemplate'];
    
    // Strip slashes from urls
    $banner['url']      = stripslashes($banner['url']);
    $banner['imageurl'] = stripslashes($banner['imageurl']);
        
    // The following properties depend on data from the invocation process
    // and can't yet be determined: {zoneid}, {bannerid}
    // These properties will be set during invocation
    
    // Auto change HTML banner
    if ($banner['storagetype'] == 'html')
    {
        if ($banner['autohtml'] == 't' && $pref['banner_html_auto'])
        {
            if ($buffer != '')
            {
                // Remove target parameters
                $buffer = preg_replace('# target\s*=\s*[\\\\]?\'[^\']*\'#i', ' ', $buffer);  // target='_blank'
                $buffer = preg_replace('# target\s*=\s*[\\\\]?\"[^\"]*\"#i', ' ', $buffer);  // target="_blank"
                //$buffer = preg_replace(" target=(some word)", '', $buffer); // target=_blank
                
                // Put our click URL and our target parameter in all anchors...
                // Assumption: That a URL will never contain either ' or "
                // Reverted this temporarily
                // $buffer = preg_replace('#<a(.*?)href\s*=\s*([\\\\]?)[\'"]http(.*?)[\'"](.*?)>#is', "<a$1href=$2\"{clickurl}http$3\"$4  target=\"{target}\">", $buffer);
                $buffer = preg_replace('#<a(.*?)href\s*=\s*([\\\\]?)[\'"]http(.*?)[\'"](.*?)>#is', "<a$1href=$2\"{clickurl}http$3\"$4  target=\\'{target}\\'>", $buffer);

                
                // Search: <\s*form (.*?)action\s*=\s*['"](.*?)['"](.*?)>
                // Replace:<form\1 action="{url_prefix}/{$conf['file']['click']}" \3><input type='hidden' name='{clickurlparams}\2'>
                $target = (!empty($banner['target'])) ? $banner['target'] : "_self";
                $buffer = preg_replace(
                    '#<\s*form (.*?)action\s*=\s*[\\\\]?[\'"](.*?)[\'\\\"][\'\\\"]?(.*?)>(.*?)</form>#is',
                    "<form $1 action=\\\"{url_prefix}\\\" $3 target=\'{$target}\'>$4<input type=\'hidden\' name=\'maxparams\\' value=\'{clickurlparams}$2\'></form>",
                    $buffer
                );
                
                //$buffer = preg_replace("#<form*action='*'*>#i","<form target='{target}' $1action='{url_prefix}/{}$conf['file']['click']'$3><input type='hidden' name='{clickurlparams}$2'>", $buffer);
                //$buffer = preg_replace("#<form*action=\"*\"*>#i","<form target=\"{target}\" $1action=\"{url_prefix}/{$conf['file']['click']}\"$3><input type=\"hidden\" name=\"{clickurlparams}$2\">", $buffer);
                
                // In addition, we need to add our clickURL to the clickTAG parameter if present, for 3rd party flash ads
                $buffer = preg_replace('#clickTAG\s?=\s?(.*?)([\'"])#', "clickTAG={clickurl}$1$2", $buffer);
                
                // Detect any JavaScript window.open() functions, and prepend the opened URL with our logurl
                $buffer = preg_replace('#window.open\s?\((.*?)\)#i', "window.open(\\\'{logurl}&maxdest=\\\'+$1)", $buffer);
            }
            
            // Since we don't want to replace adserver noscript and iframe content with click tracking etc
            $noScript = array();
            
            //Capture noscript content into $noScript[0], for seperate translations
            preg_match("#<noscript>(.*?)</noscript>#is", $buffer, $noScript);
            $buffer = preg_replace("#<noscript>(.*?)</noscript>#is", '{noscript}', $buffer);
            
            // run 3rd party plugin
            if(!empty($banner['adserver'])) {
                include_once MAX_PATH . '/lib/max/Plugin.php';
                $adServerPlugin = MAX_Plugin::factory('3rdPartyServers', $banner['adserver']);
                if($adServerPlugin) {
                    $buffer = $adServerPlugin->getBannerCache($buffer, $noScript);
                }
            }
                
            // Adserver processing complete, now replace the noscript values back:
            //$buffer = preg_replace("#{noframe}#", $noFrame[2], $buffer);
            $buffer = preg_replace("#{noscript}#", $noScript[0], $buffer);
                
/*
<script language="JavaScript1.1" src="http://adfarm.mediaplex.com/ad/js/3990-21328-3822-1?mpt={random:10}&mpvc={url_prefix}/{$conf['file']['click']}?bannerid={bannerid}&zoneid={zoneid}&source={source}&dest=">
</script>
<noscript>
  <a href="http://adfarm.mediaplex.com/ad/ck/3990-21328-3822-1?mpt={random:10}&
    <img src="http://adfarm.mediaplex.com/ad/bn/3990-21328-3822-1?mpt={random:10}&
alt="Click Here" border="0">
</a>
</noscript>
*/
                
            // End link processing
        }
    }
    
    return ($buffer);
}

function phpAds_rebuildBannerCache ($bannerid)
{
    $conf = $GLOBALS['_MAX']['CONF'];
    
    // Retrieve current values
    $res = phpAds_dbQuery ("
        SELECT
            *
        FROM
            ".$conf['table']['prefix'].$conf['table']['banners']."
        WHERE
            bannerid = '".$bannerid."'
    ") or phpAds_sqlDie();
    
    $current = phpAds_dbFetchArray($res);
    
    
    // Add slashes to status to prevent javascript errors
    // NOTE: not needed in banner-edit because of magic_quotes_gpc
    $current['status'] = addslashes($current['status']);
    
    
    // Rebuild cache
    $current['htmltemplate'] = stripslashes($current['htmltemplate']);
    $current['htmlcache']    = addslashes(phpAds_getBannerCache($current));
    
    phpAds_dbQuery("
        UPDATE
            ".$conf['table']['prefix'].$conf['table']['banners']."
        SET
            htmlcache = '".$current['htmlcache']."',
            updated = '".date('Y-m-d H:i:s')."'
        WHERE
            bannerid = '".$current['bannerid']."'
    ") or phpAds_sqlDie();
}

?>
