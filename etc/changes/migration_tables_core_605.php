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

require_once(MAX_PATH.'/lib/OA/Upgrade/Migration.php');

class Migration_605 extends Migration
{

    var $adserverMap = array(
        'adtech'        => '3rdPartyServers:ox3rdPartyServers:adtech',
        'atlas'         => '3rdPartyServers:ox3rdPartyServers:atlas',
        'bluestreak'    => '3rdPartyServers:ox3rdPartyServers:bluestreak',
        'cpx'           => '3rdPartyServers:ox3rdPartyServers:cpx',
        'doubleclick'   => '3rdPartyServers:ox3rdPartyServers:doubleclick',
        'eyeblaster'    => '3rdPartyServers:ox3rdPartyServers:eyeblaster',
        'falk'          => '3rdPartyServers:ox3rdPartyServers:falk',
        'google'        => '3rdPartyServers:ox3rdPartyServers:google',
        'kontera'       => '3rdPartyServers:ox3rdPartyServers:kontera',
        'max'           => '3rdPartyServers:ox3rdPartyServers:max',
        'mediaplex'     => '3rdPartyServers:ox3rdPartyServers:mediaplex',
        'tangozebra'    => '3rdPartyServers:ox3rdPartyServers:tangozebra',
        'tradedoubler'  => '3rdPartyServers:ox3rdPartyServers:tradedoubler',
        'ypn'           => '3rdPartyServers:ox3rdPartyServers:ypn',
    );

    function Migration_605()
    {
        //$this->__construct();

		$this->aTaskList_constructive[] = 'beforeAlterField__banners__adserver';
		$this->aTaskList_constructive[] = 'afterAlterField__banners__adserver';
    }

	function beforeAlterField__banners__adserver()
	{
		return $this->beforeAlterField('banners', 'adserver');
	}

	/**
	 * Remap any old-style "adserver" (3rdPartyServers) plugin names to PCI's
	 *
	 * @return boolean
	 */
	function afterAlterField__banners__adserver()
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

?>