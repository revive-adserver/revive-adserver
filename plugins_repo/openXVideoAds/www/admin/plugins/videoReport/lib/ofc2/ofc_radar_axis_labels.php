<?php

class radar_axis_labels
{
	// $labels : array
	function __construct( $labels )
	{
		$this->labels = $labels;
	}
	
	function set_colour( $colour )
	{
		$this->colour = $colour;
	}
}