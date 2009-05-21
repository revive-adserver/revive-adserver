<?php
include_once 'lib/ofc2/open-flash-chart.php';
include_once 'lib/Graph/Flash/BaseGraph.php';

class Graph_Flash_LineGraph
    extends Graph_Flash_BaseGraph 
{
    function __construct()
    {
        parent::__construct();
    }
    
    
    public function setXLegend()
    {
        
    }
    
    
    public function setYLegend()
    {
        
    }
    
    
    public function setXRange($min, $max)
    {
        
    }
    
    
    public function setYRange($min, $max)
    {
        
    }
    
    
    public function setXStep($step)
    {
        
    }
    

    public function setYStep($step)
    {
        
    }
    
    /**
     * Calculate Y axis step
     *
     * @param array $data array of integer values
     */
    protected function calculateYStep(array $data)
    {
        $step = (max($data) - min($data))/count($data);
        if ($step > 2) {
            $step = floor($step);
        }
        else {
            $step = ceil($step);
        }
        return $step;
    }
    
    protected function createYAxis()
    {
        $y_axis = new y_axis();
        $y_axis = $this->_configureAxis($y_axis);
        return $y_axis;
    }    
    
    protected function createXAxis()
    {
        $x_axis = new x_axis();
        $x_axis = $this->_configureAxis($x_axis);
        return $x_axis;
    }

    protected function _configureAxis($oAxis)
    {
        $oAxis->set_labels(null);
        $oAxis->set_offset(false);
        $oAxis->set_stroke(1);
        $oAxis->set_colour('#515151');
        $oAxis->set_grid_colour('#e5e0e0');
        
        return $oAxis;
    }
}

?>