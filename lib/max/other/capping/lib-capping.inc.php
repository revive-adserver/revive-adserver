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
$Id$
*/

// Required files
require_once MAX_PATH . '/lib/max/other/lib-io.inc.php';

phpAds_registerGlobal('cap', 'session_capping', 'time');

/**
 * A function to initialise capping variables for ad, campaign or zone capping.
 *
 * After running, the global variables $block is set with the number of seconds
 * to prevent delivery again for, while $cap and $session_capping are set to
 * either 0 for no capping, or number number of times to cap the item to.
 */
function _initCappingVariables() {

    global $time, $block, $cap, $session_capping;

    // Initialize $block variable with time
    if (isset($time)) {
    	$block = 0;
    	if ($time['second'] != '-') $block += (int)$time['second'];
    	if ($time['minute'] != '-') $block += (int)$time['minute'] * 60;
    	if ($time['hour'] != '-') 	$block += (int)$time['hour'] * 3600;
    } else {
    	$block = 0;
    }

    // Initialize capping variables
    if (isset($cap) && $cap != '-') {
    	$cap = (int)$cap;
    } else {
    	$cap = 0;
    }

    if (isset($session_capping) && $session_capping != '-') {
    	$session_capping = (int)$session_capping;
    } else {
    	$session_capping = 0;
    }
}

/**
 * Breaks down a duration specified in seconds to hours, minutes and seconds.
 * The result is returned in a form of associative array which has
 * the values of 'hour', 'minute' and 'second' set.
 *
 * @param int $block Number of seconds.
 * @return array An array of 'hour', 'minute' and 'second' parts.
 */
function _getTimeFromSec($secDuration)
{
	$time = array();
    $time['hour'] = ($secDuration - ($secDuration % 3600)) / 3600;
    $secDuration = $secDuration % 3600;

    $time['minute'] = ($secDuration - ($secDuration % 60)) / 60;
    $secDuration = $secDuration % 60;

    $time['second'] = $secDuration;
    return $time;
}

function _replaceTrailingZerosWithDash(&$time)
{
	if ($time['hour'] == 0 && $time['minute'] == 0 && $time['second'] == 0) $time['second'] = '-';
	if ($time['hour'] == 0 && $time['minute'] == 0) $time['minute'] = '-';
	if ($time['hour'] == 0) $time['hour'] = '-';
}

/**
 * Gets values from $cappedObject and uses them to output HTML form with
 * them. Assumes values are stored in indexs "block", "capping" and
 * "sessions" capping if $type is not supplied; otherwise it uses indexes
 * "block_$type", "cap_$type" and "session_cap_$type".
 *
 * @param int $tabindex Current $tabindex in the page.
 * @param array $arrTexts The internationalized texts to be used.
 * @param array $cappedObject An array of the capping information.
 * @param string $type Optional index name type. If not null, one of
 *                     "Ad", "Campaign" or "Zone".
 * @param array $aExtraDisplay Optional array of four or five indexes. The first
 *                             index is "title" and is the title of the display
 *                             of the extra information, the second is "titleLink"
 *                             and is the URL to go to edit these extra items,
 *                             the third is index is "arrTexts", and is a second
 *                             array of internationalized tests to be used; the fourth
 *                             index is "cappedObject" and is a second array of
 *                             capping information; the fifth (optional) index
 *                             is "type", and is an optional index name for the
 *                             "cappedObject" array.
 * @return int An incremented value of $tabindex.
 */
