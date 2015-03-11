<?php

class line_style
{
	function __construct($on, $off)
	{
		$this->style	= "dash";
		$this->on		= $on;
		$this->off		= $off;
	}
}