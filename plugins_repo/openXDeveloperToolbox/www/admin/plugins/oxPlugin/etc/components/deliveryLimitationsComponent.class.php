<?php

require_once LIB_PATH . '/Extension/deliveryLimitations/DeliveryLimitations.php';
require_once MAX_PATH . '/lib/max/Plugin/Translation.php';
require_once MAX_PATH . '/lib/max/Delivery/limitations.delivery.php';

class Plugins_DeliveryLimitations_{GROUP}_{GROUP}Component extends Plugins_DeliveryLimitations
{
    function Plugins_DeliveryLimitations_DemoDeliveryLimitation_DemoLimitation()
    {
        $this->aOperations = array(
            '==' => $GLOBALS['strEqualTo'],
            '!=' => $GLOBALS['strDifferentFrom']);
    }

    /**
     * Return name of plugin
     *
     * @return string
     */
    function getName()
    {
        return $this->translate('Demo');
    }
}