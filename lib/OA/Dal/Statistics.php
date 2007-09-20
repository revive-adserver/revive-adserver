<?php

/*
+---------------------------------------------------------------------------+
| Openads v${RELEASE_MAJOR_MINOR}                                           |
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
$Id:$
*/

/**
 * @package    Openads
 * @author     Ivan Klishch <iklishch@lohika.com>
 *
 * A file to description Stistics class.
 *
 */


/**
 * Class to description Stistics methods.
 *
 */
class OA_Dal_Statistics extends OA_Dal
{
    /**
     * Get SQL where for statistics methods.
     *
     * @param date &$oStartDate
     * @param date &$oEndDate
     * 
     * @return string
     */
    function getWhereDate(&$oStartDate, &$oEndDate)
    {
        $where = '';
        if (isset($oStartDate)) {
            $startDate = $this->oDbh->quote($oStartDate->format("%Y-%m-%d"), 'date');
            $where .= '
                AND
                s.day >= ' . $startDate;
        }

        if (isset($oEndDate)) {
            $endDate  = $this->oDbh->quote($oEndDate->format("%Y-%m-%d"), 'date');
            $where .= '
                AND
                s.day <= ' . $endDate;
        }
        return $where;
    }
}

?>