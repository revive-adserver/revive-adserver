<?php

/*
+---------------------------------------------------------------------------+
| Revive Adserver                                                           |
| http://www.revive-adserver.com                                            |
|                                                                           |
| Copyright: See the COPYRIGHT.txt file.                                    |
| License: GPLv2 or later, see the LICENSE.txt file.                        |
+---------------------------------------------------------------------------+
*/

require_once MAX_PATH . '/lib/OA/Dashboard/Widget.php';
require_once MAX_PATH . '/lib/OA/Admin/Template.php';
require_once MAX_PATH . '/lib/OX/Translation.php';
require_once('Image/Graph.php');

class OA_Dashboard_Widget_Graph extends OA_Dashboard_Widget
{
    public $aData;
    public $draw;

    /**
     * @var OA_Admin_Template
     */
    public $oTpl;

    public $oTrans;

    /**
     * The class constructor
     *
     * @param array $aParams The parameters array, usually $_REQUEST
     */
    public function __construct($aParams)
    {
        parent::__construct($aParams);

        $this->oTrans = new OX_Translation();

        $gdAvailable = extension_loaded('gd');

        $this->draw = $gdAvailable && !empty($aParams['draw']);

        $this->setDummyData();

        $this->oTpl = new OA_Admin_Template($this->draw ? 'passthrough.html' : 'dashboard/graph.html');
        $this->oTpl->setCacheId($this->getCacheId());

        $this->oTpl->assign('extensionLoaded', $gdAvailable);
    }

    public function getCacheId()
    {
        // Cache the graphs for each locale.
        return [OX_getHostName(), get_class($this), $GLOBALS['_MAX']['PREF']['language']];
    }

    public function isDataRequired()
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
    public function setData($aData)
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
    public function setDummyData()
    {
        $this->aData = [];
        for ($i = 0; $i < 7; $i++) {
            $day = $this->oTrans->translate(date('D', time() - 86400 * (7 - $i)));
            $this->aData[0][$day] = 0;
            $this->aData[1][$day] = 0;
        }
    }

    /**
     * A method to launch and display the widget
     */
    public function display($aParams = [])
    {
        if ($this->draw) {
            $useAntialias = is_callable('imageantialias');

            $Canvas = Image_Canvas::factory(
                'png',
                [
                    'width' => 239,
                    'height' => 132,
                    'antialias' => $useAntialias ? 'native' : false
                ]
            );

            $Graph = Image_Graph::factory('graph', $Canvas);

            if (is_callable('imagettftext')) {
                $Font = $Graph->addNew('ttf_font', MAX_PATH . '/lib/fonts/Bitstream/Vera.ttf');
                $Font->setSize(7);

                $Graph->setFont($Font);
            } else {
                // TTF library not available, use standard bitmap font
                $Graph->setFontSize(7);
            }

            $Datasets = [
                Image_Graph::factory('dataset'),
                Image_Graph::factory('dataset'),
            ];

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

            $Plotarea = Image_Graph::factory('plotarea');
            $Graph->add($Plotarea);

            $PlotBg = Image_Graph::factory('Fill_Array');
            $PlotBg->addColor('white');

            $PlotFg = Image_Graph::factory('Line_Array');
            $PlotFg->addColor('white');

            $Plotarea->setBackground($PlotBg);
            $Plotarea->setBorderColor('white');

            $Grid = $Plotarea->addNew('line_grid', IMAGE_GRAPH_AXIS_Y);
            $Grid->setLineColor('#cccccc');

            $Plot = $Plotarea->addNew('bar', [$Datasets]);
            $Plot->setLineColor('black@0.2');

            $FillArray = Image_Graph::factory('Fill_Array');

            $FillArray->add(Image_Graph::factory('Fill_Gradient', [IMAGE_GRAPH_GRAD_VERTICAL, '#b5da3c', '#6a9a2a']));
            $FillArray->add(Image_Graph::factory('Fill_Gradient', [IMAGE_GRAPH_GRAD_VERTICAL, '#bb5c9e', '#8b4a9e']));

            $Plot->setFillStyle($FillArray);

            $AxisY2 = $Plotarea->addNew('axis', [IMAGE_GRAPH_AXIS_Y_SECONDARY]);
            $AxisY2->forceMaximum(max($this->aData[1]) * $scaleY2 + 1);

            $AxisY = $Plotarea->getAxis(IMAGE_GRAPH_AXIS_Y);

            if (!max($this->aData[0])) {
                $AxisY->forceMaximum(1);
            }

            $func = function ($value) {
                return OA_Dashboard_Widget_Graph::_formatY($value);
            };

            $AxisY->setDataPreprocessor(Image_Graph::factory('Image_Graph_DataPreprocessor_Function', $func));
            $AxisY2->setDataPreprocessor(Image_Graph::factory('Image_Graph_DataPreprocessor_Function', $func));

            ob_start();
            $Graph->done();
            $content = ob_get_clean();

            $this->oTpl->assign('content', $content);
        } else {
            $this->oTpl->assign('imageSrc', "dashboard.php?widget={$this->widgetName}&draw=1&cb=" . $this->oTpl->cacheId);
        }

        $this->oTpl->display();
    }

    /**
     * A method to format a value using metrics (k, M, B)
     *
     * @param float $value
     * @return string
     */
    public static function _formatY($value)
    {
        $oTrans = new OX_Translation();
        $unit = '';
        $aUnits = ['B' => 1000000000, 'M' => 1000000, 'k' => 1000];
        foreach ($aUnits as $k => $v) {
            if ($value >= $v) {
                $value = $value / $v;
                $unit = $oTrans->translate($k);
            }
        }

        // Floats could be imprecise, round to 2 decimal before using ceil/floor, otherwise
        // e.g. floor($value) could return 99 even if $value seems to be 100
        $value = round($value, 2);

        $digits = 0;

        if (floor($value) != ceil($value)) {
            if ($value >= 10) {
                $digits = 1;
            } else {
                $digits = 2;
            }
        }

        return number_format($value, $digits, '.', ',') . $unit;
    }
}
