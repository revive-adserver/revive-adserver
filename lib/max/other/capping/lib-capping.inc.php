<?php

/*
+---------------------------------------------------------------------------+
| Revive Adserver                                                           |
| http://www.revive-adserver.com                                            |
|                                                                           |
| Copyright: See the COPYRIGHT.txt file.                                    |
| License: GPLv2 or later, see the LICENSE.txt file.                        |
+---------------------------------------------------------------------------+
*/

// Required files
require_once MAX_PATH . '/lib/max/other/lib-io.inc.php';

// #1088 redundant code refactor
//  phpAds_registerGlobal is a wrapper function for MAX_commonRegisterGlobalsArray($args);
//  *technically* deprecated
phpAds_registerGlobal('cap', 'session_capping', 'time');

/**
 * A function to initialise capping variables for ad, campaign or zone capping.
 *
 * After running, the result $block is set with the number of seconds
 * to prevent delivery again for, while $cap and $session_capping are set to
 * either 0 for no capping, or number number of times to cap the item to.
 */
function _initCappingVariables(&$time, &$cap, &$session_capping) {

    //global $time, $block, $cap, $session_capping;

    // Initialize $block variable with time
    if (isset($time)) {
    	$block = 0;
    	if ($time['second'] != '-') $block += (int)$time['second'];
    	if ($time['minute'] != '-') $block += (int)$time['minute'] * 60;
    	if ($time['hour'] != '-') 	$block += (int)$time['hour'] * 3600;
    }
    else {
    	$block = 0;
    }

    // Initialize capping variables
    if (isset($cap) && $cap != '-') {
    	$cap = (int)$cap;
    }
    else {
    	$cap = 0;
    }

    if (isset($session_capping) && $session_capping != '-') {
    	$session_capping = (int)$session_capping;
    }
    else {
    	$session_capping = 0;
    }
    if (empty($cap) && empty($session_capping)) { $block = 0; }
    return $block;
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
	if ($time['hour'] == 0 && $time['minute'] == 0 && $time['second'] == 0) {
	   $time['second'] = '-';
	}
	if ($time['hour'] == 0 && $time['minute'] == 0) {
	   $time['minute'] = '-';
	}
	if ($time['hour'] == 0) {
	   $time['hour'] = '-';
	}
}

/**
 * Gets values from $aCappedObject and uses them to output HTML form with
 * them. Assumes values are stored in indexs "block", "capping" and
 * "sessions" capping if $type is not supplied; otherwise it uses indexes
 * "block_$type", "cap_$type" and "session_cap_$type".
 *
 * @param int $tabindex Current $tabindex in the page.
 * @param array $aText The internationalized texts to be used.
 * @param array $aCappedObject An array of the capping information.
 * @param string $type Optional index name type. If not null, one of
 *                     "Ad", "Campaign" or "Zone". When specified, the capping
 *                      data from the $aCappedObject array is taken from the
 *                      indicies "block_$type", "cap_$type" and "session_cap_$type";
 *                      when not speficied, the indicies "block", "capping" and
 *                      "session_capping" are used.
 * @param array $aExtraDisplay Optional array of four or five indexes. The first
 *                             index is "title" and is the title of the display
 *                             of the extra information, the second is "titleLink"
 *                             and is the URL to go to edit these extra items,
 *                             the third is index is "aText", and is a second
 *                             array of internationalized tests to be used; the fourth
 *                             index is "aCappedObject" and is a second array of
 *                             capping information; the fifth (optional) index
 *                             is "type", and is an optional index name for the
 *                             "aCappedObject" array.
 */
