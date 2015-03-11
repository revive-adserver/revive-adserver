<?php

include_once 'ofc_bar_base.php';

class bar_value
{
	/**
	 * @param $top as integer. The Y value of the top of the bar
	 * @param OPTIONAL $bottom as integer. The Y value of the bottom of the bar, defaults to Y min.
	 */
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

class bar_glass extends bar_base
{
	function __construct()
	{
		$this->type      = "bar_glass";
		parent::__construct();
	}
}

class bar_cylinder extends bar_base
{
	function __construct()
	{
		$this->type      = "bar_cylinder";
		parent::__construct();
	}
}

class bar_cylinder_outline extends bar_base
{
	function __construct()
	{
		$this->type      = "bar_cylinder_outline";
		parent::__construct();
	}
}

class bar_rounded_glass extends bar_base
{
	function __construct()
	{
		$this->type      = "bar_round_glass";
		parent::__construct();
	}
}

class bar_round extends bar_base
{
	function __construct()
	{
		$this->type      = "bar_round";
		parent::__construct();
	}
}

class bar_dome extends bar_base
{
	function __construct()
	{
		$this->type      = "bar_dome";
		parent::__construct();
	}
}

class bar_round3d extends bar_base
{
	function __construct()
	{
		$this->type      = "bar_round3d";
		parent::__construct();
	}
}

class bar_3d extends bar_base
{
	function __construct()
	{
		$this->type      = "bar_3d";
		parent::__construct();
	}
}