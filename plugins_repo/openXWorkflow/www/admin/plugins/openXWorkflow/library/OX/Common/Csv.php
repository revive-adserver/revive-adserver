<?php

/**
 * A simple utility for formatting a single line of CSV output.
 */
class OX_Common_Csv
{
    /**
     * A terminating character for each CSV line.
     */
    const LINE_TERMINATOR = "\n";
    
    /**
     * Formats a single line of CSV output. Appends a new line character at the 
     * end of the line.
     * 
     * @param $data data to format
     * @return formatted CSV line
     */
    public static function formatCsvLine(array $data, $separator = ',')
    {
        $result = '';
        if (!empty($data)) {
            $result = self::escapeForCsv($data[0]);
            $size = count($data);
            for ($i = 1; $i < $size; $i++) {
                $result .= $separator . self::escapeForCsv($data[$i]);
            }
        }
        return $result . self::LINE_TERMINATOR;
    }

    public static function getLocaleListSeparator()    
    {
        // We can't use Zend's list delimiter because it's not consistent with
        // Windows. Instead, we apply a simple heuristic based on the decimal separator.
        $decimalSeparator = OX_Common_Config::getDecimalSeparator();
        return ($decimalSeparator == ',' ? ';' : ',');
    }

    private static function escapeForCsv($string)
    {
        return '"' . str_replace('"', '""', $string) . '"';
    }
}
