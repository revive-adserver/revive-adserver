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

require_once LIB_PATH . '/Extension/deliveryLimitations/DeliveryLimitations.php';
require_once MAX_PATH . '/lib/max/Plugin/Translation.php';
require_once MAX_PATH . '/lib/OA/Maintenance/Priority/DeliveryLimitation/Common.php';

/**
 * A Time delivery limitation plugin, for blocking delivery of ads on the basis
 * of the date.
 *
 * Works with:
 * Dates in YYYYMMDD format. Dates of value "00000000" mean the ads always display.
 *
 * Valid comparison operators:
 * ==, !=, <, <=, >, >=
 *
 * @package    OpenXPlugin
 * @subpackage DeliveryLimitations
 */
class Plugins_DeliveryLimitations_Time_Date extends Plugins_DeliveryLimitations
{
    function __construct()
    {
        $this->aOperations = array(
            '==' => $GLOBALS['strEqualTo'],
            '!=' => $GLOBALS['strDifferentFrom'],
            '>' => $GLOBALS['strLaterThan'],
            '>=' =>$GLOBALS['strLaterThanOrEqual'],
            '<' => $GLOBALS['strEarlierThan'],
            '<=' => $GLOBALS['strEarlierThanOrEqual']
        );

        $this->nameEnglish = 'Time - Date';
    }


    function init($data)
    {
        parent::init($data);
        $this->data = $this->_flattenData($this->data);
    }

    /**
     * Return if this plugin is available in the current context
     *
     * @return boolean
     */
    function isAllowed($page = false)
    {
        return ($page != 'channel-acl.php');
    }

    /**
     * Outputs the HTML to display the data for this limitation
     *
     * @return void
     */
    function displayData()
    {
        $this->data = $this->_expandData($this->data);
        $tabindex =& $GLOBALS['tabindex'];

        if ($this->data['day'] == 0 && $this->data['month'] == 0 && $this->data['year'] == 0) {
            $set = false;
        } else {
            $set = true;
        }

        echo "<table><tr><td>";

        if ($set) {
        $oDate = new Date($this->data['year'] .'-'. $this->data['month'] .'-'. $this->data['day']);
        }
        $dateStr = is_null($oDate) ? '' : $oDate->format('%d %B %Y ');

        echo "
        <input class='date' name='acl[{$this->executionorder}][data][date]' id='acl[{$this->executionorder}][data][day]' type='text' value='$dateStr' tabindex='".$tabindex++."' />
        <input type='image' src='" . OX::assetPath() . "/images/icon-calendar.gif' id='{$this->executionorder}_button' align='absmiddle' border='0' tabindex='".$tabindex++."' />
        <script type='text/javascript'>
        <!--
        Calendar.setup({
            inputField : 'acl[{$this->executionorder}][data][day]',
            ifFormat   : '%d %B %Y',
            button     : '{$this->executionorder}_button',
            align      : 'Bl',
            weekNumbers: false,
            firstDay   : " . ($GLOBALS['pref']['begin_of_week'] ? 1 : 0) . ",
            electric   : false
        })
        //-->
        </script>";

        echo "</td></tr></table>";

        $this->data = $this->_flattenData($this->data);
    }

    /**
     * A method that returnes the currently stored timezone for the limitation
     *
     * @return string
     */
    function getStoredTz()
    {
        $offset = strpos($this->data, '@');
        if ($offset !== false) {
            return substr($this->data, $offset + 1);
        }
        return 'UTC';
    }

    /**
     * A private method that returnes the current timezone as set in the user preferences
     *
     * @return string
     */
    function _getCurrentTz()
    {
        if (isset($GLOBALS['_MAX']['PREF']['timezone'])) {
            $tz = $GLOBALS['_MAX']['PREF']['timezone'];
        } else {
            $tz = 'UTC';
        }

        return $tz;
    }

    /**
     * A private method to "flatten" a delivery limitation into the string format that is
     * saved to the database (either in the acls, acls_channel or banners table, when part
     * of a compiled limitation string).
     *
     * Flattens the date array into string format.
     *
     * @access private
     * @param mixed $data An optional, expanded form delivery limitation.
     * @return string The delivery limitation in flattened format.
     */
    function _flattenData($data = null)
    {
        if (!isset($data)) {
            $data = $this->data;
        } elseif (is_array($data)) {
            if (empty($data['date'])) {
                $data = '00000000';
            } else {
                $data = date('Ymd', strtotime($data['date'])).'@'.$this->_getCurrentTz();
            }
        }
        return $data;
    }

    /**
     * A private method to "expand" a delivery limitation from the string format that
     * is saved in the database (ie. in the acls or acls_channel table) into its
     * "expanded" form.
     *
     * Expands the string format into an array of the day, month and year.
     *
     * @access private
     * @param string $data An optional, flat form delivery limitation data string.
     * @return mixed The delivery limitation data in expanded format.
     */
    function _expandData($data = null)
    {
        if (!isset($data)) {
            $data = $this->data;
        }
        if (is_array($data)) {
            return $data;
        }
        $parts = explode('@', $data);
        $data = $parts[0];
        $tz = isset($parts[1]) ? $parts[1] : 'UTC';
        if ($data == '00000000' || empty($data)) {
            $data = array(
                'day'   => 0,
                'month' => 0,
                'year'  => 0,
                'tz'    => $tz,
            );
        } else {
            $data = array(
                'day'   => substr($data, 6, 2),
                'month' => substr($data, 4, 2),
                'year'  => substr($data, 0, 4),
                'tz'    => $tz,
            );
        }
        return $data;
    }

    /**
     * A method to return an instance to be used by the MPE
     *
     * @param unknown_type $aDeliveryLimitation
     */
    function getMpeClassInstance($aDeliveryLimitation)
    {
        return new OA_Maintenance_Priority_DeliveryLimitation_Common($aDeliveryLimitation);
    }
}

?>