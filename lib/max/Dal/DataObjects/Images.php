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
 * Table Definition for images
 */
require_once 'DB_DataObjectCommon.php';

class DataObjects_Images extends DB_DataObjectCommon
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'images';                          // table name
    public $filename;                        // VARCHAR(128) => openads_varchar => 130
    public $contents;                        // blob() => blob => 194
    public $t_stamp;                         // DATETIME() => openads_datetime => 14

    /* Static get */
    public static function staticGet($k, $v = null)
    {
        return DB_DataObject::staticGetFromClassName('DataObjects_Images', $k, $v);
    }

    public $defaultValues = [
        'filename' => '',
        'contents' => '',
    ];

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
    public function fetch()
    {
        $oDbh = &$this->getDatabaseConnection();
        if (empty($oDbh)) {
            return false;
        }
        // When using PgSQL we need to disable MDB2_PORTABILITY_RTRIM portability option
        if ($pgsql = $oDbh->dbsyntax == 'pgsql') {
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
     * Overwrite DB_DataObjectCommon::delete() method
     *
     * @param boolean $useWhere
     * @param boolean $cascadeDelete  If true it deletes also referenced tables
     *                                if this behavior is set in DataObject.
     *                                With this parameter it's possible to turn off default behavior
     *                                @see DB_DataObjectCommon:onDeleteCascade
     * @param boolean $parentid The audit ID of the parent object causing the cascade.
     * @return int|false
     * @access protected
     */
    public function delete($useWhere = false, $cascadeDelete = true, $parentid = null)
    {
        // Contents cause problems in pgsql when retrieving current values for auditing
        $this->contents = null;
        return parent::delete($useWhere, $cascadeDelete, $parentid);
    }

    /**
     * Table has no autoincrement/sequence so we override sequenceKey().
     *
     * @return array
     */
    public function sequenceKey()
    {
        return [false, false, false];
    }

    public function getUniqueFileNameForDuplication()
    {
        $extension = substr($this->filename, strrpos($this->filename, ".") + 1);
        $base = substr($this->filename, 0, strrpos($this->filename, "."));

        if (preg_match("/^(.*)_([0-9]+)$/Di", $base, $matches)) {
            $base = $matches[1];
            $i = $matches[2];
        }

        $doCheck = $this->factory($this->_tableName);
        $names = $doCheck->getUniqueValuesFromColumn('filename');
        // Get unique name
        $i = 2;
        while (in_array($base . '_' . $i . '.' . $extension, $names)) {
            $i++;
        }
        return $base . '_' . $i . '.' . $extension;
    }

    /**
     * Overrides _refreshUpdated() because the updated field is called t_stamp.
     * This method is called on insert() and update().
     *
     */
    public function _refreshUpdated()
    {
        $this->t_stamp = OA::getNowUTC();
    }

    public function _auditEnabled()
    {
        return true;
    }

    public function _getContextId()
    {
        return 0;
    }

    public function _getContext()
    {
        return 'Image';
    }

    /**
     * A method to return an array of account IDs of the account(s) that
     * should "own" any audit trail entries for this entity type; these
     * are NOT related to the account ID of the currently active account
     * (which is performing some kind of action on the entity), but is
     * instead related to the type of entity, and where in the account
     * heirrachy the entity is located.
     *
     * @return array An array containing up to three indexes:
     *                  - "OA_ACCOUNT_ADMIN" or "OA_ACCOUNT_MANAGER":
     *                      Contains the account ID of the manager account
     *                      that needs to be able to see the audit trail
     *                      entry, or, the admin account, if the entity
     *                      is a special case where only the admin account
     *                      should see the entry.
     *                  - "OA_ACCOUNT_ADVERTISER":
     *                      Contains the account ID of the advertiser account
     *                      that needs to be able to see the audit trail
     *                      entry, if such an account exists.
     *                  - "OA_ACCOUNT_TRAFFICKER":
     *                      Contains the account ID of the trafficker account
     *                      that needs to be able to see the audit trail
     *                      entry, if such an account exists.
     */
    public function getOwningAccountIds($resetCache = false)
    {
        // Find the banner that contains this image, if possible
        $doBanners = $this->getBanner();

        if ($doBanners instanceof \DataObjects_Banners) {
            // Return the owning account IDs of the image's owning banner
            return $doBanners->getOwningAccountIds();
        }

        // Alas, the image doesn't have an owning banner yet,
        // so return the special case of
        $aAccountIds = [
            OA_ACCOUNT_ADMIN => OA_Dal_ApplicationVariables::get('admin_account_id'),
        ];
        return $aAccountIds;
    }

    /**
     * build an image specific audit array
     *
     * @param integer $actionid
     * @param array $aAuditFields
     */
    public function _buildAuditArray($actionid, &$aAuditFields)
    {
        // Do not log binary data
        $aAuditFields['contents'] = $GLOBALS['strBinaryData'];

        $aAuditFields['key_desc'] = $this->filename;
        if ($actionid === OA_AUDIT_ACTION_UPDATE) {
            if ($doBanner = $this->getBanner()) {
                $aAuditFields['bannerid'] = $doBanner->bannerid;
            }
        }
    }


    public function _formatValue($field, $type = 0)
    {
        $fieldVal = $this->$field;
        if (is_a($fieldVal, 'DB_DataObject_Cast') && $fieldVal->type == 'blob') {
            return 'binary data';
        } else {
            parent::_formatValue($field, $type);
        }
    }

    private function getBanner(): ?DataObjects_Banners
    {
        /** @var DataObjects_Banners $doBanners */
        $doBanners = OA_Dal::factoryDO('banners');
        $doBanners->storagetype = 'sql';
        $doBanners->filename = $this->filename;

        if (!$doBanners->find()) {
            return null;
        }

        $doBanners->fetch();

        return $doBanners;
    }
}
