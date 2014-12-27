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

// Require the initialisation file.
require_once '../../../../init.php';

// Require the XML-RPC classes.
require_once MAX_PATH . '/lib/pear/XML/RPC/Server.php';

require_once 'LogonXmlRpcService.php';
require_once 'AdvertiserXmlRpcService.php';
require_once 'AgencyXmlRpcService.php';
require_once 'BannerXmlRpcService.php';
require_once 'CampaignXmlRpcService.php';
require_once 'ChannelXmlRpcService.php';
require_once 'PublisherXmlRpcService.php';
require_once 'TrackerXmlRpcService.php';
require_once 'UserXmlRpcService.php';
require_once 'VariableXmlRpcService.php';
require_once 'ZoneXmlRpcService.php';

/**
 * A Front Controller class for the XML-RPC API.
 * This class delegates to the existing XML-RPC service classes.
 *
 * @package OpenX
 */
class XmlRpcFrontController
{
    // Logon functions
    public function logon($message)
    {
        $service = new LogonXmlRpcService();
        return $service->logon($message);
    }

    public function logoff($message)
    {
        $service = new LogonXmlRpcService();
        return $service->logoff($message);
    }

    // Advertiser functions
    public function addAdvertiser($message)
    {
        $service = new AdvertiserXmlRpcService();
        return $service->addAdvertiser($message);
    }

    public function advertiserBannerStatistics($message)
    {
        $service = new AdvertiserXmlRpcService();
        return $service->advertiserBannerStatistics($message);
    }

    public function advertiserCampaignStatistics($message)
    {
        $service = new AdvertiserXmlRpcService();
        return $service->advertiserCampaignStatistics($message);
    }

    public function advertiserDailyStatistics($message)
    {
        $service = new AdvertiserXmlRpcService();
        return $service->advertiserDailyStatistics($message);
    }

    public function advertiserPublisherStatistics($message)
    {
        $service = new AdvertiserXmlRpcService();
        return $service->advertiserPublisherStatistics($message);
    }

    public function advertiserZoneStatistics($message)
    {
        $service = new AdvertiserXmlRpcService();
        return $service->advertiserZoneStatistics($message);
    }

    public function deleteAdvertiser($message)
    {
        $service = new AdvertiserXmlRpcService();
        return $service->deleteAdvertiser($message);
    }

    public function getAdvertiser($message)
    {
        $service = new AdvertiserXmlRpcService();
        return $service->getAdvertiser($message);
    }

    public function getAdvertiserListByAgencyId($message)
    {
        $service = new AdvertiserXmlRpcService();
        return $service->getAdvertiserListByAgencyId($message);
    }

    public function modifyAdvertiser($message)
    {
        $service = new AdvertiserXmlRpcService();
        return $service->modifyAdvertiser($message);
    }

    // Agency functions
    public function addAgency($message)
    {
        $service = new AgencyXmlRpcService();
        return $service->addAgency($message);
    }

    public function agencyAdvertiserStatistics($message)
    {
        $service = new AgencyXmlRpcService();
        return $service->agencyAdvertiserStatistics($message);
    }

    public function agencyBannerStatistics($message)
    {
        $service = new AgencyXmlRpcService();
        return $service->agencyBannerStatistics($message);
    }

    public function agencyCampaignStatistics($message)
    {
        $service = new AgencyXmlRpcService();
        return $service->agencyCampaignStatistics($message);
    }

    public function agencyDailyStatistics($message)
    {
        $service = new AgencyXmlRpcService();
        return $service->agencyDailyStatistics($message);
    }

    public function agencyPublisherStatistics($message)
    {
        $service = new AgencyXmlRpcService();
        return $service->agencyPublisherStatistics($message);
    }

    public function agencyZoneStatistics($message)
    {
        $service = new AgencyXmlRpcService();
        return $service->agencyZoneStatistics($message);
    }

    public function deleteAgency($message)
    {
        $service = new AgencyXmlRpcService();
        return $service->deleteAgency($message);
    }

    public function getAgency($message)
    {
        $service = new AgencyXmlRpcService();
        return $service->getAgency($message);
    }

    public function getAgencyList($message)
    {
        $service = new AgencyXmlRpcService();
        return $service->getAgencyList($message);
    }

    public function modifyAgency($message)
    {
        $service = new AgencyXmlRpcService();
        return $service->modifyAgency($message);
    }

    // Banner functions
    public function addBanner($message)
    {
        $service = new BannerXmlRpcService();
        return $service->addBanner($message);
    }

    public function bannerDailyStatistics($message)
    {
        $service = new BannerXmlRpcService();
        return $service->bannerDailyStatistics($message);
    }

    public function bannerPublisherStatistics($message)
    {
        $service = new BannerXmlRpcService();
        return $service->bannerPublisherStatistics($message);
    }

