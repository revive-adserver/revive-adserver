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

$className = 'OA_UpgradePostscript_2_5_68';

require_once MAX_PATH . '/lib/OA/DB/Table.php';

class OA_UpgradePostscript_2_5_68
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

    function OA_UpgradePostscript_2_5_68()
    {

    }

    function execute($aParams)
    {
        $this->oUpgrade = & $aParams[0];
        return $this->removeMaxSection();
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