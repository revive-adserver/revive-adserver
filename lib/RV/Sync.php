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

namespace RV;

use GuzzleHttp;
use OA;
use OA_DB;
use OA_Dal_ApplicationVariables;
use PEAR;
use RV as Revive;
use RV\Sync\Dto\SerializerFactory;
use RV\Sync\Dto\Software;
use RV\Sync\Dto\SyncRequest;
use RV\Sync\Dto\SyncResponse;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

use const PEAR_LOG_ERR;
use const PEAR_LOG_INFO;

require_once RV_PATH . '/lib/RV.php';

require_once MAX_PATH . '/lib/OA.php';
require_once MAX_PATH . '/lib/OA/DB.php';
require_once MAX_PATH . '/lib/OA/Dal/ApplicationVariables.php';

/**
 * A class to deal with the services provided by Revive Adserver Sync
 *
 * @package    Revive Adserver
 */
class Sync
{
    public $aConf;
    public $aPref;
    public $_conf;

    /**
     * @var \MDB2_Driver_Common
     */
    public $oDbh;

    private readonly GuzzleHttp\ClientInterface $client;

    private readonly SerializerInterface $serializer;

    /**
     * Constructor
     *
     * @param array $conf array, if null reads the global variable
     * @param array $pref array, if null reads the global variable
     */
    public function __construct($conf = null, $pref = null, ?GuzzleHttp\ClientInterface $client = null, ?SerializerInterface $serializer = null)
    {
        $this->aConf = $conf ?? $GLOBALS['_MAX']['CONF'] ?? null;
        $this->aPref = $pref ?? $GLOBALS['_MAX']['PREF'] ?? null;

        $this->_conf = $this->aConf['rvSync'];
        $this->client = $client ?? new GuzzleHttp\Client();
        $this->serializer = $serializer ?? SerializerFactory::create();

        $this->oDbh = OA_DB::singleton();
    }


    /**
     * Returns phpAdsNew style config version.
     *
     * The OpenX version "number" is converted to an int using the following table:
     *
     * 'beta-rc' => 0.1
     * 'beta'    => 0.2
     * 'rc'      => 0.3
     * ''        => 0.4
     *
     * i.e.
     * v0.3.29-beta-rc10 becomes:
     *  0   *   1000 +
     *  3   *    100 +
     * 29   *      1 +    // Cannot exceed 100 patch releases!
     *  0.1          +
     * 10   /   1000 =
     * -------------
     *        3293.1
     */
    public static function getConfigVersion($version)
    {
        $a = [
            'dev' => -0.001,
            'beta-rc' => 0.1,
            'beta' => 0.2,
            'rc' => 0.3,
            'stable' => 0.4,
        ];

        $version = Revive::stripVersion(strtolower($version), ['dev', 'stable']);

        if (preg_match('/^v/', $version)) {
            $v = preg_split('/[.-]/', substr($version, 1));
        } else {
            $v = preg_split('/[.-]/', $version);
        }

        if (count($v) < 3) {
            return false;
        }

        // Prepare value from the first 3 items
        $returnValue = $v[0] * 1000 + $v[1] * 100 + $v[2];
        // How many items were there?
        if (count($v) == 5) {
            // Check that it is a beta-rc release
            if ((!$v[3] == 'beta') || (!preg_match('/^rc(\d+)/', $v[4], $aMatches))) {
                return false;
            }
            // Add the beta-rc
            $returnValue += $a['beta-rc'] + $aMatches[1] / 1000;
            return $returnValue;
        }

        if (count($v) == 4) {
            // Check that it is a tag or rc numer
            if (isset($a[$v[3]])) {
                // Add the beta
                $returnValue += $a[$v[3]];
                return $returnValue;
            }
            if (preg_match('/^rc(\d+)/', $v[3], $aMatches)) {
                // Add the rc
                $returnValue += $a['rc'] + $aMatches[1] / 1000;
                return $returnValue;
            }
            return false;
        }
        // Stable release
        $returnValue += $a['stable'];
        return $returnValue;
    }

