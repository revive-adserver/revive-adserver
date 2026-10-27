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

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use RV\Sync;

require_once MAX_PATH . '/lib/OA/Dal/ApplicationVariables.php';

class Test_RV_Sync_Json extends UnitTestCase
{
    private array $history = [];

    public function setUp()
    {
        OA_Dal_ApplicationVariables::cleanCache();
        OA_Dal_ApplicationVariables::set('oa_version', '6.0.8');
        OA_Dal_ApplicationVariables::set('platform_hash', 'existing-installation');
        OA_Dal_ApplicationVariables::set('sync_registered_email', 'admin@example.test');
    }

    public function tearDown()
    {
        foreach (array_keys(OA_Dal_ApplicationVariables::getAll()) as $name) {
            OA_Dal_ApplicationVariables::delete($name);
        }
    }

    private function sync(array $responses, bool $shareStack = false, bool $enabled = true, string $endpoint = 'https://sync.example.test/v1/sync'): Sync
    {
        $this->history = [];
        $handler = HandlerStack::create(new MockHandler($responses));
        $handler->push(Middleware::history($this->history));
        $conf = $GLOBALS['_MAX']['CONF'];
        $conf['sync'] = ['checkForUpdates' => $enabled, 'shareStack' => $shareStack];
        $conf['oacSync'] = ['path' => '/xmlrpc.php'];
        $conf['rvSync'] = ['endpoint' => $endpoint];
        return new Sync($conf, null, new Client(['handler' => $handler]));
    }

    private function release(string $version = '6100.400', string $readable = '6.1.0'): array
    {
        return [
            'product_name' => 'Revive Adserver',
            'config_version' => $version,
            'config_readable' => $readable,
            'security_fix' => 1,
            'description' => 'Security & maintenance',
            'url_zip' => 'https://example.test/revive-' . $readable . '.zip',
            'url_tgz' => 'https://example.test/revive-' . $readable . '.tar.gz',
        ];
    }

    public function testSuggestedReleasesAndRequest()
    {
        foreach ([[$this->release()], [$this->release(), $this->release('6009.400', '6.0.9')]] as $updates) {
            $sync = $this->sync([new Response(200, [], json_encode(['updates' => $updates]))]);
            $this->assertEqual($sync->checkForUpdates(), [0, $updates]);
            $this->assertEqual(unserialize(OA_Dal_ApplicationVariables::get('sync_cache')), $updates);
            $this->assertTrue(OA_Dal_ApplicationVariables::get('sync_timestamp') > 0);
            $this->assertTrue((bool) OA_Dal_ApplicationVariables::get('sync_last_run'));
            $request = $this->history[0]['request'];
            $this->assertEqual($request->getMethod(), 'POST');
            $this->assertEqual((string) $request->getUri(), 'https://sync.example.test/v1/sync');
            $this->assertEqual($request->getHeaderLine('Content-Type'), 'application/json');
            $payload = json_decode((string) $request->getBody());
            $this->assertIdentical($payload->version, '6008.4');
            $this->assertEqual($payload->product, PRODUCT_NAME);
            $this->assertEqual($payload->platform_hash, 'existing-installation');
            $this->assertEqual($payload->email, 'admin@example.test');
            $this->assertEqual($payload->software, new stdClass());
            $this->assertIdentical($this->history[0]['options']['verify'], true);
            $this->assertIdentical($this->history[0]['options']['allow_redirects'], false);
            $this->assertEqual($this->history[0]['options']['timeout'], 10);
        }
    }

    public function testStackOptInAndPlatformHashGeneration()
    {
        OA_Dal_ApplicationVariables::delete('platform_hash');
        $sync = $this->sync([new Response(200, [], '{"updates":[]}')], true);
        $this->assertEqual($sync->checkForUpdates()[0], 800);
        $payload = json_decode((string) $this->history[0]['request']->getBody(), true);
        $this->assertEqual(strlen($payload['platform_hash']), 40);
        $this->assertEqual($payload['platform_hash'], OA_Dal_ApplicationVariables::get('platform_hash'));
        $this->assertEqual($payload['software']['php_version'], PHP_VERSION);
        $this->assertEqual($payload['software']['php_extensions'], get_loaded_extensions());
        $this->assertIdentical($payload['software']['php_safe_mode'], false);
        $this->assertTrue(is_string($payload['software']['db_version']));
    }

