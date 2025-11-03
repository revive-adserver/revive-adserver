<?php

declare(strict_types=1);

namespace RV\Admin;

class DatePickerFormatter
{
    private ?\IntlDateFormatter $formatter;

    public function __construct(?string $locale = null)
    {
        $locale ??= $GLOBALS['_MAX']['PREF']['language'] ?? 'en';

        try {
            $this->formatter = \IntlDateFormatter::create($locale, \IntlDateFormatter::LONG, \IntlDateFormatter::NONE);
        } catch (\ValueError) {
            $formatter = null;
        }
    }

    public function format(?\Date $oDate): string
    {
        if (!$oDate instanceof \Date) {
            return '';
        }

        return $this->formatter?->format(new \DateTime($oDate->format('%Y-%m-%d'))) ??
            $oDate->format('%d %B %Y');
    }
}
