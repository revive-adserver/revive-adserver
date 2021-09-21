<?php

/**
 * Imported from OX_Common_Csv
 * A simple utility for formatting a single line of CSV output.
 */
class OX_Vast_Common_Csv
{
    /**
     * If the UTF8 signature appears as the first 3 bytes of the file, Excel
     * will correctly decode characters into UTF-8.
     */
    public const UTF8_SIGNATURE = "\xef\xbb\xbf";
    
    /**
     * A terminating character for each CSV line.
     */
    public const LINE_TERMINATOR = "\n";
    
    /**
     * Formats a single line of CSV output. Appends a new line character at the
     * end of the line.
     *
     * @param $data data to format
     * @return formatted CSV line
     */
    public static function formatCsvLine(array $data)
    {
        $result = '';
        if (!empty($data)) {
            $result = self::escapeForCsv($data[0]);
            $size = count($data);
            for ($i = 1; $i < $size; $i++) {
                $result .= "," . self::escapeForCsv($data[$i]);
            }
        }
        return $result . self::LINE_TERMINATOR;
    }


    private static function escapeForCsv($string)
    {
        return '"' . str_replace('"', '""', $string) . '"';
    }
}