    public function bannerZoneStatistics($message)
    {
        $service = new BannerXmlRpcService();
        return $service->bannerZoneStatistics($message);
    }

    public function deleteBanner($message)
    {
        $service = new BannerXmlRpcService();
        return $service->deleteBanner($message);
    }

    public function getBanner($message)
    {
        $service = new BannerXmlRpcService();
        return $service->getBanner($message);
    }

    public function getBannerListByCampaignId($message)
    {
        $service = new BannerXmlRpcService();
        return $service->getBannerListByCampaignId($message);
    }

    public function getBannerTargeting($message)
    {
        $service = new BannerXmlRpcService();
        return $service->getBannerTargeting($message);
    }

    public function modifyBanner($message)
    {
        $service = new BannerXmlRpcService();
        return $service->modifyBanner($message);
    }

    public function setBannerTargeting($message)
    {
        $service = new BannerXmlRpcService();
        return $service->setBannerTargeting($message);
    }

    // Campaign functions
    public function addCampaign($message)
    {
        $service = new CampaignXmlRpcService();
        return $service->addCampaign($message);
    }

    public function campaignBannerStatistics($message)
    {
        $service = new CampaignXmlRpcService();
        return $service->campaignBannerStatistics($message);
    }

    public function campaignDailyStatistics($message)
    {
        $service = new CampaignXmlRpcService();
        return $service->campaignDailyStatistics($message);
    }

    public function campaignPublisherStatistics($message)
    {
        $service = new CampaignXmlRpcService();
        return $service->campaignPublisherStatistics($message);
    }

    public function campaignZoneStatistics($message)
    {
        $service = new CampaignXmlRpcService();
        return $service->campaignZoneStatistics($message);
    }

    public function campaignConversionStatistics($message)
    {
        $service = new CampaignXmlRpcService();
        return $service->campaignConversionStatistics($message);
    }

    public function deleteCampaign($message)
    {
        $service = new CampaignXmlRpcService();
        return $service->deleteCampaign($message);
    }

    public function getCampaign($message)
    {
        $service = new CampaignXmlRpcService();
        return $service->getCampaign($message);
    }

    public function getCampaignListByAdvertiserId($message)
    {
        $service = new CampaignXmlRpcService();
        return $service->getCampaignListByAdvertiserId($message);
    }

    public function modifyCampaign($message)
    {
        $service = new CampaignXmlRpcService();
        return $service->modifyCampaign($message);
    }

    // Channel functions
    public function addChannel($message)
    {
        $service = new ChannelXmlRpcService();
        return $service->addChannel($message);
    }

    public function deleteChannel($message)
    {
        $service = new ChannelXmlRpcService();
        return $service->deleteChannel($message);
    }

    public function getChannel($message)
    {
        $service = new ChannelXmlRpcService();
        return $service->getChannel($message);
    }

    public function getChannelListByAgencyId($message)
    {
        $service = new ChannelXmlRpcService();
        return $service->getChannelListByAgencyId($message);
    }

    public function getChannelListByWebsiteId($message)
    {
        $service = new ChannelXmlRpcService();
        return $service->getChannelListByWebsiteId($message);
    }

    public function getChannelTargeting($message)
    {
        $service = new ChannelXmlRpcService();
        return $service->getChannelTargeting($message);
    }

    public function modifyChannel($message)
    {
        $service = new ChannelXmlRpcService();
        return $service->modifyChannel($message);
    }

    public function setChannelTargeting($message)
    {
        $service = new ChannelXmlRpcService();
        return $service->setChannelTargeting($message);
    }

    // Publisher functions
    public function addPublisher($message)
    {
        $service = new PublisherXmlRpcService();
        return $service->addPublisher($message);
    }

    public function deletePublisher($message)
    {
        $service = new PublisherXmlRpcService();
        return $service->deletePublisher($message);
    }

    public function getPublisher($message)
    {
        $service = new PublisherXmlRpcService();
        return $service->getPublisher($message);
    }

    public function getPublisherListByAgencyId($message)
    {
        $service = new PublisherXmlRpcService();
        return $service->getPublisherListByAgencyId($message);
    }

    public function modifyPublisher($message)
    {
        $service = new PublisherXmlRpcService();
        return $service->modifyPublisher($message);
    }

    public function publisherAdvertiserStatistics($message)
    {
        $service = new PublisherXmlRpcService();
        return $service->publisherAdvertiserStatistics($message);
    }

    public function publisherBannerStatistics($message)
    {
        $service = new PublisherXmlRpcService();
        return $service->publisherBannerStatistics($message);
    }

    public function publisherCampaignStatistics($message)
    {
        $service = new PublisherXmlRpcService();
        return $service->publisherCampaignStatistics($message);
    }

    public function publisherDailyStatistics($message)
    {
        $service = new PublisherXmlRpcService();
        return $service->publisherDailyStatistics($message);
    }