    public function testNullableDownloadUrlsAndConfiguredEndpoint()
    {
        $release = $this->release();
        $release['url_zip'] = null;
        $release['url_tgz'] = null;
        $sync = $this->sync([new Response(200, [], json_encode(['updates' => [$release]]))], endpoint: 'http://localhost:8080/v1/sync');
        $release['url_zip'] = '';
        $release['url_tgz'] = '';
        $this->assertEqual($sync->checkForUpdates(), [0, [$release]]);
        $this->assertEqual((string) $this->history[0]['request']->getUri(), 'http://localhost:8080/v1/sync');
    }

    public function testNoUpdatesClearsCache()
    {
        OA_Dal_ApplicationVariables::set('sync_cache', serialize([$this->release()]));
        $sync = $this->sync([new Response(200, [], '{"updates":[]}')]);
        $this->assertEqual($sync->checkForUpdates()[0], 800);
        $this->assertEqual(unserialize(OA_Dal_ApplicationVariables::get('sync_cache')), []);
        $this->assertTrue(OA_Dal_ApplicationVariables::get('sync_timestamp') > 0);
    }

    public function testFailuresPreserveCacheAndTimestamps()
    {
        $responses = [
            new Response(500, [], '{"error":{"code":899,"message":"Failure"}}'),
            new Response(302, ['Location' => 'http://sync.example.test/v1/sync']),
            new Response(200, [], '<html>Proxy error</html>'),
            new Response(200, [], '{}'),
            new Response(200, [], '{"updates":null}'),
            new Response(200, [], '{"updates":{}}'),
            new Response(200, [], '{"updates":{"wrong":[]}}'),
            new Response(200, [], '{"updates":[{}]}'),
            new ConnectException('Connection failed', new Request('POST', 'https://sync.example.test')),
        ];
        foreach ($responses as $response) {
            OA_Dal_ApplicationVariables::set('sync_cache', 'old-cache');
            OA_Dal_ApplicationVariables::set('sync_timestamp', '123');
            OA_Dal_ApplicationVariables::set('sync_last_run', 'previous-run');
            $sync = $this->sync([$response]);
            $this->assertEqual($sync->checkForUpdates()[0], -1);
            $this->assertEqual(OA_Dal_ApplicationVariables::get('sync_cache'), 'old-cache');
            $this->assertEqual(OA_Dal_ApplicationVariables::get('sync_timestamp'), '123');
            $this->assertEqual(OA_Dal_ApplicationVariables::get('sync_last_run'), 'previous-run');
        }
    }

    public function testContainerProvidesSyncService()
    {
        $savedConf = $GLOBALS['_MAX']['CONF'];
        $GLOBALS['_MAX']['CONF']['rvSync'] = ['endpoint' => 'http://localhost:8080/v1/sync'];
        try {
            $sync = RV_getContainer()->get(Sync::class);
            $this->assertIsA($sync, Sync::class);
            $this->assertIdentical($sync, RV_getContainer()->get(Sync::class));
            $this->assertEqual($sync->_conf['endpoint'], 'http://localhost:8080/v1/sync');
        } finally {
            $GLOBALS['_MAX']['CONF'] = $savedConf;
        }
    }

    public function testDisabledDoesNotContactServer()
    {
        $sync = $this->sync([], false, false);
        $this->assertEqual($sync->checkForUpdates()[0], -2);
        $this->assertEqual($this->history, []);
        $this->assertNull(OA_Dal_ApplicationVariables::get('sync_timestamp'));
    }
}
