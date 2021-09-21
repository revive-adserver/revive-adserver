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

class Migration_605 extends Migration
{
    public $adserverMap = [
        'adtech' => '3rdPartyServers:ox3rdPartyServers:adtech',
        'atlas' => '3rdPartyServers:ox3rdPartyServers:atlas',
        'bluestreak' => '3rdPartyServers:ox3rdPartyServers:bluestreak',
        'cpx' => '3rdPartyServers:ox3rdPartyServers:cpx',
        'doubleclick' => '3rdPartyServers:ox3rdPartyServers:doubleclick',
        'eyeblaster' => '3rdPartyServers:ox3rdPartyServers:eyeblaster',
        'falk' => '3rdPartyServers:ox3rdPartyServers:falk',
        'google' => '3rdPartyServers:ox3rdPartyServers:google',
        'kontera' => '3rdPartyServers:ox3rdPartyServers:kontera',
        'max' => '3rdPartyServers:ox3rdPartyServers:max',
        'mediaplex' => '3rdPartyServers:ox3rdPartyServers:mediaplex',
        'tangozebra' => '3rdPartyServers:ox3rdPartyServers:tangozebra',
        'tradedoubler' => '3rdPartyServers:ox3rdPartyServers:tradedoubler',
        'ypn' => '3rdPartyServers:ox3rdPartyServers:ypn',
    ];

    public function __construct()
    {
        //$this->__construct();

        $this->aTaskList_constructive[] = 'beforeAlterField__banners__adserver';
        $this->aTaskList_constructive[] = 'afterAlterField__banners__adserver';
    }

    public function beforeAlterField__banners__adserver()
    {
        return $this->beforeAlterField('banners', 'adserver');
    }

    /**
     * Remap any old-style "adserver" (3rdPartyServers) plugin names to PCI's
     *
     * @return boolean
     */
    public function afterAlterField__banners__adserver()
    {
        $prefix = $this->getPrefix();
        $table = $this->oDBH->quoteIdentifier($prefix . 'banners', true);

        foreach ($this->adserverMap as $name => $pci) {
            $query = "UPDATE {$table} SET adserver = '" . $pci . "' WHERE adserver = '" . $name . "'";
            $result = $this->oDBH->exec($query);
            if (PEAR::isError($result)) {
                $this->_log("Migration of adserver->PCI query failed: " . $query);
            }
        }
        return $this->afterAlterField('banners', 'adserver');
    }
}
