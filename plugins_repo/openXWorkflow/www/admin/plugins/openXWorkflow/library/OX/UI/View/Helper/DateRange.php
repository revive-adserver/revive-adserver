<?php

/**
 * Displays the range of dates covered by an OX_Common_DateRange.
 */
class OX_UI_View_Helper_DateRange
{
    public static function dateRange($dateRangeOrId, $useNames = true, 
            $separator = ' - ')
    {
        if ($dateRangeOrId instanceof OX_Common_DateRange) {
            $dateRange = $dateRangeOrId;
        }
        else {
            $dateRange = new OX_Common_DateRange();
            $dateRange->setRange($dateRangeOrId);
        }
        
        if ($useNames && $dateRange->getRangeId()) {
            return $dateRange->getName();
        }
        else {
            $startDate = $dateRange->getStartDate();
            $endDate = $dateRange->getEndDate();
            
            $result = '';
            if ($startDate) 
            {
                $result .= OX_UI_View_Helper_DateFormat::dateFormat($startDate);
            }
            if ($startDate && $endDate && $startDate != $endDate) 
            {
                $result .= $separator;
            }
            if ($endDate && $startDate != $endDate) 
            {
                $result .= OX_UI_View_Helper_DateFormat::dateFormat($endDate);
            }
            return $result;
        }
    }
}
