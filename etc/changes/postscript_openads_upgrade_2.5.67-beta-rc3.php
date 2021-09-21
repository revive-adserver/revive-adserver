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

$className = 'OA_UpgradePostscript_2_5_67';

require_once MAX_PATH . '/lib/OA/DB/Table.php';

class OA_UpgradePostscript_2_5_67
{
    public $oUpgrade;

    public $languageMap = [
        'chinese_big5' => 'zh_CN',
        'chinese_gb2312' => 'zh_CN',
        'czech' => 'cs',
        'dutch' => 'nl',
        'english' => 'en',
        'english_affiliates' => 'en',
        'english_us' => 'en',
        'french' => 'fr',
        'german' => 'de',
        'hebrew' => 'he',
        'hungarian' => 'hu',
        'indonesian' => 'id',
        'italian' => 'it',
        'korean' => 'ko',
        'polish' => 'pl',
        'portuguese' => 'pt_BR',
        'brazilian_portuguese' => 'pt_BR',
        'russian_cp1251' => 'ru',
        'russian_koi8r' => 'ru',
        'spanish' => 'es',
        'turkish' => 'tr'
    ];

    public $aContexts = [
                            'Account Preference Association' => 'account_preference_assoc',
                            'Account User Association' => 'account_user_assoc',
                            'Account User Permission Association' => 'account_user_permission_assoc',
                            'Account' => 'accounts',
                            'Delivery Limitation' => 'acls',
                            'Ad Zone Association' => 'ad_zone_assoc',
                            'Affiliate' => 'affiliates',
                            'Affiliate Extra' => 'affiliates_extra',
                            'Agency' => 'agency',
                            'Banner' => 'banners',
                            'Campaign' => 'campaigns',
                            'Campaign Tracker' => 'campaigns_trackers',
                            'Category' => 'category',
                            'Channel' => 'channel',
                            'Client' => 'clients',
                            'Image' => 'images',
                            'Campaign Zone Association' => 'placement_zone_assoc',
                            'Preference' => 'preferences',
                            'Tracker' => 'trackers',
                            'User' => 'users',
                            'Variable' => 'variables',
                            'Zone' => 'zones',
                            ];

    public function __construct()
    {
    }

    public function execute($aParams)
    {
        $this->oUpgrade = &$aParams[0];
        return $this->updateAuditContext() && $this->removeMaxSection();
    }

    public function logOnly($msg)
    {
        $this->oUpgrade->oLogger->logOnly($msg);
    }

    public function logError($msg)
    {
        $this->oUpgrade->oLogger->logError($msg);
    }

    /**
     * Replaces the existing "context" column in "audit" table with apropriate table names
     *
     * @return boolean
     */
    public function updateAuditContext()
    {
        $tblAudit = $this->oUpgrade->oDbh->quoteIdentifier(OA_Dal::getTablePrefix() . 'audit', true);
        foreach ($this->aContexts as $contextOld => $contextNew) {
            $query = 'UPDATE ' . $tblAudit
                    . ' SET context = ' . $this->oUpgrade->oDbh->quote($contextNew)
                    . ' WHERE context = ' . $this->oUpgrade->oDbh->quote($contextOld);

            $result = $this->oUpgrade->oDbh->exec($query);

            if (PEAR::isError($result) || $result === false) {
                $this->logError('Error while updating audit context: ' . $result->getUserInfo());
                return false;
            }
        }
        $this->logOnly('audit context values updated');
        return true;
    }

    public function removeMaxSection()
    {
        unset($this->oUpgrade->oConfiguration->aConfig['max']['installed']);
        unset($this->oUpgrade->oConfiguration->aConfig['max']['uiEnabled']);

        $lang = 'en';
        if (!empty($this->oUpgrade->oConfiguration->aConfig['max']['language']) && isset($this->languageMap[$this->oUpgrade->oConfiguration->aConfig['max']['language']])) {
            $lang = $this->languageMap[$this->oUpgrade->oConfiguration->aConfig['max']['language']];
        }
        $this->oUpgrade->oConfiguration->aConfig['openads']['language'] = $lang;

        unset($this->oUpgrade->oConfiguration->aConfig['max']['language']);
        if (empty($this->oUpgrade->oConfiguration->aConfig['max'])) {
            unset($this->oUpgrade->oConfiguration->aConfig['max']);
            $this->oUpgrade->oLogger->log('Removed max section');
        }
        $this->oUpgrade->oConfiguration->writeConfig();
        return true;
    }
}
