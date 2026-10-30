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

require_once MAX_PATH . '/lib/max/language/Loader.php';
require_once MAX_PATH . '/lib/OA/Admin/Statistics/Delivery/CommonEntity.php';
require_once MAX_PATH . '/lib/OA/Admin/Statistics/Fields/Delivery/Default.php';

Language_Loader::load();

class OA_Admin_Statistics_Delivery_AggregationTestController extends OA_Admin_Statistics_Delivery_CommonEntity
{
    public function __construct()
    {
        // Initialize the real statistics fields without constructing the page UI.
        $plugin = new OA_StatisticsFieldsDelivery_Default();
        $this->aPlugins = [$plugin];
        $this->aEmptyRow = $plugin->getEmptyRow();
        $this->aColumns = array_fill_keys(array_keys($this->aEmptyRow), true);
        $this->aTotal = $this->aEmptyRow;
    }

    public function start() {}
}

class Test_OA_Admin_Statistics_Delivery_Aggregation extends UnitTestCase
{
    private function conversionTypes()
    {
        return [MAX_CONNECTION_AD_IMPRESSION, MAX_CONNECTION_AD_CLICK, MAX_CONNECTION_AD_ARRIVAL, MAX_CONNECTION_MANUAL];
    }

    private function row($adId, $views, $conversionsPerType)
    {
        $row = [
            'ad_id' => $adId,
            'zone_id' => 9,
            'sum_views' => $views,
            'sum_clicks' => $views / 10,
            'sum_conversions' => $conversionsPerType * 10,
        ];
        foreach ($this->conversionTypes() as $index => $type) {
            $row['sum_conversions_' . $type] = $conversionsPerType * ($index + 1);
        }
        return $row;
    }

    public function testEntityAggregationCountsEachContributionOnceAndPreservesIds()
    {
        $controller = new OA_Admin_Statistics_Delivery_AggregationTestController();
        $entities = [];
        $controller->_prepareDataAdd($entities, $this->row(7, 100, 1), 'ad_id');
        foreach ($this->conversionTypes() as $index => $type) {
            $this->assertEqual($index + 1, $entities[7]['sum_conversions_' . $type]);
        }

        $controller->_prepareDataAdd($entities, $this->row(7, 300, 2), 'ad_id');
        $controller->_prepareDataAdd($entities, $this->row(8, 50, 1), 'ad_id');

        $this->assertEqual(7, $entities[7]['ad_id']);
        $this->assertEqual(9, $entities[7]['zone_id']);
        $this->assertEqual(400, $entities[7]['sum_views']);
        $this->assertEqual(40, $entities[7]['sum_clicks']);
        $this->assertEqual(30, $entities[7]['sum_conversions']);
        foreach ($this->conversionTypes() as $index => $type) {
            $this->assertEqual(3 * ($index + 1), $entities[7]['sum_conversions_' . $type]);
        }
        $this->assertEqual(8, $entities[8]['ad_id']);
        $this->assertEqual(50, $entities[8]['sum_views']);
    }

    public function testTotalsIncludeHiddenCountersAndCalculateWeightedSuccessRates()
    {
        $controller = new OA_Admin_Statistics_Delivery_AggregationTestController();
        $rows = [
            7 => $this->row(7, 100, 1),
            8 => $this->row(8, 300, 2),
            // Entities without conversions need not contain per-action counters.
            9 => ['ad_id' => 9, 'sum_views' => 100, 'sum_clicks' => 10, 'sum_conversions' => 0],
        ];
        $controller->_summariseTotals($rows);

        $this->assertEqual(500, $controller->aTotal['sum_views']);
        $this->assertEqual(50, $controller->aTotal['sum_clicks']);
        $this->assertEqual(30, $controller->aTotal['sum_conversions']);
        foreach ($this->conversionTypes() as $index => $type) {
            $this->assertEqual(3 * ($index + 1), $controller->aTotal['sum_conversions_' . $type] ?? null);
        }
        $this->assertWithinMargin(3 / 500, $controller->aTotal['sum_sr_views'], 0.000001);
        $this->assertWithinMargin(6 / 50, $controller->aTotal['sum_sr_clicks'], 0.000001);
    }

    public function testTotalsWithoutConversionsHaveZeroSuccessRates()
    {
        $controller = new OA_Admin_Statistics_Delivery_AggregationTestController();
        $rows = [['ad_id' => 7, 'sum_views' => 100, 'sum_clicks' => 10, 'sum_conversions' => 0]];
        $controller->_summariseTotals($rows);

        $this->assertEqual(0, $controller->aTotal['sum_sr_views']);
        $this->assertEqual(0, $controller->aTotal['sum_sr_clicks']);
    }
}
