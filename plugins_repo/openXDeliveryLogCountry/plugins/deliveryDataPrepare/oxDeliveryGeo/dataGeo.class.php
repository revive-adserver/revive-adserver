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

require_once LIB_PATH . '/Plugin/Component.php';

/**
 * @package    Plugin
 * @subpackage openxDeliveryLogCountry
 */
class Plugins_DeliveryDataPrepare_OxDeliveryGeo_DataGeo extends OX_Component
{
    public function getDependencies()
    {
        return [
            'deliveryDataPrepare:oxDeliveryGeo:dataGeo' => [
                'deliveryDataPrepare:oxDeliveryDataPrepare:dataCommon'
            ]
        ];
    }
}
