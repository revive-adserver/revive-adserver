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

/**
 * A view field for the OA_Admin_DaySpan object.
 *
 * @package    Max
 */
require_once MAX_PATH . '/lib/max/Admin/UI/Field.php';

require_once MAX_PATH . '/lib/OA/Admin/DaySpan.php';

class Admin_UI_DaySpanField extends Admin_UI_Field
{
    /* @var string */
    public $_fieldSelectionValue;
    /* @var array */
    public $_fieldSelectionNames;
    /* @var boolean */
    public $_autoSubmit;

    /**
     * Constructor
     *
     * @param array $aFieldSelectionNames A list of the predefined 'friendly' selections.
     * @param string $fieldSelectionDefault The default selection.
     */
    public function __construct(
        $name = 'DaySpanField',
        $fieldSelectionDefault = 'last_month',
        $aFieldSelectionNames = null
    ) {
        parent::__construct();
        if (is_null($aFieldSelectionNames)) {
            $aFieldSelectionNames = $this->getDefaultSelectionNames();
        }
        $this->_name = $name;
        $this->_fieldSelectionNames = $aFieldSelectionNames;
        $this->_value = new OA_Admin_DaySpan($fieldSelectionDefault);

        // Disable auto-submit by default
        $this->disableAutoSubmit();
    }


    /**
     * Return the default $aFieldSelectionNames array
     *
     * @static
     * @see Admin_UI_DaySpanField::__construct()
     */
    public function getDefaultSelectionNames()
    {
        return [
            'today' => $GLOBALS['strCollectedToday'],
            'yesterday' => $GLOBALS['strCollectedYesterday'],
            'this_week' => $GLOBALS['strCollectedThisWeek'],
            'last_week' => $GLOBALS['strCollectedLastWeek'],
            'last_7_days' => $GLOBALS['strCollectedLast7Days'],
            'this_month' => $GLOBALS['strCollectedThisMonth'],
            'last_month' => $GLOBALS['strCollectedLastMonth'],
            'all_stats' => $GLOBALS['strCollectedAllStats'],
            'specific' => $GLOBALS['strCollectedSpecificDates']
          ];
    }




    /**
     * A method to enable the auto-submit feature on selection change
     */
    public function enableAutoSubmit()
    {
        $this->_autoSubmit = true;
    }

    /**
     * A method to disable the auto-submit feature on selection change
     */
    public function disableAutoSubmit()
    {
        $this->_autoSubmit = false;
    }

    /**
     * A method to set the value of the field using a preset 'friendly' selection.
     *
     * @param string $presetValue The preset value.
     */
    public function setValue($presetValue)
    {
        $this->_fieldSelectionValue = $presetValue;
        $this->_value = new OA_Admin_DaySpan($presetValue);
    }

    /**
     * A method to set the value of the field using the input querystring fields passed in from the HTML.
     *
     * @param array $aQuerystring The querystring of this field.
     */
    public function setValueFromArray($aFieldValues)
    {
        $fieldSelectionName = $aFieldValues[$this->_name . '_preset'];
        if (!empty($fieldSelectionName)) {
            if ($fieldSelectionName == 'specific') {
                $oDaySpan = new OA_Admin_DaySpan();
                $sStartDate = $aFieldValues[$this->_name . '_start'];
                $oStartDate = new Date();

                if ($sStartDate == '') {
                    $sStartDate = '1995-01-01';
                }

                $oStartDate->setDate($sStartDate);

                $sEndDate = $aFieldValues[$this->_name . '_end'];
                $oEndDate = new Date();

                if ($sEndDate != '') {
                    $oEndDate->setDate($sEndDate);
                }

                $oDaySpan->setSpanDays($oStartDate, $oEndDate);
            } elseif ($fieldSelectionName == 'all_stats') {
                $oDaySpan = null;
            } else {
                $oDaySpan = new OA_Admin_DaySpan($fieldSelectionName);
            }
            $this->_value = $oDaySpan;
            $this->_fieldSelectionValue = $fieldSelectionName;
        }
    }

    /**
     * A method that retrieves the start date of this field's OA_Admin_DaySpan.
     *
     * @return Date the start date of the this field.
     */
    public function getStartDate()
    {
        $oDaySpan = $this->_value;
        $value = is_null($oDaySpan) ? null : $oDaySpan->getStartDate();
        return $value;
    }

    /**
     * A method that retrieves the end date of this field's OA_Admin_DaySpan.
     *
     * @return Date the end date of the this field.
     */
    public function getEndDate()
    {
        $oDaySpan = $this->_value;
        $value = is_null($oDaySpan) ? null : $oDaySpan->getEndDate();
        return $value;
    }

