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

namespace RV\Extension\DeliveryLimitations\ClientDataWrapper;

use RV\Extension\DeliveryLimitations\ClientDataWrapperInterface;
use Sinergi\BrowserDetector\Browser;
use Sinergi\BrowserDetector\Os;

class SinergiWrapper implements ClientDataWrapperInterface
{
    /**
     * A map from Sinergi to the legacy browser IDs.
     *
     * @var array
     */
    private static $aBrowserMap = [
        Browser::EDGE => 'ED',
        Browser::IE => 'IE',
        Browser::CHROME => 'GC',
        Browser::FIREFOX => 'FX',
        Browser::OPERA => 'OP',
        Browser::OPERA_MINI => 'OP',
        Browser::BLACKBERRY => 'BL',
        Browser::NAVIGATOR => 'NS',
        Browser::GALEON => 'GA',
        Browser::PHOENIX => 'PX',
        Browser::FIREBIRD => 'FB',
        Browser::SAFARI => 'SF',
        Browser::MOZILLA => 'MZ',
        Browser::KONQUEROR => 'KQ',
        Browser::ICAB => 'IC',
        Browser::LYNX => 'LX',
        Browser::AMAYA => 'AM',
        Browser::OMNIWEB => 'OW',
    ];

    /**
     * A map from Sinergi to the legacy OS IDs.
     *
     * @var array
     */
    private static $aOsMap = [
      Os::WINDOWS => [
          '95' => '95',
          '98' => '98',
          '2000' => '2k',
          'XP' => 'xp',
          '7' => 'w7',
        ],
        Os::OSX => 'osx',
        Os::LINUX => 'linux',
        Os::FREEBSD => 'freebsd',
        Os::SUNOS => 'sun',
    ];

    /** @var string */
    private $userAgent;

    /** @var \Sinergi\BrowserDetector\Browser */
    private $oBrowser;

    /** @var \Sinergi\BrowserDetector\Os */
    private $oOs;

    /**
     * {@inheritdoc}
     */
    public function __construct($userAgent)
    {
        $this->userAgent = $userAgent;
    }

    /**
     * @return \Sinergi\BrowserDetector\Browser
     */
    private function getSinergiBrowser()
    {
        if (null === $this->oBrowser) {
            $this->oBrowser = new Browser($this->userAgent);
        }

        return $this->oBrowser;
    }

    /**
     * @return \Sinergi\BrowserDetector\Os
     */
    private function getSinergiOs()
    {
        if (null === $this->oOs) {
            $this->oOs = new Os($this->userAgent);
        }

        return $this->oOs;
    }

    /**
     * {@inheritdoc}
     */
    public function getBrowserName()
    {
        return $this->getSinergiBrowser()->getName();
    }

    /**
     * {@inheritdoc}
     */
    public function getBrowserVersion()
    {
        return $this->getSinergiBrowser()->getVersion();
    }

    /**
     * {@inheritdoc}
     */
    public function getOsName()
    {
        return $this->getSinergiOs()->getName();
    }

    /**
     * {@inheritdoc}
     */
    public function getOsVersion()
    {
        return $this->getSinergiOs()->getVersion();
    }

    /**
     * {@inheritdoc}
     */
    public function isMobile()
    {
        return $this->getSinergiOs()->isMobile();
    }

    /**
     * {@inheritdoc}
     */
    public function getLegacyBrowser()
    {
        $browser = $this->getSinergiBrowser()->getName();

        if (isset(self::$aBrowserMap[$browser])) {
            return self::$aBrowserMap[$browser];
        }

        return 'Unknown';
    }

    /**
     * {@inheritdoc}
     */
    public function getLegacyOs()
    {
        $os = $this->getSinergiOs()->getName();

        if (isset(self::$aOsMap[$os])) {
            if (is_array(self::$aOsMap[$os])) {
                $version = $this->getSinergiOs()->getVersion();
                if (isset(self::$aOsMap[$os][$version])) {
                    return self::$aOsMap[$os][$version];
                }
            } else {
                return self::$aOsMap[$os];
            }
        }

        return 'Unknown';
    }
}
