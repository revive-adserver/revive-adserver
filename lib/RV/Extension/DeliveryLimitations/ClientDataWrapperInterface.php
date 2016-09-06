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

namespace RV\Extension\DeliveryLimitations;

interface ClientDataWrapperInterface
{
    /**
     * Class constructor.
     *
     * @param string $userAgent
     */
    public function __construct($userAgent);

    /**
     * Get the browser name.
     *
     * @return string
     */
    public function getBrowserName();

    /**
     * Get the browser version.
     *
     * @return string
     */
    public function getBrowserVersion();

    /**
     * Get the OS name.
     *
     * @return string
     */
    public function getOsName();

    /**
     * Get the OS version.
     *
     * @return string
     */
    public function getOsVersion();

    /**
     * Get the legacy browser "ID".
     *
     * @return string
     */
    public function getLegacyBrowser();

    /**
     * Get the legacy OS "ID".
     *
     * @return string
     */
    public function getLegacyOs();
}
