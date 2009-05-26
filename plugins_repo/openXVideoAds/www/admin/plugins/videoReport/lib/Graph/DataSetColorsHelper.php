<?php
class Graph_DataSetColorsHelper
{
    public static $COLOR_SERIES = array(
        //violet:
        array('line' => '#ae13da', 'fill' => '#f5d6fe'),
        //blue:
        array('line' => '#2098c8', 'fill' => '#c3e4f1'),
        //green:
        array('line' => '#349e3f', 'fill' => '#ccecc1'),
        //orange:
        array('line' => '#f58615', 'fill' => '#fddeb6'),
        //yellow:
        array('line' => '#dab413', 'fill' => '#fef2bc')
    );
    
    private $currentColorIndex;
    
    function __construct()
    {
        $this->currentColorIndex = 0;
    }
    
    
    function getNextColors()
    {
        $count = count(self::$COLOR_SERIES);
        $this->currentColorIndex = ($this->currentColorIndex + 1) % $count;

        return self::$COLOR_SERIES[$this->currentColorIndex];
    }
    
}
?>