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

require_once(MAX_PATH.'/lib/OA/Upgrade/Migration.php');

/**
 * Migration class to deal with converting the encoding of data stored in the database
 * The encoding of all data within the database should now be stored in UTF-8 format.
 *
 */
class EncodingMigration extends Migration
{

    /**
     * This maps the existing encoding
     *
     * @var array An array of language (folder) name -> encoding
     */
    var $aEncodingMap = array(
        'chinese_big5'      => 'big5',
        'czech'             => 'iso-8859-2',
        'french'            => 'iso-8859-15',
        'hebrew'            => 'windows-1255',
        'hungarian'         => 'iso-8859-2',
        'korean'            => 'EUC-KR',
        'polish'            => 'iso-8859-2',
        'portuguese'        => 'iso-8859-15',
        'russian_cp1251'    => 'windows-1251',
        'russian_koi8r'     => 'koi8-r',
    );

    /**
     * An array to hold the selected languages' encoding of all agencies in the system
     *
     * @var array $agencyId => $encoding
     */
    var $aEncodingByAgency = array();

    /**
     * An array to hold all the tables and fields that should be converted
     *
     * @var array of arrays(
     *  'fields' => array: field names that should be converted,
     *  'idfields' => array: fields identifying the primary (multi?) key used for the WHERE clause on update
     *  'joinon' string: Identifies which field in the table should be used to build the join up (to get the agency ID where applicable)
     */
    var $aTableFields = array(
        'acls' => array(
            'fields' => array('data'),
            'idfields' => array('bannerid', 'executionorder'),
            'joinon' => 'bannerid',
        ),
        'acls_channel' => array(
            'fields'    => array('data'),
            'idfields'  => array('channelid', 'executionorder'),
            'joinon'    => 'channelid',
        ),
        'affiliates' =>  array(
            'fields' =>  array('name', 'mnemonic', 'comments', 'contact', 'email', 'website'),
            'idfields'  => array('affiliateid'),
            'joinon' => 'affiliateid',
        ),
        'agency' => array(
            'fields' => array('name', 'contact', 'email', 'username', 'logout_url'),
            'idfields'  => array('agencyid'),
            'joinon' => 'agencyid',
        ),
        'application_variable' => array(
            'fields' => array('name', 'value'),
            'idfields'  => array('name'),
            'joinon' => 'adminid',
        ),
        'banners' => array(
            'fields' => array('htmltemplate','htmlcache','target','url','alt','bannertext','description','append','comments','keyword','statustext'),
            'idfields'  => array('bannerid'),
            'joinon' => 'bannerid',
        ),
        'campaigns' => array(
            'fields' => array('campaignname','comments'),
            'idfields'  => array('campaignid'),
            'joinon' => 'campaignid',
        ),
        'channel' => array(
            'fields' => array('name','description','comments'),
            'idfields'  => array('channelid'),
            'joinon' => 'agencyid',
        ),
        'clients' => array(
            'fields' => array('clientname','contact','email','comments'),
            'idfields'  => array('clientid'),
            'joinon' => 'clientid',
        ),
        'preference' => array(
            'fields' => array('name', 'company_name', 'admin', 'admin_fullname'),
            'idfields'  => array('agencyid'),
            'joinon'    => 'agencyid',
        ),
        'tracker_append' => array(
            'fields' => array('tagcode'),
            'idfields'  => array('tracker_append_id'),
            'joinon' => 'tracker_id',
        ),
        'trackers' => array(
            'fields' => array('trackername','description','appendcode'),
            'idfields'  => array('trackerid'),
            'joinon' => 'clientid',
        ),
        'userlog' => array(
            'fields' => array('details'),
            'idfields'  => array('userlogid'),
            'joinon' => 'adminid',
        ),
        'variables' => array(
            'fields' => array('name','description','variablecode'),
            'idfields'  => array('variableid'),
            'joinon' => 'trackerid',
        ),
        'zones' => array(
            'fields' => array('zonename','description','prepend','append','comments','what'),
            'idfields'  => array('zoneid'),
            'joinon' => 'affiliateid',
        ),
    );

    function EncodingMigration()
    {

    }

