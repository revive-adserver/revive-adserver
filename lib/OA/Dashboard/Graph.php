<?php

/*
+---------------------------------------------------------------------------+
| Openads v${RELEASE_MAJOR_MINOR}                                                              |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2007 Openads Limited                                   |
| For contact details, see: http://www.openads.org/                         |
|                                                                           |
| This program is free software; you can redistribute it and/or modify      |
| it under the terms of the GNU General Public License as published by      |
| the Free Software Foundation; either version 2 of the License, or         |
| (at your option) any later version.                                       |
|                                                                           |
| This program is distributed in the hope that it will be useful,           |
| but WITHOUT ANY WARRANTY; without even the implied warranty of            |
| MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             |
| GNU General Public License for more details.                              |
|                                                                           |
| You should have received a copy of the GNU General Public License         |
| along with this program; if not, write to the Free Software               |
| Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA |
+---------------------------------------------------------------------------+
$Id$
*/

require_once MAX_PATH . '/lib/OA/Dashboard/Widget.php';
require_once MAX_PATH . '/lib/OA/Admin/Template.php';
require_once('Image/Graph.php');

/**
 * A dashboard widget to diplay an RSS feed
 *
 */
class OA_Dashboard_Widget_Graph extends OA_Dashboard_Widget
{
    var $title;
    var $aData;
    var $draw;

    /**
     * @var OA_Admin_Template
     */
    var $oTpl;

    /**
     * The class constructor
     *
     * @param array $aParams The parameters array, usually $_REQUEST
     * @param string $title
     * @return OA_Dashboard_Widget_Feed
     */
    function OA_Dashboard_Widget_Graph($aParams, $title)
    {
        parent::OA_Dashboard_Widget($aParams);

        $this->title = $title;
        $this->draw = !empty($aParams['draw']);

        $this->setDummyData();

        $this->oTpl = new OA_Admin_Template($this->draw ? 'passthrough.html' : 'dashboard-graph.html');
        $this->oTpl->setCacheId($title);

        $this->oTpl->assign('extensionLoaded', extension_loaded('gd'));
    }

    function isDataRequired()
    {
        return !$this->oTpl->is_cached() && !empty($_REQUEST);
    }

    /**
     * A method to set the graph data.
     *
     * @param array $aData An array with two members for impressions and clicks:
     *
     * Array
     * (
     *      [0] => Array
     *          (
     *              [09-01] => 1000
     *              [09-02] => 1000
     *              [09-03] => 1000
     *              [09-04] => 1000
     *              [09-05] => 1000
     *              [09-06] => 1000
     *              [09-07] => 1000
     *          )
     *
     *      [1] => Array
     *          (
     *              [09-01] => 10
     *              [09-02] => 10
     *              [09-03] => 10
     *              [09-04] => 10
     *              [09-05] => 10
     *              [09-06] => 10
     *              [09-07] => 10
     *          )
     *
     * )
     */
    function setData($aData)
    {
        if (isset($aData[0]) && is_array($aData[0]) && isset($aData[1]) && is_array($aData[1])) {
            for ($i = 0; $i < 2; $i++) {
                foreach ($aData[$i] as $k => $v) {
                    $this->aData[$i][$k] = $v;
                }
            }
        }
    }

    /**
     * A method to use zeroed data to draw an empty graph
     *
     */
    function setDummyData()
    {
        $this->aData = array();
        for ($i = 0; $i < 7; $i++) {
            $day = date('D', time() - 86400 * (7 - $i));
            $this->aData[0][$day] = 0;
            $this->aData[1][$day] = 0;
        }
    }

