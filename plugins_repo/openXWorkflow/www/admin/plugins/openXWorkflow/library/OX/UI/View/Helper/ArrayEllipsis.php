<?php

/**
 * A helper for formatting possibly long arrays of strings.
 */
class OX_UI_View_Helper_ArrayEllipsis
{
    public function arrayEllipsis(array $array, $maxElements = 6, $separator = ', ', $moreSeparator = ' ')
    {
        $main = '';
        $rest = '';
        
        sort($array);
        
        $outputCount = 0;
        $arraySize = count($array);
        foreach ($array as $element) {
            if ($outputCount < $maxElements) {
                $main .= htmlspecialchars($element);
                $outputCount ++;
                if ($outputCount < $arraySize && $outputCount != $maxElements) {
                    $main .= $separator;
                }
            } else {
                $rest .= $element;
                $outputCount ++;
                if ($outputCount < $arraySize) {
                    $rest .= ', ';
                }
            }
        }
        
        $result = $main;
        if ($arraySize > $maxElements) {
            $result .= $moreSeparator . '<span title="' . htmlspecialchars($rest) . '">(and ' . ($arraySize - $maxElements) . ' more)</span>';
        }
        
        return $result;
    }
}
