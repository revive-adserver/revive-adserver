<?php

namespace RV_Plugins\geoTargeting\rvMaxMindGeoIP2\lib;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

class MaxMindGeoLite2Downloader
{
    public const RELATIVE_PATH = 'var/plugins/rvMaxMindGeoIP2/';
    public const FULL_PATH = MAX_PATH . '/' . self::RELATIVE_PATH;

    public const GEOLITE2_DOWNLOAD_URI = 'https://download.maxmind.com/app/geoip_download';
    public const GEOLITE2_SUFFIX_TAR_GZ = '.tar.gz';
    public const GEOLITE2_SUFFIX_MD5 = self::GEOLITE2_SUFFIX_TAR_GZ . '.md5';
    public const GEOLITE2_DBNAME = 'GeoLite2-City';
    public const GEOLITE2_CITY_TAR_GZ = self::GEOLITE2_DBNAME . '.tar.gz';
    public const GEOLITE2_CITY_MMDB = self::GEOLITE2_DBNAME . '.mmdb';

    /** @var Client  */
    private $client;

    /** @var resource */
    private $lockFp;

    /** @var string */
    private $tempName;

    public function __construct()
    {
        $this->client = new Client();
    }

    public function __destruct()
    {
        if (null === $this->tempName) {
            return;
        }

        @unlink($this->tempName . self::GEOLITE2_SUFFIX_TAR_GZ);
        @unlink($this->tempName);
    }

    public function updateGeoLiteDatabase(): bool
    {
        $md5Path = self::FULL_PATH . self::GEOLITE2_DBNAME . self::GEOLITE2_SUFFIX_MD5;

        if (!$this->lock()) {
            return false;
        }

        $md5 = $this->download(self::GEOLITE2_SUFFIX_MD5);

        if ($md5 === @file_get_contents($md5Path)) {
            $this->unlock();

            return false;
        }

        $this->tempName = tempnam(self::FULL_PATH, 'tmp');
        $tarGzPath = $this->tempName . self::GEOLITE2_SUFFIX_TAR_GZ;

        $this->downloadTo(self::GEOLITE2_SUFFIX_TAR_GZ, $tarGzPath);

        $this->decompress($tarGzPath);

        file_put_contents($md5Path, $md5);

        $this->unlock();

        return true;
    }

    private function lock(): bool
    {
        $lockFileName = self::FULL_PATH . self::GEOLITE2_CITY_MMDB . '.lock';

        @mkdir(self::FULL_PATH);
        $this->lockFp = @fopen($lockFileName, 'w');

        return $this->lockFp && @flock($this->lockFp, LOCK_EX);
    }

    private function unlock()
    {
        if (!$this->lockFp) {
            return;
        }

        @flock($this->lockFp, LOCK_UN);
        @fclose($this->lockFp);

        $lockFileName = self::FULL_PATH . self::GEOLITE2_CITY_MMDB . '.lock';
        @unlink($lockFileName);
    }

    private function download(string $suffix): string
    {
        return (string) $this->clientGet($suffix)->getBody();
    }

    private function downloadTo(string $suffix, string $destFile): bool
    {
        $response = $this->clientGet($suffix, [
            'sink' => $destFile,
        ]);

        return 200 === $response->getStatusCode();
    }

    private function clientGet(string $suffix, $options = []): ResponseInterface
    {
        $options = array_merge(
            [
                'query' => [
                    'edition_id' => self::GEOLITE2_DBNAME,
                    'suffix' => ltrim($suffix, '.'),
                    'license_key' => MaxMindGeoIP2::getLicenseKey(),
                ],
            ],
            $options
        );

        return $this->client->get(self::GEOLITE2_DOWNLOAD_URI, $options);
    }

    private function decompress(string $tarGzPath): bool
    {
        $pharData = new \PharData($tarGzPath);

        $pathName = null;

        /** @var \PharFileInfo $file */
        foreach ($pharData->getChildren() as $file) {
            if (self::GEOLITE2_CITY_MMDB === $file->getFileName()) {
                $pathName = $file->getPathName();
                break;
            }
        }

        if (null === $pathName) {
            throw new \InvalidArgumentException("Unknown file format");
        }

        stream_copy_to_stream(
            fopen($pathName, 'rb'),
            fopen(self::FULL_PATH . self::GEOLITE2_CITY_MMDB, 'w')
        );

        return true;
    }
}
