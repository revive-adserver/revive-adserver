<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * Class for axis handling.
 *
 * PHP versions 4 and 5
 *
 * LICENSE: This library is free software; you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation; either version 2.1 of the License, or (at your
 * option) any later version. This library is distributed in the hope that it
 * will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty
 * of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Lesser
 * General Public License for more details. You should have received a copy of
 * the GNU Lesser General Public License along with this library; if not, write
 * to the Free Software Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA
 * 02111-1307 USA
 *
 * @category   Images
 * @package    Image_Graph
 * @subpackage Axis
 * @author     Jesper Veggerby <pear.nosey@veggerby.dk>
 * @copyright  Copyright (C) 2003, 2004 Jesper Veggerby Hansen
 * @license    http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version    CVS: $Id: Category.php,v 1.19 2006/03/02 12:15:17 nosey Exp $
 * @link       http://pear.php.net/package/Image_Graph
 */
 
/**
 * Include file Image/Graph/Axis.php
 */
require_once 'Image/Graph/Axis.php';

/**
 * A normal axis thats displays labels with a 'interval' of 1.
 * This is basically a normal axis where the range is
 * the number of labels defined, that is the range is explicitly defined
 * when constructing the axis.
 *
 * @category   Images
 * @package    Image_Graph
 * @subpackage Axis
 * @author     Jesper Veggerby <pear.nosey@veggerby.dk>
 * @copyright  Copyright (C) 2003, 2004 Jesper Veggerby Hansen
 * @license    http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version    Release: 0.7.2
 * @link       http://pear.php.net/package/Image_Graph
 */
class Image_Graph_Axis_Category extends Image_Graph_Axis
{

    /**
     * The labels shown on the axis
     * @var array
     * @access private
     */
    var $_labels = false;

    /**
     * Image_Graph_Axis_Category [Constructor].
     *
     * @param int $type The type (direction) of the Axis
     */
    function Image_Graph_Axis_Category($type = IMAGE_GRAPH_AXIS_X)
    {
        parent::Image_Graph_Axis($type);
        $this->_labels = array();
        $this->setlabelInterval(1);
    }

    /**
     * Gets the minimum value the axis will show.
     *
     * This is always 0
     *
     * @return double The minumum value
     * @access private
     */
    function _getMinimum()
    {
        return 0;
    }

    /**
     * Gets the maximum value the axis will show.
     *
     * This is always the number of labels passed to the constructor.
     *
     * @return double The maximum value
     * @access private
     */
    function _getMaximum()
    {
        return count($this->_labels) - 1;
    }

    /**
     * Sets the minimum value the axis will show.
     *
     * A minimum cannot be set on a SequentialAxis, it is always 0.
     *
     * @param double Minimum The minumum value to use on the axis
     * @access private
     */
    function _setMinimum($minimum)
    {
    }

    /**
     * Sets the maximum value the axis will show
     *
     * A maximum cannot be set on a SequentialAxis, it is always the number
     * of labels passed to the constructor.
     *
     * @param double Maximum The maximum value to use on the axis
     * @access private
     */
    function _setMaximum($maximum)
    {
    }

    /**
     * Forces the minimum value of the axis
     *
     * <b>A minimum cannot be set on this type of axis</b>
     * 
     * To modify the labels which are displayed on the axis, instead use 
     * setLabelInterval($labels) where $labels is an array containing the 
     * values/labels the axis should display. <b>Note!</b> Only values in
     * this array will then be displayed on the graph!
     *
     * @param double $minimum A minimum cannot be set on this type of axis
     */
    function forceMinimum($minimum, $userEnforce = true)
    {
    }

    /**
     * Forces the maximum value of the axis
     *
     * <b>A maximum cannot be set on this type of axis</b>
     * 
     * To modify the labels which are displayed on the axis, instead use 
     * setLabelInterval($labels) where $labels is an array containing the 
     * values/labels the axis should display. <b>Note!</b> Only values in
     * this array will then be displayed on the graph!
     *
     * @param double $maximum A maximum cannot be set on this type of axis
     */
    function forceMaximum($maximum, $userEnforce = true)
    {
    }

