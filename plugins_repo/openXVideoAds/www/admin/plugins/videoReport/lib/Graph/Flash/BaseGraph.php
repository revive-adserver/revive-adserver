<?php
include_once 'lib/ofc2/open-flash-chart.php';


class Graph_Flash_BaseGraph
{
    /**
     * OpenFlashChart object
     *
     * @var open_flash_chart
     */
    protected $oChart;
    
    
    function __construct()
    {
        $this->setUpGraph();
    }
    
    public function getJSON()
    {
        if($this->oChart == false) {
            return false;
        }
        return $this->oChart->toPrettyString();
    }
        
    /**
     * 
     * @return open_flash_chart
     */
    protected function getGraph()
    {
        if(empty($this->oChart)) {
            $this->oChart = new open_flash_chart();    
        }
        
        return $this->oChart;
    }
    
    
    protected function setUpGraph()
    {
        $chart = $this->getGraph();
        $chart->set_bg_colour('#ffffff');   
    }
    
    
    public function setGraphTitle($title)
    {
        $this->oChart->set_title(new title($title));
        $this->oChart->set_tooltip($this->createTooltip());
    }
    
    /**
     * Creates new dot for line and area graph
     *
     * @return unknown
     */
    protected function createDot($color = '#f58615', $value = null)
    {
        $dot = new dot($value);
        $dot->colour($color)->size(4);
        
        return $dot;
    }
}

?>