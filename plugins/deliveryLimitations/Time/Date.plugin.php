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

require_once MAX_PATH . '/plugins/deliveryLimitations/DeliveryLimitations.php';
require_once MAX_PATH . '/lib/max/Plugin/Translation.php';
require_once MAX_PATH . '/lib/pear/Date.php';

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
 * @author     Andrew Hill <andrew@m3.net>
 * @author     Chris Nutting <chris@m3.net>
 */
class Plugins_DeliveryLimitations_Time_Date extends Plugins_DeliveryLimitations
{
    function Plugins_DeliveryLimitations_Time_Date()
    {
        $this->aOperations = array(
            '==' => $GLOBALS['strEqualTo'],
            '!=' => $GLOBALS['strDifferentFrom'],
            '>' => $GLOBALS['strLaterThan'],
            '>=' =>$GLOBALS['strLaterThanOrEqual'],
            '<' => $GLOBALS['strEarlierThan'],
            '<=' => $GLOBALS['strEarlierThanOrEqual']
        );
    }


    function init($data)
    {
        parent::init($data);
        if (empty($this->data)) {
            $this->data = '00000000';
        } elseif (is_array($this->data)) {
            $this->data = $this->_flattenData($this->data);
        }
    }

    /**
     * Return name of plugin
     *
     * @return string
     */
    function getName()
    {
        return MAX_Plugin_Translation::translate('Date', $this->module, $this->package);
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
        <input type='image' src='images/icon-calendar.gif' id='{$this->executionorder}_button' align='absmiddle' border='0' tabindex='".$tabindex++."' />
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
        if (is_null($data)) {
            $data = $this->data;
        }
        if (is_array($data)) {
            if (empty($data['date'])) {
                return '00000000';
            } elseif (!empty($data['date'])) {
                return date('Ymd', strtotime($data['date']));
            }
            return sprintf('%04d%02d%02d', $data['year'], $data['month'], $data['day']);
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
        if (is_null($data)) {
            $data = $this->data;
        }
        if (($data == '00000000') || (empty($data))) {
            return array(
                'day'   => 0,
                'month' => 0,
                'year'  => 0
            );
        } else {
            if (!is_array($data)) {
                return array(
                    'day'   => substr($this->data, 6, 2),
                    'month' => substr($this->data, 4, 2),
                    'year'  => substr($this->data, 0, 4)
                );
            }
        }
        return $data;
    }

    /**
     * An overridden version of the parent method, as there is a specific way this
     * delivery limitation will always match.
     *
     * @access private
     * @param string $comparison As for Plugins_DeliveryLimitations::_testGetAsSqlValues().
     * @param string $data As for Plugins_DeliveryLimitations::_testGetAsSqlValues().
     * @param boolean $allowEmpty As for Plugins_DeliveryLimitations::_testGetAsSqlValues().
     * @return mixed As for Plugins_DeliveryLimitations::_testGetAsSqlValues().
     */
    function _testGetAsSqlValues($comparison, $data, $allowEmpty = false)
    {
        $value = parent::_testGetAsSqlValues($comparison, $data, $allowEmpty);
        if (is_null($value)) {
            // Test the plugin specific "easy" match
            if ($data == '00000000') {
                return true;
            }
        }
        return null;
    }

    /**
     * A private method to return this delivery limitation plugin as a SQL limiation.
     *
     * @access private
     * @param string $comparison As for Plugins_DeliveryLimitations::_getSqlLimitation().
     * @param string $data A date in YYYYMMDD format.
     * @return mixed As for Plugins_DeliveryLimitations::_getSqlLimitation().
     *
     * @TODO Needs to be changed to deal with databases other than MySQL.
     */
    function _getSqlLimitation($comparison, $data)
    {
        if ($comparison == '==') {
            $comparison = '=';
        }
        return "DATE_FORMAT(date_time, '%Y%m%d') $comparison '$data'";
    }

    /**
     * A method to compare two comparison and data groups of the same delivery
     * limitation type, and determine if the delivery limitations have any
     * overlap, or not.
     *
     * @param array $aLimitation1 An array containing the "comparison" and "data"
     *                            fields of the first delivery limitation.
     * @param array $aLimitation2 An array containing the "comparison" and "data"
     *                            fields of the second delivery limitation.
     * @return boolean True if there is overlap between the two delivery limitations,
     *                 false if there is NOT any overlap.
     */
    function overlap($aLimitation1, $aLimitation2)
    {
        // If either date limitations have '000000000' as the data values, then
        // there will be overlap, as that limitation will always match
        if ($aLimitation1['data'] == '00000000' || $aLimitation2['data'] == '00000000') {
            return true;
        }
        $oDate1 = new Date($aLimitation1['data']);
        $oDate2 = new Date($aLimitation2['data']);
        switch ($aLimitation1['comparison']) {
            case '==':
                // There will be overlap, unless the second limitation
                // a) Shows only on a different date
                // b) Does not show on this date
                // c) Shows before this date
                // d) Shows after this date
                if ($aLimitation2['comparison'] == '==' && !$oDate1->equals($oDate2)) {
                    return false;
                }
                if ($aLimitation2['comparison'] == '!=' && $oDate1->equals($oDate2)) {
                    return false;
                }
                if ($aLimitation2['comparison'] == '<' && !$oDate2->after($oDate1)) {
                    return false;
                }
                if ($aLimitation2['comparison'] == '<=' && $oDate2->before($oDate1)) {
                    return false;
                }
                if ($aLimitation2['comparison'] == '>' && !$oDate2->before($oDate1)) {
                    return false;
                }
                if ($aLimitation2['comparison'] == '>=' && $oDate2->after($oDate1)) {
                    return false;
                }
                break;

            case '!=':
                // There will be overlap, unless the second limitation
                // only shows on the date that the first does not
                if ($aLimitation2['comparison'] == '==' && $oDate1->equals($oDate2)) {
                    return false;
                }
                break;

            case '<':
                // There will be overlap, unless the second limitation
                // shows on a date equal to or after this date
                if ($aLimitation2['comparison'] == '==' && !$oDate2->before($oDate1)) {
                    return false;
                }
                if ($aLimitation2['comparison'] == '>') {
                    // Special case, $oDate2 can be up to ONE DAY before $oDate1
                    $oTestDate = new Date();
                    $oTestDate->copy($oDate1);
                    $oTestDate->subtractSeconds(SECONDS_PER_DAY);
                    if (!$oDate2->before($oTestDate)) {
                        return false;
                    }
                }
                if ($aLimitation2['comparison'] == '>=' && !$oDate2->before($oDate1)) {
                    return false;
                }
                break;

            case '<=':
                // There will be overlap, unless the second limitation
                // shows on a date after this date
                if ($aLimitation2['comparison'] == '==' && $oDate2->after($oDate1)) {
                    return false;
                }
                if ($aLimitation2['comparison'] == '>' && !$oDate2->before($oDate1)) {
                    return false;
                }
                if ($aLimitation2['comparison'] == '>=' && $oDate2->after($oDate1)) {
                    return false;
                }
                break;

            case '>':
                // There will be overlap, unless the second limitation
                // shows on a date equal to or before this date
                if ($aLimitation2['comparison'] == '==' && !$oDate2->after($oDate1)) {
                    return false;
                }
                if ($aLimitation2['comparison'] == '<') {
                    // Special case, $oDate2 can be up to ONE DAY after $oDate1
                    $oTestDate = new Date();
                    $oTestDate->copy($oDate1);
                    $oTestDate->addSeconds(SECONDS_PER_DAY);
                    if (!$oDate2->after($oTestDate)) {
                        return false;
                    }
                }
                if ($aLimitation2['comparison'] == '<=' && !$oDate2->after($oDate1)) {
                    return false;
                }
                break;

            case '>=':
                // There will be overlap, unless the second limitation
                // shows on a date before this date
                if ($aLimitation2['comparison'] == '==' && $oDate2->before($oDate1)) {
                    return false;
                }
                if ($aLimitation2['comparison'] == '<' && !$oDate2->after($oDate1)) {
                    return false;
                }
                if ($aLimitation2['comparison'] == '<=' && $oDate2->before($oDate1)) {
                    return false;
                }
                break;
        }
        return true;
    }

    /**
     * A method to upgrade the Time:Date delivery limitation plugin from v0.3.29-alpha
     * to v0.3.31-alpha format.
     *
     * @param string $op The comparison string for the limitation in v0.3.29-alpha format.
     * @param string $sData The comparison data for the limitation in v0.3.29-alpha format.
     * @return array An array of two items, indexed by "op" and "data", which are the new
     *               v0.3.31-alpha format versions of the parameters above.
     */
    function getDeliveryLimitationPluginUpgradeThreeThirtyOneAlpha($op, $sData)
    {
        return array('op' => $op, 'data' => $sData);
    }

    /**
     * A method to downgrade the Time:Date delivery limitation plugin from v0.3.29-alpha
     * to v0.3.31-alpha format.
     *
     * @param string $op The comparison string for the limitation in v0.3.31-alpha format.
     * @param string $sData The comparison data for the limitation in v0.3.31-alpha format.
     * @return array An array of two items, indexed by "op" and "data", which are the old
     *               v0.3.29-alpha format versions of the parameters above.
     */
    function getDeliveryLimitationPluginDowngradeThreeTwentyNineAlpha($op, $sData)
    {
        return array('op' => $op, 'data' => $sData);
    }
}

?>