    /**
     * Sets an interval for where labels are shown on the axis.
     *
     * The label interval is rounded to nearest integer value.
     *
     * @param double $labelInterval The interval with which labels are shown
     */
    function setLabelInterval($labelInterval = 'auto', $level = 1)
    {
        if (is_array($labelInterval)) {
            parent::setLabelInterval($labelInterval);
        } elseif ($labelInterval == 'auto') {
            parent::setLabelInterval(1);
        } else {
            parent::setLabelInterval(round($labelInterval));
        }
    }

    /**
     * Preprocessor for values, ie for using logarithmic axis
     *
     * @param double $value The value to preprocess
     * @return double The preprocessed value
     * @access private
     */
    function _value($value)
    {
//        $the_value = array_search($value, $this->_labels);
		if (isset($this->_labels[$value])) {
	        $the_value = $this->_labels[$value];
	        if ($the_value !== false) {
	            return $the_value + ($this->_pushValues ? 0.5 : 0);
	        } else {
	            return 0;
	        }
		}
    }


    /**
     * Get the minor label interval with which axis label ticks are drawn.
     *
     * For a sequential axis this is always disabled (i.e false)
     *
     * @return double The minor label interval, always false
     * @access private
     */
    function _minorLabelInterval()
    {
        return false;
    }

    /**
     * Get the size in pixels of the axis.
     *
     * For an x-axis this is the width of the axis including labels, and for an
     * y-axis it is the corrresponding height
     *
     * @return int The size of the axis
     * @access private
     */
     function _size()
     {
        if (!$this->_visible) {
            return 0;
        }
        
        $this->_canvas->setFont($this->_getFont());

        $maxSize = 0;
        foreach($this->_labels as $label => $id) {
            $labelPosition = $this->_point($label);

            if (is_object($this->_dataPreProcessor)) {
                $labelText = $this->_dataPreProcessor->_process($label);
            } else {
                $labelText = $label;
            }

            if ((($this->_type == IMAGE_GRAPH_AXIS_X) && (!$this->_transpose)) ||
               (($this->_type != IMAGE_GRAPH_AXIS_X) && ($this->_transpose)))
            {
                $maxSize = max($maxSize, $this->_canvas->textHeight($labelText));
            } else {
                $maxSize = max($maxSize, $this->_canvas->textWidth($labelText));
            }
        }

        if ($this->_title) {
            $this->_canvas->setFont($this->_getTitleFont());

            if ((($this->_type == IMAGE_GRAPH_AXIS_X) && (!$this->_transpose)) ||
               (($this->_type != IMAGE_GRAPH_AXIS_X) && ($this->_transpose)))
            {
                $maxSize += $this->_canvas->textHeight($this->_title);
            } else {
                $maxSize += $this->_canvas->textWidth($this->_title);
            }
            $maxSize += 10;
        }
        return $maxSize +3;
    }

