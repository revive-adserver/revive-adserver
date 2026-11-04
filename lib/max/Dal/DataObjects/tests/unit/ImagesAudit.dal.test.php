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

require_once MAX_PATH . '/lib/max/Dal/tests/util/DalUnitTestCase.php';
require_once MAX_PATH . '/www/admin/lib-storage.inc.php';

Language_Loader::load();

class DataObjects_ImagesAuditTest extends DalUnitTestCase
{
    private $originalAudit;
    private $originalAdmin;
    private $originalOptimize;

    public function setUp()
    {
        $this->originalAudit = $GLOBALS['_MAX']['CONF']['audit']['enabled'];
        $this->originalOptimize = $GLOBALS['dataGeneratorDontOptimize'] ?? null;
        $GLOBALS['_MAX']['CONF']['audit']['enabled'] = false;
        $GLOBALS['dataGeneratorDontOptimize'] = true;
        $this->originalAdmin = OA_Dal_ApplicationVariables::get('admin_account_id');
        $admin = OA_Dal::factoryDO('accounts');
        $admin->account_type = 'ADMIN';
        OA_Dal_ApplicationVariables::set('admin_account_id', DataGenerator::generateOne($admin));
    }

    public function tearDown()
    {
        $GLOBALS['_MAX']['CONF']['audit']['enabled'] = false;
        if ($this->originalAdmin === null) {
            OA_Dal_ApplicationVariables::delete('admin_account_id');
        } else {
            OA_Dal_ApplicationVariables::set('admin_account_id', $this->originalAdmin);
        }
        DataGenerator::cleanUp(['images', 'audit', 'ad_zone_assoc', 'acls']);
        $GLOBALS['_MAX']['CONF']['audit']['enabled'] = $this->originalAudit;
        if ($this->originalOptimize === null) {
            unset($GLOBALS['dataGeneratorDontOptimize']);
        } else {
            $GLOBALS['dataGeneratorDontOptimize'] = $this->originalOptimize;
        }
    }

    private function createBanner(string $filename, ?int $campaignId = null): DataObjects_Banners
    {
        $this->assertEqual(phpAds_ImageStore('sql', $filename, 'image contents'), $filename);
        $banner = OA_Dal::factoryDO('banners');
        $banner->storagetype = 'sql';
        $banner->filename = $filename;
        if ($campaignId !== null) {
            $banner->campaignid = $campaignId;
        }
        $id = DataGenerator::generateOne($banner, true);
        return OA_Dal::staticGetDO('banners', $id);
    }

    private function captureLookups(callable $operation): array
    {
        $db = OA_DB::singleton();
        $debug = $db->getOption('debug');
        $handler = $db->getOption('debug_handler');
        $expanded = $db->getOption('debug_expanded_output');
        $queries = [];
        $db->setOption('debug', 1);
        $db->setOption('debug_expanded_output', false);
        $db->setOption('debug_handler', static function (&$db, $scope, $query, $context) use (&$queries) {
            if ($scope === 'query' && stripos($query, 'SELECT') !== false && stripos($query, 'banners') !== false && stripos($query, 'storagetype') !== false && stripos($query, 'filename') !== false) {
                $queries[] = $query;
            }
        });
        try {
            $operation();
        } finally {
            $db->setOption('debug', $debug);
            $db->setOption('debug_handler', $handler);
            $db->setOption('debug_expanded_output', $expanded);
        }
        return $queries;
    }

    private function latestImageAudit(int $action)
    {
        $audit = OA_Dal::factoryDO('audit');
        $audit->context = 'images';
        $audit->actionid = $action;
        $audit->orderBy('auditid DESC');
        $this->assertTrue($audit->find(true) > 0);
        return $audit;
    }

    public function testBannerDuplicationAvoidsLookup()
    {
        $banner = $this->createBanner('audit-source.png');
        $this->assertDuplicate($banner, $banner->campaignid, false);
    }

    public function testDuplicationUsesDestinationCampaign()
    {
        $banner = $this->createBanner('audit-source.png');
        $campaignId = DataGenerator::generateOne('campaigns', true);
        $this->assertDuplicate($banner, $campaignId, true);
    }

