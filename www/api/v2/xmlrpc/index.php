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

/**
 * This file creates the dispatch map by merging core and plugin dispatch maps
 * and starts the XML-RPC server.
 */

require_once '../../../../init.php';
require_once LIB_PATH . '/Plugin/Component.php';
require_once 'XmlRpcFrontController.php';

$fc = new XmlrpcFrontController();

// OpenX Core Dispatch map
$dispatches = array(
    // Logon
    'ox.logon' => array(
        'function'  => array($fc, 'logon'),
        'signature' => array(
            array('string', 'string', 'string')
        ),
        'docstring' => 'Logon method'
    ),
    'ox.logoff' => array(
        'function'  => array($fc, 'logoff'),
        'signature' => array(
            array('bool', 'string')
        ),
        'docstring' => 'Logoff method'
    ),

    // Advertiser functions
    'ox.addAdvertiser' => array(
        'function'  => array($fc, 'addAdvertiser'),
        'signature' => array(
            array('int', 'string', 'struct')
        ),
        'docstring' => 'Add advertiser'
    ),
    'ox.modifyAdvertiser' => array(
        'function'  => array($fc, 'modifyAdvertiser'),
        'signature' => array(
            array('int', 'string', 'struct')
        ),
        'docstring' => 'Modify advertiser information'
    ),
    'ox.deleteAdvertiser' => array(
        'function'  => array($fc, 'deleteAdvertiser'),
        'signature' => array(
            array('int', 'string', 'int')
        ),
        'docstring' => 'Delete advertiser'
    ),
    'ox.advertiserDailyStatistics' => array(
        'function'  => array($fc, 'advertiserDailyStatistics'),
        'signature' => array(
            array('array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601', 'boolean'),
            array('array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601'),
            array('array', 'string', 'int', 'dateTime.iso8601'),
            array('array', 'string', 'int')
        ),
        'docstring' => 'Generate Advertiser Daily Statistics'
    ),
    'ox.advertiserCampaignStatistics' => array(
        'function'  => array($fc, 'advertiserCampaignStatistics'),
        'signature' => array(
            array('array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601', 'boolean'),
            array('array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601'),
            array('array', 'string', 'int', 'dateTime.iso8601'),
            array('array', 'string', 'int')
        ),
            'docstring' => 'Generate Advertiser Campaign Statistics'
    ),
    'ox.advertiserBannerStatistics' => array(
        'function'  => array($fc, 'advertiserBannerStatistics'),
        'signature' => array(
            array('array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601', 'boolean'),
            array('array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601'),
            array('array', 'string', 'int', 'dateTime.iso8601'),
            array('array', 'string', 'int')
        ),
        'docstring' => 'Generate Advertiser Banner Statistics'
    ),
    'ox.advertiserPublisherStatistics' => array(
        'function'  => array($fc, 'advertiserPublisherStatistics'),
        'signature' => array(
            array('array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601', 'boolean'),
            array('array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601'),
            array('array', 'string', 'int', 'dateTime.iso8601'),
            array('array', 'string', 'int')
        ),
        'docstring' => 'Generate Advertiser Publisher Statistics'
    ),
    'ox.advertiserZoneStatistics' => array(
        'function'  => array($fc, 'advertiserZoneStatistics'),
        'signature' => array(
            array('array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601', 'boolean'),
            array('array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601'),
            array('array', 'string', 'int', 'dateTime.iso8601'),
            array('array', 'string', 'int')
        ),
        'docstring' => 'Generate Advertiser Zone Statistics'
    ),
    'ox.getAdvertiser' => array(
        'function'  => array($fc, 'getAdvertiser'),
        'signature' => array(
            array('struct', 'string', 'int')
        ),
        'docstring' => 'Get Advertiser Information'
    ),
    'ox.getAdvertiserListByAgencyId' => array(
        'function'  => array($fc, 'getAdvertiserListByAgencyId'),
        'signature' => array(
            array('array', 'string', 'int')
        ),
        'docstring' => 'Get Advertiser List By Agency Id'
    ),

    // Agency functions
    'ox.addAgency' => array(
        'function'  => array($fc, 'addAgency'),
        'signature' => array(
            array('int', 'string', 'struct')
        ),
        'docstring' => 'Add agency'
    ),

    'ox.modifyAgency' => array(
        'function'  => array($fc, 'modifyAgency'),
        'signature' => array(
            array('int', 'string', 'struct')
        ),
        'docstring' => 'Modify agency information'
    ),

    'ox.deleteAgency' => array(
        'function'  => array($fc, 'deleteAgency'),
        'signature' => array(
            array('int', 'string', 'int')
        ),
        'docstring' => 'Delete agency'
    ),

    'ox.agencyDailyStatistics' => array(
        'function'  => array($fc, 'agencyDailyStatistics'),
        'signature' => array(
            array('array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601', 'boolean'),
            array('array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601'),
            array('array', 'string', 'int', 'dateTime.iso8601'),
            array('array', 'string', 'int')
        ),
        'docstring' => 'Generate Agency Daily Statistics'
    ),

    'ox.agencyAdvertiserStatistics' => array(
        'function'  => array($fc, 'agencyAdvertiserStatistics'),
        'signature' => array(
            array('array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601', 'boolean'),
            array('array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601'),
            array('array', 'string', 'int', 'dateTime.iso8601'),
            array('array', 'string', 'int')
        ),
        'docstring' => 'Generate Agency Advertiser Statistics'
    ),

    'ox.agencyCampaignStatistics' => array(
        'function'  => array($fc, 'agencyCampaignStatistics'),
        'signature' => array(
            array('array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601', 'boolean'),
            array('array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601'),
            array('array', 'string', 'int', 'dateTime.iso8601'),
            array('array', 'string', 'int')
        ),
        'docstring' => 'Generate Agency Campaign Statistics'
    ),

    'ox.agencyBannerStatistics' => array(
        'function'  => array($fc, 'agencyBannerStatistics'),
        'signature' => array(
            array('array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601', 'boolean'),
            array('array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601'),
            array('array', 'string', 'int', 'dateTime.iso8601'),
            array('array', 'string', 'int')
        ),
        'docstring' => 'Generate Agency Banner Statistics'
    ),

    'ox.agencyPublisherStatistics' => array(
        'function'  => array($fc, 'agencyPublisherStatistics'),
        'signature' => array(
            array('array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601', 'boolean'),
            array('array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601'),
            array('array', 'string', 'int', 'dateTime.iso8601'),
            array('array', 'string', 'int')
        ),
        'docstring' => 'Generate Agency Publisher Statistics'
    ),

    'ox.agencyZoneStatistics' => array(
        'function'  => array($fc, 'agencyZoneStatistics'),
        'signature' => array(
            array('array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601', 'boolean'),
            array('array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601'),
            array('array', 'string', 'int', 'dateTime.iso8601'),
            array('array', 'string', 'int')
        ),
        'docstring' => 'Generate Agency Zone Statistics'
    ),

    'ox.getAgency' => array(
        'function'  => array($fc, 'getAgency'),
        'signature' => array(
            array('struct', 'string', 'int')
        ),
        'docstring' => 'Get Agency Information'
    ),

    'ox.getAgencyList' => array(
        'function'  => array($fc, 'getAgencyList'),
        'signature' => array(
            array('array', 'string')
        ),
        'docstring' => 'Get Agency List'
    ),

    // Banner functions
    'ox.addBanner' => array(
        'function'  => array($fc, 'addBanner'),
        'signature' => array(
            array('int', 'string', 'struct')
        ),
        'docstring' => 'Add banner'
    ),

    'ox.modifyBanner' => array(
        'function'  => array($fc, 'modifyBanner'),
        'signature' => array(
            array('int', 'string', 'struct')
        ),
        'docstring' => 'Modify banner information'
    ),

    'ox.deleteBanner' => array(
        'function'  => array($fc, 'deleteBanner'),
        'signature' => array(
            array('int', 'string', 'int')
        ),
        'docstring' => 'Delete banner'
    ),

    'ox.getBannerTargeting' => array(
        'function'  => array($fc, 'getBannerTargeting'),
        'signature' => array(
            array('array', 'string', 'int')
        ),
        'docstring' => 'Get banner targeting limitations array'
    ),

    'ox.setBannerTargeting' => array(
        'function'  => array($fc, 'setBannerTargeting'),
        'signature' => array(
            array('boolean', 'string', 'int', 'array')
        ),
        'docstring' => 'Set banner targeting limitations array'
    ),

    'ox.bannerDailyStatistics' => array(
        'function'  => array($fc, 'bannerDailyStatistics'),
        'signature' => array(
            array('array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601', 'boolean'),
            array('array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601'),
            array('array', 'string', 'int', 'dateTime.iso8601'),
            array('array', 'string', 'int')
        ),
        'docstring' => 'Generate Banner Daily Statistics'
    ),

    'ox.bannerPublisherStatistics' => array(
        'function'  => array($fc, 'bannerPublisherStatistics'),
        'signature' => array(
            array('array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601', 'boolean'),
            array('array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601'),
            array('array', 'string', 'int', 'dateTime.iso8601'),
            array('array', 'string', 'int')
        ),
        'docstring' => 'Generate Banner Publisher Statistics'
    ),

    'ox.bannerZoneStatistics' => array(
        'function'  => array($fc, 'bannerZoneStatistics'),
        'signature' => array(
            array('array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601', 'boolean'),
            array('array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601'),
            array('array', 'string', 'int', 'dateTime.iso8601'),
            array('array', 'string', 'int')
        ),
        'docstring' => 'Generate Banner Zone Statistics'
    ),


    'ox.getBanner' => array(
        'function'  => array($fc, 'getBanner'),
        'signature' => array(
            array('struct', 'string', 'int')
        ),
        'docstring' => 'Get Banner Information'
    ),

    'ox.getBannerListByCampaignId' => array(
        'function'  => array($fc, 'getBannerListByCampaignId'),
        'signature' => array(
            array('array', 'string', 'int')
        ),
        'docstring' => 'Get Banner List By Campaign Id'
    ),

    // Campaign functions
    'ox.addCampaign' => array(
        'function'  => array($fc, 'addCampaign'),
        'signature' => array(
            array('int', 'string', 'struct')
        ),
        'docstring' => 'Add campaign'
    ),

    'ox.modifyCampaign' => array(
        'function'  => array($fc, 'modifyCampaign'),
        'signature' => array(
            array('int', 'string', 'struct')
        ),
        'docstring' => 'Modify campaign information'
    ),

    'ox.deleteCampaign' => array(
        'function'  => array($fc, 'deleteCampaign'),
        'signature' => array(
            array('int', 'string', 'int')
        ),
        'docstring' => 'Delete campaign'
    ),

    'ox.campaignDailyStatistics' => array(
        'function'  => array($fc, 'campaignDailyStatistics'),
        'signature' => array(
            array('array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601', 'boolean'),
            array('array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601'),
            array('array', 'string', 'int', 'dateTime.iso8601'),
            array('array', 'string', 'int')
        ),
        'docstring' => 'Generate campaign Daily Statistics'
    ),

    'ox.campaignBannerStatistics' => array(
        'function'  => array($fc, 'campaignBannerStatistics'),
        'signature' => array(
            array('array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601', 'boolean'),
            array('array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601'),
            array('array', 'string', 'int', 'dateTime.iso8601'),
            array('array', 'string', 'int')
        ),
        'docstring' => 'Generate campaign Banner Statistics'
    ),

    'ox.campaignPublisherStatistics' => array(
        'function'  => array($fc, 'campaignPublisherStatistics'),
        'signature' => array(
            array('array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601', 'boolean'),
            array('array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601'),
            array('array', 'string', 'int', 'dateTime.iso8601'),
            array('array', 'string', 'int')
        ),
        'docstring' => 'Generate campaign Publisher Statistics'
    ),

    'ox.campaignZoneStatistics' => array(
        'function'  => array($fc, 'campaignZoneStatistics'),
        'signature' => array(
            array('array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601', 'boolean'),
            array('array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601'),
            array('array', 'string', 'int', 'dateTime.iso8601'),
            array('array', 'string', 'int')
        ),
        'docstring' => 'Generate campaign Zone Statistics'
    ),

    'ox.campaignConversionStatistics' => array(
        'function'  => array($fc, 'campaignConversionStatistics'),
        'signature' => array(
            array('array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601', 'boolean'),
            array('array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601'),
            array('array', 'string', 'int', 'dateTime.iso8601'),
            array('array', 'string', 'int')
        ),
        'docstring' => 'Generate campaign Conversion Statistics'
    ),

    'ox.getCampaign' => array(
        'function'  => array($fc, 'getCampaign'),
        'signature' => array(
            array('struct', 'string', 'int')
        ),
        'docstring' => 'Get Campaign Information'
    ),

    'ox.getCampaignListByAdvertiserId' => array(
        'function'  => array($fc, 'getCampaignListByAdvertiserId'),
        'signature' => array(
            array('array', 'string', 'int')
        ),
        'docstring' => 'Get Campaign List By Advertiser Id'
    ),

    // Channel functions
    'ox.addChannel' => array(
        'function'  => array($fc, 'addChannel'),
        'signature' => array(
            array('int', 'string', 'struct')
        ),
        'docstring' => 'Add Channel'
    ),

    'ox.modifyChannel' => array(
        'function'  => array($fc, 'modifyChannel'),
        'signature' => array(
            array('int', 'string', 'struct')
        ),
        'docstring' => 'Modify Channel Information'
    ),

    'ox.deleteChannel' => array(
        'function'  => array($fc, 'deleteChannel'),
        'signature' => array(
            array('int', 'string', 'int')
        ),
        'docstring' => 'Delete Channel'
    ),

    'ox.getChannel' => array(
        'function'  => array($fc, 'getChannel'),
        'signature' => array(
            array('struct', 'string', 'int')
        ),
        'docstring' => 'Get Channel Information'
    ),

    'ox.getChannelListByWebsiteId' => array(
        'function'  => array($fc, 'getChannelListByWebsiteId'),
        'signature' => array(
            array('array', 'string', 'int')
        ),
        'docstring' => 'Get Website Channel List'
    ),

    'ox.getChannelListByAgencyId' => array(
        'function'  => array($fc, 'getChannelListByAgencyId'),
        'signature' => array(
            array('array', 'string', 'int')
        ),
        'docstring' => 'Get Agency Channel List'
    ),

    'ox.getChannelTargeting' => array(
        'function'  => array($fc, 'getChannelTargeting'),
        'signature' => array(
            array('array', 'string', 'int')
        ),
        'docstring' => 'Get channel targeting limitations array'
    ),

    'ox.setChannelTargeting' => array(
        'function'  => array($fc, 'setChannelTargeting'),
        'signature' => array(
            array('boolean', 'string', 'int', 'array')
        ),
        'docstring' => 'Set channel targeting limitations array'
    ),

    // Publisher (website) functions
    'ox.addPublisher' => array(
        'function'  => array($fc, 'addPublisher'),
        'signature' => array(
            array('int', 'string', 'struct')
        ),
        'docstring' => 'Add publisher'
    ),

    'ox.modifyPublisher' => array(
        'function'  => array($fc, 'modifyPublisher'),
        'signature' => array(
            array('int', 'string', 'struct')
        ),
        'docstring' => 'Modify publisher information'
    ),

    'ox.deletePublisher' => array(
        'function'  => array($fc, 'deletePublisher'),
        'signature' => array(
            array('int', 'string', 'int')
        ),
        'docstring' => 'Delete publisher'
    ),

    'ox.publisherDailyStatistics' => array(
        'function'  => array($fc, 'publisherDailyStatistics'),
        'signature' => array(
            array('array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601', 'boolean'),
            array('array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601'),
            array('array', 'string', 'int', 'dateTime.iso8601'),
            array('array', 'string', 'int')
        ),
        'docstring' => 'Generate Publisher Daily Statistics'
    ),

    'ox.publisherZoneStatistics' => array(
        'function'  => array($fc, 'publisherZoneStatistics'),
        'signature' => array(
            array('array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601', 'boolean'),
            array('array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601'),
            array('array', 'string', 'int', 'dateTime.iso8601'),
            array('array', 'string', 'int')
        ),
        'docstring' => 'Generate Publisher Zone Statistics'
    ),

    'ox.publisherAdvertiserStatistics' => array(
        'function'  => array($fc, 'publisherAdvertiserStatistics'),
        'signature' => array(
            array('array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601', 'boolean'),
            array('array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601'),
            array('array', 'string', 'int', 'dateTime.iso8601'),
            array('array', 'string', 'int')
        ),
        'docstring' => 'Generate Publisher Advertiser Statistics'
    ),

    'ox.publisherCampaignStatistics' => array(
        'function'  => array($fc, 'publisherCampaignStatistics'),
        'signature' => array(
            array('array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601', 'boolean'),
            array('array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601'),
            array('array', 'string', 'int', 'dateTime.iso8601'),
            array('array', 'string', 'int')
        ),
        'docstring' => 'Generate Publisher Campaign Statistics'
    ),

    'ox.publisherBannerStatistics' => array(
        'function'  => array($fc, 'publisherBannerStatistics'),
        'signature' => array(
            array('array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601', 'boolean'),
            array('array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601'),
            array('array', 'string', 'int', 'dateTime.iso8601'),
            array('array', 'string', 'int')
        ),
        'docstring' => 'Generate Publisher Banner Statistics'
    ),

    'ox.getPublisher' => array(
        'function'  => array($fc, 'getPublisher'),
        'signature' => array(
            array('struct', 'string', 'int')
        ),
        'docstring' => 'Get Publisher Information'
    ),

    'ox.getPublisherListByAgencyId' => array(
        'function'  => array($fc, 'getPublisherListByAgencyId'),
        'signature' => array(
            array('array', 'string', 'int')
        ),
        'docstring' => 'Get Publishers List By Agency Id'
    ),

    // Tracker functions
    'ox.addTracker' => array(
        'function' => array($fc, 'addTracker'),
        'signature' => array(
            array('int', 'string', 'struct')
        ),
        'docstring' => 'Add tracker'
    ),

    'ox.modifyTracker' => array(
        'function'  => array($fc, 'modifyTracker'),
        'signature' => array(
            array('boolean', 'string', 'struct')
        ),
        'docstring' => 'Modify tracker'
    ),

    'ox.deleteTracker' => array(
        'function' => array($fc, 'deleteTracker'),
        'signature' => array(
            array('boolean', 'string', 'int')
        ),
        'docstring' => 'Delete tracker'
    ),

    'ox.linkTrackerToCampaign' => array(
        'function' => array($fc, 'linkTrackerToCampaign'),
        'signature' => array(
            array('boolean', 'string', 'int', 'int'),
            array('boolean', 'string', 'int', 'int', 'int')
        ),
        'docstring' => 'Link tracker to campaign'
    ),

    'ox.getTracker' => array(
        'function'  => array($fc, 'getTracker'),
        'signature' => array(
            array('struct', 'string', 'int')
        ),
        'docstring' => 'Get Tracker Information'
    ),

    // User functions
    'ox.addUser' => array(
        'function'  => array($fc, 'addUser'),
        'signature' => array(
            array('int', 'string', 'struct')
        ),
        'docstring' => 'Add user'
    ),

    'ox.modifyUser' => array(
        'function'  => array($fc, 'modifyUser'),
        'signature' => array(
            array('int', 'string', 'struct')
        ),
        'docstring' => 'Modify user information'
    ),

    'ox.deleteUser' => array(
        'function'  => array($fc, 'deleteUser'),
        'signature' => array(
            array('int', 'string', 'int')
        ),
        'docstring' => 'Delete user'
    ),

    'ox.getUser' => array(
        'function'  => array($fc, 'getUser'),
        'signature' => array(
            array('struct', 'string', 'int')
        ),
        'docstring' => 'Get User Information'
    ),

    'ox.getUserList' => array(
        'function'  => array($fc, 'getUserList'),
        'signature' => array(
            array('array', 'string')
        ),
        'docstring' => 'Get User List'
    ),

    'ox.getUserListByAccountId' => array(
        'function'  => array($fc, 'getUserListByAccountId'),
        'signature' => array(
            array('array', 'string', 'int')
        ),
        'docstring' => 'Get User List By Account Id'
    ),

    'ox.updateSsoUserId' => array(
        'function'  => array($fc, 'updateSsoUserId'),
        'signature' => array(
            array('array', 'string', 'int', 'int')
        ),
        'docstring' => 'Change the SSO User ID field'
    ),

    'ox.updateUserEmailBySsoId' => array(
        'function'  => array($fc, 'updateUserEmailBySsoId'),
        'signature' => array(
            array('array', 'string', 'int', 'string')
        ),
        'docstring' => 'Change users email for the user who match the SSO User ID'
    ),

    'ox.linkUserToAdvertiserAccount' => array(
        'function'  => array($fc, 'linkUserToAdvertiserAccount'),
        'signature' => array(
            array('boolean', 'string', 'int', 'int', 'array'),
            array('boolean', 'string', 'int', 'int')
        ),
        'docstring' => 'link a user to an advertiser account'
    ),

    'ox.linkUserToTraffickerAccount' => array(
        'function'  => array($fc, 'linkUserToTraffickerAccount'),
        'signature' => array(
            array('boolean', 'string', 'int', 'int', 'array'),
            array('boolean', 'string', 'int', 'int')
        ),
        'docstring' => 'link a user to a trafficker account'
    ),

    'ox.linkUserToManagerAccount' => array(
        'function'  => array($fc, 'linkUserToManagerAccount'),
        'signature' => array(
            array('boolean', 'string', 'int', 'int', 'array'),
            array('boolean', 'string', 'int', 'int')
        ),
        'docstring' => 'link a user to a manager account'
    ),

    // Variable functions
    'ox.addVariable' => array(
        'function' => array($fc, 'addVariable'),
        'signature' => array(
            array('int', 'string', 'struct')
        ),
        'docstring' => 'Add variable'
    ),

    'ox.modifyVariable' => array(
        'function'  => array($fc, 'modifyVariable'),
        'signature' => array(
            array('boolean', 'string', 'struct')
        ),
        'docstring' => 'Modify variable'
    ),

    'ox.deleteVariable' => array(
        'function' => array($fc, 'deleteVariable'),
        'signature' => array(
            array('boolean', 'string', 'int')
        ),
        'docstring' => 'Delete variable'
    ),

    'ox.getVariable' => array(
        'function'  => array($fc, 'getVariable'),
        'signature' => array(
            array('struct', 'string', 'int')
        ),
        'docstring' => 'Get variable information'
    ),

    // Zone functions
    'ox.addZone' => array(
        'function'  => array($fc, 'addZone'),
        'signature' => array(
            array('int', 'string', 'struct')
        ),
        'docstring' => 'Add zone'
    ),

    'ox.modifyZone' => array(
        'function'  => array($fc, 'modifyZone'),
        'signature' => array(
            array('int', 'string', 'struct')
        ),
        'docstring' => 'Modify zone information'
    ),

    'ox.deleteZone' => array(
        'function'  => array($fc, 'deleteZone'),
        'signature' => array(
            array('int', 'string', 'int')
        ),
        'docstring' => 'Delete zone'
    ),

    'ox.zoneDailyStatistics' => array(
        'function'  => array($fc, 'zoneDailyStatistics'),
        'signature' => array(
            array('array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601', 'boolean'),
            array('array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601'),
            array('array', 'string', 'int', 'dateTime.iso8601'),
            array('array', 'string', 'int')
        ),
        'docstring' => 'Generate Zone Daily Statistics'
    ),

    'ox.zoneAdvertiserStatistics' => array(
        'function'  => array($fc, 'zoneAdvertiserStatistics'),
        'signature' => array(
            array('array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601', 'boolean'),
            array('array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601'),
            array('array', 'string', 'int', 'dateTime.iso8601'),
            array('array', 'string', 'int')
        ),
        'docstring' => 'Generate Zone Advertiser Statistics'
    ),

    'ox.zoneCampaignStatistics' => array(
        'function'  => array($fc, 'zoneCampaignStatistics'),
        'signature' => array(
            array('array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601', 'boolean'),
            array('array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601'),
            array('array', 'string', 'int', 'dateTime.iso8601'),
            array('array', 'string', 'int')
        ),
        'docstring' => 'Generate Zone Campaign Statistics'
    ),

    'ox.zoneBannerStatistics' => array(
        'function'  => array($fc, 'zoneBannerStatistics'),
        'signature' => array(
            array('array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601', 'boolean'),
            array('array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601'),
            array('array', 'string', 'int', 'dateTime.iso8601'),
            array('array', 'string', 'int')
        ),
        'docstring' => 'Generate Zone Banner Statistics'
    ),

    'ox.getZone' => array(
        'function'  => array($fc, 'getZone'),
        'signature' => array(
            array('struct', 'string', 'int')
        ),
        'docstring' => 'Get Zone Information'
    ),

    'ox.getZoneListByPublisherId' => array(
        'function'  => array($fc, 'getZoneListByPublisherId'),
        'signature' => array(
            array('array', 'string', 'int')
        ),
        'docstring' => 'Get Zone List By Publisher Id'
    ),

    'ox.linkBanner' => array(
        'function'  => array($fc, 'linkBanner'),
        'signature' => array(
            array('int', 'string', 'int', 'int')
        ),
        'docstring' => 'Link a banner to a zone'
    ),

    'ox.linkCampaign' => array(
        'function'  => array($fc, 'linkCampaign'),
        'signature' => array(
            array('int', 'string', 'int', 'int')
        ),
        'docstring' => 'Link a campaign to a zone'
    ),

    'ox.unlinkBanner' => array(
        'function'  => array($fc, 'unlinkBanner'),
        'signature' => array(
            array('int', 'string', 'int', 'int')
        ),
        'docstring' => 'Unlink a banner to from zone'
    ),

    'ox.unlinkCampaign' => array(
        'function'  => array($fc, 'unlinkCampaign'),
        'signature' => array(
            array('int', 'string', 'int', 'int')
        ),
        'docstring' => 'Unlink a campaign from a zone'
    ),

    'ox.generateTags' => array(
        'function'  => array($fc, 'generateTags'),
        'signature' => array(
            array('string', 'string', 'int', 'string', 'struct'),
            array('string', 'string', 'int', 'string', 'array')
        ),
        'docstring' => 'Unlink a campaign from a zone'
    ),

);


// Merge the plugins' dispatch maps with core.
// Function names should be namespaced.
$aComponents = OX_Component::getComponents('api');
$aMaps = OX_Component::callOnComponents($aComponents, 'getDispatchMap');
foreach($aMaps as $map) {
    $dispatches = array_merge($dispatches, $map);
}

$server = new XML_RPC_Server($dispatches, 1);
