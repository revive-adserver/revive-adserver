<?php
include_once 'lib/ofc2/open-flash-chart.php';
include_once 'lib/Graph/Flash/LineGraph.php';

class Graph_Flash_AreaGraph
    extends Graph_Flash_LineGraph 
{
    function __construct()
    {
        parent::__construct();
    }

    
    /**
     * Creates a preconfigured area element (colors etc.)
     *
     */
    protected function createArea($color = '#f58615', $fill_color = '#fcdeba')
    {
        $dot = $this->createDot($color);
        
        $area = new area();
        // set the circle line width:
        $area->set_width(2);
        $area->set_default_dot_style($dot);
        $area->set_colour($color);
        $area->set_fill_colour($fill_color);
        $area->set_fill_alpha(0.8);
        
        
        return $area;
    }
}

?>