    public function testCampaignDuplicationAvoidsBannerLookups()
    {
        $source = $this->createBanner('audit-source.png');
        $this->createBanner('audit-second.png', $source->campaignid);
        $campaign = OA_Dal::staticGetDO('campaigns', $source->campaignid);
        $GLOBALS['_MAX']['CONF']['audit']['enabled'] = true;
        $newCampaignId = null;
        $queries = $this->captureLookups(function () use ($campaign, &$newCampaignId) {
            $newCampaignId = $campaign->duplicate();
        });
        $this->assertTrue($newCampaignId > 0);
        $this->assertEqual(count($queries), 0);
        $banners = OA_Dal::factoryDO('banners');
        $banners->campaignid = $newCampaignId;
        $this->assertEqual($banners->find(), 2);
        while ($banners->fetch()) {
            $this->assertEqual(phpAds_ImageRetrieve('sql', $banners->filename), 'image contents');
        }
    }

    private function assertDuplicate(DataObjects_Banners $banner, int $campaignId, bool $changeCampaign)
    {
        $campaign = OA_Dal::staticGetDO('campaigns', $campaignId);
        $owners = $campaign->getOwningAccountIds();
        $GLOBALS['_MAX']['CONF']['audit']['enabled'] = true;
        $queries = $this->captureLookups(function () use ($banner, $campaignId, $changeCampaign) {
            $id = $banner->duplicate($changeCampaign ? $campaignId : null);
            $this->assertTrue($id > 0);
        });
        $this->assertEqual(count($queries), 0);
        $this->assertEqual(phpAds_ImageRetrieve('sql', $banner->filename), 'image contents');
        $audit = $this->latestImageAudit(OA_AUDIT_ACTION_INSERT);
        $this->assertEqual($audit->account_id, $owners[OA_ACCOUNT_MANAGER]);
        $this->assertEqual($audit->advertiser_account_id, $owners[OA_ACCOUNT_ADVERTISER]);
    }

    public function testUpdateCachesPositiveAndNegativeLookupsPerAudit()
    {
        $banner = $this->createBanner('audit-source.png');
        $image = OA_Dal::staticGetDO('images', 'audit-source.png');
        $GLOBALS['_MAX']['CONF']['audit']['enabled'] = true;
        foreach (['first update', 'second update'] as $contents) {
            $image->contents = $contents;
            $queries = $this->captureLookups(function () use ($image) {
                $this->assertTrue($image->update());
            });
            $this->assertEqual(count($queries), 1);
            $details = unserialize($this->latestImageAudit(OA_AUDIT_ACTION_UPDATE)->details);
            $this->assertEqual($details['bannerid'], $banner->bannerid);
        }
        $GLOBALS['_MAX']['CONF']['audit']['enabled'] = false;
        $banner->filename = 'detached.png';
        $banner->update();
        $GLOBALS['_MAX']['CONF']['audit']['enabled'] = true;
        $image->contents = 'unowned update';
        $queries = $this->captureLookups(function () use ($image) {
            $this->assertTrue($image->update());
        });
        $this->assertEqual(count($queries), 1);
        $audit = $this->latestImageAudit(OA_AUDIT_ACTION_UPDATE);
        $this->assertFalse(isset(unserialize($audit->details)['bannerid']));
        $this->assertEqual($audit->account_id, OA_Dal_ApplicationVariables::get('admin_account_id'));
    }

    public function testLegacyDuplicationStillResolvesOwnership()
    {
        $banner = $this->createBanner('audit-source.png');
        $GLOBALS['_MAX']['CONF']['audit']['enabled'] = true;
        $queries = $this->captureLookups(function () use ($banner) {
            $this->assertTrue(is_string(phpAds_ImageDuplicate('sql', $banner->filename)));
        });
        $this->assertEqual(count($queries), 1);
        $audit = $this->latestImageAudit(OA_AUDIT_ACTION_INSERT);
        $this->assertEqual($audit->account_id, OA_Dal_ApplicationVariables::get('admin_account_id'));
    }

    public function testCopyContextDoesNotOverrideExistingDestination()
    {
        $source = $this->createBanner('audit-source.png');
        $destination = $this->createBanner('audit-destination.png');
        $owners = $destination->getOwningAccountIds();
        $adapter = new \RV\Bridge\Flysystem\SqlStoredBannerAdapter($source->getOwningAccountIds());
        $GLOBALS['_MAX']['CONF']['audit']['enabled'] = true;
        $queries = $this->captureLookups(function () use ($adapter) {
            $adapter->write('audit-destination.png', 'replacement', new \League\Flysystem\Config());
        });
        $this->assertEqual(count($queries), 1);
        $audit = $this->latestImageAudit(OA_AUDIT_ACTION_UPDATE);
        $this->assertEqual($audit->account_id, $owners[OA_ACCOUNT_MANAGER]);
        $this->assertEqual($audit->advertiser_account_id, $owners[OA_ACCOUNT_ADVERTISER]);
        $this->assertEqual(unserialize($audit->details)['bannerid'], $destination->bannerid);
    }
}