function buildDeliveryCappingFormSection(&$form, $aText, $aCappedObject, $type = null, $aExtraDisplay = array(), $showCounters = true, $hide = false)
{
    // Extract the capping information to put into the form
    if (is_null($type)) {
        $time = _getTimeFromSec($aCappedObject['block']);
        $capping = $aCappedObject['capping'];
        $session_capping = $aCappedObject['session_capping'];
    }
    else {
        $time = _getTimeFromSec($aCappedObject['block_' . strtolower($type)]);
        $capping = $aCappedObject['cap_' . strtolower($type)];
        $session_capping = $aCappedObject['session_cap_' . strtolower($type)];
    }
    _replaceTrailingZerosWithDash($time);
    if ($capping == 0) {
        $capping = '-';
    }
    if ($session_capping == 0) {
        $session_capping = '-';
    }


    //build capping section
    $form->addElement('header', 'h_capping', $aText['title']);
    //section decorator to allow hiding of the section
    $form->addDecorator('h_capping', 'tag',
        array('attributes' => array('id' => 'sect_cap', 'class' => $hide ? 'hide' : '')));


    $viewsPerDayG['text'] = $form->createElement('text', 'capping', null,
        array('size' => 2, 'id' => 'cap'));
    $viewsPerDayG['note'] = $form->createElement('html', null, $GLOBALS['strDeliveryCappingTotal']);
    $form->addGroup($viewsPerDayG, 'cap_per_d', $aText['limit']);

    $viewsPerSessG['text'] = $form->createElement('text', 'session_capping', null,
        array('size' => 2, 'id' => 'session_capping'));
    $viewsPerSessG['note'] = $form->createElement('html', null, $GLOBALS['strDeliveryCappingSession']);
    $form->addGroup($viewsPerSessG, 'cap_per_s', $aText['limit']);

    //reset counters
    if ($showCounters) {
        $resetG['hour'] = $form->createElement('text', 'time[hour]', $GLOBALS['strHours'],
            array('id' => 'timehour', 'onKeyUp' => 'phpAds_formLimitUpdate(this);',
            'size' => 2, "labelPlacement" => "after"));
        $resetG['minute'] = $form->createElement('text', 'time[minute]', $GLOBALS['strMinutes'],
            array('id' => 'timeminute', 'onKeyUp' => 'phpAds_formLimitUpdate(this);',
            'size' => 2, "labelPlacement" => "after"));
        $resetG['second'] = $form->createElement('text', 'time[second]', $GLOBALS['strSeconds'],
            array('id' => 'timesecond', 'onBlur' => 'phpAds_formLimitBlur(this);',
                'onKeyUp' => 'phpAds_formLimitUpdate(this);', 'size' => 2,
                "labelPlacement" => "after"));
        if (($capping != '-' && $capping > 0)
            || ($session_capping != '-' && $session_capping > 0)) {
            $timeDisabled = false;
        }
        else {
            $timeDisabled = true;
        }
        if ($timeDisabled) {
            $resetG['hour']->setAttribute('disabled', 'disabled');
            $resetG['minute']->setAttribute('disabled', 'disabled');
            $resetG['second']->setAttribute('disabled', 'disabled');
        }
        $form->addGroup($resetG, 'cap_reset', $GLOBALS['strDeliveryCappingReset'], "&nbsp;");
    }

    //set values for capping section
    $form->setDefaults(array('time[hour]' => $time['hour'],
        'time[minute]' => $time['minute'],
        'time[second]' => $time['second']
    ));

    // Is there extra non-editable capping info to display?
    $showExtra = false;
    if ((!empty($aExtraDisplay)) && (!empty($aExtraDisplay['aText'])) && (!empty($aExtraDisplay['aCappedObject']))) {
        $showExtra = true;
        if (is_null($aExtraDisplay['type'])) {
            $extra_time = _getTimeFromSec($aExtraDisplay['aCappedObject']['block']);
            $extra_cap = $aExtraDisplay['aCappedObject']['capping'];
            $extra_session_capping = $aExtraDisplay['aCappedObject']['session_capping'];
        }
        else {
            $extra_time = _getTimeFromSec($aExtraDisplay['aCappedObject']['block_' . strtolower($aExtraDisplay['type'])]);
            $extra_cap = $aExtraDisplay['aCappedObject']['cap_' . strtolower($aExtraDisplay['type'])];
            $extra_session_capping = $aExtraDisplay['aCappedObject']['session_cap_' . strtolower($aExtraDisplay['type'])];
        }
        _replaceTrailingZerosWithDash($extra_time);

        //if nothing to show
        if ($extra_cap == '-' && $extra_session_capping == '-' &&
            $extra_time['hour'] == '-' && $extra_time['minute'] == '-' && $extra_time['second'] == '-') {
            $showExtra = false;
        }

        if ($extra_cap == 0) {
            $extra_cap = '-';
        }
        if ($extra_session_capping == 0) {
            $extra_session_capping = '-';
        }
    }

    if ($showExtra) {
        //build extra capping section
        $form->addElement('header', 's_extra_capping', '<a href="'.$aExtraDisplay['titleLink'].'">'
            .$aExtraDisplay['title'].' '.$aText['title'].'</a>');

        $eViewsPerDayG['text'] = $form->createElement('text', 'extra_cap', null,
            array('size' => 2, 'extra_cap' => 'cap', 'disabled' => '1'));
        $eViewsPerDayG['note'] = $form->createElement('html', null, $GLOBALS['strDeliveryCappingTotal']);
        $form->addGroup($eViewsPerDayG, 'ev_per_d', $aExtraDisplay['aText']['limit']);

        $eViewsPerSessG['text'] = $form->createElement('text', 'extra_session_capping', null,
            array('size' => 2, 'id' => 'extra_session_capping', 'disabled' => '1'));
        $eViewsPerSessG['note'] = $form->createElement('html', null, $GLOBALS['strDeliveryCappingSession']);
        $form->addGroup($eViewsPerSessG, 'ev_per_s', $aExtraDisplay['aText']['limit']);

        $eResetG['hour'] = $form->createElement('text', 'extra_time[hour]',
            $GLOBALS['strHours'], array('id' => 'extratimehour', 'size' => 2,
            'disabled' => '1', "labelPlacement" => "after"));
        $eResetG['minute'] = $form->createElement('text', 'extra_time[minute]',
            $GLOBALS['strMinutes'], array('id' => 'extratimeminute', 'size' => 2,
            'disabled' => '1', "labelPlacement" => "after"));
        $eResetG['second'] = $form->createElement('text', 'extra_time[second]',
            $GLOBALS['strSeconds'], array('id' => 'extratimesecond', 'size' => 2,
            'disabled' => '1', "labelPlacement" => "after"));
        $form->addGroup($eResetG, 'v_per_s', $GLOBALS['strDeliveryCappingReset'], "&nbsp;");

        $form->setDefaults(array('extra_cap' => $extra_cap,
            'extra_session_capping' => $extra_session_capping,
            'extra_time[hour]' => $extra_time['hour'],
            'extra_time[minute]' => $extra_time['minute'],
            'extra_time[second]' => $extra_time['second']
        ));
    }

    $capG['showcapped'] = $form->createElement('checkbox', 'show_capped_no_cookie', null, $GLOBALS['strShowCappedNoCookie']);
    $capG['info'] = $form->createElement('custom', 'capping-callout');
    $form->addGroup($capG, 'cap_g', $GLOBALS['strCookies']);

    $form->setDefaults(array('show_capped_no_cookie' => 1));

    return $form;
}