function _echoDeliveryCappingHtml($tabindex, $arrTexts, $cappedObject, $type = null, $aExtraDisplay)
{
    global $time, $cap, $session_capping;

    // Extract the capping information to put into the form
    if (is_null($type)) {
        if (!isset($time)) {
        	$time = _getTimeFromSec($cappedObject['block']);
        }
        $cap = (isset($cap)) ? $cap : $cappedObject['capping'];
        $session_capping = (isset($session_capping)) ? $session_capping : $cappedObject['session_capping'];
    } else {
        if (!isset($time)) {
        	$time = _getTimeFromSec($cappedObject['block_' . strtolower($type)]);
        }
        $cap = (isset($cap)) ? $cap : $cappedObject['cap_' . strtolower($type)];
        $session_capping = (isset($session_capping)) ? $session_capping : $cappedObject['session_cap_' . strtolower($type)];
    }

    // Is there extra non-editable capping info to display?
    $showExtra = false;
    if ((!empty($aExtraDisplay)) && (!empty($aExtraDisplay['arrTexts'])) && (!empty($aExtraDisplay['cappedObject']))) {
        $showExtra = true;
        if (is_null($aExtraDisplay['type'])) {
        	$extra_time = _getTimeFromSec($aExtraDisplay['cappedObject']['block']);
            $extra_cap = $aExtraDisplay['cappedObject']['capping'];
            $extra_session_capping = $aExtraDisplay['cappedObject']['session_capping'];
        } else {
        	$extra_time = _getTimeFromSec($aExtraDisplay['cappedObject']['block_' . strtolower($aExtraDisplay['type'])]);
            $extra_cap = $aExtraDisplay['cappedObject']['cap_' . strtolower($aExtraDisplay['type'])];
            $extra_session_capping = $aExtraDisplay['cappedObject']['session_cap_' . strtolower($aExtraDisplay['type'])];
        }
    }

    _replaceTrailingZerosWithDash($time);
    if ($cap == 0) $cap = '-';
    if ($session_capping == 0) $session_capping = '-';

    if ($showExtra) {
        _replaceTrailingZerosWithDash($extra_time);
        if ($extra_cap == 0) $extra_cap = '-';
        if ($extra_session_capping == 0) $extra_session_capping = '-';
        if ($extra_time['hour'] == '-' && $extra_time['minute'] == '-' && $extra_time['second'] == '-' && $extra_cap == '-' && $extra_session_capping == '-') {
            $showExtra = false;
        }
    }

    echo "
    <tr>
      <td height='25' colspan='3' bgcolor='#FFFFFF'>
        <b>{$arrTexts['title']}</b>
      </td>";

    if ($showExtra) {
        if (!empty($aExtraDisplay['title'])) {
            echo "
      <td height='25' colspan='3' bgcolor='#FFFFFF'>
        <b>";
            if (!empty($aExtraDisplay['titleLink'])) {
                echo "<a href=\"{$aExtraDisplay['titleLink']}\">";
            }
            echo "
        {$aExtraDisplay['title']} {$arrTexts['title']}
            ";
            if (!empty($aExtraDisplay['titleLink'])) {
                echo "</a>";
            }
            echo "
        </b>
      </td>";
        }
    }

    echo "
    </tr>
    <tr><td height='1' colspan='6' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>
    <tr><td height='10' colspan='6'>&nbsp;</td></tr>

    <tr>
      <td width='30'>&nbsp;</td>
      <td width='200'>{$arrTexts['time']}</td>
      <td valign='top'>
        <input id='timehour' class='flat' type='text' size='3' name='time[hour]' value='{$time['hour']}' onKeyUp=\"phpAds_formLimitUpdate(this);\" tabindex='".($tabindex++)."'> {$GLOBALS['strHours']}&nbsp;&nbsp;
        <input id='timeminute' class='flat' type='text' size='3' name='time[minute]' value='{$time['minute']}' onKeyUp=\"phpAds_formLimitUpdate(this);\" tabindex='".($tabindex++)."'> {$GLOBALS['strMinutes']}&nbsp;&nbsp;
        <input id='timesecond' class='flat' type='text' size='3' name='time[second]' value='{$time['second']}' onBlur=\"phpAds_formLimitBlur(this);\" onKeyUp=\"phpAds_formLimitUpdate(this);\" tabindex='".($tabindex++)."'> {$GLOBALS['strSeconds']}&nbsp;&nbsp;
      </td>";

    if ($showExtra) {
        echo "
      <td width='30'>&nbsp;</td>
      <td width='200'>{$aExtraDisplay['arrTexts']['time']}</td>
      <td valign='top'>
        <input id='extratimehour' class='flat' type='text' size='3' name='extra_time[hour]' value='{$extra_time['hour']}' disabled;\"'> {$GLOBALS['strHours']}&nbsp;&nbsp;
        <input id='extratimeminute' class='flat' type='text' size='3' name='extra_time[minute]' value='{$extra_time['minute']}' disabled;\"'> {$GLOBALS['strMinutes']}&nbsp;&nbsp;
        <input id='extratimesecond' class='flat' type='text' size='3' name='extra_time[second]' value='{$extra_time['second']}' disabled;\";\"'> {$GLOBALS['strSeconds']}&nbsp;&nbsp;
      </td>";
    }

    echo "
    </tr>

    <tr><td><img src='images/spacer.gif' height='1' width='100%'></td>
    <td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td>";

    if ($showExtra) {
        echo "
    <td><img src='images/spacer.gif' height='1' width='100%'></td>
    <td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td>";
    }

    echo "
    </tr>

    <tr>
      <td width='30'>&nbsp;</td>
      <td width='200'>{$arrTexts['user']}</td>
      <td valign='top'>
        <input class='flat' type='text' size='3' name='cap' value='{$cap}' onBlur=\"phpAds_formCapBlur(this);\" tabindex='".($tabindex++)."'> {$GLOBALS['strTimes']}
      </td>";

    if ($showExtra) {
        echo "
      <td width='30'>&nbsp;</td>
      <td width='200'>{$arrTexts['user']}</td>
      <td valign='top'>
        <input class='flat' type='text' size='3' name='extra_cap' value='{$extra_cap}' disabled;\"'> {$GLOBALS['strTimes']}
      </td>";
    }

    echo "
    </tr>

    <tr><td><img src='images/spacer.gif' height='1' width='100%'></td>
    <td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td>";

    if ($showExtra) {
        echo "
    <td><img src='images/spacer.gif' height='1' width='100%'></td>
    <td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td>";
    }

    echo "
    </tr>

    <tr>
      <td width='30'>&nbsp;</td>
      <td width='200'>{$arrTexts['session']}</td>
      <td valign='top'>
        <input class='flat' type='text' size='3' name='session_capping' value='{$session_capping}' onBlur=\"phpAds_formCapBlur(this);\" tabindex='".($tabindex++)."'> {$GLOBALS['strTimes']}
      </td>";


    if ($showExtra) {
        echo "
      <td width='30'>&nbsp;</td>
      <td width='200'>{$arrTexts['session']}</td>
      <td valign='top'>
        <input class='flat' type='text' size='3' name='extra_session_capping' value='{$extra_session_capping}' disabled;\"'> {$GLOBALS['strTimes']}
      </td>";
    }

    echo "
    </tr>

    <tr><td height='10' colspan='3'>&nbsp;</td></tr>
    ";

    return $tabindex;
}

function _echoDeliveryCappingJs()
{
echo "
<script language='JavaScript'>
<!--

	function phpAds_formCapBlur (i)
	{
		if (i.value == '' || i.value == '0') i.value = '-'
	}

	function phpAds_formLimitBlur (i)
	{
		f = i.form;

		if (f.timehour.value == '') f.timehour.value = '0';
		if (f.timeminute.value == '') f.timeminute.value = '0';
		if (f.timesecond.value == '') f.timesecond.value = '0';

		phpAds_formLimitUpdate (i);
	}

	function phpAds_formLimitUpdate (i)
	{
		f = i.form;

		// Set -
		if (f.timeminute.value == '-' && f.timehour.value != '-') f.timeminute.value = '0';
		if (f.timesecond.value == '-' && f.timeminute.value != '-') f.timesecond.value = '0';

		// Set 0
		if (f.timehour.value == '0') f.timehour.value = '-';
		if (f.timehour.value == '-' && f.timeminute.value == '0') f.timeminute.value = '-';
		if (f.timeminute.value == '-' && f.timesecond.value == '0') f.timesecond.value = '-';
	}

//-->
</script>";
}

?>
