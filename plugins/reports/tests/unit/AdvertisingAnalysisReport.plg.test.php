<?php

/*
+---------------------------------------------------------------------------+
| Max Media Manager v0.3                                                    |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2006 m3 Media Services Limited                         |
| For contact details, see: http://www.m3.net/                              |
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

/**
 * ... for Max Media Manager
 *
 * @since 0.3.22 - Apr 5, 2006
 * @copyright 2006 M3 Media Services
 * @version $Id$
 */

require_once MAX_PATH . '/plugins/reports/standard/advertisingAnalysisReport.plugin.php';

class AdverisingAnalysisReportTest extends UnitTestCase
{
    function testDisplayOnlyHasRequiredColumns()
    {
        $rpt = new Plugins_Reports_Standard_AdvertisingAnalysisReport();
        $raw_campaigns = array(
            array(
                'campaign_id' => 4,
                'campaign_name' => 'A Campaign',
                'campaign_clicks' => 34,
                'campaign_impressions' => 340
            )
        );
        $displayable_campaigns = $rpt->prepareCampaignEffectivenessForDisplay($raw_campaigns);
        $displayable_campaign = $displayable_campaigns[0];
        $this->assertEqual(count($displayable_campaign), 4, 'Name, views, clicks and CTR should be the only columns shown. %s');
    }
}
?>
