<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2007 Openads Ltd                                       |
| For contact details, see: http://www.openads.org/                         |
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
$Id$
*/

require_once MAX_PATH . '/lib/max/Admin/Reporting/ReportScope.php';

class ReportScopeTest extends UnitTestCase
{
    function testDefaultHasNoRestrictions()
    {
        $scope = new ReportScope();
        $this->assertTrue($scope->hasNoRestrictions());
    }

    function testUsingPublisherEntailsRestrictions()
    {
        $scope = new ReportScope();
        $scope->usePublisherId(316);
        $this->assertFalse($scope->hasNoRestrictions());
    }

    function testUsingAdvertiserEntailsRestrictions()
    {
        $scope = new ReportScope();
        $scope->useAdvertiserId(420);
        $this->assertFalse($scope->hasNoRestrictions());
    }

    function testDescriptionDefault()
    {
        $scope = new ReportScope();
        $this->assertEqual($scope->description, "all available advertisers and publishers");
    }

    function testDescriptionOnPublisher()
    {
        $scope = new ReportScope();
        $scope->usePublisherId(316);
        $this->assertEqual($scope->description, "publisher 316");
    }

    function testDescriptionOnAdvertiser()
    {
        $scope = new ReportScope();
        $scope->useAdvertiserId(420);
        $this->assertEqual($scope->description, "advertiser 420");
    }

    function testUseAdvertiserIsSane()
    {
        $scope = new ReportScope();
        $scope->useAdvertiserId(420);
        $this->assertEqual($scope->getAdvertiserId(), 420);
    }

    function testUseAgencyIsSane()
    {
        $scope = new ReportScope();
        $scope->useAgencyId(630);
        $this->assertEqual($scope->getAgencyId(), 630);
    }

    function testAdvertisersAreBlankAfterSettingPublisher()
    {
        $scope = new ReportScope();
        $scope->useAdvertiserId(420);
        $scope->usePublisherId(316);
        $this->assertFalse($scope->getAdvertiserId(), 'Using a publisher should mean that no advertisers are selected');
    }

    function testPublishersAreBlankAfterSettingAdvertiser()
    {
        $scope = new ReportScope();
        $scope->usePublisherId(316);
        $scope->useAdvertiserId(420);
        $this->assertFalse($scope->getPublisherId(), 'Using an advertiser should mean that no publishers are selected');
    }

    function testPublishersAreBlankAfterSettingAll()
    {
        $scope = new ReportScope();
        $scope->useAllAvailableData();
        $this->assertFalse($scope->getPublisherId(), 'Using all available data should mean that no publishers are selected');
    }

    function testAdvertisersAreBlankAfterSettingAll()
    {
        $scope = new ReportScope();
        $scope->useAllAvailableData();
        $this->assertFalse($scope->getAdvertiserId(), 'Using all available data should mean that no advertisers are selected');
    }

    function testAgenciesAreBlankAfterSettingAll()
    {
        $scope = new ReportScope();
        $scope->useAgencyId(630);
        $scope->useAllAvailableData();
        $this->assertFalse($scope->getAgencyId(), 'Using all available data should mean that no agencies are selected');
    }
}

?>
