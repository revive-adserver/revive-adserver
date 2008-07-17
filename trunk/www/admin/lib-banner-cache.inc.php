<?php
/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
| For contact details, see: http://www.openx.org/                           |
|                                                                           |
| This program is free software; you can redistribute it and/or modify      |
| it under the terms of the GNU General Public License as published by      |
| the Free Software Foundation; either version 2 of the License, or         |
| (at your option) any later version.                                       |
|                                                                           |
| This program is distributed in the hope that it will be useful,           |
| but WITHOUT ANY WARRANTY; without even the implied warranty of            |
| MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             |
| GNU General Public License for more details.                              |
|                                                                           |
| You should have received a copy of the GNU General Public License         |
| along with this program; if not, write to the Free Software               |
| Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA |
+---------------------------------------------------------------------------+
$Id $
*/

function processBanners($commit = false)
{
    $doBanners = OA_Dal::factoryDO('banners');

    if ((OA_INSTALLATION_STATUS === OA_INSTALLATION_STATUS_INSTALLED) && OA_Permission::isAccount(OA_ACCOUNT_MANAGER))
    {
        $doBanners->addReferenceFilter('agency', $agencyId = OA_Permission::getEntityId());
    }
    $doBanners->find();

    $different = 0;
    $same      = 0;
    $errors    = array();

    while ($doBanners->fetch())
    {
    	// Rebuild filename
    	if ($doBanners->storagetype == 'sql' || $doBanners->storagetype == 'web') {
    		$doBanners->imageurl = '';
    	}
    	$GLOBALS['_MAX']['bannerrebuild']['errors'] = false;
    	if ($commit) {
            $doBannersClone = clone($doBanners);
            $doBannersClone->update();
            $newCache = $doBannersClone->htmlcache;
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
    return array('errors' => $errors, 'different' => $different, 'same' => $same);
}
?>
