<?php
function addIncludePath($path)
{
	$includePath = get_include_path();
	if (!strstr($includePath, $path)) {
	    set_include_path($path . PATH_SEPARATOR . $includePath);
	}
}

addIncludePath(LIB_PATH);
addIncludePath(LIB_PATH . "/doctrine");
