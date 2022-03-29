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

require_once(MAX_PATH . '/lib/OA/Upgrade/Migration.php');

/**
 * Migration class to deal with converting the encoding of data stored in the database
 * The encoding of all data within the database should now be stored in UTF-8 format.
 *
 */
class EncodingMigration extends Migration
{
    public $extension = false;

    /**
     * This maps the existing encoding
     *
     * @var array An array of language (folder) name -> encoding
     */
    public $aEncodingMap = [
        'chinese_big5' => 'big5',
        'czech' => 'iso-8859-2',
        'french' => 'iso-8859-15',
        'hebrew' => 'windows-1255',
        'hungarian' => 'iso-8859-2',
        'korean' => 'EUC-KR',
        'polish' => 'iso-8859-2',
        'portuguese' => 'iso-8859-15',
        'russian_cp1251' => 'windows-1251',
        'russian_koi8r' => 'koi8-r',
    ];

    /**
     * An array to hold the selected languages' encoding of all agencies in the system
     *
     * @var array $agencyId => $encoding
     */
    public $aEncodingByAgency = [];

    /**
     * An array to hold all the tables and fields that should be converted
     *
     * @var array of arrays(
     *  'fields' => array: field names that should be converted,
     *  'idfields' => array: fields identifying the primary (multi?) key used for the WHERE clause on update
     *  'joinon' string: Identifies which field in the table should be used to build the join up (to get the agency ID where applicable)
     */
    public $aTableFields = [
        'acls' => [
            'fields' => ['data'],
            'idfields' => ['bannerid', 'executionorder'],
            'joinon' => 'bannerid',
        ],
        'acls_channel' => [
            'fields' => ['data'],
            'idfields' => ['channelid', 'executionorder'],
            'joinon' => 'channelid',
        ],
        'affiliates' => [
            'fields' => ['name', 'mnemonic', 'comments', 'contact', 'email', 'website'],
            'idfields' => ['affiliateid'],
            'joinon' => 'affiliateid',
        ],
        'agency' => [
            'fields' => ['name', 'contact', 'email', 'username', 'logout_url'],
            'idfields' => ['agencyid'],
            'joinon' => 'agencyid',
        ],
        'application_variable' => [
            'fields' => ['name', 'value'],
            'idfields' => ['name'],
            'joinon' => 'adminid',
        ],
        'banners' => [
            'fields' => ['htmltemplate', 'htmlcache', 'target', 'url', 'alt', 'bannertext', 'description', 'append', 'comments', 'keyword', 'statustext'],
            'idfields' => ['bannerid'],
            'joinon' => 'bannerid',
        ],
        'campaigns' => [
            'fields' => ['campaignname', 'comments'],
            'idfields' => ['campaignid'],
            'joinon' => 'campaignid',
        ],
        'channel' => [
            'fields' => ['name', 'description', 'comments'],
            'idfields' => ['channelid'],
            'joinon' => 'agencyid',
        ],
        'clients' => [
            'fields' => ['clientname', 'contact', 'email', 'comments'],
            'idfields' => ['clientid'],
            'joinon' => 'clientid',
        ],
        'preference' => [
            'fields' => ['name', 'company_name', 'admin', 'admin_fullname'],
            'idfields' => ['agencyid'],
            'joinon' => 'agencyid',
        ],
        'tracker_append' => [
            'fields' => ['tagcode'],
            'idfields' => ['tracker_append_id'],
            'joinon' => 'tracker_id',
        ],
        'trackers' => [
            'fields' => ['trackername', 'description', 'appendcode'],
            'idfields' => ['trackerid'],
            'joinon' => 'clientid',
        ],
        'userlog' => [
            'fields' => ['details'],
            'idfields' => ['userlogid'],
            'joinon' => 'adminid',
        ],
        'variables' => [
            'fields' => ['name', 'description', 'variablecode'],
            'idfields' => ['variableid'],
            'joinon' => 'trackerid',
        ],
        'zones' => [
            'fields' => ['zonename', 'description', 'prepend', 'append', 'comments', 'what'],
            'idfields' => ['zoneid'],
            'joinon' => 'affiliateid',
        ],
    ];

    public function __construct()
    {
    }

    public function _getEncodingForLanguage($language)
    {
        return empty($this->aEncodingMap[$language]) ? 'UTF-8' : $this->aEncodingMap[$language];
    }

    public function _getEncodingForAgency($agencyId)
    {
        return empty($this->aEncodingByAgency[$agencyId]) ? 'UTF-8' : $this->aEncodingByAgency[$agencyId];
    }

    public function _setEncodingExtension()
    {
        $this->extension = false;

        if (class_exists('UConverter')) {
            $this->extension = 'intl';
        } elseif (function_exists('mb_convert_encoding')) {
            $this->extension = 'mbstring';
        } elseif (function_exists('iconv')) {
            $this->extension = 'iconv';
        } elseif (function_exists('utf8_encode')) {
            $this->extension = 'xml';
        }

        return $this->extension;
    }