    public function publisherZoneStatistics($message)
    {
        $service = new PublisherXmlRpcService();
        return $service->publisherZoneStatistics($message);
    }

    // Tracker functions
    public function addTracker($message)
    {
        $service = new TrackerXmlRpcService();
        return $service->addTracker($message);
    }

    public function modifyTracker($message)
    {
        $service = new TrackerXmlRpcService();
        return $service->modifyTracker($message);
    }

    public function deleteTracker($message)
    {
        $service = new TrackerXmlRpcService();
        return $service->deleteTracker($message);
    }

    public function linkTrackerToCampaign($message)
    {
        $service = new TrackerXmlRpcService();
        return $service->linkTrackerToCampaign($message);
    }

    public function getTracker($message)
    {
        $service = new TrackerXmlRpcService();
        return $service->getTracker($message);
    }

    // User functions
    public function addUser($message)
    {
        $service = new UserXmlRpcService();
        return $service->addUser($message);
    }

    public function deleteUser($message)
    {
        $service = new UserXmlRpcService();
        return $service->deleteUser($message);
    }

    public function getUser($message)
    {
        $service = new UserXmlRpcService();
        return $service->getUser($message);
    }

    public function getUserList($message)
    {
        $service = new UserXmlRpcService();
        return $service->getUserList($message);
    }

    public function getUserListByAccountId($message)
    {
        $service = new UserXmlRpcService();
        return $service->getUserListByAccountId($message);
    }

    public function modifyUser($message)
    {
        $service = new UserXmlRpcService();
        return $service->modifyUser($message);
    }

    public function updateSsoUserId($message)
    {
        $service = new UserXmlRpcService();
        return $service->updateSsoUserId($message);
    }

    public function updateUserEmailBySsoId($message)
    {
        $service = new UserXmlRpcService();
        return $service->updateUserEmailBySsoId($message);
    }

    public function linkUserToAdvertiserAccount($message)
    {
        $service = new UserXmlRpcService();
        return $service->linkUserToAdvertiserAccount($message);
    }

    public function linkUserToTraffickerAccount($message)
    {
        $service = new UserXmlRpcService();
        return $service->linkUserToTraffickerAccount($message);
    }
    public function linkUserToManagerAccount($message)
    {
        $service = new UserXmlRpcService();
        return $service->linkUserToManagerAccount($message);
    }

    // Variable functions
    public function addVariable($message)
    {
        $service = new VariableXmlRpcService();
        return $service->addVariable($message);
    }

    public function modifyVariable($message)
    {
        $service = new VariableXmlRpcService();
        return $service->modifyVariable($message);
    }

    public function deleteVariable($message)
    {
        $service = new VariableXmlRpcService();
        return $service->deleteVariable($message);
    }

    public function getVariable($message)
    {
        $service = new VariableXmlRpcService();
        return $service->getVariable($message);
    }

    // Zone functions
    public function addZone($message)
    {
        $service = new ZoneXmlRpcService();
        return $service->addZone($message);

    }

    public function deleteZone($message)
    {
        $service = new ZoneXmlRpcService();
        return $service->deleteZone($message);
    }

    public function generateTags($message)
    {
        $service = new ZoneXmlRpcService();
        return $service->generateTags($message);
    }

    public function getZone($message)
    {
        $service = new ZoneXmlRpcService();
        return $service->getZone($message);
    }

    public function getZoneListByPublisherId($message)
    {
        $service = new ZoneXmlRpcService();
        return $service->getZoneListByPublisherId($message);
    }

    public function linkBanner($message)
    {
        $service = new ZoneXmlRpcService();
        return $service->linkBanner($message);
    }

    public function linkCampaign($message)
    {
        $service = new ZoneXmlRpcService();
        return $service->linkCampaign($message);
    }

    public function modifyZone($message)
    {
        $service = new ZoneXmlRpcService();
        return $service->modifyZone($message);
    }

    public function unlinkBanner($message)
    {
        $service = new ZoneXmlRpcService();
        return $service->unlinkBanner($message);
    }

    public function unlinkCampaign($message)
    {
        $service = new ZoneXmlRpcService();
        return $service->unlinkCampaign($message);
    }

    public function zoneAdvertiserStatistics($message)
    {
        $service = new ZoneXmlRpcService();
        return $service->zoneAdvertiserStatistics($message);
    }

    public function zoneBannerStatistics($message)
    {
        $service = new ZoneXmlRpcService();
        return $service->zoneBannerStatistics($message);
    }

    public function zoneCampaignStatistics($message)
    {
        $service = new ZoneXmlRpcService();
        return $service->zoneCampaignStatistics($message);
    }

    public function zoneDailyStatistics($message)
    {
        $service = new ZoneXmlRpcService();
        return $service->zoneDailyStatistics($message);
    }
}