    function _getEncodingForLanguage($language)
    {
        return !empty($this->aEncodingMap[$language]) ? $this->aEncodingMap[$language] : 'UTF-8';
    }

    function _getEncodingForAgency($agencyId)
    {
        return !empty($this->aEncodingByAgency[$agencyId]) ? $this->aEncodingByAgency[$agencyId] : 'UTF-8';
    }

    function convertEncoding()
    {
        $this->oDBH = OA_DB::singleton();

        $upgradingFrom = $this->getOriginalApplicationVersion();
        if (!empty($upgradingFrom)) {
            switch ($upgradingFrom) {
                case '2.0.11-pr1':
                    $this->aEncodingMap['chinese_gb2312'] = 'gb2312';
                break;
                case 'v0.1.29-rc':
                    $this->aEncodingMap['chinese_gb2312'] = 'gb2312';
                    $this->aEncodingMap['portuguese']     = 'UTF-8';
                break;
            }
        }

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

        // Get agency languages
        $query = "
            SELECT
                agencyid AS id,
                language AS language
            FROM
                " . $this->_getQuotedTableName('agency');
        $agencyLang = $this->oDBH->getAssoc($query);

        // Set the admin's language for id 0, then set each agencies language as specified, using admins if unset
        $this->aEncodingByAgency[0] = !empty($adminLang[0]) ? $this->_getEncodingForLanguage($adminLang[0]) : 'UTF-8';

        foreach ($agencyLang as $id => $language) {
            if (!empty($language)) {
                $this->aEncodingByAgency[$id] = $this->_getEncodingForLanguage($language);
            } else {
                $this->aEncodingByAgency[$id] = $this->aEncodingByAgency[0];
            }
        }

        foreach ($this->aTableFields as $table => $aTableData) {

            $fields = array_merge($aTableData['fields'], $aTableData['idfields']);
            foreach ($fields as $idx => $field) { $fields[$idx] = $this->_getQuotedTableName($table) . '.' . $field; }

            $where = '';
            $quotedTablename = $this->_getQuotedTableName($table);
            switch ($aTableData['joinon']) {
                case 'bannerid':
                    $where .= '    LEFT JOIN ' . $this->_getQuotedTableName('banners') . " AS b ON b.bannerid={$quotedTablename}.bannerid\n";
                    $where .= '    LEFT JOIN ' . $this->_getQuotedTableName('campaigns') . " AS c ON c.campaignid=b.campaignid\n";
                    $where .= '    LEFT JOIN ' . $this->_getQuotedTableName('clients') . " AS cl ON c.clientid=cl.clientid\n";
                    $where .= '    LEFT JOIN ' . $this->_getQuotedTableName('agency') . " AS ag ON ag.agencyid=cl.agencyid\n";
                break;
                case 'campaignid':
                    $where .= '    LEFT JOIN ' . $this->_getQuotedTableName('campaigns') . " AS c ON c.campaignid={$quotedTablename}.campaignid\n";
                    $where .= '    LEFT JOIN ' . $this->_getQuotedTableName('clients') . " AS cl ON c.clientid=cl.clientid\n";
                    $where .= '    LEFT JOIN ' . $this->_getQuotedTableName('agency') . " AS ag ON ag.agencyid=cl.agencyid\n";
                break;
                case 'clientid':
                    $where .= '    LEFT JOIN ' . $this->_getQuotedTableName('clients') . " AS cl ON cl.clientid={$quotedTablename}.clientid\n";
                    $where .= '    LEFT JOIN ' . $this->_getQuotedTableName('agency') . " AS ag ON ag.agencyid=cl.agencyid\n";
                break;
                case 'trackerid':
                    $where .= '    LEFT JOIN ' . $this->_getQuotedTableName('trackers') . " AS tr ON tr.trackerid={$quotedTablename}.trackerid\n";
                    $where .= '    LEFT JOIN ' . $this->_getQuotedTableName('clients') . " AS cl ON tr.clientid=cl.clientid\n";
                    $where .= '    LEFT JOIN ' . $this->_getQuotedTableName('agency') . " AS ag ON ag.agencyid=cl.agencyid\n";
                break;
                case 'tracker_id':
                    $where .= '    LEFT JOIN ' . $this->_getQuotedTableName('trackers') . " AS tr ON tr.trackerid={$quotedTablename}.tracker_id\n";
                    $where .= '    LEFT JOIN ' . $this->_getQuotedTableName('clients') . " AS cl ON tr.clientid=cl.clientid\n";
                    $where .= '    LEFT JOIN ' . $this->_getQuotedTableName('agency') . " AS ag ON ag.agencyid=cl.agencyid\n";
                break;
                case 'affiliateid':
                    $where .= '    LEFT JOIN ' . $this->_getQuotedTableName('affiliates') . " AS af ON af.affiliateid={$quotedTablename}.affiliateid\n";
                    $where .= '    LEFT JOIN ' . $this->_getQuotedTableName('agency') . " AS ag ON ag.agencyid=af.agencyid\n";
                break;
                case 'channelid':
                    $where .= '    LEFT JOIN ' . $this->_getQuotedTableName('channel') . " AS ch ON ch.channelid={$quotedTablename}.channelid\n";
                    $where .= '    LEFT JOIN ' . $this->_getQuotedTableName('agency') . " AS ag ON ag.agencyid=ch.agencyid\n";
                break;
            }


            $query = "SELECT\n    ";
            if ($aTableData['joinon'] != 'adminid' && $aTableData['joinon'] != 'agencyid') { $query .= "ag.agencyid AS agencyid,\n    "; }
            $query .= implode(',' . "\n    ", $fields);
            $query .= "\nFROM\n    " . $this->_getQuotedTableName($table) . "\n";
            $query .= $where;

            $rows = $this->oDBH->queryAll($query);

            if (!PEAR::isError($rows)) {
                // For each row
                foreach ($rows as $idx => $rowFields) {
                    // Set the agency id (to zero by default for admin language)
                    $agencyId = (isset($rowFields['agencyid'])) ? $rowFields['agencyid'] : 0;
                    // Look up the probable encoding for that agency
                    $fromEncoding = $this->_getEncodingForAgency($agencyId);

                    // Don't bother converting language packs which are already UTF-8
                    if ($fromEncoding == 'UTF-8') { continue; }

                    $updateValues = array();
                    // Convert each required field's encoding
                    foreach ($rowFields as $k => $v) {
                        $converted = $this->_convertString($v, 'UTF-8', $fromEncoding);
                        if ($converted !== $v) {
                            $updateValues[$k] = $converted;
                        }
                    }
                    // Skip any rows where no fields have actually changed
                    if (empty($updateValues)) { continue; }

                    // Prepare the update query
                    $updateQuery = "UPDATE\n    " . $this->_getQuotedTableName($table) . "\nSET\n";

                    $uFields = array();
                    foreach ($updateValues as $k => $v) {
                        $uFields[] = "    {$k} = " . $this->oDBH->quote($v) . "\n";
                    }

                    $updateQuery .= implode(', ', $uFields) . " WHERE ";

                    $uFields = array();
                    foreach ($aTableData['idfields'] as $idField) {
                        $uFields[] = "    {$idField} = " . $this->oDBH->quote($rowFields[$idField]);
                    }
                    $updateQuery .= implode(' AND ', $uFields);
                    $this->oDBH->exec($updateQuery);
                }
            }
        }
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
	function _convertString($string, $toEncoding, $fromEncoding = 'UTF-8', $extension = '')
	{
	    $aExtensions = !empty($extension) ? array($extension) : null;
	    return MAX_commonConvertEncoding($string, $toEncoding, $fromEncoding, $aExtensions);
	}

	function getOriginalApplicationVersion()
	{
	    $oUpgrader = new OA_Upgrade();
	    $oUpgrader->oAuditor->init($this->oDBH);

        $aResult = $oUpgrader->seekRecoveryFile();
        if (is_array($aResult) && isset($aResult[0]['auditId']))
        {
            $auditId = $aResult[0]['auditId'];
            $aAudit = $oUpgrader->oAuditor->queryAuditByUpgradeId($auditId);
            if (is_array($aAudit[0]) && isset($aAudit[0]['version_from']))
            {
                return $aAudit[0]['version_from'];
            }
        }
        return false;
	}
}

?>
