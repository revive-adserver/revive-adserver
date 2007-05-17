<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2007 Openads Limited                                   |
| For contact details, see: http://www.openads.org/                         |
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
$Id$
*/

/**
 * @package    MaxPlugin
 * @subpackage InvocationTags
 * @author     Radek Maciaszek <radek@m3.net>
 */

require_once MAX_PATH . '/plugins/invocationTags/InvocationTags.php';
require_once MAX_PATH . '/lib/max/Plugin/Translation.php';
require_once MAX_PATH . '/lib/OA/DB.php';

/**
 * Invocation tag plugin.
 */
class Plugins_InvocationTags_publisherJS_publisherJS extends Plugins_InvocationTags
{

    /**
     * Constructor
     */
    function Plugins_InvocationTags_publisherJS_publisherJS() {
        $this->publisherPlugin = true;
        $this->oDbh = OA_DB::singleton();
    }

     /**
     * Return name of plugin
     *
     * @return string
     */
    function getName()
    {
        return MAX_Plugin_Translation::translate('Publisher code - JavaScript', $this->module, $this->package);
    }

    /**
     * Check if plugin is allowed
     *
     * @return boolean  True - allowed, false - not allowed
     */
    function isAllowed()
    {
        return false;
    }

    /**
     * Return invocation code for this plugin (codetype)
     *
     * @return string
     */
    function generateInvocationCode()
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        $mi = &$this->maxInvocation;
        $query = "
            SELECT
                mnemonic
            FROM
                {$conf['table']['prefix']}{$conf['table']['affiliates']}
            WHERE
                affiliateid=". $this->oDbh->quote($mi->affiliateid, 'integer');
        if ($row = $this->oDbh->queryRow($query)) {
            $mnemonic = $row['mnemonic'];
        } else if(PEAR::isError($row)) {
            return $row;
        }

        $query = "
            SELECT
                affiliateid,
                zoneid,
                zonename,
                width,
                height,
                delivery
            FROM
                {$conf['table']['prefix']}{$conf['table']['zones']}
            WHERE
                affiliateid=". $this->oDbh->quote($mi->affiliateid, 'integer');
        $res = $this->oDbh->query($query);
        if(PEAR::isError($res)) {
            return $res;
        }
        while ($row = $res->fetchRow()) {
            $aZoneId[]   = $row['zoneid'];
            $aZoneName[] = $row['zonename'];
            $aZoneType[] = $row['delivery'];
            $aN[]        = $mnemonic . substr(md5(uniqid('', 1)), 0, 7);
            $aWidth[]    = $row['width'] == -1 ? '*' : $row['width'];
            $aHeight[]   = $row['height'] == -1 ? '*' : $row['height'];;
        }
        if (!isset($aZoneId) || !is_array($aZoneId)) {
            return MAX_Plugin_Translation::translate('No Zones Available!', $this->module, $this->package);
        }
        $script = "
<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
<html>
<head>
".MAX_Plugin_Translation::translate('Remove Comments Note', $this->module, $this->package)."
".MAX_Plugin_Translation::translate('Publisher JS Channel Script Comment 1', $this->module, $this->package)."$mnemonic"
.MAX_Plugin_Translation::translate('Publisher JS Channel Script Comment 2', $this->module, $this->package)."$mnemonic"
.MAX_Plugin_Translation::translate('Publisher JS Channel Script Comment 3', $this->module, $this->package)."

<script type='text/javascript'>
<!--// <![CDATA[
  var az_channel = '{$mnemonic}/test/preview';
// ]]> -->
</script>
".MAX_Plugin_Translation::translate('Publisher JS Header Script Comment', $this->module, $this->package)."

<script type='text/javascript'>
<!--// <![CDATA[
var az_p=location.protocol=='https:'?'https:':'http:';
var az_r=Math.floor(Math.random()*99999999);
if (!document.phpAds_used) document.phpAds_used = ',';
function az_adjs(z,n)
{
  if (z>-1) {
    var az=\"<\"+\"script language='JavaScript' type='text/javascript' \";
    az+=\"src='\"+az_p+\"".MAX_commonConstructPartialDeliveryUrl($conf['file']['js'])."?n=\"+n+\"&zoneid=\"+z;
    az+=\"&source=\"+az_channel+\"&exclude=\"+document.phpAds_used+\"&r=\"+az_r;
    az+=\"&mmm_fo=\"+(document.mmm_fo)?'1':'0';
    if (window.location) az+=\"&loc=\"+escape(window.location);
    if (document.referrer) az+=\"&referer=\"+escape(document.referrer);
    az+=\"'><\"+\"/script>\";
    document.write(az);
  }
}
function az_adpop(z,n)
{
  if (z>-1) {
    var az=\"<\"+\"script language='JavaScript' type='text/javascript' \";
    az+=\"src='\"+az_p+\"".MAX_commonConstructPartialDeliveryUrl($conf['file']['popup'])."?n=\"+n+\"&zoneid=\"+z;
    az+=\"&source=\"+az_channel+\"&exclude=\"+document.phpAds_used+\"&r=\"+az_r;
    if (window.location) az+=\"&loc=\"+escape(window.location);
    if (document.referrer) az+=\"&referer=\"+escape(document.referrer);
    az+=\"'><\"+\"/script>\";
    document.write(az);
  }
}
// ]]> -->
</script>

</head>
<body>

".MAX_Plugin_Translation::translate('Publisher JS Ad Tag Script(s) Comment', $this->module, $this->package);
            foreach($aZoneName as $key=>$zoneName) {
                $name = "[id{$aZoneId[$key]}] " . str_replace('\'','',$zoneName) . " - " . str_replace('\'','',$aWidth[$key]) . "x". str_replace('\'','',$aHeight[$key]);
                if ($aZoneType[$key] != phpAds_ZonePopup) {
                    $script .= "
<br /><br />$name<br />

<script type='text/javascript'>
<!--// <![CDATA[
az_adjs({$aZoneId[$key]},'{$aN[$key]}');
// ]]> -->

</script>
";
                    if ($aZoneType[$key] != phpAds_ZoneText) {
                        $script .= "<noscript>\n";
                        $script .= "  <a target='_blank' href='".MAX_commonConstructDeliveryUrl($conf['file']['click'])."?n={$aN[$key]}'>\n";
                        $script .= "  <img border='0' alt='' src='".MAX_commonConstructDeliveryUrl($conf['file']['view'])."?zoneid={$aZoneId[$key]}&n={$aN[$key]}' /></a>\n";
                        $script .= "</noscript>";
                    }
                }
                else {
                    // This is a popup zone, so generate popup.php invocation not javascript
                    $script .= "
<br /><br />$name<br />

<script type='text/javascript'>
<!--// <![CDATA[
az_adpop({$aZoneId[$key]},'{$aN[$key]}');
// ]]> -->
</script>
";
                }
            }
            $script .= "

</body>
</html>";
        return $script;
    }

}

?>