/**
 * Gets values from $aCappedObject and uses them to output HTML form with
 * them. Assumes values are stored in indexs "block", "capping" and
 * "sessions" capping if $type is not supplied; otherwise it uses indexes
 * "block_$type", "cap_$type" and "session_cap_$type".
 *
 * @param int $tabindex Current $tabindex in the page.
 * @param array $aText The internationalized texts to be used.
 * @param array $aCappedObject An array of the capping information.
 * @param string $type Optional index name type. If not null, one of
 *                     "Ad", "Campaign" or "Zone". When specified, the capping
 *                      data from the $aCappedObject array is taken from the
 *                      indicies "block_$type", "cap_$type" and "session_cap_$type";
 *                      when not speficied, the indicies "block", "capping" and
 *                      "session_capping" are used.
 * @param array $aExtraDisplay Optional array of four or five indexes. The first
 *                             index is "title" and is the title of the display
 *                             of the extra information, the second is "titleLink"
 *                             and is the URL to go to edit these extra items,
 *                             the third is index is "aText", and is a second
 *                             array of internationalized tests to be used; the fourth
 *                             index is "aCappedObject" and is a second array of
 *                             capping information; the fifth (optional) index
 *                             is "type", and is an optional index name for the
 *                             "aCappedObject" array.
 * @return int An incremented value of $tabindex.
 */