    /**
     * A method to launch and display the widget
     */
    function display()
    {
        if ($this->draw) {
    		$Canvas =& Image_Canvas::factory('png',
    			array(
    				'width'		=> 239,
    				'height'	=> 132,
    				'antialias'	=> 'native'
    			)
    		);

     		$Graph =& Image_Graph::factory('graph', $Canvas);

    		$Font =& $Graph->addNew('ttf_font', MAX_PATH.'/lib/fonts/Bitstream/Vera.ttf');
    		$Font->setSize(7);

    		$Graph->setFont($Font);

            $Datasets = array(
                Image_Graph::factory('dataset'),
                Image_Graph::factory('dataset'),
            );

            $Datasets[0]->setName('Impressions');
            $Datasets[1]->setName('Clicks');

            foreach ($this->aData[0] as $k => $v) {
                $Datasets[0]->addPoint($k, $v);
            }

            $scaleY2 = 1.75;
            $factor = max($this->aData[0]) / max($this->aData[1]) / $scaleY2;

            foreach ($this->aData[1] as $k => $v) {
                $Datasets[1]->addPoint($k, $v * $factor);
            }

    /*
    		$FontT =& $Graph->addNew('ttf_font', MAX_PATH.'/lib/fonts/Bitstream/VeraBd.ttf');
    		$FontT->setSize(11);

            $Graph->add(
    			Image_Graph::vertical(
    				Image_Graph::factory('title', array($this->title, $FontT)),
    				Image_Graph::vertical(
    					$Plotarea = Image_Graph::factory('plotarea'),
    					$Legend = Image_Graph::factory('legend'),
    					85
    				),
    				5
    			)
    		);

    		$Legend->setPlotarea($Plotarea);
    */

            $Graph->add($Plotarea = Image_Graph::factory('plotarea'));

            $FillBG =& Image_Graph::factory('Image_Graph_Fill_Image', MAX_PATH . '/www/admin/images/dashboard-graph-bg.gif');
            $Graph->setBackground($FillBG);


    		$Grid =& $Plotarea->addNew('line_grid', IMAGE_GRAPH_AXIS_Y);
    		$Grid->setLineColor('#cccccc');

    		$Plot =& $Plotarea->addNew('bar', array($Datasets));
    		$Plot->setLineColor('black@0.2');

    		$FillArray =& Image_Graph::factory('Fill_Array');

//    		$FillArray->addColor('#0066ff@0.5');
//    		$FillArray->addColor('#66ccff@0.5');

            $FillArray->add(Image_Graph::factory('Fill_Gradient', array(IMAGE_GRAPH_GRAD_VERTICAL, '#b5da3c', '#6a9a2a')));
            $FillArray->add(Image_Graph::factory('Fill_Gradient', array(IMAGE_GRAPH_GRAD_VERTICAL, '#bb5c9e', '#8b4a9e')));

    		$Plot->setFillStyle($FillArray);

    		$AxisY2 =& $Plotarea->addNew('axis', array(IMAGE_GRAPH_AXIS_Y_SECONDARY));
    		$AxisY2->forceMaximum(max($this->aData[1]) * $scaleY2 + 1);

    		$AxisY =& $Plotarea->getAxis(IMAGE_GRAPH_AXIS_Y);

    		if (!max($this->aData[0])) {
    		    $AxisY->forceMaximum(1);
    		}

    		$func = create_function('$value', 'return OA_Dashboard_Widget_Graph::_formatY($value);');

            $AxisY->setDataPreprocessor(Image_Graph::factory('Image_Graph_DataPreprocessor_Function', $func));
            $AxisY2->setDataPreprocessor(Image_Graph::factory('Image_Graph_DataPreprocessor_Function', $func));

            ob_start();
    		$Graph->done();
    		$content = ob_get_clean();

            $this->oTpl->assign('content', $content);
        } else {
            $this->oTpl->assign('title', $this->title);
            $this->oTpl->assign('imageSrc', "dashboard.php?widget={$this->widgetName}&draw=1");
        }

        $this->oTpl->display();
    }

    /**
     * A method to format a value using metrics (k, M, B)
     *
     * @param float $value
     * @return string
     */
    function _formatY($value)
    {
        $unit = '';
        $aUnits = array('B' => 1000000000, 'M' => 1000000, 'k' => 1000);
        foreach ($aUnits as $k => $v) {
            if ($value >= $v) {
                $value = $value / $v;
                $unit  = $k;
            }
        }

        if (floor($value) != ceil($value)) {
            if ($value >= 100) {
                $digits = 0;
            } elseif ($value >= 10) {
                $digits = 1;
            } else {
                $digits = 2;
            }
        }

        return number_format($value, $digits, '.', ',').$unit;
    }
}

?>