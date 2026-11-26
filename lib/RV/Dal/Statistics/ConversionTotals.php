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

namespace RV\Dal\Statistics;

/**
 * SQL helpers to cap the total_basket_value and total_num_items statistics.
 *
 * Conversion variable values are supplied by the client, so their totals
 * are capped to avoid overflowing the columns and breaking maintenance.
 */
final class ConversionTotals
{
    /** Maximum value of a numeric(10,4) column */
    public const MAX_BASKET_VALUE = '999999.9999';

    /** Maximum value of a signed int column */
    public const MAX_NUM_ITEMS = '2147483647';

    /**
     * @param string      $expression The SQL expression to cap
     * @param string|null $column     The column to add the expression to, if any
     */
    public static function capBasketValueSql(string $expression, ?string $column = null): string
    {
        return self::cap($expression, self::MAX_BASKET_VALUE, $column);
    }

    /**
     * @param string      $expression The SQL expression to cap
     * @param string|null $column     The column to add the expression to, if any
     */
    public static function capNumItemsSql(string $expression, ?string $column = null): string
    {
        return self::cap($expression, self::MAX_NUM_ITEMS, $column);
    }

    private static function cap(string $expression, string $max, ?string $column): string
    {
        if (null === $column) {
            return "LEAST({$expression}, {$max})";
        }

        return "{$column} + LEAST({$expression}, {$max} - {$column})";
    }
}