function _echoDeliveryCappingHtml($tabindex, $aText, $aCappedObject, $type = null, $aExtraDisplay = array())
{
    global $time, $cap, $session_capping;

    // Extract the capping information to put into the form
    if (is_null($type)) {
        if (!isset($time)) {
        	$time = _getTimeFromSec($aCappedObject['block']);
        }
        $cap = (isset($cap)) ? $cap : $aCappedObject['capping'];
        $session_capping = (isset($session_capping)) ? $session_capping : $aCappedObject['session_capping'];
    } else {
        if (!isset($time)) {
        	$time = _getTimeFromSec($aCappedObject['block_' . strtolower($type)]);
        }
        $cap = (isset($cap)) ? $cap : $aCappedObject['cap_' . strtolower($type)];
        $session_capping = (isset($session_capping)) ? $session_capping : $aCappedObject['session_cap_' . strtolower($type)];
    }

    // Is there extra non-editable capping info to display?
    $showExtra = false;
    if ((!empty($aExtraDisplay)) && (!empty($aExtraDisplay['aText'])) && (!empty($aExtraDisplay['aCappedObject']))) {
        $showExtra = true;
        if (is_null($aExtraDisplay['type'])) {
        	$extra_time = _getTimeFromSec($aExtraDisplay['aCappedObject']['block']);
            $extra_cap = $aExtraDisplay['aCappedObject']['capping'];
            $extra_session_capping = $aExtraDisplay['aCappedObject']['session_capping'];
        } else {
        	$extra_time = _getTimeFromSec($aExtraDisplay['aCappedObject']['block_' . strtolower($aExtraDisplay['type'])]);
            $extra_cap = $aExtraDisplay['aCappedObject']['cap_' . strtolower($aExtraDisplay['type'])];
            $extra_session_capping = $aExtraDisplay['aCappedObject']['session_cap_' . strtolower($aExtraDisplay['type'])];
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
        <b>{$aText['title']}</b>
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
        {$aExtraDisplay['title']} {$aText['title']}
            ";
            if (!empty($aExtraDisplay['titleLink'])) {
                echo "</a>";
            }
            echo "
        </b>
      </td>";
        }
    } else {
        echo "<tr height='1'><td colspan='3' bgcolor='#888888'><img src='" . OX::assetPath() . "/images/break.gif' height='1' width='100%'></td></tr>"."\n";
        echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>"."\n";
    }

    echo "
    </tr>

    <tr>
      <td width='30'>&nbsp;</td>
      <td width='200'>{$aText['limit']}</td>
      <td valign='top'>
        <input class='flat' type='text' size='2' id='cap' name='cap' value='{$cap}' tabindex='".($tabindex++)."'> {$GLOBALS['strDeliveryCappingTotal']}
      </td>";

    if ($showExtra) {
        echo "
      <td width='30'>&nbsp;</td>
      <td width='200'>{$aExtraDisplay['aText']['limit']}</td>
      <td valign='top'>
        <input class='flat' type='text' size='2' id='extra_cap' name='extra_cap' value='{$extra_cap}' disabled='disabled'> {$GLOBALS['strDeliveryCappingTotal']}
      </td>";
    }

    echo "
    </tr>

    <tr><td><img src='" . OX::assetPath() . "/images/spacer.gif' height='1' width='100%'></td>
    <td colspan='2'><img src='" . OX::assetPath() . "/images/break-l.gif' height='1' width='200' vspace='6'></td>";

    if ($showExtra) {
        echo "
    <td><img src='" . OX::assetPath() . "/images/spacer.gif' height='1' width='100%'></td>
    <td colspan='2'><img src='" . OX::assetPath() . "/images/break-l.gif' height='1' width='200' vspace='6'></td>";
    }

    echo "
    </tr>

    <tr>
      <td width='30'>&nbsp;</td>
      <td width='200'>{$aText['limit']}</td>
      <td valign='top'>
        <input class='flat' type='text' size='2' id='session_capping' name='session_capping' value='{$session_capping}' tabindex='".($tabindex++)."'> {$GLOBALS['strDeliveryCappingSession']}
      </td>

      ";

    if ($showExtra) {
        echo "
      <td width='30'>&nbsp;</td>
      <td width='200'>{$aExtraDisplay['aText']['limit']}</td>
      <td valign='top'>
        <input class='flat' type='text' size='2' id='extra_session_capping' name='extra_session_capping' value='{$extra_session_capping}' disabled='disabled'> {$GLOBALS['strDeliveryCappingSession']}
      </td>";
    }
    if (($cap != '-' && $cap > 0) || ($session_capping != '-' && $session_capping > 0)) {
        $timeDisabled = false;
    } else {
        $timeDisabled = true;
    }
   echo "
    </tr>
    <tr><td><img src='" . OX::assetPath() . "/images/spacer.gif' height='1' width='100%'></td>
    <td colspan='2'><img src='" . OX::assetPath() . "/images/break-l.gif' height='1' width='200' vspace='6'></td>";
   if ($showExtra) {
    echo "
        <td><img src='" . OX::assetPath() . "/images/spacer.gif' height='1' width='100%'></td>
        <td colspan='2'><img src='" . OX::assetPath() . "/images/break-l.gif' height='1' width='200' vspace='6'></td>";
    }
    echo "
    </tr>
    <tr>
      <td width='30'>&nbsp;</td>
      <td width='200'>{$GLOBALS['strDeliveryCappingReset']}</td>
      <td valign='top'>
        <input id='timehour' class='flat' type='text' size='2' name='time[hour]' value='{$time['hour']}' onKeyUp=\"phpAds_formLimitUpdate(this);\" tabindex='".($tabindex++)."' ".($timeDisabled ? "disabled='disabled'" : '')."> {$GLOBALS['strHours']}&nbsp;
        <input id='timeminute' class='flat' type='text' size='2' name='time[minute]' value='{$time['minute']}' onKeyUp=\"phpAds_formLimitUpdate(this);\" tabindex='".($tabindex++)."' ".($timeDisabled ? "disabled='disabled'" : '')."> {$GLOBALS['strMinutes']}&nbsp;
        <input id='timesecond' class='flat' type='text' size='2' name='time[second]' value='{$time['second']}' onBlur=\"phpAds_formLimitBlur(this);\" onKeyUp=\"phpAds_formLimitUpdate(this);\" tabindex='".($tabindex++)."' ".($timeDisabled ? "disabled='disabled'" : '')."> {$GLOBALS['strSeconds']}&nbsp;
      </td>";

    if ($showExtra) {
        echo "
      <td width='30'>&nbsp;</td>
      <td width='200'>{$GLOBALS['strDeliveryCappingReset']}</td>
      <td valign='top'>
        <input id='extratimehour' class='flat' type='text' size='2' name='extra_time[hour]' value='{$extra_time['hour']}' disabled='disabled'> {$GLOBALS['strHours']}&nbsp;
        <input id='extratimeminute' class='flat' type='text' size='2' name='extra_time[minute]' value='{$extra_time['minute']}' disabled='disabled'> {$GLOBALS['strMinutes']}&nbsp;
        <input id='extratimesecond' class='flat' type='text' size='2' name='extra_time[second]' value='{$extra_time['second']}' disabled='disabled'> {$GLOBALS['strSeconds']}&nbsp;
      </td>";
    }

    echo "
    </tr>

    <tr><td><img src='" . OX::assetPath() . "/images/spacer.gif' height='1' width='100%'></td>
    <td colspan='2'><img src='" . OX::assetPath() . "/images/break-l.gif' height='1' width='200' vspace='6'></td>";

    if ($showExtra) {
        echo "
    <td><img src='" . OX::assetPath() . "/images/spacer.gif' height='1' width='100%'></td>
    <td colspan='2'><img src='" . OX::assetPath() . "/images/break-l.gif' height='1' width='200' vspace='6'></td>";
    }
    echo "<tr><td height='10' colspan='6'>&nbsp;</td></tr>";

    return $tabindex;
}

