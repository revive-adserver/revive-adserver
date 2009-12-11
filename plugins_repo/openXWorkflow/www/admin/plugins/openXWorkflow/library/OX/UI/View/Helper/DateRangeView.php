<?php

class OX_UI_View_Helper_DateRangeView extends OX_UI_View_Helper_WithViewScript
{
    public static function dateRangeView($dateRange)
    {
        return parent::renderViewScript("date-range-view.html", array (
                'dateRange' => $dateRange));
    }
}
