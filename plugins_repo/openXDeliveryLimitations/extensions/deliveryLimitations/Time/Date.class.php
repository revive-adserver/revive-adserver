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

require_once OX_EXTENSIONS_PATH . '/deliveryLimitations/DeliveryLimitations.php';
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
        return MAX_Plugin_Translation::translate('Date', $this->extension, $this->group);
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
}

?>
