<?php

declare(strict_types=1);

namespace RV\Admin;

class DatePickerFormatter
{
    private ?\IntlDateFormatter $formatter = null;

    public function __construct(?string $locale = null)
    {
        $locale ??= $GLOBALS['_MAX']['PREF']['language'] ?? 'en';

        // Use default formater if jscalendar doesn't have the matching translation
        if (!file_exists(MAX_PATH . "/www/admin/assets/js/jscalendar/lang/calendar-{$locale}.js")) {
            return;
        }

        try {
            $this->formatter = \IntlDateFormatter::create($locale, pattern: 'dd LLLL y');
        } catch (\ValueError) {
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
