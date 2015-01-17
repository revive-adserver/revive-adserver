<?php

/**
 * Sugar: to make stars easier sometimes
 */
class s_star extends star
{
	/**
	 * I use this wrapper for default dot types,
	 * it just makes the code easier to read.
	 */
	function __construct($colour, $size)
	{
		parent::__construct();
		$this->colour($colour)->size($size);
	}
}

class s_box extends anchor
{
	/**
	 * I use this wrapper for default dot types,
	 * it just makes the code easier to read.
	 */
	function __construct($colour, $size)
	{
		parent::__construct();
		$this->colour($colour)->size($size)->rotation(45)->sides(4);
	}
}

class s_hollow_dot extends hollow_dot
{
	/**
	 * I use this wrapper for default dot types,
	 * it just makes the code easier to read.
	 */
	function __construct($colour, $size)
	{
		parent::__construct();
		$this->colour($colour)->size($size);
	}
}