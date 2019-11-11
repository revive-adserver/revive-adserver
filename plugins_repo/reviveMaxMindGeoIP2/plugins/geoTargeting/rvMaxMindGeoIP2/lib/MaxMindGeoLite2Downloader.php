<?php

namespace RV_Plugins\geoTargeting\rvMaxMindGeoIP2\lib;

use GuzzleHttp\Client;

class MaxMindGeoLite2Downloader
{
    const RELATIVE_PATH = 'var/plugins/rvMaxMindGeoIP2/';
    const FULL_PATH = MAX_PATH.'/'.self::RELATIVE_PATH;

    const GEOLITE2_BASE_URI = 'https://geolite.maxmind.com/download/geoip/database/';
    const GEOLITE2_CITY_TAR_GZ = 'GeoLite2-City.tar.gz';
    const GEOLITE2_CITY_MMDB = 'GeoLite2-City.mmdb';

    /** @var Client  */
    private $client;

    /** @var resource */
    private $lockFp;

    /** @var string */
    private $tempName;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => self::GEOLITE2_BASE_URI,
        ]);
    }

    public function __destruct()
    {
        if (null === $this->tempName) {
            return;
        }

        @unlink($this->tempName.'.tgz');
        @unlink($this->tempName);
    }

    public function updateGeoLiteDatabase(): bool
    {
        $md5Path = self::FULL_PATH.self::GEOLITE2_CITY_TAR_GZ.'.md5';

        if (!$this->lock()) {
            return false;
        }

        $md5 = $this->download(basename($md5Path));

        if ($md5 === @file_get_contents($md5Path)) {
            $this->unlock();

            return false;
        }

        $this->tempName = tempnam(self::FULL_PATH, 'tmp');
        $tarGzPath = $this->tempName.'.tgz';

        $this->downloadTo(self::GEOLITE2_CITY_TAR_GZ, $tarGzPath);

        $this->decompress($tarGzPath);

        file_put_contents($md5Path, $md5);

        $this->unlock();

        return true;
    }

    private function lock(): bool
    {
        $lockFileName = self::FULL_PATH.self::GEOLITE2_CITY_MMDB.'.lock';

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

        $lockFileName = self::FULL_PATH.self::GEOLITE2_CITY_MMDB.'.lock';
        @unlink($lockFileName);
    }

    private function download(string $url): string
    {
        $response = $this->client->get($url);

        return (string) $response->getBody();
    }

    private function downloadTo(string $url, string $destFile): bool
    {
        $response = $this->client->get($url, [
            'sink' => $destFile,
        ]);

        return 200 === $response->getStatusCode();
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
            fopen(self::FULL_PATH.self::GEOLITE2_CITY_MMDB, 'w')
        );

        return true;
    }
}