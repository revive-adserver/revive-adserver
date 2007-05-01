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

require_once MAX_PATH . '/lib/OA/Admin/Statistics/Common.php';

/**
 * A class of helper methods that can be called from the delivery statistics
 * Flexy templates to help display the required data.
 *
 * @package    OpenadsAdmin
 * @subpackage StatisticsDelivery
 * @author     Matteo Beccati <matteo@beccati.com>
 * @author     Andrew Hill <andrew.hill@openads.org>
 */
class OA_Admin_Statistics_Delivery_Flexy extends OA_Admin_Statistics_Common
{

    /**
     * Return the link for a column
     *
     * @param array Entity array
     * @param array Column name
     * @return string Link associated with a column
     */
    function showColumnLink($entity, $column)
    {
        return empty($this->aColumnLinks[$column]) || empty($entity['linkparams']) ? '' : $this->aColumnLinks[$column];
    }

    /**
     * Return the visibility status of a column -- helper function for Flexy
     *
     * @param string Column name
     * @return boolean True if the column is vilible
     */
    function showColumn($column)
    {
        return isset($this->aColumnVisible[$column]) ? $this->aColumnVisible[$column] : true;
    }

    /**
     * Return an array field
     *
     * @param array The array
     * @param array Field name
     * @return mixed Field value
     */
    function showValue($e, $k)
    {
        return $e[$k];
    }

    /**
     * Return a translated string
     *
     * @param string Name of the translation string
     *
     * @see getTranslation
     */
    function tr($str)
    {
        if (preg_match('/^(str|key)/', $str) && isset($GLOBALS[$str])) {
            $str = $GLOBALS[$str];
        }

        return $str;
    }

    /**
     * Return the link to change sorting field and order
     *
     * @param string Name of the field
     * @param boolean Reverse default sorting
     * @return string The href parameter
     */
    function listOrderHref($fieldname, $reverse = false)
    {
        if ($this->listOrderField == $fieldname) {
            $orderdirection = $this->listOrderDirection == 'up' ? 'down' : 'up';
        } else {
            $orderdirection = $reverse ? 'down' : 'up';
        }

        return "{$this->pageURI}listorder={$fieldname}&orderdirection={$orderdirection}";
    }

    /**
     * Return the link to change sorting field and order using reversed
     * order by default -- helper function for Flexy
     *
     * @param string Name of the field
     * @return string The href parameter
     */
    function listOrderHrefRev($fieldname)
    {
        return $this->listOrderHref($fieldname, true);
    }

    /**
     * Return the image to show current ordering
     *
     * The function returns false if the data is not sorted by $fieldname
     *
     * @param string Name of the field
     * @return mixed Image src parameter
     */
    function listOrderImage($fieldname)
    {
        if ($this->listOrderField == $fieldname) {
            return "images/caret-".($this->listOrderDirection == 'up' ? 'u': 'ds').".gif";
        } else {
            return false;
        }
    }

}

?>