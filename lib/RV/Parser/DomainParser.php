<?php

namespace RV\Parser;

use GuzzleHttp;
use GuzzleHttp\Psr7\Request;
use Pdp\Domain;
use Pdp\ResourceUri;
use Pdp\Storage\PsrStorageFactory;
use Pdp\Storage\PublicSuffixListStorage;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;
use Psr\SimpleCache\CacheInterface;

class DomainParser
{
    private const PREFIX = 'pdp_';
    private const TTL = 86400;

    private readonly PublicSuffixListStorage $pslStorage;

    public function __construct(CacheInterface $cache)
    {
        $this->pslStorage = self::getFactory($cache)->createPublicSuffixListStorage(self::PREFIX, self::TTL);
    }

    public function getHostname(string $url): ?string
    {
        return $this->parseUrlOrHostname($url);
    }

    public function getRegistrableDomain(string $url): ?string
    {
        return $this->parseUrlOrHostname($url, true);
    }

    private function parseUrlOrHostname(string $url, bool $registrableDomain = false): ?string
    {
        if (!preg_match('#^https?://#', $url)) {
            $url = 'http://' . $url;
        }

        try {
            $hostname = @parse_url($url, PHP_URL_HOST) ?: throw new \RuntimeException();
            $domain = Domain::fromIDNA2008($hostname);
        } catch (\Throwable) {
            return null;
        }

        $publicSuffixList = $this->pslStorage->get(ResourceUri::PUBLIC_SUFFIX_LIST_URI);

        $resolvedDomain = $publicSuffixList->resolve($domain);

        if (!$resolvedDomain->suffix()->isICANN()) {
            return null;
        }

        if ($registrableDomain) {
            return $resolvedDomain->registrableDomain()->value();
        }

        return $hostname;
    }

    private static function getFactory(CacheInterface $cache): PsrStorageFactory
    {
        return new PsrStorageFactory(
            $cache,
            new GuzzleHttp\Client(),
            new class implements RequestFactoryInterface {
                public function createRequest(string $method, $uri): RequestInterface
                {
                    return new Request($method, $uri);
                }
            },
        );
    }
}
