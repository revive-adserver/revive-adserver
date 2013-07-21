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

/**
 * @package    OpenXPlugin
 * @subpackage DeliveryLimitations
 * @author     Chris Nutting <chris@m3.net>
 */

$res = array(
    'unknown'   => MAX_Plugin_Translation::translate('Unknown', $this->extension, $this->group),
    'dialup'    => MAX_Plugin_Translation::translate('Dial-up', $this->extension, $this->group),
    'cabledsl'  => MAX_Plugin_Translation::translate('Broadband', $this->extension, $this->group),
    'corporate' => MAX_Plugin_Translation::translate('Corporate', $this->extension, $this->group),
);

?>