function _echoDeliveryCappingJs()
{
echo "
<script type='text/javascript'>
<!--// <![CDATA[
  $(document).ready(function() {
    $(\"#session_capping,#cap,#min_impressions\")
      .keypress(maskNonNumeric)
      .focus(prepareForText)
      .blur(enableResetCounterConditionally);
  });

  function prepareForText(event)
  {
    if (this.value == '-')  {
      this.value = '';
    }
  }


  function enableResetCounterConditionally()
  {
    var cappingSet = false;
    $('#session_capping,#cap').each(function()
    {
      if (this.value == '-' || this.value == '' || this.value == '0') {
        this.value = '-';
      }
      else {
        cappingSet = true;
      }
    });

    if (isResetCounterEnabled(this.form) != cappingSet) {
      setResetCounterEnabled(this.form, cappingSet);
    }
  }


  function isResetCounterEnabled(form)
  {
    var \$timeHourField = $(\"#timehour\");

    if (\$timeHourField.length == 0) {
        return false;
    }

    return !\$timeHourField.attr(\"disabled\");
  }


  function setResetCounterEnabled(form, cappingSet)
  {
      var disable = !cappingSet;
      if (form.timehour) {
        form.timehour.disabled = disable;
      }
      if (form.timeminute) {
        form.timeminute.disabled = disable;
      }
      if (form.timesecond) {
        form.timesecond.disabled = disable;
      }
  }


	/*function phpAds_formCapBlur(i)
	{
		if (i.value == '-' || i.value == '' || i.value == '0') {
		  i.value = '-';
		} else {
      oa_formSetTimeDisabled(i, false);
		}
	}*/


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


  /*function oa_formEnableTime(i)
  {
      f = i.form;
      f.timehour.disabled = false;
      f.timeminute.disabled = false;
      f.timesecond.disabled = false;
  }*/
// ]]> -->
</script>";
}

?>
