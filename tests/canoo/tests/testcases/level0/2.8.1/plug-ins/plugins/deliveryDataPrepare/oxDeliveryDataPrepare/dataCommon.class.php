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
 * @subpackage openxDeliveryLog
 */
class Plugins_DeliveryDataPrepare_OxDeliveryDataPrepare_DataCommon extends OX_Component
{
    function getDependencies()
    {
        return array(
            'deliveryDataPrepare:oxDeliveryDataPrepare:dataCommon' => array()
        );
    }
}

?>