    /**
     * Apply the dataset to the axis.
     *
     * This calculates the order of the categories, which is very important
     * for fx. line plots, so that the line does not "go backwards", consider
     * these X-sets:<p>
     * 1: (1, 2, 3, 4, 5, 6)<br>
     * 2: (0, 1, 2, 3, 4, 5, 6, 7)<p>
     * If they are not ordered, but simply appended, the categories on the axis
     * would be:<p>
     * X: (1, 2, 3, 4, 5, 6, 0, 7)<p>
     * Which would render the a line for the second plot to show incorrectly.
     * Instead this algorithm, uses and 'value- is- before' method to see that
     * the 0 is before a 1 in the second set, and that it should also be before
     * a 1 in the X set. Hence:<p>
     * X: (0, 1, 2, 3, 4, 5, 6, 7)
     *
     * @param Image_Graph_Dataset $dataset The dataset
     * @access private
     */
    function _applyDataset(&$dataset)
    {
        $newLabels = array();
        $allLabels = array();

        $dataset->_reset();
        $count = 0;
        $count_new = 0;
        while ($point = $dataset->_next()) {
            if ($this->_type == IMAGE_GRAPH_AXIS_X) {
                $data = $point['X'];
            } else {
                $data = $point['Y'];
            }
            if (!isset($this->_labels[$data])) {
                $newLabels[$data] = $count_new++;
                //$this->_labels[] = $data;
            }
            $allLabels[$data] = $count++;
        }

        if (count($this->_labels) == 0) {
            $this->_labels = $newLabels;           
        } elseif ((is_array($newLabels)) && (count($newLabels) > 0)) {           
            // get all intersecting labels
            $intersect = array_intersect(array_keys($allLabels), array_keys($this->_labels));
            // traverse all new and find their relative position withing the
            // intersec, fx value X0 is before X1 in the intersection, which
            // means that X0 should be placed before X1 in the label array
            foreach($newLabels as $newLabel => $id) {
                $key = $allLabels[$newLabel];
                reset($intersect);
                $this_value = false;
                // intersect indexes are the same as in allLabels!
                $first = true;
                while ((list($id, $value) = each($intersect)) &&
                    ($this_value === false))
                {
                    if (($first) && ($id > $key)) {
                        $this_value = $value;
                    } elseif ($id >= $key) {
                        $this_value = $value;
                    }
                    $first = false;
                }

                if ($this_value === false) {
                    // the new label was not found before anything in the
                    // intersection -> append it
                    $this->_labels[$newLabel] = count($this->_labels);
                } else {
                    // the new label was found before $this_value in the
                    // intersection, insert the label before this position in
                    // the label array
//                    $key = $this->_labels[$this_value];
                    $keys = array_keys($this->_labels);
                    $key = array_search($this_value, $keys);
                    $pre = array_slice($keys, 0, $key);
                    $pre[] = $newLabel;
                    $post = array_slice($keys, $key);
                    $this->_labels = array_flip(array_merge($pre, $post));
                }
            }
            unset($keys);
        }

        $labels = array_keys($this->_labels);
        $i = 0;
        foreach ($labels as $label) {
            $this->_labels[$label] = $i++;
        }

//        $this->_labels = array_values(array_unique($this->_labels));
        $this->_calcLabelInterval();
    }

    /**
     * Return the label distance.
     *
     * @return int The distance between 2 adjacent labels
     * @access private
     */
    function _labelDistance($level = 1)
    {
        reset($this->_labels);
        list($l1) = each($this->_labels);
        list($l2) = each($this->_labels);
        return abs($this->_point($l2) - $this->_point($l1));
    }

    /**
     * Get next label point
     *
     * @param doubt $point The current point, if omitted or false, the first is
     *   returned
     * @return double The next label point
     * @access private
     */
    function _getNextLabel($currentLabel = false, $level = 1)
    {
        if ($currentLabel === false) {
            reset($this->_labels);
        }
        $result = false;
        $count = ($currentLabel === false ? $this->_labelInterval() - 1 : 0);
        while ($count < $this->_labelInterval()) {
           $result = (list($label) = each($this->_labels));
           $count++;
        }
        if ($result) {
            return $label;
        } else  {
            return false;
        }
    }

    /**
     * Is the axis numeric or not?
     *
     * @return bool True if numeric, false if not
     * @access private
     */
    function _isNumeric()
    {
        return false;
    }

    /**
     * Output the axis
     *
     * @return bool Was the output 'good' (true) or 'bad' (false).
     * @access private
     */
    function _done()
    {
        $result = true;
        if (Image_Graph_Element::_done() === false) {
            $result = false;
        }
        
        $this->_canvas->startGroup(get_class($this));
        
        $this->_drawAxisLines();
        
        $this->_canvas->startGroup(get_class($this) . '_ticks');
        $label = false;
        while (($label = $this->_getNextLabel($label)) !== false) {
            $this->_drawTick($label);
        }
        $this->_canvas->endGroup();       

        $this->_canvas->endGroup();
        
        return $result;
    }

}

?>