    /**
     * Check for updates using the JSON endpoint.
     *
     * @return array Error code and message, or 0 and a list of suggested releases.
     *               -2: disabled; -1: communication/response error; 800: no updates.
     */
    public function checkForUpdates()
    {
        if (!$this->aConf['sync']['checkForUpdates']) {
            return [-2, 'Check for updates has been disabled by the administrator.'];
        }

        // Prepare the installation's platform hash
        $platform_hash = OA_Dal_ApplicationVariables::get('platform_hash');
        if (!$platform_hash) {
            // The installation does not have a platform hash; generate one,
            // and save it to the database for later use
            OA::debug("Generating a new platform_hash for the installation", PEAR_LOG_INFO);
            $platform_hash = OA_Dal_ApplicationVariables::generatePlatformHash();
            if (!OA_Dal_ApplicationVariables::set('platform_hash', $platform_hash)) {
                OA::debug("Could not save the new platform_hash to the database", PEAR_LOG_ERR);
                $platform_hash = '';
                OA::debug("Sync process proceeding without a platform_hash", PEAR_LOG_INFO);
            }
        }


        $software = new Software();

        // Only send technology stack data when the administrator has opted in.
        if ($this->aConf['sync']['shareStack']) {
            // Thanks, admin user! You're a star! Prepare the technology stack
            // data and add it to the JSON request
            if ($this->oDbh->dbsyntax == 'mysql' || $this->oDbh->dbsyntax == 'mysqli') {
                $dbms = 'MySQL';
            } elseif ($this->oDbh->dbsyntax == 'pgsql') {
                $dbms = 'PostgreSQL';
            } else {
                $dbms = 'UnknownSQL';
            }

            $dbVersion = $this->oDbh->queryOne("SELECT VERSION()");
            if (PEAR::isError($dbVersion)) {
                $dbVersion = '';
            }

            $software = new Software();
            $software->osType = php_uname('s');
            $software->osVersion = php_uname('r');
            $software->webserverType = isset($_SERVER['SERVER_SOFTWARE']) ? preg_replace('#^(.*?)/.*$#', '$1', $_SERVER['SERVER_SOFTWARE']) : '';
            $software->webserverVersion = isset($_SERVER['SERVER_SOFTWARE']) ? preg_replace('#^.*?/(.*?)(?: .*)?$#', '$1', $_SERVER['SERVER_SOFTWARE']) : '';
            $software->dbType = $dbms;
            $software->dbVersion = (string) $dbVersion;
            $software->phpVersion = phpversion();
            $software->phpSapi = ucfirst(php_sapi_name());
            $software->phpExtensions = get_loaded_extensions();
            $software->phpRegisterGlobals = false;
            $software->phpMagicQuotesGpc = false;
            $software->phpSafeMode = false;
            $software->phpOpenBasedir = (bool) strlen(ini_get('open_basedir'));
            $software->phpUploadTmpReadable = (bool) is_readable(ini_get('upload_tmp_dir') . DIRECTORY_SEPARATOR);
        }
        $request = new SyncRequest(
            PRODUCT_NAME,
            (string) self::getConfigVersion(OA_Dal_ApplicationVariables::get('oa_version')),
            (string) $platform_hash,
            (string) OA_Dal_ApplicationVariables::get('sync_registered_email'),
            $software,
        );

        try {
            $response = $this->client->request('POST', $this->_conf['endpoint'], [
                'body' => $this->serializer->serialize($request, 'json', [
                    AbstractObjectNormalizer::SKIP_NULL_VALUES => true,
                    AbstractObjectNormalizer::PRESERVE_EMPTY_OBJECTS => true,
                ]),
                'headers' => ['Accept' => 'application/json', 'Content-Type' => 'application/json'],
                'timeout' => 10,
                'connect_timeout' => 10,
                'allow_redirects' => false,
                'http_errors' => false,
                'verify' => true,
            ]);
            if ($response->getStatusCode() !== 200) {
                throw new \RuntimeException('Sync server returned HTTP ' . $response->getStatusCode() . '.');
            }

            $syncResponse = SyncResponse::fromJson((string) $response->getBody(), $this->serializer);
            $updates = $syncResponse->toLegacyUpdates($this->serializer);
        } catch (GuzzleHttp\Exception\GuzzleException | \JsonException | \RuntimeException | \InvalidArgumentException $e) {
            OA::debug('Sync: ' . $e->getMessage(), PEAR_LOG_ERR);
            return [-1, $e->getMessage()];
        }

        OA_Dal_ApplicationVariables::set('sync_last_run', date('Y-m-d H:i:s'));
        OA_Dal_ApplicationVariables::set('sync_cache', serialize($updates));
        OA_Dal_ApplicationVariables::set('sync_timestamp', time());
        OA::debug($updates !== [] ? 'Sync: updates found!' : 'Sync: no updates available.', PEAR_LOG_INFO);

        return $updates !== [] ? [0, $updates] : [800, 'No updates available.'];
    }

    /**
     * Read both the legacy single-release cache and the new release list.
     */
    public static function normalizeUpdates($updates): array
    {
        if (!is_array($updates)) {
            return [];
        }
        return isset($updates['config_version']) ? [$updates] : $updates;
    }
}
