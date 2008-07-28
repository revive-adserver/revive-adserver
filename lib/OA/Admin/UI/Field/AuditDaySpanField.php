<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
| For contact details, see: http://www.openx.org/                           |
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

require_once MAX_PATH . '/lib/max/Admin/UI/Field/DaySpanField.php';
require_once MAX_PATH . '/lib/OA/Translation.php';

class OA_Admin_UI_Audit_DaySpanField extends Admin_UI_DaySpanField
{
    var $oTrans;

    function OA_Admin_UI_Audit_DaySpanField($name = 'AuditDaySpanField',
                         $fieldSelectionDefault = 'all_events',
                         $aFieldSelectionNames = null)
    {
        parent::Admin_UI_DaySpanField($name, $fieldSelectionDefault, $aFieldSelectionNames);
        $this->oTrans = new OA_Translation();
    }

    /**
     * Return the default $aFieldSelectionNames array
     *
     * @static
     * @see Admin_UI_DaySpanField::__construct()
     */
    function getDefaultSelectionNames()
    {
        return array(
            'all_events'  => $GLOBALS['strCollectedAllEvents'],
            'today'       => $GLOBALS['strCollectedToday'],
            'yesterday'   => $GLOBALS['strCollectedYesterday'],
            'this_week'   => $GLOBALS['strCollectedThisWeek'],
            'last_week'   => $GLOBALS['strCollectedLastWeek'],
            'last_7_days' => $GLOBALS['strCollectedLast7Days'],
            'this_month'  => $GLOBALS['strCollectedThisMonth'],
            'last_month'  => $GLOBALS['strCollectedLastMonth'],
            'specific'    => $GLOBALS['strCollectedSpecificDates']
          );
    }
    /**
     * A method that echos the HTML for this field.
     */
    function display()
    {
        $oStartDate = $this->getStartDate();
        $startDateStr = is_null($oStartDate) ? '' : $oStartDate->format('%Y-%m-%d');
        $oEndDate = $this->getEndDate();
        $endDateStr = is_null($oEndDate) ? '' : $oEndDate->format('%Y-%m-%d');

        echo "
        <select name='{$this->_name}_preset' id='{$this->_name}_preset' onchange='{$this->_name}FormChange(" . ($this->_autoSubmit ? 1 : 0) . ")' tabindex='" . $this->_tabIndex++ . "'>";

        foreach ($this->_fieldSelectionNames as $v => $n) {
            $selected = $v == $this->_fieldSelectionValue ? " selected='selected'" : '';
            echo "
            <option value='{$v}'{$selected}>{$n}</option>";
        }

        echo "
        </select>
        <label for='{$this->_name}_start' style='margin-left: 1em'> " . $this->oTrans->translate('From') . "</label>
        <input class='date' name='{$this->_name}_start' id='{$this->_name}_start' type='text' value='$startDateStr' tabindex='".$this->_tabIndex++."' />
        <input type='image' src='" . OX::assetPath() . "/images/icon-calendar.gif' id='{$this->_name}_start_button' align='absmiddle' border='0' tabindex='".$this->_tabIndex++."' />
        <label for='{$this->_name}_end' style='margin-left: 1em'> " . $this->oTrans->translate('To') . "</label>
        <input class='date' name='{$this->_name}_end' id='{$this->_name}_end' type='text' value='$endDateStr' tabindex='".$this->_tabIndex++."' />
        <input type='image' src='" . OX::assetPath() . "/images/icon-calendar.gif' id='{$this->_name}_end_button' align='absmiddle' border='0' tabindex='".$this->_tabIndex++."' />
        <script type='text/javascript'>
        <!--
        Calendar.setup({
            inputField : '{$this->_name}_start',
            ifFormat   : '%Y-%m-%d',
            button     : '{$this->_name}_start_button',
            align      : 'Bl',
            weekNumbers: false,
            firstDay   : " . ($GLOBALS['pref']['ui_week_start_day'] ? 1 : 0) . ",
            electric   : false
        })
        Calendar.setup({
            inputField : '{$this->_name}_end',
            ifFormat   : '%Y-%m-%d',
            button     : '{$this->_name}_end_button',
            align      : 'Bl',
            weekNumbers: false,
            firstDay   : " . ($GLOBALS['pref']['ui_week_start_day'] ? 1 : 0) . ",
            electric   : false
        })
        // Tabindex handling
        {$this->_name}TabIndex = " . ($this->_tabIndex - 4) . ";
        // Functions
        function {$this->_name}Reset()
        {
            document.getElementById('{$this->_name}_start').value = '$startDateStr';
            document.getElementById('{$this->_name}_start').value = '$endDateStr';
            document.getElementById('{$this->_name}_preset').value = '{$this->_fieldSelectionValue}';
        }
        function {$this->_name}FormSubmit() {
            submitForm();
            return false;
        }
        function {$this->_name}FormChange(bAutoSubmit)
        {
            var o = document.getElementById('{$this->_name}_preset');
            var {$this->_name}SelectName = o.options[o.selectedIndex].value;
            var specific = {$this->_name}SelectName == 'specific';";

        $oTmpDaySpan = new OA_Admin_DaySpan();
        foreach ($this->_fieldSelectionNames as $v => $n) {
            if ($v != 'specific') {
                if ($v != 'all_events') {
                    $oTmpDaySpan->setSpanPresetValue($v);
                    $oTmpStartDate = $oTmpDaySpan->getStartDate();
                    $sTmpStartDate = $oTmpStartDate->format('%Y-%m-%d');
                    $oTmpEndDate   = $oTmpDaySpan->getEndDate();
                    $sTmpEndDate   = $oTmpEndDate->format('%Y-%m-%d');
                } else {
                    $sTmpStartDate = '';
                    $sTmpEndDate   = '';
                }
                echo "
            if ({$this->_name}SelectName == '$v') {
                document.getElementById('{$this->_name}_start').value = '$sTmpStartDate';
                document.getElementById('{$this->_name}_end').value = '$sTmpEndDate';
            }
                ";
            }
        }

        echo "

            document.getElementById('{$this->_name}_start').readOnly = !specific;
            document.getElementById('{$this->_name}_end').readOnly = !specific;

            if (!specific) {
                document.getElementById('{$this->_name}_start').style.backgroundColor = '#CCCCCC';
                document.getElementById('{$this->_name}_end').style.backgroundColor = '#CCCCCC';
                document.getElementById('{$this->_name}_start').tabIndex = null;
                document.getElementById('{$this->_name}_start_button').tabIndex = null;
                document.getElementById('{$this->_name}_end').tabIndex = null;
                document.getElementById('{$this->_name}_end_button').tabIndex = null;
            } else {
                document.getElementById('{$this->_name}_start').style.backgroundColor = '#FFFFFF';
                document.getElementById('{$this->_name}_end').style.backgroundColor = '#FFFFFF';
                document.getElementById('{$this->_name}_start').tabIndex = {$this->_name}TabIndex;
                document.getElementById('{$this->_name}_start_button').tabIndex = {$this->_name}TabIndex + 1;
                document.getElementById('{$this->_name}_end').tabIndex = {$this->_name}TabIndex + 2;
                document.getElementById('{$this->_name}_end_button').tabIndex = {$this->_name}TabIndex + 3;
            }

            document.getElementById('{$this->_name}_start_button').readOnly = !specific;
            document.getElementById('{$this->_name}_end_button').readOnly = !specific;
            document.getElementById('{$this->_name}_start_button').src = specific ? '" . OX::assetPath() . "/images/icon-calendar.gif' : '" . OX::assetPath() . "/images/icon-calendar-d.gif';
            document.getElementById('{$this->_name}_end_button').src = specific ? '" . OX::assetPath() . "/images/icon-calendar.gif' : '" . OX::assetPath() . "/images/icon-calendar-d.gif';
            document.getElementById('{$this->_name}_start_button').style.cursor = specific ? 'auto' : 'default';
            document.getElementById('{$this->_name}_end_button').style.cursor = specific ? 'auto' : 'default';

            if (!specific && bAutoSubmit) {
                submitForm();
            }
        }
        {$this->_name}FormChange(0);
        //-->
        </script>";
    }
}
?>
