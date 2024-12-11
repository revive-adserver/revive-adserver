<?php

namespace RV_Plugins\geoTargeting\rvMaxMindGeoIP2\lib;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

class MaxMindGeoLite2Downloader
{
    public const RELATIVE_PATH = 'var/plugins/rvMaxMindGeoIP2/';
    public const FULL_PATH = MAX_PATH . '/' . self::RELATIVE_PATH;

    public const GEOLITE2_DOWNLOAD_URI = 'https://download.maxmind.com/geoip/databases/%s/download';
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
        if (!$this->lock()) {
            return false;
        }

        try {
            return $this->update();
        } finally {
            $this->unlock();
        }
    }

    private function lock(): bool
    {
        $lockFileName = $this->getFullPath() . self::GEOLITE2_CITY_MMDB . '.lock';

        @mkdir($this->getFullPath());
        $this->lockFp = @fopen($lockFileName, 'w');

        return $this->lockFp && @flock($this->lockFp, LOCK_EX);
    }

    private function unlock(): void
    {
        if (!$this->lockFp) {
            return;
        }

        @flock($this->lockFp, LOCK_UN);
        @fclose($this->lockFp);

        $lockFileName = $this->getFullPath() . self::GEOLITE2_CITY_MMDB . '.lock';
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
                    'suffix' => ltrim($suffix, '.'),
                ],
                'auth' => [
                    MaxMindGeoIP2::getAccountId(),
                    MaxMindGeoIP2::getLicenseKey(),
                ],
            ],
            $options,
        );

        return $this->client->get(
            sprintf(self::GEOLITE2_DOWNLOAD_URI, self::GEOLITE2_DBNAME),
            $options,
        );
    }

    private function decompress(string $tarGzPath): void
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

        $destName = $this->getFullPath() . self::GEOLITE2_CITY_MMDB;

        $result = @stream_copy_to_stream(
            fopen($pathName, 'rb'),
            fopen($destName, 'w'),
        );

        if (false === $result) {
            throw new \RuntimeException("Could not write to: {$destName}");
        }
    }

    private function getFullPath(): string
    {
        return \MAX_PATH . '/' . self::RELATIVE_PATH;
    }

    private function update(): bool
    {
        $md5Path = $this->getFullPath() . self::GEOLITE2_DBNAME . self::GEOLITE2_SUFFIX_MD5;

        $md5 = $this->download(self::GEOLITE2_SUFFIX_MD5);

        if ($md5 === @file_get_contents($md5Path)) {
            return false;
        }

        $this->tempName = tempnam($this->getFullPath(), 'tmp');
        $tarGzPath = $this->tempName . self::GEOLITE2_SUFFIX_TAR_GZ;

        $this->downloadTo(self::GEOLITE2_SUFFIX_TAR_GZ, $tarGzPath);

        $this->decompress($tarGzPath);

        if (false === @file_put_contents($md5Path, $md5)) {
            throw new \RuntimeException("Could not write to: {$md5Path}");
        }

        return true;
    }
}
