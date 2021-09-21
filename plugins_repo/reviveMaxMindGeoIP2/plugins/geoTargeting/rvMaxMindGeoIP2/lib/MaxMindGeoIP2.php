<?php

namespace RV_Plugins\geoTargeting\rvMaxMindGeoIP2\lib;

use MaxMind\Db\Reader;

class MaxMindGeoIP2
{
    public const DEFAULT_MMDB = MAX_PATH . '/var/plugins/rvMaxMindGeoIP2/GeoLite2-City.mmdb';

    public const GEO = [
        'version' => '2',
        'country' => '',
        'continent' => '',
        'is_in_eu' => '',
        'city' => '',
        'postal_code' => '',
        'latitude' => '',
        'longitude' => '',
        'accuracy_radius' => '',
        'time_zone' => '',
        'metro_code' => '',
        'subdivision_1' => '',
        'subdivision_2' => '',
    ];

    public const TRAITS = [
        'is_anonymous' => '',
        'is_anonymous_vpn' => '',
        'is_hosting_provider' => '',
        'is_public_proxy' => '',
        'is_tor_exit_node' => '',
        'connection_type' => '',
        'average_income' => '',
        'population_density' => '',
        'domain' => '',
        'isp' => '',
        'organization' => '',
        'user_type' => '',
        'autonomous_system_number' => '',
        'autonomous_system_organization' => '',
    ];

    public const CAPABILITIES = [
        'Anonymous-IP' => [
            'is_anonymous' => true,
            'is_anonymous_vpn' => true,
            'is_hosting_provider' => true,
            'is_public_proxy' => true,
            'is_tor_exit_node' => true,
        ],
        'City' => [
            'postal_code' => true,
            'latitude' => true,
            'longitude' => true,
            'accuracy_radius' => true,
            'continent' => true,
            'country' => true,
            'subdivision_1' => true,
            'subdivision_2' => true,
            'city' => true,
            'metro_code' => true,
            'time_zone' => true,
            'is_in_eu' => true,
        ],
        'Connection-Type' => [
            'connection_type' => true,
        ],
        'Country' => [
            'continent' => true,
            'country' => true,
            'is_in_eu' => true,
        ],
        'DensityIncome' => [
            'average_income' => true,
            'population_density' => true,
        ],
        'Domain' => [
            'domain' => true,
        ],
        'ISP' => [
            'isp' => true,
            'organization' => true,
            'autonomous_system_number' => true,
            'autonomous_system_organization' => true,
        ],
        'ASN' => [
            'autonomous_system_number' => true,
            'autonomous_system_organization' => true,
        ],
    ];

    /**
     * Get the available capabilities of all the configured databases as array keys
     */
    public static function getCapabilities()
    {
        $capabilities = [];

        foreach (self::getReaders() as $reader) {
            $type = preg_replace('#^Geo(?:IP|Lite)2-#', '', $reader->metadata()->databaseType);

            if ('Enterprise' === $type) {
                $capabilities += self::CAPABILITIES['City'] +
                    self::CAPABILITIES['Connection-Type'] +
                    self::CAPABILITIES['ISP'];
            } elseif (isset(self::CAPABILITIES[$type])) {
                $capabilities += self::CAPABILITIES[$type];
            }
        }

        return $capabilities;
    }

    public static function getGeoInfo($useCookie)
    {
        $aConf = $GLOBALS['_MAX']['CONF'];

        // Try and read the data from the geo cookie...
        if ($useCookie && isset($_COOKIE[$aConf['var']['viewerGeo']])) {
            $ret = self::unpackCookie($_COOKIE[$aConf['var']['viewerGeo']]);
            if (false !== $ret) {
                return $ret;
            }
        }

        $ip = $GLOBALS['_MAX']['GEO_IP'] ?? $_SERVER['REMOTE_ADDR'] ?? '24.24.24.24';

        $ret = [];
        foreach (self::getReaders() as $reader) {
            $res = $reader->get($ip);

            if (isset($res['continent']['code'])) {
                $ret['continent'] = $res['continent']['code'];
            }

            if (isset($res['country']['iso_code'])) {
                $ret['country'] = $res['country']['iso_code'];
            }

            if (isset($res['country']['is_in_european_union'])) {
                $ret['is_in_eu'] = $res['country']['is_in_european_union'];
            }

            if (isset($res['city']['names']['en'])) {
                $ret['city'] = $res['city']['names']['en'];
            }

            if (isset($res['postal']['code'])) {
                $ret['postal_code'] = $res['postal']['code'];
            }

            if (isset($res['location'])) {
                $ret['latitude'] = $res['location']['latitude'];
                $ret['longitude'] = $res['location']['longitude'];
                $ret['accuracy_radius'] = $res['location']['accuracy_radius'] ?? 1;
            }

            if (isset($res['location']['time_zone'])) {
                $ret['time_zone'] = $res['location']['time_zone'];
            }

            if (isset($res['location']['metro_code'])) {
                $ret['metro_code'] = $res['location']['metro_code'];
            }

            if (isset($res['subdivisions'][0]['iso_code'])) {
                $ret['subdivision_1'] = $res['subdivisions'][0]['iso_code'];
            }

            if (isset($res['subdivisions'][1]['iso_code'])) {
                $ret['subdivision_2'] = $res['subdivisions'][1]['iso_code'];
            }

            foreach (self::TRAITS as $trait => $dummy) {
                if (isset($res[$trait])) {
                    $ret[$trait] = $res[$trait];
                } elseif (isset($res['traits'][$trait])) {
                    $ret[$trait] = $res['traits'][$trait];
                }
            }
        }

        // Store this information in the cookie for later use
        if ($useCookie && (!empty($ret))) {
            MAX_cookieAdd($aConf['var']['viewerGeo'], self::packCookie($ret));
        }

        return $ret;
    }

    private static function getCookieArray()
    {
        return self::GEO + self::TRAITS;
    }

    public static function packCookie($data = [])
    {
        $aGeoInfo = self::getCookieArray();

        return join('|', array_merge($aGeoInfo, $data));
    }

    public static function unpackCookie($string = '')
    {
        try {
            $aGeoInfo = @array_combine(
                array_keys(self::getCookieArray()),
                explode('|', $string)
            );
        } catch (\ValueError $e) {
            return false;
        }

        if (false === $aGeoInfo) {
            return false;
        }

        if ('2' !== $aGeoInfo['version']) {
            return false;
        }

        return $aGeoInfo;
    }

    public static function getMmdbPaths(): string
    {
        return trim($GLOBALS['_MAX']['CONF']['rvMaxMindGeoIP2']['mmdb_paths'] ?? '') ?: self::DEFAULT_MMDB;
    }

    public static function hasCustomConfig(): string
    {
        return self::DEFAULT_MMDB !== self::getMmdbPaths();
    }

    public static function getLicenseKey(): string
    {
        return $GLOBALS['_MAX']['CONF']['rvMaxMindGeoIP2']['license_key'] ?? '';
    }

    /**
     * @return \Generator|Reader[]
     */
    private static function getReaders(): \Generator
    {
        foreach (preg_split('/\s+/', self::getMmdbPaths(), -1, PREG_SPLIT_NO_EMPTY) as $mmdb) {
            try {
                yield new Reader($mmdb);
            } catch (\Throwable $e) {
                // Do nothing!
            }
        }
    }
}
