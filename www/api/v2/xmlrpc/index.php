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

$fc = new XmlRpcFrontController();

// OpenX Core Dispatch map
$dispatches = [
    // Logon
    'ox.logon' => [
        'function' => [$fc, 'logon'],
        'signature' => [
            ['string', 'string', 'string']
        ],
        'docstring' => 'Logon method'
    ],
    'ox.logoff' => [
        'function' => [$fc, 'logoff'],
        'signature' => [
            ['bool', 'string']
        ],
        'docstring' => 'Logoff method'
    ],

    // Advertiser functions
    'ox.addAdvertiser' => [
        'function' => [$fc, 'addAdvertiser'],
        'signature' => [
            ['int', 'string', 'struct']
        ],
        'docstring' => 'Add advertiser'
    ],
    'ox.modifyAdvertiser' => [
        'function' => [$fc, 'modifyAdvertiser'],
        'signature' => [
            ['int', 'string', 'struct']
        ],
        'docstring' => 'Modify advertiser information'
    ],
    'ox.deleteAdvertiser' => [
        'function' => [$fc, 'deleteAdvertiser'],
        'signature' => [
            ['int', 'string', 'int']
        ],
        'docstring' => 'Delete advertiser'
    ],
    'ox.advertiserDailyStatistics' => [
        'function' => [$fc, 'advertiserDailyStatistics'],
        'signature' => [
            ['array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601', 'boolean'],
            ['array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601'],
            ['array', 'string', 'int', 'dateTime.iso8601'],
            ['array', 'string', 'int']
        ],
        'docstring' => 'Generate Advertiser Daily Statistics'
    ],
    'ox.advertiserHourlyStatistics' => [
        'function' => [$fc, 'advertiserHourlyStatistics'],
        'signature' => [
            ['array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601', 'boolean'],
            ['array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601'],
            ['array', 'string', 'int', 'dateTime.iso8601'],
            ['array', 'string', 'int']
        ],
        'docstring' => 'Generate Advertiser Hourly Statistics'
    ],
    'ox.advertiserCampaignStatistics' => [
        'function' => [$fc, 'advertiserCampaignStatistics'],
        'signature' => [
            ['array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601', 'boolean'],
            ['array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601'],
            ['array', 'string', 'int', 'dateTime.iso8601'],
            ['array', 'string', 'int']
        ],
            'docstring' => 'Generate Advertiser Campaign Statistics'
    ],
    'ox.advertiserBannerStatistics' => [
        'function' => [$fc, 'advertiserBannerStatistics'],
        'signature' => [
            ['array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601', 'boolean'],
            ['array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601'],
            ['array', 'string', 'int', 'dateTime.iso8601'],
            ['array', 'string', 'int']
        ],
        'docstring' => 'Generate Advertiser Banner Statistics'
    ],
    'ox.advertiserPublisherStatistics' => [
        'function' => [$fc, 'advertiserPublisherStatistics'],
        'signature' => [
            ['array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601', 'boolean'],
            ['array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601'],
            ['array', 'string', 'int', 'dateTime.iso8601'],
            ['array', 'string', 'int']
        ],
        'docstring' => 'Generate Advertiser Publisher Statistics'
    ],
    'ox.advertiserZoneStatistics' => [
        'function' => [$fc, 'advertiserZoneStatistics'],
        'signature' => [
            ['array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601', 'boolean'],
            ['array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601'],
            ['array', 'string', 'int', 'dateTime.iso8601'],
            ['array', 'string', 'int']
        ],
        'docstring' => 'Generate Advertiser Zone Statistics'
    ],
    'ox.getAdvertiser' => [
        'function' => [$fc, 'getAdvertiser'],
        'signature' => [
            ['struct', 'string', 'int']
        ],
        'docstring' => 'Get Advertiser Information'
    ],
    'ox.getAdvertiserListByAgencyId' => [
        'function' => [$fc, 'getAdvertiserListByAgencyId'],
        'signature' => [
            ['array', 'string', 'int']
        ],
        'docstring' => 'Get Advertiser List By Agency Id'
    ],

    // Agency functions
    'ox.addAgency' => [
        'function' => [$fc, 'addAgency'],
        'signature' => [
            ['int', 'string', 'struct']
        ],
        'docstring' => 'Add agency'
    ],

    'ox.modifyAgency' => [
        'function' => [$fc, 'modifyAgency'],
        'signature' => [
            ['int', 'string', 'struct']
        ],
        'docstring' => 'Modify agency information'
    ],

    'ox.deleteAgency' => [
        'function' => [$fc, 'deleteAgency'],
        'signature' => [
            ['int', 'string', 'int']
        ],
        'docstring' => 'Delete agency'
    ],

    'ox.agencyDailyStatistics' => [
        'function' => [$fc, 'agencyDailyStatistics'],
        'signature' => [
            ['array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601', 'boolean'],
            ['array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601'],
            ['array', 'string', 'int', 'dateTime.iso8601'],
            ['array', 'string', 'int']
        ],
        'docstring' => 'Generate Agency Daily Statistics'
    ],

    'ox.agencyHourlyStatistics' => [
        'function' => [$fc, 'agencyHourlyStatistics'],
        'signature' => [
            ['array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601', 'boolean'],
            ['array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601'],
            ['array', 'string', 'int', 'dateTime.iso8601'],
            ['array', 'string', 'int']
        ],
        'docstring' => 'Generate Agency Hourly Statistics'
    ],

    'ox.agencyAdvertiserStatistics' => [
        'function' => [$fc, 'agencyAdvertiserStatistics'],
        'signature' => [
            ['array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601', 'boolean'],
            ['array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601'],
            ['array', 'string', 'int', 'dateTime.iso8601'],
            ['array', 'string', 'int']
        ],
        'docstring' => 'Generate Agency Advertiser Statistics'
    ],

    'ox.agencyCampaignStatistics' => [
        'function' => [$fc, 'agencyCampaignStatistics'],
        'signature' => [
            ['array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601', 'boolean'],
            ['array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601'],
            ['array', 'string', 'int', 'dateTime.iso8601'],
            ['array', 'string', 'int']
        ],
        'docstring' => 'Generate Agency Campaign Statistics'
    ],

    'ox.agencyBannerStatistics' => [
        'function' => [$fc, 'agencyBannerStatistics'],
        'signature' => [
            ['array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601', 'boolean'],
            ['array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601'],
            ['array', 'string', 'int', 'dateTime.iso8601'],
            ['array', 'string', 'int']
        ],
        'docstring' => 'Generate Agency Banner Statistics'
    ],

    'ox.agencyPublisherStatistics' => [
        'function' => [$fc, 'agencyPublisherStatistics'],
        'signature' => [
            ['array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601', 'boolean'],
            ['array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601'],
            ['array', 'string', 'int', 'dateTime.iso8601'],
            ['array', 'string', 'int']
        ],
        'docstring' => 'Generate Agency Publisher Statistics'
    ],

    'ox.agencyZoneStatistics' => [
        'function' => [$fc, 'agencyZoneStatistics'],
        'signature' => [
            ['array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601', 'boolean'],
            ['array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601'],
            ['array', 'string', 'int', 'dateTime.iso8601'],
            ['array', 'string', 'int']
        ],
        'docstring' => 'Generate Agency Zone Statistics'
    ],

    'ox.getAgency' => [
        'function' => [$fc, 'getAgency'],
        'signature' => [
            ['struct', 'string', 'int']
        ],
        'docstring' => 'Get Agency Information'
    ],

    'ox.getAgencyList' => [
        'function' => [$fc, 'getAgencyList'],
        'signature' => [
            ['array', 'string']
        ],
        'docstring' => 'Get Agency List'
    ],

    // Banner functions
    'ox.addBanner' => [
        'function' => [$fc, 'addBanner'],
        'signature' => [
            ['int', 'string', 'struct']
        ],
        'docstring' => 'Add banner'
    ],

    'ox.modifyBanner' => [
        'function' => [$fc, 'modifyBanner'],
        'signature' => [
            ['int', 'string', 'struct']
        ],
        'docstring' => 'Modify banner information'
    ],

    'ox.deleteBanner' => [
        'function' => [$fc, 'deleteBanner'],
        'signature' => [
            ['int', 'string', 'int']
        ],
        'docstring' => 'Delete banner'
    ],

    'ox.getBannerTargeting' => [
        'function' => [$fc, 'getBannerTargeting'],
        'signature' => [
            ['array', 'string', 'int']
        ],
        'docstring' => 'Get banner targeting limitations array'
    ],

    'ox.setBannerTargeting' => [
        'function' => [$fc, 'setBannerTargeting'],
        'signature' => [
            ['boolean', 'string', 'int', 'array']
        ],
        'docstring' => 'Set banner targeting limitations array'
    ],

    'ox.bannerDailyStatistics' => [
        'function' => [$fc, 'bannerDailyStatistics'],
        'signature' => [
            ['array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601', 'boolean'],
            ['array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601'],
            ['array', 'string', 'int', 'dateTime.iso8601'],
            ['array', 'string', 'int']
        ],
        'docstring' => 'Generate Banner Daily Statistics'
    ],

    'ox.bannerHourlyStatistics' => [
        'function' => [$fc, 'bannerHourlyStatistics'],
        'signature' => [
            ['array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601', 'boolean'],
            ['array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601'],
            ['array', 'string', 'int', 'dateTime.iso8601'],
            ['array', 'string', 'int']
        ],
        'docstring' => 'Generate Banner Hourly Statistics'
    ],

    'ox.bannerPublisherStatistics' => [
        'function' => [$fc, 'bannerPublisherStatistics'],
        'signature' => [
            ['array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601', 'boolean'],
            ['array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601'],
            ['array', 'string', 'int', 'dateTime.iso8601'],
            ['array', 'string', 'int']
        ],
        'docstring' => 'Generate Banner Publisher Statistics'
    ],

    'ox.bannerZoneStatistics' => [
        'function' => [$fc, 'bannerZoneStatistics'],
        'signature' => [
            ['array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601', 'boolean'],
            ['array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601'],
            ['array', 'string', 'int', 'dateTime.iso8601'],
            ['array', 'string', 'int']
        ],
        'docstring' => 'Generate Banner Zone Statistics'
    ],


    'ox.getBanner' => [
        'function' => [$fc, 'getBanner'],
        'signature' => [
            ['struct', 'string', 'int']
        ],
        'docstring' => 'Get Banner Information'
    ],

    'ox.getBannerListByCampaignId' => [
        'function' => [$fc, 'getBannerListByCampaignId'],
        'signature' => [
            ['array', 'string', 'int']
        ],
        'docstring' => 'Get Banner List By Campaign Id'
    ],

    // Campaign functions
    'ox.addCampaign' => [
        'function' => [$fc, 'addCampaign'],
        'signature' => [
            ['int', 'string', 'struct']
        ],
        'docstring' => 'Add campaign'
    ],

    'ox.modifyCampaign' => [
        'function' => [$fc, 'modifyCampaign'],
        'signature' => [
            ['int', 'string', 'struct']
        ],
        'docstring' => 'Modify campaign information'
    ],

    'ox.deleteCampaign' => [
        'function' => [$fc, 'deleteCampaign'],
        'signature' => [
            ['int', 'string', 'int']
        ],
        'docstring' => 'Delete campaign'
    ],

    'ox.campaignDailyStatistics' => [
        'function' => [$fc, 'campaignDailyStatistics'],
        'signature' => [
            ['array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601', 'boolean'],
            ['array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601'],
            ['array', 'string', 'int', 'dateTime.iso8601'],
            ['array', 'string', 'int']
        ],
        'docstring' => 'Generate campaign Daily Statistics'
    ],

    'ox.campaignHourlyStatistics' => [
        'function' => [$fc, 'campaignHourlyStatistics'],
        'signature' => [
            ['array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601', 'boolean'],
            ['array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601'],
            ['array', 'string', 'int', 'dateTime.iso8601'],
            ['array', 'string', 'int']
        ],
        'docstring' => 'Generate campaign Hourly Statistics'
    ],

    'ox.campaignBannerStatistics' => [
        'function' => [$fc, 'campaignBannerStatistics'],
        'signature' => [
            ['array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601', 'boolean'],
            ['array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601'],
            ['array', 'string', 'int', 'dateTime.iso8601'],
            ['array', 'string', 'int']
        ],
        'docstring' => 'Generate campaign Banner Statistics'
    ],

    'ox.campaignPublisherStatistics' => [
        'function' => [$fc, 'campaignPublisherStatistics'],
        'signature' => [
            ['array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601', 'boolean'],
            ['array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601'],
            ['array', 'string', 'int', 'dateTime.iso8601'],
            ['array', 'string', 'int']
        ],
        'docstring' => 'Generate campaign Publisher Statistics'
    ],

    'ox.campaignZoneStatistics' => [
        'function' => [$fc, 'campaignZoneStatistics'],
        'signature' => [
            ['array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601', 'boolean'],
            ['array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601'],
            ['array', 'string', 'int', 'dateTime.iso8601'],
            ['array', 'string', 'int']
        ],
        'docstring' => 'Generate campaign Zone Statistics'
    ],

    'ox.campaignConversionStatistics' => [
        'function' => [$fc, 'campaignConversionStatistics'],
        'signature' => [
            ['array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601', 'boolean'],
            ['array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601'],
            ['array', 'string', 'int', 'dateTime.iso8601'],
            ['array', 'string', 'int']
        ],
        'docstring' => 'Generate campaign Conversion Statistics'
    ],

    'ox.getCampaign' => [
        'function' => [$fc, 'getCampaign'],
        'signature' => [
            ['struct', 'string', 'int']
        ],
        'docstring' => 'Get Campaign Information'
    ],

    'ox.getCampaignListByAdvertiserId' => [
        'function' => [$fc, 'getCampaignListByAdvertiserId'],
        'signature' => [
            ['array', 'string', 'int']
        ],
        'docstring' => 'Get Campaign List By Advertiser Id'
    ],

    // Channel functions
    'ox.addChannel' => [
        'function' => [$fc, 'addChannel'],
        'signature' => [
            ['int', 'string', 'struct']
        ],
        'docstring' => 'Add Channel'
    ],

    'ox.modifyChannel' => [
        'function' => [$fc, 'modifyChannel'],
        'signature' => [
            ['int', 'string', 'struct']
        ],
        'docstring' => 'Modify Channel Information'
    ],

    'ox.deleteChannel' => [
        'function' => [$fc, 'deleteChannel'],
        'signature' => [
            ['int', 'string', 'int']
        ],
        'docstring' => 'Delete Channel'
    ],

    'ox.getChannel' => [
        'function' => [$fc, 'getChannel'],
        'signature' => [
            ['struct', 'string', 'int']
        ],
        'docstring' => 'Get Channel Information'
    ],

    'ox.getChannelListByWebsiteId' => [
        'function' => [$fc, 'getChannelListByWebsiteId'],
        'signature' => [
            ['array', 'string', 'int']
        ],
        'docstring' => 'Get Website Channel List'
    ],

    'ox.getChannelListByAgencyId' => [
        'function' => [$fc, 'getChannelListByAgencyId'],
        'signature' => [
            ['array', 'string', 'int']
        ],
        'docstring' => 'Get Agency Channel List'
    ],

    'ox.getChannelTargeting' => [
        'function' => [$fc, 'getChannelTargeting'],
        'signature' => [
            ['array', 'string', 'int']
        ],
        'docstring' => 'Get channel targeting limitations array'
    ],

    'ox.setChannelTargeting' => [
        'function' => [$fc, 'setChannelTargeting'],
        'signature' => [
            ['boolean', 'string', 'int', 'array']
        ],
        'docstring' => 'Set channel targeting limitations array'
    ],

    // Publisher (website) functions
    'ox.addPublisher' => [
        'function' => [$fc, 'addPublisher'],
        'signature' => [
            ['int', 'string', 'struct']
        ],
        'docstring' => 'Add publisher'
    ],

    'ox.modifyPublisher' => [
        'function' => [$fc, 'modifyPublisher'],
        'signature' => [
            ['int', 'string', 'struct']
        ],
        'docstring' => 'Modify publisher information'
    ],

    'ox.deletePublisher' => [
        'function' => [$fc, 'deletePublisher'],
        'signature' => [
            ['int', 'string', 'int']
        ],
        'docstring' => 'Delete publisher'
    ],

    'ox.publisherDailyStatistics' => [
        'function' => [$fc, 'publisherDailyStatistics'],
        'signature' => [
            ['array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601', 'boolean'],
            ['array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601'],
            ['array', 'string', 'int', 'dateTime.iso8601'],
            ['array', 'string', 'int']
        ],
        'docstring' => 'Generate Publisher Daily Statistics'
    ],

    'ox.publisherHourlyStatistics' => [
        'function' => [$fc, 'publisherHourlyStatistics'],
        'signature' => [
            ['array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601', 'boolean'],
            ['array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601'],
            ['array', 'string', 'int', 'dateTime.iso8601'],
            ['array', 'string', 'int']
        ],
        'docstring' => 'Generate Publisher Hourly Statistics'
    ],

    'ox.publisherZoneStatistics' => [
        'function' => [$fc, 'publisherZoneStatistics'],
        'signature' => [
            ['array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601', 'boolean'],
            ['array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601'],
            ['array', 'string', 'int', 'dateTime.iso8601'],
            ['array', 'string', 'int']
        ],
        'docstring' => 'Generate Publisher Zone Statistics'
    ],

    'ox.publisherAdvertiserStatistics' => [
        'function' => [$fc, 'publisherAdvertiserStatistics'],
        'signature' => [
            ['array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601', 'boolean'],
            ['array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601'],
            ['array', 'string', 'int', 'dateTime.iso8601'],
            ['array', 'string', 'int']
        ],
        'docstring' => 'Generate Publisher Advertiser Statistics'
    ],

    'ox.publisherCampaignStatistics' => [
        'function' => [$fc, 'publisherCampaignStatistics'],
        'signature' => [
            ['array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601', 'boolean'],
            ['array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601'],
            ['array', 'string', 'int', 'dateTime.iso8601'],
            ['array', 'string', 'int']
        ],
        'docstring' => 'Generate Publisher Campaign Statistics'
    ],

    'ox.publisherBannerStatistics' => [
        'function' => [$fc, 'publisherBannerStatistics'],
        'signature' => [
            ['array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601', 'boolean'],
            ['array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601'],
            ['array', 'string', 'int', 'dateTime.iso8601'],
            ['array', 'string', 'int']
        ],
        'docstring' => 'Generate Publisher Banner Statistics'
    ],

    'ox.getPublisher' => [
        'function' => [$fc, 'getPublisher'],
        'signature' => [
            ['struct', 'string', 'int']
        ],
        'docstring' => 'Get Publisher Information'
    ],

    'ox.getPublisherListByAgencyId' => [
        'function' => [$fc, 'getPublisherListByAgencyId'],
        'signature' => [
            ['array', 'string', 'int']
        ],
        'docstring' => 'Get Publishers List By Agency Id'
    ],

    // Tracker functions
    'ox.addTracker' => [
        'function' => [$fc, 'addTracker'],
        'signature' => [
            ['int', 'string', 'struct']
        ],
        'docstring' => 'Add tracker'
    ],

    'ox.modifyTracker' => [
        'function' => [$fc, 'modifyTracker'],
        'signature' => [
            ['boolean', 'string', 'struct']
        ],
        'docstring' => 'Modify tracker'
    ],

    'ox.deleteTracker' => [
        'function' => [$fc, 'deleteTracker'],
        'signature' => [
            ['boolean', 'string', 'int']
        ],
        'docstring' => 'Delete tracker'
    ],

    'ox.linkTrackerToCampaign' => [
        'function' => [$fc, 'linkTrackerToCampaign'],
        'signature' => [
            ['boolean', 'string', 'int', 'int'],
            ['boolean', 'string', 'int', 'int', 'int']
        ],
        'docstring' => 'Link tracker to campaign'
    ],

    'ox.getTracker' => [
        'function' => [$fc, 'getTracker'],
        'signature' => [
            ['struct', 'string', 'int']
        ],
        'docstring' => 'Get Tracker Information'
    ],

    // User functions
    'ox.addUser' => [
        'function' => [$fc, 'addUser'],
        'signature' => [
            ['int', 'string', 'struct']
        ],
        'docstring' => 'Add user'
    ],

    'ox.modifyUser' => [
        'function' => [$fc, 'modifyUser'],
        'signature' => [
            ['int', 'string', 'struct']
        ],
        'docstring' => 'Modify user information'
    ],

    'ox.deleteUser' => [
        'function' => [$fc, 'deleteUser'],
        'signature' => [
            ['int', 'string', 'int']
        ],
        'docstring' => 'Delete user'
    ],

    'ox.getUser' => [
        'function' => [$fc, 'getUser'],
        'signature' => [
            ['struct', 'string', 'int']
        ],
        'docstring' => 'Get User Information'
    ],

    'ox.getUserList' => [
        'function' => [$fc, 'getUserList'],
        'signature' => [
            ['array', 'string']
        ],
        'docstring' => 'Get User List'
    ],

    'ox.getUserListByAccountId' => [
        'function' => [$fc, 'getUserListByAccountId'],
        'signature' => [
            ['array', 'string', 'int']
        ],
        'docstring' => 'Get User List By Account Id'
    ],

    'ox.updateSsoUserId' => [
        'function' => [$fc, 'updateSsoUserId'],
        'signature' => [
            ['array', 'string', 'int', 'int']
        ],
        'docstring' => 'Change the SSO User ID field'
    ],

    'ox.updateUserEmailBySsoId' => [
        'function' => [$fc, 'updateUserEmailBySsoId'],
        'signature' => [
            ['array', 'string', 'int', 'string']
        ],
        'docstring' => 'Change users email for the user who match the SSO User ID'
    ],

    'ox.linkUserToAdvertiserAccount' => [
        'function' => [$fc, 'linkUserToAdvertiserAccount'],
        'signature' => [
            ['boolean', 'string', 'int', 'int', 'array'],
            ['boolean', 'string', 'int', 'int']
        ],
        'docstring' => 'link a user to an advertiser account'
    ],

    'ox.linkUserToTraffickerAccount' => [
        'function' => [$fc, 'linkUserToTraffickerAccount'],
        'signature' => [
            ['boolean', 'string', 'int', 'int', 'array'],
            ['boolean', 'string', 'int', 'int']
        ],
        'docstring' => 'link a user to a trafficker account'
    ],

    'ox.linkUserToManagerAccount' => [
        'function' => [$fc, 'linkUserToManagerAccount'],
        'signature' => [
            ['boolean', 'string', 'int', 'int', 'array'],
            ['boolean', 'string', 'int', 'int']
        ],
        'docstring' => 'link a user to a manager account'
    ],

    // Variable functions
    'ox.addVariable' => [
        'function' => [$fc, 'addVariable'],
        'signature' => [
            ['int', 'string', 'struct']
        ],
        'docstring' => 'Add variable'
    ],

    'ox.modifyVariable' => [
        'function' => [$fc, 'modifyVariable'],
        'signature' => [
            ['boolean', 'string', 'struct']
        ],
        'docstring' => 'Modify variable'
    ],

    'ox.deleteVariable' => [
        'function' => [$fc, 'deleteVariable'],
        'signature' => [
            ['boolean', 'string', 'int']
        ],
        'docstring' => 'Delete variable'
    ],

    'ox.getVariable' => [
        'function' => [$fc, 'getVariable'],
        'signature' => [
            ['struct', 'string', 'int']
        ],
        'docstring' => 'Get variable information'
    ],

    // Zone functions
    'ox.addZone' => [
        'function' => [$fc, 'addZone'],
        'signature' => [
            ['int', 'string', 'struct']
        ],
        'docstring' => 'Add zone'
    ],

    'ox.modifyZone' => [
        'function' => [$fc, 'modifyZone'],
        'signature' => [
            ['int', 'string', 'struct']
        ],
        'docstring' => 'Modify zone information'
    ],

    'ox.deleteZone' => [
        'function' => [$fc, 'deleteZone'],
        'signature' => [
            ['int', 'string', 'int']
        ],
        'docstring' => 'Delete zone'
    ],

    'ox.zoneDailyStatistics' => [
        'function' => [$fc, 'zoneDailyStatistics'],
        'signature' => [
            ['array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601', 'boolean'],
            ['array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601'],
            ['array', 'string', 'int', 'dateTime.iso8601'],
            ['array', 'string', 'int']
        ],
        'docstring' => 'Generate Zone Daily Statistics'
    ],

    'ox.zoneHourlyStatistics' => [
        'function' => [$fc, 'zoneHourlyStatistics'],
        'signature' => [
            ['array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601', 'boolean'],
            ['array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601'],
            ['array', 'string', 'int', 'dateTime.iso8601'],
            ['array', 'string', 'int']
        ],
        'docstring' => 'Generate Zone Hourly Statistics'
    ],

    'ox.zoneAdvertiserStatistics' => [
        'function' => [$fc, 'zoneAdvertiserStatistics'],
        'signature' => [
            ['array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601', 'boolean'],
            ['array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601'],
            ['array', 'string', 'int', 'dateTime.iso8601'],
            ['array', 'string', 'int']
        ],
        'docstring' => 'Generate Zone Advertiser Statistics'
    ],

    'ox.zoneCampaignStatistics' => [
        'function' => [$fc, 'zoneCampaignStatistics'],
        'signature' => [
            ['array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601', 'boolean'],
            ['array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601'],
            ['array', 'string', 'int', 'dateTime.iso8601'],
            ['array', 'string', 'int']
        ],
        'docstring' => 'Generate Zone Campaign Statistics'
    ],

    'ox.zoneBannerStatistics' => [
        'function' => [$fc, 'zoneBannerStatistics'],
        'signature' => [
            ['array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601', 'boolean'],
            ['array', 'string', 'int', 'dateTime.iso8601', 'dateTime.iso8601'],
            ['array', 'string', 'int', 'dateTime.iso8601'],
            ['array', 'string', 'int']
        ],
        'docstring' => 'Generate Zone Banner Statistics'
    ],

    'ox.getZone' => [
        'function' => [$fc, 'getZone'],
        'signature' => [
            ['struct', 'string', 'int']
        ],
        'docstring' => 'Get Zone Information'
    ],

    'ox.getZoneListByPublisherId' => [
        'function' => [$fc, 'getZoneListByPublisherId'],
        'signature' => [
            ['array', 'string', 'int']
        ],
        'docstring' => 'Get Zone List By Publisher Id'
    ],

    'ox.linkBanner' => [
        'function' => [$fc, 'linkBanner'],
        'signature' => [
            ['int', 'string', 'int', 'int']
        ],
        'docstring' => 'Link a banner to a zone'
    ],

    'ox.linkCampaign' => [
        'function' => [$fc, 'linkCampaign'],
        'signature' => [
            ['int', 'string', 'int', 'int']
        ],
        'docstring' => 'Link a campaign to a zone'
    ],

    'ox.unlinkBanner' => [
        'function' => [$fc, 'unlinkBanner'],
        'signature' => [
            ['int', 'string', 'int', 'int']
        ],
        'docstring' => 'Unlink a banner to from zone'
    ],

    'ox.unlinkCampaign' => [
        'function' => [$fc, 'unlinkCampaign'],
        'signature' => [
            ['int', 'string', 'int', 'int']
        ],
        'docstring' => 'Unlink a campaign from a zone'
    ],

    'ox.generateTags' => [
        'function' => [$fc, 'generateTags'],
        'signature' => [
            ['string', 'string', 'int', 'string', 'struct'],
            ['string', 'string', 'int', 'string', 'array']
        ],
        'docstring' => 'Generate zone invocation code'
    ],

];


// Merge the plugins' dispatch maps with core.
// Function names should be namespaced.
$aComponents = OX_Component::getComponents('api');
$aMaps = OX_Component::callOnComponents($aComponents, 'getDispatchMap');
foreach ($aMaps as $map) {
    $dispatches = array_merge($dispatches, $map);
}

$server = new XML_RPC_Server($dispatches, 1);
