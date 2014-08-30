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

    require_once MAX_PATH . '/lib/pear/Date.php';

    function MAX_getDatesByPeriod($period, $period_start = 0, $period_end = 0)
    {
   		require_once MAX_PATH . '/lib/max/Admin/UI/FieldFactory.php';

		$oDaySpan =& FieldFactory::newField('day-span');
		$oDaySpan->_name = 'period';
    	$oDaySpan->setValueFromArray(array('period_preset' => $period, 'period_start' => $period_start, 'period_end' => $period_end));

        $dayBegin = $oDaySpan->getStartDate();
        $dayEnd   = $oDaySpan->getEndDate();

        $aDates = array();
        $aDates['day_begin'] = is_object($dayBegin) ? $dayBegin->format('%Y-%m-%d') : '';
        $aDates['day_end']   = is_object($dayEnd)   ? $dayEnd->format('%Y-%m-%d') : '';

        return $aDates;
    }

    function MAX_getDatesByPeriodLimitStart($period, $limit, $start)
    {
        $begin = $limit + $start-1;
        $end = $start;
        switch ($period) {
            case 'daily':      $dayBegin = new Date();
                               $dayBegin->subtractSpan(new Date_Span("$begin, 0, 0, 0"));
                               $dayEnd   = new Date();
                               $dayBegin->subtractSpan(new Date_Span("$end, 0, 0, 0"));
                               break;
            case 'weekly':     $dayBegin = new Date(Date_Calc::prevDay());
                               $dayEnd   = new Date(Date_Calc::prevDay());
                               break;
            case 'monthly' :    $dayBegin = new Date();
                               $dayBegin->subtractSpan(new Date_Span('6, 0, 0, 0'));
                               $dayEnd   = new Date();
                               break;
            case 'allstats':
            default:
                               $dayBegin = null;
                               $dayEnd = null;
        }
        $aDates = array();
        $aDates['day_begin'] = is_object($dayBegin) ? $dayBegin->format('%Y-%m-%d') : '';
        $aDates['day_end']   = is_object($dayEnd)   ? $dayEnd->format('%Y-%m-%d') : '';

        return $aDates;
    }

    function MAX_sortArray(&$aArr, $column, $ascending = true)
    {
        // Store $column and $ascending for use in _sortArrayCompare()
        $GLOBALS['sortColumn']    = $column;
        $GLOBALS['sortAscending'] = $ascending;

        reset($aArr);
        $key = key($aArr);
        // If array keys are days (yyyy-mm-dd format), and the array is to be sorted by 'day',
        // use ksort to avoid comparing strings with formatted dates
        if ($column == 'day' && preg_match("/^[0-9]{4}\-[0-9]{2}\-[0-9]{2}$/", $key) == 1) {
            if ($ascending) {
                ksort($aArr);
            } else {
                krsort($aArr);
            }
        } else {
            uasort($aArr, '_sortArrayCompare');
        }
    }

    function _sortArrayCompare($a, $b)
    {
        global $sortColumn, $sortAscending;

        switch ($sortColumn) {
            case 'name' :
                $compare = strcmp(strtolower($a[$sortColumn]), strtolower($b[$sortColumn]));
                break;

            case 'ctr'  :
            case 'sum_ctr':
                if (isset($a['sum_views']) && !isset($a['views'])) {
                    $ratioA = $a['sum_views'] > 0 ? $a['sum_clicks']/$a['sum_views'] : 0;
                    $ratioB = $b['sum_views'] > 0 ? $b['sum_clicks']/$b['sum_views'] : 0;
                } else {
                    $ratioA = $a['views'] > 0 ? $a['clicks']/$a['views'] : 0;
                    $ratioB = $b['views'] > 0 ? $b['clicks']/$b['views'] : 0;
                }
                if ($ratioA == $ratioB) return 0;
                $compare = $ratioA > $ratioB ? 1 : -1;
                break;

            case 'cnvr' :
                if (isset($a['sum_conversions']) && !isset($a['clicks'])) {
                    $ratioA = $a['sum_clicks'] > 0 ? $a['sum_conversions']/$a['sum_clicks'] : 0;
                    $ratioB = $b['sum_clicks'] > 0 ? $b['sum_conversions']/$b['sum_clicks'] : 0;
                } else {
                    $ratioA = $a['clicks'] > 0 ? $a['conversions']/$a['clicks'] : 0;
                    $ratioB = $b['clicks'] > 0 ? $b['conversions']/$b['clicks'] : 0;
                }
                if ($ratioA == $ratioB) return 0;
                $compare = $ratioA > $ratioB ? 1 : -1;
                break;

            default     :
                $compare = ($a[$sortColumn] > $b[$sortColumn]) ? 1 : -1;
        }
        if (!$sortAscending) {
            $compare = -$compare;
        }

        return $compare;
    }

?>