    /**
     * A method that returns an array representing the start and end dates of the span.
     *
     * @return array the begin and end dates of the span
     */
    public function getDaySpanArray()
    {
        $aDaySpan = [];
        $oDaySpan = $this->_value;
        if (!empty($oDaySpan)) {
            $aDaySpan['day_begin'] = $oDaySpan->getStartDateString();
            $aDaySpan['day_end'] = $oDaySpan->getEndDateString();
        }
        return $aDaySpan;
    }

    /**
     * A method that echos the HTML for this field.
     */
    public function display()
    {
        $oStartDate = $this->getStartDate();
        $startDateStr = is_null($oStartDate) ? '' : $oStartDate->format('%d %B %Y ');
        $oEndDate = $this->getEndDate();
        $endDateStr = is_null($oEndDate) ? '' : $oEndDate->format('%d %B %Y');

        echo "
        <select name='{$this->_name}_preset' id='{$this->_name}_preset' onchange='{$this->_name}FormChange(" . ($this->_autoSubmit ? 1 : 0) . ")' tabindex='" . $this->_tabIndex++ . "'>";

        foreach ($this->_fieldSelectionNames as $v => $n) {
            $selected = $v == $this->_fieldSelectionValue ? " selected='selected'" : '';
            echo "
            <option value='{$v}'{$selected}>{$n}</option>";
        }

        echo "
        </select>
        <label for='{$this->_name}_start' style='margin-left: 1em'>{$GLOBALS['strFrom']}</label>
        <input class='date' name='{$this->_name}_start' id='{$this->_name}_start' type='text' value='$startDateStr' tabindex='" . $this->_tabIndex++ . "' />
        <input type='image' src='" . OX::assetPath() . "/images/icon-calendar.gif' id='{$this->_name}_start_button' align='absmiddle' border='0' tabindex='" . $this->_tabIndex++ . "' />
        <label for='{$this->_name}_end' style='margin-left: 1em'> {$GLOBALS['strTo']}</label>
        <input class='date' name='{$this->_name}_end' id='{$this->_name}_end' type='text' value='$endDateStr' tabindex='" . $this->_tabIndex++ . "' />
        <input type='image' src='" . OX::assetPath() . "/images/icon-calendar.gif' id='{$this->_name}_end_button' align='absmiddle' border='0' tabindex='" . $this->_tabIndex++ . "' />
        <script type='text/javascript'>
        <!--
        Calendar.setup({
            inputField : '{$this->_name}_start',
            ifFormat   : '%d %B %Y',
            button     : '{$this->_name}_start_button',
            align      : 'Bl',
            weekNumbers: false,
            firstDay   : " . ($GLOBALS['pref']['ui_week_start_day'] ? 1 : 0) . ",
            electric   : false
        });
        Calendar.setup({
            inputField : '{$this->_name}_end',
            ifFormat   : '%d %B %Y',
            button     : '{$this->_name}_end_button',
            align      : 'Bl',
            weekNumbers: false,
            firstDay   : " . ($GLOBALS['pref']['ui_week_start_day'] ? 1 : 0) . ",
            electric   : false
        });

        var field = document.getElementById('{$this->_name}_start');
        var oldOnSubmit = field.form.onsubmit;

        field.form.onsubmit = function() {
          if(oldOnSubmit) {
            oldOnSubmit();
          }

          return checkDates(this);
        }

        function checkDates(form)
        {
          var startField = form.{$this->_name}_start;
          var endField = form.{$this->_name}_end;

          if (!startField.disabled && startField.value != '') {
            var start = Date.parseDate(startField.value, '%d %B %Y');
          }
          if (!startField.disabled && endField.value != '') {
            var end = Date.parseDate(endField.value, '%d %B %Y');
          }

          if ((start != undefined && end != undefined) && (start.getTime() > end.getTime())) {
            alert('" . addslashes($GLOBALS['strFieldStartDateBeforeEnd']) . "');
            return false;
          }
          return true;
        }

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
            var form = document.getElementById('{$this->_name}_preset').form;
            if (checkDates(form)) {
              form.submit();
            }
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
                if ($v != 'all_stats') {
                    $oTmpDaySpan->setSpanPresetValue($v);
                    $oTmpStartDate = $oTmpDaySpan->getStartDate();
                    $sTmpStartDate = $oTmpStartDate->format('%d %B %Y');
                    $oTmpEndDate = $oTmpDaySpan->getEndDate();
                    $sTmpEndDate = $oTmpEndDate->format('%d %B %Y');
                } else {
                    $sTmpStartDate = '';
                    $sTmpEndDate = '';
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
            document.getElementById('{$this->_name}_start_button').disabled = !specific;
            document.getElementById('{$this->_name}_end').readOnly = !specific;
            document.getElementById('{$this->_name}_end_button').disabled = !specific;

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
                o.form.submit();
            }
        }
        {$this->_name}FormChange(0);
        //-->
        </script>";
    }
}
