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

function processBanners($commit = false)
{
    $doBanners = OA_Dal::factoryDO('banners');

    if ((OA_INSTALLATION_STATUS === OA_INSTALLATION_STATUS_INSTALLED) && OA_Permission::isAccount(OA_ACCOUNT_MANAGER)) {
        $doBanners->addReferenceFilter('agency', $agencyId = OA_Permission::getEntityId());
    }
    $doBanners->find();

    $different = 0;
    $same = 0;
    $errors = [];

    // Disable audit
    $audit = $GLOBALS['_MAX']['CONF']['audit'];
    $GLOBALS['_MAX']['CONF']['audit'] = false;

    while ($doBanners->fetch()) {
        // Rebuild filename
        if ($doBanners->storagetype == 'sql' || $doBanners->storagetype == 'web') {
            $doBanners->imageurl = '';
        }
        $GLOBALS['_MAX']['bannerrebuild']['errors'] = false;
        if ($commit) {
            $doBannersClone = clone($doBanners);
            $doBannersClone->update();
            $newCache = $doBannersClone->htmlcache;
            unset($doBannersClone);
        } else {
            $newCache = phpAds_getBannerCache($doBanners->toArray());
        }
        if (empty($GLOBALS['_MAX']['bannerrebuild']['errors'])) {
            if ($doBanners->htmlcache != $newCache && ($doBanners->storagetype == 'html')) {
                $different++;
            } else {
                $same++;
            }
        } else {
            $errors[] = $doBanners->toArray();
        }
    }

    // Enable audit if needed
    $GLOBALS['_MAX']['CONF']['audit'] = $audit;

    return ['errors' => $errors, 'different' => $different, 'same' => $same];
}