    public function convertEncoding()
    {
        if (!$this->init(OA_DB::singleton())) {
            return false;
        }
        if (!$this->_setEncodingExtension()) {
            $this->_log("convertEncoding will be skipped because no extension was found (iconv, mbstring, xml)");
            return true;
        }
        $this->_log("Starting convertEncoding");
        $this->_log('Encoding extension set to ' . $this->extension);
        $upgradingFrom = $this->getOriginalApplicationVersion();
        if (!empty($upgradingFrom)) {
            switch ($upgradingFrom) {
                case '2.0.11-pr1':
                    $this->aEncodingMap['chinese_gb2312'] = 'gb2312';
                break;
                case 'v0.1.29-rc':
                    $this->aEncodingMap['chinese_gb2312'] = 'gb2312';
                    $this->aEncodingMap['portuguese'] = 'UTF-8';
                break;
            }
        }

        $tblBanners = $this->_getQuotedTableName('banners');
        $tblCampaigns = $this->_getQuotedTableName('campaigns');
        $tblClients = $this->_getQuotedTableName('clients');
        $tblAgency = $this->_getQuotedTableName('agency');
        $tblTrackers = $this->_getQuotedTableName('trackers');
        $tblAffiliates = $this->_getQuotedTableName('affiliates');
        $tblChannel = $this->_getQuotedTableName('channel');

        // Get admin language
        $query = "
            SELECT
                agencyid AS id,
                language AS language
            FROM
                " . $this->_getQuotedTableName('preference') . "
            WHERE
                agencyid = 0
        ";

        $adminLang = $this->oDBH->getAssoc($query);
        if (PEAR::isError($adminLang)) {
            $this->_logError("Error while retrieving admin language: " . $adminLang->getUserInfo());
            return false;
        }

        // Get agency languages
        $query = "
            SELECT
                agencyid AS id,
                language AS language
            FROM
                " . $tblAgency;
        $agencyLang = $this->oDBH->getAssoc($query);
        if (PEAR::isError($agencyLang)) {
            $this->_logError("Error while retrieving agency language: " . $agencyLang->getUserInfo());
            return false;
        }

        // Set the admin's language for id 0, then set each agencies language as specified, using admins if unset
        $this->aEncodingByAgency[0] = empty($adminLang[0]) ? 'UTF-8' : $this->_getEncodingForLanguage($adminLang[0]);

        foreach ($agencyLang as $id => $language) {
            if (!empty($language)) {
                $this->aEncodingByAgency[$id] = $this->_getEncodingForLanguage($language);
            } else {
                $this->aEncodingByAgency[$id] = $this->aEncodingByAgency[0];
            }
        }

        foreach ($this->aTableFields as $table => $aTableData) {
            $quotedTablename = $this->_getQuotedTableName($table);
            $fields = array_merge($aTableData['fields'], $aTableData['idfields']);
            foreach ($fields as $idx => $field) {
                $fields[$idx] = $quotedTablename . '.' . $field;
            }
            $where = '';

            switch ($aTableData['joinon']) {
                case 'bannerid':
                    $where .= '    LEFT JOIN ' . $tblBanners . " AS b ON b.bannerid={$quotedTablename}.bannerid\n";
                    $where .= '    LEFT JOIN ' . $tblCampaigns . " AS c ON c.campaignid=b.campaignid\n";
                    $where .= '    LEFT JOIN ' . $tblClients . " AS cl ON c.clientid=cl.clientid\n";
                    $where .= '    LEFT JOIN ' . $tblAgency . " AS ag ON ag.agencyid=cl.agencyid\n";
                break;
                case 'campaignid':
                    $where .= '    LEFT JOIN ' . $tblCampaigns . " AS c ON c.campaignid={$quotedTablename}.campaignid\n";
                    $where .= '    LEFT JOIN ' . $tblClients . " AS cl ON c.clientid=cl.clientid\n";
                    $where .= '    LEFT JOIN ' . $tblAgency . " AS ag ON ag.agencyid=cl.agencyid\n";
                break;
                case 'clientid':
                    $where .= '    LEFT JOIN ' . $tblClients . " AS cl ON cl.clientid={$quotedTablename}.clientid\n";
                    $where .= '    LEFT JOIN ' . $tblAgency . " AS ag ON ag.agencyid=cl.agencyid\n";
                break;
                case 'trackerid':
                    $where .= '    LEFT JOIN ' . $tblTrackers . " AS tr ON tr.trackerid={$quotedTablename}.trackerid\n";
                    $where .= '    LEFT JOIN ' . $tblClients . " AS cl ON tr.clientid=cl.clientid\n";
                    $where .= '    LEFT JOIN ' . $tblAgency . " AS ag ON ag.agencyid=cl.agencyid\n";
                break;
                case 'tracker_id':
                    $where .= '    LEFT JOIN ' . $tblTrackers . " AS tr ON tr.trackerid={$quotedTablename}.tracker_id\n";
                    $where .= '    LEFT JOIN ' . $tblClients . " AS cl ON tr.clientid=cl.clientid\n";
                    $where .= '    LEFT JOIN ' . $tblAgency . " AS ag ON ag.agencyid=cl.agencyid\n";
                break;
                case 'affiliateid':
                    $where .= '    LEFT JOIN ' . $tblAffiliates . " AS af ON af.affiliateid={$quotedTablename}.affiliateid\n";
                    $where .= '    LEFT JOIN ' . $tblAgency . " AS ag ON ag.agencyid=af.agencyid\n";
                break;
                case 'channelid':
                    $where .= '    LEFT JOIN ' . $tblChannel . " AS ch ON ch.channelid={$quotedTablename}.channelid\n";
                    $where .= '    LEFT JOIN ' . $tblAgency . " AS ag ON ag.agencyid=ch.agencyid\n";
                break;
            }


            $query = "SELECT\n    ";
            if ($aTableData['joinon'] != 'adminid' && $aTableData['joinon'] != 'agencyid') {
                $query .= "ag.agencyid AS agencyid,\n    ";
            }
            $query .= implode(',
    ', $fields);
            $query .= "\nFROM\n    " . $quotedTablename . "\n";
            $query .= $where;
            $rows = $this->oDBH->queryAll($query);
            if (PEAR::isError($rows)) {
                $this->_log("Error while retrieving data: " . $rows->getUserInfo());
            } else {
                foreach ($rows as $idx => $rowFields) {
                    // Set the agency id (to zero by default for admin language)
                    $agencyId = (isset($rowFields['agencyid'])) ? $rowFields['agencyid'] : 0;
                    // Look up the probable encoding for that agency
                    $fromEncoding = $this->_getEncodingForAgency($agencyId);

                    // Don't bother converting language packs which are already UTF-8
                    if ($fromEncoding == 'UTF-8') {
                        continue;
                    }
                    $updateValues = [];
                    // Convert each required field's encoding
                    foreach ($rowFields as $k => $v) {
                        if (!empty($v)) {
                            $converted = $this->_convertString($v, 'UTF-8', $fromEncoding);
                            if ($converted !== $v) {
                                $updateValues[$k] = $converted;
                            }
                        }
                    }
                    // Skip any rows where no fields have actually changed
                    if (empty($updateValues)) {
                        continue;
                    }
                    // Prepare the update query
                    $updateQuery = "UPDATE\n    " . $quotedTablename . "\nSET\n";

                    $uFields = [];
                    foreach ($updateValues as $k => $v) {
                        $uFields[] = "    {$k} = " . $this->oDBH->quote($v) . "\n";
                    }
                    $updateQuery .= implode(', ', $uFields) . " WHERE ";

                    $uFields = [];
                    foreach ($aTableData['idfields'] as $idField) {
                        $uFields[] = "    {$idField} = " . $this->oDBH->quote($rowFields[$idField]);
                    }
                    $updateQuery .= implode(' AND ', $uFields);
                    $this->_log('updating from ' . $fromEncoding . ' to UTF-8 : ' . $updateQuery);
                    $result = $this->oDBH->exec($updateQuery);
                    if (PEAR::isError($result)) {
                        $this->_log("Error while updating data: " . $rows->getUserInfo());
                    }
                }
            }
        }
        $this->_log('Completed convertEncoding');
        // Do we want fail the upgrade on encoding issues? I think not...
        return true;
    }

    /**
     * This method converts a string's encoding into UTF-8
     *
     * @todo Before merging this to trunk, this wrapper should be replaced
     *
     * @param string $string The string to be converted
     * @param string $toEncoding The destination encoding
     * @param string $fromEncoding The source encoding (if known)
     * @return string The converted string
     */
    public function _convertString($string, $toEncoding, $fromEncoding = 'UTF-8')
    {
        return MAX_commonConvertEncoding($string, $toEncoding, $fromEncoding, [$this->extension]);
    }

    public function getOriginalApplicationVersion()
    {
        $oUpgrader = new OA_Upgrade();
        $oUpgrader->oAuditor->init($this->oDBH);

        $aResult = $oUpgrader->seekRecoveryFile();
        if (is_array($aResult) && isset($aResult[0]['auditId'])) {
            $auditId = $aResult[0]['auditId'];
            $aAudit = $oUpgrader->oAuditor->queryAuditByUpgradeId($auditId);
            if (is_array($aAudit[0]) && isset($aAudit[0]['version_from'])) {
                return $aAudit[0]['version_from'];
            }
        }
        return false;
    }
}
