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
require_once('Image/Graph.php');

/**
 * A dashboard widget to diplay an RSS feed
 *
 */
class OA_Dashboard_Widget_Graph extends OA_Dashboard_Widget
{
    var $title;
    var $aData;

    /**
     * The class constructor
     *
     * @param string $title
     * @param string $url
     * @param int $posts
     * @return OA_Dashboard_Widget_Feed
     */
    function OA_Dashboard_Widget_Graph($title, $aData)
    {
        parent::OA_Dashboard_Widget();

        $this->title = $title;
        $this->aData = array_slice($aData, -7);
    }

    /**
     * A method to launch and display the widget
     *
     * @param array $aParams The parameters array, usually $_REQUEST
     */
    function display($aParams)
    {
		$Canvas =& Image_Canvas::factory('png',
			array(
				'width'		=> 300,
				'height'	=> 300,
				'antialias'	=> 'native'
			)
		);

 		$Graph =& Image_Graph::factory('graph', $Canvas);

		$Font =& $Graph->addNew('ttf_font', MAX_PATH.'/lib/fonts/trebuc.ttf');
		$Font->setSize(8);

		$FontT =& $Graph->addNew('ttf_font', MAX_PATH.'/lib/fonts/trebucbd.ttf');
		$FontT->setSize(11);

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

        $scaleY2 = 1.8;
        $factor = max($this->aData[0]) / max($this->aData[1]) / $scaleY2;

        foreach ($this->aData[1] as $k => $v) {
            $Datasets[1]->addPoint($k, $v * $factor);
        }

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

		$Grid =& $Plotarea->addNew('line_grid', IMAGE_GRAPH_AXIS_Y);
		$Grid->setLineColor('silver');

		$Plot =& $Plotarea->addNew('bar', array($Datasets));
		$Plot->setLineColor('black@0.5');

		$FillArray =& Image_Graph::factory('Image_Graph_Fill_Array');

		$FillArray->addColor('#0066ff@0.5');
		$FillArray->addColor('#66ccff@0.5');

		$Plot->setFillStyle($FillArray);

		$AxisY2 =& $Plotarea->addNew('axis', array(IMAGE_GRAPH_AXIS_Y_SECONDARY));
		$AxisY2->forceMaximum(max($this->aData[1]) * $scaleY2);

		$AxisY =& $Plotarea->getAxis(IMAGE_GRAPH_AXIS_Y);

		$func = create_function('$value', 'return OA_Dashboard_Widget_Graph::_formatY($value);');

        $AxisY->setDataPreprocessor(Image_Graph::factory('Image_Graph_DataPreprocessor_Function', $func));
        $AxisY2->setDataPreprocessor(Image_Graph::factory('Image_Graph_DataPreprocessor_Function', $func));

		$Graph->done();
/*
        $oTpl = new OA_Admin_Template('dashboard-graph.html');

        $oTpl->assign('title', $this->title);
        $oTpl->assign('feed', array_slice($oRss->getItems(), 0, $this->posts));

        $oTpl->display();
*/
    }

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