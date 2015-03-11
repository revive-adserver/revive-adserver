<?php

class shape_point
{
	function __construct( $x, $y )
	{
		$this->x = $x;
		$this->y = $y;
	}
}

class shape
{
	function __construct( $colour )
	{
		$this->type		= "shape";
		$this->colour	= $colour;
		$this->values	= array();
	}
	
	function append_value( $p )
	{
		$this->values[] = $p;	
	}
}