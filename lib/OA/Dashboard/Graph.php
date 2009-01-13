<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2009 OpenX Limited                                     |
| For contact details, see: http://www.openx.org/                           |
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
require_once MAX_PATH . '/lib/OX/Translation.php';
require_once('Image/Graph.php');

class OA_Dashboard_Widget_Graph extends OA_Dashboard_Widget
{
    var $aData;
    var $draw;

    /**
     * @var OA_Admin_Template
     */
    var $oTpl;
    
    var $oTrans;

    /**
     * The class constructor
     *
     * @param array $aParams The parameters array, usually $_REQUEST
     * @return OA_Dashboard_Widget_Feed
     */
    function OA_Dashboard_Widget_Graph($aParams)
    {
        parent::OA_Dashboard_Widget($aParams);
        
        $this->oTrans = new OX_Translation();

        $gdAvailable = extension_loaded('gd');

        $this->draw = $gdAvailable && !empty($aParams['draw']);

        $this->setDummyData();

        $this->oTpl = new OA_Admin_Template($this->draw ? 'passthrough.html' : 'dashboard/graph.html');
        $this->oTpl->setCacheId($this->getCacheId());

        $this->oTpl->assign('extensionLoaded', $gdAvailable);
    }

    function getCacheId()
    {
        // Cache the graphs for each locale.
        return array(get_class($this), $GLOBALS['_MAX']['PREF']['language']);
    }

    function isDataRequired()
    {
        return $this->draw && !$this->oTpl->is_cached();
    }

    /**
     * A method to set the graph data.
     *
     * @param array $aData An array with two members for impressions and clicks:
     *
     * Array
     * (
     *      [0] => Array (imps)
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
     *      [1] => Array (clicks)
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
                    // OXC gives us the days in english, eg Mon.
                    $day = $this->oTrans->translate($k);
                    $this->aData[$i][$day] = $v;
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
            $day = $this->oTrans->translate(date('D', time() - 86400 * (7 - $i)));
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
            $useAntialias = is_callable('imageantialias');

    		$Canvas =& Image_Canvas::factory('png',
    			array(
    				'width'		=> 239,
    				'height'	=> 132,
    				'antialias'	=> $useAntialias ? 'native' : false
    			)
    		);

     		$Graph =& Image_Graph::factory('graph', $Canvas);

     		if (is_callable('imagettftext')) {
        		$Font =& $Graph->addNew('ttf_font', MAX_PATH.'/lib/fonts/Bitstream/Vera.ttf');
        		$Font->setSize(7);

        		$Graph->setFont($Font);
     		} else {
     		    // TTF library not available, use standard bitmap font
     		    $Graph->setFontSize(7);
     		}

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
            $maxImpr = max($this->aData[0]);
            $maxClick = max($this->aData[1]);
            $relation = $maxImpr / ($maxClick > 0 ? $maxClick : 1); // impressions/clicks 
            $factor = $relation / $scaleY2; //scale down to make click ~ 57% of impressions bar height
            
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

            /*$FillBG =& Image_Graph::factory('Image_Graph_Fill_Image', MAX_PATH . '/www/admin/images/dashboard-graph-bg.gif');
            $Graph->setBackground($FillBG);*/

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
            $this->oTpl->assign('imageSrc', "dashboard.php?widget={$this->widgetName}&draw=1&cb=".$this->oTpl->cacheId);
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
        $oTrans = new OX_Translation();
        $unit = '';
        $aUnits = array('B' => 1000000000, 'M' => 1000000, 'k' => 1000);
        foreach ($aUnits as $k => $v) {
            if ($value >= $v) {
                $value = $value / $v;
                $unit  = $oTrans->translate($k);
            }
        }

        // Floats could be imprecise, round to 2 decimal before using ceil/floor, otherwise
        // e.g. floor($value) could return 99 even if $value seems to be 100
        $value = round($value, 2);

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
