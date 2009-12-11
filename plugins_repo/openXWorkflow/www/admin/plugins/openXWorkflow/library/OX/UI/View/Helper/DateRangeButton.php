<?php

class OX_UI_View_Helper_DateRangeButton extends OX_UI_View_Helper_WithViewScript
{
    public static function dateRangeButton($dateRange)
    {
        return parent::renderViewScript("date-range-button.html", array (
                'dateRange' => $dateRange));
    }
}
