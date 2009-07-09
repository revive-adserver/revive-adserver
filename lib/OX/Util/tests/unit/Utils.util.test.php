<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2009 OpenX Limited                                     |
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
$Id$
*/

require_once(MAX_PATH . '/lib/OX/Util/Utils.php');
require_once MAX_PATH . '/lib/pear/Date.php';

class OX_Util_UtilsTest
    extends UnitTestCase
{
    function testGetCampaignType()
    {
        $aTestValues = array(
            -2 => OX_CAMPAIGN_TYPE_ECPM,
            -1 => OX_CAMPAIGN_TYPE_CONTRACT_EXCLUSIVE,
            0 => OX_CAMPAIGN_TYPE_REMNANT
        );
        for ($i = 1; $i <= 10; $i++) {
            $aTestValues[$i] = OX_CAMPAIGN_TYPE_CONTRACT_NORMAL;
        }

        foreach ($aTestValues as $priority => $expectedResult) {
            $result = OX_Util_Utils::getCampaignType($priority);
            $this->assertEqual($expectedResult, $result);
        }
    }


    function testGetCampaignTranslationKey()
    {
        $aTestValues = array(-1 => 'strExclusiveContract', 0 => 'strRemnant');
        for ($i = 1; $i <= 10; $i++) {
            $aTestValues[$i] = 'strStandardContract';
        }

        foreach ($aTestValues as $priority => $expectedResult) {
            $result = OX_Util_Utils::getCampaignTypeTranslationKey($priority);
            $this->assertEqual($expectedResult, $result);
        }
    }

    function testGetEcpm()
    {
        $revenue = 10;
        $clicks = 10;
        $conversions = 5;

        // Test each type with 0 impressions.
        $impressions = 0;

        // CPM
        $expected = 10;
        $result = OX_Util_Utils::getEcpm(MAX_FINANCE_CPM, $revenue, $impressions);
        $this->assertEqual($expected, $result);

        // CPC
        // eCPM = default click ratio * revenue * 1000
        $defaultClickRatio = null;
        $expected = 50;
        $result = OX_Util_Utils::getEcpm(MAX_FINANCE_CPC, $revenue, $impressions,
            $clicks, $conversions, null, null, $defaultClickRatio);
        $this->assertEqual($expected, $result);

        $defaultClickRatio = 0.05;
        $expected = 500;
        $result = OX_Util_Utils::getEcpm(MAX_FINANCE_CPC, $revenue, $impressions,
            $clicks, $conversions, null, null, $defaultClickRatio);
        $this->assertEqual($expected, $result);

        // CPA
        // eCPM = default conversion ratio * revenue * 1000
        $defaultConversionRatio = null;
        $expected = 1;
        $result = OX_Util_Utils::getEcpm(MAX_FINANCE_CPA, $revenue, $impressions,
            $clicks, $conversions, null, null, $defaultClickRatio, $defaultConversionRatio);
        $this->assertEqual($expected, $result);

        $defaultConversionRatio = 0.01;
        $expected = 100;
        $result = OX_Util_Utils::getEcpm(MAX_FINANCE_CPA, $revenue, $impressions,
            $clicks, $conversions, null, null, $defaultClickRatio, $defaultConversionRatio);
        $this->assertEqual($expected, $result);

        // Tenancy
        // eCPM = 0.
        $expected = 0;
        $result = OX_Util_Utils::getEcpm(MAX_FINANCE_MT, $revenue, $impressions,
            $clicks, $conversions, '2009-01-01', '2009-01-14', $defaultClickRatio, $defaultConversionRatio);
        $this->assertEqual($expected, $result);

        // Test each type with some impressions
        $impressions = 100000;

        // CPM
        // eCPM = CPM
        $expected = 10;
        $result = OX_Util_Utils::getEcpm(MAX_FINANCE_CPM, $revenue, $impressions);
        $this->assertEqual($expected, $result);

        // CPC
        // eCPM = revenue * clicks / impressions * 1000
        $expected = 1;
        $result = OX_Util_Utils::getEcpm(MAX_FINANCE_CPC, $revenue, $impressions, $clicks);
        $this->assertEqual($expected, $result);

        // CPA
        // eCPM = revenue * conversions / impressions * 1000
        $expected = 0.5;
        $result = OX_Util_Utils::getEcpm(MAX_FINANCE_CPA, $revenue, $impressions, $clicks, $conversions);
        $this->assertEqual($expected, $result);

        // Tenancy
        // eCPM = (revenue / totalDaysInCampaign) * daysInCampaignSoFar / impressions * 1000
        $now = new Date();
        $startDate = new Date($now);
        $endDate = new Date($now);
        $endDate->addSeconds(60 * 60 * 24 * 10); // 10 days in the future.

        $span = new Date_Span();
        $span->setFromDateDiff($startDate, $endDate);
        $this->assertEqual(10, $span->toDays());

        // Total revenue for tenancy.
        $revenue = 10000;

        $revenuePerDay = $revenue / $span->toDays();
        $this->assertEqual(1000, $revenuePerDay);

        // Beginning of campaign (no imps served)
        $impressions = 0;
        $expected = 0;
        $result = OX_Util_Utils::getEcpm(MAX_FINANCE_MT, $revenue, $impressions,
            $clicks, $conversions, $startDate->getDate(DATE_FORMAT_ISO), $endDate->getDate(DATE_FORMAT_ISO));
        $this->assertEqual($expected, $result);

        // Half way through campaign (40,000 imps served)
        $impressions = 40000;
        $startDate->subtractSeconds(60 * 60 * 24 * 5); // We are 5 days into the campaign.
        $endDate->subtractSeconds(60 * 60 * 24 * 5);
        $span->setFromDateDiff($startDate, $now);
        $this->assertEqual(5, $span->toDays());
        $span->setFromDateDiff($endDate, $now);
        $this->assertEqual(5, $span->toDays());

        // eCPM = (revenue / totalDaysInCampaign) * daysInCampaignSoFar / impressions * 1000
        $expected = 125;
        $result = OX_Util_Utils::getEcpm(MAX_FINANCE_MT, $revenue, $impressions, $clicks, $conversions,
            $startDate->getDate(DATE_FORMAT_ISO), $endDate->getDate(DATE_FORMAT_ISO));
        $this->assertEqual($expected, $result);

        // End of campaign (70,000 imps served)
        $impressions = 70000;
        $startDate->subtractSeconds(60 * 60 * 24 * 5); // We are 10 days into the campaign.
        $endDate->subtractSeconds(60 * 60 * 24 * 5);
        $span->setFromDateDiff($startDate, $now);
        $this->assertEqual(10, $span->toDays());

        $expected = 142.857142857;
        $result = OX_Util_Utils::getEcpm(MAX_FINANCE_MT, $revenue, $impressions, $clicks, $conversions,
            $startDate->getDate(DATE_FORMAT_ISO), $endDate->getDate(DATE_FORMAT_ISO));

        // Is this the correct margin?
        $this->assertWithinMargin($expected, $result, 0.0001, "Outside of margin");

        // No dates given
        $expected = 0;
        $result = OX_Util_Utils::getEcpm(MAX_FINANCE_MT, $revenue, $impressions, $clicks, $conversions,
            null, null);
        $this->assertEqual($expected, $result);

    }

}
?>