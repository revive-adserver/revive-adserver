<?php

include_once 'ofc_bar_base.php';

class bar_3d_value
{
	function __construct( $top )
	{
		$this->top = $top;
	}
	
	function set_colour( $colour )
	{
		$this->colour = $colour;
	}
	
	function set_tooltip( $tip )
	{
		$this->tip = $tip;
	}
}

