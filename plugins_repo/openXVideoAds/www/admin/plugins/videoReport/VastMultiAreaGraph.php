<?php
include_once 'lib/ofc2/open-flash-chart.php';
include_once 'lib/Graph/Flash/AreaGraph.php';
include_once 'lib/Graph/DataSetColorsHelper.php';

class VastMultiAreaGraph extends Graph_Flash_AreaGraph
{
	function __construct($XLabelsToDataSets, $dataSetsIdToName, $isPlottingPercentage)
	{
		$this->xLabels = array_keys($XLabelsToDataSets);
		$this->dataSetsIdToName = $dataSetsIdToName;
		$this->tableXLabelToDataSets = $XLabelsToDataSets;
		$this->yUnit = '';
		if($isPlottingPercentage) { 
            $this->yUnit = "%";
        }
        $this->oChart = $this->setUpGraph();
	}
    
    private function getValuesForDataSet($id)
    {
    	$values = array();
    	foreach($this->tableXLabelToDataSets as $xLabel => $datasets) {
    		$values[] = $datasets[$id];
    	}
    	return $values;
    }
    
    private function getMaxYValue()
    {
    	$max = 0;
    	foreach($this->tableXLabelToDataSets as $xLabel => $datasets) {
    		$max = max($max, max($datasets));
    	}
        return $max;
    }
    
    private function getMinYValue()
    {
        return 0;
    }
    
    protected function setUpGraph()
    {
        parent::setUpGraph();
        $aDataSets = $this->getDataSets();
        // if no data, or only one data point, we don't display the graph
        if(count($this->xLabels) <= 1) {
			return false;
        }
        $chart = $this->getGraph();
        
        //set up the axes
        $y_axis = $this->createYAxis();
        $y_axis->set_range( max(0, $this->getMinYValue() - 1), 
            $this->getMaxYValue() + 1);
        $y_axis->set_steps(ceil($this->getMaxYValue() / 4));
        $y_axis->set_label_text("#val#".$this->yUnit);
        
        //y_axis legend
        $y_legend = new y_legend('Viewers');
        $y_legend->set_style('color: #515151; font-size: 12px;');
        $chart->set_y_legend($y_legend);
                
        $x_axis = $this->createXAxis();
    
        $x_values = $this->xLabels;
        $xSteps = 5;
        if(count($x_values) < $xSteps) {
        	$xSteps = count($x_values);
        } else {
	        // hack around the set_steps that doesn't seem to work for X axis
	        foreach($x_values as $i => &$xValue) {
	        	if( $i % $xSteps != 0 ) {
	        		$xValue = '';
	        	}
	        }
        }
        $x_axis->set_steps($xSteps);
        $x_labels = new x_axis_labels();
        $x_labels->set_labels($x_values);
        // Add the X Axis Labels to the X Axis
        $x_axis->set_labels( $x_labels );
        
        
        $chart->add_y_axis( $y_axis );
        
        $chart->x_axis = $x_axis;
        
        $oColorHelper = new Graph_DataSetColorsHelper();
        foreach ($aDataSets as $aDataSet) {
            $values = $aDataSet['values'];
            $name = $aDataSet['name'];

            $aColors = $oColorHelper->getNextColors();
            
            $dotValues = $this->buildDotValues($aColors['line'], $values, $name);
            $area = $this->createArea($aColors['line'], $aColors['fill']);
            $area->set_fill_alpha("0.1");
            $area->set_values($dotValues);
            $area->set_text($name);
            
            // add the area object to the chart:
            $chart->add_element($area);
        }
        
        return $chart;
    }
    
    
    private function getDataSets()
    {
        $aSets = array();
        foreach ($this->dataSetsIdToName as $id => $name) {
            $aSet['name'] = $name;
            $aSet['values'] = $this->getValuesForDataSet($id);
            $aSets[] = $aSet;
        }
        return $aSets;
    }
    
    protected function buildDotValues($dotColor, array $values, $name)
    {
        $dotValues = array();
        $max = max($values);
        foreach($values as $i => $value) {
            $dot = $this->createDot($dotColor, (string)$value);
            $xLabel = $this->xLabels[$i];
            $dot->tooltip("$name <br>$xLabel<br>Viewers: #val#".$this->yUnit);
            $dotValues[] = $dot;
        }
        return $dotValues;
    }
    
}

