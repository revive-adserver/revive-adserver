<?php
/*
+---------------------------------------------------------------------------+
| Max Media Manager v0.3                                                    |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2006 m3 Media Services Limited                         |
| For contact details, see: http://www.m3.net/                              |
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

/**
 * Legal agreement DAL for Max Media Manager
 *
 * @package MaxDal
 * @since 0.3.22 - Apr 13, 2006
 * @copyright 2006 M3 Media Services
 * @version $Id$
 */

require_once MAX_PATH.'/lib/max/Dal/Common.php';

class MAX_Dal_LegalAgreement extends MAX_Dal_Common
{
    /**
     * Has the specified publisher agreed to their agency's terms and conditions?
     * 
     * @param int $publisher_id  The id number representing a publisher to check
     * @return bool True if the publisher has ever agreed to their agency's terms
     */
    function hasPublisherAgreed($publisher_id)
    {
        $publisher_table = $this->getFullTableName('affiliates');
        $query = "
            SELECT last_accepted_agency_agreement
            FROM $publisher_table
            WHERE affiliateid = $publisher_id
        ";
        $agreed_date_string = $this->oDbh->queryOne($query);
        if (is_null($agreed_date_string)) {
            return false;
        }
        return true; 
    }
    
    /**
     * Mark a publisher as having agreed to their agency's terms.
     * 
     * Records a timestamp that they agreed, based on the database's idea of the
     * current time.
     * 
     * @param int $publisher_id  The id number representing a publisher who has agreed
     */
    function acceptAgreementForPublisher($publisher_id)
    {
        $publisher_table = $this->getFullTableName('affiliates');
        $query = "
            UPDATE $publisher_table
            SET last_accepted_agency_agreement = NOW()
            WHERE affiliateid = $publisher_id
        ";
        $this->oDbh->exec($query);
    }
    
    /**
     * Mark a publisher as NOT having agreed yet to their agency's terms.
     * 
     * @param int $publisher_id  The id number representing a publisher who has not yet agreed
     */
    function unAcceptAgreementForPublisher($publisher_id)
    {
        $publisher_table = $this->getFullTableName('affiliates');
        $query = "
            UPDATE $publisher_table
            SET last_accepted_agency_agreement = NULL
            WHERE affiliateid = $publisher_id
        ";
        $this->oDbh->exec($query);
    }
    
    function getAgreementTextForAgency($agency_id)
    {
        $preference_table = $this->getFullTableName('preference');
        $query = "
            SELECT publisher_agreement_text
            FROM $preference_table
            WHERE agencyid = $agency_id
        ";
        return $this->oDbh->queryOne($query);
    }
    
    function isAgreementNecessaryForPublisher($publisher_id)
    {
        if (!$this->doesAgreementExistForPublisher($publisher_id)) {
            return false;
        }
        return !$this->hasPublisherAgreed($publisher_id);
    }
    
    function doesAgreementExistForPublisher($publisher_id)
    {
        $publisher_table = $this->getFullTableName('affiliates');
        $preference_table = $this->getFullTableName('preference');
        $query = "
            SELECT IF(a.publisher_agreement = 't', 1, 0) AS has_agreement
            FROM $publisher_table p
                LEFT JOIN $preference_table a
                ON p.agencyid = a.agencyid
            WHERE p.affiliateid = $publisher_id
        ";
        $has_agreement = $this->oDbh->queryOne($query);
        return $has_agreement == 1;
    }
    
    function doesAgreementExistForAgency($agency_id)
    {
        $preference_table = $this->getFullTableName('preference');
        $query = "
            SELECT IF(a.publisher_agreement = 't', 1, 0) AS has_agreement
            FROM $preference_table a
            WHERE a.agencyid = $agency_id
        ";
        $has_agreement = $this->oDbh->queryOne($query);
        return $has_agreement == 1;
    }
    
    /**
     * Prepend table prefix to the given table name.
     * 
     * @param string $short_table_name The unqualified table name, like 'agency' or 'banners'
     * @return string A table name suitable for use in SQL "FROM" clauses
     */
    function getFullTableName($short_table_name)
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        $full_table_name = $conf['table']['prefix'] . $short_table_name;
        return $full_table_name;
    }
}

?>
