<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2009 OpenX Limited                                     |
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
$Id:$
*/

/**
 * @package    OpenX
 * @author     Ivan Klishch <iklishch@lohika.com>
 *
 */


/**
 * Satistics methods description class.
 *
 * @package    OpenXDal
 */
class OA_Dal_Statistics extends OA_Dal
{
    /**
     * Get SQL where for statistics methods.
     *
	 * @access public
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
            $startDate = $this->oDbh->quote($oStartDate->format("%Y-%m-%d 00:00:00"), 'timestamp');
            $where .= '
                AND
                s.date_time >= ' . $startDate;
        }

        if (isset($oEndDate)) {
            $endDate  = $this->oDbh->quote($oEndDate->format("%Y-%m-%d 23:59:59"), 'timestamp');
            $where .= '
                AND
                s.date_time <= ' . $endDate;
        }
        return $where;
    }

    /**
     * Add quote for table name.
     *
	 * @access public
	 *
     * @param string $tableName
     *
     * @return string  quotes table name
     */
    function quoteTableName($tableName)
    {
        $aConf = $GLOBALS['_MAX']['CONF'];

        return $this->oDbh->quoteIdentifier(
                            $aConf['table']['prefix'].$aConf['table'][$tableName],
                            true);
    }

}

?>