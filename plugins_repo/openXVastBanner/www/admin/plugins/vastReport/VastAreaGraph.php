<?php
include_once 'lib/ofc2/open-flash-chart.php';
include_once 'lib/Graph/Flash/AreaGraph.php';


class VastAreaGraph extends Graph_Flash_AreaGraph
{
    function __construct($values, $labels)
    {
        parent::__construct();
        $this->values = $values;
        $this->labels = $labels;
        $this->oChart = $this->buildChart();
    }
   
    protected function buildChart()
    {
        $chart = $this->getGraph();
        
//		$title = new title('No data');
//		$title->set_style('{font-size: 25px;}');
//		$chart->set_title($title);
//		
        $area = $this->createArea();
        $dotValues = $this->buildDotValues('#f58615');
        $area->set_values($dotValues);
        // add the area object to the chart:
        $chart->add_element( $area );
        $y_axis = $this->createYAxis(); 
        $y_axis->set_range( max(0, min($this->values) - 1), max($this->values) + 1);
        $y_axis->set_steps( ceil(max($this->values) / 4));
        //y_axis legend
        $y_legend = new y_legend('Viewers');
        $y_legend->set_style('color: #515151; font-size: 12px;');
        $chart->set_y_legend($y_legend);
        $x_axis = $this->createXAxis();
        $x_axis->set_steps( 1 );
        
        $x_labels = new x_axis_labels();
        $x_labels->set_labels(array_values($this->labels));
        //$x_labels->set_steps( 1 );
        
        // Add the X Axis Labels to the X Axis
        $x_axis->set_labels( $x_labels );
        $chart->add_y_axis( $y_axis );
        $chart->x_axis = $x_axis;
        return $chart;
    }
    
    /**
     * @param array $this->values
     */
    protected function buildDotValues($dotColor)
    {
        $dotValues = array();
        $max = max($this->values);
        foreach($this->values as $eventId => $value) {
            $dot = $this->createDot($dotColor, $value);
            $drops = $max - $value;
            $dot->tooltip($this->labels[$eventId] . "<br>Viewers: #val#<br>Drop offs: ".$drops);

            $dotValues[] = $dot;
        }
        return $dotValues;
    }
}

?>