up<?php

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

/**
 * Table Definition for images
 */
require_once 'DB_DataObjectCommon.php';

class DataObjects_Images extends DB_DataObjectCommon
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'images';                          // table name
    var $filename;                        // string(128)  not_null primary_key
    var $contents;                        // blob(4294967295)  not_null blob binary
    var $t_stamp;                         // datetime(19)  binary

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Images',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE


    /**
     * fetches next row into this objects var's
     *
     * Note: it is ovverridden to deal with automatic unescaping of blob data on pgsql,
     *       also dealing with the MDB2_PORTABILITY_RTRIM option which needs to be disabled
     *       in order to retrieve correct binary data
     *
     * @access  public
     * @return  boolean on success
     */
    function fetch()
    {
        $oDbh = &$this->getDatabaseConnection();
        if (empty($oDbh)) {
            return false;
        }
        // When using PgSQL we need to disable MDB2_PORTABILITY_RTRIM portability option
        if ($psql = $oDbh->dbsyntax == 'pgsql') {
            $portability = $oDbh->getOption('portability');
            if ($rtrim = $portability & MDB2_PORTABILITY_RTRIM) {
                $oDbh->setOption('portability', $portability ^ MDB2_PORTABILITY_RTRIM);
            }
        }
        // Fetch result
        $result = parent::fetch();
        // Reset portability options, in case they have been modified
        if ($pgsql && $rtrim) {
            $oDbh->setOption('portability', $portability);
        }
        // Unescape data on PgSQL
        if ($pgsql && $result) {
            $this->contents = pg_unescape_bytea($this->contents);
        }

        return $result;
    }

    /**
     * Table has no autoincrement/sequence so we override sequenceKey().
     *
     * @return array
     */
    function sequenceKey() {
        return array(false, false, false);
    }

    function getUniqueFileNameForDuplication()
    {
        $extension = substr($this->filename, strrpos($this->filename, ".") + 1);
	    $base	   = substr($this->filename, 0, strrpos($this->filename, "."));

        if (eregi("^(.*)_([0-9]+)$", $base, $matches)) {
			$base = $matches[1];
			$i = $matches[2];
        }

        $doCheck = $this->factory($this->_tableName);
        $names = $doCheck->getUniqueValuesFromColumn('filename');
        // Get unique name
        $i = 2;
        while (in_array($base.'_'.$i . '.' .$extension, $names)) {
            $i++;
        }
        return $base . '_' . $i . '.' . $extension;
    }

    /**
     * Overrides _refreshUpdated() because the updated field is called t_stamp.
     * This method is called on insert() and update().
     *
     */
    function _refreshUpdated()
    {
        $this->t_stamp = OA::getNow();
    }

    function _auditEnabled()
    {
        return true;
    }

    function _getContextId()
    {
        return 0;
    }

    function _getContext()
    {
        return 'Image';
    }

    /**
     * A private method to return the account ID of the
     * account that should "own" audit trail entries for
     * this entity type; NOT related to the account ID
     * of the currently active account performing an
     * action.
     *
     * @return integer The account ID to insert into the
     *                 "account_id" column of the audit trail
     *                 database table.
     */
    function getOwningAccountId()
    {
        $doBanners = OA_Dal::factoryDO('banners');
        $doBanners->storagetype = 'sql';
        $doBanners->filename = $this->filename;
        $doBanners->find();

        if ($doBanners->fetch()) {
            return $doBanners->getOwningAccountId();
        }

        return OA_Dal_ApplicationVariables::get('admin_account_id');
    }


    /**
     * build an image specific audit array
     *
     * @param integer $actionid
     * @param array $aAuditFields
     */
    function _buildAuditArray($actionid, &$aAuditFields)
    {
        // Do not log binary data
        $aAuditFields['contents'] = $GLOBALS['strBinaryData'];

        $aAuditFields['key_desc']   = $this->filename;
        switch ($actionid)
        {
            case OA_AUDIT_ACTION_UPDATE:
                        $aAuditFields['bannerid']   = $this->bannerid;
                        break;
        }
    }
    
    
    function _formatValue($field, $type ='')
    {
        $fieldVal = $this->$field; 
        if ($fieldVal instanceof DB_DataObject_Cast && $fieldVal->type == 'blob') {
            return 'binary data';
        }
        else { 
            parent::_formatValue($field, $type);
        }
    }
}

?>