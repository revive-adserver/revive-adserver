<?php

include_once 'ofc_bar_base.php';

class bar_value
{
	function __construct( $top, $bottom=null )
	{
		$this->top = $top;
		
		if( isset( $bottom ) )
			$this->bottom = $bottom;
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

class bar extends bar_base
{
	function __construct()
	{
		$this->type      = "bar";
		parent::__construct();
	}
}

