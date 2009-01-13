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
$Id$
*/

$className = 'OA_UpgradePostscript_2_5_67';

require_once MAX_PATH . '/lib/OA/DB/Table.php';

class OA_UpgradePostscript_2_5_67
{
    var $oUpgrade;

    var $languageMap = array(
        'chinese_big5'          => 'zh_CN',
        'chinese_gb2312'        => 'zh_CN',
        'czech'                 => 'cs',
        'dutch'                 => 'nl',
        'english'               => 'en',
        'english_affiliates'    => 'en',
        'english_us'            => 'en',
        'french'                => 'fr',
        'german'                => 'de',
        'hebrew'                => 'he',
        'hungarian'             => 'hu',
        'indonesian'            => 'id',
        'italian'               => 'it',
        'korean'                => 'ko',
        'polish'                => 'pl',
        'portuguese'            => 'pt_BR',
        'brazilian_portuguese'  => 'pt_BR',
        'russian_cp1251'        => 'ru',
        'russian_koi8r'         => 'ru',
        'spanish'               => 'es',
        'turkish'               => 'tr'
    );

    var $aContexts = array(
                            'Account Preference Association'=>'account_preference_assoc',
                            'Account User Association'=>'account_user_assoc',
                            'Account User Permission Association'=>'account_user_permission_assoc',
                            'Account'=>'accounts',
                            'Delivery Limitation'=>'acls',
                            'Ad Zone Association'=>'ad_zone_assoc',
                            'Affiliate'=>'affiliates',
                            'Affiliate Extra'=>'affiliates_extra',
                            'Agency'=>'agency',
                            'Banner'=>'banners',
                            'Campaign'=>'campaigns',
                            'Campaign Tracker'=>'campaigns_trackers',
                            'Category'=>'category',
                            'Channel'=>'channel',
                            'Client'=>'clients',
                            'Image'=>'images',
                            'Campaign Zone Association'=>'placement_zone_assoc',
                            'Preference'=>'preferences',
                            'Tracker'=>'trackers',
                            'User'=>'users',
                            'Variable'=>'variables',
                            'Zone'=>'zones',
                            );

    function OA_UpgradePostscript_2_5_67()
    {

    }

    function execute($aParams)
    {
        $this->oUpgrade = & $aParams[0];
        return $this->updateAuditContext() && $this->removeMaxSection();
    }

    function logOnly($msg)
    {
        $this->oUpgrade->oLogger->logOnly($msg);
    }

    function logError($msg)
    {
        $this->oUpgrade->oLogger->logError($msg);
    }

    /**
     * Replaces the existing "context" column in "audit" table with apropriate table names
     *
     * @return boolean
     */
    function updateAuditContext()
    {
        $tblAudit = $this->oUpgrade->oDbh->quoteIdentifier(OA_Dal::getTablePrefix().'audit',true);
        foreach ($this->aContexts as $contextOld => $contextNew)
        {
            $query = 'UPDATE '.$tblAudit
                    .' SET context = '. $this->oUpgrade->oDbh->quote($contextNew)
                    .' WHERE context = '. $this->oUpgrade->oDbh->quote($contextOld);

            $result = $this->oUpgrade->oDbh->exec($query);

            if (PEAR::isError($result) || $result === false)
            {
                $this->logError('Error while updating audit context: '.$result->getUserInfo());
                return false;
            }
        }
        $this->logOnly('audit context values updated');
        return true;
    }

    function removeMaxSection()
    {
        unset($this->oUpgrade->oConfiguration->aConfig['max']['installed']);
        unset($this->oUpgrade->oConfiguration->aConfig['max']['uiEnabled']);

        $lang = 'en';
        if (!empty($this->oUpgrade->oConfiguration->aConfig['max']['language'])) {
			if (isset($this->languageMap[$this->oUpgrade->oConfiguration->aConfig['max']['language']])) {
				$lang = $this->languageMap[$this->oUpgrade->oConfiguration->aConfig['max']['language']];
			}
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
